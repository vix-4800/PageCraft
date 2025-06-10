#!make

.PHONY: start stop restart pull update \ 
	start_frontend stop_frontend restart_frontend shell_frontend logs_frontend update_frontend \
	start_backend stop_backend restart_backend shell_backend logs_backend update_backend \
	start_analytics stop_analytics \
	start_development stop_development \
	start_monitoring stop_monitoring

FRONTEND_DOCKER_FILE=frontend/docker-compose.yml
BACKEND_DOCKER_FILE=backend/docker-compose.yml
MONITORING_DOCKER_FILE=infrastructure/docker-compose.monitoring.yml
ANALYTICS_DOCKER_FILE=infrastructure/docker-compose.analytics.yml
DEVELOPMENT_DOCKER_FILE=infrastructure/docker-compose.dev.yml

# General
start: start_frontend start_backend
start_all: start_frontend start_backend start_analytics start_monitoring start_development

stop: stop_frontend stop_backend
stop_all: stop_analytics stop_monitoring stop_development stop_frontend stop_backend

restart: restart_frontend restart_backend

update: pull start update_frontend update_backend restart

install: start install_frontend install_backend restart

pull:
	@echo "\nPulling images..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) pull
	@docker compose -f $(BACKEND_DOCKER_FILE) pull
	@docker compose -f $(MONITORING_DOCKER_FILE) pull
	@docker compose -f $(ANALYTICS_DOCKER_FILE) pull
	@docker compose -f $(DEVELOPMENT_DOCKER_FILE) pull

build:
	@echo "\nBuilding images..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) build
	@docker compose -f $(BACKEND_DOCKER_FILE) build
	@docker compose -f $(MONITORING_DOCKER_FILE) build
	@docker compose -f $(ANALYTICS_DOCKER_FILE) build
	@docker compose -f $(DEVELOPMENT_DOCKER_FILE) build

# Frontend
start_frontend:
	@echo "\nStarting Frontend..."
	@docker compose -f $(FRONTEND_DOCKER_FILE) up -d
	@echo "\nFrontend can be accessed at http://localhost"
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
	@docker exec -it frontend npm update
install_frontend:
	@echo "\nInstalling Frontend..."
	@docker exec -it frontend npm install

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

# Monitoring
start_monitoring:
	@echo "\nStarting Monitoring Services..."
	@docker compose -f $(MONITORING_DOCKER_FILE) up -d
stop_monitoring:
	@echo "\nStopping Monitoring Services..."
	@docker compose -f $(MONITORING_DOCKER_FILE) down

# Analytics
start_analytics:
	@echo "\nStarting Analytics Services..."
	@docker compose -f $(ANALYTICS_DOCKER_FILE) up -d
stop_analytics:
	@echo "\nStopping Analytics..."
	@docker compose -f $(ANALYTICS_DOCKER_FILE) down

# Development
start_development:
	@echo "\nStarting Development Services..."
	@docker compose -f $(DEVELOPMENT_DOCKER_FILE) up -d
stop_development:
	@echo "\nStopping Development Services..."
	@docker compose -f $(DEVELOPMENT_DOCKER_FILE) down