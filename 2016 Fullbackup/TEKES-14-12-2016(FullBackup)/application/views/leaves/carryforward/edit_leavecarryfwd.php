<?php
$this->db->where('L_Id', $L_Id);
$q = $this->db->get('tbl_leave_carryforward_type');
foreach ($q->result() as $row) {
    $Start_Year1 = $row->Start_Year;
    $Start_Year = date("d-m-Y", strtotime($Start_Year1));
    $End_Year1 = $row->End_Year;
    $End_Year = date("d-m-Y", strtotime($End_Year1));
}
?>

<script>
    $(document).ready(function () {
        $('#editleavecarryforward_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_leavecarryforward_id: $('#edit_leavecarryforward_id').val(),
                edit_start_year_list: $('#edit_start_year_list').val(),
                edit_end_year_list: $('#edit_end_year_list').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/edit_leavecarryforward') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_leavecarryforward_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_leavecarryforward_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_leavecarryforward_error').html(msg);
                        $('#edit_leavecarryforward_success').show();
                    }
                }
            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_leavecarryforward_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_leavecarryforward_success" class="alert alert-success" style="display:none;">Leave carry forward updated successfully.</div>
            <div id="edit_leavecarryforward_error" class="alert alert-danger" style="display:none;">Failed to update leave carry forward.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_leavecarryforward_id" id="edit_leavecarryforward_id" value="<?php echo $L_Id; ?>">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Financial Start Year</label>
                <div class="input-group">
                    <input type="text" name="edit_start_year_list" id="edit_start_year_list" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select start year." value="<?php echo $Start_Year;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Financial End Year</label>
                <div class="input-group">
                    <input type="text" name="edit_end_year_list" id="edit_end_year_list" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select end year." value="<?php echo $End_Year;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:65%;left:45%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
    </div>    
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>