<?php
$this->db->where('R_Id', $termination_id);
$q = $this->db->get('tbl_resignation');
foreach ($q->result() as $row) {
    $employee_id = $row->Employee_Id;
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
    $Terminated_Date1 = $row->Resignation_Date;
    $Terminated_Date = date("d-m-Y", strtotime($Terminated_Date1));
    $LWD1 = $row->Last_Working_Date;
    $LWD = date("d-m-Y", strtotime($LWD1));
    $Reason = $row->Reason;

    $emp_report_to_id = $row->Reporting_To;
    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_firstname = $row_emp->Emp_FirstName;
        $emp_reporting_lastname = $row_emp->Emp_LastName;
        $emp_reporting_middlename = $row_emp->Emp_MiddleName;
    }
}
?>

<script>
    $(document).ready(function () {
        $('#edittermination_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                termination_id: $('#termination_id').val(),
                employee_id: $('#employee_id').val(),
                termination_lwd: $('#edit_termination_lwd').val(),
                termination_date: $('#edit_termination_date').val(),
                termination_reason: $('#edit_termination_reason').val()

            };
            $.ajax({
                url: "<?php echo site_url('Termination/EditTermination') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edittermination_success').hide();
                        $('#edittermination_error').show();
                    }
                    if (msg == 'success') {
                        $('#edittermination_error').hide();
                        $('#edittermination_success').show();
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
            <div id="edittermination_success" class="alert alert-success" style="display:none;">Termination data updated successfully.</div>
            <div id="edittermination_error" class="alert alert-danger" style="display:none;">Failed to update termination.</div>
        </div>
    </div>
    <input type="hidden" name="termination_id" id="termination_id" value="<?php echo $termination_id; ?>">
    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id; ?>">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Code : </label>
                <?php echo $emp_code . $employee_id ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Name : </label>
                <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-3" class="control-label">Reporting Manager : </label>
                <?php echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename . "(" . $emp_code . $emp_report_to_id . ")"; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Last Working Date : </label>
                <div class="input-group">
                    <input type="text" name="edit_termination_lwd" id="edit_termination_lwd" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select last working date." data-mask="dd-mm-yyyy" data-validate="required" value="<?php echo $Terminated_Date; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Termination Date : </label>
                <div class="input-group">
                    <input type="text" name="edit_termination_date" id="edit_termination_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select termination date." data-mask="dd-mm-yyyy" data-validate="required" value="<?php echo $LWD; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Reason</label>
                <div class="input-group">
                    <textarea name="edit_termination_reason" id="edit_termination_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter reason."><?php echo $Reason; ?></textarea>
                </div>
            </div>	
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
