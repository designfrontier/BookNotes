<?php

namespace App\Data;

use App\Exceptions\InvalidUsage;

class Category extends ValueObjectWithIdAndName
{
	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'parentCategory'    => null,
			'books'             => array()
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('parentCategory', 'books'));
	}

	protected function set_parentCategory(Category $parentCategory): Category
	{
		if ($this->data['id'] == $parentCategory->id) { // Validate that Parent Category is Not the Same as This Category
			\Log::debug(sprintf('%s::%s() - Attempting to set category as its own parent', get_called_class(), __FUNCTION__), array('Category Data' => $this->toArray(), 'Parent Category Data' => $parentCategory->toArray()));
			throw new InvalidUsage('Cannot set category to be its own parent');
		} // End of Validate that Parent Category is Not the Same as This Category
		return $this->data['parentCategory'] = $parentCategory;
	}

	public function addBooks(array $booksToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($booksToAdd, 'books', Book::class);
	}
}
