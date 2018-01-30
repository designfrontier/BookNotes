<?php

namespace App\Models;

use App\Data\Publisher;
use App\Data\ValueObjectWithId;

class PublishersModel extends ValueObjectWithIdAndNameModel
{
	protected $table = 'publishers';
	
	protected $valueObjectClassName = Publisher::class;

	protected function populateValueObjectWithId(ValueObjectWithId $publisherToPopulate): ValueObjectWithId
	{
		// @todo Consider Moving this Functionality to Entity Object Itself
		if ($publisherToPopulate instanceof Publisher) { // Validate Passed Publisher Parameter
			$publisherToPopulate->addBooks((new BooksModel())->fetchPublisherBooks($publisherToPopulate));
		} // End of Validate Passed Publisher Parameter
		return $publisherToPopulate;
	}
}
