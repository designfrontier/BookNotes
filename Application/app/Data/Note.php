<?php

namespace App\Data;

use App\Exceptions\MissingRequiredParameterException;

class Note extends EntityObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
			if (isset($rawData['note']) && !empty($rawData['note'])) { // Validate Required Title Parameter
				$return['note'] = (string) $rawData['note'];
			} else { // Middle of Validate Required Title Parameter
				\Log::debug(sprintf('%s::%s() - Missing required note parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
				throw new MissingRequiredParameterException('Missing required note parameter');
			} // End of Validate Required Title Parameter
			if (isset($rawData['book_id']) && !empty($rawData['book_id'])) { // Validate Required Title Parameter
				if (false !== ($validatedId = static::validateNonZeroPositiveInteger($rawData['book_id']))) { // Check ID Validation
					$return['bookId'] = $validatedId;
				} else { // Middle of Check ID Validation
					\Log::debug(sprintf('%s::%s() - Invalid book ID parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
					throw new InvalidParameterException(sprintf('Invalid book ID parameter value: %s', print_r($rawData['book_id'], true)));
				} // End of Check ID Validation
			} else { // Middle of Validate Required Title Parameter
				\Log::debug(sprintf('%s::%s() - Missing required book ID parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
				throw new MissingRequiredParameterException('Missing required book ID parameter');
			} // End of Validate Required Title Parameter


			// @todo Add Validation of Parent Note ID
			// @todo Add Validation of Chapter
			// @todo Add Validation of Section
			// @todo Add Validation of Created


		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'note'              => null,
			'bookId'            => null,
			'parentNoteId'      => null,
			'chapter'           => null,
			'section'           => null,
			'created'           => null
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('bookId', 'created'));
	}

	public function __toString(): string
	{
		return $this->data['note'];
	}
}