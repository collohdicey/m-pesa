<?php
// declare variables
$consumerKey = 'yGq4s18LSbNb38iVczvUAgX7HpLp6xCl';
$consumerSecret = 'b3EIQYhcVdanDHnr';
$shortcode='603021';
$amount='1';
$phone='254708374149';
//get access token
function generateToken()
{
  $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $url);
   $credentials = base64_encode('ToO5SO5ncy1Ru9oSpbCBRsUEfH9idEYy:fg51hQnivrlGlTMF');
   curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

   $curl_response = curl_exec($curl);
   $json_decode = json_decode($curl_response);
   $access_token = $json_decode->access_token;

   return $access_token;
}
//register urls
function registerURL($shortcode)
{
  $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.generateToken()));

  $curl_post_data = array(
    'ShortCode' => $shortcode,
    'ResponseType' => 'Completed',
    'ConfirmationURL' => 'http://demo.njoka.net/payment/confirmation/',
    'ValidationURL' => 'http://demo.njoka.net/payment/validation/'
  );

  $data_string = json_encode($curl_post_data);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

  $curl_response = curl_exec($curl);

  return $curl_response;
}

function simulatC2B($amount, $phone)
{
    global $shortcode;
  $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.generateToken()));

    $curl_post_data = array(
           'ShortCode' => $shortcode,
           'CommandID' => 'CustomerPayBillOnline',
           'Amount' => $amount,
           'Msisdn' => $phone,
           'CallBackURL' => 'http://demo.njoka.net/payment/callback/',
           'BillRefNumber' => '00000'
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);

    return $curl_response;
}

function payment()
{
  $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

  $amount='4';
  $BusinessShortCode = 174379;
  $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
  $date = new DateTime();
  $timestamp = $date->format('YmdHis');
  $password=base64_encode($BusinessShortCode.$LipaNaMpesaPasskey.$timestamp);
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.generateToken()));

  $curl_post_data = array(
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => '1',
    'PartyA' => '254719578752',
    'PartyB' => '174379',
    'PhoneNumber' => '254719578752',
    'CallBackURL' => 'http://demo.njoka.net/payment/callback/',
    'AccountReference' => 'testing',
    'TransactionDesc' => 'test'
  );

  $data_string = json_encode($curl_post_data);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

  $curl_response = curl_exec($curl);

  return $curl_response;
}
 ?>
