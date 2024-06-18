serv:
	sudo systemctl start mysql
	npm run dev&
	sudo php artisan serve --host 0.0.0.0 --port 80&
	mailhog&

stop:
	sudo killall mailhog node php

sonar-test:
	/opt/sonar-scanner/bin/sonar-scanner \
		-Dsonar.projectKey=testestest \
  		-Dsonar.sources=. \
 		-Dsonar.host.url=http://localhost:9000 \
 		-Dsonar.token=sqp_e1b9b34a7c80a5759100a6d9a53ea7ab0973ba0b \
		-Dsonar.exclusions=vendor,node_modules,storage,_ide_helper.php,_ide_helper_models.php,app/Console/,app/Exceptions/,app/Providers/

sonar:
	docker run -d --name sonarqube -p 9000:9000 -p 9092:9092 sonarqube
