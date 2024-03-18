FROM node:20-alpine3.16 AS dev

ARG SRC_DIR=/usr/src/app
ARG NODE_PATH

WORKDIR ${SRC_DIR}
COPY . ${SRC_DIR}

RUN npm install -g npm@9.6.7
RUN npm install

CMD ["npm", "run", "dev"]

#########################################

FROM dev as prod

RUN yarn run build
