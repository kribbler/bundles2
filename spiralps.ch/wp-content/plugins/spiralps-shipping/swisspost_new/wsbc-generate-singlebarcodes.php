<?php

/**************************************************************************
 * Example for calling Webservice Barcode Operation GenerateSingleBarcodes
 **************************************************************************/

include("wsbc-init.php");
include("wsbc-utils.php");

echo "<html><header></header><body>";

// Franking License Configuration
// TODO: you have to set this to a valid franking license for your barcode web service user account!
$frankinglicense = '60082076';

// 1. Define Label Request
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.1)
$generateSingleBarcodesRequest = array(
    'Language' => 'de',
    'Envelope' => array(
       	'BarcodeDefinition' => array(
	        'ImageFileType' => 'PNG',
	        'ImageResolution' => 300
        ),
        'FileInfos' => array(
	         'FrankingLicense' => $frankinglicense,
			 'PpFranking' => true,
	         'Customer' => array(
		         'Name1' => 'Meier AG',
         		 // 'Name2' => 'Generalagentur',
		         'Street' => 'Viktoriaplatz 10',
		         // 'POBox' => 'Postfach 600',
		         'ZIP' => '8050',
		         'City' => 'Zürich',
		         // 'Country' => 'CH',
		         'DomicilePostOffice' => '3000 Bern'
      		 ),
		),
		'Data' => array(
			'Provider' => array(
				'Sending' => array(
	            	//'SendingID' => 'auftragsreferenz',
					'Item' => array(
						array( // 1.Item ...
							'ItemID' => '1234',
							// 'ItemNumber' => '12345678',
							// 'IdentCode' => '1234',
							'Recipient' => array(
								//'PostIdent' => 'IdentCodeUser',
								'Title' => 'Frau',
								'Vorname' => 'Melanie',
								'Name1' => 'Steiner',
								//'Name2' => 'Müller AG',
								'Street' => 'Viktoriastrasse',
								'HouseNo' => '21',
								//'FloorNo' => '1',
								//'MailboxNo' => '1111',
								'ZIP' => '3030',
								'City' => 'Bern 1',
								//'Country' => 'CH',
								//'Phone' => '0313381111', // für ZAW3213
								//'Mobile' => '0793381111',
								'EMail' => 'h.muster@post.ch'
								//'LabelAddress' => array(
								//	'LabelLine' => array('LabelLine 1',
								//						 'LabelLine 2',
								//						 'LabelLine 3',
								//						 'LabelLine 4',
								//						 'LabelLine 5'
								//						)
								//)
							),
							//'AdditionalINFOS' => array(
							// Cash-On-Delivery amount in CHF for service 'BLN':
							//	'AdditionalData' => array(
							//  	'Type' => 'NN_BETRAG',
							//		'Value' => '12.5'
							//	),
														
							// Cash-On-Delivery example for 'BLN' with ESR:
							//	AdditionalData' => array(
							//	'Type' => 'NN_ESR_REFNR',
							//	'Value' => '965993000000000000001237460' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_ESR_KNDNR',
							//	'Value' => '010003757' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_CUS_EMAIL',
							//	'Value' => 'hans.muster@mail.ch' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_CUS_MOBILE',
							//	'Value' => '0791234567' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_CUS_PHONE',
							//	'Value' => '0311234567' 
							//	),		
							
							// Cash-On-Delivery example for 'BLN' with IBAN:
							//	AdditionalData' => array(
							//	'Type' => 'NN_IBAN',
							//	'Value' => 'CH10002300A1023502601' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_END_NAME_VORNAME',
							//	'Value' => 'Hans Muster' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_END_STRASSE',
							//	'Value' => 'Musterstrasse 11' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_END_PLZ',
							//	'Value' => '3011' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_END_ORT',
							//	'Value' => 'Bern' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_CUS_EMAIL',
							//	'Value' => 'hans.muster@mail.ch' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_CUS_MOBILE',
							//	'Value' => '0791234567' 
							//	),
							//  AdditionalData' => array(
							//	'Type' => 'NN_CUS_PHONE',
							//	'Value' => '0311234567' 
							//	),
							//),
							'Attributes' => array(
								'PRZL' => array(
									// At least one code is required (schema validation)
									'eAR',
									'RINL'
								),
								// Cash on delivery amount in CHF for service 'N':
								// 'Amount' => 12.5,
								'FreeText' => 'Freitext',
								// 'DeliveryDate' => '2010-06-19',
								// 'ParcelNo' => 2,
								// 'ParcelTotal' => 5,
								// 'DeliveryPlace' => 'Vor der Haustüre',
								'ProClima' => true
							)
							//'Notification' => array(
							//	// Notification structure ...
							//)
							)
					//,
					// Add additional items here for multiple requests in one web service call ...
					// array( // 2.Item ...
					//		... // same structure as above
					//	),
					)
				)
			)
		)
	)
);

// 2. Web service call
$response = null;
try {
	$response = $SOAP_Client -> GenerateSingleBarcodes($generateSingleBarcodesRequest);
}
catch (SoapFault $fault) {
	echo('Error in GenerateSingleBarcodes: '. $fault -> __toString() .'<br />');
}

// 3. Process requests: save label images and check for errors
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.2)
foreach (getElements($response->Envelope->Data->Provider->Sending->Item) as $item) {
	if ($item->Errors != null) {

      	// Error in Single  Request Item:
      	// This barcode label was not generated due to errors.
      	// The received error messages are returned in the specified language of the request.
      	// This means, that the label was not generated,
      	// but other labels from other request items in same call
      	// might have been generated successfully anyway.
      	$errorMessages = "";
      	$delimiter="";
      	foreach (getElements($item->Errors->Error) as $error) {
      		$errorMessages .= $delimiter.$error->Message;
      		$delimiter=",";
      	}
      	echo '<p>ERROR for item with itemID='.$item->ItemID.": ".$errorMessages.'.<br/></p>';

	}
    else {
      	// Get successfully generated label as binary data:
		$itemID = $item->IdentID;
      	$identCode = $item->IdentCode;

		$counter = 1;
		$basePath = 'outputfolder/testOutput_GenerateSingleBarcodes_'.$identCode.'_';
		foreach (getElements($item->Barcodes->Barcode) as $barcode) {
			// Save the binary image data to image file:
			$filename = ''.$basePath.''.$counter.'.gif';
			file_put_contents($filename, $barcode);
			$counter++;
		}
		$numberOfItems = $counter - 1;

	   	// Printout some label information (and warnings, if any):
		echo '<p>'.$numberOfItems.'Barcodes successfully generated for identCode='.$identCode.': <br/>';
		if ($item->Warnings != null) {
			$warningMessages = "";
	      	foreach (getElements($item->Warnings->Warning) as $warning) {
	      		$warningMessages .= $warning->Message.",";
	      	}
	      	echo 'with WARNINGS: '.$warningMessages.'.<br/>';
	    }
		echo 'All files start with: <br/><img src="'.$basePath.'"/><br/>';
		echo '</p>';
	}
}

echo "</body></html>";

?>