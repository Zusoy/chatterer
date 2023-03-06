FROM node:18.14.2-alpine AS dev

ARG SRC_DIR=/usr/src/app
ARG NODE_PATH
ARG REACT_APP_API_URL

WORKDIR ${SRC_DIR}
RUN chown 1000:1000 ${SRC_DIR}

COPY . ${SRC_DIR}

USER docker

USER 1000

RUN yarn install

#######################################################

FROM dev AS prod

RUN yarn run build
