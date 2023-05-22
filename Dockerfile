FROM php:8.1-fpm-alpine

RUN apk add --no-cache nginx supervisor wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

# ENV PORT 8080
# ENV HOST 0.0.0.0
# EXPOSE 8080

RUN mkdir -p /app
COPY . /app

RUN sh -c "wget https://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

# Look at this for installing node js and npm : https://stackoverflow.com/questions/55258124/docker-npm-not-found

RUN apk add --no-cache nodejs npm
RUN cd /app && \
    npm install

CMD sh /app/docker/startup.sh