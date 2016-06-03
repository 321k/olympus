<?php

$request = new HttpRequest();
$request->setUrl('https://transferwise.com/api/v1/payment/create');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'postman-token' => 'acf103d2-4d86-9758-4253-3a916b60d52c',
  'cache-control' => 'no-cache',
  'x-authorization-token' => 'm5njb81us73uv3usi16boal3k57j7ukdfaq5ilppv784gr2n3msk',
  'x-authorization-key' => 'dad99d7d8e52c2c8aaf9fda788d8acdc',
  'content-type' => 'multipart/form-data; boundary=---011000010111000001101001'
));

$request->setBody('-----011000010111000001101001
Content-Disposition: form-data; name="amount"

12567
-----011000010111000001101001
Content-Disposition: form-data; name="amountCurrency"

source
-----011000010111000001101001
Content-Disposition: form-data; name="exchangeId"

fa447bea-4016-4261-af94-f7bfd8c9810a
-----011000010111000001101001
Content-Disposition: form-data; name="isFixedRate"

true
-----011000010111000001101001
Content-Disposition: form-data; name="profile"

business
-----011000010111000001101001
Content-Disposition: form-data; name="recipientId"

773709
-----011000010111000001101001
Content-Disposition: form-data; name="refundRecipientId"


-----011000010111000001101001
Content-Disposition: form-data; name="sourceCurrency"

GBP
-----011000010111000001101001
Content-Disposition: form-data; name="sourceOfFundsOptionId"


-----011000010111000001101001
Content-Disposition: form-data; name="sourceOfFundsText"

asdf
-----011000010111000001101001
Content-Disposition: form-data; name="targetCurrency"

EUR
-----011000010111000001101001--');

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}