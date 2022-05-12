<?php declare(strict_types=1);

namespace Webit\PHPgs;

use Symfony\Component\Process\Process;
use Webit\PHPgs\Options\Options;

class ProcessFactory
{
	public function __construct(
		private string $gsBin = 'gs'
	) {}

	public function createProcess(Input $input, Output $output, Options $options): Process
	{
		$this->ensureOutputDirExists($output);
		$options = $options->withOption('-sOutputFile', $output);

		return new Process(
			array_merge([$this->gsBin], $options->toProcessArguments(), $input->files())
		);
	}

	private function ensureOutputDirExists(Output $output): void
	{
		$dir = dirname($output->filenameOrPattern());
		if (!is_dir($dir)) {
			@mkdir($dir, 0755, true);
		}
	}
}
