<?php
ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_SESSION['admin_type'] != 'super') {
        $_SESSION['failure'] = "You don't have permission to perform this action";
        header('location: notifications.php');
        exit;

    }
    $notification_id = $del_id;

    $db = getDbInstance();
    $db->where('notification_id', $notification_id);
    $status = $db->delete('notification');

    if ($status) {
        $_SESSION['info'] = "Notification deleted successfully!";
        header('location: notifications.php');
        exit;
    } else {
        $_SESSION['failure'] = "Unable to delete notification";
        header('location: notifications.php');
        exit;

    }

}
