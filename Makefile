serv:
	sudo php artisan serve --port 80 --host 0.0.0.0

make mig:
	php artisan migrate

make drop:
	echo "DROP DATABASE morpion;" | mariadb -u root -proot && make mig
