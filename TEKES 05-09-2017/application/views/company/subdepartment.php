<?php
$this->db->order_by('Subdepartment_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_subdepartment');


$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');
?>


<script>
    function edit_SubDepartment(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Editsubdepartment') ?>",
            data: "subdepartment_id=" + id,
            cache: false,
            success: function (html) {
                $("#editsubdepartment_form").html(html);

            }
        });
    }

    function delete_SubDepartment(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Deletesubdepartment') ?>",
            data: "subdepartment_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletesubdepartment_form").html(html);

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
                    $("#add_subdept_department").html(html);
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#addsubdepartment_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                branch_name: $('#add_subdept_branch').val(),
                department_name: $('#add_subdept_department').val(),
                client_name: $('#client_name').val(),
                subdepartment_name: $('#subdepartment_name').val()
				//add_process: $('#add_process').val()

            };

            $.ajax({
                url: "<?php echo site_url('Company/add_subdepartment') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addsubdepartment_error').show();
                    }
                    if (msg == 'success') {
                        $('#addsubdepartment_success').show();
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
                            <h2>Process & Sub Process</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_subdepartment').modal('show', {backdrop: 'static'});">
                                New Process
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Sub Department Table Format Start Here -->

                    <table class="table table-bordered datatable" id="subdepartment_table">
                        <thead>
                            <tr>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Process Name</th>
                                <th>Sub Department</th>								
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($q->Result() as $row) {
                                $subdepartment_id = $row->Subdepartment_Id;

                                $department_id = $row->Department_Id;
                                $this->db->where('Department_Id', $department_id);
                                $q_dept = $this->db->get('tbl_department');
                                foreach ($q_dept->result() as $row_dept) {
                                    $department_name = $row_dept->Department_Name;
                                    $company_id = $row_dept->Company_Id;
                                    $branch_id = $row_dept->Branch_Id;
                                }

                                $client_name = $row->Client_Name;
                                $subdepartment_name = $row->Subdepartment_Name;
								$process = $row->Process;

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
                                    <td><?php echo $branch_name; ?></td>
                                    <td><?php echo $department_name; ?></td>
                                    <td><?php echo $client_name; ?></td>
                                    <td><?php echo $subdepartment_name; ?></td>									
                                    <td>
                                        <a data-toggle='modal' href='#edit_subdepartment' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_SubDepartment(<?php echo $subdepartment_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_subdepartment' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_SubDepartment(<?php echo $subdepartment_id; ?>)">
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

                    <!-- Sub Department Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Sub Department Start Here -->

        <div class="modal fade custom-width" id="add_subdepartment">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Process & Sub Process</h3>
                    </div>
                    <form role="form" id="addsubdepartment_form" name="addsubdepartment_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addsubdepartment_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addsubdepartment_success" class="alert alert-success" style="display:none;">Sub Process details added successfully.</div>
                                    <div id="addsubdepartment_error" class="alert alert-danger" style="display:none;">Failed to add sub process details.</div>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Branch</label>
                                        <select id="add_subdept_branch" name="add_subdept_branch" class="round" onChange="showDepartment(this);" data-validate="required" data-message-required="Please select branch.">
                                            <option value="">Please Select</option>
                                            <?php foreach ($select_branch->result() as $row_branch) { ?>
                                                <option value="<?php echo $row_branch->Branch_ID; ?>"><?php echo $row_branch->Branch_Name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Department</label>
                                        <select id="add_subdept_department" name="add_subdept_department" class="round" data-validate="required" data-message-required="Please select department.">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Process</label>
                                        <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Process Name" data-validate="required" data-message-required="Please enter client.">
                                    </div>	
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Sub Department</label>
                                        <input type="text" name="subdepartment_name" id="subdepartment_name" class="form-control" placeholder="Sub Department" data-validate="required" data-message-required="Please enter sub process.">
                                    </div>	
                                </div>
								<!--<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Process</label>
                                        <input type="text" name="add_process" id="add_process" class="form-control" placeholder="Process" data-validate="required" data-message-required="Please enter process.">
                                    </div>	
                                </div>-->
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

        <!-- Add Sub Department End Here -->

        <!-- Edit Sub Department Start Here -->

        <div class="modal fade custom-width" id="edit_subdepartment">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Sub Process</h3>
                    </div>
                    <form role="form" id="editsubdepartment_form" name="editsubdepartment_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Sub Department End Here -->

        <!-- Delete Sub Department Start Here -->

        <div class="modal fade" id="delete_subdepartment">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Sub Process</h3>
                    </div>
                    <form role="form" id="deletesubdepartment_form" name="deletesubdepartment_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Sub Department End Here -->

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
                tableContainer = $("#subdepartment_table");

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

