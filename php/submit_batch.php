<?php

$X_Authorization_key = mysql_real_escape_string($_POST['X_Authorization_key']);
$X_Authorization_token = mysql_real_escape_string($_POST['X_Authorization_token']);
$Postman_Token = mysql_real_escape_string($_POST['Postman_Token']);
$amount = mysql_real_escape_string($_POST['amount']);
$amountCurrency = mysql_real_escape_string($_POST['amountCurrency']);
$profile = mysql_real_escape_string($_POST['profile']);
$recipientId = mysql_real_escape_string($_POST['recipientId']);
$sourceCurrency = mysql_real_escape_string($_POST['sourceCurrency']);
$targetCurrency = mysql_real_escape_string($_POST['targetCurrency']);

$content = array($X_Authorization_key, $X_Authorization_token, $Postman_Token, $amount, 
 			$amountCurrency, $profile, $recipientId, $sourceCurrency, $targetCurrency);

$curl = curl_init();
$CURLOPT_POSTFIELDS = "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"amount\"\r\n\r\n" . $amount . " \r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"amountCurrency\"\r\n\r\n" . $amountCurrency . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"exchangeId\"\r\n\r\nfa447bea-4016-4261-af94-f7bfd8c9810a\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"isFixedRate\"\r\n\r\ntrue\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"profile\"\r\n\r\n" . $profile .  "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"recipientId\"\r\n\r\n" . $recipientId . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"refundRecipientId\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"sourceCurrency\"\r\n\r\n" . $sourceCurrency . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"sourceOfFundsOptionId\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"sourceOfFundsText\"\r\n\r\nasdf\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"targetCurrency\"\r\n\r\n" . $targetCurrency ."\r\n-----011000010111000001101001--";

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://transferwise.com/api/v1/payment/create",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=---011000010111000001101001",
    "postman-token: ebf1b139-4003-436d-867c-fd38a247573e",
    "x-authorization-key: " . $X_Authorization_key,
    "x-authorization-token: " . $X_Authorization_token
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>

