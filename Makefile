-include .env

STAGE ?= dev
CI ?= 0

####################
# STACK MANAGEMENT #
####################

.PHONY: build
build:
	docker-compose build

.PHONY: start
start:
	docker-compose up -d --remove-orphans

.PHONY: stop
stop:
	docker-compose stop

.PHONY: kill
kill:
	docker-compose down

#######
# API #
#######

.PHONY: api-acceptance
api-acceptance:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" vendor/bin/behat

.PHONY: api-integrations
api-integrations:
	@docker-compose run --rm --no-deps api kahlan

.PHONY: api-shell
api-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" sh

.PHONY: api-specs
api-specs:
	@docker-compose run --rm --no-deps api phpspec run -f pretty -vn --no-code-generation

.PHONY: api-setup-db-test
api-setup-db-test:
	@docker-compose run --rm --no-deps api console doctrine:database:create --env=test --if-not-exists
	@docker-compose run --rm --no-deps api console doctrine:migrations:migrate -n --env=test

.PHONY: api-fixtures
api-fixtures:
	@docker-compose run --rm --no-deps api console app:data:fixtures -p

.PHONY: api-vendor
api-vendor:
	@docker-compose run --rm --no-deps api composer install

##########
# CLIENT #
##########

.PHONY: client-shell
client-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_client)" sh

.PHONY: client-install
client-install:
	@docker-compose run --rm --no-deps client yarn install

.PHONY: client-build
client-build:
	@docker-compose run --rm --no-deps client yarn build --if-present

.PHONY: client-test
client-test:
	@docker-compose run --rm --no-deps client yarn test --verbose

############
# DATABASE #
############

.PHONY: database-connect
database-connect:
	@docker-compose run --rm database mysql -u ${MYSQL_USER} -p

#########
# TOOLS #
#########

.PHONY: phpstan
phpstan:
	docker-compose -f docker-compose.tools.yaml build phpstan > /dev/null
	docker-compose -f docker-compose.tools.yaml run --rm --user=$$(id -u) -w /code --entrypoint=sh phpstan -c "composer install $(COMPOSER_OPTIONS)"
ifeq ($(CI),1)
	docker-compose -f docker-compose.tools.yaml run --rm --user=$$(id -u) -w /code --entrypoint=sh phpstan -c "phpstan analyse --memory-limit=-1 --error-format=raw --no-progress -v"
else
	docker-compose -f docker-compose.tools.yaml run --rm --user=$$(id -u) -w /code --entrypoint=sh phpstan -c "phpstan analyse --memory-limit=-1"
endif

#################
# MISCELLANEOUS #
#################

.env:
	cp -n .env.dist .env
	cp -n apps/api/.env.dist apps/api/.env
