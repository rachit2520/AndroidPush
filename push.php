<?php
$url = "https://fcm.googleapis.com/fcm/send";
$token = "cvH1tXyShLM:APA91bEkvSwAmEbX9cpKkTBPa5uvN6BbPH4jmXP8c3spn4rCcdWSoiQUDuy1yZ4FZHTcwKW9De_mEMRdvAph_5NUuZITZhn4htXkG0rlwj8BO1vR0KyyuLL0J62rdjRJaB9N-jUD3vGc";
$serverKey = "AAAAMffK6G0:APA91bG6o2ueD-l-QRe0mjrMHqfpDRw_wLTuHOkY6qnF0BILKdv8zJohTmLpof1Hs-WdzWCG2ZfIJymmVGcF5diZkMSuqyfMd37Okq-JYBQjhYILFOFO2i8-J13eXILQ02NfM2Q_nvGp";
$title = "Title";
$body = "Body of the message";
$notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
$json = json_encode($arrayToSend);
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: key='. $serverKey;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
//Send the request
$response = curl_exec($ch);
echo $response;
//Close request
if ($response === FALSE) {
die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
