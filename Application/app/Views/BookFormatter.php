<?php

namespace App\Views;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;
use App\Data\ReadingList;
use App\Data\ValueObjectWithId;

class BookFormatter extends EntityFormatter
{
	protected $valueObjectClassName = Book::class;

	protected $riverSubItemHeader = 'Book(s)';

	protected $riverMainItemSubItemsMapping = array(
		'authors'       => Author::class,
		'categories'    => Category::class,
		'readingLists'  => ReadingList::class
	);

	public function formatAsRiverMainItem(ValueObjectWithId $valueObjectWithId): string
	{
		$return = '';
		if ($valueObjectWithId instanceof $this->valueObjectClassName) { // Validate Passed Value Object
			$return  = sprintf(
				'<li class="book"><%1$s><a href="/books/%2$d">%3$s</a> (%4$s)</%1$s>',
				$this->riverMainItemTag,
				$valueObjectWithId->id,
				$valueObjectWithId->title,
				$valueObjectWithId->type
			);
			foreach ($this->riverMainItemSubItemsMapping as $valueObjectAttributeName => $valueObjectAttributeType) { // Loop through River Main Item Sub Items
				FormatterFactory::getFormatterFromValueObjectClassName($valueObjectAttributeType)->formatAsRiverSubList($valueObjectWithId->{$valueObjectAttributeName});
			} // End of Loop through River Main Item Sub Items
			$return .= '</li>';
		} // End of Validate Passed Value Object
		return $return;
	}

	public function formatAsRiverSubItem(ValueObjectWithId $valueObjectWithId): string
	{
		return '<li class="author">Insert Book (Sub Item) Here</li>';
	}
}
