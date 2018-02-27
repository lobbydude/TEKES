<script>
    function edit_jobpost(id) {
        $.ajax({          
            type: "POST",
            url: "<?php echo site_url('Manpower/Editjobpost') ?>",
            data: "MP_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editjobpost_Requisitions_form").html(html);
            }
        });
    }    
    function delete_jobpost(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Manpower/Deletejobpost') ?>",
            data: "MP_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletejobpost_Requisitions_form").html(html);
            }
        });
    }
</script>
<!-- Add New Manpower Requisitions Post Form Start here-->
<script type="text/javascript">  
    $(document).ready(function () {
        $('#add_manpower_Requisition_form').submit(function (e) {
            e.preventDefault();
            var formdata = {               
                add_jobpost_interview_date: $('#add_jobpost_interview_date').val(),
                add_jobpost_request_person_name: $('#add_jobpost_request_person_name').val(),
                add_jobpost_department_name: $('#add_jobpost_department_name').val(),
                add_jobpost_subdepartment_name: $('#add_jobpost_subdepartment_name').val(),
                
                add_jobpost_title_name: $('#add_jobpost_title_name').val(),
                add_jobpost_type: $('#add_jobpost_type').val(),
                add_jobpost_positions: $('#add_jobpost_positions').val(),
                add_jobpost_jobskills: $('#add_jobpost_jobskills').val(),
                
                add_jobpost_location: $('#add_jobpost_location').val(),
                add_jobpost_qualification: $('#add_jobpost_qualification').val(),
                add_jobpost_experience: $('#add_jobpost_experience').val(),
                add_jobpost_salary: $('#add_jobpost_salary').val(),
                add_jobpost_gender: $('#add_jobpost_gender').val(),
                
                add_jobpost_working_hour: $('#add_jobpost_working_hour').val(),
                add_jobpost_shift_time: $('#add_jobpost_shift_time').val(),                
                add_jobpost_jobdescription: $('#add_jobpost_jobdescription').val(),
                add_jobpost_otherinformation: $('#add_jobpost_otherinformation').val()                
            };
            $.ajax({                
                url: "<?php echo site_url('Manpower/add_jobpost_Requisitions') ?>",				
                type: 'post',
                data: formdata,
                success: function (msg) {                     
                    if (msg == 'fail') {
                        $('#add_jobpost_error').show();
                    }
                    if (msg == 'success') {
                        $('#add_jobpost_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>
<!-- Add New Manpower Requisitions Post Form End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Manpower Job Post Requisition</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_manpower_jobpost').modal('show', {backdrop: 'static'});">
                                New Manpower Job Post Requisition 
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>                    
                    <!-- Manpower Job_requisition design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="manpower_table">
                        <thead>
                            <tr>
                                <th>S.No</th>                               
                                <th>Date</th>
                                <th>Requisition Name</th>
                                <th>Department Name</th>                              
                                <!--<th>Sub Department</th>-->
                                <th>Job Title</th>
                                <th>Skills</th>
                                <th>Job Type</th> 
                                <th>Positions</th>
                                <th>Job Location</th>                                
                                <th>Qualification</th>                                
                                <th>Experience</th>                             
                                <th>Salary Start to End ₹</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('MP_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_manpower_requisition');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $MP_Id = $row->MP_Id;                                
                                $requisition_date1 = $row->Requisition_Date;                                
                                $requisition_date = date("d-m-Y", strtotime($requisition_date1));
                                $department_id = $row->Department_Name;                               
                                $Requisition_Name = $row->Requisition_Name;
                                $subdepartment_id = $row->Sub_Department_Name;
                                $jobtitle_id = $row->Job_Title;
                                $jobskills = $row->Job_Skills;
                                $jobtype = $row->Job_Type;
                                $positions = $row->Positions;
                                $job_location = $row->Job_Location;
                                $qualification = $row->Qualification;
                                $experience = $row->Experience;                                
                                $salary_range = $row->Salary;                               
                                $job_description = $row->Job_Description;
                                $job_other_information = $row->Other_Information;
                                $gender = $row->Gender;                               
                                
                                // Department Name get the value
                                $this->db->where('Department_Id', $department_id);
                                $q_dept = $this->db->get('tbl_department');
                                foreach ($q_dept->result() as $row_dept) {
                                    $department_name = $row_dept->Department_Name;                                    
                                }                                
                                // Sub Department Name get the value
                                $this->db->where('Subdepartment_Id', $subdepartment_id);
                                $q_subdept_name = $this->db->get('tbl_subdepartment');
                                foreach ($q_subdept_name->result() as $row_subdept) {
                                    $subdepartment_name = $row_subdept->Subdepartment_Name;                                    
                                }
                                // Designation Name (Jobtitle) get the value
                                $this->db->where('Designation_Id', $jobtitle_id);
                                $q_design = $this->db->get('tbl_designation');
                                foreach ($q_design->Result() as $row_design) {
                                    $jobtitle = $row_design->Designation_Name;                                    
                                }
                                // Employee Name get the value
                                $this->db->where('Emp_Number', $Requisition_Name);
                                $q_report_employee = $this->db->get('tbl_employee');
                                foreach ($q_report_employee->result() as $row_report_employee) {
                                    $Report_Emp_FirstName = $row_report_employee->Emp_FirstName;
                                    $Report_Emp_Middlename = $row_report_employee->Emp_MiddleName;
                                    $Report_Emp_LastName = $row_report_employee->Emp_LastName;
                                }
                                 // Employee Code get the value
                                 $this->db->where('employee_number', $Requisition_Name);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->Result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                    $emp_number = $row_code->employee_number;                                    
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>                                    
                                    <td><?php echo $requisition_date; ?></td>
                                    <td><?php echo $Report_Emp_FirstName . " " . $Report_Emp_LastName . " " . $Report_Emp_Middlename . ' : '. $emp_code . $emp_number; ?></td>
                                    <td><?php echo $department_name; ?></td>                                 
                                    <!--<td><?php //echo $subdepartment_name; ?></td>-->
                                    <td><?php echo $jobtitle; ?></td>
                                    <td><?php echo $jobskills; ?></td>
                                    <td><?php echo $jobtype; ?></td>
                                    <td><?php echo $positions;?></td>
                                    <td><?php echo $job_location; ?></td>                                    
                                    <td><?php echo $qualification; ?></td>
                                    <td><?php echo $experience; ?></td>                                  
                                    
                                    <td> ₹: <?php echo $salary_range;?></td>                                                                                                                                                                                   
                                    <td>
                                        <a data-toggle='modal' href='#edit_jobpost' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_jobpost(<?php echo $MP_Id; ?>)">     
										<i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_jobpost' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_jobpost(<?php echo $MP_Id; ?>)">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>                            
                        </tbody>                 
                    </table> 
                    <!--Manpower Job_requisition design Table Format End Here -->
                </div>
            </div>
        </section>
        
        <!-- Add New Manpower Job_requisition Form Start Here -->
        <div class="modal fade custom-width" id="add_manpower_jobpost">
            <div class="modal-dialog" style="width:90%">
                <div class="modal-content">                   
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Manpower Job Requisition Information</h2>
                        </div>
                        <div class="panel-options">                            
                            <span style="float:right;">DRN/HR/MRF-FMT/004</span>
                        </div>
                    </div>
                    <form role="form" id="add_manpower_Requisition_form" name="add_manpower_Requisition_form" method="post" class="validate" enctype="multipart/form-data" >
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="add_jobpost_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="add_jobpost_success" class="alert alert-success" style="display:none;">Job Post Requisitions Form details added successfully.</div>
                                        <div id="add_jobpost_error" class="alert alert-danger" style="display:none;">Failed to add Job Post Requisitions Form details.</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label" for="interviewdate">Request Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_jobpost_interview_date" id="add_jobpost_interview_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                   
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Request Person Name</label>
                                            <select name="add_jobpost_request_person_name" id="add_jobpost_request_person_name" class="select2" data-validate="required" data-message-required="Please select Request name">
                                                <option value="">Please Select Request Name</option>                                                
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
                                                    <option onClick="show_individual_payslip()" value="<?php echo $emp_no_list ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Department Name</label>
                                            <select id="add_jobpost_department_name" name="add_jobpost_department_name" class="round" data-validate="required" data-message-required="Please select department name.">
                                                <option value="">Select Department</option>
                                                <?php
                                                $this->db->order_by('Department_Id', 'desc');
                                                $this->db->group_by('Department_Name');
                                                $this->db->where('Status', 1);
                                                $q_department = $this->db->get(' tbl_department');
                                                foreach ($q_department->Result() as $row_department) {
                                                    $department_name = $row_department->Department_Name;
                                                    $department_id = $row_department->Department_Id;                                                   
                                                    ?>
                                                    <option value="<?php echo $department_id;?>"><?php echo $department_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Sub Department Name</label>
                                            <select id="add_jobpost_subdepartment_name" name="add_jobpost_subdepartment_name" class="round" data-validate="required" data-message-required="Please select department name.">                                                
                                                <option value="">Select Sub Department</option>
                                                <?php
                                                $this->db->order_by('Subdepartment_Id', 'desc');
                                                $this->db->group_by('Subdepartment_Name');
                                                $this->db->where('Status', 1);
                                                $q_subdepartment = $this->db->get('tbl_subdepartment');
                                                foreach ($q_subdepartment->Result() as $row_subdepartment) {
                                                    $department_id= $row_subdepartment->Department_Id;
                                                    $subdepartment_name = $row_subdepartment->Subdepartment_Name;
                                                    $subdepartment_id = $row_subdepartment->Subdepartment_Id;                                                                                
                                                    ?>
                                                    <option value="<?php echo $subdepartment_id; ?>"><?php echo $subdepartment_name; ?></option>
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
                                            <select name="add_jobpost_title_name" id="add_jobpost_title_name" class="round" data-validate="required" data-message-required="Please Select jobtitle">
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
                                                    <option value="<?php echo $designation_id; ?>"><?php echo $designation_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>	
                                    </div>                                     
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Job Type</label>
                                            <select id="add_jobpost_type" name="add_jobpost_type" class="round" data-validate="required" data-message-required="Please select jobtype">
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
                                            <input type="text" name="add_jobpost_positions" id="add_jobpost_positions" class="form-control" placeholder="No.of.Position" data-validate="required" data-message-required="Please enter no.of.position">
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Job Skills</label>                                        
                                            <textarea class="form-control" name="add_jobpost_jobskills" id="add_jobpost_jobskills" placeholder="Job Skills" data-validate="required" data-message-required="Please enter job skills" ></textarea>
                                        </div>	
                                    </div>
                                </div><!-- Second row Close-->

                                <div class="row"><!-- Third row Start-->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Job Location</label>
                                            <input type="text" name="add_jobpost_location" id="add_jobpost_location" class="form-control" placeholder="Job Location" data-validate="required" data-message-required="Please enter Job Location">
                                        </div>	
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Qualification</label>
                                            <!--<input type="text" name="add_jobpost_qualification" id="add_jobpost_qualification" class="form-control" placeholder="Qualification" data-validate="required" data-message-required="Please enter qualification">-->
                                            <select id="add_jobpost_qualification" name="add_jobpost_qualification" class="round" data-validate="required" data-message-required="Please select Qualification">
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
                                            <!--<input type="text" name="add_jobpost_experience" id="add_jobpost_experience" class="form-control" placeholder="Experience" data-validate="required" data-message-required="Please enter candidate experience">-->
                                            <select id="add_jobpost_experience" name="add_jobpost_experience" class="round" data-validate="required" data-message-required="Please select Experience">
                                                <option value="">Select Experience</option>
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
                                            <select name="add_jobpost_salary" id="add_jobpost_salary" class="round" data-validate="required" data-message-required="Please Select Salary">
                                                <option value="Salary">Select Salary</option>
                                                <option value="100000-150000">RS:- 100000-150000</option>
                                                <option value="150000-200000">RS:- 150000-200000</option> 
                                                <option value="200000-250000">RS:- 200000-250000</option>
                                                <option value="250000-300000">RS:- 250000-300000</option>
                                                <option value="300000-350000">RS:- 300000-350000</option>
                                                <option value="350000-400000">RS:- 350000-400000</option>
                                                <option value="450000-500000">RS:- 450000-500000</option>
                                                <option value="500000-550000">RS:- 500000-550000</option>
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Gender</label>
                                            <select name="add_jobpost_gender" id="add_jobpost_gender" class="round" data-validate="required" data-message-required="Please Select Gender">
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
                                            <input name="add_jobpost_working_hour" id="add_jobpost_working_hour" class="form-control" data-template="dropdown" data-show-seconds="true" data-default-time="09:30" data-minute-step="5" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Shift Name</label>
                                            <select name="add_jobpost_shift_time" id="add_jobpost_shift_time" class="round" data-validate="required" data-message-required="Please select shift time">
                                                <option value="">Select Shift Name</option>
                                                <option value="Day Shift">Day Shift</option>
                                                <option value="Mid Shift">Mid Shift</option>
                                                <option value="Night Shift">Night Shift</option>                                                
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Job Description</label>                                        
                                            <textarea class="form-control" name="add_jobpost_jobdescription" id="add_jobpost_jobdescription" placeholder="Job Description" data-validate="required" data-message-required="Please enter job description" ></textarea>
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Other Information</label>                                        
                                            <textarea class="form-control" name="add_jobpost_otherinformation" id="add_jobpost_otherinformation" placeholder="Other Information" ></textarea>
                                        </div>	
                                    </div>
                                </div><!-- Fourth row close-->
                            </div>
                            <div class="modal-footer">
                                <span style="float:left;"> Version 1.0</span>
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        <!-- Add New Manpower Job_requisition Form End Here -->

        <!-- Edit Manpower Job_requisition Form Start Here -->
        <div class="modal fade custom-width" id="edit_jobpost">
            <div class="modal-dialog" style="width:90%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Job Post Requisitions </h3>
                    </div>
                    <form role="form" id="editjobpost_Requisitions_form" name="editjobpost_Requisitions_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Manpower Job_requisition Form End Here -->

        <!-- Delete Manpower Job_requisition Form Start Here -->

        <div class="modal fade" id="delete_jobpost">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Job Post Requisitions</h3>
                    </div>
                    <form role="form" id="deletejobpost_Requisitions_form" name="deletejobpost_Requisitions_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Manpower Job_requisition Form End Here -->


        <!-- Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#manpower_table");

                tableContainer.dataTable({
                    "sPaginationType": "bootstrap",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "bStateSave": true,
                    // Responsive Settings
                    bAutoWidth: false,
                    fnPreDrawCallback: function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper) {
                            responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
                        }
                    },
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        responsiveHelper.createExpandIcon(nRow);
                    },
                    fnDrawCallback: function (oSettings) {
                        responsiveHelper.respond();
                    }
                });

                $(".dataTables_wrapper select").select2({
                    minimumResultsForSearch: -1
                });
            });
        </script>