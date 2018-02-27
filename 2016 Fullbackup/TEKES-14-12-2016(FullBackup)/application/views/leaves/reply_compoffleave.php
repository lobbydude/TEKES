<?php
$this->db->where('A_M_Id', $leave_id);
$q = $this->db->get('tbl_attendance_mark');
foreach ($q->result() as $row) {
    $employee_id = $row->Emp_Id;
    $this->db->where('employee_number', $employee_id);
    $q_code = $this->db->get('tbl_emp_code');
    foreach ($q_code->result() as $row_code) {
        $emp_code = $row_code->employee_code;
    }
    $this->db->where('Emp_Number', $employee_id);
    $q_employee = $this->db->get('tbl_employee');
    foreach ($q_employee->result() as $row_employee) {
        $Emp_FirstName = $row_employee->Emp_FirstName;
        $Emp_Middlename = $row_employee->Emp_MiddleName;
        $Emp_LastName = $row_employee->Emp_LastName;
    }

    $Leave_Title = $row->Type;
    $Leave_Duration = "Full Day";
    $Leave_From1 = $row->Date;
    $Leave_From = date("d-m-Y", strtotime($Leave_From1));

    $Leave_To1 = $row->Date;
    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
    $Leave_To = date("d-m-Y", strtotime($Leave_To1));
    $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
    $total_no_days = $interval->format("%a");
    $No_days = $interval->format("%a") . " Days";
    $Reason = $row->Reason;
    $Approval = $row->Approval;
    $Remarks = $row->Remarks;

    $Canceled_By = $row->Canceled_By;
    $this->db->where('Emp_Number', $Canceled_By);
    $q_emp_cancel = $this->db->get('tbl_employee');
    foreach ($q_emp_cancel->result() as $row_emp_cancel) {
        $emp_cancel_firstname = $row_emp_cancel->Emp_FirstName;
        $emp_cancel_lastname = $row_emp_cancel->Emp_LastName;
        $emp_cancel_middlename = $row_emp_cancel->Emp_MiddleName;
    }
}
?>

<script>
    $(document).ready(function () {
        $('#replycompoffleave_form').submit(function (e) {
            e.preventDefault();
            var approval;
            if (document.getElementById("compoffleave_reply_approval_yes").checked) {
                approval = document.getElementById("compoffleave_reply_approval_yes").value;
            } else {
                approval = document.getElementById("compoffleave_reply_approval_no").value;
            }

            var formdata = {
                leave_id: $('#compoff_id').val(),
                emp_id: $('#compoff_reply_emp_id').val(),
                leave_reply_type_id: $('#compoff_reply_type_id').val(),
                leave_reply_total_days: $('#compoff_reply_total_days').val(),
                approval: approval,
                leave_reply_remarks: $('#compoffleave_reply_remarks').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/reply_compoffleave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#replycompoffleave_error').show();
                    }
                    if (msg == 'success') {
                        $('#replycompoffleave_success').show();
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
            <div id="replycompoffleave_success" class="alert alert-success" style="display:none;">Leave status sent successfully.</div>
            <div id="replycompoffleave_error" class="alert alert-danger" style="display:none;">Failed to send leave status.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" id="compoff_id" name="compoff_id" value="<?php echo $leave_id ?>">
        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Name : </label>
                <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "( " . $emp_code . $employee_id . ")" ?>
            </div>
        </div>
        <input type="hidden" name="compoff_reply_emp_id" id="compoff_reply_emp_id" value="<?php echo $employee_id ?>">
        <input type="hidden" name="leave_reply_total_days" id="leave_reply_total_days" value="<?php echo $total_no_days; ?>">

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Type : </label>
                <?php echo $Leave_Title; ?>
            </div>	
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Duration : </label>
                <?php echo $Leave_Duration; ?>
            </div>	
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">From Date : </label>
                <?php echo $Leave_From; ?>
            </div>	
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">To Date : </label>
                <?php echo $Leave_To; ?>
            </div>	
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">No of Days : </label>
                <?php echo $No_days; ?>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Reason : </label>
                <?php echo $Reason; ?>
            </div>	
        </div>
    </div>
    <?php
    if ($Approval == "Cancel") {
        ?>
        <div class="row">
            <div class="col-md-12">
                <strong><?php echo "Leave Canceled by " . $emp_cancel_firstname . " " . $emp_cancel_lastname . " " . $emp_cancel_middlename; ?></strong>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Manager Approval</label>
                    <div class="col-md-6">
                        <div class="radio">
                            <input type="radio" id="compoffleave_reply_approval_yes" name="approval"  value="Yes" <?php
                            if ($Approval == "Yes" || $Approval == "Request") {
                                echo "checked";
                            }
                            ?>>
                            <label>Yes</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio">
                            <input type="radio" id="compoffleave_reply_approval_no"  name="approval" value="No" <?php
                            if ($Approval == "No") {
                                echo "checked";
                            }
                            ?>>
                            <label>No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-3" class="control-label">Remarks</label>
                    <textarea name="compoffleave_reply_remarks" id="compoffleave_reply_remarks" class="form-control"><?php echo $Remarks; ?></textarea>
                </div>	
            </div>
        </div>
    <?php } ?>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>