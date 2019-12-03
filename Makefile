USER_ID = $(shell id -u)
GROUP_ID = $(shell id -g)

export UID = $(USER_ID)
export GID = $(GROUP_ID)

PROJECT_NAME = sf_test
DOCKER_COMPOSE_DEV = docker-compose -p $(PROJECT_NAME)

help: ## Display available commands
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# =====================================================================
# Install =============================================================
# =====================================================================

install: ## Install docker stack, assets and vendors
	$(DOCKER_COMPOSE_DEV) build
	$(MAKE) deps-install
	$(MAKE) db-migrate
	$(MAKE) js-deps-install
	echo `cat ./docker/doc/install.txt`

db-migrate: ## Migrate database
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'su -l www-data -s /bin/bash -c "php bin/console doctrine:migration:migrate --no-interaction"'

deps-install: ## Install composer vendor and setup assets
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'su -l www-data -s /bin/bash -c "php -d memory_limit=2G bin/composer install"'
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'su -l www-data -s /bin/bash -c "php bin/console assets:install"'

js-deps-install: ## Install javascript modules
	$(DOCKER_COMPOSE_DEV) run --rm yarn ash -ci 'cd app && yarn install'

fixtures-install: ## Install fixtures
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'su -l www-data -s /bin/bash -c "php -d memory_limit=2G bin/console doctrine:fixtures:load -n"'

# =====================================================================
# Development =========================================================
# =====================================================================

start: ## Start all the stack (you can access the project on localhost:8080 after that)
	@-docker network create thinkfab_stack
	$(DOCKER_COMPOSE_DEV) up -d
	@docker network connect --alias $(PROJECT_NAME) thinkfab_stack $$(docker ps --filter "name=$(PROJECT_NAME)_php_*" -q)
	echo `cat ./docker/doc/start.txt`

stop: ## Stop all the containers that belongs to the project
	@-docker network disconnect thinkfab_stack $$(docker ps --filter "name=$(PROJECT_NAME)_php_*" -q)
	$(DOCKER_COMPOSE_DEV) down

connect: ## Connect on a remote bash terminal on the php container
	$(DOCKER_COMPOSE_DEV) exec php bash -ci 'su -l www-data -s /bin/bash'

connect_root: ## Connect on a remote bash terminal on the php container
	$(DOCKER_COMPOSE_DEV) exec php bash

log: ## Show logs from php container
	$(DOCKER_COMPOSE_DEV) logs -f php

status: ## Check container status
	$(DOCKER_COMPOSE_DEV) ps

connect-yarn: ## Connect on a remove bash terminal on the yarn container
	$(DOCKER_COMPOSE_DEV) run yarn ash -ci 'cd app'

build-assets: ## Build assets (minimized) for production
	$(DOCKER_COMPOSE_DEV) run --rm yarn ash -ci 'cd app && yarn encore production'

build-assets-watch: ## Build assets for dev in watch mode
	$(DOCKER_COMPOSE_DEV) run --rm yarn ash -ci 'cd app && yarn encore dev --watch'

composer_require: ## Add composer dependencies
	@read -p "Enter vendor name:" vendor; \
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci "su -l www-data -s /bin/bash -c 'php -d memory_limit=2G bin/composer require $$vendor'"