<?php declare(strict_types=1);

namespace Webit\PHPgs;

use Webit\PHPgs\Options\Options;

class Executor
{
	private ProcessFactory $processFactory;

	public function __construct(ProcessFactory $processFactory = null)
	{
		$this->processFactory = $processFactory ?: new ProcessFactory();
	}

	public function execute(Input $input, Output $output, Options $options)
	{
		$process = $this->processFactory->createProcess($input, $output, $options);
		if (0 != $process->run()) {
			throw GhostScriptExecutionException::fromProcess($process);
		}
	}
}
