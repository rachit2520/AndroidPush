<?php
$url = "https://fcm.googleapis.com/fcm/send";
//$token = "fDQctMDJoIY:APA91bFXbIAdDktJ3xm4KLgj3zGYVsojKC2ArbdaIQoMIbyf8ZAAHLq2DTHsDvu62N2IDiCQJpOK1l4Q5-lAAuZYgVQvjNHEGY6Ki7fkQKWR1KdsVx7cyx1IgZ87NHqmZ9XTptImAcvX";
//$token = "f5LiqOPsdg8:APA91bEHOZ7nYdD-9yfuAwfpoNHgBlPS6S6rCCA0_GAMc_ingsX5MvEXjifRWQuLwQmyIxwoWzvBnGT-OH9fEzRlI3wHtjWXIKQEuH4W7OkKnehvToMXSsYV-gBDb8rEd2oriN_4x04e";
$token = "c5zbwYoCyOc:APA91bHXxadj_7vmSvd6UK-jkMw-6GqWoptxAXIDY52qsNag1VmVz3N-YatDeb7tlmEdlXbIxnIPEzoFsJwZsXSW_GKd4ahadL3pzYA5Tn9O_54aiGxNKCcQx8o5ww1hhi1yAQyryyMz";
$serverKey = "AAAAKj_dpoE:APA91bE1eNkF6_xYD9PYNxPafcI720AW3AIW6IEPUljkWDVwU9KBcVgaf70lKj9cvpiRrsybtVFDNENwahAoZEyPLDvYh7m-y8j52vpKCl8ywtD0iD3NjE5wvrBGsWL2Mc3CRlsmyPbt";
$title = "Title";
$body = "Body of the message";
//$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default');
//$notification = array('message' => 'This offer expires at 11:30 or whatever' , 'title' => 'Test Notification', 'additionalData' => array('surveyID' => 'ewtawgreg-gragrag-rgarhthgbad'));
$notification = array('title' => 'Test Notification' , 'message' => 'This offer expires at 11:30 or whatever', 'sound' => 'default', 'notId' => 10, 'surveyID' => 'ewtawgreg-gragrag-rgarhthgbad');
$arrayToSend = array('to' => $token, 'data' => $notification,'priority'=>'high');
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
