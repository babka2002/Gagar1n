#!/usr/bin/env bash
set -e

php please stache:clear
php please cache:clear
php please static:clear

php artisan view:clear
php artisan cache:clear
php artisan config:clear

# перезапускаем FPM (нужен sudo, либо запустите скрипт от root)
systemctl restart php8.3-fpm
