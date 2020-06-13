SHELL=/bin/bash

export HOST_UID := $(shell id -u)
export HOST_GID := $(shell id -g)

vendor: composer.json
	bin/composer install --prefer-dist

.PHONY: test
test:
	bin/php vendor/bin/phpstan analyze
	bin/php vendor/bin/phpunit -v
