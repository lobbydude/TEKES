<?php
$this->db->where('L_Id', $leave_id);
$q = $this->db->get('tbl_leaves');
foreach ($q->result() as $row) {
    $employee_id = $row->Employee_Id;
    $Leave_Type_Id = $row->Leave_Type;
    $Leave_Duration = $row->Leave_Duration;
    $Leave_From1 = $row->Leave_From;
    $Leave_To1 = $row->Leave_To;
    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));

    if ($Leave_Duration == "Full Day") {
        $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
        $total_no_days = $interval->format("%a");
        $No_days = $interval->format("%a") . " Days";
    } else {
        $total_no_days = 0.5;
        $No_days = "Half Day";
    }
}
?>

<script>
    $(document).ready(function () {
        $("#cancel_leave_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                cancel_leave_id: $('#cancel_leave_id').val(),
                cancel_leave_emp_id: $('#cancel_leave_emp_id').val(),
                cancel_leave_type_id: $('#cancel_leave_type_id').val(),
                cancel_leave_total_days: $('#cancel_leave_total_days').val()
            };

            $.ajax({
                url: "<?php echo site_url('Leaves/cancel_leave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#cancel_leave_error').show();
                    }
                    else {
                        $('#cancel_leave_error').hide();
                        $('#cancel_leave_success').hide();
                        window.location.reload();
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="cancel_leave_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="cancel_leave_success" class="alert alert-success" style="display:none;">Leave canceled successfully.</div>
            <div id="cancel_leave_error" class="alert alert-danger" style="display:none;">Failed to cancel the leave.</div>
        </div>
    </div>
    <input type="hidden" name="cancel_leave_emp_id" id="cancel_leave_emp_id" value="<?php echo $employee_id ?>">
    <input type="hidden" name="cancel_leave_type_id" id="cancel_leave_type_id" value="<?php echo $Leave_Type_Id; ?>">
    <input type="hidden" name="cancel_leave_total_days" id="cancel_leave_total_days" value="<?php echo $total_no_days; ?>">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to cancel this leave?
            </div>	
        </div>
        <input type="hidden" name="cancel_leave_id" id="cancel_leave_id" value="<?php echo $leave_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

