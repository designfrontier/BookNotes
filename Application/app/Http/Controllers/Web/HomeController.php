<?php

namespace App\Http\Controllers\Web;

use App\Models\BooksModel;

class HomeController extends BaseController
{
	public function index()
	{
		return $this->renderView(array(
			'books'     => (new BooksModel())->fetchAll(true),
			'version'   => \App::version(),
			'pageTitle' => 'Not a Fan of these Puppies' // @todo Delete This
		));
	}
}
