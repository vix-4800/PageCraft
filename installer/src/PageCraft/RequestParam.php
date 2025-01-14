<?php

declare(strict_types=1);

namespace PageCraft;

enum RequestParam: string
{
	case APP_NAME = 'app_name';
	case APP_URL = 'app_url';
	case APP_LOCALE = 'app_locale';
	case APP_TIMEZONE = 'app_timezone';
	case DB_NAME = 'db_name';
	case DB_USER = 'db_user';
	case DB_PASSWORD = 'db_password';
	case MAIL_DRIVER = 'mail_driver';
	case MAIL_HOST = 'mail_host';
	case MAIL_PORT = 'mail_port';
	case MAIL_USERNAME = 'mail_username';
	case MAIL_PASSWORD = 'mail_password';
	case MAIL_ENCRYPTION = 'mail_encryption';
	case BACKEND_PORT = 'backend_port';
	case RUN_SEEDERS = 'run_seeders';
	case APP_ENVIRONMENT = 'environment';
	case INSTALL_PATH = 'install_path';
}
