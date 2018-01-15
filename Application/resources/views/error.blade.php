@include('layout.component-header')
@include('layout.component-menu-top')
<?php 

	if (isset($errorMessage) && is_string($errorMessage) && !empty($errorMessage)) { // Check for Error Message
		echo(sprintf('<p class="error">%s</p>', $errorMessage));
	} else { // Middle of Check for Error Message
		echo('<p class="error">An error has occurred.</p>');
	} // End of Check for Error Message

?>
@include('layout.component-footer')