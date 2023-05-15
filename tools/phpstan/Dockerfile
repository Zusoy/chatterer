FROM composer:2.5.5 AS composer

#####################################

FROM php:8.1-fpm-alpine3.15

RUN apk add --no-cache \
  git==2.34.8-r0

ENV PATH="/phpstan/vendor/bin:${PATH}"

WORKDIR /phpstan

COPY composer.* ./

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer install

WORKDIR /usr/src/app

ENTRYPOINT ["phpstan"]

CMD ["analyse"]
