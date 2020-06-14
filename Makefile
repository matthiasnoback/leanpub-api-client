SHELL=/bin/bash

export HOST_UID := $(shell id -u)
export HOST_GID := $(shell id -g)

vendor: composer.json
	docker/composer install --prefer-dist

.PHONY: test
test: vendor
	docker/php vendor/bin/phpstan analyze
	docker/php vendor/bin/phpunit -v
