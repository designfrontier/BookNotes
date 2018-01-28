<?php

namespace App\Views;

use App\Data\ValueObjectWithId;
use App\Exceptions\MissingRequiredAttributeException;

abstract class ValueObjectWithIdFormatter extends ValueObjectFormatter
{
	protected $valueObjectClassType = ValueObjectWithId::class;

	protected $riverSubItemHeader;

	protected $riverSubItemHeaderTag = 'h4';

	protected $riverMainItemTag = 'h3';

	public function __construct()
	{
		$this->validateValueObjectClassAttributes();
		$this->validateRiverSubItemHeaderAttribute();
	}

	protected function validateRiverSubItemHeaderAttribute(): void
	{
		if (!empty($this->riverSubItemHeader)) { // Validate River Sub Item Header Present
			if (!is_string($this->riverSubItemHeader)) { // Validate River Sub Item Header Is a String
				throw new MissingRequiredAttributeException(sprintf('%s->riverSubItemHeader must be a string', get_called_class()));
			} // End of Validate River Sub Item Header Is a String
		} else { // Middle of Validate River Sub Item Header Present
			throw new MissingRequiredAttributeException(sprintf('%s->riverSubItemHeader cannot be empty', get_called_class()));
		} // End of Validate River Sub Item Header Present
	}

	abstract public function formatAsRiverMainItem(ValueObjectWithId $valueObjectWithId): ?string;

	public function formatAsRiverSubList(array $arrayOfRiverSubItems): ?string
	{
		$return = null;
		if (count($arrayOfRiverSubItems) > 0) { // Check for River Sub Items
			$validRiverSubItems = 0;
			$htmlString = sprintf('<%1$s>%2$s</%1$s><ul>', $this->riverSubItemHeaderTag, $this->riverSubItemHeader);
			foreach ($arrayOfRiverSubItems as $currentRiverSubItem) { // Loop through River Sub Items
				if ($currentRiverSubItem instanceof $this->valueObjectClassName) { // Validate Current River Sub Item Data Type
					$validRiverSubItems++;
					$htmlString .= $this->formatAsRiverSubItem($currentRiverSubItem);
				} // End of Validate Current River Sub Item Data Type
			} // End of Loop through River Sub Items
			if ($validRiverSubItems > 0) { // Check for Valid River Sub Items
				$return = $htmlString . '</ul>';
			} // End of Check for Valid River Sub Items
		} // End of Check for River Sub Items
		return $return;
	}

	abstract public function formatAsRiverSubItem(ValueObjectWithId $valueObjectWithId): ?string;
}
