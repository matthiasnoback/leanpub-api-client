SHELL=/bin/bash

export HOST_UID := $(shell id -u)
export HOST_GID := $(shell id -g)

composer.lock: composer.json
	docker/composer install --prefer-dist

.PHONY: test
test: composer.lock
	docker/php vendor/bin/phpstan analyze
	docker/php vendor/bin/phpunit -v
