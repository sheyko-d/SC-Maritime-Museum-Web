<?php

$target_dir = "../file-upload/server/php/files/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$success = true;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$file_name = uniqid() . "." . $imageFileType;
$target_file = $target_dir . $file_name;
$error = "Failure!";

// Check if file already exists
if (file_exists($target_file)) {
    $error = "Sorry, file already exists.";
    $success = false;
}
// Check file size
if ($_FILES["file"]["size"] > 500000) {
    $error = "Sorry, your file is too large.";
    $success = false;
}
// Allow certain file formats
if ($imageFileType != "mp3" && $imageFileType != "m4a") {
    $error = "Sorry, only mp3 and m4a files are allowed.";
    $success = false;
}
// Upload the file
if ($success) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $message = "http://" . $_SERVER['HTTP_HOST'] . "/file-upload/server/php/files/" . $file_name;
    } else {
        $error = "Sorry, there was an error uploading your file.";
        $success = false;
    }
}

// $output will be converted into JSON

if ($success) {
    $output = array("success" => true, "message" => $message);
} else {
    $output = array("success" => false, "error" => $error);
}

if (($iframeId = (int) $_GET["_iframeUpload"]) > 0) { //old browser...

    header("Content-Type: text/html; charset=utf-8");

    ?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<script type="text/javascript">

var data = {
	id: <?php echo $iframeId; ?>,
	type: "json",
	data: <?php echo json_encode($output); ?>
};

parent.simpleUpload.iframeCallback(data);

</script>
</body>
</html>
<?php

} else { //new browser...

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($output);

}

?>