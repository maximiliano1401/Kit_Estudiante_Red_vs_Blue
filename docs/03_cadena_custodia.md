# Cadena de custodia

Un formulario por evidencia. El `evidence_id` coincide con la linea de tiempo y el informe. Los hashes SHA-256 fueron generados con `shasum -a 256` y se consolidan en `MANIFEST.sha256` del ZIP de evidencia.

Custodio responsable: Manuel David Castro Blanco (Forense). Herramienta de hash: shasum -a 256.

---

## EV-BASE-001

- Caso / escenario: Base / respaldo de referencia
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-BASE-001
- Fecha y hora UTC: 2026-11-25T14:40:00Z
- Host / contenedor: rb-db
- Ruta o fuente original: dvwa_base.sql
- Tipo: dump
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: mariadb-dump (MariaDB 10.11)
- Tamano (bytes): 5699
- Hash SHA-256: 11049221a723bd7185b53a6f2716bd2efc3daee115f05c8d1f553a756065099b
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Respaldo de la base dvwa antes de atacar; referencia para validar la recuperacion.

---

## EV-A-20261125-001

- Caso / escenario: A - SQLi
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-A-20261125-001
- Fecha y hora UTC: 2026-11-25T15:44:00Z
- Host / contenedor: rb-web
- Ruta o fuente original: EV-A-20261125-001_top.txt
- Tipo: estado
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: docker top
- Tamano (bytes): 1915
- Hash SHA-256: ca3aec18f1883541585d51bd74d5062641aaff81f90a4179341a9064e77ee94c
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Procesos del contenedor web al momento del incidente.

---

## EV-A-20261125-002

- Caso / escenario: A - SQLi
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-A-20261125-002
- Fecha y hora UTC: 2026-11-25T15:44:00Z
- Host / contenedor: rb-web
- Ruta o fuente original: EV-A-20261125-002_inspect.json
- Tipo: estado
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: docker inspect
- Tamano (bytes): 11449
- Hash SHA-256: e6439fcdb4758576cdd9765f4beb834df9dfa7a8af8dc1123affc881a7c720c6
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Configuracion y estado del contenedor web.

---

## EV-A-20261125-003

- Caso / escenario: A - SQLi
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-A-20261125-003
- Fecha y hora UTC: 2026-11-25T15:44:00Z
- Host / contenedor: rb-web
- Ruta o fuente original: EV-A-20261125-003_diff.txt
- Tipo: estado
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: docker diff
- Tamano (bytes): 7984
- Hash SHA-256: 20d172398a056d7403a9d2e70901b64b5909c107c1dcd45362d230669cde5e23
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Cambios en el sistema de archivos del contenedor web.

---

## EV-A-20261125-004

- Caso / escenario: A - SQLi
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-A-20261125-004
- Fecha y hora UTC: 2026-11-25T15:44:00Z
- Host / contenedor: rb-web
- Ruta o fuente original: EV-A-20261125-004_web.log
- Tipo: log
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: docker logs
- Tamano (bytes): 551
- Hash SHA-256: 7c6d8ae99efd2e78ac0205acc022820b9fd8ec4cca5d42f24e924ff7a37cd277
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Registro del contenedor web durante el ataque.

---

## EV-A-20261125-005

- Caso / escenario: A - SQLi
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-A-20261125-005
- Fecha y hora UTC: 2026-11-25T15:44:00Z
- Host / contenedor: rb-edge
- Ruta o fuente original: EV-A-20261125-005_edge_access.log
- Tipo: log
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: copia del access.log de Nginx
- Tamano (bytes): 1403083
- Hash SHA-256: 1b124df6d29cd382b712480e169159dd1936ce35482e0eee2ed6ad31897c882c
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Peticiones de sqlmap con payloads de inyeccion.

---

## EV-A-20261125-006

- Caso / escenario: A - SQLi
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-A-20261125-006
- Fecha y hora UTC: 2026-11-25T15:34:00Z
- Host / contenedor: rb-web / rb-db
- Ruta o fuente original: EV-A-20261125-006_users_dump.csv
- Tipo: dump
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: sqlmap 1.7.2
- Tamano (bytes): 689
- Hash SHA-256: e11d8cb2d10b0dd6b38cb25abea363e559a2d7cf8b0ad00192e453de10281ebd
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Tabla users exfiltrada con hashes MD5.

---

## EV-B-20261125-001

- Caso / escenario: B - Phishing
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-B-20261125-001
- Fecha y hora UTC: 2026-11-25T18:44:50Z
- Host / contenedor: rb-phish
- Ruta o fuente original: EV-B-20261125-001_creds.log
- Tipo: archivo
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: capture.php
- Tamano (bytes): 72
- Hash SHA-256: 0fbec57fcd5c263ce45e4005d910972b41e7fb0f59d2b14ec92571b2a21b9315
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Credencial capturada por el clon de login.

---

## EV-B-20261125-002

- Caso / escenario: B - Phishing
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-B-20261125-002
- Fecha y hora UTC: 2026-11-25T18:52:00Z
- Host / contenedor: rb-phish
- Ruta o fuente original: EV-B-20261125-002_phish_access.log
- Tipo: log
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: copia del access.log de Apache
- Tamano (bytes): 1568
- Hash SHA-256: fd9c2fccbe12ac96c02ba7be8d3d91c1967ada191334013db976696b01222ec4
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: POST a /capture.php y acceso con la cuenta.

---

## EV-B-20261125-003

- Caso / escenario: B - Phishing
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-B-20261125-003
- Fecha y hora UTC: 2026-11-25T18:52:00Z
- Host / contenedor: rb-edge
- Ruta o fuente original: EV-B-20261125-003_edge_access.log
- Tipo: log
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: copia del access.log de Nginx
- Tamano (bytes): 1434105
- Hash SHA-256: 213ef75beb411d13b41f6af3a09526c6af8dc1b818e8848a82d4d2d2e76def78
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Trafico del borde durante el phishing.

---

## EV-B-20261125-004

- Caso / escenario: B - Phishing
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-B-20261125-004
- Fecha y hora UTC: 2026-11-25T18:52:00Z
- Host / contenedor: rb-phish
- Ruta o fuente original: EV-B-20261125-004_clon_index.php
- Tipo: archivo
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: copia del clon
- Tamano (bytes): 1410
- Hash SHA-256: 7f6f2ed335fc9398d88192cd05da332d1865133631fc114c51e9b92dfa864565
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Pagina falsa que suplanta el login de DVWA.

---

## EV-B-20261125-005

- Caso / escenario: B - Phishing
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-B-20261125-005
- Fecha y hora UTC: 2026-11-25T18:40:00Z
- Host / contenedor: host
- Ruta o fuente original: EV-B-20261125-005_correo1.eml
- Tipo: archivo
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: redaccion del equipo
- Tamano (bytes): 264
- Hash SHA-256: 1f2d7eca7952484f337e3dc4e71e7a25098b8861c561975a4c9c6cec3c37138b
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Primer correo cebo entregado a la victima simulada.

---

## EV-B-20261125-006

- Caso / escenario: B - Phishing
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-B-20261125-006
- Fecha y hora UTC: 2026-11-25T18:40:00Z
- Host / contenedor: host
- Ruta o fuente original: EV-B-20261125-006_correo2.eml
- Tipo: archivo
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: redaccion del equipo
- Tamano (bytes): 210
- Hash SHA-256: a2a1df5f77bb512e97944182f2f138a4288d4dd884153f40b9a096983405341b
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Segundo correo cebo entregado a la victima simulada.

---

## EV-C-20261125-001

- Caso / escenario: C - DoS
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-C-20261125-001
- Fecha y hora UTC: 2026-11-25T19:10:00Z
- Host / contenedor: rb-attacker
- Ruta o fuente original: EV-C-20261125-001_slowhttptest.csv
- Tipo: log
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: slowhttptest 1.8.2
- Tamano (bytes): 847
- Hash SHA-256: 5f60193c610ee80420795c786c138ecbae9d318df5770f5d33d45a4536a6391c
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Reporte del ataque lento; disponibilidad 50/50.

---

## EV-C-20261125-002

- Caso / escenario: C - DoS
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-C-20261125-002
- Fecha y hora UTC: 2026-11-25T19:14:00Z
- Host / contenedor: rb-edge
- Ruta o fuente original: EV-C-20261125-002_nginx_mitigado.conf
- Tipo: archivo
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: copia de la config
- Tamano (bytes): 1115
- Hash SHA-256: c9b658ee2ce96dfce53cd91cbe1e2639512a4df54290b3859e982e86132b0553
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Config de Nginx con limit_req/limit_conn activos.

---

## EV-C-20261125-003

- Caso / escenario: C - DoS
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-C-20261125-003
- Fecha y hora UTC: 2026-11-25T19:18:00Z
- Host / contenedor: rb-edge
- Ruta o fuente original: EV-C-20261125-003_edge_access.log
- Tipo: log
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: copia del access.log de Nginx
- Tamano (bytes): 1946117
- Hash SHA-256: 2f20137ecb2db40fa03a4cbaf888fc2b1bd9cfef069e296df2ddbd87a77975a5
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Trafico de la inundacion y respuestas 503.

---

## EV-C-20261125-004

- Caso / escenario: C - DoS
- Expediente: Proyecto Final Red vs Blue
- Evidence ID: EV-C-20261125-004
- Fecha y hora UTC: 2026-11-25T19:12:00Z
- Host / contenedor: host
- Ruta o fuente original: EV-C-20261125-004_docker_stats.txt
- Tipo: estado
- Metodo: adquisicion sobre copia, sin alterar el original
- Herramienta y version: docker stats
- Tamano (bytes): 648
- Hash SHA-256: 32e0e5b3b0dd43c528170cca5e679f65938f4cb767eee3585ff956e3ab25eafc
- Recolecto (nombre, rol, firma): Manuel David Castro Blanco, Forense (firmado)
- Observaciones: Consumo de recursos durante el ataque (CPU casi en 0%).

---

## Registro de transferencias

| Fecha/hora UTC | Entrega | Recibe | Motivo | Hash verificado |
|---|---|---|---|---|
| 2026-11-25T20:00:00Z | David (Forense) | Equipo (repositorio) | Integracion al expediente | si |
| 2026-11-26T15:00:00Z | David (Forense) | Docente | Entrega final | si |

## Declaracion de integridad

El custodio declara que la evidencia fue identificada, recolectada, adquirida y preservada conforme al procedimiento; que trabajo sobre copias y que el hash registrado corresponde al estado inicial. Cualquier cambio posterior se documenta en una nueva fila.

Firma del custodio: Manuel David Castro Blanco (firmado)  Fecha: 26/11/2026

Reviso (docente o coordinador): Dcte. Mario Alonso Segovia Gutierrez  Fecha: 26/11/2026
