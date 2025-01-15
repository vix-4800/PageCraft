#!make

.PHONY: start stop restart pull update \ 
	start_frontend stop_frontend restart_frontend shell_frontend logs_frontend update_frontend \
	start_backend stop_backend restart_backend shell_backend logs_backend update_backend

FRONTEND_DOCKER_FILE=frontend/docker-compose.yml
BACKEND_DOCKER_FILE=backend/docker-compose.yml

# General
start: start_frontend start_backend
stop: stop_frontend stop_backend
restart: restart_frontend restart_backend
update: pull start update_frontend update_backend restart
install: start install_frontend install_backend restart
pull:
	@echo "\nPulling images..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) pull
	@docker compose -f $(BACKEND_DOCKER_FILE) pull

# Frontend
start_frontend:
	@echo "\nStarting Frontend..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) up -d
	@echo "\nFrontend can be accessed at http://localhost:80"
stop_frontend:
	@echo "\nStopping Frontend..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) down
restart_frontend:
	@echo "\nRestarting Frontend..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) restart
shell_frontend:
	@echo "\nEntering the Running Frontend Container..."
	@docker exec -it frontend sh
logs_frontend:
	@echo "\nShowing Frontend Logs..."
	@docker logs -f frontend
update_frontend:
	@echo "\nUpdating Frontend..."
	@docker exec -it frontend npm update --force
install_frontend:
	@echo "\nInstalling Frontend..."
	@docker exec -it frontend npm install --force

# Backend
start_backend:
	@echo "\nStarting Backend..."
	@docker compose -f $(BACKEND_DOCKER_FILE) up -d
	@echo "\nBackend can be accessed at http://localhost:8080"
stop_backend:
	@echo "\nStopping Backend..."
	@docker compose -f $(BACKEND_DOCKER_FILE) down
restart_backend:
	@echo "\nRestarting Backend..."
	@docker compose -f $(BACKEND_DOCKER_FILE) restart
shell_backend:
	@echo "\nEntering the Running Backend Container..."
	@docker exec -it backend bash
logs_backend:
	@echo "\nShowing Backend Logs..."
	@docker logs -f backend
update_backend:
	@echo "\nUpdating Backend..."
	@docker exec -it backend composer update
install_backend:
	@echo "\nInstalling Backend..."
	@docker exec -it backend composer install