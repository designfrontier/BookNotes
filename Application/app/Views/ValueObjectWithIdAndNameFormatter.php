<?php

namespace App\Views;

use App\Data\ValueObjectWithIdAndName;

abstract class ValueObjectWithIdAndNameFormatter extends ValueObjectWithIdFormatter
{
	protected $valueObjectClassType = ValueObjectWithIdAndName::class;
}
