<?php
$this->db->where('S_Id', $S_Id);
$q = $this->db->get('tbl_suggestion');
foreach ($q->result() as $row) {
    $feedback_message = $row->Feedback;
    $Emp_Id = $row->Emp_Id;
    $this->db->where('Emp_Number', $Emp_Id);
    $q = $this->db->get('tbl_employee');
    foreach ($q->result() as $row) {
        $firstname = $row->Emp_FirstName;
        $lastname = $row->Emp_LastName;
        $middlename = $row->Emp_MiddleName;
    }

    $get_empcode = array(
        'employee_number' => $Emp_Id,
        'Status' => 1
    );
    $this->db->where($get_empcode);
    $q_empcode = $this->db->get('tbl_emp_code');
    foreach ($q_empcode->result() as $row_empcode) {
        $empcode = $row_empcode->employee_code;
    }
}
?>

<div class="modal-body">    
    <div class="row" style="padding: 2%;">        
        <h3 class="modal-title"><?php echo $firstname . " " . $lastname . " " . $middlename . "( " . $empcode . $Emp_Id . " )  :  "; ?></h5>
        <p><?php echo $feedback_message; ?></p>
    </div>
</div>

<div class="modal-footer">    
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

