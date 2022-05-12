<?php declare(strict_types=1);

namespace Webit\PHPgs;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Symfony\Component\Process\Process;
use Webit\PHPgs\Options\Options;

class ExecutorTest extends AbstractTest
{
	use MockeryPHPUnitIntegration;

	private ProcessFactory|MockInterface $processFactory;
	private Executor $executor;

	/**
	 * @test
	 */
	public function shouldExecuteGsCommand()
	{
		$input = Input::singleFile($this->randomPathname());
		$output = Output::create($this->randomPathname());
		$options = Options::create();

		$process = $this->mockProcess();
		$this->processFactory
			->shouldReceive('createProcess')
			->with($input, $output, $options)
			->andReturn($process)
			->once();

		$process->shouldReceive('run')->andReturn(0)->once();

		$this->executor->execute($input, $output, $options);
	}

	private function mockProcess(): Process|MockInterface
	{
		$process = Mockery::mock(Process::class);

		$process->shouldReceive('stop');

		return $process;
	}

	/**
	 * @test
	 */
	public function shouldThrowExceptionOnCommandExecutionFailure()
	{
		$this->expectException(GhostScriptExecutionException::class);
		$input = Input::singleFile($this->randomPathname());
		$output = Output::create($this->randomPathname());
		$options = Options::create();

		$process = $this->mockProcess();
		$this->processFactory
			->shouldReceive('createProcess')
			->with($input, $output, $options)
			->andReturn($process)
			->once();

		$process->shouldReceive('run')->andReturn(2)->once();
		$process->shouldReceive('getCommandLine')->andReturn($this->randomPathname());
		$process->shouldReceive('getOutput')->andReturn($this->randomString());

		$this->executor->execute($input, $output, $options);
	}

	protected function setUp(): void
	{
		$this->processFactory = Mockery::mock(ProcessFactory::class);
		$this->executor = new Executor($this->processFactory);
	}
}
