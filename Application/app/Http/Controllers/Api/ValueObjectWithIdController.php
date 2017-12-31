<?php

namespace App\Http\Controllers\Api;

use App\Data\ValueObjectWithId;
use App\Models\ValueObjectWithIdModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class ValueObjectWithIdController extends ValueObjectController
{
	protected $valueObjectClassType = ValueObjectWithId::class;

	protected $valueObjectModelType = ValueObjectWithIdModel::class;

	protected $payloadIndexName;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->validatePayloadIndexNameAttribute();
	}

	protected function validatePayloadIndexNameAttribute(): void
	{
		if (empty($this->payloadIndexName) || !is_string($this->payloadIndexName)) { // Verify Payload Index Name Set
			$this->payloadIndexName = $this->getClassNameWithoutNamespace($this->valueObjectClassName);
		} // End of Verify Payload Index Name Set
	}

	protected function valueObjectOnlyDataResponse(array $responsePayloadData): JsonResponse
	{
		return $this->okResponse(array($this->payloadIndexName => $responsePayloadData));
	}

	public function index(): JsonResponse
	{
		$retrieved = (new $this->valueObjectModelName())->fetchAll($this->checkRetrieveFullyPopulatedValueObject());
		if (is_array($retrieved) && count($retrieved)) { // Check for Retrieved Entities from DB
			$return = $this->valueObjectOnlyDataResponse($this->convertArrayOfValueObjectsToArrayOfArrays($retrieved));
		} else { // Middle of Check for Retrieved Entities from DB
			$return = $this->notFoundResponse();
		} // End of Check for Retrieved Entities from DB
		return $return;
	}

	public function single($id = null): JsonResponse
	{
		if ((bool) $filteredId = static::validateNonZeroPositiveInteger((int) $id)) { // Validate Passed ID Parameter
			$retrieved = (new $this->valueObjectModelName())->fetchById($filteredId, $this->checkRetrieveFullyPopulatedValueObject());
			if ($retrieved instanceof $this->valueObjectClassName) { // Check if Entity Retrieved from DB
				$return = $this->valueObjectOnlyDataResponse(array($retrieved->toArray()));
			} else { // Middle of Check if Entity Retrieved from DB
				$return = $this->notFoundResponse();
			} // End of Check if Entity Retrieved from DB
		} else { // Middle of Validate Passed ID Parameter
			$return = $this->invalidIdResponse($id, $this->getClassNameWithoutNamespace($this->valueObjectClassName));
		} // End of Validate Passed ID Parameter
		return $return;
	}

	public function getPayloadIndexName(): string
	{
		return $this->payloadIndexName;
	}
}