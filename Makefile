all: php53 php54

php53:
	phpunit --stop-on-failure --coverage-html coverage || exit -1

php54:
	/usr/local/php-5.4/bin/php /usr/bin/phpunit --stop-on-failure || exit -1

compiler:
	phplemon lib/Haanga2/Compiler/Parser.y


autoloader:
	php ../Autoloader/autoloader.phar generate --library lib/Haanga2/autoload.php lib/ vendor
