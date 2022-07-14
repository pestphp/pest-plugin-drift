# Variables
COMPOSER = composer
PEST_BIN = vendor/bin/pest
PSALM_BIN = vendor/bin/psalm
PHP_CS_FIXER_BIN = vendor/bin/php-cs-fixer
BOX_BIN = vendor-bin/box/vendor/bin/box

.DEFAULT_GOAL := help

#
# Commands
#

.PHONY: help
help: ## Show the help
help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

.PHONY: test
test: ## Run pest
test: $(PEST_BIN)
	@$(PEST_BIN)

.PHONY: coverage
coverage: ## Run pest with coverage
coverage: $(PEST_BIN)
	@XDEBUG_MODE=coverage $(PEST_BIN) --coverage

.PHONY: lint
lint: ## Lint source files.
lint: $(PHP_CS_FIXER_BIN)
	@$(PHP_CS_FIXER_BIN) fix --config=.php_cs.dist.php -v --dry-run

.PHONY: lint-fix
lint-fix: ## Lint and fix source files
lint-fix: $(PHP_CS_FIXER_BIN)
	@$(PHP_CS_FIXER_BIN) fix --config=.php_cs.dist.php -v

.PHONY: psalm
psalm: ## Run psalm
psalm: $(PSALM_BIN)
	$(PSALM_BIN)

.PHONY: psalm-info
psalm-info: $(PSALM_BIN)
	$(PSALM_BIN) --show-info=true

.phony: box
box: ## Run box
box: $(BOX_BIN)
	$(BOX_BIN)

pest-converter.phar: ## Build phar executable
pest-converter.phar: $(BOX_BIN) .git/HEAD vendor box.json.dist $(shell find bin/ src/ config/ -type f)
	@$(BOX_BIN) compile
	touch $@

#
# Rules
#

vendor: composer.json
	@composer install
	touch $@

$(BOX_BIN): vendor
	@composer bin box install
	touch $@

$(PEST_BIN): vendor
	touch $@

$(PSALM_BIN): vendor
	touch $@

$(PHP_CS_FIXER_BIN): vendor
	touch $@