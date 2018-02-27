<?php
$emp_no = $this->uri->segment(3);
$this->db->order_by('Career_Id', 'desc');
$data_career = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_career);
$q = $this->db->get('tbl_employee_career');

$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');

$this->db->where('Status', 1);
$select_report = $this->db->get('tbl_employee');

$user_role = $this->session->userdata('user_role');
?>

<script>
    function edit_Career(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Editcareer') ?>",
            data: "career_id=" + id,
            cache: false,
            success: function (html) {
                $("#editcareer_form").html(html);
            }
        });
    }

    function delete_Career(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deletecareer') ?>",
            data: "career_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletecareer_form").html(html);
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        $('#addjobtitle_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                add_career_emp_no: $('#add_career_emp_no').val(),
                add_career_branch: $('#add_career_branch').val(),
                add_career_department: $('#add_career_department').val(),
                add_career_client: $('#add_career_client').val(),
                add_career_subprocess: $('#add_career_subprocess').val(),
                add_career_designation: $('#add_career_designation').val(),
                add_career_grade: $('#add_career_grade').val(),
                add_career_departmentrole: $('#add_career_departmentrole').val(),
                add_career_reporting_to: $('#add_career_reporting_to').val(),
                add_career_from: $('#add_career_from').val(),
                add_career_to: $('#add_career_to').val()

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
                    $("#add_career_department").html(html);
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
                    $("#add_career_client").html(html);
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
                    $("#add_career_subprocess").html(html);
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
                    $("#add_career_designation").html(html);
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
                    $("#add_career_grade").html(html);
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
                    $("#add_career_departmentrole").html(html);
                }
            });
        }
    }
</script>

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

                    <!-- Branch Table Format Start Here -->

                    <table class="table table-bordered datatable" id="career_table">
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

                    <!-- Branch Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Career Start Here -->

        <div class="modal fade custom-width" id="add_jobtitle">
            <div class="modal-dialog" style="width:65%">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Branch</label>
                                        <select class="round" name="add_career_branch" id="add_career_branch" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                                            <option value="">Please Select</option>
                                            <?php foreach ($select_branch->result() as $row_branch) { ?>
                                                <option value="<?php echo $row_branch->Branch_ID; ?>"><?php echo $row_branch->Branch_Name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                </div>
                                <input type="hidden" name="add_career_emp_no" id="add_career_emp_no" value="<?php echo $emp_no; ?>">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Department</label>
                                        <select name="add_career_department" id="add_career_department" class="round" onChange="showClient(this);" data-validate="required" data-message-required="Please select department.">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Sub-Department Client</label>
                                        <select name="add_career_client" id="add_career_client" class="round" onChange="showSubprocess(this);" data-validate="required" data-message-required="Please select client.">
                                            <option value="">Select Client</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Job Title Sub Process</label>
                                        <select name="add_career_subprocess" id="add_career_subprocess" class="round" onChange="showDesignation(this);" data-validate="required" data-message-required="Please select sub process.">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Designation</label>
                                        <select name="add_career_designation" id="add_career_designation" class="round" onChange="showGrade(this);" data-validate="required" data-message-required="Please select designation.">
                                            <option value="">Select Designation</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Grade</label>
                                        <select name="add_career_grade" id="add_career_grade" class="round" onChange="showDepartmentRole(this);" data-validate="required" data-message-required="Please select grade.">
                                            <option value="">Select Grade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Role</label>
                                        <select name="add_career_departmentrole" id="add_career_departmentrole" class="round" data-validate="required" data-message-required="Please select role.">
                                            <option value="">Select Role</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Reporting To</label>
                                        <select name="add_career_reporting_to" id="add_career_reporting_to" class="round" data-validate="required" data-message-required="Please select reporting manager.">
                                            <option value="">Please Select</option>
                                            <?php foreach ($select_report->result() as $row_report) { ?>
                                                <option value="<?php echo $row_report->Emp_Number; ?>"><?php echo $row_report->Emp_FirstName; ?></option>
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
                                            <input type="text" name="add_career_from" id="add_career_from" class="form-control datepicker"  placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
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
                                            <input type="text" name="add_career_to" id="add_career_to" class="form-control datepicker" placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
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

        <!-- Add Career End Here -->

        <!-- Edit Career Start Here -->

        <div class="modal fade custom-width" id="edit_career">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Career</h3>
                    </div>
                    <form role="form" id="editcareer_form" name="editcareer_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Career End Here -->

        <!-- Delete Career Start Here -->

        <div class="modal fade" id="delete_career">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Career</h3>
                    </div>
                    <form role="form" id="deletecareer_form" name="deletecareer_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Career End Here -->

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
                tableContainer = $("#career_table");

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

