<?php 
// Server file
class PushNotifications {
	// (Android)API access key from Google API's Console.
	private static $API_ACCESS_KEY = 'AAAAKj_dpoE:APA91bE1eNkF6_xYD9PYNxPafcI720AW3AIW6IEPUljkWDVwU9KBcVgaf70lKj9cvpiRrsybtVFDNENwahAoZEyPLDvYh7m-y8j52vpKCl8ywtD0iD3NjE5wvrBGsWL2Mc3CRlsmyPbt';
	// (iOS) Private key's passphrase.
	private static $passphrase = 'wss@WSS2017';
	
	// Change the above three vriables as per your app.
	public function __construct() {
        // exit('Init function is not allowed');
    }

    // Sends Push notification for Android users
    public function android($data, $reg_id) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = array
        (
            'title' => $data['mtitle'],
            'body' => $data['mdesc'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'sound' => 'default'
        );
    
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.self::$API_ACCESS_KEY
        );

        $fields = array(
            'notification' => $message,
            'to' => $reg_id,
        );

        return self::useCurl($url, $headers, $fields);
    }
    
    // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {

        $deviceToken = $devicetoken;

        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'apn.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', 'wss@WSS2017');

        // Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
             ),
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);

        if (!$result)
            echo 'Message not delivered' . PHP_EOL;
        else
            echo 'Message successfully delivered' . PHP_EOL;

    }

    // Curl 
    private function useCurl($url, $headers , $fields) {
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            }
            // Execute post
            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);
       //checking the response code we get from fcm for debugging purposes
            echo "http response " . $httpcode;
       //checking the status/result of the push notif for debugging purposes
            echo $result;
            return $result;
        }

    }
}

?>