ARG IMAGE_TAG=develop

FROM nginx:1.21.1-alpine as dev

COPY nginx.conf /etc/nginx/nginx.conf

FROM zusoy/chatterer-client:${IMAGE_TAG} as client
FROM dev as prod
COPY --from=client /usr/src/app/build /usr/src/app
