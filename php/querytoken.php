<?php
// *********************
// START OF MAIN PROGRAM
// *********************

// add the start of the vpcURL querystring parameters
include 'utils.php';
$onefinURL = $_POST["virtualPaymentClientURL"];

// This is the title for display

// Remove the Virtual Payment Client URL from the parameter hash as we 
// do not want to send these fields to the Virtual Payment Client.
unset($_POST["virtualPaymentClientURL"]);

// create a variable to hold the POST data information and capture it
$messageObject;

foreach ($_POST as $key => $value) {
    if (strlen($value) > 0) {
        $messageObject[$key] =  $value;
    }
}


// turn on output buffering to stop response going to browser
ob_start();
$jsonMessage = json_encode($messageObject);
$signature = signMessage($jsonMessage);

$body = new stdClass();
$body->signature = $signature;
$body->messages = $jsonMessage;

$response = curl_post($onefinURL, $body);

ob_end_clean();

// set up message paramter for error outputs
$message = "";
$map = [];
// serach if $response contains html error code
if ($response != null && isset($response->messages) && isset($response->signature)) {
    $signatureVerified = verifySignature($response->messages, $response->signature);
    if ($signatureVerified) {
        $map = json_decode($response->messages);
    } else {
        $message = "Siganture verify failed";
    }
} else {
    $message = $response->errorDTO->message || "Something wrong occured";
}

//  -----------------------------------------------------------------------------

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

//  ----------------------------------------------------------------------------

// Standard Receipt Data
# merchTxnRef not always returned in response if no receipt so get input
//TK//$merchTxnRef     = $vpc_MerchTxnRef;


$merchantCode = null2unknown($map, "merchantCode");
$memberId = null2unknown($map, "memberId");
$tokenList = null2unknown($map, "tokenList");




// Define an AMA transaction output for Refund & Capture transactions
$amaTransaction = true;

/*********************
 * END OF MAIN PROGRAM
 *********************/


// FINISH TRANSACTION - Process the VPC Response Data
// =====================================================
// For the purposes of demonstration, we simply display the Result fields on a
// web page.

// Show 'Error' in title if an error condition

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <title>Response Page</title>
    <meta http-equiv="Content-Type" content="text/html, charset=utf8">
    <style type="text/css">
        <!--
        h1 {
            font-family: Arial, sans-serif;
            font-size: 24pt;
            color: #08185A;
            font-weight: 100
        }

        h2.co {
            font-family: Arial, sans-serif;
            font-size: 24pt;
            color: #08185A;
            margin-top: 0.1em;
            margin-bottom: 0.1em;
            font-weight: 100
        }

        h3.co {
            font-family: Arial, sans-serif;
            font-size: 16pt;
            color: #000000;
            margin-top: 0.1em;
            margin-bottom: 0.1em;
            font-weight: 100
        }

        body {
            font-family: Verdana, Arial, sans-serif;
            font-size: 10pt;
            color: #08185A;
            background-color: #FFFFFF
        }

        a:link {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A
        }

        a:visited {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A
        }

        a:hover {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #FF0000
        }

        a:active {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #FF0000
        }

        tr.title {
            height: 25px;
            background-color: #0074C4
        }

        td {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A
        }

        th {
            font-family: Verdana, Arial, sans-serif;
            font-size: 10pt;
            color: #08185A;
            font-weight: bold;
            background-color: #CED7EF;
            padding-top: 0.5em;
            padding-bottom: 0.5em
        }

        input {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
            color: #08185A;
            background-color: #CED7EF;
            font-weight: bold
        }

        #background-image {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            font-size: 12px;
            width: 80%;
            text-align: left;
            border-collapse: collapse;
            background: url("...") 330px 59px no-repeat;
            margin: 20px;
        }

        #background-image th {
            font-weight: normal;
            font-size: 14px;
            color: #339;
            padding: 12px;
        }

        #background-image td {
            color: #669;
            border-top: 1px solid #fff;
            padding: 9px 12px;
        }

        #background-image tfoot td {
            font-size: 11px;
        }

        #background-image tbody td {
            background: url("./back.png");
        }

        * html #background-image tbody td {
            filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='table-images/back.png', sizingMethod='crop');
            background: none;
        }

        #background-image tbody tr:hover td {
            color: #339;
            background: none;
        }
        -->
    </style>
</head>

<body>
    <table width='100%' border='2' cellpadding='2' bgcolor='#0074C4'>
        <tr>
            <td bgcolor='#CED7EF' width='90%'>
                <h2 class='co'>&nbsp;Payment Client Example</h2>
            </td>
            <td bgcolor='#0074C4' align='center'>
                <h3 class='co'>OneFin</h3>
            </td>
        </tr>
    </table>
    <center>
        <h1>Token List</h1>
    </center>
    <center>
        <table id="background-image" summary="Meeting Results">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td align="center" colspan="4"></td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td><strong><i>Merchant Code </i></strong></td>
                    <td><?php
                        echo $merchantCode;
                        ?></td>
                    <td>Được cấp bởi OneFin</td>
                </tr>
                <tr>
                    <td><strong><i>Member ID </i></strong></td>
                    <td><?php
                        echo $memberId;
                        ?></td>
                    <td>Member Id của merchant</td>
                </tr>
                <tr>
                    <td><strong><i>Message</i></strong></td>
                    <td><?php
                        echo $message;
                        ?></td>
                    <td>Thông báo từ cổng thanh toán</td>
                </tr>
                <?php
                $colors = array("red", "green", "blue", "yellow");

                foreach ($tokenList as $key=>$value) {
                    echo "<tr> <td><strong><i>Token $key</i></strong></td><td>";
                    echo $value->cardNumber."<br />".$value->cardHolderName."<br />".$value->tokenId ;
                    echo "</td>";
                    echo "<td>Giá trị Token được lưu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </center>
</body>

</html>

<?
// End Processing

//  ----------------------------------------------------------------------------

// This method uses the QSI Response code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code
//
// @param $responseCode String containing the QSI Response Code
//
// @return String containing the appropriate description
//
function getResponseDescription($responseCode)
{

    switch ($responseCode) {
        case "0":
            $result = "Transaction Successful";
            break;
        case "?":
            $result = "Transaction status is unknown";
            break;
        case "1":
            $result = "Bank system reject";
            break;
        case "2":
            $result = "Bank Declined Transaction";
            break;
        case "3":
            $result = "No Reply from Bank";
            break;
        case "4":
            $result = "Expired Card";
            break;
        case "5":
            $result = "Insufficient funds";
            break;
        case "6":
            $result = "Error Communicating with Bank";
            break;
        case "7":
            $result = "Payment Server System Error";
            break;
        case "8":
            $result = "Transaction Type Not Supported";
            break;
        case "9":
            $result = "Bank declined transaction (Do not contact Bank)";
            break;
        case "A":
            $result = "Transaction Aborted";
            break;
        case "C":
            $result = "Transaction Cancelled";
            break;
        case "D":
            $result = "Deferred transaction has been received and is awaiting processing";
            break;
        case "F":
            $result = "3D Secure Authentication failed";
            break;
        case "I":
            $result = "Card Security Code verification failed";
            break;
        case "L":
            $result = "Shopping Transaction Locked (Please try the transaction again later)";
            break;
        case "N":
            $result = "Cardholder is not enrolled in Authentication scheme";
            break;
        case "P":
            $result = "Transaction has been received by the Payment Adaptor and is being processed";
            break;
        case "R":
            $result = "Transaction was not processed - Reached limit of retry attempts allowed";
            break;
        case "S":
            $result = "Duplicate SessionID (OrderInfo)";
            break;
        case "T":
            $result = "Address Verification Failed";
            break;
        case "U":
            $result = "Card Security Code Failed";
            break;
        case "V":
            $result = "Address Verification and Card Security Code Failed";
            break;
        default:
            $result = "Unable to be determined";
    }
    return $result;
}
