<?php
$this->db->where('R_Id', $R_Id);
$q = $this->db->get('tbl_Resignation');
foreach ($q->result() as $row) {
    $emp_no=$row->Employee_Id;
    $Terminated_Date1 = $row->Resignation_Date;
    $Terminated_Date = date("d-m-Y", strtotime($Terminated_Date1));

    $LWD_Date1 = $row->Last_Working_Date;
    $LWD_Date = date("d-m-Y", strtotime($LWD_Date1));

    $Reason = $row->Reason;
    $emp_report_to_id = $row->Reporting_To;

    $this->db->where('employee_number', $emp_no);
    $q_code = $this->db->get('tbl_emp_code');
    foreach ($q_code->result() as $row_code) {
        $emp_code = $row_code->employee_code;
    }

    $this->db->where('Emp_Number', $emp_no);
    $q_employee = $this->db->get('tbl_employee');
    foreach ($q_employee->result() as $row_employee) {
        $Emp_FirstName = $row_employee->Emp_FirstName;
        $Emp_Middlename = $row_employee->Emp_MiddleName;
        $Emp_LastName = $row_employee->Emp_LastName;
    }

    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_firstname = $row_emp->Emp_FirstName;
        $emp_reporting_lastname = $row_emp->Emp_LastName;
        $emp_reporting_middlename = $row_emp->Emp_MiddleName;
    }

    $Terminated_By = $row->exit_by;

}
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Code : </label>
                <?php echo $emp_code . $emp_no ?>
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

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Terminated Date : </label>
                <?php echo $Terminated_Date; ?>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Last Working Date : </label>
                <?php echo $LWD_Date; ?>
            </div>	
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-3" class="control-label">Terminated By : </label>
                <?php echo $Terminated_By; ?>
            </div>	
        </div>
        <div class="col-md-10">
            <div class="form-group">
                <label for="field-3" class="control-label">Reason : </label>
                <?php echo $Reason; ?>
            </div>	
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">Close</button>
</div>
<!-- Print option query Start here-->
<script>
    function termination_print(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- Print option query End here-->
<div id="termination_print" style="display: none;">    

    <h2 align="center"> Termination</h2>
    <p align="right">Terminated Date : <?php echo $Terminated_Date; ?></p>

    <p>Emp.Name :  <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></p>
    <p>Emp.Code :  <?php echo $emp_code . $emp_no ?></p>
    <p>Reporting Manager : <?php echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename . "(" . $emp_code . $emp_report_to_id . ")"; ?></p>
    <p>Last Working Date : <?php echo $LWD_Date; ?></p>
    <p>Terminated By :   <?php echo $Terminated_By; ?></p>
    <p>Subject : <b>Termination Letter</b></p>
    <p>Dear Sir, </p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Reason; ?> </p>
</div>
