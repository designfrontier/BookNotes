<?php

use App\Views\FormatterFactory;
use App\Views\ValueObjectWithIdFormatter;

	if (isset($riverFormatter) && ($riverFormatter instanceof ValueObjectWithIdFormatter)) { // Check for River Formatter
		if (isset($riverItems) && is_array($riverItems) && count($riverItems)) { // Check for River Items
			echo($riverFormatter->formatAsRiverMainList($riverItems));
		} else { // Middle of Check for River Items
			echo('<p class="river missing-data">There are no items to display.</p>');
		} // End of Check for River Items
	} else { // Middle of Check for River Formatter
		echo('<p class="river missing-formatter">Cannot display data.</p>');
	} // End of Check for River Formatter
