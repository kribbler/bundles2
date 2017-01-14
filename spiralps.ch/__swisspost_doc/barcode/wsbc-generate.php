<?php

/*****************************************************************
 * Example for calling Webservice Barcode Operation GenerateLabel
 *****************************************************************/

include("wsbc-init.php");
include("wsbc-utils.php");

// Franking License Configuration
// TODO: you have to set this to a valid franking license for your barcode web service user account!
$frankinglicense = '60082076';

//$imgfile = 'default_logo.gif';
//$logo_binary_data = fread(fopen($imgfile, "r"), filesize($imgfile));

// 1. Define Label Request
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.1)
$generateLabelRequest = array(
    'Language' => 'de',
    'Envelope' => array(
       	'LabelDefinition' => array(
	       	'LabelLayout' => 'A5',
	        'PrintAddresses' => 'RecipientAndCustomer',
	        'ImageFileType' => 'GIF',
	        'ImageResolution' => 300,
			'PrintPreview' => false
        ),
        'FileInfos' => array(
	         'FrankingLicense' => $frankinglicense,
			 'PpFranking' => false,
	         'Customer' => array(
		         'Name1' => 'Meier AG',
         		 // 'Name2' => 'Generalagentur',
		         'Street' => 'Viktoriaplatz 10',
		         // 'POBox' => 'Postfach 600',
		         'ZIP' => '8050',
		         'City' => 'Zürich',
		         // 'Country' => 'CH',
		         // 'Logo' => $logo_binary_data,
         		 // 'LogoFormat' => 'GIF',
		         'DomicilePostOffice' => '3000 Bern'
      		 ),
			 'CustomerSystem' => 'PHP Client System'
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
								'Phone' => '0313381111', // für ZAW3213
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
							//	'Type' => 'NN_ESR_REF_REFNR',
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

									// Basic service code(s) (optional, default="ECO"):
									'PRI',
									// Additional service codes (optional)
									'N',
									'FRA',
									// Delivery instruction codes (optional)
									'ZAW3211',
									'ZAW3213'
								),

								// Cash on delivery amount in CHF for service 'N':
								'Amount' => 12.5,
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
					// Add addtional items here for multiple requests in one web service call ...
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
	$response = $SOAP_Client -> GenerateLabel($generateLabelRequest);
}
catch (SoapFault $fault) {
	echo('Error in GenerateLabel: '. $fault -> __toString() .'<br />');
}

// 3. Process requests: save label images and check for errors
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.2)
foreach (getElements($response->Envelope->Data->Provider->Sending->Item) as $item) {
	if ($item->Errors != null) {

      	// Error in Label Request Item:
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
      	$identCode = $item->IdentCode;
   		$labelBinaryData = $item->Label;

	   	// Save the binary image data to image file:
	   	$filename = 'outputfolder/testOutput_GenerateLabel_'.$identCode.'.gif';
	   	file_put_contents($filename, $labelBinaryData);

	   	// Printout some label information (and warnings, if any):
		echo '<p>Label generated successfully for identCode='.$identCode.': <br/>';
		if ($item->Warnings != null) {
			$warningMessages = "";
	      	foreach (getElements($item->Warnings->Warning) as $warning) {
	      		$warningMessages .= $warning->Message.",";
	      	}
	      	echo 'with WARNINGS: '.$warningMessages.'.<br/>';
	    }
		echo $filename.':<br/><img src="'.$filename.'"/><br/>';
		echo '</p>';
	}
}

echo "</body></html>";

?>