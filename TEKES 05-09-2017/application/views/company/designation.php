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
    function edit_Designation(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Editdesignation') ?>",
            data: "designation_id=" + id,
            cache: false,
            success: function (html) {
                $("#editdesignation_form").html(html);

            }
        });
    }

    function delete_Designation(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Deletedesignation') ?>",
            data: "designation_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletedesignation_form").html(html);

            }
        });
    }

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
    $(document).ready(function () {
        $('#adddesignation_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                branch_name: $('#add_designation_branch').val(),
                department_name: $('#add_designation_department').val(),
                client_name: $('#add_designation_client').val(),
                sub_process: $('#add_designation_subprocess').val(),
                designation_name: $('#designation_name').val(),
                grade_name: $('#grade_name').val(),
                notice_period: $('#notice_period').val(),
                role: $('#role_name').val()

            };

            $.ajax({
                url: "<?php echo site_url('Company/add_designation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#adddesignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#adddesignation_success').show();
                        window.location.reload();
                    }

                }

            });
        });
    });

</script>


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Designation & Role</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_designation').modal('show', {backdrop: 'static'});">
                                New Designation
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Designation Table Format Start Here -->

                    <table class="table table-bordered datatable" id="designation_table">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Process</th>
                                <th>Sub Department</th>
                                <th>Designation</th>
                                <th>Role</th>
                                <th>Grade</th>
                                <th>Notice Period</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($q->Result() as $row) {

                                $designation_id = $row->Designation_Id;

                                $client_id = $row->Client_Id;

                                $this->db->where('SubDepartment_Id', $client_id);
                                $q_subdept = $this->db->get('tbl_subdepartment');
                                foreach ($q_subdept->result() as $row_subdept) {
                                    $client_name = $row_subdept->Client_Name;
                                    $subprocess_name = $row_subdept->Subdepartment_Name;
                                    $department_id = $row_subdept->Department_Id;
                                }

                                $this->db->where('Department_Id', $department_id);
                                $q_dept = $this->db->get('tbl_department');
                                foreach ($q_dept->result() as $row_dept) {
                                    $department_name = $row_dept->Department_Name;
                                    $company_id = $row_dept->Company_Id;
                                    $branch_id = $row_dept->Branch_Id;
                                }

                                $designation_name = $row->Designation_Name;
                                $grade = $row->Grade;
                                $role = $row->Role;
                                $notice_period = $row->Notice_Period;
                                $this->db->where('Company_Id', $company_id);
                                $q_cmp = $this->db->get('tbl_company');
                                foreach ($q_cmp->result() as $row_cmp) {
                                    $company_name = $row_cmp->Company_Name;
                                }


                                $this->db->where('Branch_ID', $branch_id);
                                $q_branch = $this->db->get('tbl_branch');
                                foreach ($q_branch->result() as $row_branch) {
                                    $branch_name = $row_branch->Branch_Name;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $department_name; ?></td>
                                    <td><?php echo $client_name; ?></td>
                                    <td><?php echo $subprocess_name; ?></td>
                                    <td><?php echo $designation_name; ?></td>
                                    <td><?php echo $role; ?></td>
                                    <td><?php echo $grade; ?></td>
                                    <td><?php echo $notice_period . " Days"; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_designation' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Designation(<?php echo $designation_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_designation' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Designation(<?php echo $designation_id; ?>)">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Designation Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Designation Start Here -->

        <div class="modal fade custom-width" id="add_designation">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Designation</h3>
                    </div>
                    <form role="form" id="adddesignation_form" name="adddesignation_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="adddesignation_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="adddesignation_success" class="alert alert-success" style="display:none;">Designation details added successfully.</div>
                                    <div id="adddesignation_error" class="alert alert-danger" style="display:none;">Failed to add designation details.</div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Branch</label>
                                        <select id="add_designation_branch" name="add_designation_branch" class="round" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                                            <option value="">Please Select</option>
                                            <?php foreach ($select_branch->result() as $row_branch) { ?>
                                                <option value="<?php echo $row_branch->Branch_ID; ?>"><?php echo $row_branch->Branch_Name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Department</label>
                                        <select id="add_designation_department" name="add_designation_department" class="round" onChange="showClient(this);" data-validate="required" data-message-required="Please select department.">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Process</label>
                                        <select id="add_designation_client" name="add_designation_client" class="round" data-validate="required" data-message-required="Please select client." onChange="showSubprocess(this);">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Sub Department</label>
                                        <select id="add_designation_subprocess" name="add_designation_subprocess" class="round" data-validate="required" data-message-required="Please select sub process.">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Designation</label>
                                        <input type="text" name="designation_name" id="designation_name" class="form-control" placeholder="Designation" data-validate="required" data-message-required="Please enter designation.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Role</label>
                                        <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Role" data-validate="required" data-message-required="Please enter role.">
                                    </div>	
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Grade</label>
                                        <input type="text" name="grade_name" id="grade_name" class="form-control" placeholder="Grade" data-validate="required" data-message-required="Please enter grade.">
                                    </div>	
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Notice Period</label>

                                        <div class="input-group">
                                            <input type="text" name="notice_period" id="notice_period" class="form-control" placeholder="Notice Period" data-validate="required,number" data-message-required="Please enter notice period.">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary">Days</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="subdepartment_button">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Designation End Here -->

        <!-- Edit Designation Start Here -->

        <div class="modal fade custom-width" id="edit_designation">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Designation</h3>
                    </div>
                    <form role="form" id="editdesignation_form" name="editdesignation_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Designation End Here -->

        <!-- Delete Designation Start Here -->

        <div class="modal fade" id="delete_designation">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Designation</h3>
                    </div>
                    <form role="form" id="deletedesignation_form" name="deletedesignation_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Designation End Here -->

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
                tableContainer = $("#designation_table");

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

