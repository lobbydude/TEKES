<?php
$this->db->where('Comp_Id', $C_Id);
$q = $this->db->get('tbl_compoff');
foreach ($q->result() as $row) {
    $edit_leavecompoff_title = $row->Title;
    $edit_leavecompoff_date1 = $row->Comp_Date;
    $edit_leavecompoff_date = date("d-m-Y", strtotime($edit_leavecompoff_date1));
   }
?>

<script>
    $(document).ready(function () {
        $('#editleavecompoff_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_leavecompoff_id: $('#edit_leavecompoff_id').val(),
                edit_leavecompoff_title: $('#edit_leavecompoff_title').val(),
                edit_leavecompoff_date: $('#edit_leavecompoff_date').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/edit_leavecompoff') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_leavecompoff_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_leavecompoff_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_leavecompoff_server_error').html(msg);
                        $('#edit_leavecompoff_server_error').show();
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_leavecompoff_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_leavecompoff_success" class="alert alert-success" style="display:none;">Leave Compoff details updated successfully.</div>
            <div id="edit_leavecompoff_error" class="alert alert-danger" style="display:none;">Failed to update Leave Compoff details.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_leavecompoff_id" id="edit_leavecompoff_id" value="<?php echo $C_Id; ?>">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Title</label>
                <input type="text" name="edit_leavecompoff_title" id="edit_leavecompoff_title" class="form-control" value="<?php echo $edit_leavecompoff_title; ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Date</label>
                <div class="input-group">
                    <input type="text" name="edit_leavecompoff_date" id="edit_leavecompoff_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_leavecompoff_date; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>                                     
            </div>	
        </div>
    </div>   
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>