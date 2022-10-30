test:
	./vendor/bin/phpunit tests

test-dox:
	./vendor/bin/phpunit tests --testdox

lint:
	composer run-script phpcs tests

install:
	composer install