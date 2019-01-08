<?php

// Connect to the database
require_once "../../../util/database.php";
$db = new DBConnect();
$con = $db->openConnection();

ini_set('max_execution_time', 120);

// Retrieve all FCM tokens from DB
$token_query = $db->makeQuery($con, "SELECT token FROM token") or die(mysqli_error($con));
$tokens = array();
while ($token_result = mysqli_fetch_assoc($token_query)) {
    array_push($tokens, $token_result["token"]);
}

// Retrieve all notificications from DB
$notification_query = $db->makeQuery($con, "SELECT notification_id, title, message, time FROM notification WHERE sent<>1") or die(mysqli_error($con));
$notifications = array();
while ($notification_result = mysqli_fetch_assoc($notification_query)) {
    if (abs(time() - $notification_result["time"] / 1000) <= 60) {
        //if ($notification_result["time"] / 1000 - time() > 0) {
            //sleep($notification_result["time"] / 1000 - time());
        //}
        sendFCM($notification_result["title"], $notification_result["message"], $tokens);

        $notification_id = $notification_result['notification_id'];
        $db->makeQuery($con, "UPDATE notification SET sent=1 WHERE notification_id='$notification_id'") or die(mysqli_error($con));
    }
}

function sendFCM($title, $body, $tokens)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'registration_ids' => $tokens,
        'notification' => array(
            "body" => $body,
            "title" => $title,
            "icon" => "new",
            "sound" => "default"
        ),
        'data' => array(
            "body" => $body,
            "title" => $title,
        ),
        'priority' => "high",
        'content_available' => true,
    );
    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . "AAAAXPhmu0g:APA91bHGwYpRdJqVRCf2btQzaWOriHo6puN1IN0oCysddKyrp-1bEt3vgnoTGukQZRtDnTMULbJbkpm8ly25zvvR4u9YmcSvVPb2irvamGlZAZAlxSg74To-suVuvwuTqS6lqynq5gUX",
        'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    var_dump($result);
    curl_close($ch);
}
