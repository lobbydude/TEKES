<?php
if ($status == "Present") {
    $this->db->where('A_Id', $att_id_in);
    $q_in = $this->db->get('tbl_attendance');
    foreach ($q_in->result() as $row_in) {
        $Login_Date1 = $row_in->Login_Date;
        $Login_Date = date("d-m-Y", strtotime($Login_Date1));
        $Login_Time = $row_in->Login_Time;
        $Employee_Id = $row_in->Emp_Id;
        $this->db->where('Emp_Number', $Employee_Id);
        $select_emp = $this->db->get('tbl_employee');
        foreach ($select_emp->result() as $row_emp) {
            $employee_first_name = $row_emp->Emp_FirstName;
            $employee_middle_name = $row_emp->Emp_MiddleName;
            $employee_last_name = $row_emp->Emp_LastName;
        }
        $Logout_Date1 = $row_in->Logout_Date;
        if ($Logout_Date1 == "0000-00-00") {
            $Logout_Date = "";
        } else {
            $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
        }
        $Logout_Time = $row_in->Logout_Time;
        $h1 = strtotime($Login_Time);
        $h2 = strtotime($Logout_Time);
        $seconds = $h2 - $h1;
        if ($Logout_Date1 == "0000-00-00") {
            $total_hours = "";
        } else {
            $total_hours = gmdate("H:i:s", $seconds);
        }
    }
    ?>
    <div class="row margin-bottom-10">
        <div class="form-group">
            <input type="hidden" name="edit_att_emp_id" id="edit_att_emp_id" value="<?php echo $Employee_Id ?>">
            <input type="hidden" name="edit_att_id_in" id="edit_att_id_in" value="<?php echo $att_id_in ?>">
            <input type="hidden" name="edit_att_status" id="edit_att_status" value="<?php echo $status ?>">
            <div class="col-md-6">
                <label class="control-label">Employee Name : <?php echo $employee_first_name . " " . $employee_last_name . " " . $employee_middle_name; ?></label>
            </div>
            <div class="col-md-3">
                <label class="control-label">Type : Present</label>
            </div>
            <div class="col-md-3">
                <label class="control-label">Total Hours : <?php echo $total_hours; ?></label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                <label class="control-label">Login Date : <?php echo $Login_Date; ?></label>
            </div>
            <div class="col-md-3">
                <label class="control-label">Login Time : <?php echo $Login_Time; ?></label>
            </div>
            <div class="col-md-3">
                <label class="control-label">Logout Date : <?php echo $Logout_Date; ?></label>
            </div>
            <div class="col-md-3">
                <label class="control-label">Logout Time : <?php echo $Logout_Time; ?></label>
            </div>
        </div> <br><br><br>
    </div>
    <?php
}
if ($status == "Lop" || $status == "Disciplinary_LOP" || $status == "Comp_Off") {
    $this->db->where('A_M_Id', $att_id_in);
    $q_att_mark = $this->db->get('tbl_attendance_mark');
    foreach ($q_att_mark->result() as $row_att_mark) {
        $Emp_Id = $row_att_mark->Emp_Id;
        $this->db->where('Emp_Number', $Emp_Id);
        $select_emp = $this->db->get('tbl_employee');
        foreach ($select_emp->result() as $row_emp) {
            $employee_first_name = $row_emp->Emp_FirstName;
            $employee_middle_name = $row_emp->Emp_MiddleName;
            $employee_last_name = $row_emp->Emp_LastName;
        }
        $Date1 = $row_att_mark->Date;
        $Date = date("d-m-Y", strtotime($Date1));
        $Type = $row_att_mark->Type;
        $Remarks = $row_att_mark->Remarks;
    }
    if($status=="Comp_Off"){
        $status_text="Comp Off";
    }
    if($status=="Lop"){
        $status_text="Lop";
    }
    if($status=="Disciplinary_LOP"){
        $status_text="Disciplinary LOP";
    }
    ?>
    <div class="row">
        <div class="form-group">
            <input type="hidden" name="edit_att_id_in" id="edit_att_id_in" value="<?php echo $att_id_in ?>">
            <input type="hidden" name="edit_att_status" id="edit_att_status" value="<?php echo $status_text ?>">
            <input type="hidden" name="edit_att_emp_id" id="edit_att_emp_id" value="<?php echo $Emp_Id ?>">
            <div class="col-md-6">
                <label class="control-label">Employee Name : <?php echo $employee_first_name . " " . $employee_last_name . " " . $employee_middle_name; ?></label>
            </div>
            <div class="col-md-6">
                <label class="control-label">Type : <?php echo $Type; ?></label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label class="control-label">Date : <?php echo $Date; ?></label>
            </div>
            <div class="col-md-6">
                <label class="control-label">Remarks : <?php echo $Remarks; ?></label>
            </div>
        </div>
    </div>
    <?php
}
?>
