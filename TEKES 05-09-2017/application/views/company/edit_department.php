<?php
$this->db->where('Department_Id', $department_id);
$q = $this->db->get('tbl_department');
foreach ($q->result() as $row) {

    $department_name = $row->Department_Name;

    $company_id = $row->Company_Id;

    $this->db->where('Company_Id', $company_id);
    $q_company = $this->db->get('tbl_company');
    foreach ($q_company->result() as $row_company) {
        $company_name = $row_company->Company_Name;
    }

    $branch_id = $row->Branch_Id;

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
?>

<script>
    $(document).ready(function () {
        $('#editdepartment_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_department_id: $('#edit_department_id').val(),
                company_name: $('#edit_department_company').val(),
                branch_name: $('#edit_department_branch').val(),
                edit_department_name: $('#edit_department_name').val()

            };
            $.ajax({
                url: "<?php echo site_url('Company/edit_department') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editdepartment_error').show();
                    }
                    if (msg == 'success') {
                        $('#editdepartment_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#editdepartment_server_error').html(msg);
                        $('#editdepartment_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editdepartment_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editdepartment_success" class="alert alert-success" style="display:none;">Department details updated successfully.</div>
            <div id="editdepartment_error" class="alert alert-danger" style="display:none;">Failed to department branch details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="field-1" class="control-label">Company</label>
                <select name="edit_department_company" id="edit_department_company" class="round" onChange="showBranch(this);" data-validate="required" data-message-required="Please select company.">
                    <option value="<?php echo $company_id; ?>"><?php echo $company_name; ?></option>

                </select>
            </div>	
        </div>

        <input type="hidden" name="edit_department_id" id="edit_department_id" value="<?php echo $department_id; ?>">

        <div class="col-md-6">
            <div class="form-group">
                <label for="field-2" class="control-label">Branch</label>
                <select name="edit_department_branch" id="edit_department_branch" class="round" data-validate="required" data-message-required="Please select branch.">
                    <option value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option>
                    <?php foreach ($select_branch_exp->result() as $row_branch_exp) { ?>
                        <option value="<?php echo $row_branch_exp->Branch_ID; ?>"><?php echo $row_branch_exp->Branch_Name; ?></option>
                    <?php } ?>
                </select>

            </div>	
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Department</label>
                <input type="text" name="edit_department_name" id="edit_department_name" class="form-control" data-validate="required" data-message-required="Please enter department." value="<?php echo $department_name; ?>">
            </div>	
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

