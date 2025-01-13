<?php

require_once __DIR__ . '/src/php/installer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$installer = new Installer();

	throw new Exception('Not implemented');

	$installer->install();
}
