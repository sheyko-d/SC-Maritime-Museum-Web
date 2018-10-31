<?php 
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: items.php');
        exit;

	}
    $item_id = $del_id;

    $db = getDbInstance();
    $db->where('item_id', $item_id);
    $status = $db->delete('item');
    
    if ($status) 
    {
        $_SESSION['info'] = "Item deleted successfully!";
        header('location: items.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete item";
    	header('location: items.php');
        exit;

    }
    
}