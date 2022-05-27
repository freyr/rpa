create:
	docker compose pull
	docker compose up -d

start:
	docker compose up -d
destroy:
	docker compose down

phpunit: start
	docker compose exec -it unit vendor/bin/phpunit

composer:
	docker compose run build
