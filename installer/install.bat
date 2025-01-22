@echo off
setlocal EnableDelayedExpansion

call :check_root

echo "Starting installation process..."
echo "Enter path for installation: "
set /p INSTALL_PATH=

echo "Enter application name: "
set /p APP_NAME=

echo "Enter application URL: "
set /p APP_URL=

echo "Enter backend port: "
set /p BACKEND_PORT=

echo "Enter database name: "
set /p DB_NAME=

echo "Enter database user: "
set /p DB_USER=

echo "Enter database password: "
set /p DB_PASSWORD=

echo "Run seeders? (yes/no): "
set /p RUN_SEEDERS=

echo "Enable SSL? (yes/no): "
set /p ENABLE_SSL=

call :check_dependencies
call :clone_repository

call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "APP_NAME" %APP_NAME%
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "APP_ENV" "production"
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "APP_URL" %APP_URL%
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "APP_PORT" %BACKEND_PORT%
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "FRONTEND_URL" %APP_URL%
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "DB_DATABASE" %DB_NAME%
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "DB_USERNAME" %DB_USER%
call :set_env_variable "%INSTALL_PATH%\pagecraft\backend\.env" "DB_PASSWORD" %DB_PASSWORD%

call :set_env_variable "%INSTALL_PATH%\pagecraft\frontend\.env" "APP_NAME" %APP_NAME%
call :set_env_variable "%INSTALL_PATH%\pagecraft\frontend\.env" "APP_ENV" "production"
call :set_env_variable "%INSTALL_PATH%\pagecraft\frontend\.env" "APP_URL" %APP_URL%
call :set_env_variable "%INSTALL_PATH%\pagecraft\frontend\.env" "API_PORT" %BACKEND_PORT%

call :install_dependencies
call :start_docker_containers
call :generate_application_key
call :run_migrations

if /I "%RUN_SEEDERS%"=="yes" call :run_seeders

if /I "%ENABLE_SSL%"=="yes" call :enable_ssl

echo "Installation completed successfully!"
goto :eof

:set_env_variable
set "env_file=%~1"
set "key=%~2"
set "value=%~3"
if not "%value%"=="" set "value="%value%""
findstr /b "%key%=" "%env_file%" > nul
if %errorlevel% equ 0 (
    for /f "delims=" %%a in ('type "%env_file%" ^| findstr /v "^%key%="') do echo %%a > "%env_file%.tmp"
    echo %key%=%value% >> "%env_file%.tmp"
    move /y "%env_file%.tmp" "%env_file%"
) else (
    echo %key%=%value% >> "%env_file%"
)
goto :eof

:check_root
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo This script must be run as administrator.
    exit /b 1
)
goto :eof

:check_dependencies
echo Checking Git and Docker...
where git > nul 2>&1
if %errorlevel% neq 0 (
    echo Git is not installed. Please install Git before running.
    exit /b 1
)
where docker > nul 2>&1
if %errorlevel% neq 0 (
    echo Docker is not installed. Please install Docker before running.
    exit /b 1
)
goto :eof

:clone_repository
set INSTALL_PATH=%INSTALL_PATH%\pagecraft
echo Cloning repository to %INSTALL_PATH%...
mkdir "%INSTALL_PATH%"
git clone https://github.com/vix-4800/PageCraft.git "%INSTALL_PATH%"
goto :eof

:install_dependencies
echo Installing Composer dependencies...
docker run --rm -v "%INSTALL_PATH%\backend:/app" -w /app composer:latest composer install --no-interaction

echo Installing Node.js dependencies...
docker run --rm -v "%INSTALL_PATH%\frontend:/app" -w /app node:22-alpine npm install --force
goto :eof

:start_docker_containers
echo Starting Docker containers...
docker-compose -f "%INSTALL_PATH%\pagecraft\backend\docker-compose.yml" up -d
docker-compose -f "%INSTALL_PATH%\pagecraft\frontend\docker-compose.yml" up -d
goto :eof

:generate_application_key
echo Generating application key...
docker exec -it backend php artisan key:generate
goto :eof

:run_migrations
echo Running migrations...
docker exec -it backend php artisan migrate --force
goto :eof

:run_seeders
echo Running seeders...
docker exec -it backend php artisan db:seed
goto :eof

:enable_ssl
echo Enabling SSL...
set CERTBOT_EMAIL=admin@%APP_URL%
docker exec -it backend certbot --nginx --non-interactive --agree-tos --email "%CERTBOT_EMAIL%" --domains "%APP_URL%"
goto :eof

