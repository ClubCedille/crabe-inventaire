from composer:1.8.5

WORKDIR /app

COPY . .

RUN composer install

CMD php -S localhost:8000 -t public

