<?php
$get_data = array(
    'Status' => 1,
    'Emp_Number' => $emp_id
);
$this->db->where($get_data);
$q_emp = $this->db->get('tbl_employee');
foreach ($q_emp->result() as $row_emp) {
    $emp_firstname = $row_emp->Emp_FirstName;
    $emp_middlename = $row_emp->Emp_MiddleName;
    $emp_lastname = $row_emp->Emp_LastName;
    $emp_no = $row_emp->Emp_Number;

    $this->db->where('employee_number', $emp_no);
    $q_code = $this->db->get('tbl_emp_code');
    foreach ($q_code->Result() as $row_code) {
        $emp_code = $row_code->employee_code;
    }
    $Emp_Doj = $row_emp->Emp_Doj;
    $doj = date("d-M-Y", strtotime($Emp_Doj));

    $this->db->where('Employee_Id', $emp_no);
    $q_report = $this->db->get('tbl_employee_career');
    foreach ($q_report->Result() as $row_report) {
        $emp_designation_id = $row_report->Designation_Id;
        $report_id = $row_report->Reporting_To;
    }
    $this->db->where('Designation_Id', $emp_designation_id);
    $q_desig = $this->db->get('tbl_designation');
    foreach ($q_desig->result() as $row_desig) {
        $emp_notice_period = $row_desig->Notice_Period;
    }
}
?>
<script>
    $(document).ready(function () {
        $('#addtermination_form').submit(function (e) {
            e.preventDefault();
            var type = $("#add_res_type").val();
            if (type == "Termination") {
                var formdata = {
                    add_termination_employee: $('#add_termination_employee').val(),
                    add_termination_date: $('#add_termination_date').val(),
                    add_termination_lwd: $('#add_termination_lwd').val(),
                    add_termination_reporting_to: $('#add_termination_reporting_to').val(),
                    add_termination_reason: $('#add_termination_reason').val(),
                    add_termination_by:$("#add_termination_by").val()
                };
                $.ajax({
                    url: "<?php echo site_url('Termination/AddTermination') ?>",
                    type: 'post',
                    data: formdata,
                    success: function (msg) {
                        if (msg == 'fail') {
                            $('#addtermination_error').show();
                        }
                        if (msg == 'success') {
                            $('#addtermination_success').show();
                            window.location.reload();
                        }
                    }

                });
            }
            if (type == "Resignation") {
                var formdata = {
                    emp_no: $("#add_termination_employee").val(),
                    notice_date: $('#add_notice_date').val(),
                    resignation_date: $('#add_resignation_date').val(),
                    reporting_to: $('#add_termination_reporting_to').val(),
                    reason: $('#add_reason').val(),
                    notice_period: $('#add_termination_notice_period').val()
                };
                $.ajax({
                    url: "<?php echo site_url('Resignation/add_resignation') ?>",
                    type: 'post',
                    data: formdata,
                    success: function (msg) {
                        if (msg == 'fail') {
                            $('#addresignation_error').show();
                        }
                        if (msg == 'success') {
                            $('#addresignation_success').show();
                            window.location.reload();
                        }

                    }

                });
            }
        });
    });
</script>

<!-- Add Termination Start Here -->

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label class="control-label">Employee Name : </label>
            <?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . "(" . $emp_code . $emp_no . ")"; ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">DOJ : </label>
            <?php echo $doj; ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Notice Period : </label>
            <?php echo $emp_notice_period . " Days"; ?>
        </div>
    </div>
</div>
<input type="hidden" name="add_termination_employee" id="add_termination_employee" value="<?php echo $emp_id; ?>">
<input type="hidden" name="add_termination_reporting_to" id="add_termination_reporting_to" value="<?php echo $report_id; ?>">
<input type="hidden" name="add_termination_notice_period" id="add_termination_notice_period" value="<?php echo $emp_notice_period; ?>">

<!-- Add Termination End Here -->