


<div class="keyboard-section">

    <div class="keyboard-section-inner"  > <!-- enctype must to upload files -->

        <i class="fas fa-paper-plane" style="display:none"></i>
        <i class="fas fa-thumbs-up"></i>
        <input type="text" class="form-control keyboard-input" fid="<?php echo $_GET["fid"]; ?>" id="send-messege" placeholder="Type Your Messege..." autocomplete="off" autofocus   />
        <i class="fas fa-smile"></i>

        <form class="content-icon" enctype="multipart/form-data">
            <label for="file" id="file-label">  <i class="fas fa-paperclip"></i> </label>
            <input type="file" class="file form-control" id="file" name="file"   /> 
        </form>

    </div>

</div>