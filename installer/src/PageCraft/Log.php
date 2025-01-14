<?php

declare(strict_types=1);

namespace PageCraft;

class Log
{
	protected string $filename = 'install.log';

	public function write(string $message, int $progress): void
	{
		$logData = [
			'status' => $message,
			'progress' => $progress
		];

		file_put_contents($this->filename, json_encode($logData) . PHP_EOL, FILE_APPEND);
	}

	public function clear(): void
	{
		file_put_contents($this->filename, '');
	}
}
