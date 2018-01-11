<?php
function SendToDevice($title, $message, $platform, $push_token)
{
    require_once('PushNotifications.php');
    // Message payload, using data from post request
    $msg_payload = array(
        'mtitle' => $title,
        'mdesc' => $message,
    );
    $var = new PushNotifications();
    if($platform == 'ios') {
        $var->iOS($msg_payload, $push_token);
    }else if($platform == 'android') {
        $var->android($msg_payload, $push_token);
    }
}
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST['SendTo']))) {
    $stud = explode("_",$_POST['SendTo']);
    $platform = $stud[0];
    $push_token = $stud[1];
    SendToDevice($_POST['title'], $_POST['messageBody'], $platform, $push_token);
}
?>
<!-- HTML Form that contains input fields to send notification data in POST request on submit -->
<!DOCTYPE HTML>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<h1>Test FCM from server to client! </h1>
</header>

<form method="POST" action = "index.php">
    Who do you want to send the alert to?
    <select id = "SendTo" name="SendTo">
<!-- Put the FCM registration token in option value  --> 
        <option value="android_fDQctMDJoIY:APA91bFXbIAdDktJ3xm4KLgj3zGYVsojKC2ArbdaIQoMIbyf8ZAAHLq2DTHsDvu62N2IDiCQJpOK1l4Q5-lAAuZYgVQvjNHEGY6Ki7fkQKWR1KdsVx7cyx1IgZ87NHqmZ9XTptImAcvX">Android</option>
        <option value="android_dsqrzEGS1CI:APA91bGn0NwCRNqcfAR3OB8Z5BcGBil369IFXG9cRf-toUu_jj4cgNMGXxdwV96QRhKETmjzo41FNACE10sVn_XODWodYDh2sqWF1FxAVLpM8lgYS3nzLbahHHVbM-XwkGLIOS9vrHIc">ios</option>
    </select>
    <br />
    Title: <input tye="text" name ="title" id="title">
    <br />
    Message Body : <input type = "text", name = "messageBody">
    <br />
    <input type="submit" name="submit" id="submit">
</form>
</body>
</html>