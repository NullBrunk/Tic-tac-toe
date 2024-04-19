.DEFAULT_GOAL = help

serv: ## Start the DB and launch the HTTP server
	@mailhog&
	@sudo systemctl start mariadb
	@sudo php artisan serve --port 80 --host 0.0.0.0

mig: ## Make the migration
	@php artisan migrate

drop: ## Drop the database and make the migration
	echo "DROP DATABASE morpion;" | mariadb -u root -proot && make mig

help: 
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
