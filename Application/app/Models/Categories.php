<?php

namespace App\Models;

use App\Data\Category;

class Categories extends ValueObjectWithIdAndNameModel
{
	protected $valueObjectClassName = Category::class;
}
