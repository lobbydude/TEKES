<?php
$this->db->where('Status', 1);
$q = $this->db->get('tbl_user_role');
?>

<script>
    function editrole(role_id, role_name) {
        $("#editrole_form").show();
        $("#edit_role_id").val(role_id);
        $("#edit_role_name").val(role_name);
    }

    function deleterole(role_id, role_name) {
        $("#deleterole_form").show();
        $("#delete_role_id").val(role_id);
    }

</script>

<script>
    $(document).ready(function () {

        $("#addrole_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                role_name: $('#role_name').val()
            };

            $.ajax({
                url: "<?php echo site_url('User/add_role') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {

                    if (msg == 'fail') {
                        $('#addrole_server_error').hide();
                        $('#addrole_error').show();
                    }
                    if (msg == 'success') {
                        $('#addrole_error').hide();
                        $('#addrole_server_error').hide();
                        $('#addrole_success').hide();
                        window.location.reload();
                    }
                    else {
                        $('#addrole_error').hide();
                        $('#addrole_server_error').html(msg);
                    }
                }

            });
        });

        $("#editrole_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_role_id: $('#edit_role_id').val(),
                edit_role_name: $('#edit_role_name').val()
            };

            $.ajax({
                url: "<?php echo site_url('User/edit_role') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editrole_server_error').hide();
                        $('#editrole_error').show();
                    }
                    if (msg == 'success') {
                        $('#editrole_error').hide();
                        $('#editrole_server_error').hide();
                        window.location.reload();
                    }
                    else {
                        $('#editrole_error').hide();
                        $('#editrole_server_error').html(msg);
                    }
                }

            });
        });

        $("#deleterole_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_role_id: $('#delete_role_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('User/delete_role') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {

                    if (msg == 'fail') {
                        $('#deleterole_server_error').hide();
                        $('#deleterole_error').show();
                    }
                    if (msg == 'success') {
                        $('#deleterole_error').hide();
                        $('#deleterole_server_error').hide();
                        window.location.reload();
                    }
                    else {
                        $('#deleterole_error').hide();
                        $('#deleterole_server_error').html(msg);
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
                            <h2>User Role</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_userrole').modal('show', {backdrop: 'static'});">
                                New User Role
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- User Role Table Format Start Here -->

                    <table class="table table-bordered datatable" id="userrole_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Role Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $role_id = $row->Role_Id;
                                $role_name = $row->Role_Name;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $role_name; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_userrole' class="btn btn-default btn-sm btn-icon icon-left" onclick="editrole(<?php echo $role_id; ?>, '<?php echo $role_name ?>')">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_userrole' class="btn btn-danger btn-sm btn-icon icon-left" onclick="deleterole(<?php echo $role_id; ?>, '<?php echo $role_name ?>')">
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

                    <!-- User Role Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Role Start Here -->

        <div class="modal fade" id="add_userrole">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Userrole</h3>
                    </div>
                    <form role="form" id="addrole_form" name="addrole_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addrole_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addrole_success" class="alert alert-success" style="display:none;">User role added successfully.</div>
                                    <div id="addrole_error" class="alert alert-danger" style="display:none;">Failed to add user role.</div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Role Name</label>
                                        <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Role Name" data-validate="required" data-message-required="Please enter role name.">
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

        <!-- Add Role End Here -->

        <!-- Edit Role Start Here -->

        <div class="modal fade" id="edit_userrole">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit User Role</h3>
                    </div>
                    <form role="form" id="editrole_form" name="editrole_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="editrole_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="editrole_success" class="alert alert-success" style="display:none;">User role updated successfully.</div>
                                    <div id="editrole_error" class="alert alert-danger" style="display:none;">Failed to update user role.</div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Role Name</label>
                                        <input type="text" name="edit_role_name" id="edit_role_name" class="form-control" placeholder="Role Name" data-validate="required" data-message-required="Please enter role name.">
                                    </div>	
                                </div>
                                <input type="hidden" name="edit_role_id" id="edit_role_id" value="">

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Role End Here -->

        <!-- Delete User Role Start Here -->

        <div class="modal fade" id="delete_userrole">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete User Role</h3>
                    </div>
                    <form role="form" id="deleterole_form" name="deleterole_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                Are you sure want to delete this user role?
                            </div>
                            <input type="hidden" name="delete_role_id" id="delete_role_id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete User Role End Here -->

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
                tableContainer = $("#userrole_table");

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

