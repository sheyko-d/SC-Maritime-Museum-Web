<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="file-upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css">

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
          <input type="text" name="name" value="<?php echo $edit ? $item['name'] : ''; ?>" placeholder="Name" class="form-control" required="required" id = "f_name" >
    </div>

    <div class="form-group">
        <label for="desc">Description *</label>
          <textarea name="desc" placeholder="Description" class="form-control" id="desc"><?php echo ($edit)? $item['desc'] : ''; ?></textarea>
    </div> 

    <div class="form-group">
        <label for="desc">Photos</label>

                        <?php
                        $photos = json_decode($item['photos'], true);
                        $i = 0;
                        if ($photos){
                            echo "<br>";
                        foreach ($photos as $photo){
                            echo "<span style='height:80; position:relative' id='photo_wrapper".$i."'>
                                    <img height=80 src='".$photo["url"]."' style='margin-right:7px; margin-bottom:10px'/>
                                    <img style='position:absolute;right:14px;top:-32px;height:16px;width:16px;cursor:pointer' onClick='deletePhoto(\"".$photo["url"]."\", ".$i."); return false' src='assets/images/delete.png'/>
                                </span>";
                                $i++;
                        }
                     } ?>
        <br>
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add files...</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files[]" multiple>
        </span>
        <br>
        <br>
        <!-- The container for the uploaded files -->
        <div id="files" class="files"></div>
        <!-- The global progress bar -->
        <div id="progress" class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>

        <input type="hidden" name="photos" id="photos" />
    </div>
    
    <div class="form-group">
        <label for="mp3">Audio</label>
            <input type="text" name="mp3" value="<?php echo $edit ? $item['mp3'] : ''; ?>" placeholder="Paste an MP3 link (or upload)" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="video">Video</label>
            <input name="video" value="<?php echo $edit ? $item['video'] : ''; ?>" placeholder="Paste a YouTube video link" class="form-control"  type="text" id="phone">
    </div>


    <script>
    var photos = <?php echo $item["photos"] ? $item["photos"] : "[]" ?>;
    $("#photos").val(JSON.stringify(photos));

    function deletePhoto($photo, $index){
        $("#photo_wrapper"+$index).hide()

        for (var i in photos) {
            if (photos[i].url == $photo){
                photos.splice(i, 1)
            }
        }

        $("#photos").val(JSON.stringify(photos));
    }

    $(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = 'file-upload/server/php/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxHeight: 150,
        previewCrop: false
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    
            }
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
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
                    
        photos.push({url: file.url});
        $("#photos").val(JSON.stringify(photos));

            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        alert(e)
        alert(data)
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
    </script>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>