FROM nginx:alpine

MAINTAINER Ivan Makarenkov <info@ivmak.com>

ADD nginx.conf /etc/nginx/
ADD symfony.conf /etc/nginx/conf.d/default.conf
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN adduser -S -G www-data www-data

CMD ["nginx"]

EXPOSE 80