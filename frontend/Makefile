#!make

.PHONY: start stop restart shell logs

include .env

# Frontend
start:
	@echo "\nStarting Frontend..."
	@docker compose up -d
	@echo "\nYou can access your app at http://localhost:${APP_PORT}"

stop:
	@echo "\nStopping Frontend..."
	@docker compose down

restart:
	@echo "\nRestarting Frontend..."
	@docker compose restart

shell:
	@echo "\nEntering the Running Frontend Container..."
	@docker exec -it frontend sh

logs:
	@echo "\nShowing Frontend Logs..."
	@docker logs -f frontend
