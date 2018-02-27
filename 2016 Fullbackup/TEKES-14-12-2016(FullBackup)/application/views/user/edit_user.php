<?php
$emp_id = str_pad(($emp_no), 4, '0', STR_PAD_LEFT);
$this->db->where('Employee_Id', $emp_id);
$q = $this->db->get('tbl_user');
foreach ($q->result() as $row) {
    $user_role_id = $row->User_RoleId;
    $User_Photo = $row->User_Photo;
}
$this->db->where('Role_Id', $user_role_id);
$q_userrole = $this->db->get('tbl_user_role');
foreach ($q_userrole->result() as $row_userrole) {
    $role_name = $row_userrole->Role_Name;
}

$this->db->where('employee_number', $emp_id);
$q_code = $this->db->get('tbl_emp_code');
foreach ($q_code->result() as $row_code) {
    $emp_code = $row_code->employee_code;
}

$this->db->where('Emp_Number', $emp_id);
$q_emplo = $this->db->get('tbl_employee');
foreach ($q_emplo->result() as $row_emplo) {
    $Emp_FirstName = $row_emplo->Emp_FirstName;
     $Emp_LastName = $row_emplo->Emp_LastName;
}

$this->db->where('Employee_Id', $emp_id);
$q_employee = $this->db->get('tbl_employee_career');
foreach ($q_employee->result() as $row_employee) {
    $branch_id = $row_employee->Branch_Id;
    $this->db->where('Branch_ID', $branch_id);
    $q_branch = $this->db->get('tbl_branch');
    foreach ($q_branch->result() as $row_branch) {
        $branch_name = $row_branch->Branch_Name;
    }
}

 $data_userole = array(
                'Role_Id !=' => $user_role_id,
                'Status' => 1
            );
$this->db->where($data_userole);
$select_userole_exp = $this->db->get('tbl_user_role');

?>


<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edituser_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edituser_success" class="alert alert-success" style="display:none;">User details updated successfully.</div>
            <div id="edituser_error" class="alert alert-danger" style="display:none;">Failed to update user details.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="edit_emp_id" id="edit_emp_id" value="<?php echo $emp_id; ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Branch Name </label>
                <select name="edit_branch_name" id="edit_branch_name" class="round" data-validate="required" data-message-required="Please select branch name.">
                    <option value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Code </label>
                <input type="text" name="edit_emp_code" id="edit_emp_code" class="form-control" value="<?php echo $emp_code . $emp_id ?>" disabled>
            </div>	
        </div>
        
         <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Name </label>
                <input type="text" name="edit_emp_name" id="edit_emp_name" class="form-control" value="<?php echo $Emp_FirstName . " " . $Emp_LastName ?>" disabled>
            </div>	
        </div>

        
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Role</label>
                <select name="edit_user_role" id="edit_user_role" class="round" data-validate="required" data-message-required="Please select user role.">
                    <option value="<?php echo $user_role_id; ?>"><?php echo $role_name; ?></option>
                     <?php foreach ($select_userole_exp->result() as $row_userole_exp) { ?>
                        <option value="<?php echo $row_userole_exp->Role_Id; ?>"><?php echo $row_userole_exp->Role_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-6" class="control-label">User Photo</label>
                <div style="max-width: 200px; max-height: 150px;float:right" class="fileinput-preview fileinput-exists thumbnail">
                    <img src="<?php echo site_url('user_img/' . $User_Photo); ?>" style="max-width: 200px; max-height: 95px;">
                </div>
                <a class="file-input-wrapper btn form-control file2 inline btn btn-primary"><i class="glyphicon glyphicon-file"></i> Browse
                    <input type="file" id="userfile" name="userfile" data-label="&lt;i class='glyphicon glyphicon-file'&gt;&lt;/i&gt; Browse" class="form-control file2 inline btn btn-primary" style="left: 47.6667px; top: -0.25px;">
                </a>
            </div>	
        </div>
    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


<script type="text/javascript">
    $(document).ready(function (e) {
        $("#edituser_form").on('submit', (function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo site_url('User/edit_user') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#edituser_error').show();
                    }
                    else {
                        $('#edituser_error').hide();
                        $('#edituser_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>