php_bash:
	docker-compose -f docker-compose.yml exec php-cli bash -l -c "export TERM=xterm; export COLUMNS=`tput cols`; export LINES=`tput lines`; exec bash -l"

atoum:
	docker-compose -f docker-compose.yml exec php-cli bash -c "./bin/atoum"

up:
	docker-compose -f docker-compose.yml up -d

down:
	docker-compose -f docker-compose.yml down --rmi local --volumes

restart: down up
