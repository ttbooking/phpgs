<?php declare(strict_types=1);

namespace Webit\PHPgs;

use DirectoryIterator;

final class Output implements \IteratorAggregate
{
	private function __construct(
		private string $filenameOrPattern
	) {}

	public static function create(string $filenameOrPattern): Output
	{
		return new self($filenameOrPattern);
	}

	/**
	 * @inheritdoc
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->files());
	}

	/**
	 * @return string[]
	 */
	public function files(): array
	{
		$files = array();
		foreach (new DirectoryIterator(dirname($this->filenameOrPattern())) as $file) {
			if ($file->isDot()) {
				continue;
			}
			$files[] = $file->getPathname();
		}
		sort($files, SORT_NATURAL);

		return $files;
	}

	public function filenameOrPattern(): string
	{
		return $this->filenameOrPattern;
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return $this->filenameOrPattern();
	}
}
