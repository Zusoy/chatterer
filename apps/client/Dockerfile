FROM node:16.13.0-alpine3.11 AS dev

ARG SRC_DIR=/usr/src/app
ARG NODE_PATH

WORKDIR ${SRC_DIR}
COPY . ${SRC_DIR}

RUN npm install
RUN npm install -g @angular/cli@latest

EXPOSE 4200

CMD ["ng", "serve", "--host", "0.0.0.0"]

FROM dev AS prod

RUN npm run build
