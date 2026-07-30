FROM php:8.2-apache

# Habilitar o mod_rewrite do Apache (necessário para alguns roteamentos, por precaução)
RUN a2enmod rewrite

# Instalar dependências do SQLite e extensão PDO SQLite
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Copiar os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Inicializar o banco de dados com o schema e rodar os seeds automaticamente
RUN sqlite3 /var/www/html/database/database.db < /var/www/html/database/schema.sql \
    && php /var/www/html/database/seed_user.php \
    && php /var/www/html/database/seed_salas.php \
    && php /var/www/html/database/seed_item.php


# Garantir que a pasta database (para o SQLite) e uploads tenham permissão de escrita pelo Apache
RUN chown -R www-data:www-data /var/www/html/database \
    && chmod -R 775 /var/www/html/database \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 775 /var/www/html/uploads

# Expor a porta 80, que o Render usará para mapear o tráfego
EXPOSE 80
