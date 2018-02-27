<script>
    $(document).ready(function () {
        $('#addleavetype_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_leavetype_title: $('#add_leavetype_title').val(),
                add_leavetype_leavetype: $('#add_leavetype_leavetype').val(),
                add_leavetype_gender: $('#add_leavetype_gender').val(),
                add_leavetype_leavedays: $('#add_leavetype_leavedays').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/add_leavetype') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "fail") {
                        $('#add_leavetype_error').show();
                    }
                    if (msg.trim() == "success") {
                        $('#add_leavetype_success').show();
                        location.reload();
                    }
                }
            });
        });
    });

</script>

<script>
    function edit_leavetype(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Editleavetype') ?>",
            data: "L_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editleavetype_form").html(html);

            }
        });
    }

    function delete_leavetype(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Deleteleavetype') ?>",
            data: "L_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteleavetype_form").html(html);

            }
        });
    }

</script>


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Leave Type</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_leavetype').modal('show', {backdrop: 'static'});">
                                New Type
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Leave type Table Format Start Here -->

                    <table class="table table-bordered datatable" id="leavetype_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>                                
                                <th>Type</th>
                                <th>Gender</th>
                                <th>Days</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('L_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_leavetype');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $L_Id = $row->L_Id;
                                $leavetitle = $row->Leave_Title;
                                $leavetype = $row->Leave_Type;
                                $leavegender = $row->Leave_Gender;
                                $leavedays = $row->Leave_Days;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $leavetitle; ?></td>
                                    <td><?php echo $leavetype; ?></td>
                                    <td><?php echo $leavegender; ?></td>
                                    <td><?php echo $leavedays; ?></td>                                    
                                    <td>
                                        <a data-toggle='modal' href='#edit_leavetype' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_leavetype(<?php echo $L_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_leavetype' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_leavetype(<?php echo $L_Id; ?>)">
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
                    <!-- Leave Type Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add New Leave Type Start Here -->
        <div class="modal fade" id="add_leavetype">
            <div class="modal-dialog" style="width:55%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Leave Type</h3>
                    </div>
                    <form role="form" id="addleavetype_form" name="addleavetype_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_leavetype_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_leavetype_success" class="alert alert-success" style="display:none;">Leave Type details added successfully.</div>
                                    <div id="add_leavetype_error" class="alert alert-danger" style="display:none;">Failed to add Leave Type details.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Title</label>
                                        <input type="text" name="add_leavetype_title" id="add_leavetype_title" class="form-control" placeholder="Leave Title" data-validate="required" data-message-required="Please Enter Title">
                                    </div>	
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Type</label>
                                        <select name="add_leavetype_leavetype" id="add_leavetype_leavetype" class="round" data-validate="required" data-message-required="Please Select Leave type.">
                                            <option value="Any Type">Any Type</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid">Unpaid</option>                                    
                                        </select>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Gender</label>
                                        <select name="add_leavetype_gender" id="add_leavetype_gender" class="round" data-validate="required" data-message-required="Please Select Gender">
                                            <option value="Any Gender">Any Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>                                           
                                        </select>
                                    </div>	
                                </div>                                
                            </div>                            
                            <div class="row">                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Days</label>
                                        <div class="input-group">
                                            <input type="text" name="add_leavetype_leavedays" id="add_leavetype_leavedays" class="form-control" placeholder="Days" data-validate="required,number" data-message-required="Please Enter Days">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary">Days</button>
                                            </span>
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
        <!-- Add New Leave Type End Here -->

        <!-- Edit Leave Type form Start Here -->

        <div class="modal fade" id="edit_leavetype">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Leave Type</h3>
                    </div>
                    <form role="form" id="editleavetype_form" name="editleavetype_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Leave Type form End Here -->

        <!-- Delete Leave Type Start Here -->

        <div class="modal fade" id="delete_leavetype">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Leave Type</h3>
                    </div>
                    <form role="form" id="deleteleavetype_form" name="deleteleavetype_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Leave Type  End Here -->

        <!-- Dashboard Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#leavetype_table");

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