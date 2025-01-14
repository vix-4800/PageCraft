<?php

require_once __DIR__ . '/src/php/Installer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	file_put_contents(__DIR__ . '/install_data.json', json_encode($_POST));

	$installer = new Installer($_POST);

	$installer->install();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['get'])) {
	$getParam = $_GET['get'];

	if ($getParam === 'status') {
		$logFile = __DIR__ . '/install.log';

		$progress = 25;
		$status = 'Log file not found.';

		if (file_exists($logFile)) {
			$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$status = end($lines);
		}

		echo json_encode([
			'status' => $status,
			'progress' => $progress
		]);

		return;
	}

	echo json_encode([
		'status' => 'Installation not started.',
		'progress' => 0
	]);
}
