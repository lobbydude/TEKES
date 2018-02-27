<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#add_jobpost_skills').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<style>
    .multiselect-container.dropdown-menu a .checkbox input[type="checkbox"]{
        opacity: 1;
    }
    .multiselect-container.dropdown-menu{
        height: 200px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>
<script>
    function edit_jobtitle(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Recruitment/Editjobtitle') ?>",
            data: "J_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editjobtitle_form").html(html);
            }
        });
    }    
    function delete_jobtitle(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Recruitment/Deletejobtitle') ?>",
            data: "J_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletejobtitle_form").html(html);
            }
        });
    }
</script>
<!-- Add New Job Post Requisitions Form Start here-->
<script type="text/javascript">  
    $(document).ready(function () {
        $('#addjobpost_Requisitions_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_jobpost_interview_date: $('#add_jobpost_interview_date').val(),
                add_jobpost_department_name: $('#add_jobpost_department_name').val(),
                add_jobpost_subdepartment_name: $('#add_jobpost_subdepartment_name').val(),
                add_jobpost_title_name: $('#add_jobpost_title_name').val(),
                add_jobpost_skills: $('#add_jobpost_skills').val(),
                add_jobpost_type: $('#add_jobpost_type').val(),
                add_jobpost_positions: $('#add_jobpost_positions').val(),
                add_jobpost_location: $('#add_jobpost_location').val(),
                add_jobpost_qualification: $('#add_jobpost_qualification').val(),
                add_jobpost_experience: $('#add_jobpost_experience').val(),
                add_jobpost_candidate_age_start: $('#add_jobpost_candidate_age_start').val(),
                add_jobpost_candidate_age_end: $('#add_jobpost_candidate_age_end').val(),
                add_jobpost_salary_start_range: $('#add_jobpost_salary_start_range').val(),
                add_jobpost_salary_end_range: $('#add_jobpost_salary_end_range').val(),
                add_jobpost_gender: $('#add_jobpost_gender').val(),
                add_jobpost_shift_time: $('#add_jobpost_shift_time').val(),
                add_jobpost_jobdescription: $('#add_jobpost_jobdescription').val(),
                add_jobpost_otherinformation: $('#add_jobpost_otherinformation').val()                
            };
            $.ajax({                
                url: "<?php echo site_url('Recruitment/add_jobpost_Requisitions') ?>",				
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
<!-- Add New Job Post Requisitions Form End here-->
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Job Post Requisition Information</h2>
                        </div>
                        <div class="panel-options">                                                       
                            <a class="btn btn-primary btn-icon icon-left" href="<?php echo site_url('Recruitment/Jobpostdashboard'); ?>">
                                <i class="entypo-user"></i>
                                <span class="title">JobPost Dashboard</span>
                            </a>
                            <a class="btn btn-primary btn-icon icon-left" onclick="history.back();">
                                 <i class="entypo-back"></i>
                                <span class="title">Back</span>
                            </a>                                
                        </div>                                             
                    </div>                    
                    <!-- Add New Job Requirements Post Form Start Here -->
                    <div class="modal-content">                        
                        <form role="form" id="addjobpost_Requisitions_form" name="addjobpost_Requisitions_form" method="post" class="validate" enctype="multipart/form-data" >
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
                                            <label class="control-label" for="interviewdate">Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_jobpost_interview_date" id="add_jobpost_interview_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Department Name</label>
                                            <select id="add_jobpost_department_name" name="add_jobpost_department_name" class="round" data-validate="required" data-message-required="Please select department name.">
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
                                                    <option value="<?php echo $department_jobtitle;?>"><?php echo $department_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Sub Department Name</label>
                                            <select id="add_jobpost_subdepartment_name" name="add_jobpost_subdepartment_name" class="round" data-validate="required" data-message-required="Please select department.">
                                                <option value="">Select Sub Department</option>
                                                <?php
                                                $this->db->order_by('J_Id', 'desc');
                                                $this->db->group_by('Subdepartment_Name');
                                                $this->db->where('Status', 1);
                                                $q_subdepartment = $this->db->get('tbl_jobtitle');
                                                foreach ($q_subdepartment->Result() as $row_subdepartment) {
                                                    $department_name = $row_subdepartment->Department_Name;
                                                    $subdepartment_name1 = $row_subdepartment->Subdepartment_Name;
                                                    $subdepartment_id = $row_subdepartment->S_Id;
                                                    // Sub Department Name get the value
                                                    $this->db->where('Subdepartment_Id', $subdepartment_name1);
                                                    $q_subdept = $this->db->get('tbl_subdepartment');
                                                    foreach ($q_subdept->result() as $row_subdept) {
                                                        $subdepartment_name = $row_subdept->Subdepartment_Name;                                    
                                                    }                                                
                                                    ?>
                                                    <option value="<?php echo $subdepartment_name1; ?>"><?php echo $subdepartment_name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
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
                                            <label for="field-1" class="control-label">Job Skills</label>
                                            <select name="add_jobpost_skills[]" id="add_jobpost_skills" class="round" multiple data-validate="required" data-message-required="Please Select jobtitle">                                                
                                                <?php
                                                $this->db->order_by('S_Id', 'desc');
                                                $this->db->group_by('Jobskills');
                                                $this->db->where('Status', 1);
                                                $q_skills = $this->db->get('tbl_jobskills');
                                                foreach ($q_skills->Result() as $row_skills) {
                                                    $skills_id = $row_skills->S_Id;
                                                    $skill_jobtitle = $row_skills->Jobtitle;
                                                    $skill_jobskills = $row_skills->Jobskills;                                                                                                        
                                                    ?>
                                                    <option value="<?php echo $skill_jobskills; ?>"><?php echo $skill_jobskills; ?></option>
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">No.of.Positions</label>
                                            <input type="text" name="add_jobpost_positions" id="add_jobpost_positions" class="form-control" placeholder="No.of.Position" data-validate="required" data-message-required="Please enter no.of.position">
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Job Location</label>
                                            <input type="text" name="add_jobpost_location" id="add_jobpost_location" class="form-control" placeholder="Job Location" data-validate="required" data-message-required="Please enter Job Location">
                                        </div>	
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Candidate Qualification</label>
                                            <input type="text" name="add_jobpost_qualification" id="add_jobpost_qualification" class="form-control" placeholder="Qualification" data-validate="required" data-message-required="Please enter qualification">
                                        </div>	
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Candidate Experience</label>
                                            <input type="text" name="add_jobpost_experience" id="add_jobpost_experience" class="form-control" placeholder="Experience" data-validate="required" data-message-required="Please enter candidate experience">
                                        </div>	
                                    </div>                                                                        
                                </div><!-- Second row Close-->

                                <div class="row"><!-- Third row Start-->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Candidate Age Start</label>
                                            <input type="text" name="add_jobpost_candidate_age_start" id="add_jobpost_candidate_age_start" class="form-control" placeholder="Candidate Age Start">
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Candidate Age End</label>
                                            <input type="text" name="add_jobpost_candidate_age_end" id="add_jobpost_candidate_age_end" class="form-control" placeholder="Candidate Age End">
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Salary Start Range</label>
                                            <input type="text" name="add_jobpost_salary_start_range" id="add_jobpost_salary_start_range" class="form-control" placeholder="Salary Start Range" >
                                        </div>	
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Salary End Range</label>
                                            <input type="text" name="add_jobpost_salary_end_range" id="add_jobpost_salary_end_range" class="form-control" placeholder="Salary End Range">
                                        </div>	
                                    </div>                                  
                                </div><!-- Third row Close-->								
                                <div class="row"><!-- Fourth row Start-->                                    
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Shift time</label>
                                            <select name="add_jobpost_shift_time" id="add_jobpost_shift_time" class="round" data-validate="required" data-message-required="Please select shift time">
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
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>     
                   
                </div>
            </div>
        </section>        
        <!-- Add New Job Post Form End Here -->

        <!-- Edit Job Title Start Here -->
        <div class="modal fade custom-width" id="edit_jobtitle">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Job Title</h3>
                    </div>
                    <form role="form" id="editjobtitle_form" name="editjobtitle_form" method="post" class="validate">
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Job Title End Here -->

        <!-- Delete Job Title Start Here -->

        <div class="modal fade" id="delete_jobtitle">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Job Title</h3>
                    </div>
                    <form role="form" id="deletejobtitle_form" name="deletejobtitle_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Job Title End Here -->


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
                tableContainer = $("#jobtitle_table");

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