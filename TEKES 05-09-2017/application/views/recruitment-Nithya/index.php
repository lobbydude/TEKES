<?php
$this->db->order_by('Designation_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_designation');

$this->db->where('Status', 1);
$select_company = $this->db->get('tbl_company');

$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');
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
                    $("#add_designation_department").html(html);
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
                    $("#add_designation_client").html(html);
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
                    $("#add_designation_subprocess").html(html);
                }
            });
        }
    }
</script>
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
<!-- Add New Job Title Start here-->
<script type="text/javascript">  
    $(document).ready(function () {
        $('#addjobtitle_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_department_name: $('#add_department_name').val(),
                add_subdept_department: $('#add_subdept_department').val(),
                add_jobtitle_name: $('#add_jobtitle_name').val(),
                add_jobtype: $('#add_jobtype').val(),
                add_jobtitle_process: $('#add_jobtitle_process').val()
            };
            $.ajax({               
                url: "<?php echo site_url('Recruitment/add_jobtitle') ?>",				
                type: 'post',
                data: formdata,
                success: function (msg) {                    
                    if (msg == 'fail') {
                        $('#add_jobtitle_error').show();
                    }
                    if (msg == 'success') {
                        $('#add_jobtitle_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });    
</script>
<!-- Add New Job Title End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Job Title</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_jobtitle').modal('show', {backdrop: 'static'});">
                                New Jobtitle
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>                    
                    <!--Job title Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="jobtitle_table">
                        <thead>
                            <tr>
                                <th style="width: 25px;">S.No</th>
                                <th>Department Name</th>                              
                                <th>Sub Department</th>
                                <th>Job Title</th>
                                <th>Job Type</th>
                                <th>Process</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('J_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_Jobtitle');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $J_Id = $row->J_Id;
                                $department_id = $row->Department_Name;                               
                                $subdepartment_id = $row->Subdepartment_Name;
                                $jobtitle_id = $row->Jobtitle;
                                $jobtype = $row->Jobtype;
                                $process = $row->Process;
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
                                // Designation Name get the value
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
                                    <td><?php echo $jobtype; ?></td>
                                    <td><?php echo $process; ?></td>                                    
                                    <td>
                                        <a data-toggle='modal' href='#edit_jobtitle' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_jobtitle(<?php echo $J_Id;?>)">                                                                                                                                      
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_jobtitle' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_jobtitle(<?php echo $J_Id; ?>)">
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
        
        <!-- Add New Job Title Start Here -->
        <div class="modal fade custom-width" id="add_jobtitle">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Jobtitle</h3>
                    </div>
                    <form role="form" id="addjobtitle_form" name="addjobtitle_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_jobtitle_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_jobtitle_success" class="alert alert-success" style="display:none;">Jobtitle details added successfully.</div>
                                    <div id="add_jobtitle_error" class="alert alert-danger" style="display:none;">Failed to add Jobtitle details.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Department Name</label>
                                        <select id="add_department_name" name="add_department_name" class="round" data-validate="required" data-message-required="Please select department.">
                                            <option value="">Select Department</option>
                                            <?php
                                            $this->db->order_by('Department_Id', 'desc');
                                            $this->db->group_by('Department_Name');
                                            $this->db->where('Status', 1);
                                            $q_department = $this->db->get('tbl_department');
                                            foreach ($q_department->Result() as $row_department) {
                                                $department_name = $row_department->Department_Name;
                                                $department_id = $row_department->Department_Id;                                                
                                                ?>
                                                <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Sub-Process</label>
                                        <select id="add_subdept_department" name="add_subdept_department" class="round" data-validate="required" data-message-required="Please select sub-department.">
                                            <option value="">Sub-Process</option>
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
                                                <option value="<?php echo $subdepartment_id; ?>"><?php echo $subdepartment_name; ?></option>
                                                <?php
                                            }
                                            ?>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Job Title</label>
                                        <select name="add_jobtitle_name" id="add_jobtitle_name" class="round" data-validate="required" data-message-required="Please Select jobtitle">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Job Type</label>
                                        <select id="add_jobtype" name="add_jobtype" class="round" data-validate="required" data-message-required="Please select jobtype">
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
                                        <input type="text" name="add_jobtitle_process" id="add_jobtitle_process" class="form-control" placeholder="Process name" data-validate="required" data-message-required="Please enter process name">
                                    </div>	
                                </div>                                
                            </div>                                                   
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add New Job Title End Here -->
        
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