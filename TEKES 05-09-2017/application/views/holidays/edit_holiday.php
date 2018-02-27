<?php
$this->db->where('Holiday_Id', $holiday_id);
$q = $this->db->get('tbl_holiday');
foreach ($q->result() as $row) {
    $holiday_name = $row->Holiday_Name;
    $holiday_date1 = $row->Holiday_Date;
    $holiday_date = date("d-m-Y", strtotime($holiday_date1));
}
?>

<script>
    $(document).ready(function () {
        $('#editholiday_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_holiday_id: $('#edit_holiday_id').val(),
                edit_holiday_name: $('#edit_holiday_name').val(),
                edit_holiday_date: $('#edit_holiday_date').val()
            };
            $.ajax({
                url: "<?php echo site_url('Holidays/edit_holiday') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editholiday_error').show();
                    }
                    if (msg == 'success') {
                        $('#editholiday_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#editholiday_server_error').html(msg);
                        $('#editholiday_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editholiday_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editholiday_success" class="alert alert-success" style="display:none;">Holiday details updated successfully.</div>
            <div id="editholiday_error" class="alert alert-danger" style="display:none;">Failed to holiday details.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="edit_holiday_id" id="edit_holiday_id" value="<?php echo $holiday_id; ?>">
        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Holiday</label>
                <input type="text" name="edit_holiday_name" id="edit_holiday_name" class="form-control" data-validate="required" data-message-required="Please enter holiday." value="<?php echo $holiday_name; ?>">
            </div>	
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Date</label>
                <div class="input-group">
                    <input type="text" name="edit_holiday_date" id="edit_holiday_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select date." value="<?php echo $holiday_date; ?>">
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

