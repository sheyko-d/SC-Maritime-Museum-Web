<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = filter_input_array(INPUT_POST);
    $db = getDbInstance();
    $last_id = $db->insert('item', $data_to_store);
    
    if($last_id)
    {
    	$_SESSION['success'] = "Item added successfully!";
    	header('location: items.php');
    	exit();
    }  
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Item</h2>
        </div>
        
</div>
    <form class="form" action="" method="post"  id="item_form" enctype="multipart/form-data">
       <?php  include_once('./forms/item_form.php'); ?>
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