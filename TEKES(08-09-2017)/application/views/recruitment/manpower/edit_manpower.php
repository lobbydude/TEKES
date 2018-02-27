<?php
$this->db->where('MP_Id', $MP_Id);
$q = $this->db->get('tbl_manpower_requisition');
foreach ($q->result() as $row) {
    $edit_jobpost_interview_date = $row->Requisition_Date;
    $edit_jobpost_request_person_name = $row->Requisition_Name;
    $edit_jobpost_department_name = $row->Department_Name;
    $edit_jobpost_subdepartment_name = $row->Sub_Department_Name;
    
    $edit_jobpost_title_name = $row->Job_Title;    
    $edit_jobpost_type = $row->Job_Type;        
    $edit_jobpost_positions = $row->Positions;
    $edit_jobpost_skills = $row->Job_Skills;
    
    $edit_jobpost_location = $row->Job_Location;
    $edit_jobpost_qualification = $row->Qualification;
    $edit_jobpost_experience = $row->Experience;   
    $edit_jobpost_salary = $row->Salary;
    $edit_jobpost_gender = $row->Gender;
    
    $edit_jobpost_working_hour = $row->Working_Hours;    
    $edit_jobpost_shift_time = $row->Shift_Time;
    $edit_jobpost_jobdescription = $row->Job_Description;
    $edit_jobpost_otherinformation = $row->Other_Information; 
}
?>
<script>
    $(document).ready(function () {
        $('#editjobpost_Requisitions_form').submit(function (e) {
            e.preventDefault();
            var formdata = {                  
                edit_jobpost_id: $('#edit_jobpost_id').val(),
                edit_jobpost_interview_date: $('#edit_jobpost_interview_date').val(),
                edit_jobpost_request_person_name: $('#edit_jobpost_request_person_name').val(),
                edit_jobpost_department_name: $('#edit_jobpost_department_name').val(),  
                edit_jobpost_subdepartment_name: $('#edit_jobpost_subdepartment_name').val(),
                
                edit_jobpost_title_name: $('#edit_jobpost_title_name').val(),
                edit_jobpost_type: $('#edit_jobpost_type').val(),                
                edit_jobpost_positions: $('#edit_jobpost_positions').val(),
                edit_jobpost_location: $('#edit_jobpost_location').val(),                
                edit_jobpost_skills: $('#edit_jobpost_skills').val(),
                
                edit_jobpost_qualification: $('#edit_jobpost_qualification').val(),
                edit_jobpost_experience: $('#edit_jobpost_experience').val(),
                edit_jobpost_salary: $('#edit_jobpost_salary').val(),                
                edit_jobpost_gender: $('#edit_jobpost_gender').val(),
                edit_jobpost_shift_time: $('#edit_jobpost_shift_time').val(),
                
                edit_jobpost_jobdescription: $('#edit_jobpost_jobdescription').val(),                
                edit_jobpost_otherinformation: $('#edit_jobpost_otherinformation').val()                  
            };
            $.ajax({
                url: "<?php echo site_url('Manpower/edit_jobpost') ?>",                
                type: 'post',
                data: formdata,
                success: function (msg) {  
                    
                    if (msg == 'fail') {
                        $('#edit_jobpost_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_jobpost_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_jobpost_server_error').html(msg);
                        $('#edit_jobpost_server_error').show();
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_jobpost_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_jobpost_success" class="alert alert-success" style="display:none;">Job Post details updated successfully.</div>
            <div id="edit_jobpost_error" class="alert alert-danger" style="display:none;">Failed to update Job Post details.</div>
        </div>
    </div>
        <input type="hidden" name="edit_jobpost_id" id="edit_jobpost_id" value="<?php echo $MP_Id; ?>">        
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label" for="interviewdate">Request Date</label>
                    <div class="input-group">
                        <input type="text" name="edit_jobpost_interview_date" id="edit_jobpost_interview_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" value="<?php echo $edit_jobpost_interview_date; ?>">
                        <div class="input-group-addon">
                            <a href="#"><i class="entypo-calendar"></i></a>
                        </div>
                    </div>
                </div>
            </div>                                  

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Request Person Name</label>
                    <select name="edit_jobpost_request_person_name" id="edit_jobpost_request_person_name" class="round">
                        <option value="">Please Select</option>
                        <?php
                        $this->db->where('Status', 1);
                        $select_emp = $this->db->get('tbl_employee');
                        foreach ($select_emp->result() as $row_emp) {
                            $emp_no_list = $row_emp->Emp_Number;
                            $emp_firstname = $row_emp->Emp_FirstName;
                            $emp_middlename = $row_emp->Emp_MiddleName;
                            $emp_lastname = $row_emp->Emp_LastName;

                            $this->db->where('employee_number', $emp_no_list);
                            $q_empcode = $this->db->get('tbl_emp_code');
                            foreach ($q_empcode->result() as $row_empcode) {
                                $emp_code = $row_empcode->employee_code;
                                $start_number = $row_empcode->employee_number;
                                $emp_id = str_pad(($start_number), 4, '0', STR_PAD_LEFT);
                            }
                            ?>
                                    
                            <option value="<?php echo $emp_id; ?>" <?php
                            if ($edit_jobpost_request_person_name == $emp_id) {
                                echo "selected=selected";
                            }
                            ?>>
                                <?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Department Name</label>
                    <select id="edit_jobpost_department_name" name="edit_jobpost_department_name" class="round">
                        <option value="">Select Department</option>
                        <?php
                        $this->db->order_by('J_Id', 'desc');
                        $this->db->group_by('Department_Name');
                        $this->db->where('Status', 1);
                        $q_department = $this->db->get('tbl_jobtitle');
                        foreach ($q_department->Result() as $row_department) {
                            $department_jobtitle = $row_department->Department_Name;
                            $department_id = $row_department->S_Id;
                            // Department Name get the value
                            $this->db->where('Department_Id', $department_jobtitle);
                            $q_dept = $this->db->get('tbl_department');
                            foreach ($q_dept->result() as $row_dept) {
                                $department_name = $row_dept->Department_Name;
                            }
                            ?>
                            <option value="<?php echo $department_jobtitle; ?>" <?php
                            if ($edit_jobpost_department_name == $department_jobtitle) {
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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Sub Department Name</label>
                    <select id="edit_jobpost_subdepartment_name" name="edit_jobpost_subdepartment_name" class="round">                                                
                        <option value="">Select Sub Department</option>
                        <?php
                        $this->db->order_by('Subdepartment_Id', 'desc');
                        $this->db->group_by('Subdepartment_Name');
                        $this->db->where('Status', 1);
                        $q_subdepartment = $this->db->get('tbl_subdepartment');
                        foreach ($q_subdepartment->Result() as $row_subdepartment) {
                            $department_id = $row_subdepartment->Department_Id;
                            $subdepartment_name = $row_subdepartment->Subdepartment_Name;
                            $subdepartment_id = $row_subdepartment->Subdepartment_Id;
                            ?>                                           
                            <option value="<?php echo $subdepartment_id; ?>" <?php
                            if ($edit_jobpost_subdepartment_name == $subdepartment_id) {
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
        </div><!-- first row Close-->
								
        <div class="row"><!-- Second row Start-->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-1" class="control-label">Job Title</label>
                    <select name="edit_jobpost_title_name" id="edit_jobpost_title_name" class="round">
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
                        if ($edit_jobpost_title_name == $designation_id) {
                            echo "selected=selected";
                        }
                        ?>>
                            <?php echo $designation_name . " ($role)"; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>	
            </div>                                     
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Job Type</label>
                    <select id="edit_jobpost_type" name="edit_jobpost_type" class="round" >
                        <option value="<?php echo $edit_jobpost_type; ?>"><?php echo $edit_jobpost_type; ?></option>
                        <option value="">Select Jobtype</option>
                        <option value="Permanent">Permanent</option>
                        <option value="Contract">Contract</option>
                        <option value="Project Based">Project Based</option>
                        <option value="Other">Other</option>                                            
                    </select>
                </div>
            </div>                                    
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">No.of.Positions</label>
                    <input type="text" name="edit_jobpost_positions" id="edit_jobpost_positions" class="form-control" value="<?php echo $edit_jobpost_positions; ?>">
                </div>	
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Job Skills</label>                                        
                    <textarea class="form-control" name="edit_jobpost_skills" id="edit_jobpost_skills"><?php echo $edit_jobpost_skills; ?></textarea>
                </div>	
            </div>
        </div><!-- Second row Close-->

        <div class="row"><!-- Third row Start-->
            <div class="col-md-2">
                <div class="form-group">
                    <label for="field-3" class="control-label">Job Location</label>
                    <input type="text" name="edit_jobpost_location" id="edit_jobpost_location" class="form-control" value="<?php echo $edit_jobpost_location;?>">
                </div>	
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="field-3" class="control-label">Qualification</label>
                    <!--<input type="text" name="edit_jobpost_qualification" id="edit_jobpost_qualification" class="form-control" value="<?php //echo $edit_jobpost_qualification;?>">-->
                    <select id="edit_jobpost_qualification" name="edit_jobpost_qualification" class="round" >
                        <option value="<?php echo $edit_jobpost_type;?>"><?php echo $edit_jobpost_qualification; ?></option>
                        <option value="">Select Qualification</option>
                        <option value="Degree">Any Degree</option>
                        <option value="BE">B.E</option>
                        <option value="MCA">MCA</option>                                            
                    </select>
                </div>	
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="field-3" class="control-label">Experience</label>
                    <!--<input type="text" name="edit_jobpost_experience" id="edit_jobpost_experience" class="form-control" value="<?php echo $edit_jobpost_experience;?>">-->
                    <select id="edit_jobpost_experience" name="edit_jobpost_experience" class="round" >
                        <option value="<?php echo $edit_jobpost_experience;?>"><?php echo $edit_jobpost_experience; ?></option>
                        <option value="0-1Year">0-1Year</option>
                        <option value="1-2Year">1-2Year</option>
                        <option value="2-3Year">2-3Year</option>
                        <option value="2-3Year">2-3Year</option>
                        <option value="3-4Year">3-4Year</option>
                        <option value="4-5Year">4-5Year</option>
                        <option value="5-6Year">5-6Year</option>
                        <option value="6-7Year">6-7Year</option>                                            
                    </select>
                </div>	
            </div>                                     
            <div class="col-md-3">                                        
                <div class="form-group">
                    <label for="field-1" class="control-label">Salary</label>
                    <select name="edit_jobpost_salary" id="edit_jobpost_salary" class="round" data-validate="required" data-message-required="Please Select Salary">
                        <option value="<?php echo $edit_jobpost_salary; ?>"><?php echo $edit_jobpost_salary; ?></option>                        
                        <option value="Salary">Select Salary</option>
                        <option value="100000-150000">100000-150000</option>
                        <option value="150000-200000">150000-200000</option> 
                        <option value="200000-250000">200000-250000</option>
                        <option value="250000-300000">250000-300000</option>
                        <option value="300000-350000">300000-350000</option>
                        <option value="350000-400000">350000-400000</option>
                        <option value="450000-500000">450000-500000</option>
                        <option value="500000-550000">500000-550000</option>
                    </select>
                </div>                                        
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-1" class="control-label">Gender</label>
                    <select name="edit_jobpost_gender" id="edit_jobpost_gender" class="round">
                        <option value="<?php echo $edit_jobpost_gender; ?>"><?php echo $edit_jobpost_gender; ?></option>                    
                        <option value="Any Gender">Any Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>                                           
                    </select>
                </div>	
            </div>
        </div><!-- Third row Close-->
								
        <div class="row"><!-- Fourth row Start-->                                    
            <div class="col-md-3">                                   
                <div class="form-group">
                    <label for="field-3" class="control-label">Working Hours</label>
                    <input type="text" name="edit_jobpost_working_hour" id="edit_jobpost_working_hour" class="form-control timepicker" data-template="dropdown" value="<?php echo $edit_jobpost_working_hour;?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Shift time</label>
                    <select name="edit_jobpost_shift_time" id="edit_jobpost_shift_time" class="round">
                        <option value="<?php echo $edit_jobpost_shift_time; ?>"><?php echo $edit_jobpost_shift_time; ?></option>
                        <option value="">Select Shift time</option>
                        <option value="Day Shift">Day Shift</option>
                        <option value="Mid Shift">Mid Shift</option>
                        <option value="Night Shift">Night Shift</option>                                                
                    </select>                                            
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Job Description</label>                                        
                    <textarea class="form-control" name="edit_jobpost_jobdescription" id="edit_jobpost_jobdescription"><?php echo $edit_jobpost_jobdescription; ?></textarea>
                </div>	
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Other Information</label>                                        
                    <textarea class="form-control" name="edit_jobpost_otherinformation" id="edit_jobpost_otherinformation"><?php echo $edit_jobpost_otherinformation; ?></textarea>
                </div>	
            </div>
        </div><!-- Fourth row close-->
</div>



<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
