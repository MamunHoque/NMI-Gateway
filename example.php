<?php
require __DIR__ . '/nmigateway.php';

$nmi = new NMI_Gateway;

//$ccnumber,$ccexp,$cvv,$amount,$firstname,$lastname

$sell = $nmi->sell('4111111111111111', '0711', '999', '10.00');

if ($sell['response'] == 1 && $sell['responsetext'] == 'SUCCESS' && $sell['response_code'] == 100) {
	echo "sell succesful!";
	print_r($sell);
	//save the transaction ID in the database
} else {
	echo "sell failed";
	print_r($sell);
}