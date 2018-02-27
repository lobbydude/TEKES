<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');

if ($this->uri->segment(3) != "") {
    $cur_date = $this->uri->segment(3);
    $current_date = date("Y-m-d", strtotime($cur_date));
} else {
    $current_date = date('Y-m-d');
}
?>
<script>
    function edit_attendance(attendance_id_in) {
        var formdata = {
            att_id_in: attendance_id_in
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Attendance/Editattendance') ?>",
            data: formdata,
            cache: false,
            success: function (html) {
                $("#edit_attendance_form").html(html);
            }
        });
    }
   
    function delete_attendance(attendance_id_in) {
        var formdata = {
            att_id_in: attendance_id_in
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Attendance/Deleteattendance') ?>",
            data: formdata,
            cache: false,
            success: function (html) {
                $("#delete_attendance_form").html(html);
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#importattendance_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('Attendance/import_attendance') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#importattendance_error').show();
                    }

                    if (data == "success") {
                        $('#importattendance_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {

                }
            });
        }));

        $("#add_attendance_form").on('submit', (function (e) {
            e.preventDefault();
            var formdata = {
                add_att_employee_name: $('#add_att_employee_name').val(),
                add_att_login_date: $('#add_att_login_date').val(),
                add_att_login_time: $('#add_att_login_time').val(),
                add_att_logout_date: $('#add_att_logout_date').val(),
                add_att_logout_time: $('#add_att_logout_time').val(),
                add_shiftname: $('#add_shiftname').val(),
                add_comments: $('#add_comments').val()
            };
            $.ajax({
                url: "<?php echo site_url('Attendance/add_attendance') ?>",
                type: "POST",
                data: formdata,
                cache: true,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#addattendance_success').hide();
                        $('#addattendance_exists').hide();
                        $('#addattendance_error').show();
                    }
                    if (data == "success") {
                        $('#addattendance_error').hide();
                        $('#addattendance_exists').hide();
                        $('#addattendance_success').show();
                        window.location.reload();
                    }
                    if (data == "exists") {
                        $('#addattendance_success').hide();
                        $('#addattendance_error').hide();
                        $('#addattendance_exists').show();
                    }
                },
                error: function ()
                {

                }
            });
        }));

    });
</script>
<!-- Late Login Details Start Here-->
<script>
    $(document).ready(function () {
        $('#shifttime_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                employee_list: $('#employee_list').val(),
                period_from: $('#period_from').val(),
                period_to: $('#period_to').val()
            };
            $.ajax({
                url: "<?php echo site_url('Attendance/preview') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    $('#employee_shifttime').html(msg);
                }
            });
        });
    });
    function showgroupslip() {
        $("#preview_div").hide();
        $("#grouppayslip_div").show();
    }
    function show_individual_payslip() {
        $("#grouppayslip_div").hide();
        $("#preview_div").show();
    }
</script>
<!-- Late Login Details End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h3>Daily Employee Login Details</h3>
                        </div>
                    </div>
                    <!-- Employee Attendance Filter Start-->
                    <div class="row">
                        <br /><br />
                        <div class="col-md-1"></div>
                        <form role="form" id="shifttime_form" name="shifttime_form" method="post" class="validate">                            
                            <div class="col-md-3">                                
                                <?php
                                if ($user_role == 2 || $user_role == 6 || $user_role == 1 || $user_role == 7) {
                                    ?>
                                    <select name="employee_list" id="employee_list" class="select2" data-validate="required" data-message-required="Please select employee name">
                                        <option value="">Please Select Employee</option>
                                        <option value="all">All Employees </option>
                                        <?php
                                        $this->db->where('Status', 1);
                                        $select_emp = $this->db->get('tbl_employee');
                                        foreach ($select_emp->result() as $row_emp) {
                                            $emp_no_list = $row_emp->Emp_Number;
                                            $emp_firstname = $row_emp->Emp_FirstName;
                                            $emp_middlename = $row_emp->Emp_MiddleName;
                                            $emp_lastname = $row_emp->Emp_LastName;

                                            $this->db->where('employee_number', $emp_no_list);
                                            $q_empcode = $this->db->get('tbl_emp_code');
                                            foreach ($q_empcode->result() as $row_empcode) {
                                                $emp_code = $row_empcode->employee_code;
                                                $start_number = $row_empcode->employee_number;
                                                $emp_id = str_pad(($start_number), 4, '0', STR_PAD_LEFT);
                                            }
                                            ?>
                                            <option onClick="show_individual_payslip()" value="<?php echo $emp_no_list ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>                        
                            <div class="col-md-2">
                                <div class="form-group">                                    
                                    <div class="input-group">
                                        <input type="text" name="period_from" id="period_from" class="form-control datepicker" data-format="dd-mm-yyyy" placeholder="Start Date">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">                                    
                                    <div class="input-group">
                                        <input type="text" name="period_to" id="period_to" class="form-control datepicker" data-format="dd-mm-yyyy" placeholder="End Date">
                                        <div class="input-group-addon">
                                            <a href="#"><i class="entypo-calendar"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">Preview</button>
                            </div>                                
                        </form>
                        <br /><br /> <br /><br />
                        <div id="employee_shifttime"></div>
                    </div>
                    <!-- Employee Attendance Filter End-->
                    
                    <!-- Attendance Table Format Start Here -->
                    
                    <!-- Attendance Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Import Attendance Start Here -->
        <div class="modal fade" id="import_attendance" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content" id="import_div">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Import Attendance Data</h3>
                    </div>
                    <form role="form" id="importattendance_form" name="importattendance_form" method="post" class="validate" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="importattendance_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="importattendance_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                    <div id="importattendance_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">File Upload</label>
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="file" name="import_file" id="import_file" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
                                    </div>	
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="Import">Import</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <div class="modal-content" id="export_div" style="display:none">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Export Employee Data</h3>
                    </div>
                    <form role="form" id="exportemployee_form" name="exportemployee_form" method="post" class="validate" action="<?php echo site_url('Employee/export_employee') ?>">
                        <div class="modal-body">
                            <button type="submit" class="btn btn-primary" name="Export" style="margin-left:35%;margin-bottom: 4%;width:30%">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Import Attendance End Here -->
        <!-- Add Attendance Start Here -->
        <div class="modal fade custom-width" id="add_attendance_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Mark Attendance</h3>
                    </div>
                    <form role="form" id="add_attendance_form" name="add_attendance_form" method="post" class="validate" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addattendance_exists" class="alert alert-info" style="display:none;">This employee attendance already exists.</div>
                                    <div id="addattendance_success" class="alert alert-success" style="display:none;">Attendance marked successfully.</div>
                                    <div id="addattendance_error" class="alert alert-danger" style="display:none;">Failed to mark attendance.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Employee Name</label>
                                        <select name="add_att_employee_name" id="add_att_employee_name" class="round" data-validate="required" data-message-required="Please select employee.">
                                            <option value="">Please Select</option>
                                            <?php
                                            $this->db->where('Status', 1);
                                            $select_emp = $this->db->get('tbl_employee');
                                            foreach ($select_emp->result() as $row_emp) {
                                                $emp_no_list = $row_emp->Emp_Number;
                                                $emp_firstname = $row_emp->Emp_FirstName;
                                                $emp_middlename = $row_emp->Emp_MiddleName;
                                                $emp_lastname = $row_emp->Emp_LastName;

                                                $this->db->where('employee_number', $emp_no_list);
                                                $q_empcode = $this->db->get('tbl_emp_code');
                                                foreach ($q_empcode->result() as $row_empcode) {
                                                    $emp_code = $row_empcode->employee_code;
                                                    $start_number = $row_empcode->employee_number;
                                                    $emp_id = str_pad(($start_number), 4, '0', STR_PAD_LEFT);
                                                }
                                                ?>
                                                <option value="<?php echo $emp_no_list ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Login Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_att_login_date" id="add_att_login_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Login Time</label>
                                        <input type="text" name="add_att_login_time" id="add_att_login_time" class="form-control timepicker" placeholder="H:i:s" data-template="dropdown" data-show-seconds="true" data-minute-step="5"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Logout Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_att_logout_date" id="add_att_logout_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Logout Time</label>
                                        <input type="text" name="add_att_logout_time" id="add_att_logout_time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-minute-step="5"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Shift Name</label>                                        
                                        <input type="text" name="add_shiftname" id="add_shiftname" class="form-control" placeholder="ShiftName" data-validate="required" data-message-required="Please ShiftName">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Comments</label>  
                                        <textarea name="add_comments" id="add_comments" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit" >Add</button>
                            <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Attendance End Here -->   



        <!-- Edit Attendance Start Here -->
        <div class="modal fade custom-width" id="edit_attendance_details">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Attendance</h3>
                    </div>
                    <form role="form" id="edit_attendance_form" name="edit_attendance_form" method="post" class="validate" >

                    </form>
                </div>
            </div>
        </div>      
        <!-- Edit Attendance End Here --> 
		
        <!-- Delete Attendance Start Here -->
        <div class="modal fade" id="delete_attendance_details">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Attendance</h3>
                    </div>
                    <form role="form" id="delete_attendance_form" name="delete_attendance_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Attendance End Here -->

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
                tableContainer = $("#atten_table");

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