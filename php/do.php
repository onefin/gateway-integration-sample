<?php
 //Version 1.0

// *********************
// START OF MAIN PROGRAM
// *********************

include 'utils.php';

// add the start of the vpcURL querystring parameters
$onefinURL = $_POST["virtualPaymentClientURL"];

// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
unset($_POST["virtualPaymentClientURL"]); 

// The URL link for the receipt to do another transaction.
// Note: This is ONLY used for this example and is not required for 
// production code. You would hard code your own URL into your application.

// Get and URL Encode the AgainLink. Add the AgainLink to the array
// Shows how a user field (such as application SessionIDs) could be added

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

