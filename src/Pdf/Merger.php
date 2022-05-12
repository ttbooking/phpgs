<?php declare(strict_types=1);

namespace Webit\PHPgs\Pdf;

use Webit\PHPgs\Input;
use Webit\PHPgs\Options\Options;
use Webit\PHPgs\Output;

interface Merger
{
	public function merge(Input $input, Output $output, ?Options $options = null): void;
}