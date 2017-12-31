<?php

namespace App\Http\Controllers\Api;

use App\Data\ReadingList;
use App\Models\BooksModel;
use App\Models\ReadingListsModel;
use Illuminate\Http\JsonResponse;

class ReadingListsController extends ValueObjectWithIdAndNameController
{
	protected $valueObjectClassName = ReadingList::class;

	protected $valueObjectModelName = ReadingListsModel::class;

	public function getReadingListsFromBookId($id = null): JsonResponse
	{
		return $this->lookupCurrentValueObjectFromRetrievalValueObjectId((int) $id, new BooksModel(), 'fetchBookReadingLists');
	}
}
