<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
	protected function renderView(array $data = array(), string $methodName = '')
	{
		$templateName = sprintf(
			'%s-%s',
			strtolower(str_replace('Controller', '', $this->getClassNameWithoutNamespace(get_called_class()))),
			(!empty($methodName) ? strtolower($methodName) : strtolower($this->determineMethodNameForRenderView()))
		);
		return view($templateName, array_merge($this->getStandardDataItemsForView(), $data));
	}

	protected function determineMethodNameForRenderView(): string
	{
		return 'index'; // @todo Delete This
	}

	protected function getStandardDataItemsForView(): array
	{
		return array(
			'applicationName'   => config('app.name'),
			'pageTitle'         => config('app.name')
		);
	}

	protected function invalidIdResponse(string $invalidIdValue, string $entityType)
	{
		return view('error', array_merge($this->getStandardDataItemsForView(), array(
			'errorMessage'  => sprintf('You have provided an invalid %s ID: %s', $entityType, $invalidIdValue),
			'pageTitle'     => sprintf('Invalid %s ID', $entityType)
		)));
	}

	protected function notFoundResponse(string $entityType)
	{
		$errorMessage = sprintf('%s Not Found', $entityType);
		return view('error', array_merge($this->getStandardDataItemsForView(), array(
			'errorMessage'  => $errorMessage,
			'pageTitle'     => $errorMessage
		)));
	}
}
