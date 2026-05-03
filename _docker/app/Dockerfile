FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    sockets \
    pdo_mysql \
    bcmath \
    gd \
    zip

COPY . /app
WORKDIR /app

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=80", "--admin-port=2019", "--watch"]
