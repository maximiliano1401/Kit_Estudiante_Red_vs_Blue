#!/usr/bin/env bash
set -euo pipefail
mkdir -p docs/02_baseline
date -u > docs/02_baseline/timestamp_utc.txt
docker compose ps > docs/02_baseline/compose_ps.txt
docker stats --no-stream > docs/02_baseline/docker_stats.txt
docker compose exec -T attacker ab -n 200 -c 10 http://edge/login.php \
  > docs/02_baseline/ab_baseline.txt 2>&1 || true
echo "Línea base guardada en docs/02_baseline/"
