<?php declare(strict_types=1);

namespace Webit\PHPgs;

use ArrayIterator;
use IteratorAggregate;

final class Input implements IteratorAggregate
{
	/** @param string[] $files */
	private function __construct(
		private array $files
	) {}

	public static function singleFile(string $file): Input
	{
		return new self(array($file));
	}

	/** @param string[] $files */
	public static function multipleFiles(array $files): Input
	{
		return new self($files);
	}

	/**
	 * @inheritdoc
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->files);
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		$files = array();
		foreach ($this->files() as $file) {
			$files[] = escapeshellarg($file);
		}

		return implode(' ', $files);
	}

	/**
	 * @return string[]
	 */
	public function files(): array
	{
		return $this->files;
	}
}
