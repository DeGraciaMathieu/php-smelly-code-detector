test:
	vendor/bin/phpunit

cov:
	vendor/bin/phpunit --coverage-text

phpstan:
	vendor/bin/phpstan