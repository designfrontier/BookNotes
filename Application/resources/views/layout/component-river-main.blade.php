<?php

	if (isset($riverItems) && is_array($riverItems) && count($riverItems)) { // Check for River Items
		echo('<p>Display Dat Shit!</p>'); // @todo Loop Through & Display River
	} else { // Middle of Check for River Items
		echo('<p class="river missing-data">There are no items to display.</p>');
	} // End of Check for River Items
