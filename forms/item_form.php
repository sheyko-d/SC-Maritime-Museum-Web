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
        <label for="mp3">Audio</label>
            <input type="text" name="mp3" value="<?php echo $edit ? $item['mp3'] : ''; ?>" placeholder="Paste an MP3 link (or upload)" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="video">Video</label>
            <input name="video" value="<?php echo $edit ? $item['video'] : ''; ?>" placeholder="Paste a YouTube video link" class="form-control"  type="text" id="phone">
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>