<?php
ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

date_default_timezone_set('US/Eastern');

//Include the QR library
include 'phpqrcode/qrlib.php';

//Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

//Get current page.
$page = filter_input(INPUT_GET, 'page');

//Per page limit for pagination.
$pagelimit = 20;

if (!$page) {
    $page = 1;
}

// If filter types are not selected we show latest created data first
if (!$filter_col) {
    $filter_col = "notification_id";
}
$filter_col = $filter_col;
if (!$order_by) {
    $order_by = "Desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('notification_id', 'title', 'message', 'time');

//Start building query according to input parameters.
// If search string
if ($search_string) {
    $db->where('title', '%' . $search_string . '%', 'like');
    $db->orwhere('message', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
    $db->orderBy("notification." . $filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$items = $db->arraybuilder()->paginate("notification", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($items as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}
include_once 'includes/header.php';
?>


<script src="https://unpkg.com/moment"></script>

<!--Main container start-->
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Notifications</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
	            <a href="add_notification.php?operation=create">
	            	<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
	            </a>
            </div>
        </div>
    </div>
        <?php include './includes/flash_messages.php'?>
    <!--    Begin filter section-->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col" class="form-control">

                <?php
foreach ($filter_options as $option) {
    ($filter_col === $option) ? $selected = "selected" : $selected = "";
    echo ' <option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
}
?>

            </select>

            <select name="order_by" class="form-control" id="input_order">

                <option value="Asc" <?php
if ($order_by == 'Asc') {
    echo "selected";
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_by == 'Desc') {
    echo "selected";
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">

        </form>
    </div>
<!--   Filter section end-->

    <hr>


    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
<th class="header" style="width:50px; text-align: center">#</th>
                <th style="width:auto">Title</th>
                <th style="width:auto">Message</th>
                <th style="width:230px">Date & Time</th>
                <th style="text-align:center; width:120px">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $row): ?>
                <tr>
	                <td style="vertical-align:middle; text-align: center"><?php echo $row['notification_id'] ?></td>
	                <td style="vertical-align:middle"><?php echo htmlspecialchars($row['title']) ?></td>
	                <td style="vertical-align:middle"><?php echo htmlspecialchars($row['message']) ?></td>
	                <td style="vertical-align:middle" class="date_row"><?php echo $row['time'] / 1000 ?></td>
                    <td style="text-align: center; padding: 5px 0px 5px 7px; vertical-align:middle">
                        <a href="edit_notification.php?notification_id=<?php echo $row['notification_id'] ?>&operation=edit" class="btn btn-primary" style="margin-right: 8px;"><span class="glyphicon glyphicon-edit"></span>
                        <a href=""  class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['notification_id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span>
                    </td>
				</tr>

						<!-- Delete Confirmation Modal-->
					 <div class="modal fade" id="confirm-delete-<?php echo $row['notification_id'] ?>" role="dialog">
					    <div class="modal-dialog">
					      <form action="delete_notification.php" method="POST">
					      <!-- Modal content-->
						      <div class="modal-content">
						        <div class="modal-header">
						          <button type="button" class="close" data-dismiss="modal">&times;</button>
						          <h4 class="modal-title">Confirm</h4>
						        </div>
						        <div class="modal-body">

						        		<input type="hidden" name="del_id" id = "del_id" value="<?php echo $row['notification_id'] ?>">

						          <p>Are you sure you want to delete this notification?</p>
						        </div>
						        <div class="modal-footer">
						        	<button type="submit" class="btn btn-default pull-left">Yes</button>
						         	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						        </div>
						      </div>
					      </form>

					    </div>
  					</div>
            <?php endforeach;?>
        </tbody>
    </table>



<!--    Pagination links-->
    <div class="text-center">

        <?php
if (!empty($_GET)) {
    //we must unset $_GET[page] if previously built by http_build_query function
    unset($_GET['page']);
    //to keep the query sting parameters intact while navigating to next/prev page,
    $http_query = "?" . http_build_query($_GET);
} else {
    $http_query = "?";
}
//Show pagination links
if ($total_pages > 1) {
    echo '<ul class="pagination text-center">';
    for ($i = 1; $i <= $total_pages; $i++) {
        ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
        echo '<li' . $li_class . '><a href="items.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul></div>';
}
?>
    </div>
    <!--    Pagination links end-->

</div>
<!--Main container end-->

<script>

    $(document).ready(function() {
        $(".date_row").each(function() {
            $(this).html(moment.unix($(this).html()).format("DD MMMM YYYY hh:mm a"));
        });
    });
</script>


<?php include_once './includes/footer.php';?>
