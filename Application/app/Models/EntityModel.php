<?php

namespace App\Models;

use App\Data\EntityObject;

abstract class EntityModel extends ValueObjectWithIdModel
{
	protected $valueObjectClassType = EntityObject::class;
}
