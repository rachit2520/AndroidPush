<?php
function SendToDevice($title, $message, $regId)
{
    require_once('PushNotifications.php');
    // Message payload, using data from post request
    $msg_payload = array(
        'mtitle' => $title,
        'mdesc' => $message,
    );
    $var = new PushNotifications();
    $var->android($msg_payload, $regId);
}
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST['SendTo']))) {
    SendToDevice($_POST['title'], $_POST['messageBody'], $_POST['SendTo']);
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
        <option value="cvH1tXyShLM:APA91bEkvSwAmEbX9cpKkTBPa5uvN6BbPH4jmXP8c3spn4rCcdWSoiQUDuy1yZ4FZHTcwKW9De_mEMRdvAph_5NUuZITZhn4htXkG0rlwj8BO1vR0KyyuLL0J62rdjRJaB9N-jUD3vGc">Android</option>
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