<?php
    
    if (!isset($_GET["token"]) or empty($_GET["token"])) {
        die("Token is empty");
    }
    
    $token = $_GET["token"];
    
    // Connect to the database
    require_once "../../../util/database.php";
    $db = new DBConnect();
    $con = $db->openConnection();
    
    // Check if this token already exists
    $token_query = $db->makeQuery($con, "SELECT token FROM token WHERE token='$token'") or die(mysqli_error($con));
    $token_result = mysqli_fetch_assoc($token_query);
    if ($token_result) {
        die();
    }
    
    $db->makeQuery($con, "INSERT INTO token(token) VALUES ('$token')") or die(mysqli_error($con));

?>
