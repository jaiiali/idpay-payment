<?php

require_once('variables.php');

if (empty($_POST['status']) ||
    empty($_POST['id']) ||
    empty($_POST['track_id']) ||
    empty($_POST['order_id']) ||
    empty($_POST['amount']) ||
    empty($_POST['amount'])) {

  return FALSE;
}

if ($_POST['status'] != 100) {
  return FALSE;
}

// if $_POST['id'] was not in the database return FALSE


$header = array(
  'Content-Type: application/json',
  'X-API-KEY:' . APIKEY,
  'X-SANDBOX:' . SANDBOX,
);

$params = array(
  'id' => $_POST['id'],
  'order_id' => $_POST['order_id'],
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, URL_INQUIRY);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$result = curl_exec($ch);
curl_close($ch);

$result = json_decode($result);

if (empty($result) ||
    empty($result->status)) {

  print 'Error handeling';
  return FALSE;
}

switch ($result->status) {
  case 1:
    print 'پرداخت انجام نشده است';
    return;

  case 2:
    print 'پرداخت ناموفق بوده است';
    return;

  case 3:
    print 'خطا رخ داده است';
    return;

  case 100:
    print 'پرداخت تایید شده است';
    return;

  default:
    print 'Error handeling';
    return;
}