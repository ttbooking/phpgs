<?php declare(strict_types=1);

namespace Webit\PHPgs\Options;

use Webit\PHPgs\Output;

final class Options
{
	/** @var string[] */
	private static array $defaultOptions = [
		'-dNOPAUSE' => null,
		'-dBATCH' => null,
		'-dSAFER' => null
	];

	/**
	 * @var string[]
	 */
	private array $options;

	/**
	 * Options constructor.
	 * @param array $options
	 */
	private function __construct(array $options = array())
	{
		$this->options = array_replace(self::$defaultOptions, $options);
	}

	public static function create(?Device $device = null): Options
	{
		$options = new self();
		return $options->withDevice($device ?: Device::pdfWrite());
	}

	public function withDevice(Device $device): Options
	{
		return $this->withOption('-sDEVICE', (string)$device);
	}

	/**
	 * @param string $option
	 * @param null|mixed $value
	 * @return Options
	 */
	public function withOption(string $option, mixed $value = null): Options
	{
		$options = $this->options;
		$options[$option] = $value !== null ? (string)$value : null;

		return new self($options);
	}

	public function withSize(Size $size): Options
	{
		return $this->withOption(sprintf('-g%s', $size));
	}

	public function withCompatibilityLevel(CompatibilityLevel $compatibilityLevel): Options
	{
		return $this->withOption('-dCompatibilityLevel', (string)$compatibilityLevel);
	}

	public function withNoTransparency(): Options
	{
		return $this->withOption('-dNOTRANSPARENCY');
	}

	public function useCIEColor(): Options
	{
		return $this->withOption('-dUseCIEColor', 'true');
	}

	public function withColorConversionStrategy(ColorConversionStrategy $colorConversionStrategy): Options
	{
		return $this->withOption('-dColorConversionStrategy', (string)$colorConversionStrategy);
	}

	public function withColorConversionStrategyForImages(ColorConversionStrategy $colorConversionStrategy): Options
	{
		return $this->withOption('-dColorConversionStrategyForImages', (string)$colorConversionStrategy);
	}

	public function withProcessColorModel(DeviceColorSpace $colorSpace): Options
	{
		return $this->withOption('-dProcessColorModel', (string)$colorSpace);
	}

	public function withPageRange(?int $first = null, ?int $last = null): Options
	{
		$options = $this;
		if ($first !== null) {
			$options = $options->withOption('-dFirstPage', $first);
		}

		if ($last !== null) {
			$options = $options->withOption('-dLastPage', $last);
		}

		return $options;
	}

	public function withJpegQuality(int $quality): Options
	{
		return $this->withOption('-dJPEGQ', $quality);
	}

	public function withResolution(int $x, ?int $y = null): Options
	{
		$option = sprintf('-r%d', $x);
		if ($y) {
			$option = sprintf('-r%dx%d', $x, $y);
		}

		return $this->withOption($option);
	}

	public function withOutputFile(Output|string $file): Options
	{
		return $this->withOption('-sOutputFile', $file);
	}

	public function useCropBox(): Options
	{
		return $this->withOption('-dUseCropBox');
	}

	public function toProcessArguments(): array
	{
		$result = [];
		foreach ($this->options as $option => $value) {
			if (is_null($value)) {
				$result[] = $option;
			} else {
				$result[] = sprintf('%s=%s', $option, $value);
			}
		}
		return $result;
	}
}