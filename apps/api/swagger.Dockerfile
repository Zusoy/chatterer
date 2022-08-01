FROM swaggerapi/swagger-ui:v4.5.0

COPY ./doc /usr/share/nginx/html/doc

EXPOSE 8080
