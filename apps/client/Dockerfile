FROM node:19-alpine3.16 AS dev

ARG SRC_DIR=/usr/src/app
ARG NODE_PATH

WORKDIR ${SRC_DIR}
COPY . ${SRC_DIR}

RUN npm install -g npm@9.6.1
RUN yarn install

CMD ["yarn", "start"]

##########################################

FROM dev AS prod

RUN yarn run build
