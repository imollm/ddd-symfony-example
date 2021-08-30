API_SERVICE_NAME=api
WEBSERVER_SERVICE_NAME=nginx
MYSQL_SERVICE_NAME=db

USER_ID:=$(shell id -u)
GROUP_ID:=$(shell id -g)
COMPOSE=docker-compose -f docker/docker-compose.yml

.EXPORT_ALL_VARIABLES:
DOCKER_UID=$(USER_ID)
DOCKER_GID=$(GROUP_ID)

# DOCKER CONTAINERS
up:
	$(COMPOSE) up -d --build
refresh:
	$(COMPOSE) down
	$(COMPOSE) build
	$(COMPOSE) up -d
reload:
	$(COMPOSE) stop
	$(COMPOSE) build
	$(COMPOSE) up -d
bash-api:
	docker exec -it $(API_SERVICE_NAME) bash
bash-nginx:
	docker exec -it $(WEBSERVER_SERVICE_NAME) bash
bash-db:
	docker exec -it $(MYSQL_SERVICE_NAME) bash
autoload:
	docker exec -it $(API_SERVICE_NAME) composer dump-autoload
rm:
	$(COMPOSE) down
	docker rmi --force $$(docker images -q)
	rm -rf docker/mysql/data
network:
	docker network inspect docker_default

# DATABASE
db-create:
	docker exec -it $(API_SERVICE_NAME) bin/console doctrine:schema:create
db-check:
	docker exec -it $(API_SERVICE_NAME) bin/console doctrine:schema:validate
db-update-force:
	docker exec -it $(API_SERVICE_NAME) bin/console doctrine:schema:update --force
db-update-dump:
	docker exec -it $(API_SERVICE_NAME) bin/console doctrine:schema:update --dump-sql
