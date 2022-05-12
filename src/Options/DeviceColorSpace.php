<?php

namespace Webit\PHPgs\Options;

final class DeviceColorSpace
{
	private function __construct(
		private string $colorSpace
	) {}

	public static function gray(): DeviceColorSpace
	{
		return new self('/DeviceGray');
	}

	public static function rgb(): DeviceColorSpace
	{
		return new self('/DeviceRGB');
	}

	public static function cmyk(): DeviceColorSpace
	{
		return new self('/DeviceCMYK');
	}

	/**
	 * @inheritDoc
	 */
	public function __toString()
	{
		return $this->colorSpace;
	}
}