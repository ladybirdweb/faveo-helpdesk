.PHONY: ci cs-dry-run cs-fix help install test update

default: help

help:
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Available commands:"
	@echo "   ci           to run both tests suite and check style"
	@echo "   cs-dry-run   to show files that need to be fixed"
	@echo "   cs-fix       to fix files that need to be fixed"
	@echo "   help         to display this help"
	@echo "   install      to install the project dependencies"
	@echo "   test         to run the tests suite"
	@echo "   update       to update the project dependencies"

ci: test cs-dry-run

cs-dry-run:
	@if [ ! -f vendor/bin/php-cs-fixer ]; then make install; fi
	vendor/bin/php-cs-fixer fix --dry-run --diff --verbose

cs-fix:
	@if [ ! -f vendor/bin/php-cs-fixer ]; then make install; fi
	vendor/bin/php-cs-fixer fix --verbose

install:
	composer install

test:
	@if [ ! -f vendor/bin/simple-phpunit ]; then make install; fi
	SYMFONY_PHPUNIT_REMOVE_RETURN_TYPEHINT=1 vendor/bin/simple-phpunit

update:
	composer update
