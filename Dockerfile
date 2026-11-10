FROM php:8.3-apache
RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite headers \
    && printf '%s\n' '<VirtualHost *:80>' \
      '    ServerName localhost' \
      '    DocumentRoot /var/www/html/public' \
      '    <Directory /var/www/html/public>' \
      '        AllowOverride All' \
      '        Require all granted' \
      '        Options -Indexes' \
      '    </Directory>' \
      '</VirtualHost>' > /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/html
COPY . /var/www/html
