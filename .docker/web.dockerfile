FROM nginx:1.13

ADD .docker/vhost.conf /etc/nginx/conf.d/default.conf
