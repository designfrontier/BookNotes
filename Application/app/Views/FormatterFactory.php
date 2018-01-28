<?php

namespace App\Views;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;
use App\Data\ReadingList;
use App\Data\ValueObject;

class FormatterFactory
{
	static protected $formatterClassNames = array(
		AuthorFormatter::class,
		BookFormatter::class,
		CategoryFormatter::class,
		ReadingListFormatter::class
	);

	static protected $valueObjectToFormatterMapping = array(
		Author::class       => AuthorFormatter::class,
		Book::class         => BookFormatter::class,
		Category::class     => CategoryFormatter::class,
		ReadingList::class  => ReadingListFormatter::class
	);

	static protected $formatterRegistry = array();

	static public function getFormatterFromClassName(string $formatterFullyNamespacedClassName): ?ValueObjectFormatter
	{
		$return = null;
		if (in_array($formatterFullyNamespacedClassName, static::$formatterClassNames)) { // Validate Formatter Class Name
			if (!empty(static::$formatterRegistry[$formatterFullyNamespacedClassName])) { // Check Registry for Existing Instance
				$return = static::$formatterRegistry[$formatterFullyNamespacedClassName];
			} else { // Middle of Check Registry for Existing Instance
				$return = static::$formatterRegistry[$formatterFullyNamespacedClassName] = new $formatterFullyNamespacedClassName();
			} // End of Check Registry for Existing Instance
		} // End of Validate Formatter Class Name
		return $return;
	}

	static public function getFormatterFromValueObjectClassName(string $valueObjectFullyNamespacedClassName): ?ValueObjectFormatter
	{
		$return = null;
		if (!empty($valueObjectFullyNamespacedClassName) && !empty(static::$valueObjectToFormatterMapping[$valueObjectFullyNamespacedClassName])) { // Check for Known Mapping
			$return = static::getFormatterFromClassName(static::$valueObjectToFormatterMapping[$valueObjectFullyNamespacedClassName]);
		} // End of Check for Known Mapping
		return $return;
	}

	static public function getFormatterFromValueObject(ValueObject $valueObject): ?ValueObjectFormatter
	{
		$return = null;
		if ($formatterClassName = static::determineFormatterFromValueObject($valueObject)) { // Check for Known Mapping
			$return = static::getFormatterFromClassName($formatterClassName);
		} // End of Check for Known Mapping
		return $return;
	}

	static public function determineFormatterFromValueObject(ValueObject $valueObject): ?string
	{
		return static::determineFormatterFromValueObjectClassName(get_class($valueObject));
	}

	static public function determineFormatterFromValueObjectClassName(string $valueObjectFullyNamespacedClassName): ?string
	{
		$return = null;
		if (!empty($valueObjectFullyNamespacedClassName) && !empty(static::$valueObjectToFormatterMapping[$valueObjectFullyNamespacedClassName])) { // Check for Known Mapping
			$return = static::$valueObjectToFormatterMapping[$valueObjectFullyNamespacedClassName];
		} // End of Check for Known Mapping
		return $return;
	}

	protected function __construct()
	{
	}
}
