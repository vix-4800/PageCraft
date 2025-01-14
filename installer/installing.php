<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>PageCraft Installer</title>

	<script src="https://cdn.tailwindcss.com"></script>
	<script src="./src/js/loading.js"></script>
</head>

<body>
	<header class="flex items-center justify-center min-h-[70px] bg-gray-200 mb-8">
		<h1 class="text-3xl font-bold">PageCraft Installer</h1>
	</header>

	<main class="flex justify-center min-h-screen gap-4 mx-auto lg:max-w-6xl md:max-w-4xl">
		<div class="w-1/2">
			<div class="flex flex-col items-center justify-between w-full gap-4">
				<progress class="w-full rounded" value="50" max="100" id="progress_bar"></progress>
				<span id="progress_status">Loading...</span>
			</div>
		</div>
	</main>

	<footer class="flex items-center justify-center min-h-[70px] bg-gray-200 mt-8">
		<p>&copy; 2025 PageCraft. All rights reserved.</p>
	</footer>
</body>

</html>