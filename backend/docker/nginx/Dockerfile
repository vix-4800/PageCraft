FROM nginx:latest

ARG CERTBOT_DOMAINS
ARG CERTBOT_EMAIL

RUN apt update && apt upgrade -y && \
    apt install -y certbot python3-certbot-nginx

RUN nginx -t

