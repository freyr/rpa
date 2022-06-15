create:
	docker compose pull
	docker compose up -d

destroy:
	docker compose down

start:
	docker compose up -d

test: start
	docker compose run --rm php vendor/bin/phpunit

install:
	docker compose run --rm php composer install

update:
	docker compose run --rm php composer update

bash:
	docker compose run -it --rm php bash

