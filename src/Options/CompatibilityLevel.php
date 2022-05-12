<?php declare(strict_types=1);

namespace Webit\PHPgs\Options;

final class CompatibilityLevel
{
	private function __construct(
		private string $level
	) {}

	public static function level13(): CompatibilityLevel
	{
		return new self('1.3');
	}

	public static function level14(): CompatibilityLevel
	{
		return new self('1.4');
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return $this->level;
	}
}