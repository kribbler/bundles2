<?php

/***************************************************************
 * Example for calling Webservice Barcode Read Operations
 * For getting all available service codes and label layouts
 **************************************************************/

include("wsbc-init.php");
include("wsbc-utils.php");

// covered requests:
// 1. ReadServiceGroups
// 2.1 ReadBasicServices
// 2.1.1 ReadAdditionalServices
// 2.1.2 ReadDeliveryInstructions
// 2.1.3 ReadLabelLayouts
// 3. ReadAllowedServicesByFrankingLicense

echo "<html><header></header><body>";

//
// 1. Read all service groups
$serviceGroupsRequest = array('Language' => 'de');
try {
	$serviceGroupsResponse = $SOAP_Client -> ReadServiceGroups($serviceGroupsRequest);
}
catch (SoapFault $fault) {
	echo('Error in ReadServiceGroups: '. $fault -> __toString() .'<br />');
	exit;
}

echo "<h1>Read Services Test Execution</h1>";
echo "<br/>";
echo "<br/>";

//
// 2. For each service group: read and display service codes and label layouts
foreach (getElements($serviceGroupsResponse->ServiceGroup) as $group) {
	echo "<b>Available service codes and layouts for Service-Group '".$group->Description."'</b>";
	echo "<br/>";
	echo "<br/>";

	//
	// 2.1. Basic services for service group
	$basicServicesRequest = array('Language' => 'de', 'ServiceGroupID' => $group->ServiceGroupID);
	try {
		$basicServicesResponse = $SOAP_Client -> ReadBasicServices($basicServicesRequest);
	}
	catch (SoapFault $fault) {
		echo('Error in ReadBasicServices: '. $fault -> __toString() .'<br />');
		exit;
	}
	echo "Basic Services:";
	echo "<ul>";
	foreach (getElements($basicServicesResponse->BasicService) as $basicService) {
		echo "<li>";
		$basicServiceCodes = getElements($basicService->PRZL);
		echo toCommaSeparatedString($basicServiceCodes);

		//
		// 2.1.1. Additional services for basic service
		$additionalServicesRequest = array('Language' => 'de', 'PRZL' => $basicServiceCodes);
		try {
			$additionalServicesResponse = $SOAP_Client -> ReadAdditionalServices($additionalServicesRequest);
		}
		catch (SoapFault $fault) {
			echo('Error in ReadAdditonalServices: '. $fault -> __toString() .'<br />');
			exit;
		}
		echo "<ul>";
		echo "<li>Additional service codes: ";
		$delimiter="";
		foreach (getElements($additionalServicesResponse->AdditionalService) as $additionalService) {
			echo $delimiter.$additionalService->PRZL;
			$delimiter =",";
		}
		echo "</li>";
		echo "</ul>";
		// 2.1.1.
		//

		//
		// 2.1.2. Delivery instructions for basic service
		$deliveryInstructionsRequest = array('Language' => 'de', 'PRZL' => $basicServiceCodes);
		try {
			$deliveryInstructionsResponse = $SOAP_Client -> ReadDeliveryInstructions($deliveryInstructionsRequest);
		}
		catch (SoapFault $fault) {
			echo('Error in ReadDeliveryInstructions: '. $fault -> __toString() .'<br />');
			exit;
		}

		echo "<ul>";
		echo "<li>Delivery instruction codes: ";
		$delimiter="";
		foreach (getElements($deliveryInstructionsResponse->DeliveryInstructions) as $deliveryInstruction) {
			echo $delimiter.$deliveryInstruction->PRZL;
			$delimiter =",";
		}
		echo "</li>";
		echo "</ul>";
		// -- 2.1.2.
		//

		//
		// 2.1.3. Label layouts for basic service
		$labelLayoutsRequest = array('Language' => 'de', 'PRZL' => $basicServiceCodes);
		try {
			$labelLayoutsResponse = $SOAP_Client -> ReadLabelLayouts($labelLayoutsRequest);
		}
		catch (SoapFault $fault) {
			echo('Error in ReadLabelLayouts: '. $fault -> __toString() .'<br />');
			exit;
		}

		echo "<ul>";
		echo "<li>Label Layouts: ";
		// elements
		echo "<ul>";
		foreach (getElements($labelLayoutsResponse->LabelLayout) as $labelLayout) {
			echo "<li>";
			echo $labelLayout->LabelLayout.": ";
			echo "max. ".$labelLayout->MaxServices." services ";
			echo "and ".$labelLayout->MaxDeliveryInstructions." delivery instructions, ";
			if ($labelLayout->FreeTextAllowed) {
				echo "freetext allowed";
			}
			else {
				echo "freetext not allowed";
			}
			echo "</li>";
		}
		echo "</ul>";
		// -- elements
		echo "</li>";
		echo "</ul>";
		// -- 2.1.3.
		//

		echo "</li>";
	}
	echo "</ul>";

}

echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<h1>Allowed Services By Franking License 60022220</h1>";

//
// 3. Read allowed services by franking license
$allowedServicesRequest = array('FrankingLicense' => '60082076', 'Language' => 'de');
try {
	$allowedServicesResponse = $SOAP_Client -> ReadAllowedServicesByFrankingLicense($allowedServicesRequest);
}
catch (SoapFault $fault) {
	echo('Error in ReadAllowedServicesByFrankingLicense: '. $fault -> __toString() .'<br />');
	exit;
}

echo "<ul>";
foreach (getElements($allowedServicesResponse->ServiceGroups) as $serviceGroup) {
	echo "<li>";
	echo "ServiceGroup: ".$serviceGroup->ServiceGroup->ServiceGroupID.", ".$serviceGroup->ServiceGroup->Description."";
	echo "<ul>";
	foreach (getElements($serviceGroup->BasicService) as $basicService) {
		echo "<li>";
		$przls = count($basicService->PRZL);
		if ($przls > 1) {
			echo "BasicService: ".$basicService->Description.": ".toCommaSeparatedString($basicService->PRZL)."";
		} else {
			echo "BasicService: ".$basicService->Description.": ".$basicService->PRZL."";
		}
		echo "</li>";
	}
	echo "</ul>";
	echo "</li>";
	echo "<br/>";
}
echo "</ul>";

echo "</body></html>";

?>