FROM node:lts-alpine3.12 as node
FROM nginx:1.18-alpine
SHELL ["/bin/ash", "-oeux", "pipefail", "-c"]

#ENV TZ=${TZ}

RUN apk update && \
  apk add --update --no-cache --virtual=.build-dependencies g++

# node command
COPY --from=node /usr/local/bin /usr/local/bin
# npm command
COPY --from=node /usr/local/lib /usr/local/lib
# yarn command
COPY --from=node /opt /opt

# nginx config file
COPY ./default.conf /etc/nginx/conf.d/default.conf
# SSL
# COPY ./*.pem /etc/nginx/conf.d/

WORKDIR /var/web/html