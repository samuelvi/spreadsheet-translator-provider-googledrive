.PHONY: all test rector

all: test

test:
	vendor/bin/phpunit

rector:
	vendor/bin/rector process
