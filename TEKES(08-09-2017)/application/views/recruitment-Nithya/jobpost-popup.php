<script>
    function edit_jobpost(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Recruitment/Editjobpost') ?>",
            data: "JP_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editjobpost_Requisitions_form").html(html);
            }
        });
    }    
    function delete_jobpost(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Recruitment/Deletejobpost') ?>",
            data: "JP_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletejobpost_Requisitions_form").html(html);
            }
        });
    }
</script>
<!-- Add New Job Post Form Start here-->
<script type="text/javascript">  
    $(document).ready(function () {
        $('#addjobpost_Requisitions_form').submit(function (e) {
            e.preventDefault();
            var formdata = {                
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
<!-- Add New Job Post Form End here-->

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
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_jobpost').modal('show', {backdrop: 'static'});">
                                New Job Post Requisition
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>                    
                    <!--Job title Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="jobpost_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Department Name</th>                              
                                <th>Sub Department</th>
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
                            $this->db->order_by('JP_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_jobpost_requisitions');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $JP_Id = $row->JP_Id;
                                $department_id = $row->Department_Name;                               
                                $subdepartment_id = $row->Sub_Department_Name;
                                $jobtitle_id = $row->Job_Title;
                                $jobskills = $row->Job_Skills;
                                $jobtype = $row->Job_Type;
                                $positions = $row->Positions;
                                $job_location = $row->Job_Location;
                                $qualification = $row->Qualification;
                                $experience = $row->Experience;
                                $age_start = $row->Age_Start;
                                $age_end = $row->Age_End;
                                $salary_start_range = $row->Salary_Start_Range;
                                $salary_end_range = $row->Salary_End_Range;
                                $job_description = $row->Job_Description;
                                $job_other_information = $row->Job_Other_Information;
                                
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
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $department_name; ?></td>                                 
                                    <td><?php echo $subdepartment_name; ?></td>
                                    <td><?php echo $jobtitle; ?></td>
                                    <td><?php echo $jobskills; ?></td>
                                    <td><?php echo $jobtype; ?></td>
                                    <td><?php echo $positions;?></td>
                                    <td><?php echo $job_location; ?></td>                                    
                                    <td><?php echo $qualification; ?></td>
                                    <td><?php echo $experience; ?></td>                                    
                                    <td> ₹: <?php echo $salary_start_range . " to " . $salary_end_range;?></td>                                                                       
                                    <td>
                                        <a data-toggle='modal' href='#edit_jobpost' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_jobpost(<?php echo $JP_Id;?>)">                                                                                                                                      
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_jobpost' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_jobpost(<?php echo $JP_Id; ?>)">
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
                    <!--Job title Table Format End Here -->
                </div>
            </div>
        </section>
        
        <!-- Add New Job Post Form Start Here -->
        <div class="modal fade custom-width" id="add_jobpost">
            <div class="modal-dialog" style="width:90%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Job Post Requisition Information</h3>
                    </div>
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
                                    <div class="col-md-3">
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
                                    <div class="col-md-3">
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
                                            <label for="field-1" class="control-label">Job Skills</label>
                                            <select name="add_jobpost_skills" id="add_jobpost_skills" class="round" data-validate="required" data-message-required="Please Select jobtitle">
                                                <option value="">Select Jobskills</option>
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Candidate Age Start</label>
                                            <input type="text" name="add_jobpost_candidate_age_start" id="add_jobpost_candidate_age_start" class="form-control" placeholder="Candidate Age Start">
                                        </div>	
                                    </div>
                                    <div class="col-md-2">
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Salary End Range</label>
                                            <input type="text" name="add_jobpost_salary_end_range" id="add_jobpost_salary_end_range" class="form-control" placeholder="Salary End Range">
                                        </div>	
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Job Description</label>                                        
                                            <textarea class="form-control" name="add_jobpost_jobdescription" id="add_jobpost_jobdescription" placeholder="Job Description" data-validate="required" data-message-required="Please enter job description" ></textarea>
                                        </div>	
                                    </div>
                                </div><!-- Third row Close-->
								
                                <div class="row"><!-- Fourth row Start-->                               
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Other Information</label>                                        
                                            <textarea class="form-control" name="add_jobpost_otherinformation" id="add_jobpost_otherinformation" placeholder="Other Information" ></textarea>
                                        </div>	
                                    </div>
                                    <!--<div class="col-md-9">
                                        <div class="checkbox_outer">
                                            <input id="condition_agree" type="checkbox" name="condition_agree"><span></span>
                                        </div> 
                                        <div class="col-md-12">
                                            Career Services thanks you for your interest in posting jobs for DRN Definites Solutions Pvt Ltd., We are eager to help you locate qualified candidates for your positions. Please note that all postings are subject to approval. All requests will be reviewed for content and suitability.
                                        </div>
                                        <div class="col-md-12">
                                            <p id="acknowledgment_error" style="display:none;color:red">Please check acknowledgment</p>
                                        </div>
                                    </div>-->
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
        <!-- Add New Job Post Requisitions Form End Here -->

        <!-- Edit Job Post Requisitions Start Here -->

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
        <!-- Edit Job Post Requisitions End Here -->

        <!-- Delete Job Post Requisitions Start Here -->

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
        <!-- Delete Job Post Requisitions End Here -->


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
                tableContainer = $("#jobpost_table");

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