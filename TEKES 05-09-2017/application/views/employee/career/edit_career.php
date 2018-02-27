<?php
$this->db->where('Career_Id', $career_id);
$q_career = $this->db->get('tbl_employee_career');
foreach ($q_career->result() as $row_career) {
    $branch_id = $row_career->Branch_Id;
    $department_id = $row_career->Department_Id;
    $client_id = $row_career->Client_Id;
    $designation_id = $row_career->Designation_Id;
    $report_to_id = $row_career->Reporting_To;
    $from_date = $row_career->From;
    $from = date("d-m-Y", strtotime($from_date));
    $to_date = $row_career->To;
    if ($to_date == "0000-00-00") {
        $to = "";
    } else {
        $to = date("d-m-Y", strtotime($to_date));
    }

    $this->db->where('Designation_Id', $designation_id);
    $q_designation = $this->db->get('tbl_designation');
    foreach ($q_designation->result() as $row_designation) {
        $designation_name = $row_designation->Designation_Name;
        $emp_grade_id = $row_designation->Designation_Id;
        $grade_name = $row_designation->Grade;
        $dept_role_id = $row_designation->Designation_Id;
        $dept_role = $row_designation->Role;
        $subdepartment_id = $row_designation->Client_Id;

        $this->db->where('Subdepartment_Id', $subdepartment_id);
        $q_subdept = $this->db->get('tbl_subdepartment');
        foreach ($q_subdept->result() as $row_subdept) {
            $subdepartment_name = $row_subdept->Subdepartment_Name;
            $client_name = $row_subdept->Client_Name;
        }
    }
    $this->db->where('Department_Id', $department_id);
    $q_dept = $this->db->get('tbl_department');
    foreach ($q_dept->result() as $row_dept) {
        $department_name = $row_dept->Department_Name;
    }

    $this->db->where('Branch_ID', $branch_id);
    $q_branch = $this->db->get('tbl_branch');
    foreach ($q_branch->result() as $row_branch) {
        $branch_name = $row_branch->Branch_Name;
    }

    $this->db->where('Emp_Number', $report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $reporting_name = $row_emp->Emp_FirstName;
    }
}

$data_branch = array(
    'Branch_ID !=' => $branch_id,
    'Status' => 1
);
$this->db->where($data_branch);
$select_branch_exp = $this->db->get('tbl_branch');

$data_dept = array(
    'Branch_ID' => $branch_id,
    'Department_Id !=' => $department_id,
    'Status' => 1
);
$this->db->where($data_dept);
$select_dept_exp = $this->db->get('tbl_department');

$data_client = array(
    'Department_Id' => $department_id,
    'Subdepartment_Id !=' => $client_id,
    'Status' => 1
);
$this->db->where($data_client);
$select_client_exp = $this->db->get('tbl_subdepartment');

$data_subdept = array(
    'Department_Id' => $department_id,
    'Subdepartment_Id !=' => $subdepartment_id,
    'Status' => 1
);
$this->db->where($data_subdept);
$select_subdept_exp = $this->db->get('tbl_subdepartment');

$data_report = array(
    'Emp_Number !=' => $report_to_id,
    'Status' => 1
);
$this->db->where($data_report);
$select_report_exp = $this->db->get('tbl_employee');
?>

<script>
    function showDepartment(sel) {
        var branch_id = sel.options[sel.selectedIndex].value;
        if (branch_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_department') ?>",
                data: "branch_id=" + branch_id,
                cache: false,
                success: function (html) {
                    $("#edit_career_department").html(html);
                }
            });
        }
    }

    function showClient(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_client') ?>",
                data: "dept_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_career_client").html(html);
                }
            });
        }
    }

    function showSubprocess(sel) {
        var client_id = sel.options[sel.selectedIndex].value;
        if (client_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_subprocess') ?>",
                data: "client_id=" + client_id,
                cache: false,
                success: function (html) {
                    $("#edit_career_subprocess").html(html);
                }
            });
        }
    }

    function showDesignation(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_designation') ?>",
                data: "subdept_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_career_designation").html(html);
                }
            });
        }
    }

    function showGrade(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_grade') ?>",
                data: "designation_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_career_grade").html(html);
                }
            });
        }
    }

    function showDepartmentRole(sel) {
        var dept_id = sel.options[sel.selectedIndex].value;
        if (dept_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_departmentrole') ?>",
                data: "grade_id=" + dept_id,
                cache: false,
                success: function (html) {
                    $("#edit_career_departmentrole").html(html);
                }
            });
        }
    }

</script>

<script>
    $(document).ready(function () {
        $('#editcareer_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_career_id: $('#edit_career_id').val(),
                edit_career_branch: $('#edit_career_branch').val(),
                edit_career_department: $('#edit_career_department').val(),
                edit_career_client: $('#edit_career_client').val(),
                edit_career_subprocess: $('#edit_career_subprocess').val(),
                edit_career_designation: $('#edit_career_designation').val(),
                edit_career_grade: $('#edit_career_grade').val(),
                edit_career_departmentrole: $('#edit_career_departmentrole').val(),
                edit_career_reporting_to: $('#edit_career_reporting_to').val(),
                edit_career_from: $('#edit_career_from').val(),
                edit_career_to: $('#edit_career_to').val()
            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_career') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editcareer_error').show();
                    }
                    if (msg == 'success') {
                        $('#editcareer_success').show();
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
            <div id="editcareer_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editcareer_success" class="alert alert-success" style="display:none;">Career details updated successfully.</div>
            <div id="editcareer_error" class="alert alert-danger" style="display:none;">Failed to update branch details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-1" class="control-label">Branch</label>
                <select class="round" name="edit_career_branch" id="edit_career_branch" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                    <option value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option>
                    <?php foreach ($select_branch_exp->result() as $row_branch_exp) { ?>
                        <option value="<?php echo $row_branch_exp->Branch_ID; ?>"><?php echo $row_branch_exp->Branch_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>
        <input type="hidden" name="edit_career_id" id="edit_career_id" value="<?php echo $career_id; ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">Department</label>
                <select name="edit_career_department" id="edit_career_department" class="round" onChange="showClient(this);" data-validate="required" data-message-required="Please select department.">
                    <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                    <?php foreach ($select_dept_exp->result() as $row_dept_exp) { ?>
                        <option value="<?php echo $row_dept_exp->Department_Id; ?>"><?php echo $row_dept_exp->Department_Name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">Client</label>
                <select name="edit_career_client" id="edit_career_client" class="round" onChange="showSubprocess(this);" data-validate="required" data-message-required="Please select client.">
                    <option value="<?php echo $client_id; ?>"><?php echo $client_name; ?></option>
                    <?php foreach ($select_client_exp->result() as $row_client_exp) { ?>
                        <option value="<?php echo $row_client_exp->Subdepartment_Id; ?>"><?php echo $row_client_exp->Client_Name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Sub Process</label>
                <select name="edit_career_subprocess" id="edit_career_subprocess" class="round" onChange="showDesignation(this);" data-validate="required" data-message-required="Please select sub process.">
                    <option value="<?php echo $subdepartment_id; ?>"><?php echo $subdepartment_name; ?></option>
                    <?php foreach ($select_subdept_exp->result() as $row_subdept_exp) { ?>
                        <option value="<?php echo $row_subdept_exp->Subdepartment_Id; ?>"><?php echo $row_subdept_exp->Subdepartment_Name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">Designation</label>
                <select name="edit_career_designation" id="edit_career_designation" class="round" onChange="showGrade(this);" data-validate="required" data-message-required="Please select designation.">
                    <option value="<?php echo $designation_id; ?>"><?php echo $designation_name; ?></option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Grade</label>
                <select name="edit_career_grade" id="edit_career_grade" class="round" onChange="showDepartmentRole(this);" data-validate="required" data-message-required="Please select grade.">
                    <option value="<?php echo $emp_grade_id; ?>"><?php echo $grade_name; ?></option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Role</label>
                <select name="edit_career_departmentrole" id="edit_career_departmentrole" class="round" data-validate="required" data-message-required="Please select role.">
                    <option value="<?php echo $dept_role_id; ?>"><?php echo $dept_role; ?></option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Reporting To</label>
                <select name="edit_career_reporting_to" id="edit_career_reporting_to" class="round" data-validate="required" data-message-required="Please select reporting manager.">
                    <option value="<?php echo $report_to_id; ?>"><?php echo $reporting_name; ?></option>
                    <?php foreach ($select_report_exp->result() as $row_report_exp) { ?>
                        <option value="<?php echo $row_report_exp->Emp_Number; ?>"><?php echo $row_report_exp->Emp_FirstName; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">From</label>
                <div class="input-group">
                    <input type="text" name="edit_career_from" id="edit_career_from" class="form-control datepicker" placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date." value="<?php echo $from; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">To</label>
                <div class="input-group">
                    <input type="text" name="edit_career_to" id="edit_career_to" class="form-control datepicker"  placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date." value="<?php echo $to; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>