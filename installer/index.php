<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>PageCraft Installer</title>

	<script src="https://cdn.tailwindcss.com"></script>
	<script src="./src/js/main.js"></script>
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

		<form action="./install.php" method="POST" class="w-4/5 space-y-4" id="installer-form">
			<section class="space-y-2" id="application-settings">
				<h3 class="text-xl font-bold text-gray-800">
					Application Settings
				</h3>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="app_name">
						App Name:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="PageCraft" name="app_name" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="app_url">
						App URL:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="http://localhost" name="app_url" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="app_locale">
						App Locale:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="app_locale" required>
						<option value="en" selected>English</option>
						<option value="ru">Russian</option>
					</select>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="app_timezone">
						App Timezone:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="app_timezone" required>
						<option value="UTC" selected>UTC</option>
						<option value="Europe/Moscow">Europe/Moscow</option>
					</select>
				</div>
			</section>

			<hr class="border-gray-500">

			<section class="space-y-2" id="database-configuration">
				<h3 class="text-xl font-bold text-gray-800">
					Database Configuration
				</h3>
				<div class="space-y-2">
					<div class="gap-4 md:flex md:items-center">
						<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="db_name">
							DB Name:
						</label>
						<input
							class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
							type="text" placeholder="pagecraft_db" name="db_name" required>
					</div>

					<div class="gap-4 md:flex md:items-center">
						<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="db_user">
							DB User:
						</label>
						<input
							class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
							type="text" placeholder="pagecraft" name="db_user" required>
					</div>

					<div class="gap-4 md:flex md:items-center">
						<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="db_password">
							DB Password:
						</label>
						<input
							class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
							type="password" placeholder="password" name="db_password">
					</div>
				</div>
			</section>

			<hr class="border-gray-500">

			<section class="space-y-2" id="mail-configuration">
				<h3 class="text-xl font-bold text-gray-800">
					Mail Settings
				</h3>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="mail_driver">
						Driver:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="mail_driver" required>
						<option value="smtp" selected>SMTP</option>
						<option value="log">Log</option>
					</select>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="mail_host">
						Host:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" placeholder="mailhog" name="mail_host">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="mail_port">
						Port:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="number" placeholder="1025" name="mail_port" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="mail_username">
						Username:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="text" name="mail_username">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="mail_password">
						Password:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="password" name="mail_password">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="mail_encryption">
						Encryption:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="mail_encryption" required>
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
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="backend_port">
						Backend Port:
					</label>
					<input
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						type="number" placeholder="8080" value="8080" name="backend_port" required>
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="run_seeders">
						Populate Database with Test Data:
					</label>
					<input class="w-5 h-5 bg-gray-200 border-2 border-gray-200 rounded" type="checkbox"
						name="run_seeders" value="1">
				</div>

				<div class="gap-4 md:flex md:items-center">
					<label class="font-bold text-gray-500 md:w-1/4 md:text-right md:mb-0" for="environment">
						Environment:
					</label>
					<select
						class="w-3/5 px-4 py-2 leading-tight text-gray-700 bg-gray-200 border-2 border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-purple-500"
						name="environment" required>
						<option value="local" selected>Local</option>
						<option value="staging">Staging</option>
						<option value="production">Production</option>
					</select>
				</div>
			</section>

			<button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
				Install
			</button>
		</form>
	</main>

	<footer class="flex items-center justify-center min-h-[70px] bg-gray-200 mt-8">
		<p>&copy; 2025 PageCraft. All rights reserved.</p>
	</footer>
</body>

</html>