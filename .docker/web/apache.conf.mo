<VirtualHost *:80>
    ServerAdmin webmaster@{{DOCKER_DEVBOX_DOMAIN_PREFIX}}.{{DOCKER_DEVBOX_DOMAIN}}
    ServerName api.{{DOCKER_DEVBOX_DOMAIN_PREFIX}}.{{DOCKER_DEVBOX_DOMAIN}}
    ServerAlias api.pgsql.{{DOCKER_DEVBOX_DOMAIN_PREFIX}}.{{DOCKER_DEVBOX_DOMAIN}} api.mysql.{{DOCKER_DEVBOX_DOMAIN_PREFIX}}.{{DOCKER_DEVBOX_DOMAIN}}

    <Directory />
        AllowOverride None
        Require all denied
    </Directory>

    DocumentRoot "/var/www/html/api/public"
    <Directory "/var/www/html/api/public">
        DirectoryIndex index.html index.php
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:fcgi://php.{{COMPOSE_NETWORK_NAME}}:9000"
    </FilesMatch>
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin webmaster@{{DOCKER_DEVBOX_DOMAIN_PREFIX}}.{{DOCKER_DEVBOX_DOMAIN}}
    ServerName admin.{{DOCKER_DEVBOX_DOMAIN_PREFIX}}.{{DOCKER_DEVBOX_DOMAIN}}

    <Directory />
        AllowOverride None
        Require all denied
    </Directory>

    DocumentRoot "/var/www/html/app/dist"
    <Directory "/var/www/html/app/dist">
        DirectoryIndex index.html

        AllowOverride All
        Order allow,deny
        Allow from all
        Require all granted

        Options +FollowSymLinks
        RewriteEngine On
        RewriteBase /
        RewriteRule ^index\.html$ - [L]
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . /index.html [L]
    </Directory>
</VirtualHost>

