<?php

require_once('variables.php');

$header = array(
  'Content-Type: application/json',
  'X-API-KEY:' . APIKEY,
  'X-SANDBOX:' . SANDBOX,
);

$params = array(
  'order_id' => '101',
  'amount' => 10000,
  'phone' => '09382198592',
  'desc' => 'توضیحات پرداخت کننده',
  'callback' => URL_CALLBACK,
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, URL_PAYMENT);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result = curl_exec($ch);
curl_close($ch);

$result = json_decode($result);

if (empty($result) ||
    empty($result->link)) {

  print 'Error handeling';
  return FALSE;
}

//.Redirect to payment form
header('Location:' . $result->link);