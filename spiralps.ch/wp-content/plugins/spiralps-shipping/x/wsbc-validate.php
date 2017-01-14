<?php

/***********************************************************************
 * Example for calling Webservice Barcode Operation ValidateCombination
 ***********************************************************************/

include("wsbc-init.php");
include("wsbc-utils.php");

echo "<html><header></header><body>";

// 1. Define Validation Request
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.2.1)
$validationRequest = array(
     'Language' => 'de',
     'Envelope' => array(
       	'LabelDefinition' => array(
	       	'LabelLayout' => 'A5'
         ),
	  'Data' => array(
	      'Provider' => array(
	         'Sending' => array(
	            'Item' => array(
   					array( // 1.Item ...
   						'ItemID' => '1',
		            	'Attributes' => array(
		            		'PRZL' => array(
				                // At least one code is required (schema validation)

			            		// Basic service code(s) (optional, default="ECO"):
				                'PRI',
				                // Additional service codes (optional)
				                'FRA',
				                'SI',
				                // Delivery instruction codes (optional)
				                'ZAW3213',
				                'ZAW3215',
		            		)
		            	)
		            ),
	            // Add additional items here for multiple requests in one web service call ...
	            // array( // 2.Item ...
	            //		... // same structure as above
	            //	),
	   ))))));

// 2. Web service call
try {
	$response = $SOAP_Client -> ValidateCombination($validationRequest);
}
catch (SoapFault $fault) {
	echo('Error in ValidateCombination: '. $fault -> __toString() .'<br />');
}

// 3. Process response
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.2.2)
foreach (getElements($response->Envelope->Data->Provider->Sending->Item) as $item) {
	if ($item->Errors != null) {

      	// Errors in validation ...
		// (error messages are returned in the requested language)
      	$errorMessages = "";
      	foreach (getElements($item->Errors->Error) as $error) {
      		$errorMessages .= $error->Message.',';
      	}
      	echo '<p>Validation-ERROR for item with itemID='.$item->ItemID.": ".$errorMessages.'.<br/></p>';
	}
    else {
	   	// Successful validation
		echo '<p>Validation was successfull for service code combination in item with itemID='.$item->ItemID.'.<br/></p>';

		// Also display warnings
		if ($item->Warnings != null) {
			$warningMessages = "";
	      	foreach (getElements($item->Warnings->Warning) as $warning) {
	      		$warningMessages .= $warning->Message.",";
	      	}
	      	echo 'with WARNINGS: '.$warningMessages.'.<br/>';
	    }
	}
}

echo "</body></html>";

?>