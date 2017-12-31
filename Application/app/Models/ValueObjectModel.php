<?php

namespace App\Models;

abstract class ValueObjectModel extends BaseModel
{
	abstract public function fetchAll();
}
