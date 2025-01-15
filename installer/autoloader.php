<?php

declare(strict_types=1);

spl_autoload_register(function ($className): void {
	$file = __DIR__ . "/src/" . str_replace('\\', DIRECTORY_SEPARATOR, $className) . ".php";

	if (file_exists($file)) {
		require_once $file;
	} else {
		throw new Exception("Unable to load $className.");
	}
});
