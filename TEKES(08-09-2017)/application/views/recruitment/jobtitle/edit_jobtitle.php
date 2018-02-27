<?php
$this->db->where('J_Id', $J_Id);
$q = $this->db->get('tbl_Jobtitle');
foreach ($q->result() as $row) {
    $edit_department_name = $row->Department_Name;
    $edit_subdept_department = $row->Subdepartment_Name;
    $edit_jobtitle = $row->Jobtitle;
    $edit_jobtype = $row->Jobtype;
    $edit_jobtitle_process = $row->Process;
}
?>
<script>
    $(document).ready(function () {
        $('#editjobtitle_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_jobtitle_id: $('#edit_jobtitle_id').val(),
                edit_department_name: $('#edit_department_name').val(),
                edit_subdept_department: $('#edit_subdept_department').val(),
                edit_jobtitle_name: $('#edit_jobtitle_name').val(),
                edit_jobtype: $('#edit_jobtype').val(),
                edit_jobtitle_process: $('#edit_jobtitle_process').val()
            };
            $.ajax({
                url: "<?php echo site_url('Recruitment/edit_jobtitle') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_jobtitle_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_jobtitle_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_jobtitle_server_error').html(msg);
                        $('#edit_jobtitle_server_error').show();
                    }
                }
            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_jobtitle_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_jobtitle_success" class="alert alert-success" style="display:none;">Job Title details updated successfully.</div>
            <div id="edit_jobtitle_error" class="alert alert-danger" style="display:none;">Failed to update Job Title details.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_jobtitle_id" id="edit_jobtitle_id" value="<?php echo $J_Id; ?>">
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-3" class="control-label">Department Name</label>
                <select id="edit_department_name" name="edit_department_name" class="round" data-validate="required" data-message-required="Please select department.">                                       
                    <?php
                    $this->db->order_by('Department_Id', 'desc');
                    $this->db->group_by('Department_Name');
                    $this->db->where('Status', 1);
                    $q_department = $this->db->get('tbl_department');
                    foreach ($q_department->Result() as $row_department) {
                        $department_name = $row_department->Department_Name;
                        $department_id = $row_department->Department_Id;                       
                        ?>                                                                                             
                        <option value="<?php echo $department_id; ?>" <?php
                            if ($edit_department_name == $department_id) {
                                echo "selected=selected";
                            }
                            ?>>
                            <?php echo $department_name; ?></option>
                        <?php
                    }
                    ?>
                </select>                             
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Sub Department</label>
                <select id="edit_subdept_department" name="edit_subdept_department" class="round" data-validate="required" data-message-required="Please select sub-department.">
                    <option value="">Sub Department</option>
                    <?php
                    $this->db->order_by('Subdepartment_Id', 'desc');
                    $this->db->group_by('Subdepartment_Name');
                    $this->db->where('Status', 1);
                    $q_subdepartment = $this->db->get('tbl_subdepartment');
                    foreach ($q_subdepartment->Result() as $row_subdepartment) {
                        $subdepartment_name = $row_subdepartment->Subdepartment_Name;
                        $subdepartment_id = $row_subdepartment->Subdepartment_Id;
                        $department_id = $row_subdepartment->Department_Id;
                        ?>                        
                        <option value="<?php echo $subdepartment_id; ?>" <?php
                            if ($edit_subdept_department == $subdepartment_id) {
                                echo "selected=selected";
                            }
                            ?>>
                            <?php echo $subdepartment_name; ?></option>                         
                        <?php
                    }
                    ?>                                            
                </select>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-1" class="control-label">Job Title</label>
                <select name="edit_jobtitle_name" id="edit_jobtitle_name" class="round" data-validate="required" data-message-required="Please Select jobtitle">
                    <option value="">Select Jobtitle</option>
                    <?php
                    $this->db->order_by('Designation_Id', 'desc');
                    $this->db->group_by('Designation_Name');
                    $this->db->where('Status', 1);
                    $q_designation = $this->db->get('tbl_designation');
                    foreach ($q_designation->Result() as $row_designation) {
                        $designation_name = $row_designation->Designation_Name;
                        $designation_id = $row_designation->Designation_Id;
                        $role = $row_designation->Role;
                        ?>                        
                        
                        <option value="<?php echo $designation_id; ?>" <?php
                            if ($edit_jobtitle == $designation_id) {
                                echo "selected=selected";
                            }
                            ?>>
                            <?php echo $designation_name; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>	
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Job Type</label>
                <select id="edit_jobtype" name="edit_jobtype" class="round" data-validate="required" data-message-required="Please select jobtype">
                    <option value="<?php echo $edit_jobtype; ?>"><?php echo $edit_jobtype; ?></option>
                    <option value="">Select Jobtype</option>
                    <option value="Permanent">Permanent</option>
                    <option value="Contract">Contract</option>
                    <option value="Project Based">Project Based</option>
                    <option value="Other">Other</option>                                            
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Process</label>
                <input type="text" name="edit_jobtitle_process" id="edit_jobtitle_process" class="form-control" data-validate="required" value="<?php echo $edit_jobtitle_process; ?>" >
            </div>	
        </div>
    </div>    
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>