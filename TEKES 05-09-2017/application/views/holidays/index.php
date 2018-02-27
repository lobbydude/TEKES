<?php
if ($this->uri->segment(3) != "") {
    $selected_year = $this->uri->segment(3);
} else {
    $selected_year = date('Y');
}
$this->db->order_by('Holiday_Id', 'desc');
$get_holiday = array(
    'Holiday_Year' => $selected_year,
    'Status' => 1
);
$this->db->where($get_holiday);
$q = $this->db->get('tbl_holiday');
?>
<script>
    function edit_Holiday(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Holidays/Editholiday') ?>",
            data: "holiday_id=" + id,
            cache: false,
            success: function (html) {
                $("#editholiday_form").html(html);

            }
        });
    }
    function delete_Holiday(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Holidays/Deleteholiday') ?>",
            data: "holiday_id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteholiday_form").html(html);

            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        $('#addholiday_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_holiday_name: $('#add_holiday_name').val(),
                add_holiday_date: $('#add_holiday_date').val()
            };
            $.ajax({
                url: "<?php echo site_url('Holidays/add_holiday') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addholiday_error').show();
                    }
                    if (msg == 'success') {
                        $('#addholiday_success').show();
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
                            <h2>Holidays</h2>                            
                        </div>                      
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_holiday').modal('show', {backdrop: 'static'});">
                                Add Holiday
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>                    
                    <!-- Select Year Design Start here--->                                      
                    <br /><br />                
                    <div class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <h4>Select Year</h4>
                        </div>
                        <div class="col-md-2">                                    
                            <form action="" name="holiday_search" id="holiday_search">
                                <?php
                                $holiday_year = $this->input->get('holiday_year');
                                define('DOB_YEAR_START', 2000);
                                $current_year = date('Y');                                
                                ?>
                                <select id="holiday_year" name="holiday_year" onchange="location = this.options[this.selectedIndex].value;" class="round">
                                    <?php
                                    for ($count = $current_year; $count >= DOB_YEAR_START1; $count--) {                                        
                                        ?>
                                    
                                        <option value="<?php echo site_url('Holidays/Index/' . $count); ?>" <?php if($selected_year == $count){echo 'selected="selected"';}?>><?php echo $count; ?></option>;
                                        <?php
                                    }
                                    ?>
                                </select>
                            </form>                                
                        </div>                                
                    </div>
                    <br /><br /><br /><br />       

                    <!-- Holiday Table Format Start Here -->
                    <table class="table table-bordered datatable" id="holiday_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Holiday Date</th>
                                <th>Holiday Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $holiday_id = $row->Holiday_Id;
                                $holiday_name = $row->Holiday_Name;
                                $holiday_date1 = $row->Holiday_Date;
                                $holiday_date = date("d-m-Y", strtotime($holiday_date1));
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $holiday_date; ?></td>
                                    <td><?php echo $holiday_name; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_holiday' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Holiday(<?php echo $holiday_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_holiday' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Holiday(<?php echo $holiday_id; ?>)">
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
                    <!-- Holiday Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Holiday Start Here -->
        <div class="modal fade" id="add_holiday">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add Holiday</h3>
                    </div>
                    <form role="form" id="addholiday_form" name="addholiday_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addholiday_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addholiday_success" class="alert alert-success" style="display:none;">Holiday details added successfully.</div>
                                    <div id="addholiday_error" class="alert alert-danger" style="display:none;">Failed to add holiday details.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Holiday Name</label>
                                        <input type="text" name="add_holiday_name" id="add_holiday_name" class="form-control" placeholder="Holiday Name" data-validate="required" data-message-required="Please enter holiday.">
                                    </div>	
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Holiday Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_holiday_date" id="add_holiday_date" class="form-control datepicker" placeholder="Holiday Date" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
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
        <!-- Add Holiday End Here -->

        <!-- Edit Holiday Start Here -->
        <div class="modal fade" id="edit_holiday">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Holiday</h3>
                    </div>
                    <form role="form" id="editholiday_form" name="editholiday_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Holiday End Here -->

        <!-- Delete Holiday Start Here -->
        <div class="modal fade" id="delete_holiday">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Holiday</h3>
                    </div>
                    <form role="form" id="deleteholiday_form" name="deleteholiday_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Holiday End Here -->


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
                tableContainer = $("#holiday_table");

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

