<?php
$this->db->where('L_Id', $L_Id);
$q = $this->db->get('tbl_leavetype');
foreach ($q->result() as $row) {
    $edit_leavetype_title = $row->Leave_Title;
    $edit_leavetype_leavetype = $row->Leave_Type;
    $edit_leavetype_gender = $row->Leave_Gender;
    $edit_leavetype_leavedays = $row->Leave_Days;
}
?>

<script>
    $(document).ready(function () {
        $('#editleavetype_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_leavetype_id: $('#edit_leavetype_id').val(),
                edit_leavetype_title: $('#edit_leavetype_title').val(),
                edit_leavetype_leavetype: $('#edit_leavetype_leavetype').val(),
                edit_leavetype_gender: $('#edit_leavetype_gender').val(),
                edit_leavetype_leavedays: $('#edit_leavetype_leavedays').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/edit_leavetype') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_leavetype_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_leavetype_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_leavetype_server_error').html(msg);
                        $('#edit_leavetype_server_error').show();
                    }
                }
            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_leavetype_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_leavetype_success" class="alert alert-success" style="display:none;">Leave Type details updated successfully.</div>
            <div id="edit_leavetype_error" class="alert alert-danger" style="display:none;">Failed to update Leave Type details.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_leavetype_id" id="edit_leavetype_id" value="<?php echo $L_Id; ?>">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Title</label>
                <input type="text" name="edit_leavetype_title" id="edit_leavetype_title" class="form-control" value="<?php echo $edit_leavetype_title; ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-1" class="control-label">Type</label>
                <select name="edit_leavetype_leavetype" id="edit_leavetype_leavetype" class="round" data-validate="required">                   
                    <option value="<?php echo $edit_leavetype_leavetype; ?>"><?php echo $edit_leavetype_leavetype; ?></option>
                    <option value="Any Value">Any Type</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>                                    
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Gender</label>
                <select name="edit_leavetype_gender" id="edit_leavetype_gender" class="round" data-validate="required">
                    <option value="<?php echo $edit_leavetype_gender; ?>"><?php echo $edit_leavetype_gender; ?></option>
                    <option value="Any Geneder">Any Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>                                           
                </select>
            </div>	
        </div>
    </div>    

    <div class="row"> 
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Days</label>
                <div class="input-group">
                    <input type="text" name="edit_leavetype_leavedays" id="edit_leavetype_leavedays" class="form-control" placeholder="Days" data-validate="required,number" value="<?php echo $edit_leavetype_leavedays; ?>">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary">Days</button>
                    </span>
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>