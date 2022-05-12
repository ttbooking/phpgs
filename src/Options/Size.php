<?php declare(strict_types=1);

namespace Webit\PHPgs\Options;

final class Size
{
	public function __construct(
		private int $width, private int $height
	) {}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return sprintf('%dx%d', $this->width, $this->height);
	}
}