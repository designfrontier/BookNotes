<?php

namespace App\Views;

use App\Data\Author;
use App\Data\ValueObjectWithId;

class AuthorFormatter extends EntityFormatter
{
	protected $valueObjectClassName = Author::class;

	protected $riverSubItemHeader = 'Author(s)';

	public function formatAsRiverMainItem(ValueObjectWithId $valueObjectWithId): ?string
	{

	}

	public function formatAsRiverSubItem(ValueObjectWithId $valueObjectWithId): ?string
	{
		$return = null;
		if ($valueObjectWithId instanceof $this->valueObjectClassName) { // Validate Passed Value Object Parameter
			$return = sprintf(
				'<li><a href="/authors/%d">%s</a>',
				$valueObjectWithId->id,
				$valueObjectWithId
			);
			foreach ($valueObjectWithId->contributionTypes as $currentContributionType) { // Loop through Author Contribution Types
				$return .= sprintf(' (%s)', $currentContributionType);
			} // End of Loop through Author Contribution Types
			$return .= '</li>';
		} // End of Validate Passed Value Object Parameter
		return $return;
	}
}
