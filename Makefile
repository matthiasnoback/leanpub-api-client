SHELL=/bin/bash

export HOST_UID := $(shell id -u)
export HOST_GID := $(shell id -g)

composer.lock: composer.json
	docker/composer install --no-progress --ansi --prefer-dist

.PHONY: test
test: composer.lock
	docker/php80 vendor/bin/phpstan analyze
	docker/php80 vendor/bin/phpunit -v --stop-on-failure
