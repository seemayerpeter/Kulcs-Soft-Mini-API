<?php
header('Content-Type: text/plain');
	$route 	= $_SERVER['REQUEST_URI'];

	$route = substr($route, 1);
	$route = explode("?", $route);
	$route = explode("/", $route[0]);
	$route = array_diff($route, array('Kulcs-Soft', 'api'));
	$route = array_values($route);

	$arr = null;

	if (count($route) <= 2) {
		
		switch ($route[0]) {
			case 'user':
				include('user.class.php');
				$user = new User($_REQUEST['Action'],$_REQUEST['userId'],$_REQUEST['apiKey']);
				$arr = $user->verifyMethod();
				break;
			
			default:
				$arr = array('status' => 0);
				break;
		}

	}else{
		$arr = array('status' => 0);
	}
	switch ($_REQUEST['datatype']){
		case 'JSON':
			echo json_encode($arr);
			break;
		case 'XML':
			// could have also used XMLRPC_ENCODE but this solution produces more human readable xml
			echo xml_encode($arr);
			break;
	}

	// CREDIT - https://stackoverflow.com/questions/7609095/is-there-an-xml-encode-like-json-encode-in-php
	// Modified it a bit, to remove an unwanted feature
	function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
		if (is_null($DOMDocument)) {
			$DOMDocument =new DOMDocument;
			$DOMDocument->formatOutput = true;
			xml_encode($mixed, $DOMDocument, $DOMDocument);
			echo $DOMDocument->saveXML();
		}
		else {
			// To cope with embedded objects 
			if (is_object($mixed)) {
			  $mixed = get_object_vars($mixed);
			}
			if (is_array($mixed)) {
				foreach ($mixed as $index => $mixedElement) {
					if (is_int($index)) {
						if ($index === 0) {
							$node = $domElement;
						}
						else {
							$node = $DOMDocument->createElement($domElement->tagName);
							$domElement->parentNode->appendChild($node);
						}
					}
					else {
						$plural = $DOMDocument->createElement($index);
						$domElement->appendChild($plural);
						$node = $plural;
					}
	
					xml_encode($mixedElement, $node, $DOMDocument);
				}
			}
			else {
				$mixed = is_bool($mixed) ? ($mixed ? 'true' : 'false') : $mixed;
				$domElement->appendChild($DOMDocument->createTextNode($mixed));
			}
		}
	}


?>