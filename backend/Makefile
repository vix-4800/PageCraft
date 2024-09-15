#!make

.PHONY: start stop restart shell logs migrate seed test pint helper

include .env

# Backend
start:
	@echo "\nStarting Backend..."
	@docker compose up -d
	@echo "\nYou can access your Backend at http://localhost:${APP_PORT}"

stop:
	@echo "\nStopping Backend..."
	@docker compose down

restart:
	@echo "\nRestarting Backend..."
	@docker compose restart

shell:
	@echo "\nEntering the Backend Frontend Container..."
	@docker exec -it backend bash

logs:
	@echo "\nShowing Backend Logs..."
	@docker logs -f backend

migrate:
	@echo "\nMigrating Database..."
	@docker exec -it backend php artisan migrate --force

seed:
	@echo "\nSeeding Database..."
	@docker exec -it backend php artisan db:seed

test:
	@echo "\nRunning Tests..."
	@docker exec -it backend php artisan test

pint:
	@echo "\nRunning Pint..."
	@docker exec -it backend composer pint

larastan:
	@echo "\nRunning Larastan..."
	@docker exec -it backend composer phpstan

helper:
	@echo "\nGenerating Laravel IDE helpers..."
	@docker exec -it backend composer ide-helper
