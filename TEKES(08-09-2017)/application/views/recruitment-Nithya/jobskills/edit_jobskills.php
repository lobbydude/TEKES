<?php
$this->db->where('S_Id', $S_Id);
$q = $this->db->get('tbl_jobskills');
foreach ($q->result() as $row) {    
    $edit_jobskills_jobtitle = $row->Jobtitle;
    $edit_jobskills_name = $row->Jobskills;   
}
?>
<script>
    $(document).ready(function () {
        $('#editjobskills_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_jobskills_id: $('#edit_jobskills_id').val(),                
                edit_jobskills_jobtitle: $('#edit_jobskills_jobtitle').val(),
                edit_jobskills_name: $('#edit_jobskills_name').val()
            };
            $.ajax({
                url: "<?php echo site_url('Jobskills/edit_jobskills') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_jobskills_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_jobskills_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_jobskills_server_error').html(msg);
                        $('#edit_jobskills_server_error').show();
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_jobskills_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_jobskills_success" class="alert alert-success" style="display:none;">Job Skills details updated successfully.</div>
            <div id="edit_jobskills_error" class="alert alert-danger" style="display:none;">Failed to update Job Skills details.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_jobskills_id" id="edit_jobskills_id" value="<?php echo $S_Id; ?>"> 
        
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-1" class="control-label">Job Title</label>
                <select name="edit_jobskills_jobtitle" id="edit_jobskills_jobtitle" class="round" data-validate="required" data-message-required="Please Select jobskills">
                    <option value="">Select Jobtitle</option>
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
                            if ($edit_jobskills_jobtitle == $designation_id) {
                                echo "selected=selected";
                            }
                            ?>>
                            <?php echo $designation_name; ?></option>
                        
                        <?php
                    }
                    ?>
                </select>
            </div>	
        </div>        
        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Skills</label>
                <input type="text" name="edit_jobskills_name" id="edit_jobskills_name" class="form-control" data-validate="required" value="<?php echo $edit_jobskills_name;?>">
            </div>	
        </div>
    </div>    
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>