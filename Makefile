cc:
	php bin/console cache:clear

vendor:composer.json
	composer install

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


install:
	composer install


exec:  ## Acceder au container php
	docker exec -it FoodTrucksApp-php-fpm bash


mariadb: ## Acceder au container mysql
	docker exec -it FoodTrucksApp-mariadb mysql -uroot -proot

db: ## lister les base de donnée mysql this cmd shold be executed outside the container
	docker exec -it FoodTrucksApp-mariadb mysql -uroot -proot -e "show databases;"

test:  ## Lance les tests unitaire
#	php ./vendor/bin/phpunit --stop-on-failure
	bin/phpunit


reload:  ## Lance les tests unitaire
	bin/console doctrine:schema:drop --force \
	&& bin/console doctrine:schema:update --force \
	&& bin/console doctrine:fixtures:load -n



fixer: ## Lance l'annalys de code PhpStan
	vendor/bin/phpstan analyse --level 8 src
	#vendor/bin/phpstan analyse -c phpstan.neon