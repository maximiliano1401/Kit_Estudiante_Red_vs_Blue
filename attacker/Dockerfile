FROM debian:12-slim
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates curl jq nmap sqlmap hydra gobuster dirb dnsutils \
    netcat-openbsd slowhttptest apache2-utils tcpdump iproute2 \
    procps python3 openssl vim-tiny \
 && rm -rf /var/lib/apt/lists/*
WORKDIR /work
CMD ["sleep", "infinity"]
