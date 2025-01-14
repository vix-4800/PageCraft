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
		echo 'Installing...';
	}
}
