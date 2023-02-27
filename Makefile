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

.PHONY: api-analysis
api-analysis:
	@docker-compose run --rm --no-deps api ./vendor/bin/phpstan --memory-limit=2G -n

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

##########
# CLIENT #
##########

.PHONY: client-shell
client-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_client)" sh

#################
# MISCELLANEOUS #
#################

.env:
	cp -n .env.dist .env
