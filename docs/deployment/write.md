- sudo chmod 664 /var/www/label_trust/.env
- sudo chmod -R 775 /var/www/label_trust

- sudo chown -R www-data:www-data /var/www/label_trust
- sudo -u www-data php artisan key:generate

- sudo -u www-data php artisan passport:install
- sudo chmod -R 775 /var/www/label_trust/storage