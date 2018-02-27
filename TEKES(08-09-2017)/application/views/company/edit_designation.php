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
                    $("#edit_designation_department").html(html);
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
                    $("#edit_designation_client").html(html);
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
                    $("#edit_designation_subprocess").html(html);
                }
            });
        }
    }

</script>

<?php
$this->db->where('Designation_Id', $designation_id);
$q = $this->db->get('tbl_designation');
foreach ($q->result() as $row) {

    $designation_name = $row->Designation_Name;

    $client_id = $row->Client_Id;

    $this->db->where('Subdepartment_Id', $client_id);
    $q_subdept = $this->db->get('tbl_subdepartment');
    foreach ($q_subdept->result() as $row_subdept) {
        $client_name = $row_subdept->Client_Name;
        $subprocess = $row_subdept->Subdepartment_Name;
        $department_id = $row_subdept->Department_Id;
    }


    $this->db->where('Department_Id', $department_id);
    $q_dept = $this->db->get('tbl_department');
    foreach ($q_dept->result() as $row_dept) {
        $department_name = $row_dept->Department_Name;
        $company_id = $row_dept->Company_Id;
        $branch_id = $row_dept->Branch_Id;
    }

    $this->db->where('Company_Id', $company_id);
    $q_company = $this->db->get('tbl_company');
    foreach ($q_company->result() as $row_company) {
        $company_name = $row_company->Company_Name;
    }


    $this->db->where('Branch_ID', $branch_id);
    $q_branch = $this->db->get('tbl_branch');
    foreach ($q_branch->result() as $row_branch) {
        $branch_name = $row_branch->Branch_Name;
    }

    $grade_name = $row->Grade;
    $role = $row->Role;
    $notice_period = $row->Notice_Period;
}

$data_branch = array(
    'Branch_ID !=' => $branch_id,
    'Status' => 1
);
$this->db->where($data_branch);
$select_branch_exp = $this->db->get('tbl_branch');

$data_department = array(
    'Branch_ID' => $branch_id,
    'Department_Id !=' => $department_id,
    'Status' => 1
);
$this->db->where($data_department);
$select_department_exp = $this->db->get('tbl_department');

$data_subdepartment = array(
    'Department_Id' => $department_id,
    'Subdepartment_Id !=' => $client_id,
    'Status' => 1
);
$this->db->where($data_subdepartment);
$select_subdepartment_exp = $this->db->get('tbl_subdepartment');
?>

<script>
    $(document).ready(function () {
        $('#editdesignation_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_designation_id: $('#edit_designation_id').val(),
                branch_name: $('#edit_designation_branch').val(),
                department_name: $('#edit_designation_department').val(),
                client_name: $('#edit_designation_client').val(),
                sub_process: $('#edit_designation_subprocess').val(),
                edit_designation_name: $('#edit_designation_name').val(),
                edit_grade_name: $('#edit_grade_name').val(),
                edit_role_name: $('#edit_role_name').val(),
                edit_notice_period: $('#edit_notice_period').val()

            };
            $.ajax({
                url: "<?php echo site_url('Company/edit_designation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editdesignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#editdesignation_success').show();
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
            <div id="editdesignation_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editdesignation_success" class="alert alert-success" style="display:none;">Designation details updated successfully.</div>
            <div id="editdesignation_error" class="alert alert-danger" style="display:none;">Failed to designation branch details.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="edit_designation_id" id="edit_designation_id" value="<?php echo $designation_id; ?>">

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-2" class="control-label">Branch</label>
                <select name="edit_designation_branch" id="edit_designation_branch" class="round" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                    <option value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option>
                    <?php foreach ($select_branch_exp->result() as $row_branch_exp) { ?>
                        <option value="<?php echo $row_branch_exp->Barnch_ID; ?>"><?php echo $row_branch_exp->Branch_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Department</label>
                <select name="edit_designation_department" id="edit_designation_department" class="round" data-validate="required" data-message-required="Please select department." onChange="showClient(this);">
                    <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                    <?php foreach ($select_department_exp->result() as $row_department_exp) { ?>
                        <option value="<?php echo $row_department_exp->Department_Id; ?>"><?php echo $row_department_exp->Department_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Client</label>
                <select name="edit_designation_client" id="edit_designation_client" class="round" data-validate="required" data-message-required="Please select client." onChange="showSubprocess(this);">
                    <option value="<?php echo $client_id; ?>"><?php echo $client_name; ?></option>
                    <?php foreach ($select_subdepartment_exp->result() as $row_subdepartment_exp) { ?>
                        <option value="<?php echo $row_subdepartment_exp->Subdepartment_Id; ?>"><?php echo $row_subdepartment_exp->Client_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Sub Process</label>
                <select name="edit_designation_subprocess" id="edit_designation_subprocess" class="round" data-validate="required" data-message-required="Please select sub process.">
                    <option value="<?php echo $client_id; ?>"><?php echo $subprocess; ?></option>
                    <?php foreach ($select_subdepartment_exp->result() as $row_subdepartment_exp) { ?>
                        <option value="<?php echo $row_subdepartment_exp->Subdepartment_Id; ?>"><?php echo $row_subdepartment_exp->Subdepartment_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

    </div>
    <div class="row">


        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Designation</label>
                <input type="text" name="edit_designation_name" id="edit_designation_name" class="form-control" data-validate="required" data-message-required="Please enter designation." value="<?php echo $designation_name; ?>">
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Role</label>
                <input type="text" name="edit_role_name" id="edit_role_name" class="form-control" data-validate="required" data-message-required="Please enter role." value="<?php echo $role; ?>">
            </div>	
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="field-3" class="control-label">Grade</label>
                <input type="text" name="edit_grade_name" id="edit_grade_name" class="form-control" data-validate="required" data-message-required="Please enter grade." value="<?php echo $grade_name; ?>">
            </div>	
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="field-3" class="control-label">Notice Period</label>
                <div class="input-group">
                    <input type="text" name="edit_notice_period" id="edit_notice_period" class="form-control" data-validate="required,number" data-message-required="Please enter notice period." value="<?php echo $notice_period; ?>">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary">Days</button>
                    </span>
                </div>
            </div>	
        </div>

    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

