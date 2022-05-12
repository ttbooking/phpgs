<?php declare(strict_types=1);

namespace Webit\PHPgs;

use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
	protected function randomPathname(): string
	{
		return sprintf('%s/%s', sys_get_temp_dir(), $this->randomString());
	}

	protected function randomString(): string
	{
		return md5((string)mt_rand(0, 1000));
	}
}