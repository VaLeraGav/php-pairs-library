test:
	./vendor/bin/phpunit tests

tests --testdox:
	./vendor/bin/phpunit tests --testdox

lint:
	composer run-script phpcs tests

install:
	composer install