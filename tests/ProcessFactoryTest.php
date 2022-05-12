<?php declare(strict_types=1);

namespace Webit\PHPgs;

use Symfony\Component\Process\Process;
use Webit\PHPgs\Options\Device;
use Webit\PHPgs\Options\Options;
use Webit\PHPgs\Options\Size;

class ProcessFactoryTest extends AbstractTest
{
	private string $gsPath;
	private ProcessFactory $processFactory;

	protected function setUp(): void
	{
		$this->gsPath = getenv('gs.binary');
		$this->processFactory = new ProcessFactory($this->gsPath);
	}

	/**
	 * @test
	 * @dataProvider processes
	 * @param Input $input
	 * @param Output $output
	 * @param Options $options
	 * @param Process $expectedProcess
	 */
	public function shouldCreateProcess(Input $input, Output $output, Options $options, Process $expectedProcess)
	{
		$this->assertEquals(
			$expectedProcess,
			$this->processFactory->createProcess($input, $output, $options)
		);
	}

	public function processes()
	{
		$this->setUp();
		return [
			'single input' => [
				$input = Input::singleFile($this->randomPathname()),
				$output = Output::create($this->randomPathname()),
				$options = Options::create(Device::any($this->randomString()))
					->withSize(new Size(100, 100))
					->withOutputFile($output)
				,
				new Process(
					array_merge([$this->gsPath], $options->toProcessArguments(), $input->files())
				)
			],
			'multiple input' => [
				$input = Input::multipleFiles(
					[
						$this->randomPathname(),
						$this->randomPathname()
					]
				),
				$output = Output::create($this->randomPathname()),
				$options = Options::create()->withOption('-sOutputFile', $output),
				new Process(
					array_merge([$this->gsPath], $options->toProcessArguments(), $input->files())
				)
			]
		];
	}

}
