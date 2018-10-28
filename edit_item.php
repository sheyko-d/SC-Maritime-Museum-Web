<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sanitize if you want
$item_id = filter_input(INPUT_GET, 'item_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get item id form query string parameter.
    $item_id = filter_input(INPUT_GET, 'item_id', FILTER_SANITIZE_STRING);

    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);
    $db = getDbInstance();
    $db->where('item_id',$item_id);
    $stat = $db->update('item', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Item updated successfully!";
        //Redirect to the listing page,
        header('location: items.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db->where('item_id', $item_id);
    //Get data to pre-populate the form.
    $item = $db->getOne("item");
}
?>


<?php
    include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Item</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="" action="" method="post" enctype="multipart/form-data" id="item_form">
        
        <?php
            //Include the common form for add and edit  
            require_once('./forms/item_form.php'); 
        ?>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
   $("#item_form").validate({
       rules: {
            name: {
                required: true,
                minlength: 1
            },
            desc: {
                required: true,
                minlength: 1
            },   
        }
    });
  });
</script>

<?php include_once 'includes/footer.php'; ?>