<?php
    
    // Connect to the database
    require_once "../../../util/database.php";
    $db = new DBConnect();
    $con = $db->openConnection();
    
    // Retrieve all FCM tokens from DB
    $token_query = $db->makeQuery($con, "SELECT token FROM token") or die(mysqli_error($con));
    
    $tokens = array();
    while ($token_result = mysqli_fetch_assoc($token_query)) {
        array_push($tokens, $token_result["token"]);
    }
    
    sendFCM("Test", "Body", $tokens);
    
    function sendFCM($title, $body, $tokens) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
                         'registration_ids' => $tokens,
                         'notification' => array (
                                                  "body" => $body,
                                                  "title" => $title
                                                  )
                         );
        $fields = json_encode ( $fields );
        $headers = array (
                          'Authorization: key=' . "AAAAXPhmu0g:APA91bHGwYpRdJqVRCf2btQzaWOriHo6puN1IN0oCysddKyrp-1bEt3vgnoTGukQZRtDnTMULbJbkpm8ly25zvvR4u9YmcSvVPb2irvamGlZAZAlxSg74To-suVuvwuTqS6lqynq5gUX",
                          'Content-Type: application/json'
                          );
        
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        
        $result = curl_exec ( $ch );
        var_dump($result);
        curl_close ( $ch );
    }
    
    ?>
