<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	file_put_contents(__DIR__ . '/install_data.json', json_encode($_POST));

	shell_exec('php ' . __DIR__ . '/install.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['get'])) {
	$getParam = $_GET['get'];

	if ($getParam === 'status') {
		$logFile = 'install.log';

		if (file_exists($logFile)) {
			$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$lastLog = end($lines);

			$logData = json_decode($lastLog, true);

			echo json_encode([
				'status' => $logData['status'],
				'progress' => $logData['progress']
			]);

			return;
		}
	}

	echo json_encode([
		'status' => 'Installation not started.',
		'progress' => 0
	]);
}
