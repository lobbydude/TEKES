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
    });

</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Attendance</h2>
                        </div>

                        <div class="panel-options">
                            <div class="<?php
                            if ($user_role == 2) {
                                echo 'col-sm-3';
                            } else {
                                echo 'col-sm-5';
                            }
                            ?>">
                                <input type="text" id="selected_date" class="form-control datepicker" data-start-view="2" data-format="dd-mm-yyyy" onchange="location = 'http://1.23.211.173/DRNHRMS/Attendance/Index/' + this.value;" value="<?php
                                if ($this->uri->segment(3) != "") {
                                    echo $this->uri->segment(3);
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>">
                            </div>
                            <?php if ($user_role == 2) { ?>
                                <a data-toggle='modal' href='#import_attendance' style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                    Import Attendance
                                    <i class="entypo-upload"></i>
                                </a>
                            <?php } ?>
                            <?php if ($user_role == 1 || $user_role == 2) { ?>
                                <a href="<?php echo site_url('Attendance/MonthTimesheet') ?>" style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                    Attendance Timesheet
                                    <i class="entypo-upload"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Attendance Table Format Start Here -->

                    <table class="table table-bordered datatable" id="atten_table">
                        <thead>
                            <tr>
                                <?php if ($user_role == 2) { ?>
                                    <th>S.No</th>
                                <?php } ?>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <?php if ($user_role == 2) { ?>
                                    <th>Reporting Manager</th>
                                <?php } ?>
                                <th>Shift</th>
                                <th>Login Date</th>
                                <th>Login Time</th>
                                <th>Logout Date</th>
                                <th>Logout Time</th>
                                <th>Total Hours</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 2) {

                                $data_in = array(
                                    'Login_Date' => $current_date,
                                    'Status' => 1
                                );
                                $this->db->where($data_in);
                                $q_in = $this->db->get('tbl_attendance');
                                $count_in = $q_in->num_rows();

                                if ($count_in > 0) {
                                    $i = 1;
                                    foreach ($q_in->Result() as $row_in) {

                                        $A_Id_in = $row_in->A_Id;

                                        $Login_Date1 = $row_in->Login_Date;
                                        $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                        $Login_Time = $row_in->Login_Time;

                                        $shift_name = $row_in->Shift_Name;
                                        $employee_id = $row_in->Emp_Id;

                                        $this->db->where('employee_number', $employee_id);
                                        $q_code = $this->db->get('tbl_emp_code');
                                        foreach ($q_code->result() as $row_code) {
                                            $emp_code = $row_code->employee_code;
                                        }

                                        $this->db->where('Emp_Number', $employee_id);
                                        $q_employee = $this->db->get('tbl_employee');
                                        foreach ($q_employee->result() as $row_employee) {
                                            $Emp_FirstName = $row_employee->Emp_FirstName;
                                            $Emp_Middlename = $row_employee->Emp_MiddleName;
                                            $Emp_LastName = $row_employee->Emp_LastName;
                                        }

                                        $this->db->where('Employee_Id', $employee_id);
                                        $q_career = $this->db->get('tbl_employee_career');
                                        foreach ($q_career->result() as $row_career) {
                                            $emp_report_to_id = $row_career->Reporting_To;
                                        }

                                        $this->db->where('Emp_Number', $emp_report_to_id);
                                        $q_emp = $this->db->get('tbl_employee');
                                        foreach ($q_emp->result() as $row_emp) {
                                            $emp_reporting_firstname = $row_emp->Emp_FirstName;
                                            $emp_reporting_lastname = $row_emp->Emp_LastName;
                                            $emp_reporting_middlename = $row_emp->Emp_MiddleName;
                                        }

                                        $Logout_Date1 = $row_in->Logout_Date;
                                        $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                        $Logout_Time = $row_in->Logout_Time;

                                        $h1 = strtotime($Login_Time);
                                        $h2 = strtotime($Logout_Time);
                                        $seconds = $h2 - $h1;
                                        $total_hours = gmdate("H:i:s", $seconds);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $emp_code . $employee_id; ?></td>
                                            <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                            <?php if ($user_role == 2) { ?>
                                                <td> 
                                                    <?php
                                                    echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename;
                                                    ?>
                                                </td>
                                            <?php }
                                            ?>

                                            <td><?php echo $shift_name; ?></td>
                                            <td><?php echo $Login_Date; ?></td>
                                            <td><?php echo $Login_Time; ?></td>
                                            <td><?php echo $Logout_Date; ?></td>
                                            <td><?php echo $Logout_Time; ?></td>
                                            <td><?php echo $total_hours; ?></td>
                                            <?php if ($user_role == 2) { ?>
                                                <td>
                                                    <a data-toggle='modal' href='#edit_attendance_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_attendance(<?php echo $A_Id_in; ?>)">
                                                        <i class="entypo-pencil"></i>
                                                        Edit
                                                    </a>
                                                    <a data-toggle='modal' href='#delete_attendance_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_attendance(<?php echo $A_Id_in; ?>)">
                                                        <i class="entypo-pencil"></i>
                                                        Delete
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
                            if ($user_role == 1) {
                                $report_id = $this->session->userdata('username');
                                $data_report = array(
                                    'Reporting_To' => $report_id,
                                    'Status' => 1
                                );
                                $this->db->where($data_report);
                                $q_emp_report = $this->db->get('tbl_employee_career');
                                foreach ($q_emp_report->Result() as $row_emp_report) {
                                    $employee_id = $row_emp_report->Employee_Id;

                                    $this->db->order_by('Login_Date', 'desc');
                                    $data_in = array(
                                        'Login_Date' => $current_date,
                                        'Emp_Id' => $employee_id,
                                        'Status' => 1
                                    );
                                    $this->db->where($data_in);
                                    $q_in = $this->db->get('tbl_attendance');
                                    $count_in = $q_in->num_rows();

                                    if ($count_in > 0) {

                                        foreach ($q_in->Result() as $row_in) {

                                            $A_Id_in = $row_in->A_Id;
                                            $Login_Date1 = $row_in->Login_Date;
                                            $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                            $Login_Time = $row_in->Login_Time;
                                            $shift_name = $row_in->Shift_Name;
                                            $employee_id = $row_in->Emp_Id;

                                            $this->db->where('employee_number', $employee_id);
                                            $q_code = $this->db->get('tbl_emp_code');
                                            foreach ($q_code->result() as $row_code) {
                                                $emp_code = $row_code->employee_code;
                                            }

                                            $this->db->where('Emp_Number', $employee_id);
                                            $q_employee = $this->db->get('tbl_employee');
                                            foreach ($q_employee->result() as $row_employee) {
                                                $Emp_FirstName = $row_employee->Emp_FirstName;
                                                $Emp_Middlename = $row_employee->Emp_MiddleName;
                                                $Emp_LastName = $row_employee->Emp_LastName;
                                            }

                                            $this->db->where('Employee_Id', $employee_id);
                                            $q_career = $this->db->get('tbl_employee_career');
                                            foreach ($q_career->result() as $row_career) {
                                                $emp_report_to_id = $row_career->Reporting_To;
                                            }

                                            $this->db->where('Emp_Number', $emp_report_to_id);
                                            $q_emp = $this->db->get('tbl_employee');
                                            foreach ($q_emp->result() as $row_emp) {
                                                $emp_reporting_firstname = $row_emp->Emp_FirstName;
                                                $emp_reporting_lastname = $row_emp->Emp_LastName;
                                                $emp_reporting_middlename = $row_emp->Emp_MiddleName;
                                            }

                                            $Logout_Date1 = $row_in->Logout_Date;
                                            $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                            $Logout_Time = $row_in->Logout_Time;

                                            $h1 = strtotime($Login_Time);
                                            $h2 = strtotime($Logout_Time);
                                            $seconds = $h2 - $h1;
                                            $total_hours = gmdate("H:i:s", $seconds);
                                            ?>
                                            <tr>
                                                <td><?php echo $emp_code . $employee_id; ?></td>
                                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                                <?php if ($user_role == 2) { ?>
                                                    <td> 
                                                        <?php
                                                        echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename;
                                                        ?>
                                                    </td>
                                                <?php }
                                                ?>

                                                <td><?php echo $shift_name; ?></td>
                                                <td><?php echo $Login_Date; ?></td>
                                                <td><?php echo $Login_Time; ?></td>
                                                <td><?php echo $Logout_Date; ?></td>
                                                <td><?php echo $Logout_Time; ?></td>
                                                <td><?php echo $total_hours; ?></td>
                                                <td>
                                                    <a data-toggle='modal' href='#edit_attendance_details' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_attendance(<?php echo $A_Id_in; ?>)">
                                                        <i class="entypo-pencil"></i>
                                                        Edit
                                                    </a>
                                                    <a data-toggle='modal' href='#delete_attendance_details' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_attendance(<?php echo $A_Id_in; ?>)">
                                                        <i class="entypo-pencil"></i>
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>

                    </table>
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

