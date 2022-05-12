<?php declare(strict_types=1);

namespace Webit\PHPgs;

class ExecutorBuilder
{
	private string $ghostScriptBinary = 'gs';

	public static function create()
	{
		return new self();
	}

	public function setGhostScriptBinary(string $ghostScriptBinary): static
	{
		$this->ghostScriptBinary = $ghostScriptBinary;
		return $this;
	}

	public function build(): Executor
	{
		return new Executor(
			new ProcessFactory($this->ghostScriptBinary)
		);
	}
}