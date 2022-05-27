create:
	docker compose pull
	docker compose up -d

start: destroy
	docker compose up -d
destroy:
	docker compose down -v

build:
	docker compose build
phpunit: start
	docker compose exec -it unit vendor/bin/phpunit

mysql:
	docker compose exec -it db mysql -urpa -prpa
