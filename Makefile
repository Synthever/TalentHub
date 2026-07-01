# Docker helper commands for TalentHub

.PHONY: help build up down restart logs shell test migrate fresh seed cache-clear

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-20s %s\n", $$1, $$2}'

build: ## Build Docker containers
	docker-compose build --no-cache

up: ## Start Docker containers
	docker-compose up -d

down: ## Stop Docker containers
	docker-compose down

restart: ## Restart Docker containers
	docker-compose restart

logs: ## Show container logs
	docker-compose logs -f

logs-app: ## Show app container logs
	docker-compose logs -f app

logs-nginx: ## Show nginx container logs
	docker-compose logs -f nginx

shell: ## Access app container shell
	docker-compose exec app sh

shell-mysql: ## Access MySQL container
	docker-compose exec mysql mysql -u root -psecret talenthub

shell-redis: ## Access Redis CLI
	docker-compose exec redis redis-cli

install: ## Install dependencies
	docker-compose exec app composer install
	docker-compose exec app npm install

build-assets: ## Build frontend assets
	docker-compose exec app npm run build

dev-assets: ## Watch frontend assets
	docker-compose exec app npm run dev

test: ## Run tests
	docker-compose exec app php artisan test

migrate: ## Run database migrations
	docker-compose exec app php artisan migrate

migrate-fresh: ## Fresh migration with seed
	docker-compose exec app php artisan migrate:fresh --seed

seed: ## Run database seeders
	docker-compose exec app php artisan db:seed

cache-clear: ## Clear all caches
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

cache-optimize: ## Optimize caches for production
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan route:cache
	docker-compose exec app php artisan view:cache

pint: ## Run Laravel Pint code formatter
	docker-compose exec app vendor/bin/pint

setup: build up install migrate ## Complete setup from scratch
	docker-compose exec app php artisan key:generate
	@echo "Setup complete! Access the application at http://localhost:8080"

clean: down ## Clean up containers and volumes
	docker-compose down -v
	docker system prune -f
