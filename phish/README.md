# Contenedor de phishing (laboratorio)

Este contenedor solo provee PHP y Apache. El equipo Red debe construir el clon del login de DVWA y el flujo de captura.

## Reglas

- Usen únicamente credenciales señuelo y datos sintéticos.
- No envíen correos a direcciones reales ni usen dominios públicos.
- El enlace debe apuntar al host del laboratorio (`http://<host>:8081/`), no a un sitio real.
- El archivo `loot/phish/creds.log` es evidencia: se copia, se hashea y se conserva.

## Flujo mínimo

1. Copien el HTML del login de DVWA en `index.php`.
2. Cambien el `action` del formulario a `/capture.php`.
3. La víctima simulada introduce credenciales señuelo.
4. Revisen `captures/creds.log`.
5. Documenten la respuesta del Blue Team.

`capture.php` ya está incluido y escribe en `captures/creds.log`, que corresponde a `loot/phish/creds.log` en el host.
