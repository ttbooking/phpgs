<?php declare(strict_types=1);

namespace Webit\PHPgs\Pdf;

use Webit\PHPgs\Executor;
use Webit\PHPgs\Input;
use Webit\PHPgs\Options\Device;
use Webit\PHPgs\Options\Options;
use Webit\PHPgs\Output;

final class PdfManipulator implements Merger, Splitter
{
	public function __construct(
		private Executor $writer
	) {}

	/**
	 * @inheritdoc
	 */
	public function merge(Input $input, Output $output, ?Options $options = null): void
	{
		$options = $this->mergeOptions($options);
		$this->writer->execute($input, $output, $options);
	}

	private function mergeOptions(?Options $options = null): Options
	{
		$options = $options ?: Options::create();
		return $options->withDevice(Device::pdfWrite());
	}

	/**
	 * @inheritdoc
	 */
	public function split(
		Input $input,
		Output $output,
		?int $pageFrom = null,
		?int $pageTo = null,
		?Options $options = null
	): void	{
		$options = $this->mergeOptions($options)->withPageRange($pageFrom, $pageTo);
		$this->writer->execute($input, $output, $options);

		$this->ensureExtractedPages($output, $pageFrom, $pageTo);
	}

	/**
	 * Fix unwanted Ghost Script behaviour (producing additional empty page)
	 */
	private function ensureExtractedPages(Output $output, int $pageFrom, int $pageTo)
	{
		$expectedNumberOfPages = $pageTo - ($pageFrom ?: 1) + 1;

		$files = $output->files();

		while (count($files) > $expectedNumberOfPages) {
			@unlink(array_pop($files));
			$files = $output->files();
		}
	}
}
