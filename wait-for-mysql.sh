#!/bin/bash
set -e

until mariadb-admin ping -h mysql -P 3306 --silent; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing command"

php artisan migrate
