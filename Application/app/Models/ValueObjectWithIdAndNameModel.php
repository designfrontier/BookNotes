<?php

namespace App\Models;

use App\Data\ValueObjectWithIdAndName;

abstract class ValueObjectWithIdAndNameModel extends ValueObjectWithIdModel
{
	protected $valueObjectClassType = ValueObjectWithIdAndName::class;
}
