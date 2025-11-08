.PHONY: all test rector rector-dry install update clean help

# Default target
all: test

# Install dependencies
install:
	composer install

# Update dependencies
update:
	composer update

# Run tests
test:
	vendor/bin/phpunit

# Run tests with coverage
test-coverage:
	vendor/bin/phpunit --coverage-html coverage

# Run Rector (dry-run)
rector-dry:
	vendor/bin/rector process --dry-run

# Run Rector (apply changes)
rector:
	vendor/bin/rector process

# Clean cache and generated files
clean:
	rm -rf vendor
	rm -rf .phpunit.cache
	rm -rf coverage
	rm -f composer.lock
	rm -f .phpunit.result.cache

# Validate composer.json
validate:
	composer validate --strict

# Run all checks (validate, rector dry-run, tests)
check: validate rector-dry test

# Display help
help:
	@echo "Available targets:"
	@echo "  make install        - Install dependencies"
	@echo "  make update         - Update dependencies"
	@echo "  make test           - Run tests"
	@echo "  make test-coverage  - Run tests with coverage report"
	@echo "  make rector-dry     - Run Rector in dry-run mode"
	@echo "  make rector         - Run Rector and apply changes"
	@echo "  make validate       - Validate composer.json"
	@echo "  make check          - Run all checks (validate, rector-dry, test)"
	@echo "  make clean          - Clean cache and generated files"
	@echo "  make help           - Display this help message"
