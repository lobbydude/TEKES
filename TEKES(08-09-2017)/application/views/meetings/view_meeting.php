<?php
$this->db->where('M_Id', $M_Id);
$q = $this->db->get('tbl_meetings');
foreach ($q->result() as $row) {
    $Title = $row->Title;
    $Start_Date1 = $row->Start_Date;
    $Start_Date = date("d-m-Y", strtotime($Start_Date1));
    $Start_Time = $row->Start_Time;
    $End_Date1 = $row->End_Date;
    $End_Date = date("d-m-Y", strtotime($End_Date1));
    $End_Time = $row->End_Time;
    $Location = $row->Location;
    $Message = $row->Message;
}
?>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="field-3" class="control-label">Title : </label>
            <?php echo $Title ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="field-3" class="control-label">Start Date & Time : </label>
            <?php echo $Start_Date . " " . $Start_Time; ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="field-3" class="control-label">End Date & Time : </label>
            <?php echo $End_Date . " " . $End_Time; ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="field-3" class="control-label">Location : </label>
            <?php echo $Location; ?>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="field-3" class="control-label">Agenda : </label>
            <?php echo $Message; ?>
        </div>
    </div>
</div>
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Status</th>                                              
            </tr>
        </thead>						
        <tbody>
            <?php
            $this->db->where('Meeting_Id', $M_Id);
            $q_meeting_to = $this->db->get('tbl_meetings_to');
            foreach ($q_meeting_to->result() as $row_meeting_to) {
                $to_emp_id = $row_meeting_to->Emp_Id;
                $meeting_status = $row_meeting_to->Status;

                $this->db->where('Emp_Number', $to_emp_id);
                $q_employee = $this->db->get('tbl_employee');
                foreach ($q_employee->result() as $row_employee) {
                    $first_name = $row_employee->Emp_FirstName;
                    $middle_name = $row_employee->Emp_MiddleName;
                    $last_name = $row_employee->Emp_LastName;

                    $this->db->where('employee_number', $to_emp_id);
                    $q_code = $this->db->get('tbl_emp_code');
                    foreach ($q_code->result() as $row_code) {
                        $emp_code = $row_code->employee_code;
                    }
                    ?>
                    <tr>
                        <td><?php echo $first_name . $last_name . $middle_name . " (" . $emp_code . $to_emp_id . ")"; ?></td>
                        <td><?php $meeting_status; ?></td>
                    </tr>	
                <?php }
            } ?>
        </tbody>
    </table>
</div>