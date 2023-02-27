FROM composer:2.3.10 AS composer

FROM php:8.1-fpm-alpine3.15 as base

ENV PATH ./vendor/bin:./bin:$PATH
ENV APP_ENV dev

RUN mkdir -p /usr/src/app && \
  addgroup docker && \
  adduser -S -h /home/docker -u 1000 -G docker docker && \
  chown -R docker /home/docker /usr/src/app && \
  apk add --no-cache --virtual=.build-deps \
  autoconf==2.71-r0 \
  g++==10.3.1_git20211027-r0 \
  make==4.3-r0 \
  pcre-dev==8.45-r1 \
  && \
  docker-php-ext-install -j"$(nproc)" pdo_mysql fileinfo && \
  pecl install apcu-5.1.21 redis && \
  docker-php-ext-enable apcu redis.so && \
  apk del .build-deps

WORKDIR /usr/src/app

COPY --chown=docker composer.* /usr/src/app/

COPY --from=composer /usr/bin/composer /usr/bin/composer

USER docker

FROM base as dev

RUN composer install --no-scripts --prefer-dist --no-interaction

FROM base as ci

COPY --chown=docker . /usr/src/app

RUN composer install --no-scripts --prefer-dist --no-interaction

FROM base as prod

ENV APP_ENV prod

COPY --chown=docker . /usr/src/app

RUN composer install --no-scripts --no-dev --no-interaction && \
  composer dump-autoload -o --no-dev
