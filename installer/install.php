<?php

require_once __DIR__ . '/autoloader.php';

use PageCraft\Installer;

$installer = new Installer(json_decode(file_get_contents(__DIR__ . '/install_data.json'), true));
$installer->install();
