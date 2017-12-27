<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
	abstract public function fetchAll();

	abstract public function fetchById(int $valueObjectId);
}
