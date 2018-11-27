<?php ini_set('post_max_size', '1000M');
ini_set('upload_max_filesize', '1000M');?>

<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="file-upload/css/jquery.fileupload.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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



<!-- Latest Sortable -->
<script src="bower_components/Sortable/Sortable.js"></script>


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
        <label for="f_name">Name *</label>
          <input type="text" name="name" value="<?php echo $edit ? $item['name'] : ''; ?>" placeholder="Name" class="form-control" style="padding: 6px 10px" required="required" id = "f_name" >
    </div>

    <!--<div class="form-group" style="display:none">
        <label for="desc">Photos</label>

                        <?php/*
$photos = json_decode($item['photos'], true);
$i = 0;
if ($photos) {
echo "<br>";
foreach ($photos as $photo) {
echo "<span style='height:80; position:relative' id='photo_wrapper" . $i . "'>
<img height=80 src='" . $photo["url"] . "' style='margin-right:7px; margin-bottom:10px'/>
<img style='position:absolute;right:14px;top:-32px;height:16px;width:16px;cursor:pointer' onClick='deletePhoto(\"" . $photo["url"] . "\", " . $i . "); return false' src='assets/images/delete.png'/>
</span>";
$i++;
}
}*/?>

    </div>-->

    <div class="form-group">
        <label for="mp3" style="margin-top:10px">Content</label>
        <br>
        <span class="btn btn-success fileinput-button" onClick="addText()">
            <i class="glyphicon glyphicon-align-left"></i>
            <span>&nbsp;Add Text</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="addtext" type="button">
        </span>
        <span class="btn btn-success fileinput-button" onClick="addPhoto()">
            <i class="glyphicon glyphicon-picture"></i>
            <span>&nbsp;Add Photo</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="addtext" type="button">
        </span>
        <span class="btn btn-success fileinput-button" onClick="addVideo()">
            <i class="glyphicon glyphicon-film"></i>
            <span>&nbsp;Add Video</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="addtext" type="button">
        </span>

        <div id="listWithHandle" class="list-group" style="margin-top:10px">
            <?php
if ($edit && $item["content"]) {
    $content = json_decode($item["content"], true);
    $i = 0;
    foreach ($content as $part) {
        if ($part["type"] == "desc") {
            echo '<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>Text Area<div class="listHiddenContainer" style="display:none; margin-left: 25px; margin-top: 10px; margin-bottom: 5px"><textarea placeholder="Paste your text paragraph here…" class="form-control" id="description" style="height: 131px; resize:vertical; padding: 6px 10px; border-color:#e0e0e0">' . $part["text"] . '</textarea></div></div>';
        } else if ($part["type"] == "img") {
            echo '<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>Photo w/ Caption<div class="listHiddenContainer" style="display:none; margin-left: 25px; margin-top: 10px; margin-bottom: -5px"><div id="files' . $i . '" class="files"><div><p><a target="_blank" href="' . $part["url"] . '"><img width="80" height="80" src=' . $part["url"] . '></img></a><br><input style="margin-top:10px; border-color:#e0e0e0" class="form-control caption" value="' . $part["caption"] . '" placeholder="Enter photo name…"></p></div></div></div></div>';
        } else {
            echo '<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>Video w/ Caption<div class="listHiddenContainer" style="display:none; margin-left: 25px; margin-top: 10px; margin-bottom: 5px"><input type="text" placeholder="Or paste a YouTube embed link here… (example: https://www.youtube.com/embed/Bey4XXJAqS8)" class="form-control youtube" id="youtube' . $i . '" style="padding: 6px 10px; border-color:#e0e0e0" value="' . $part["url"] . '"/><input style="margin-top:10px;border-color:#e0e0e0" type="text" class="form-control caption" value="' . @$part["caption"] . '" placeholder="Enter video name…"/></div></div>';
        }
        $i++;
    }
}
?>
        </div>
    </div>

    <input type="hidden" name="content" id="content" />

    <div class="form-group">
        <label for="mp3" style="margin-top:10px">Audio</label>
        <input type="text" name="mp3" value="<?php echo $edit ? $item['mp3'] : ''; ?>" placeholder="Paste a link here, or upload using a button below…" class="form-control" style="padding: 6px 10px" id="audio">
        <span class="btn btn-success fileinput-button" style="margin-top:10px">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Upload File…</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_audio" type="file" name="file">
     </span>
        <div id="audio_file" class="files" style="margin-top:10px"></div>
        <div id="progress_audio" class="progress" style="margin-bottom:10px; display:none"><div class="progress-bar progress-bar-success"></div></div>
    </div>

    <div class="form-group">
        <label for="video" style="margin-top:10px">Related Items</label>
        <div id="related_items_container">
        <?php
// Connect to the database
require_once "util/database.php";
$db = new DBConnect();
$con = $db->openConnection();

$item_query = $db->makeQuery($con, "SELECT item_id, name FROM item " . ($item['item_id'] ? "WHERE item_id<>" . $item['item_id'] : null)) or die(mysqli_error($con));
while ($item_result = mysqli_fetch_assoc($item_query)) {
    echo '<input type="checkbox" item_id="' . $item_result["item_id"] . '" ' . (in_array($item_result["item_id"], json_decode($item["related_items"] ? $item["related_items"] : "[]", true)) ? "checked" : null) . '><font style="margin-left:8px">' . $item_result["name"] . '</font><br>';
}
?>
        </div>

        <input type="hidden" name="related_items" id="related_items" />

        <input type="hidden" name="references" id="references" />
    </div>





    <div class="form-group">
        <label for="mp3" style="margin-top:10px">External References</label>
        <br>
        <span class="btn btn-success fileinput-button" onClick="addLink()">
            <i class="glyphicon glyphicon-link" style="margin-top:2px;margin-left:-2px"></i>
            <span>&nbsp;Add Link</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="addtext" type="button">
        </span>

        <div id="listWithHandleLinks" class="list-group" style="margin-top:10px">
            <?php
if ($edit && $item["references"]) {
    $references = json_decode($item["references"], true);
    $i = 0;
    foreach ($references as $part) {
        echo '<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>External Link w/ Caption<div class="listHiddenContainer" style="margin-left: 25px; margin-top: 10px; margin-bottom: 5px"><input type="text" placeholder="Paste the URL here…" class="form-control url" value="' . $part["url"] . '" style="padding: 6px 10px; border-color:#e0e0e0"/><input style="margin-top:10px;border-color:#e0e0e0" type="text" class="form-control url_title" id="url_title" placeholder="Enter a link title…" value="' . $part["url_title"] . '"/></div></div>';
        $i++;
    }
}
?>
        </div>
    </div>



    <script>
$('#fileupload_audio').change(function(){

$(this).simpleUpload("./ajax/upload.php", {

    start: function(file){
        //upload started
        console.log("upload started");
        $('#progress_audio').show()
    },

    progress: function(progress){
        //received progress
        $('#progress_audio .progress-bar').css(
            'width',
            progress + '%'
        );
    },

    success: function(data){
        if (data.success){
            // Upload successful
            $("#audio").val(data.message);
        } else {
            // Upload failed
            $('#progress_audio .progress-bar').css(
                'width',
                '0%'
            );
            $('#progress_audio').hide()
            alert("Upload error: " + data.error);
        }
    },

    error: function(error){
        //upload failed
        alert("Upload failed")
        console.log("upload error: " + error.name + ": " + error.message);
    }

});

});

    function toggleItem(item){
        $(item).parent().find(".listHiddenContainer").toggle()
        $(item).rotate({
        angle: $(item).getRotateAngle(),
        animateTo: $(item).getRotateAngle()==0?180:0,
        duration: 150
      });
    }

    function deleteItem(item){
        if (confirm("Do you want to delete this item?")){
            $(item).parent().remove()
        }
    }

    function addText(){
        $("#listWithHandle").append('<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>Text Area<div class="listHiddenContainer" style="margin-left: 25px; margin-top: 10px; margin-bottom: 5px"><textarea placeholder="Paste your text paragraph here…" class="form-control" id="description" style="height: 131px; resize:vertical; padding: 6px 10px; border-color:#e0e0e0"></textarea></div></div>')
        $("#listWithHandle").children().last().find(".fa-chevron-down").rotate(180)
    }

    function addPhoto(){
        var index = $("#listWithHandle").children().length;
        $("#listWithHandle").append('<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>Photo w/ Caption<div class="listHiddenContainer" style="margin-left: 25px; margin-top: 10px; margin-bottom: -5px"><span class="btn btn-success fileinput-button" style="margin-bottom:10px" id="button'+index+'"><i class="glyphicon glyphicon-plus"></i><span>&nbsp;Upload File...</span><input id="fileupload'+index+'" type="file" name="files[]" multiple></span><div id="files'+index+'" class="files"></div><div id="progress'+index+'" class="progress" style="margin-bottom:10px;display:none"><div class="progress-bar progress-bar-success"></div></div></div></div>');
        initUploadButton(index)
        $("#listWithHandle").children().last().find(".fa-chevron-down").rotate(180)
    }

    function addVideo(){
        var index = $("#listWithHandle").children().length;
        $("#listWithHandle").append('<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>Video w/ Caption<div class="listHiddenContainer" style="margin-left: 25px; margin-top: 10px; margin-bottom: 5px"><span class="btn btn-success fileinput-button" style="margin-bottom:10px" id="button_video'+index+'"><i class="glyphicon glyphicon-plus"></i><span>&nbsp;Upload File...</span><input id="fileupload_video'+index+'" type="file" name="file"></span><div id="files_video'+index+'" class="files"></div><div id="progress_video'+index+'" class="progress" style="margin-bottom:10px;display:none"><div class="progress-bar progress-bar-success"></div></div><input type="text" placeholder="Or paste a YouTube embed link here… (example: https://www.youtube.com/embed/Bey4XXJAqS8)" class="form-control youtube" id="youtube'+index+'" style="padding: 6px 10px; border-color:#e0e0e0"/><input style="margin-top:10px;border-color:#e0e0e0" type="text" class="form-control caption" id="youtube_name'+index+'" placeholder="Enter video name…"/></div></div>')
        initVideoUploadButton(index)
        $("#listWithHandle").children().last().find(".fa-chevron-down").rotate(180)
    }

    function addLink(){
        var index = $("#listWithHandleLinks").children().length;
        $("#listWithHandleLinks").append('<div class="list-group-item" style="user-select:none"><i class="fa fa-times" style="float:right;padding:3px;cursor:pointer" onclick="deleteItem(this)"></i><i class="fa fa-chevron-down" style="float:right;padding:3px;margin-right:10px; cursor:pointer" onclick="toggleItem(this)"></i><span class="drag-handle" aria-hidden="true" style="margin-right:12px; cursor:move">☰</span>External Link w/ Caption<div class="listHiddenContainer" style="margin-left: 25px; margin-top: 10px; margin-bottom: 5px"><input type="text" placeholder="Paste the URL here…" class="form-control url" id="url'+index+'" style="padding: 6px 10px; border-color:#e0e0e0"/><input style="margin-top:10px;border-color:#e0e0e0" type="text" class="form-control url_title" id="url_title'+index+'" placeholder="Enter a link title…"/></div></div>')
        $("#listWithHandleLinks").children().last().find(".fa-chevron-down").rotate(180)

        addUrlListener()
    }

    // List with handle
    Sortable.create(listWithHandle, {
        handle: '.drag-handle',
        animation: 150
    });

// List with handle
Sortable.create(listWithHandleLinks, {
    handle: '.drag-handle',
    animation: 150
});

    var content = <?php echo $item["content"] ? $item["content"] : "[]" ?>;
    $("#content").val(JSON.stringify(content));

    var references = <?php echo $item["references"] ? $item["references"] : "[]" ?>;
    $("#references").val(JSON.stringify(references));

    function initVideoUploadButton(i){

        var video_name;
        $('#fileupload_video'+i).change(function(){

$(this).simpleUpload("./ajax/upload_video.php", {

    start: function(file){
        video_name = file.name;

        //upload started
        console.log("upload started");
        $('#progress_video'+i).show()
    },

    progress: function(progress){
        //received progress
        $('#progress_video'+i+' .progress-bar').css(
            'width',
            progress + '%'
        );
    },

    success: function(data){
        if (data.success){
            // Upload successful
            $("#youtube"+i).val(data.message);
            $("#youtube_name"+i).val(video_name.replace(".mp4", "").replace(".avi", "").replace(".mov", "").replace("mpg", "").replace("mpeg", "").replace("mkv", ""));
        } else {
            // Upload failed
            $('#progress_video'+i+' .progress-bar').css(
                'width',
                '0%'
            );
            $('#progress_video'+i).hide()
            alert("Upload error: " + data.error);
        }
    },

    error: function(error){
        //upload failed
        alert("Upload failed")
        console.log("upload error: " + error.name + ": " + error.message);
    }

});

});
    }

    function initUploadButton(i){
    var url = 'file-upload/server/php/'
    $('#fileupload'+i).fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 9999000,
        imageMaxHeight: 1000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxHeight: 1000,
        previewCrop: false
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files'+i);
        $.each(data.files, function (index, file) {
            var fileName = file.name.replace(".png", "").replace(".jpg", "").replace(".jpeg", "").replace("JPG", "");

            if (fileName.indexOf(")")==1 || fileName.indexOf(")")==2){
                fileName = $.trim(fileName.substring(fileName.indexOf(")")+1));
            }

            var node = $('<p/>')
                    .append($('<input/>').attr("style", "margin-top:10px; border-color:#e0e0e0").attr("class", "form-control caption").attr("value", fileName).attr("placeholder", "Enter photo name…"));

            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
            $("#button"+i).hide()
            $('#progress'+i).show();
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress'+i+' .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index]).find("canvas")
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }

    addUrlListener()
    function addUrlListener(){
        $(".url").change(function(){
            var proxyurl = "get_external_content.php?url=" + $(this).val()
            var input = $(this)
            $.ajax({
                url: proxyurl,
                async: true,
                success: function(response) {
                    input.parent().find(".url_title").val(JSON.parse(response).title)
                },
                error: function(e) {
                alert("error! " + e);
                }
            });
        })
    }

    function submitForm(){
        var content = []
        $("#listWithHandle").children().each(function () {
            // Check if content type is description (true) or photo (false)
            if ($(this).find("#description").length > 0){
                if ($(this).find("#description").val()){
                    content.push({
                        type: "desc",
                        text: $.trim($(this).find("#description").val())
                    })
                }
            } else if ($(this).find(".youtube").length > 0){
                if ($(this).find(".youtube").val()){
                    content.push({
                        type: "video",
                        url: $.trim($(this).find(".youtube").val()),
                        caption: $(this).find(".caption").val()
                    })
                }
            } else {
                if ($(this).find("a").length > 0){
                    content.push({
                        type: "img",
                        url: $(this).find("a").attr("href"),
                        caption: $(this).find(".caption").val()
                    })
                }
            }
        });
        $("#content").val(JSON.stringify(content))

        var references = []
        $("#listWithHandleLinks").children().each(function () {
            if ($(this).find(".url").length > 0){
                if ($(this).find(".url").val()){
                    if (ValidURL($.trim($(this).find(".url").val()))){
                        references.push({
                            url: $.trim($(this).find(".url").val()),
                            url_title: $.trim($(this).find(".url_title").val())
                        })
                    } else {
                        alert("URL is invalid and will not be saved.")
                    }
                }
            }
        });
        $("#references").val(JSON.stringify(references))

        var related_items = []
        $("#related_items_container").children().each(function () {
            var id = $(this).attr("item_id");
            if (id && $(this).is(':checked')){
                related_items.push(id)
            }
        });
        $("#related_items").val(JSON.stringify(related_items))
    }

    function ValidURL(str) {
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (pattern.test(str)) {
            return true;
        } else {
            return false;
        }
    }

    </script>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" onClick="submitForm()" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>