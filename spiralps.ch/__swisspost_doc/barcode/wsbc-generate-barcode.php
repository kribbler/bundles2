<?php

/*******************************************************************
 * Example for calling Webservice Barcode Operation GenerateBarcode
 *******************************************************************/

include("wsbc-init.php");
include("wsbc-utils.php");

echo "<html><header></header><body>";

// 1. Define Label Request
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.1)
$generateBarcodeRequest = array(
	'Language' => 'de',
	'BarcodeDefinition' => array(
		'BarcodeType' => 'LSO_2',
		'ImageFileType' => 'PNG',
		'ImageResolution' => 200
	)
);

// 2. Web service call
$response = null;
try {
	$response = $SOAP_Client -> GenerateBarcode($generateBarcodeRequest);
}
catch (SoapFault $fault) {
	echo('Error in GenerateBarcode: '. $fault -> __toString() .'<br />');
}

// 3. Process requests: save label images and check for errors
// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.2)
foreach (getElements($response->Data) as $data) {
	if ($data->Errors != null) {

      	// Error in Barcode Request Item:
      	// This barcode label was not generated due to errors.
      	// The received error messages are returned in the specified language of the request.
      	// This means, that the label was not generated,
      	// but other labels from other request items in same call
      	// might have been generated successfully anyway.
      	$errorMessages = "";
      	$delimiter="";
      	foreach (getElements($data->Errors->Error) as $error) {
      		$errorMessages .= $delimiter.$error->Message;
      		$delimiter=",";
      	}
      	echo "<p>ERROR for request: ".$errorMessages.'.<br/></p>';

	}
    else {
      	// Get successfully generated barcide as binary data:
		$barcodeBinaryData = $data->Barcode;
		$deliveryNoteRef = $data->DeliveryNoteRef;
      	$barcodeDefinition = $data->BarcodeDefinition;
		$barcodeType = $barcodeDefinition->BarcodeType;
		$imageFileType = $barcodeDefinition->ImageFileType;
		$imageResolution = $barcodeDefinition->ImageResolution;

	   	// Save the binary image data to image file:
	   	$filename = 'outputfolder/testOutput_GenerateBarcode_'.$deliveryNoteRef.'.gif';
	   	file_put_contents($filename, $barcodeBinaryData);

	   	// Printout some label information (and warnings, if any):
		echo '<p>Label generated successfully for Delivery Note Reference = '.$deliveryNoteRef.': <br/>';
		if ($data->Warnings != null) {
			$warningMessages = "";
	      	foreach (getElements($data->Warnings->Warning) as $warning) {
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