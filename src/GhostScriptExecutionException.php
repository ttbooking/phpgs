<?php declare(strict_types=1);

namespace Webit\PHPgs;

use RuntimeException;
use Symfony\Component\Process\Process;

class GhostScriptExecutionException extends RuntimeException
{
	private string $command;
	private string $output;

	public static function fromProcess(Process $process): GhostScriptExecutionException
	{
		$exception = new self('Error during GhostScript command execution.');
		$exception->command = $process->getCommandLine();
		$exception->output = $process->getOutput();

		return $exception;
	}

	public function command(): string
	{
		return $this->command;
	}

	public function output(): string
	{
		return $this->output;
	}
}
