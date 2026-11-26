#!/usr/bin/env bash
set -euo pipefail
CASE_DIR="${1:-evidence}"
if [ ! -f "$CASE_DIR/MANIFEST.sha256" ]; then
  echo "No se encontró $CASE_DIR/MANIFEST.sha256"
  exit 1
fi
cd "$CASE_DIR"
sha256sum -c MANIFEST.sha256
