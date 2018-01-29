<?php

namespace App\Http\Controllers\Web;

use App\Data\ValueObjectWithId;
use App\Exceptions\MissingRequiredAttributeException;
use App\Models\ValueObjectWithIdModel;

abstract class ValueObjectWithIdContoller extends ValueObjectContoller
{
	protected $valueObjectClassType = ValueObjectWithId::class;

	protected $valueObjectModelType = ValueObjectWithIdModel::class;

	protected $indexPageTitle;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->validateIndexPageTitleSet();
	}

	protected function validateIndexPageTitleSet(): void
	{
		if (!empty($this->indexPageTitle)) { // Validate Index Page Title Attribute Not Empty
			if (!is_string($this->indexPageTitle)) { // Validate Index Page Title Attribute is a String
				throw new MissingRequiredAttributeException(sprintf('%s->indexPageTitle must be a string'));
			} // End of Validate Index Page Title Attribute is a String
		} else { // Middle of Validate Index Page Title Attribute Not Empty
			throw new MissingRequiredAttributeException(sprintf('%s->indexPageTitle cannot be empty'));
		} // End of Validate Index Page Title Attribute Not Empty
	}

	public function index()
	{
		return $this->renderView(array(
			'riverItems'        => (new $this->valueObjectModelType())->fetchAll(true),
			'riverFormatter'    => FormatterFactory::getFormatterFromValueObjectClassName($this->valueObjectClassType),
			'pageTitle'         => $this->indexPageTitle
		));
	}
}
