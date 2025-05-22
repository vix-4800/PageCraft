#!/bin/bash

set_env_variable() {
    local env_file=$1
    local key=$2
    local value=$3

    if [[ -n $value ]]; then
        value="\"$value\""
    fi

    # Check if the key already exists
    if grep -q "^$key=" "$env_file"; then
        sed -i "s/^$key=.*/$key=$value/" "$env_file"
    else
        echo "$key=$value" >> "$env_file"
    fi
}

check_root() {
	if [[ "$EUID" -ne 0 ]]; then
		echo "This script must be run as root" >&2
		exit 1
	fi
}

check_dependencies() {
	echo "Git and Docker check..."
	if ! command -v git &>/dev/null; then
		echo "Git is not installed. Please install Git before running."
		exit 1
	fi

	if ! command -v docker &>/dev/null; then
		echo "Docker is not installed. Please install Docker before running."
		exit 1
	fi
}

clone_repository() {
	INSTALL_PATH="$INSTALL_PATH/pagecraft"
	echo "Cloning the repository into $INSTALL_PATH..."
	mkdir -p "$INSTALL_PATH"
	git clone https://github.com/vix-4800/PageCraft.git "$INSTALL_PATH"
}

setup_env() {
	echo "Setting up environment variables..."
	BACKEND_ENV="$INSTALL_PATH/backend/.env"
	FRONTEND_ENV="$INSTALL_PATH/frontend/.env"

	cp "$INSTALL_PATH/backend/.env.example" "$BACKEND_ENV"
	cp "$INSTALL_PATH/frontend/.env.example" "$FRONTEND_ENV"

	set_env_variable "$BACKEND_ENV" "APP_NAME" $APP_NAME
	set_env_variable "$BACKEND_ENV" "APP_ENV" "production"
	set_env_variable "$BACKEND_ENV" "APP_URL" $APP_URL
	set_env_variable "$BACKEND_ENV" "APP_PORT" $BACKEND_PORT
	set_env_variable "$BACKEND_ENV" "FRONTEND_URL" $APP_URL
	set_env_variable "$BACKEND_ENV" "DB_DATABASE" $DB_NAME
	set_env_variable "$BACKEND_ENV" "DB_USERNAME" $DB_USER
	set_env_variable "$BACKEND_ENV" "DB_PASSWORD" $DB_PASSWORD

	set_env_variable "$FRONTEND_ENV" "APP_NAME" $APP_NAME
	set_env_variable "$FRONTEND_ENV" "APP_ENV" "production"
	set_env_variable "$FRONTEND_ENV" "APP_URL" $APP_URL
	set_env_variable "$FRONTEND_ENV" "API_PORT" $BACKEND_PORT
}

install_dependencies() {
	echo "Installing composer dependencies..."
	docker run --rm -v "$INSTALL_PATH/backend:/app" -w /app composer:latest composer install --no-interaction

	echo "Installing Node.js dependencies..."
	docker run --rm -v "$INSTALL_PATH/frontend:/app" -w /app node:22-alpine npm install
}

install(){
	check_root

	echo "Starting installation process..."

	# User input
	read -p "Enter the installation path: " INSTALL_PATH
	read -p "Enter the application name: " APP_NAME
	read -p "Enter the application URL: " APP_URL
	read -p "Enter the port for the backend: " BACKEND_PORT
	read -p "Enter the database name: " DB_NAME
	read -p "Enter the database user: " DB_USER
	read -sp "Enter the database password: " DB_PASSWORD
	echo
	read -p "Run the seeders? (yes/no): " RUN_SEEDERS
	read -p "Enable SSL? (yes/no): " ENABLE_SSL

	check_dependencies
	clone_repository
	setup_env
	install_dependencies

	# Run containers
	echo "Starting Docker containers..."
	docker compose -f "$INSTALL_PATH/backend/docker-compose.yml" up -d
	docker compose -f "$INSTALL_PATH/frontend/docker-compose.yml" up -d

	# Generate application key
	echo "Generating application key..."
	docker exec -it backend php artisan key:generate

	# Run migrations
	echo "Running migrations..."
	docker exec -it backend php artisan migrate --force

	# Run seeders (if selected)
	if [[ "$RUN_SEEDERS" == "yes" ]]; then
		echo "Running seeders..."
		docker exec -it backend php artisan db:seed
	fi

	# Enable SSL (if selected)
	if [[ "$ENABLE_SSL" == "yes" ]]; then
		echo "Enabling SSL..."
		CERTBOT_EMAIL="admin@$APP_URL"
		docker exec -it backend certbot --nginx --non-interactive --agree-tos --email "$CERTBOT_EMAIL" --domains "$APP_URL"
	fi

	echo "Installation completed successfully!"
}

install
