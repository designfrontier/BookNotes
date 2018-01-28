<?php

namespace App\Views;

use App\Data\Category;
use App\Data\ValueObjectWithId;

class CategoryFormatter extends ValueObjectWithIdAndNameFormatter
{
	protected $valueObjectClassName = Category::class;

	protected $riverSubItemHeader = 'Category(s)';

	public function formatAsRiverMainItem(ValueObjectWithId $valueObjectWithId): string
	{

	}

	public function formatAsRiverSubItem(ValueObjectWithId $valueObjectWithId): string
	{
		return '<li class="category">Insert Category Here</li>';
	}
}
