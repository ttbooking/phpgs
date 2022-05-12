<?php

namespace Webit\PHPgs\Options;

final class Device
{
	private function __construct(
		private string $device
	) {}

	public static function jpeg(): Device
	{
		return new self('jpeg');
	}

	public static function png256(): Device
	{
		return new self('png256');
	}

	public static function pdfWrite(): Device
	{
		return new self('pdfwrite');
	}

	public static function any(string $device): Device
	{
		return new self($device);
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return $this->device;
	}
}
