FROM bitnami/laravel:6-debian-9

COPY . /app

EXPOSE $PORT

ENTRYPOINT [ "/app-entrypoint.sh" ]
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=$PORT" ]