<script>
    $(document).ready(function () {
        $('#addleavecompoff_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_leavecompoff_title: $('#add_leavecompoff_title').val(),
                add_leavecompoff_date: $('#add_leavecompoff_date').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/add_leavecompoff') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "fail") {
                        $('#add_leavecompoff_error').show();
                    }
                    if (msg.trim() == "success") {
                        $('#add_leavecompoff_success').show();
                        location.reload();
                    }
                }
            });
        });
    });
</script>

<script>
    function edit_leavecompoff(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Editleavecompoff') ?>",
            data: "C_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editleavecompoff_form").html(html);
            }
        });
    }

    function delete_leavecompoff(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Deleteleavecompoff') ?>",
            data: "C_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteleavecompoff_form").html(html);

            }
        });
    }
    // Year Select query
    function select_year() {
    $("form#compoff_search").submit();
   }    
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Comp off</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_leavecompoff').modal('show', {backdrop: 'static'});">
                                Add Comp off
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Select Comp off Year Design Start here---> 
                    <br />              
                    <div class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <h4>Select Year</h4>
                        </div>
                        <div class="col-md-2">                                    
                            <form action="" name="compoff_search" id="compoff_search">
                                <?php
                                $compoff_year = $this->input->get('compoff_year');
                                define('DOB_YEAR_START', 2013);
                                $current_year = date('Y');
                                ?>
                                <select id="compoff_year" name="compoff_year" onchange="select_year();" class="round">
                                    <?php
                                    for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                        echo "<option value='{$count}' " . ($compoff_year == $count ? 'selected="selected"' : '') . ">{$count}</option>";
                                    }
                                    ?>
                                </select>
                            </form>                                
                        </div>                                
                    </div>
                    <br /><br /><br/>
                    <!-- Select Comp off Year Design End here--->                    

                    <!-- Leave type Table Format Start Here -->
                    <table class="table table-bordered datatable" id="leave_compoff_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>                                                                
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('Comp_Id', 'desc');
                            $this->db->where('Status', 1);                            
                            // Search based on Comp off Year Start
                            if($compoff_year) {                                
                                $minyear = $compoff_year. "-01-01";
                                $maxyear = $compoff_year. "-12-31";
                                $this->db->where("Comp_Date BETWEEN '". $minyear ."' AND '". $maxyear ."'");
                            }                     
                            // Search based on Comp off Year End
                            
                            $q = $this->db->get('tbl_compoff');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $C_Id = $row->Comp_Id;
                                $Title = $row->Title;
                                //$compoff_year = $row->Compoff_Year;
                                $Date1 = $row->Comp_Date;
                                $Date = date("d-M-Y", strtotime($Date1));                                
                                // Comp off Year Convert                                                                                       
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $Title; ?></td>                                    
                                    <td><?php echo $Date; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_leavecompoff' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_leavecompoff(<?php echo $C_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>
                                        <a data-toggle='modal' href='#delete_leavecompoff' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_leavecompoff(<?php echo $C_Id; ?>)">
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
        <div class="modal fade" id="add_leavecompoff">
            <div class="modal-dialog" style="width:55%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add Compoff</h3>
                    </div>
                    <form role="form" id="addleavecompoff_form" name="addleavecompoff_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_leavecompoff_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_leavecompoff_success" class="alert alert-success" style="display:none;">Leave Compoff details added successfully.</div>
                                    <div id="add_leavecompoff_error" class="alert alert-danger" style="display:none;">Failed to add Leave Compoff details.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Title</label>
                                        <input type="text" name="add_leavecompoff_title" id="add_leavecompoff_title" class="form-control" placeholder="Leave Title" data-validate="required" data-message-required="Please Enter Title">
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_leavecompoff_date" id="add_leavecompoff_date" placeholder="Compoff date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please Compoff date.">
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
        <!-- Add New Leave Type End Here -->

        <!-- Edit Leave Type form Start Here -->

        <div class="modal fade" id="edit_leavecompoff">
            <div class="modal-dialog" style="width:55%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Compoff</h3>
                    </div>
                    <form role="form" id="editleavecompoff_form" name="editleavecompoff_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Leave Type form End Here -->
        <!-- Delete Leave Type Start Here -->
        <div class="modal fade" id="delete_leavecompoff">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Compoff</h3>
                    </div>
                    <form role="form" id="deleteleavecompoff_form" name="deleteleavecompoff_form" method="post" class="validate">

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
                tableContainer = $("#leave_compoff_table");

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