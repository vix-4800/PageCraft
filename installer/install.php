<?php

require_once __DIR__ . '/src/php/installer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$installer = new Installer($_POST);

	$installer->install();
}
