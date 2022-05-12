<?php declare(strict_types=1);

namespace Webit\PHPgs\Options;

final class ColorConversionStrategy
{
	private function __construct(
		private string $strategy
	) {}

	public static function leaveColorUnchanged(): ColorConversionStrategy
	{
		return new self('LeaveColorUnchanged');
	}

	public static function useDeviceIndependentColor(): ColorConversionStrategy
	{
		return new self('UseDeviceIndependentColor');
	}

	public static function gray(): ColorConversionStrategy
	{
		return new self('Gray');
	}

	public static function rgb(): ColorConversionStrategy
	{
		return new self('rgb');
	}

	public static function cmyk(): ColorConversionStrategy
	{
		return new self('CMYK');
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return $this->strategy;
	}
}