build:
	docker-compose rm -vsf
	docker-compose down -v --remove-orphans
	docker-compose build
	docker-compose up -d

up:
	docker-compose up -d

down:
	docker-compose down

stop:
	docker-compose stop

enter:
	docker-compose exec app bash

test:
	./vendor/phpunit/phpunit/phpunit tests --colors

test-coverage:
	./vendor/phpunit/phpunit/phpunit tests --colors --coverage-html ./report
