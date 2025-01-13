<?php

declare(strict_types=1);

class Installer
{
	public function __construct()
	{
		// 
	}

	public function checkDependencies()
	{
		@exec('git --version');
		@exec('docker -v');
	}

	public function install()
	{
		echo 'install';
	}
}
