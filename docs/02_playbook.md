# Playbooks de respuesta a incidentes

Tres playbooks, uno por escenario. Fases alineadas a NIST SP 800-61r3.
Roles: IC = Max (Blue) decide; OPS = Mauricio (Red) ejecuta bajo el IC; EVI = David (Forense); COM = David (Coordinador).

---

# Playbook A — Inyección SQL y exfiltración

- Versión: 1.0
- Fecha UTC: 2026-11-25
- Dueño: Max (Blue Team Lead)
- Escenario: A
- ATT&CK: T1595, T1190, T1213, T1041
- Severidad: Alta (exfiltración de credenciales)

## 1. Preparación
Laboratorio desplegado y línea base validada (EV-BASE-001). Respaldo de la base hasheado antes de atacar. Accesos por SSH/Tailscale. Criterio de activación: patrones de inyección en el log del borde.

## 2. Detección y análisis
Fuente: logs de Nginx (borde) y MariaDB. Consulta: patrones union select, information_schema, sleep( en la URI con respuesta 200 (regla D01/D02). Umbral: 1 o más coincidencias. Triage: IP de origen, tablas afectadas, volumen extraído. Evidencia a preservar: log del borde, salida y dump de sqlmap, estado del contenedor web.

## 3. Contención
Acción: bloquear la IP del atacante (172.21.0.2) en Nginx (deny) y recargar. Responsable: OPS bajo orden del IC. Efecto esperado: el atacante recibe 403. Efecto secundario: ninguno para el usuario legítimo (otra IP). Tiempo objetivo: < 10 min desde la alerta.

## 4. Erradicación
Causa raíz: parámetro id inyectable en DVWA (vulnerable por diseño). Control compensatorio: bloqueo de IP y regla de patrón en el borde. Limpieza: rotación de todas las credenciales (hashes MD5 expuestos). Validación: la credencial robada ya no autentica.

## 5. Recuperación
Restauración: no se requiere restaurar datos (ataque de lectura); se verifica la integridad del respaldo contra EV-BASE-001. Verificación: login válido con la credencial nueva. Monitoreo reforzado: regla D01/D02 activa. Criterio de cierre: servicio operativo y credenciales rotadas.

## 6. Comunicación
A quién: docente y "víctima simulada". Cuándo: al confirmar la exfiltración. Qué no se divulga: contenido crudo de los hashes fuera del expediente.

## 7. Evidencia y custodia
Evidence IDs: EV-A-20261125-001 a 006, EV-BASE-001. Ubicación: evidence/. Hash: SHA-256 en EV-A_custodia.sha256. Custodio: David (Forense).

## 8. Post-incidente
Lecciones: adquirir evidencia antes de contener. Regla ajustada: D01/D02 afinada. Retest: repetir sqlmap tras el bloqueo (debe dar 403). Riesgo residual: otros módulos de DVWA siguen vulnerables.

## Lo que NO se debe hacer
No apagar el contenedor web, no ejecutar docker compose down -v, no editar los logs, no bloquear al administrador legítimo.

## Simulacro (de escritorio / controlado)
Ejecutado el 2026-11-25. MTTD y MTTR registrados en UTC en la bitácora (tabla de métricas). Hueco detectado: la rotación de credenciales no invalida una sesión activa; se añadió el borrado de sesiones como paso.

---

# Playbook B — Phishing de credenciales

- Versión: 1.0
- Fecha UTC: 2026-11-25
- Dueño: Max (Blue Team Lead)
- Escenario: B
- ATT&CK: T1566.002, T1056.003, T1078
- Severidad: Alta (compromiso de cuenta)

## 1. Preparación
Contenedor phish disponible; capture.php listo. Criterio de activación: peticiones a /capture.php o con Referer del clon.

## 2. Detección y análisis
Fuente: logs de Apache (phish) y Nginx. Consulta: POST a /capture.php o Referer del dominio del clon (:8081), regla D04. Umbral: 1 evento. Triage: cuenta afectada, hora, origen. Evidencia a preservar: creds.log, logs del phish, el clon index.php, los correos cebo.

## 3. Contención
Acción: rotar la contraseña de la cuenta comprometida e invalidar sesiones. Responsable: OPS bajo el IC. Efecto esperado: la credencial robada deja de servir. Efecto secundario: la cuenta debe volver a iniciar sesión. Tiempo objetivo: < 10 min.

## 4. Erradicación
Causa raíz: usuario engañado por un clon de login. Control compensatorio: bloquear la URL del clon y dejar el contenedor phish fuera de línea. Limpieza: borrado de sesiones PHP activas. Validación: el clon ya no responde.

## 5. Recuperación
Restauración: restablecer la contraseña del usuario. Verificación: acceso legítimo correcto. Monitoreo reforzado: regla D04 activa. Criterio de cierre: clon fuera de línea y credencial rotada.

## 6. Comunicación
A quién: la víctima (fuera de banda) y el docente. Qué no se divulga: la contraseña capturada en claro fuera del expediente.

## 7. Evidencia y custodia
Evidence IDs: EV-B-20261125-001 a 006. Ubicación: evidence/. Hash: SHA-256 en EV-B_custodia.sha256. Custodio: David (Forense).

## 8. Post-incidente
Lecciones: la detección fiable es el POST a /capture.php y el Referer, no la IP (NAT de Docker). Retest: reenviar el formulario del clon (debe no responder). Riesgo residual: el phishing depende del factor humano.

## Lo que NO se debe hacer
No apagar el contenedor phish antes de preservar la evidencia; no borrar creds.log; no bloquear al administrador.

## Simulacro (de escritorio / controlado)
Ejecutado el 2026-11-25. La víctima simulada tecleó credenciales señuelo con consentimiento. MTTD/MTTR en la bitácora.

---

# Playbook C — Denegación de servicio de capa 7

- Versión: 1.0
- Fecha UTC: 2026-11-25
- Dueño: Max (Blue Team Lead)
- Escenario: C
- ATT&CK: T1499.002, T1499.003
- Severidad: Media (disponibilidad)

## 1. Preparación
Línea base de disponibilidad medida (1418 r/s, 0 fallos). Reglas limit_req/limit_conn preparadas en la config de Nginx. Criterio de activación: pico de peticiones por IP o caída de disponibilidad.

## 2. Detección y análisis
Fuente: logs de Nginx y docker stats. Consulta: tasa de peticiones por IP sobre el umbral o pico de 499/502/503 (D06); conexiones lentas con request_time alto (D05). Umbral: > 10 r/s por IP; > 20 conexiones lentas. Triage: origen, RPS, errores, CPU/RAM. Evidencia a preservar: salida de ab y slowhttptest, config antes/después, docker stats.

## 3. Contención
Acción: activar limit_req (10 r/s, burst 20) y limit_conn (20 por IP) en el borde y recargar. Responsable: OPS bajo el IC. Efecto esperado: el atacante recibe 503; el legítimo sigue en 200. Efecto secundario: picos legítimos muy altos podrían limitarse. Tiempo objetivo: < 10 min.

## 4. Erradicación
Causa raíz: ausencia de límite de tasa por IP en el borde. Control compensatorio: limit_req/limit_conn. Limpieza: retirar bloqueos temporales. Validación: ab repetido muestra 1974/2000 rechazos (503).

## 5. Recuperación
Restauración: servicio ya disponible (no cayó). Verificación: disponibilidad >= 95 % con el loop de curl. Monitoreo reforzado: reglas D05/D06. Criterio de cierre: mitigación activa y disponibilidad confirmada.

## 6. Comunicación
A quién: docente. Qué no se divulga: nada sensible (datos sintéticos).

## 7. Evidencia y custodia
Evidence IDs: EV-C-20261125-001 a 004. Ubicación: evidence/. Hash: SHA-256 en EV-C_custodia.sha256. Custodio: David (Forense).

## 8. Post-incidente
Lecciones: la línea base (timeouts y límites de memoria) absorbió el slowloris. Retest: repetir ab con la mitigación activa. Riesgo residual: un DoS distribuido desde muchas IP no se frena con un límite por IP.

## Lo que NO se debe hacer
No reiniciar los contenedores durante el ataque; no ejecutar docker compose down -v; no editar los logs.

## Simulacro (de escritorio / controlado)
Ejecutado el 2026-11-25. Hallazgo: el ataque no tumbó el servicio; el contraste medible está del lado del atacante (503). MTTD/MTTR en la bitácora.
