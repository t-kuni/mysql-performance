FROM nginx:1.20.0-alpine

# Add user
ARG APP_UID
ARG APP_GID
ENV APP_UID ${APP_UID}
ENV APP_GID ${APP_GID}
RUN adduser -u $APP_UID -g $APP_GID --disabled-password --gecos "" -s /sbin/nologin app

RUN mkdir -p /var/www/app/storage/app/public \
    && mkdir -p /var/www/app/public/storage
RUN ln -s /var/www/app/storage/app/public /var/www/app/public/storage

# Copy configs
COPY site.conf /etc/nginx/conf.d/site.conf
COPY nginx.conf /etc/nginx/nginx.conf

CMD exec nginx -g 'daemon off;'