<?php declare(strict_types=1);

namespace Webit\PHPgs\Pdf;

use Webit\PHPgs\AbstractTest;
use Webit\PHPgs\ExecutorBuilder;
use Webit\PHPgs\Input;
use Webit\PHPgs\Output;

class PdfManipulatorIntegrationTest extends AbstractTest
{
	/** @var string[] */
	private array $tempDirs = [];
	private PdfManipulator $pdfManipulator;

	/**
	 * @test
	 */
	public function shouldSplitPdfPagesToMultipleFiles()
	{
		$input = Input::singleFile(__DIR__ . '/../Resources/lorem-ipsum.pdf');
		$output = $this->pdfOutput(true);
		$this->pdfManipulator->split($input, $output, 2, 5);

		$files = $output->files();
		$this->assertEquals(4, count($files));
	}

	private function pdfOutput(bool $multiple = false): Output
	{
		$dir = sprintf('%s/%s', sys_get_temp_dir(), $this->randomString());
		$this->tempDirs[] = $dir;

		if ($multiple) {
			return Output::create(sprintf('%s/%s-%%d.pdf', $dir, $this->randomString()));
		}

		return Output::create(sprintf('%s/%s.pdf', $dir, $this->randomString()));
	}

	/**
	 * @test
	 */
	public function shouldSplitPdfPagesToSingleFile()
	{
		$input = Input::singleFile(__DIR__ . '/../Resources/lorem-ipsum.pdf');
		$output = $this->pdfOutput();

		$this->pdfManipulator->split($input, $output, 2, 5);

		$this->assertFileExists($output->filenameOrPattern());
		$this->assertEquals(4, $this->countPdfPages($output->filenameOrPattern()));
	}

	private function countPdfPages(string $filenameOrPattern): int
	{
		$imagick = new \Imagick($filenameOrPattern);
		return $imagick->getNumberImages();
	}

	/**
	 * @test
	 */
	public function shouldMergePdfPages()
	{
		$input = Input::multipleFiles(array(
			__DIR__ . '/../Resources/p1.pdf',
			__DIR__ . '/../Resources/p2.pdf',
			__DIR__ . '/../Resources/p3.pdf',
			__DIR__ . '/../Resources/p4.pdf'
		));

		$output = $this->pdfOutput();
		$this->pdfManipulator->merge($input, $output);

		$this->assertFileExists($output->filenameOrPattern());
		$this->assertEquals(4, $this->countPdfPages($output->filenameOrPattern()));
	}

	public function tearDown(): void
	{
		foreach ($this->tempDirs as $dir) {
			$di = new \DirectoryIterator($dir);
			foreach ($di as $file) {
				if ($file->isDot()) {
					continue;
				}
				@unlink($file->getPathname());
			}
			@rmdir($dir);
		}
	}

	protected function setUp(): void
	{
		$this->pdfManipulator = new PdfManipulator(
			ExecutorBuilder::create()->setGhostScriptBinary(getenv('gs.binary'))->build()
		);
	}
}
