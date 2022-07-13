.DEFAULT_GOAL := help
.PHONY: $(filter-out vendor node_modules,$(MAKECMDGOALS))

help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

vendor: composer.json $(wildcard composer.lock) ## Install PHP dependencies
	@composer install

test: vendor ## Run tests
	@vendor/bin/pest

test-coverage: vendor ## Run test with coverage
	@XDEBUG_MODE=coverage vendor/bin/pest --coverage

lint: vendor ## Lint source files.
	@vendor/bin/php-cs-fixer fix --config=.php_cs.dist.php -v --dry-run

lint-fix: vendor ## Lint and fix source files
	@vendor/bin/php-cs-fixer fix --config=.php_cs.dist.php -v

psalm: vendor ## Run psalm
	@vendor/bin/psalm

psalm-info: vendor
	@vendor/bin/psalm --show-info=true