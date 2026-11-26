# Charter y autorización del proyecto

## 1. Datos del equipo

- Materia: Ciberdefensa y Ciberataques
- Cuatrimestre / grupo: 1er cuatrimestre
- Integrantes y roles: Mauricio Pinzón (Red Team Lead / OPS); Max (Blue Team Lead / IC); Manuel David Castro Blanco (Forense y Custodia / Coordinador)
- Fecha: 25 de noviembre de 2026
- Docente: Dcte. Mario Alonso Segovia Gutiérrez

## 2. Alcance

- Redes y servicios incluidos: red interna labnet de Docker Compose; servicios edge (Nginx), web (DVWA), db (MariaDB), logs (Vector), attacker y phish. Escenarios A (SQLi), B (phishing) y C (DoS capa 7).
- Hosts y contenedores: anfitrión único (MacBook Apple Silicon M4) con Docker Desktop; los seis contenedores del laboratorio. Publicación solo en 127.0.0.1 y en la IP privada de la red Tailscale del anfitrión.
- Ventanas autorizadas: sesiones acordadas por el equipo el 25 de noviembre de 2026, con el docente informado.
- Fuera de alcance: el equipo anfitrión, la red de la universidad, Internet y cualquier servicio real. No se usan datos, credenciales ni dominios reales. No se exponen puertos a Internet ni se usa Tailscale Funnel.

## 3. Objetivos y criterios de éxito

- Escenario A: explotar la inyección SQL de DVWA y exfiltrar la tabla users. Éxito: dump obtenido fuera del segmento internal, con evidencia y detección.
- Escenario B: robar credenciales con un clon de login. Éxito: credenciales capturadas, acceso con la cuenta y respuesta documentada.
- Escenario C: degradar la disponibilidad con un ataque de capa 7. Éxito: disponibilidad medida, mitigación aplicada y recuperación verificada.

## 4. Roles y RACI

| Actividad | Red | Blue | Forensic | Coordinator |
|---|---|---|---|---|
| Autorización y alcance | C | C | C | A/R |
| Despliegue | R | C | I | A |
| Ataque | R | I | C | A |
| Detección y respuesta | I | R | C | A |
| Evidencia y custodia | C | C | R | A |
| Informe y exposición | C | C | C | A/R |

Controles cruzados: Red no valida su propio alcance; Blue no manipula la evidencia original; Forense tiene veto sobre cualquier acción que la altere; quien ejecuta comandos no firma los hashes.

## 5. Reglas de enfrentamiento

- Solo laboratorio autorizado y datos sintéticos.
- DoS: 60 s, 50 conexiones, 2 000 solicitudes.
- Prohibido: malware, kernel exploits, persistencia fuera del contenedor, datos reales, ataques a Internet.
- Criterios de aborto: host > 80 % CPU/RAM, pérdida de acceso, tráfico externo, sospecha de escape.
- Adquirir la evidencia antes de contener; no reiniciar contenedores sospechosos ni ejecutar docker compose down -v.
- Acceso remoto solo por la red privada (Tailscale), ACL limitada a 8080, 8081 y 443.

## 6. Autorización

Nombre y firma del coordinador: Manuel David Castro Blanco  (firmado)  Fecha: 25/11/2026

Nombre y firma del docente: Dcte. Mario Alonso Segovia Gutiérrez  (autorizado)  Fecha: 25/11/2026
