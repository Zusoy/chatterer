-include .env

STAGE ?= dev

####################
# STACK MANAGEMENT #
####################

.PHONY: init-swarm
init-swarm:
	@docker swarm init --advertise-addr 127.0.0.1

.PHONY: build
build: .ensure-stage-exists
	@DOCKER_BUILDKIT=1 docker-compose -f swarm.$(STAGE).yml build
  @DOCKER_BUILDKIT=1 docker-compose -f swarm.$(STAGE).yml build client

.PHONY: start
start: .ensure-stage-exists
	@docker stack deploy -c swarm.$(STAGE).yml chatterer

.PHONY: stop
stop:
	@docker stack rm chatterer

#######
# API #
#######

.PHONY: api-analysis
api-analysis:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" phpstan --memory-limit=2G -n

.PHONY: api-integrations
api-integrations:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" kahlan

.PHONY: api-shell
api-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" sh

.PHONY: api-specs
api-specs:
	@docker-compose -f swarm.$(STAGE).yml run --rm api phpspec run -f pretty -vn --no-code-generation

.PHONY: api-setup-db-test
api-setup-db-test:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" console doctrine:database:create --env=test --if-not-exists
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" console doctrine:migrations:migrate -n --env=test

.PHONY: api-fixtures
api-fixtures:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" console app:data:fixtures -p

##########
# CLIENT #
##########

.PHONY: client-shell
client-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_client)" sh

############
# DATABASE #
############

.PHONY: database-shell
database-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_database)" sh

.PHONY: database-connect
database-connect:
	@docker exec -it "$$(docker ps -q -f name=chatterer_database)" mysql -u$(MYSQL_USER) -p$(MYSQL_PASSWORD) $(MYSQL_DATABASE)

#################
# MISCELLANEOUS #
#################

.env:
	cp -n .env.dist .env

.PHONY: .ensure-stage-exists
.ensure-stage-exists:
ifeq (,$(wildcard swarm.$(STAGE).yml))
	@echo "Env $(STAGE) not supported."
	@exit 1
endif
