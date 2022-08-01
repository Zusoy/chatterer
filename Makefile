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

.PHONY: api-shell
api-shell:
	@docker exec -it "$$(docker ps -q -f name=chatterer_api)" sh

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

.PHONY: .ensure-stage-exists
.ensure-stage-exists:
ifeq (,$(wildcard swarm.$(STAGE).yml))
	@echo "Env $(STAGE) not supported."
	@exit 1
endif
