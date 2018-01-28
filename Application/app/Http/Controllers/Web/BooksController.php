<?php

namespace App\Http\Controllers\Web;

use App\Data\Book;
use App\Models\BooksModel;

class BooksController extends BaseController
{
	protected $valueObjectClassName = Book::class;

	public function index()
	{
		return $this->renderView(array(
			'riverItems'    => (new BooksModel())->fetchAll(true),
			'version'       => \App::version(),
			'pageTitle'     => 'Browse Books'
		));

	}

	public function single($id = null)
	{
		return '<p>Working on it.</p>'; // @todo Delete This

		if ((bool) $filteredId = static::validateNonZeroPositiveInteger((int) $id)) { // Validate Passed ID Parameter
			$retrieved = (new $this->valueObjectModelName())->fetchById($filteredId, $this->checkRetrieveFullyPopulatedValueObject());
			if ($retrieved instanceof $this->valueObjectClassName) { // Check if Entity Retrieved from DB

				// @todo Construct Return Value
				$return = '<p>Working on it.</p>';
//				$return = $this->valueObjectOnlyDataResponse(array($retrieved->toArray()));

			} else { // Middle of Check if Entity Retrieved from DB
				$return = $this->notFoundResponse();
			} // End of Check if Entity Retrieved from DB
		} else { // Middle of Validate Passed ID Parameter
			$return = $this->invalidIdResponse($id, $this->getClassNameWithoutNamespace($this->valueObjectClassName));
		} // End of Validate Passed ID Parameter
		return $return;
	}
}
