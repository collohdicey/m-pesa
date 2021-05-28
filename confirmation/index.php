<?php
$headers = ['Content-Type:application/json'];
$response = '{
  "ResultCode": 0,
  "ReseultDesc": "Confirmation Received Successfully"
}';
// DATA
$mpesaResponse = file_get_contents('php://input');
// log the response
$logFile = "M_PESAResponse.txt";
$jsonMpesaResponse = json_decode($mpesaResponse, TRUE);
// write to file
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);
 ?>
