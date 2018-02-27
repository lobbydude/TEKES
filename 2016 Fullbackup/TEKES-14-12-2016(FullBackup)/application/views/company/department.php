<?php
$this->db->order_by('Department_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_department');

$this->db->where('Status', 1);
$select_company = $this->db->get('tbl_company');

$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');
?>

<script>
    function edit_Department(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Editdepartment') ?>",
            data: "department_id=" + id,
            cache: false,
            success: function (html) {
                $("#editdepartment_form").html(html);

            }
        });
    }

    function delete_Department(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Deletedepartment') ?>",
            data: "department_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletedepartment_form").html(html);

            }
        });
    }

</script>

<script>
    $(document).ready(function () {
        $('#adddepartment_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                company_name: $('#add_department_company').val(),
                branch_name: $('#add_department_branch').val(),
                department_name: $('#department_name').val()

            };
            $.ajax({
                url: "<?php echo site_url('Company/add_department') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#adddepartment_error').show();
                    }
                    if (msg == 'success') {
                        $('#adddepartment_success').show();
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
                            <h2>Department</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_department').modal('show', {backdrop: 'static'});">
                                New Department
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Department Table Format Start Here -->

                    <table class="table table-bordered datatable" id="department_table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($q->Result() as $row) {
                                $department_id = $row->Department_Id;
                                $department_name = $row->Department_Name;

                                $company_id = $row->Company_Id;
                                $this->db->where('Company_Id', $company_id);
                                $q_cmp = $this->db->get('tbl_company');
                                foreach ($q_cmp->result() as $row_cmp) {
                                    $company_name = $row_cmp->Company_Name;
                                }

                                $branch_id = $row->Branch_Id;
                                $this->db->where('Branch_ID', $branch_id);
                                $q_branch = $this->db->get('tbl_branch');
                                foreach ($q_branch->result() as $row_branch) {
                                    $branch_name = $row_branch->Branch_Name;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $company_name; ?></td>
                                    <td><?php echo $branch_name; ?></td>
                                    <td><?php echo $department_name; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_department' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Department(<?php echo $department_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_department' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Department(<?php echo $department_id; ?>)">
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

                    <!-- Department Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Department Start Here -->

        <div class="modal fade" id="add_department">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Department</h3>
                    </div>
                    <form role="form" id="adddepartment_form" name="adddepartment_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="adddepartment_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="adddepartment_success" class="alert alert-success" style="display:none;">Department details added successfully.</div>
                                    <div id="adddepartment_error" class="alert alert-danger" style="display:none;">Failed to add department details.</div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Company Name</label>
                                        <select name="add_department_company" id="add_department_company" class="round" data-validate="required" data-message-required="Please select company.">
                                            <?php foreach ($select_company->result() as $row_company) { ?>
                                                <option value="<?php echo $row_company->Company_Id; ?>"><?php echo $row_company->Company_Name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Branch</label>
                                            <select name="add_department_branch" id="add_department_branch" class="round" data-validate="required" data-message-required="Please select branch.">
                                                <option value="">Please Select</option>
                                                <?php foreach ($select_branch->result() as $row_branch) { ?>
                                                <option value="<?php echo $row_branch->Branch_ID; ?>"><?php echo $row_branch->Branch_Name; ?></option>
                                            <?php } ?>
                                            </select>
                                    </div>	
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Department</label>
                                        <input type="text" name="department_name" id="department_name" class="form-control" placeholder="Department" data-validate="required" data-message-required="Please enter department.">
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

        <!-- Add Department End Here -->

        <!-- Edit Department Start Here -->

        <div class="modal fade custom-width" id="edit_department">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Department</h3>
                    </div>
                    <form role="form" id="editdepartment_form" name="editdepartment_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Department End Here -->

        <!-- Delete Department Start Here -->

        <div class="modal fade" id="delete_department">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Department</h3>
                    </div>
                    <form role="form" id="deletedepartment_form" name="deletedepartment_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Department End Here -->

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
                tableContainer = $("#department_table");

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

