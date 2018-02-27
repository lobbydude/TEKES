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

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Daily Movements - 
                                <?php
                                if ($this->uri->segment(3) != "") {
                                    echo date("d M Y", strtotime($this->uri->segment(3)));
                                } else {
                                    echo date('d M Y');
                                }
                                ?></h2>
                        </div>
                        <div class="panel-options">
                            <div class="col-md-6">
                                <a data-toggle='modal' href='#add_attendance_details' class="btn btn-primary btn-icon icon-left"> 
                                    Mark Attendance
                                    <i class="entypo-plus-circled"></i>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="selected_date" class="form-control datepicker" data-start-view="2" data-format="dd-mm-yyyy" onchange="location = 'http://192.168.12.151:82/TEKES/Attendance/Index/' + this.value;" value="<?php
                                if ($this->uri->segment(3) != "") {
                                    echo $this->uri->segment(3);
                                } else {
                                    echo date('d-m-Y');
                                }
                                ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Table Format Start Here -->
                    <table class="table table-bordered datatable" id="atten_table">
                        <thead>
                            <tr>
                                <?php if ($user_role == 2 || $user_role == 6 || $user_role == 1) { ?>
                                    <th>S.No</th>
                                <?php } ?>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <?php if ($user_role == 2 || $user_role == 6 || $user_role == 1) { ?>
                                    <th>Reporting Manager</th>
                                <?php } ?>                                
                                <th>Shift Type</th>
                                <th>Shift Time</th>
                                <th>Login Date</th>
                                <th>Login Time</th>
                                <th>Logout Date</th>
                                <th>Logout Time</th>
                                <th>Total Hours</th>
                                <th>Early Login</th>
                                <th>Late Login</th>
                                <th>Comments</th>
                                <?php if ($user_role == 1 || $user_role == 6 ) { ?>
								<th>Action</th>
								<?php } ?>	
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
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
                                        $Comments = $row_in->Comments;

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
                                        if ($Logout_Date1 == "0000-00-00") {
                                            $Logout_Date = "";
                                            $Logout_Time = "";
                                        } else {
                                            $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                            $Logout_Time = $row_in->Logout_Time;
                                        }
                                        $h1 = strtotime($Login_Time);
                                        $h2 = strtotime($Logout_Time);
                                        $seconds = $h2 - $h1;
                                        if ($Logout_Time == "") {
                                            $total_hours = "";
                                        } else {
                                            $total_hours = gmdate("H:i:s", $seconds);
                                        }

                                        // Shift Name Time details start here                                        
                                        $get_shift_data = array(
                                            'Employee_Id' => $employee_id,
                                            'Date' => $Login_Date1,
                                            'Status' => 1
                                        );

                                        $this->db->where($get_shift_data);
                                        $q_shift_all = $this->db->get('tbl_shift_allocate');
                                        $count_shift_all = $q_shift_all->num_rows();
                                        if ($count_shift_all > 0) {
                                            foreach ($q_shift_all->result() as $row_shift_all) {
                                                $shift_id = $row_shift_all->Shift_Id;
                                            }
                                            // Shift Name Time get value    
                                            $get_shift = array(
                                                'Shift_Id' => $shift_id,
                                                'Status' => 1
                                            );
                                            $this->db->where($get_shift);
                                            $q_shift = $this->db->get('tbl_shift_details');
                                            foreach ($q_shift->result() as $row_shift) {
                                                $Shift_Name = $row_shift->Shift_Name;
                                                $Shift_From = $row_shift->Shift_From;
                                                $Shift_From1 = date("H:i:s", strtotime($Shift_From));
                                                $Shift_To = $row_shift->Shift_To;
                                                $Shift_To1 = date("H:i:s", strtotime($Shift_To));
                                            }
                                            $shift_grace_time1 = strtotime("+16 minutes", strtotime($Shift_From1));
                                            $shift_grace_time = date('H:i:s', $shift_grace_time1);
                                        }
                                        ?>
                                        <tr <?php
                                        if ($count_shift_all > 0) {
                                            if ($shift_grace_time < $Login_Time) {
                                                echo "style='background-color:#D3D3D3;'";
                                            } if ($shift_grace_time > $Login_Time) {
                                                echo "style='background-color:#fff;'";
                                            }
                                        }
                                        ?>>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $emp_code . $employee_id; ?></td>
                                            <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                            <td> 
                                                <?php
                                                echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename;
                                                ?>
                                            </td>
                                            <td><?php echo $shift_name; ?></td>
                                            <td>
                                                <?php
                                                if ($count_shift_all > 0) {
                                                    echo $Shift_Name . " [ " . $Shift_From . " " . $Shift_To . " ] ";
                                                }
                                                ?>
                                            </td>                                            
                                            <td><?php echo $Login_Date; ?></td>
                                            <td>
                                                <?php
                                                if ($shift_grace_time < $Login_Time) {
                                                    echo "<span style='color:blue;'>$Login_Time</span>";
                                                } else {
                                                    echo $Login_Time;
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $Logout_Date; ?></td>
                                            <td><?php echo $Logout_Time; ?></td>
                                            <td><?php echo $total_hours; ?></td>
                                            <td>
                                                <?php
                                                 if ($count_shift_all != "") {
                                                $shift_24_hour_format = date("H:i:s", strtotime("$Shift_From1"));
                                                $to_time = strtotime("$Login_Date1 $shift_24_hour_format");
                                                $from_time = strtotime("$Login_Date1 $Login_Time");
                                                if (strtotime($shift_24_hour_format) > strtotime($Login_Time)) {
                                                    $before_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                    $before_hours = floor($before_total_mins / 60);
                                                    $before_minutes = $before_total_mins % 60;
                                                    echo "<span style='color:#006400;'>$before_hours H : $before_minutes M</span>";
                                                }
                                                 }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                 if ($count_shift_all != "") {
                                                if (strtotime($shift_24_hour_format) < strtotime($Login_Time)) {
                                                    $late_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                    $late_hours = floor($late_total_mins / 60);
                                                    $late_minutes = $late_total_mins % 60;
                                                    echo "<span style='color:red'>$late_hours H : $late_minutes M</span>";
                                                }
                                                 }
                                                ?>
                                            </td>
                                            <td><?php echo $Comments; ?></td>
											<?php if ($user_role == 1 || $user_role == 6) { ?>
                                            <td>
                                                <ul class="nav navbar-right pull-right">
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown" style="width:95px">Actions<b class="caret"></b></a>
                                                        <ul class="dropdown-menu">   
                                                            <li>
                                                                <a data-toggle='modal' href='#edit_attendance_details' onclick="edit_attendance(<?php echo $A_Id_in; ?>)">
                                                                    Edit
                                                                </a>                                                                
                                                            </li>
                                                            <li>
                                                                <a data-toggle='modal' href='#delete_attendance_details' onclick="delete_attendance(<?php echo $A_Id_in; ?>)">
                                                                    Delete
                                                                </a>                                                                
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </td> 
											<?php } ?>											
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
							// Manager Team Controll (my Team)
                            /*/if ($user_role == 1) {
                                $report_id = $this->session->userdata('username');
                                $data_report = array(
                                    'Reporting_To' => $report_id,
                                    'Status' => 1
                                );
                                $this->db->where($data_report);
                                $q_emp_report = $this->db->get('tbl_employee_career');
                                $h = 1;
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
                                            $employee_id = $row_in->Emp_Id;
                                            $shift_name = $row_in->Shift_Name;
                                            $Comments = $row_in->Comments;

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
                                            if ($Logout_Date1 == "0000-00-00") {
                                                $Logout_Date = "";
                                                $Logout_Time = "";
                                            } else {
                                                $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                $Logout_Time = $row_in->Logout_Time;
                                            }
                                            $h1 = strtotime($Login_Time);
                                            $h2 = strtotime($Logout_Time);
                                            $seconds = $h2 - $h1;
                                            if ($Logout_Time == "") {
                                                $total_hours = "";
                                            } else {
                                                $total_hours = gmdate("H:i:s", $seconds);
                                            }

                                            $get_shift_data = array(
                                                'Employee_Id' => $employee_id,
                                                'Date' => $Login_Date1,
                                                'Status' => 1
                                            );

                                            $this->db->where($get_shift_data);
                                            $q_shift_all = $this->db->get('tbl_shift_allocate');
                                            $count_shift_all = $q_shift_all->num_rows();
                                            if ($count_shift_all > 0) {
                                                foreach ($q_shift_all->result() as $row_shift_all) {
                                                    $shift_id = $row_shift_all->Shift_Id;
                                                }
                                                // Shift Name Time get value    
                                                $get_shift = array(
                                                    'Shift_Id' => $shift_id,
                                                    'Status' => 1
                                                );
                                                $this->db->where($get_shift);
                                                $q_shift = $this->db->get('tbl_shift_details');
                                                foreach ($q_shift->result() as $row_shift) {
                                                    $Shift_Name = $row_shift->Shift_Name;
                                                    $Shift_From = $row_shift->Shift_From;
                                                    $Shift_From1 = date("H:i:s", strtotime($Shift_From));
                                                    $Shift_To = $row_shift->Shift_To;
                                                    $Shift_To1 = date("H:i:s", strtotime($Shift_To));
                                                }
                                                $shift_grace_time1 = strtotime("+16 minutes", strtotime($Shift_From1));
                                                $shift_grace_time = date('H:i:s', $shift_grace_time1);
                                            }
                                            ?>
                                            <tr <?php
                                            if ($count_shift_all > 0) {
                                                if ($shift_grace_time < $Login_Time) {
                                                    echo "style='background-color:#D3D3D3;'";
                                                } if ($shift_grace_time > $Login_Time) {
                                                    echo "style='background-color:#fff;'";
                                                }
                                            }
                                            ?>>
                                                <td><?php echo $h; ?></td>
                                                <td><?php echo $emp_code . $employee_id; ?></td>
                                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                                <td><?php echo $shift_name; ?></td>
                                                <td>
                                                    <?php
                                                    if ($count_shift_all > 0) {
                                                        echo $Shift_Name . " [ " . $Shift_From . " " . $Shift_To . " ] ";
                                                    }
                                                    ?>
                                                </td>     
                                                <td><?php echo $Login_Date; ?></td>
                                                <td><?php
                                                    if ($shift_grace_time < $Login_Time) {
                                                        echo "<span style='color:blue;'>$Login_Time</span>";
                                                    } else {
                                                        echo $Login_Time;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $Logout_Date; ?></td>
                                                <td><?php echo $Logout_Time; ?></td>
                                                <td>
                                                    <?php
                                                    if ($Logout_Date1 != "0000-00-00") {
                                                        echo $total_hours;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($count_shift_all != "") {
                                                        $shift_24_hour_format = date("H:i:s", strtotime("$Shift_From1"));
                                                        $to_time = strtotime("$Login_Date1 $shift_24_hour_format");
                                                        $from_time = strtotime("$Login_Date1 $Login_Time");
                                                        if (strtotime($shift_24_hour_format) > strtotime($Login_Time)) {
                                                            $before_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                            $before_hours = floor($before_total_mins / 60);
                                                            $before_minutes = $before_total_mins % 60;
                                                            echo "<span style='color:#006400;'>$before_hours H : $before_minutes M</span>";
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($count_shift_all != "") {
                                                        if (strtotime($shift_24_hour_format) < strtotime($Login_Time)) {
                                                            $late_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                            $late_hours = floor($late_total_mins / 60);
                                                            $late_minutes = $late_total_mins % 60;
                                                            echo "<span style='color:red'>$late_hours H : $late_minutes M</span>";
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $Comments; ?></td>
                                                <td>
                                                    <ul class="nav navbar-right pull-right">
                                                        <li class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown" style="width:95px">Actions<b class="caret"></b></a>
                                                            <ul class="dropdown-menu">   
                                                                <li>
                                                                    <a data-toggle='modal' href='#edit_attendance_details' onclick="edit_attendance(<?php echo $A_Id_in; ?>)">
                                                                        Edit
                                                                    </a>                                                                
                                                                </li>
                                                                <li>
                                                                    <a data-toggle='modal' href='#delete_attendance_details' onclick="delete_attendance(<?php echo $A_Id_in; ?>)">
                                                                        Delete
                                                                    </a>                                                                
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </td>   
                                            </tr>
                                            <?php
                                            $h++;
                                        }
                                    }
                                }
                            }*/
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