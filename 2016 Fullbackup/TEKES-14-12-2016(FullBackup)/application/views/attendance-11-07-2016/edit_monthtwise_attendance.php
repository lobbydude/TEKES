<?php
$emp_id = str_pad(($emp_no), 4, '0', STR_PAD_LEFT);
$fetch_data = array(
    'Emp_Number' => $emp_id
);
$this->db->where($fetch_data);
$q = $this->db->get('tbl_employee');
foreach ($q->result() as $row) {
    $emp_firstname = $row->Emp_FirstName;
    $emp_middlename = $row->Emp_MiddleName;
    $emp_lastname = $row->Emp_LastName;
}
?>

<div class="col-md-4">
    <div class="form-group">
        <label class="control-label">Employee Name</label>
        <input class="form-control" name="editmonthtimesheet_employee_name" id="att_employee_name"  value="<?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?>" disabled="disabled"/>
    </div>
</div>
<input type="hidden" id="edit_monthwise_att_empno" name="edit_monthwise_att_empno" value="<?php echo $emp_id; ?>">


