<?php

// *********************
// START OF MAIN PROGRAM
// *********************


include 'utils.php';

$postJson = file_get_contents('php://input');
$postData = json_decode($postJson);
// This is the title for display

$message = "";
$map = [];
// serach if $response contains html error code
if($postData != null && isset($postData->messages) && isset($postData->signature)){
    $signatureVerified = verifySignature($postData->messages, $postData->signature);
    if($signatureVerified){
        $map = json_decode($postData->messages);
		$message = "IPN Received";
    } else{
		$message = "Siganture verify failed";
	}
}else {
    $message = $postData->errorDTO->message || "Something wrong occured";
}

// If input is null, returns string "No Value Returned", else returns value corresponding to given key
function null2unknown($map, $key)
{
    if (array_key_exists($key, $map)) {
        if (!is_null($map->$key)) {
            return $map->$key;
        }
    }
    return "No Value Returned";
}


$merchantCode = null2unknown($map, "merchantCode");
$currency = null2unknown($map, "currency");
$amount = null2unknown($map, "amount");
$processingFee = null2unknown($map, "processingFee");
$trxRefNo = null2unknown($map, "trxRefNo");
$transactionId = null2unknown($map, "transactionId");
$statusId = null2unknown($map, "statusId");
$gatewayTransactionId  = null2unknown($map, "gatewayTransactionId");
$orderId = null2unknown($map, "orderId");
$paymentToken = null2unknown($map, "paymentToken");
$errorCode = null2unknown($map, "errorCode");
$errorMessage = null2unknown($map, "errorMessage");

echo $message;
// do further code here