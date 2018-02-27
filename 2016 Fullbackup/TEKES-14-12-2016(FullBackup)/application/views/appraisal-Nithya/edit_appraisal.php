<?php
$this->db->where('AP_Id', $AP_Id);
$q = $this->db->get('tbl_appraisalform');
foreach ($q->result() as $row) {
    $edit_designation = $row->Designation;
    $appraisal_edit_file = $row->File;
}
?>

<!-- Upload Appraisal File image Edit Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#editappraisal_form").on('submit', (function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo site_url('appraisal/edit_appraisal') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#editappraisal_error').show();
                    }
                    else {
                        $('#editappraisal_error').hide();
                        $('#editappraisal_success').show();
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
<!-- Upload Appraisal File Edit image End here-->

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editappraisal_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editappraisal_success" class="alert alert-success" style="display:none;">Appraisal details updated successfully.</div>
            <div id="editappraisal_error" class="alert alert-danger" style="display:none;">Failed to update Appraisal details.</div>
        </div>
    </div>
    <div class="row">   
        <input type="hidden" name="edit_appraisal_id" id="edit_appraisal_id" value="<?php echo $AP_Id; ?>">
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-1" class="control-label">Designation</label>
                <select name="edit_designation" id="edit_designation" class="round" data-validate="required" data-message-required="Please Select Designation">
                    <?php
                    $this->db->order_by('Designation_Id', 'desc');
                    $this->db->group_by('Designation_Name');
                    $this->db->where('Status', 1);
                    $q_designation = $this->db->get('tbl_designation');
                    foreach ($q_designation->Result() as $row_designation) {
                        $designation_name = $row_designation->Designation_Name;
                        $designation_id = $row_designation->Designation_Id;
                        $role = $row_designation->Role;
                        ?>
                        <option value="<?php echo $designation_id; ?>" <?php
                        if ($edit_designation == $designation_id) {
                            echo "selected=selected";
                        }
                        ?>>
                            <?php echo $designation_name . " ($role)"; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Appraisal Form</label>
                <div style="max-width: 200px; max-height: 150px;float:right" class="fileinput-preview fileinput-exists thumbnail">

                    <?php
                    $ext = pathinfo($appraisal_edit_file, PATHINFO_EXTENSION);
                    if ($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                        ?>
                        <a href="<?php echo site_url('appraisal_image/' . $appraisal_edit_file) ?>" target="_blank">
                            <img src="<?php echo site_url('appraisal_image/' . $appraisal_edit_file) ?>" width="100" height="100">                        
                        </a>
                        <?php
                    } elseif ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlsm' || $ext == 'csv') {
                        ?>
                        <a href="<?php echo site_url('appraisal_image/' . $appraisal_edit_file) ?>" target="_blank">
                            <img src="<?php echo site_url('images/excel.png') ?>">                        
                        </a>                     
                        <?php
                    } elseif ($ext == 'ppt') {
                        ?>
                        <a href="<?php echo site_url('appraisal_image/' . $appraisal_edit_file) ?>" target="_blank">
                            <img src="<?php echo site_url('images/pdf.png') ?>">                        
                        </a>
                        <?php
                    } elseif ($ext == 'pdf') {
                        ?>
                        <a href="<?php echo site_url('appraisal_image/' . $appraisal_edit_file) ?>" target="_blank">
                            <img src="<?php echo site_url('images/pdf.png') ?>">                        
                        </a>
                        <?php
                    } elseif ($ext == 'doc' || $ext == 'docx') {
                        ?>
                        <a href="<?php echo site_url('appraisal_image/' . $appraisal_edit_file) ?>" target="_blank">
                            <img src="<?php echo site_url('images/word.png') ?>">                        
                        </a>                                       
                    <?php } ?>                   

                </div>
                <a class="file-input-wrapper btn form-control file2 inline btn btn-primary"><i class="glyphicon glyphicon-file"></i> Browse
                    <input type="file" id="edit_userfile" name="edit_userfile" data-label="&lt;i class='glyphicon glyphicon-file'&gt;&lt;/i&gt; Browse" class="form-control file2 inline btn btn-primary" style="left: 47.6667px; top: -0.25px;">                    
                </a>
            </div>
        </div>     

    </div>
    <!-- Edit(Update) Appraisal Form Design Start-->

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>