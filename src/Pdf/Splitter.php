<?php

namespace Webit\PHPgs\Pdf;

use Webit\PHPgs\Input;
use Webit\PHPgs\Options\Options;
use Webit\PHPgs\Output;

interface Splitter
{
	public function split(
		Input $input,
		Output $output,
		?int $pageFrom = null,
		?int $pageTo = null,
		?Options $options = null
	): void;
}