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
                    $("#edit_subdept_department").html(html);
                }
            });
        }
    }
</script>
<?php
$this->db->where('Subdepartment_Id', $subdepartment_id);
$q = $this->db->get('tbl_subdepartment');
foreach ($q->result() as $row) {

    $subdepartment_name = $row->Subdepartment_Name;
    $department_id = $row->Department_Id;
    $client_name = $row->Client_Name;
	//$edit_process = $row->Process;

    $this->db->where('Department_Id', $department_id);
    $q_dept = $this->db->get('tbl_department');
    foreach ($q_dept->result() as $row_dept) {
        $department_name = $row_dept->Department_Name;
        $branch_id = $row_dept->Branch_Id;
    }

    $this->db->where('Branch_ID', $branch_id);
    $q_branch = $this->db->get('tbl_branch');
    foreach ($q_branch->result() as $row_branch) {
        $branch_name = $row_branch->Branch_Name;
    }
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
?>

<script>
    $(document).ready(function () {
        $('#editsubdepartment_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_subdepartment_id: $('#edit_subdepartment_id').val(),
                branch_name: $('#edit_subdept_branch').val(),
                department_name: $('#edit_subdept_department').val(),
                client_name: $('#edit_client_name').val(),
                edit_subdepartment_name: $('#edit_subdepartment_name').val(),
				//edit_process: $('#edit_process').val()

            };
            $.ajax({
                url: "<?php echo site_url('Company/edit_subdepartment') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editsubdepartment_error').show();
                    }
                    if (msg == 'success') {
                        $('#editsubdepartment_success').show();
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
            <div id="editsubdepartment_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editsubdepartment_success" class="alert alert-success" style="display:none;">Sub department details updated successfully.</div>
            <div id="editsubdepartment_error" class="alert alert-danger" style="display:none;">Failed to sub department branch details.</div>
        </div>
    </div>

    <div class="row">
       
        <input type="hidden" name="edit_subdepartment_id" id="edit_subdepartment_id" value="<?php echo $subdepartment_id; ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Branch</label>
                <select name="edit_subdept_branch" id="edit_subdept_branch" class="round" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                    <option value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option>
                    <?php foreach ($select_branch_exp->result() as $row_branch_exp) { ?>
                        <option value="<?php echo $row_branch_exp->Branch_ID; ?>"><?php echo $row_branch_exp->Branch_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Department</label>
                <select name="edit_subdept_department" id="edit_subdept_department" class="round" data-validate="required" data-message-required="Please select department." >
                    <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                    <?php foreach ($select_department_exp->result() as $row_department_exp) { ?>
                        <option value="<?php echo $row_department_exp->Department_Id; ?>"><?php echo $row_department_exp->Department_Name; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Client</label>
                <input type="text" name="edit_client_name" id="edit_client_name" class="form-control" data-validate="required" data-message-required="Please enter client." value="<?php echo $client_name; ?>">
            </div>	
        </div>
    </div>
    <div class="row">
	    <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Sub Department</label>
                <input type="text" name="edit_subdepartment_name" id="edit_subdepartment_name" class="form-control" data-validate="required" data-message-required="Please enter sub department." value="<?php echo $subdepartment_name; ?>">
            </div>	
        </div>
		<!--<div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Process</label>
                <input type="text" name="edit_process" id="edit_process" class="form-control" data-validate="required" data-message-required="Please enter process" value="<?php echo $edit_process; ?>">
            </div>	
        </div>-->
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

