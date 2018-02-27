<?php
$this->db->where('A_Id', $A_Id);
$q = $this->db->get('tbl_announcement');
foreach ($q->result() as $row) {
    $edit_announcement_title = $row->Title;
    $edit_announcement_date1 = $row->Date;
    $edit_announcement_date = date("d-m-Y", strtotime($edit_announcement_date1));
    $edit_announcement_message = $row->Message;
    $announcement_edit_file = $row->File;
}
?>


<!-- Upload Announcement File image Edit Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#editannouncement_form").on('submit', (function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo site_url('Announcement/edit_announcement') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#editannouncement_error').show();
                    }
                    else {
                        $('#editannouncement_error').hide();
                        $('#editannouncement_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>
<!-- Upload Announcement File Edit image End here-->

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editannouncement_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editannouncement_success" class="alert alert-success" style="display:none;">Announcement details updated successfully.</div>
            <div id="editannouncement_error" class="alert alert-danger" style="display:none;">Failed to update Announcement details.</div>
        </div>
    </div>
    <div class="row">   
        <input type="hidden" name="edit_announcement_id" id="edit_announcement_id" value="<?php echo $A_Id; ?>">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Title</label>
                <input type="text" name="edit_announcement_title" id="edit_announcement_title" class="form-control" placeholder="Title" value="<?php echo $edit_announcement_title; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Announcement Date</label>
                <div class="input-group">
                    <input type="text" name="edit_announcement_date" id="edit_announcement_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_announcement_date; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>                                     
            </div>	
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-4" class="control-label">Message</label>                                
                    <textarea class="form-control" name="edit_announcement_message" id="edit_announcement_message"><?php echo $edit_announcement_message; ?></textarea>
                </div>	
            </div>
        </div>  

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Files</label>
                <div style="max-width: 200px; max-height: 150px;float:right" class="fileinput-preview fileinput-exists thumbnail">
                    
                    <?php
                    $ext = pathinfo($announcement_edit_file, PATHINFO_EXTENSION);
                    if ($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" width="100" height="100">                        
                        </a>
                        <?php
                    } elseif ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlsm' || $ext == 'csv') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/excel.png')?>">                        
                        </a>                     
                        <?php
                    } elseif ($ext == 'ppt') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/pdf.png')?>">                        
                        </a>
                        <?php
                    } 
                     elseif ($ext == 'pdf') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/pdf.png')?>">                        
                        </a>
                        <?php
                    } 
                    elseif ($ext == 'doc' || $ext == 'docx') {
                        ?>
                        <a href="<?php echo site_url('announcement_image/' . $announcement_edit_file)?>" target="_blank">
                            <img src="<?php echo site_url('images/word.png')?>">                        
                        </a>                                       
                    <?php } ?>                   

                </div>
                <a class="file-input-wrapper btn form-control file2 inline btn btn-primary"><i class="glyphicon glyphicon-file"></i> Browse
                    <input type="file" id="edit_userfile" name="edit_userfile" data-label="&lt;i class='glyphicon glyphicon-file'&gt;&lt;/i&gt; Browse" class="form-control file2 inline btn btn-primary" style="left: 47.6667px; top: -0.25px;">                    
                </a>
            </div>
        </div>     

    </div>
    <!-- Edit(Update) Announcement Form Design Start-->

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>