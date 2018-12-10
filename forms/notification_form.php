<?ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="file-upload/css/jquery.fileupload.css">

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="file-upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="file-upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="file-upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="file-upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="file-upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="file-upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="file-upload/js/jquery.fileupload-validate.js"></script>
<script src="js/jQueryRotate.js"></script>
<script src="js/simpleUpload.min.js"></script>
<script src="https://unpkg.com/moment"></script>



<!-- Latest Sortable -->
<script src="bower_components/Sortable/Sortable.js"></script>


<link href="../datetimepicker/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

<script type="text/javascript" src="../datetimepicker/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<style>
    .ph_container{
        position:absolute;
        top:0;
        left:0;
        width:80px;
        height:80px;
        background:red
    }
</style>

<fieldset>
    <div class="form-group">
        <label for="f_name">Title *</label>
          <input type="text" name="title" value="<?php echo $edit ? $item['title'] : ''; ?>" placeholder="Enter a notification title…" class="form-control" style="padding: 6px 10px" required="required" id = "title" >
    </div>

    <div class="form-group">
        <label for="f_name">Message *</label>
          <input type="text" name="message" value="<?php echo $edit ? $item['message'] : ''; ?>" placeholder="Enter a notification message…" class="form-control" style="padding: 6px 10px" required="required" id = "message" >
    </div>

    <div class="form-group">
        <label for="f_name">When to send *</label>

        <div class="form-group">
            <div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                <input onchange="parseDate()" style="background:white" class="form-control" id="date" size="16" type="text" value="" readonly>
                <span style="background:white" class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
			<input type="hidden" id="dtp_input1" value="" />
        </div>
        <input type="hidden" name="time" id="time"/>
        <input type="hidden" name="sent" value="0"/>

    </div>

    </fieldset>



    <script>
    $('.form_datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1,
        pickerPosition: "bottom-left"
    });
    window.onload = function () {
        let date
        if (!"<?php echo $item["time"] ?>"){
            date = new Date()
            date.addHours(1)
            date.setSeconds(0)
        } else {
            date = new Date(<?php echo $item["time"] ? $item["time"] : "" ?>)
        }

        $('.form_datetime').datetimepicker('update', date)
        if ("<?php echo $item["time"] ?>"){
            $("#time").val(<?php echo $item["time"] ?>)
        } else {
            parseDate()
        }
    }

    Date.prototype.addHours= function(h){
        this.setHours(this.getHours()+h);
        return this;
    }

    function parseDate(){
        let date = $("#date").val()
        let timestamp = moment(date, 'DD MMMM YYYY hh:mm a').valueOf()
        $("#time").val(timestamp)
    }

    </script>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>