<script>
    $(document).ready(function () {
        $('#addleavecarryforward_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                start_year_list: $('#start_year_list').val(),
                end_year_list: $('#end_year_list').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/add_leavecarryforward') ?>",
                type: 'post',
                data: formdata,
                cache: false,
                success: function (msg) {
                    if (msg.trim() == "fail") {
                        $('#add_leavecarryforward_error').show();
                    }
                    if (msg.trim() == "success") {
                        $('#add_leavecarryforward_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>

<script>
    function edit_leavecarryforward(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Editleavecarryforward') ?>",
            data: "L_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editleavecarryforward_form").html(html);

            }
        });
    }

    function delete_leavecarryforward(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Deleteleavecarryforward') ?>",
            data: "L_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteleavecarryforward_form").html(html);
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
                            <h2>Annual Leave Carry Forward</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_leavecarryforward').modal('show', {backdrop: 'static'});">
                                Add New
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Leave Carry Forward Table Format Start Here -->

                    <table class="table table-bordered datatable" id="leavecarryforward_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>From</th>                                
                                <th>To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('L_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_leave_carryforward_type');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $L_Id = $row->L_Id;
                                $Start_Year1 = $row->Start_Year;
                                $Start_Year = date("d-m-Y", strtotime($Start_Year1));
                                $End_Year1 = $row->End_Year;
                                $End_Year = date("d-m-Y", strtotime($End_Year1));
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $Start_Year; ?></td>
                                    <td><?php echo $End_Year; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_leavecarryforward' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_leavecarryforward(<?php echo $L_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>
                                        <a data-toggle='modal' href='#delete_leavecarryforward' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_leavecarryforward(<?php echo $L_Id; ?>)">
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
                    <!-- Leave Carry Forward Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add New Leave Carry Forward Start Here -->
        <div class="modal fade" id="add_leavecarryforward">
            <div class="modal-dialog" style="width:55%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Annual Leave Carry Forward</h3>
                    </div>
                    <form role="form" id="addleavecarryforward_form" name="addleavecarryforward_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_leavecarryforward_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_leavecarryforward_success" class="alert alert-success" style="display:none;">Leave Carry Forward added successfully.</div>
                                    <div id="add_leavecarryforward_error" class="alert alert-danger" style="display:none;">Failed to add Leave Carry Forward.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Financial Start Year</label>
                                        <div class="input-group">
                                            <input type="text" name="start_year_list" id="start_year_list" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select start year.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Financial End Year</label>
                                        <div class="input-group">
                                            <input type="text" name="end_year_list" id="end_year_list" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select end year.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:65%;left:45%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
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
        <!-- Add New Leave Carry Forward End Here -->

        <!-- Edit Leave Carry Forward form Start Here -->

        <div class="modal fade" id="edit_leavecarryforward">
            <div class="modal-dialog" style="width:55%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Leave Carry Forward</h3>
                    </div>
                    <form role="form" id="editleavecarryforward_form" name="editleavecarryforward_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Leave Carry Forward form End Here -->

        <!-- Delete Leave Carry Forward Start Here -->

        <div class="modal fade" id="delete_leavecarryforward">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Leave Carry Forward</h3>
                    </div>
                    <form role="form" id="deleteleavecarryforward_form" name="deleteleavecarryforward_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Leave Carry Forward  End Here -->

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
                tableContainer = $("#leavecarryforward_table");

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