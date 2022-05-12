<?php declare(strict_types=1);

namespace Webit\PHPgs\Options;

use Webit\PHPgs\AbstractTest;

class OptionsTest extends AbstractTest
{
	/**
	 * @dataProvider options
	 * @test
	 */
	public function shouldCastToString(Options $options, array $expectedArguments)
	{
		$this->assertEquals($expectedArguments, $options->toProcessArguments());
	}

	public function options(): array
	{
		return [
			'default' => [
				Options::create(),
				$this->commonOptions()
			],
			'custom-device' => [
				Options::create($device = Device::any($this->randomString())),
				$this->commonOptions($device)
			],
			'size' => [
				Options::create()->withSize(new Size(150, 200)),
				array_merge($this->commonOptions(), ['-g150x200']),
			],
			'compatibility level' => [
				Options::create()->withCompatibilityLevel($compatibilityLevel = CompatibilityLevel::level14()),
				array_merge($this->commonOptions(), [
					sprintf('-dCompatibilityLevel=%s', $compatibilityLevel)
				]),
			],
			'color conversion strategy' => [
				Options::create()->withColorConversionStrategy($colorConversionStrategy = ColorConversionStrategy::gray()),
				array_merge($this->commonOptions(), [
					sprintf('-dColorConversionStrategy=%s', $colorConversionStrategy)
				]),
			],
			'color conversion strategy for images' => [
				Options::create()->withColorConversionStrategyForImages($colorConversionStrategy = ColorConversionStrategy::cmyk()),
				array_merge($this->commonOptions(), [
					sprintf('-dColorConversionStrategyForImages=%s', $colorConversionStrategy)
				]),
			],
			'jpeg quality' => [
				Options::create()->withJpegQuality($quality = 90),
				array_merge($this->commonOptions(), [
					sprintf('-dJPEGQ=%s', $quality)
				]),
			],
			'no transparency' => [
				Options::create()->withNoTransparency(),
				array_merge($this->commonOptions(), ['-dNOTRANSPARENCY']),
			],
			'resolution' => [
				Options::create()->withResolution($x = 72, $y = 96),
				array_merge($this->commonOptions(), [
					sprintf('-r%dx%d', $x, $y)
				]),
			],
			'process color model' => [
				Options::create()->withProcessColorModel($colorSpace = DeviceColorSpace::rgb()),
				array_merge($this->commonOptions(), [
					sprintf('-dProcessColorModel=%s', $colorSpace)
				]),
			],
			'page range' => [
				Options::create()->withPageRange($from = 4, $to = 10),
				array_merge($this->commonOptions(), [
					sprintf('-dFirstPage=%s', $from),
					sprintf('-dLastPage=%s', $to)
				]),
			],
			'page from' => [
				Options::create()->withPageRange($from = 4),
				array_merge($this->commonOptions(), [
					sprintf('-dFirstPage=%s', $from)
				]),
			],
			'page to' => [
				Options::create()->withPageRange(null, $to = 4),
				array_merge($this->commonOptions(), [
					sprintf('-dLastPage=%s', $to)
				]),
			],
			'crop box' => [
				Options::create()->useCropBox(),
				array_merge($this->commonOptions(), ['-dUseCropBox']),
			],
			'CIE Color' => [
				Options::create()->useCIEColor(),
				array_merge($this->commonOptions(), ['-dUseCIEColor=true']),
			],
			'with output file' => [
				Options::create()->withOutputFile($file = $this->randomPathname()),
				array_merge($this->commonOptions(), [
					sprintf('-sOutputFile=%s', $file)
				])
			],
			'any option with value' => [
				Options::create()->withOption($option = $this->randomString(), $value = $this->randomString()),
				array_merge($this->commonOptions(), [
					sprintf('%s=%s', $option, $value)
				]),
			],
			'any option no value' => [
				Options::create()->withOption($option = $this->randomString()),
				array_merge($this->commonOptions(), [
					sprintf('%s', $option)
				]),
			],
		];
	}

	private function commonOptions($device = null): array
	{
		return [
			'-dNOPAUSE',
			'-dBATCH',
			'-dSAFER',
			sprintf('-sDEVICE=%s', $device ?: 'pdfwrite'),
		];
	}
}
