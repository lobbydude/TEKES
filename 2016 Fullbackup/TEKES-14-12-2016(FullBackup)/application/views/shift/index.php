<?php
$data_select = array(
    'Status' => 1
);
$this->db->order_by('Shift_Id', 'desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_shift_details');
?>

<!-- Time Picker -->
<script src="<?php echo site_url('js/bootstrap-timepicker.min.js') ?>"></script>

<script>
    function edit_Shift(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Shift/Editshift') ?>",
            data: "shift_id=" + id,
            cache: false,
            success: function (html) {
                $("#editshift_form").html(html);
            }
        });
    }

    function delete_Shift(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Shift/Deleteshift') ?>",
            data: "shift_id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteshift_form").html(html);
            }
        });
    }

</script>

<script>

    $(document).ready(function () {
        $('#addshift_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                shift_name: $('#shift_name').val(),
                shift_from: $('#shift_from').val(),
                shift_to: $('#shift_to').val()
            };

            $.ajax({
                url: "<?php echo site_url('Shift/Add_shift') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addshift_error').show();
                    }
                    if (msg == 'success') {
                        $('#addshift_success').show();
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
                            <h2>Shift Timings</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_shift').modal('show', {backdrop: 'static'});">
                                Add Shift
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Shift Table Format Start Here -->

                    <table class="table table-bordered datatable" id="shift_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Shift Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $Shift_Id = $row->Shift_Id;
                                $shift_name = $row->Shift_Name;
                                $shift_from = $row->Shift_From;
                                $shift_to = $row->Shift_To;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $shift_name ?></td>
                                    <td><?php echo $shift_from; ?></td>
                                    <td><?php echo $shift_to; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_shift' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Shift('<?php echo $Shift_Id; ?>')">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_shift' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Shift('<?php echo $Shift_Id; ?>')">
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
                    <!-- Shift Table Format End Here -->
                </div>
            </div>
        </section>


        <!-- Add Shift Start Here -->

        <div class="modal fade custom-width" id="add_shift">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add Shift</h3>
                    </div>
                    <form role="form" id="addshift_form" name="addshift_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addshift_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addshift_success" class="alert alert-success" style="display:none;">Shift details added successfully.</div>
                                    <div id="addshift_error" class="alert alert-danger" style="display:none;">Failed to add designation details.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Shift Name</label>
                                        <input type="text" name="shift_name" id="shift_name" class="form-control" placeholder="Shift Name" data-validate="required" data-message-required="Please enter shift name.">
                                    </div>	
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">From</label>
                                        <!--<inpu type="text" name="shift_from" id="shift_from" class="form-control" placeholder="H:i:s" data-validate="required" data-message-required="Please enter time.">-->
                                        <div class="input-group minimal">
                                            <div class="input-group-addon">
                                                <i class="entypo-clock"></i>
                                            </div>
                                            <input type="text" name="shift_from" id="shift_from" class="form-control timepicker" data-validate="required" data-message-required="Please enter time."/>
                                        </div>
                                    </div>	
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">To</label>
                                        <!--<input type="text" name="shift_to" id="shift_to" class="form-control" placeholder="H:i:s" data-validate="required" data-message-required="Please enter time.">-->
                                        <div class="input-group minimal">
                                            <div class="input-group-addon">
                                                <i class="entypo-clock"></i>
                                            </div>
                                            <input type="text" name="shift_to" id="shift_to" class="form-control timepicker" data-validate="required" data-message-required="Please enter time."/>
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

        <!-- Add Shift End Here -->

        <!-- Edit Shift Start Here -->

        <div class="modal fade custom-width" id="edit_shift">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Shift</h3>
                    </div>
                    <form role="form" id="editshift_form" name="editshift_form" method="post" class="validate" enctype="multipart/form-data">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Shift End Here -->

        <!-- Delete Shift Start Here -->

        <div class="modal fade" id="delete_shift">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Shift</h3>
                    </div>
                    <form role="form" id="deleteshift_form" name="deleteshift_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Shift End Here -->

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
                tableContainer = $("#shift_table");

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

