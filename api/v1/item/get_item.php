<?php

if (!isset($_GET["id"])) {
    die("ID is empty");
}

$item_id = $_GET["id"];

// Connect to the database
require_once "../../../util/database.php";
$db = new DBConnect();
$con = $db->openConnection();

// Find item with the specified ID
$item_query = $db->makeQuery($con, "SELECT item.name, content, mp3, item.references FROM item WHERE item_id='$item_id'") or die(mysqli_error($con));
$item_result = mysqli_fetch_assoc($item_query);
if (!$item_result) {
    die();
}

$name = $item_result["name"];
$content = $item_result["content"];
$audio = $item_result["mp3"];
$references = $item_result["references"];

$name = iconv('UTF-8', 'UTF-8//IGNORE', $name);
$content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
$references = iconv('UTF-8', 'UTF-8//IGNORE', $references);

$content = json_decode($content, true);
$references = json_decode($references, true);

echo json_encode(array("id" => $item_id, "name" => $name, "content" => $content, "audio" => $audio, "references" => $references));
