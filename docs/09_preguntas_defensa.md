# Defensa del proyecto

Duración: 25 minutos (15 de exposición, 5 de demostración y 5 de preguntas). Todos los integrantes participan.

## Preguntas de preparación

1. ¿Por qué eligieron esta segmentación y qué cambiarían con 2 GB menos de RAM?
2. ¿Qué técnica no tuvo detección y qué telemetría faltaría para cubrirla?
3. Muestren la línea exacta del log que disparó D01. ¿Cuántos falsos positivos produce?
4. ¿Cómo demuestran que el dump no fue alterado entre la adquisición y la entrega?
5. ¿Cómo calcularon MTTD y MTTR? ¿Qué eventos tomaron como inicio y fin?
6. Si el atacante hubiera usado exfiltración por DNS, ¿lo habrían detectado?
7. ¿Qué control compensatorio reduce el riesgo de DVWA sin modificar el código?
8. ¿Cuál es el riesgo residual y quién debe aceptarlo?

## Demo mínima

- Levantar el laboratorio y mostrar `docker compose ps`.
- Mostrar una detección real con la línea de log que la disparó.
- Verificar un hash y el formulario de custodia.
- Explicar una decisión de contención y su efecto secundario.
