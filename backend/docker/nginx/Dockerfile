FROM nginx:latest

ARG CERTBOT_DOMAINS
ARG CERTBOT_EMAIL

RUN apt update && apt upgrade -y && \
    apt install -y certbot python3-certbot-nginx

RUN certbot --nginx --non-interactive --agree-tos --email $CERTBOT_EMAIL --domains $CERTBOT_DOMAINS
RUN nginx -t
RUN certbot renew --dry-run
