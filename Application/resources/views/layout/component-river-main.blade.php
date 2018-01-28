<?php

use App\Views\FormatterFactory;
use App\Views\ValueObjectFormatter;

	if (isset($riverItems) && is_array($riverItems) && count($riverItems)) { // Check for River Items
		echo('<ul class="river">');
		foreach ($riverItems as $currentRiverItem) { // Loop through River Items
			$currentFormatter = FormatterFactory::getFormatterFromValueObject($currentRiverItem);
			if ($currentFormatter instanceof ValueObjectFormatter) { // Check for Formatter for Current River Item


				echo($currentFormatter->formatAsRiverMainItem($currentRiverItem));


			} else { // Middle of Check for Formatter for Current River Item
				echo('<li>No Formatter Found: <pre>' . print_r($currentRiverItem, true) . '</pre></li>');
			} // End of Check for Formatter for Current River Item
		} // End of Loop through River Items
		echo('</ul>');
	} else { // Middle of Check for River Items
		echo('<p class="river missing-data">There are no items to display.</p>');
	} // End of Check for River Items
