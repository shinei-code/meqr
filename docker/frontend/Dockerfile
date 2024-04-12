FROM node:16-buster-slim
RUN apt-get update && \
    yarn global add @vue/cli nuxt create-nuxt-app
WORKDIR /src

ENV HOST=0.0.0.0
