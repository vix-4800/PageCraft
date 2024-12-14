#!make

.PHONY: build start stop ps restart pull config \ 
	start_frontend stop_frontend restart_frontend shell_frontend logs_frontend \
	start_backend stop_backend restart_backend shell_backend logs_backend \
	start stop ps restart

FRONDEND_DOCKER_FILE=frontend/docker-compose.yml
BACKEND_DOCKER_FILE=backend/docker-compose.yml

# General
start: start_frontend start_backend
stop: stop_frontend stop_backend
restart: restart_frontend restart_backend

# Frontend
start_frontend:
	@echo "\nStarting Frontend..."
	@docker compose -f $(FRONDEND_DOCKER_FILE) up -d
	@echo "\nFrontend can be accessed at http://localhost:80"
stop_frontend:
	@echo "\nStopping Frontend..."
	@docker compose -f $(FRONDEND_DOCKER_FILE) down
restart_frontend:
	@echo "\nRestarting Frontend..."
	@docker compose -f $(FRONDEND_DOCKER_FILE) restart
shell_frontend:
	@echo "\nEntering the Running Frontend Container..."
	@docker exec -it frontend sh
logs_frontend:
	@echo "\nShowing Frontend Logs..."
	@docker logs -f frontend

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