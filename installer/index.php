<?php

require_once __DIR__ . '/autoloader.php';

use PageCraft\RequestParam;
use PageCraft\Log;

$logger = new Log();
$progress = $logger->getProgress();

if ($progress === 100) {
	header('Location: ./installing.php');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>PageCraft Installer</title>

	<script src="https://cdn.tailwindcss.com"></script>
	<script src="./assets/js/main.js"></script>
</head>

<body>
	<header class="flex items-center justify-center min-h-[70px] bg-gray-200 mb-8">
		<h1 class="text-3xl font-bold">PageCraft Installer</h1>
	</header>

	<main class="flex justify-center min-h-screen gap-4 mx-auto lg:max-w-6xl md:max-w-4xl">
		<aside class="sticky top-0 w-1/5">
			<ul class="space-y-2">
				<li class="font-bold nav-link">
					<a href="#application-settings">Application Settings</a>
				</li>
				<li class="text-gray-800 nav-link">
					<a href="#database-configuration">Database Configuration</a>
				</li>
				<li class="text-gray-800 nav-link">
					<a href="#mail-configuration">Mail Configuration</a>
				</li>
				<li class="text-gray-800 nav-link">
					<a href="#additional-settings">Additional Settings</a>
				</li>
			</ul>
		</aside>

		<form class="w-4/5 space-y-4" id="installer-form">
			<section class="space-y-2" id="application-settings">
				<h3 class="text-xl font-bold text-gray-800">
					Application Settings
				</h3>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::APP_NAME->value ?>">
						App Name:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="PageCraft" name="<?= RequestParam::APP_NAME->value ?>" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::APP_URL->value ?>">
						App URL:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="http://example.com" name="<?= RequestParam::APP_URL->value ?>" required
						pattern="[Hh][Tt][Tt][Pp][Ss]?:\/\/(?:(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)(?:\.(?:[a-zA-Z\u00a1-\uffff0-9]+-?)*[a-zA-Z\u00a1-\uffff0-9]+)*(?:\.(?:[a-zA-Z\u00a1-\uffff]{2,}))(?::\d{2,5})?(?:\/[^\s]*)?">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::APP_LOCALE->value ?>">
						App Locale:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="<?= RequestParam::APP_LOCALE->value ?>" required>
						<option value="en" selected>English</option>
						<option value="ru">Russian</option>
					</select>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::APP_TIMEZONE->value ?>">
						App Timezone:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="<?= RequestParam::APP_TIMEZONE->value ?>" required>
						<option value="UTC" selected>UTC</option>
						<option value="Europe/Moscow">Europe/Moscow</option>
					</select>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::INSTALL_PATH->value ?>">
						App Location:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="/var/www/pagecraft" name="<?= RequestParam::INSTALL_PATH->value ?>" required
						pattern="^[a-zA-Z0-9_\-\/]+$">
				</div>
			</section>

			<hr class="border-gray-500">

			<section class="space-y-2" id="database-configuration">
				<h3 class="text-xl font-bold text-gray-800">
					Database Configuration
				</h3>
				<div class="space-y-2">
					<div class="gap-4 md:flex md:items-center">
						<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::DB_NAME->value ?>">
							DB Name:
						</label>
						<input
							class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
							type="text" placeholder="pagecraft_db" name="<?= RequestParam::DB_NAME->value ?>" required
							pattern="^[a-zA-Z0-9_\-]+$">
					</div>

					<div class="gap-4 md:flex md:items-center">
						<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::DB_USER->value ?>">
							DB User:
						</label>
						<input
							class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
							type="text" placeholder="pagecraft" name="<?= RequestParam::DB_USER->value ?>" required
							pattern="^[a-zA-Z0-9_\-]+$">
					</div>

					<div class="gap-4 md:flex md:items-center">
						<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::DB_PASSWORD->value ?>">
							DB Password:
						</label>
						<input
							class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
							type="password" placeholder="password" name="<?= RequestParam::DB_PASSWORD->value ?>" required">
					</div>
				</div>
			</section>

			<hr class="border-gray-500">

			<section class="space-y-2" id="mail-configuration">
				<h3 class="text-xl font-bold text-gray-800">
					Mail Settings
				</h3>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::MAIL_DRIVER->value ?>">
						Driver:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="<?= RequestParam::MAIL_DRIVER->value ?>" required>
						<option value="smtp" selected>SMTP</option>
						<option value="log">Log</option>
					</select>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::MAIL_HOST->value ?>">
						Host:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="mailhog" name="<?= RequestParam::MAIL_HOST->value ?>" required"
						pattern="^[a-zA-Z0-9_\-]+$">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::MAIL_PORT->value ?>">
						Port:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="number" placeholder="1025" name="<?= RequestParam::MAIL_PORT->value ?>" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::MAIL_USERNAME->value ?>">
						Username:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" name="<?= RequestParam::MAIL_USERNAME->value ?>">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::MAIL_PASSWORD->value ?>">
						Password:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="password" name="<?= RequestParam::MAIL_PASSWORD->value ?>">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::MAIL_ENCRYPTION->value ?>">
						Encryption:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="<?= RequestParam::MAIL_ENCRYPTION->value ?>" required>
						<option value="none" selected>None</option>
						<option value="tls">TLS</option>
						<option value="ssl">SSL</option>
					</select>
				</div>
			</section>

			<hr class="border-gray-500">

			<section class="space-y-2" id="additional-settings">
				<h3 class="text-xl font-bold text-gray-800">
					Additional Settings
				</h3>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::BACKEND_PORT->value ?>">
						Backend Port:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="number" placeholder="8080" value="8080" name="<?= RequestParam::BACKEND_PORT->value ?>" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::RUN_SEEDERS->value ?>">
						Populate Database with Test Data:
					</label>
					<input class="w-5 h-5 bg-gray-200 border-2 border-gray-200 rounded" type="checkbox"
						name="<?= RequestParam::RUN_SEEDERS->value ?>" value="1">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::APP_ENVIRONMENT->value ?>">
						Environment:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="<?= RequestParam::APP_ENVIRONMENT->value ?>" required>
						<option value="local" selected>Local</option>
						<option value="staging">Staging</option>
						<option value="production">Production</option>
					</select>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="<?= RequestParam::ENABLE_SSL->value ?>">
						Enable SSL:
					</label>
					<input class="w-5 h-5 bg-gray-200 border-2 border-gray-200 rounded" type="checkbox"
						name="<?= RequestParam::ENABLE_SSL->value ?>" value="1">
				</div>
			</section>

			<button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Install</button>
		</form>
	</main>

	<footer class="flex items-center justify-center min-h-[70px] bg-gray-200 mt-8">
		<p>&copy; 2025 PageCraft. All rights reserved.</p>
	</footer>
</body>

</html>