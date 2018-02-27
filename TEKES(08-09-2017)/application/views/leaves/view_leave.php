<?php
$this->db->where('L_Id', $leave_id);
$q = $this->db->get('tbl_leaves');
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

    $emp_report_to_id = $row->Reporting_To;
    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_firstname = $row_emp->Emp_FirstName;
        $emp_reporting_lastname = $row_emp->Emp_LastName;
        $emp_reporting_middlename = $row_emp->Emp_MiddleName;
    }

    $Leave_Type_Id = $row->Leave_Type;
    $this->db->where('L_Id', $Leave_Type_Id);
    $q_leave_type = $this->db->get('tbl_leavetype');
    foreach ($q_leave_type->result() as $row_leave_type) {
        $Leave_Title = $row_leave_type->Leave_Title;
    }

    $Leave_Duration = $row->Leave_Duration;
    $Leave_From1 = $row->Leave_From;
    $Leave_From = date("d-m-Y", strtotime($Leave_From1));

    $Leave_To1 = $row->Leave_To;
    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
    $Leave_To = date("d-m-Y", strtotime($Leave_To1));

    if ($Leave_Duration == "Full Day") {
        $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
        $No_days = $interval->format("%a") . " Days";
    } else {
        $No_days = "Half Day";
    }

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

<div class="modal-body">
    <div class="row">
        <?php
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2) {
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="field-3" class="control-label">Employee Code : </label>
                    <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(". $emp_code . $employee_id . ")" ?>
                </div>
            </div>

        <?php } ?>


        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Reporting Manager : </label>
                <?php echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename . "(" . $emp_code . $emp_report_to_id . ")"; ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Leave Type : </label>
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
        
        <div class="col-md-5">
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
            <div class="col-md-12">
                <h3>Manager Status : </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Manager Approval: </label>
                    <?php
                    if ($Approval == "Request") {
                        echo "Processing ... ";
                    }if ($Approval == "Yes") {
                        echo "Approved";
                    }if ($Approval == "No") {
                        echo "Not Approved";
                    }
                    ?>

                </div>
            </div>

            <div class="col-md-7">
                <div class="form-group">
                    <label for="field-3" class="control-label">Remarks : </label>
                    <?php echo $Remarks; ?>
                </div>	
            </div>
        </div>
    <?php } ?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


