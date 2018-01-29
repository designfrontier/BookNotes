<?php

namespace App\Data;

class Category extends ValueObjectWithIdAndName
{
	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'name'              => null,
			'parentCategory'    => null
		));
	}
}
