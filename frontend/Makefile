#!make

.PHONY: start stop restart shell logs update install pull build

include .env

# Frontend
start:
	@echo "\nStarting Frontend..."
	@docker compose up -d
	@echo "\nYou can access your app at http://localhost/welcome"

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

update:
	@echo "\nUpdating..."
	@docker exec -it frontend npm update

install:
	@echo "\nInstalling..."
	@docker exec -it frontend npm install

pull:
	@echo "\nPulling images..."
	@docker compose pull

build:
	@echo "\nBuilding images..."
	@docker compose build
