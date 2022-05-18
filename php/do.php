<?php
 //Version 1.0

// *********************
// START OF MAIN PROGRAM
// *********************

include 'utils.php';

$onefinURL = $_POST["virtualPaymentClientURL"];


unset($_POST["virtualPaymentClientURL"]); 


$messageObject;

foreach($_POST as $key => $value) {
    if (strlen($value) > 0) {
        $messageObject[$key] =  $value;
    }
}

$jsonMessage = json_encode($messageObject);
$signature = signMessage($jsonMessage);

$body= new stdClass();
$body->signature = $signature;
$body->messages = $jsonMessage;

$response = curl_post($onefinURL,$body);
if($response != null && isset($response->messages) && isset($response->signature)){
    $signatureVerified = verifySignature($response->messages, $response->signature);
    if($signatureVerified){
        $responseMessage = json_decode($response->messages);
        header("Location: ".$responseMessage->paymentURL);
    }
}else{
    echo json_encode($response);
}
// *******************
// END OF MAIN PROGRAM
// *******************

