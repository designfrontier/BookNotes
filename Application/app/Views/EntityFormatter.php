<?php

namespace App\Views;

use App\Data\EntityObject;

abstract class EntityFormatter extends ValueObjectWithIdFormatter
{
	protected $valueObjectClassType = EntityObject::class;
}
