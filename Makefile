test:
	vendor/bin/phpunit

coverage:
	vendor/bin/phpunit --coverage-text

phpstan:
	vendor/bin/phpstan