ssh:
	docker exec -it opengraph_app sh

build:
	docker compose up --build -d

stop:
	docker compose stop

down:
	docker compose down

cs-fix:
	docker exec -e PHP_CS_FIXER_IGNORE_ENV=1 opengraph_app ./vendor/bin/php-cs-fixer fix

phpstan:
	docker exec opengraph_app ./vendor/bin/phpstan --memory-limit=256M

test:
	docker exec -e XDEBUG_MODE=off opengraph_app ./vendor/bin/phpunit --testsuite=unit --coverage-text

code-coverage:
	docker exec -e XDEBUG_MODE=coverage opengraph_app ./vendor/bin/phpunit --coverage-html ./var/coverage

deps:
	docker exec opengraph_app composer install
