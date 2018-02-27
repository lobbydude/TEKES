<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');

$data_allowance = array(
    'Status' => 1
);
$this->db->where($data_allowance);
$q_allowance = $this->db->get('tbl_allowance');
foreach ($q_allowance->result() as $row_allowance) {
    $allowance_id = $row_allowance->A_Id;
    $allowance_name = $row_allowance->Allowance_Name;
    $allowance_amount = $row_allowance->Allowance_Amount;
    if ($allowance_id == 1) {
        $saturday_half_day = $allowance_amount;
    }
    if ($allowance_id == 2) {
        $saturday_full_day = $allowance_amount;
    }
    if ($allowance_id == 3) {
        $saturday_night = $allowance_amount;
    }
    if ($allowance_id == 4) {
        $sunday_full_day = $allowance_amount;
    }
    if ($allowance_id == 5) {
        $sunday_night = $allowance_amount;
    }
    if ($allowance_id == 6) {
        $both_day = $allowance_amount;
    }
    if ($allowance_id == 7) {
        $both_night = $allowance_amount;
    }
}
?>

<script src="<?php echo site_url('js/excel/jquery.btechco.excelexport.js') ?>"></script>
<script src="<?php echo site_url('js/excel/jquery.base64.js') ?>"></script>

<script>
    $(document).ready(function () {
        $("#timesheet_download_button").click(function () {
            $("#timesheet_table_download").btechco_excelexport({
                containerid: "timesheet_table_download",
                datatype: $datatype.Table
            });
        });
    });

    function edit_monthly_attendance(attendance_id_in, status) {
        var formdata = {
            att_id_in: attendance_id_in,
            status: status
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Attendance/Editmonthlyattendance') ?>",
            data: formdata,
            cache: false,
            success: function (html) {
                $("#edit_monthly_timesheet_view").html(html);
            }
        });
    }
    function show_attendance(attendance) {
        if (attendance == "Present") {
            $('#attendance_mark').hide();
            $('#attendance').show();
        } else {
            $('#attendance').hide();
            $('#attendance_mark').show();
        }
    }

    function show_attendance_month(attendance) {
        if (attendance == "Present") {
            $('#monthwise_attendance_mark').hide();
            $('#monthwise_attendance').show();
        } else {
            $('#monthwise_attendance').hide();
            $('#monthwise_attendance_mark').show();
        }
    }

    function edit_monthwise_attendance(emp_id) {
        var formdata = {
            emp_id: emp_id
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Attendance/Edit_monthwise_attendance') ?>",
            data: formdata,
            cache: false,
            success: function (html) {
                $("#emp_id_div").html(html);
            }
        });
    }

    $(document).ready(function () {
        $('#edit_monthlyattendance_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_att_emp_id: $('#edit_att_emp_id').val(),
                edit_att_id_in: $('#edit_att_id_in').val(),
                edit_att_status: $('#edit_att_status').val(),
                edit_att_type: $('#edit_att_type').val(),
                edit_att_login_date: $('#edit_att_login_date').val(),
                edit_att_login_time: $('#edit_att_login_time').val(),
                edit_att_logout_date: $('#edit_att_logout_date').val(),
                edit_att_logout_time: $('#edit_att_logout_time').val(),
                edit_lop_date: $('#edit_lop_date').val(),
                edit_lop_remarks: $('#edit_lop_remarks').val()
            };
            $.ajax({
                url: "<?php echo site_url('Attendance/edit_monthlyattendance') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editattendance_error').show();
                    }
                    if (msg == 'success') {
                        $('#editattendance_error').hide();
                        $('#editattendance_success').show();
                        window.location.reload();
                    }
                }
            });
        });

        $('#edit_monthwise_attendance_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_monthwise_att_empno: $('#edit_monthwise_att_empno').val(),
                edit_monthwise_att_type: $('#edit_monthwise_att_type').val(),
                edit_monthwise_att_login_date: $('#edit_monthwise_att_login_date').val(),
                edit_monthwise_att_login_time: $('#edit_monthwise_att_login_time').val(),
                edit_monthwise_att_logout_date: $('#edit_monthwise_att_logout_date').val(),
                edit_monthwise_att_logout_time: $('#edit_monthwise_att_logout_time').val(),
                edit_monthwise_lop_date: $('#edit_monthwise_lop_date').val(),
                edit_monthwise_lop_remarks: $('#edit_monthwise_lop_remarks').val()
            };
            $.ajax({
                url: "<?php echo site_url('Attendance/Edit_MonthwiseAttendnace') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_monthwise_attendance_success').hide();
                        $('#edit_monthwise_attendance_error').show();
                    }
                    if (msg == 'success') {
                        $('#edit_monthwise_attendance_error').hide();
                        $('#edit_monthwise_attendance_success').show();
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
                            <h2>Muster Rolls</h2>
                        </div>
                        <div class="panel-options">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                    define('DOB_YEAR_START', 2000);
                                    $current_year = date('Y');
                                    ?>
                                    <select id="year_list" name="year_list" class="round" onchange="$('#change_timesheet').submit();">
                                        <?php
                                        if ($this->uri->segment(4) != "") {
                                            $cur_year = $this->uri->segment(4);
                                            for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                                ?>
                                                <option value="<?php echo $count; ?>" <?php
                                                if ($cur_year == $count) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $count; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                                        ?>
                                                <option value="<?php echo $count; ?>"><?php echo $count; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </div>
                                <div class="col-md-4">
                                    <select class="round" id="month_list" name="month_list" onchange="location = this.options[this.selectedIndex].value + '/' + $('#year_list').val();">
                                        <?php
                                        if ($this->uri->segment(3) != "") {
                                            $cur_month = $this->uri->segment(3);
                                            $cur_month_name = date("F", mktime(0, 0, 0, $cur_month, 10));
                                            for ($m = 1; $m <= 12; $m++) {
                                                ?>
                                                <option value="<?php echo site_url('Attendance/MonthTimesheet/' . $m); ?>" <?php
                                                if ($cur_month == $m) {
                                                    echo "selected=selected";
                                                }
                                                ?>>
                                                            <?php
                                                            if ($cur_month == $m) {
                                                                echo $cur_month_name;
                                                            } else {
                                                                // echo date('F');
                                                                echo date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                            }
                                                            ?>
                                                </option>
                                                <?php
                                            }
                                        } else {
                                            for ($m = 1; $m <= 12; $m++) {
                                                $current_month = date('m');
                                                $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                ?>
                                                <option value="<?php echo site_url('Attendance/MonthTimesheet/' . $m); ?>" <?php
                                                if ($current_month == $m) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $month; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <a style="margin-top:0px" class="btn btn-primary btn-icon icon-left" id="timesheet_download_button">
                                        Download
                                        <i class="entypo-upload"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Attendance Table Format Start Here -->
                    <table class="table table-bordered stripe row-border order-column" id="timesheet_table">
                        <div class="panel-body">
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn btn-blue">H</i> Holiday</a></div>
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn btn-red">A</i> Absent</a></div>
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn btn-warning">WO</i> Weekly Off</a></div>
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn btn-success">P/NP</i>Present</a></div>
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn" style="background-color: #00FFFF">HP</i> Half Day Present</a></div>
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn" style="background-color: #BF00FF;color:#fff">LOP</i> LOP</a></div>
                            <div class="icon-el col-md-1 col-sm-2"><a href="#"><i class="btn" style="background-color: #58FAD0;color:#000">COMP-OFF</i> COMP-OFF</a></div>
                        </div>
                        <?php
                        if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                            $month = $this->uri->segment(3);
                            $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                            $year = $this->uri->segment(4);
                            $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        } else {
                            $month = date("m");
                            $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                            $year = date("Y");
                            $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        }
                        ?>
                        <h3 class="col-sm-8" id="curr_div">Daily Attendance for the Month of <?php echo $cur_month_name . " " . $year ?></h3>
                        <thead> 
                            <tr>
                                <th>Employee Code</th>
                                <th>Employees</th>
                                <th>DOJ</th>
                                <th>No of Days</th>
                                <?php
                                for ($i = 1; $i <= $num; $i++) {
                                    $mktime = mktime(0, 0, 0, $month, $i, $year);
                                    $date = date("d", $mktime);
                                    $dates_month[$i] = $date;
                                    $date_n = date("d-m-Y", $mktime);
                                    ?>
                                    <th><p class='vertical-align'><?php echo $date_n; ?></p></th>
                            <?php
                        }
                        ?>

                        <th>No. of Working Days(DRNDS)</th>
                        <th>Total Holidays (H)</th>
                        <th>LOP</th>
                        <th>Disciplinary LOP</th>
                        <th>Total Hours</th>
                        <th>No. Days Present (P)</th>
                        <th>No. of Day Absent (A)</th>
                        <th>No. of Days Half day Present (HP)</th>
                        <th>Total Week Off ( Sat/ Sun)(WO)</th>
                        <th>Week End - Half Day</th>
                        <th>Week End - Day - Sat</th>
                        <th>Week End - Night - Sat</th>
                        <th>Week End - Day - Sun</th>
                        <th>Week End - Night - Sun</th>
                        <th>Week End - Both - Day</th>
                        <th>Week End - Both - Night</th>
                        <th>Week End - Total</th>
                        <th>Comp Off Availed</th>
                        <th>Weekend Eligibility</th>
                        <th>Attendance Eligibility</th>
                        <th>Weekend for Probationer Total</th>
                        <th>Weekend Amount Total</th>
                        <th>Day Shift Count</th>
                        <th>Mid Shift Count</th>
                        <th>Night Shift Count</th>
                        <th>Number of days in the month</th>
                        <th>Total comp offs</th>
                        <th>Comp off Pending</th>
                        <th>Attendance Allowance Payout (Rs)</th>
                        <th>Weekend Allowance Payout (Rs)</th>
                        <th>Shift allowances Payout (Rs)</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 2 || $user_role == 6) {
                                $i = 1;
                                $data = array(
                                    'Status' => 1
                                );
                                $this->db->where($data);
                                $q = $this->db->get('tbl_employee');
                                foreach ($q->result() as $row) {
                                    $emp_firstname = $row->Emp_FirstName;
                                    $emp_middlename = $row->Emp_MiddleName;
                                    $emp_lastname = $row->Emp_LastName;
                                    $employee_no = $row->Emp_Number;
                                    $doj = $row->Emp_Doj;
                                    $emp_doj = date("d-m-Y", strtotime($doj));
                                    $interval = date_diff(date_create(), date_create($doj));
                                    $no_days = $interval->format("%a");
                                    $this->db->where('employee_number', $employee_no);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->Result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }
                                    if ($no_days > 89) {
                                        $weekend_eligibility = "YES";
                                    } else {
                                        $weekend_eligibility = "NO";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $emp_code . $employee_no; ?></td>
                                        <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                        <td><?php echo $emp_doj; ?></td>
                                        <td><?php echo $no_days; ?></td>
                                        <?php
                                        $p = 0;
                                        $a = 0;
                                        $wp = 0;
                                        $wo = 0;
                                        $h = 0;
                                        $hp = 0;
                                        $no_of_w_days = 0;
                                        $lop = 0;
                                        $dis_lop = 0;
                                        $week_half_day = 0;
                                        $week_satfull_day = 0;
                                        $week_satmidfull_day = 0;
                                        $week_satnightfull_day = 0;
                                        $week_sunfull_day = 0;
                                        $week_sunmidfull_day = 0;
                                        $week_sunnightfull_day = 0;
                                        $week_both_day = 0;
                                        $week_both_night = 0;
                                        $comp_off_availed = 0;
                                        $weekend_probationer_total = 0;
                                        $weekend_amount_total = 0;
                                        $day_shift_count = 0;
                                        $mid_shift_count = 0;
                                        $night_shift_count = 0;
                                        $comp_off_taken = 0;
                                        $total_hours = 0;
                                        if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                                            $month = $this->uri->segment(3);
                                            $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                                            $year = $this->uri->segment(4);
                                            $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                        }
                                        $no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                        for ($i = 1; $i <= $num; $i++) {
                                            $mktime = mktime(0, 0, 0, $month, $i, $year);
                                            $date = date("d", $mktime);
                                            $dates_month[$i] = $date;
                                            $date_1 = date("d-m-Y", $mktime);
                                            $dates_month_1 = date("Y-m-d", $mktime);
                                            $curr_date_calender = strtotime(date('d-m-Y'));
                                            $calender_date = strtotime($date_1);
                                            if ($curr_date_calender >= $calender_date) {
                                                $data_compoff = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Date' => $dates_month_1,
                                                    'Type' => 'Comp Off',
                                                    'Approval' => 'Yes',
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_compoff);
                                                $q_compoff = $this->db->get('tbl_attendance_mark');
                                                $count_compoff = $q_compoff->num_rows();
                                                foreach ($q_compoff->result() as $row_compoff) {
                                                    $compoff_id = $row_compoff->A_M_Id;
                                                }
                                                $data_lop = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Date' => $dates_month_1,
                                                    'Type' => 'LOP',
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_lop);
                                                $q_lop = $this->db->get('tbl_attendance_mark');
                                                $count_lop = $q_lop->num_rows();
                                                foreach ($q_lop->result() as $row_lop) {
                                                    $lop_id = $row_lop->A_M_Id;
                                                }
                                                $data_dislop = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Date' => $dates_month_1,
                                                    'Type' => 'Disciplinary LOP',
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_dislop);
                                                $q_dislop = $this->db->get('tbl_attendance_mark');
                                                $count_dislop = $q_dislop->num_rows();
                                                foreach ($q_dislop->result() as $row_dislop) {
                                                    $dislop_id = $row_dislop->A_M_Id;
                                                }
                                                if ($count_compoff == 1) {
                                                    $comp_off_text = "Comp_Off";
                                                    echo "<td style = 'background-color:#58FAD0;color:#000'>";
                                                    echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($compoff_id,'$comp_off_text')>";
                                                    echo "COMP-OFF";
                                                    echo "</a></td>";
                                                    $comp_off_taken = $comp_off_taken + 1;
                                                } else if ($count_lop == 1) {
                                                    $lop_text = "Lop";
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>";
                                                    echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($lop_id,'$lop_text')>";
                                                    echo "LOP";
                                                    echo "</a></td>";
                                                    $lop = $lop + 1;
                                                } else if ($count_dislop == 1) {
                                                    $dis_lop_text = "Disciplinary_LOP";
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>";
                                                    echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($dislop_id,'$dis_lop_text')>";
                                                    echo "Disciplinary LOP";
                                                    echo "</a></td>";
                                                    $dis_lop = $dis_lop + 1;
                                                } else {
                                                    $dat_no_1 = date('N', strtotime($date_1));
                                                    if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                                                        $data_in_weekend = array(
                                                            'Emp_Id' => $employee_no,
                                                            'Login_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($data_in_weekend);
                                                        $q_in_weekend = $this->db->get('tbl_attendance');
                                                        $count_in_weekend = $q_in_weekend->num_rows();
                                                        if ($count_in_weekend == 1) {
                                                            foreach ($q_in_weekend->result() as $row_in_weekend) {
                                                                $A_Id_in_weekend = $row_in_weekend->A_Id;
                                                                $Login_Date1_weekend = $row_in_weekend->Login_Date;
                                                                $Login_Date = date("d-m-Y", strtotime($Login_Date1_weekend));
                                                                $Login_Time_weekend = $row_in_weekend->Login_Time;
                                                                $shift_name_weekend = $row_in_weekend->Shift_Name;
                                                                $Logout_Date1_weekend = $row_in_weekend->Logout_Date;
                                                                $Logout_Date_weekend = date("d-m-Y", strtotime($Logout_Date1_weekend));
                                                                $Logout_Time_weekend = $row_in_weekend->Logout_Time;
                                                                $h1_weekend = strtotime($Login_Time_weekend);
                                                                $h2_weekend = strtotime($Logout_Time_weekend);
                                                                $seconds_weekend = $h2_weekend - $h1_weekend;
                                                                $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                                $min_time_weekend = "04:30:00";
                                                                if ($total_hours_weekend > $min_time_weekend) {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff'>";
                                                                    echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($A_Id_in_weekend,'Present')>";
                                                                    if ($shift_name_weekend == "DS") {
                                                                        echo "DS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satfull_day = $week_satfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunfull_day = $week_sunfull_day + 1;
                                                                        }
                                                                        $day_shift_count = $day_shift_count + 1;
                                                                    }

                                                                    if ($shift_name_weekend == "MS") {
                                                                        echo "MS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                        }
                                                                        $mid_shift_count = $mid_shift_count + 1;
                                                                    }

                                                                    if ($shift_name_weekend == "NS") {
                                                                        echo "NS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                        }
                                                                        $night_shift_count = $night_shift_count + 1;
                                                                    }

                                                                    echo "</a></td>";
                                                                    $total_hours = $total_hours_weekend + $total_hours;
                                                                } else {
                                                                    echo "<td style = 'background-color:#00a651'>";
                                                                    echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($A_Id_in_weekend,'Present')>";
                                                                    if ($shift_name_weekend == "DS") {
                                                                        echo "DS";
                                                                        $day_shift_count = $day_shift_count + 0.5;
                                                                    }if ($shift_name_weekend == "MS") {
                                                                        echo "MS";
                                                                        $mid_shift_count = $mid_shift_count + 0.5;
                                                                    }
                                                                    if ($shift_name_weekend == "NS") {
                                                                        echo "NS";
                                                                        $night_shift_count = $night_shift_count + 0.5;
                                                                    }
                                                                    echo "</a></td>";
                                                                    $week_half_day = $week_half_day + 1;
                                                                    $total_hours = $total_hours_weekend + $total_hours;
                                                                }
                                                            }
                                                            $wp = $wp + 1;
                                                        } else {
                                                            if ($dat_no_1 == 6) {
                                                                echo "<td style = 'background-color:#fad839'>";
                                                                echo "<a data-toggle='modal' href='#edit_monthwise_attendance'>";
                                                                echo "SAT";
                                                                echo "</a></td>";
                                                            }if ($dat_no_1 == 7) {
                                                                echo "<td style = 'background-color:#fad839'>";
                                                                echo "<a data-toggle='modal' href='#edit_monthwise_attendance'>";
                                                                echo "SUN";
                                                                echo "</a></td>";
                                                            }
                                                        }
                                                        $wo = $wo + 1;
                                                    } else {
                                                        $holiday_data = array(
                                                            'Holiday_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($holiday_data);
                                                        $q_hol = $this->db->get('tbl_holiday');
                                                        $count_hol = $q_hol->num_rows();
                                                        if ($count_hol == 1) {
															$data_in = array(
                                                        'Emp_Id' => $employee_no,
                                                        'Login_Date' => $dates_month_1,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($data_in);
                                                    $q_in = $this->db->get('tbl_attendance');
                                                    $count_in = $q_in->num_rows();
                                                    if ($count_in == 1) {
                                                        foreach ($q_in->result() as $row_in) {
                                                            $A_Id_in = $row_in->A_Id;
                                                            $Login_Date1 = $row_in->Login_Date;
                                                            $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                            $Login_Time = $row_in->Login_Time;
                                                            $shift_name = $row_in->Shift_Name;

                                                            $Logout_Date1 = $row_in->Logout_Date;
                                                            $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                            $Logout_Time = $row_in->Logout_Time;

                                                            $h1 = strtotime($Login_Time);
                                                            $h2 = strtotime($Logout_Time);
                                                            $seconds = $h2 - $h1;
                                                            $total_hours_present = gmdate("H:i:s", $seconds);
                                                            $min_time = "04:30:00";
                                                            if ($total_hours_present > $min_time) {
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #fff;'>";
                                                                if ($shift_name == "DS") {
                                                                    echo "DS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satfull_day = $week_satfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunfull_day = $week_sunfull_day + 1;
                                                                    }
                                                                    $day_shift_count = $day_shift_count + 1;
                                                                }

                                                                if ($shift_name == "MS") {
                                                                    echo "MS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                    }
                                                                    $mid_shift_count = $mid_shift_count + 1;
                                                                }

                                                                if ($shift_name == "NS") {
                                                                    echo "NS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                    }
                                                                    $night_shift_count = $night_shift_count + 1;
                                                                }
                                                                echo "</td>";
                                                                $p = $p + 1;
                                                                $total_hours = $total_hours_present + $total_hours;
                                                            } else {
                                                                echo "<td style = 'background-color:#00ffff;border:1px solid #fff;'>HP</td>";
                                                                $hp = $hp + 1;
                                                                $total_hours = $total_hours_present + $total_hours;
                                                            }
                                                        }
                                                    }else{
                                                            echo "<td style = 'background-color:#0072bc;color:#fff'>";
                                                            echo "<a data-toggle='modal' href='#edit_monthwise_attendance'>";
                                                            echo "H";
                                                            echo "</a></td>";
													}
                                                            $h = $h + 1;
                                                        } else {
                                                            $data_in = array(
                                                                'Emp_Id' => $employee_no,
                                                                'Login_Date' => $dates_month_1,
                                                                'Status' => 1
                                                            );
                                                            $this->db->where($data_in);
                                                            $q_in = $this->db->get('tbl_attendance');
                                                            $count_in = $q_in->num_rows();
                                                            if ($count_in == 1) {
                                                                foreach ($q_in->result() as $row_in) {
                                                                    $A_Id_in = $row_in->A_Id;
                                                                    $Login_Date1 = $row_in->Login_Date;
                                                                    $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                                    $Login_Time = $row_in->Login_Time;
                                                                    $shift_name = $row_in->Shift_Name;

                                                                    $Logout_Date1 = $row_in->Logout_Date;
                                                                    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                                    $Logout_Time = $row_in->Logout_Time;

                                                                    $h1 = strtotime($Login_Time);
                                                                    $h2 = strtotime($Logout_Time);
                                                                    $seconds = $h2 - $h1;
                                                                    $total_hours_present = gmdate("H:i:s", $seconds);
                                                                    $min_time = "04:30:00";
                                                                    if ($total_hours_present > $min_time) {
                                                                        echo "<td style = 'background-color:#00a651;color:#fff'>";
                                                                        echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($A_Id_in,'Present')>";
                                                                        if ($shift_name == "DS") {
                                                                            echo "DS";
                                                                            $day_shift_count = $day_shift_count + 1;
                                                                        } if ($shift_name == "MS") {
                                                                            echo "MS";
                                                                            $mid_shift_count = $mid_shift_count + 1;
                                                                        } if ($shift_name == "NS") {
                                                                            echo "NS";
                                                                            $night_shift_count = $night_shift_count + 1;
                                                                        }
                                                                        echo "</a></td>";
                                                                        $p = $p + 1;
                                                                        $total_hours = $total_hours_present + $total_hours;
                                                                    } else {
                                                                        echo "<td style = 'background-color:#00FFFF'>";
                                                                        echo "<a data-toggle='modal' href='#edit_monthly_attendance' onclick=edit_monthly_attendance($A_Id_in,'Present')>";
                                                                        echo "HP</a></td>";
                                                                        $hp = $hp + 1;
                                                                        $total_hours = $total_hours_present + $total_hours;
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#d42020;'>";
                                                                echo "<a data-toggle='modal' href='#edit_monthwise_attendance' style = 'color:#fff' onclick=edit_monthwise_attendance('$employee_no')>";
                                                                echo "A";
                                                                echo "</a></td>";
                                                                $a = $a + 1;
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "<td style = 'background-color:#d42020;color:#fff'>";
                                                echo "-";
                                                echo "</td>";
                                                $a = $a + 1;
                                            }
                                            $no_of_w_days = $no_of_w_days + 1;
                                        }
                                        if (($week_satnightfull_day > 1) && ($week_sunnightfull_day > 1)) {
                                            $week_both_night = $week_satnightfull_day + $week_sunnightfull_day;
                                        }
                                        if (($week_satfull_day > 1) && ($week_sunfull_day > 1)) {
                                            $week_both_day = $week_satfull_day + $week_sunfull_day;
                                        }
                                        $week_total = $week_satnightfull_day + $week_sunnightfull_day + $week_satfull_day + $week_sunfull_day + $week_half_day;
                                        $no_of_days_present = $p;
                                        $no_of_working_days = $no_of_w_days - $wo - $h;
                                        if ($no_days > 89 && $no_of_working_days == $no_of_days_present) {
                                            $attendance_eligibility = "YES";
                                        } else {
                                            $attendance_eligibility = "NO";
                                        }
                                        if ($attendance_eligibility == "YES") {
                                            $attendance_allowance_payout = 500;
                                        } else {
                                            $attendance_allowance_payout = 0;
                                        }
										$weekend_allowance_payout=$week_satnightfull_day*$saturday_night + $week_sunnightfull_day*$sunday_night + $week_satfull_day*$saturday_full_day + $week_sunfull_day*$sunday_full_day + $week_half_day*$saturday_half_day;
                                        //$weekend_allowance_payout = $week_half_day * $saturday_half_day + $week_satfull_day * $saturday_full_day + $week_satnightfull_day * $saturday_night + $week_sunfull_day * $sunday_full_day + $week_sunnightfull_day * $sunday_night + $week_both_day * $both_day + $week_both_night * $both_night;
                                        $shift_allowance_payout = (int) ((1000 / $no_of_working_days) * $night_shift_count);
                                        $comp_off_pending = $week_total - $comp_off_taken;
                                        ?>
                                        <td><?php echo $no_of_working_days; ?></td>
                                        <td><?php echo $h; ?></td>
                                        <td><?php echo $lop; ?></td>
                                        <td><?php echo $dis_lop; ?></td>
                                        <td><?php echo $total_hours; ?></td>
                                        <td><?php echo $no_of_days_present; ?></td>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $hp; ?></td>  
                                        <td><?php echo $wo; ?></td>
                                        <td><?php echo $week_half_day; ?></td>
                                        <td><?php echo $week_satfull_day; ?></td>
                                        <td><?php echo $week_satnightfull_day; ?></td>
                                        <td><?php echo $week_sunfull_day; ?></td>
                                        <td><?php echo $week_sunnightfull_day; ?></td>
                                        <td><?php echo $week_both_day; ?></td>
                                        <td><?php echo $week_both_night; ?></td>
                                        <td><?php echo $week_total; ?></td>
                                        <td><?php echo $comp_off_taken; ?></td>
                                        <td><?php echo $weekend_eligibility; ?></td>
                                        <td><?php echo $attendance_eligibility; ?></td>
                                        <td><?php echo $weekend_probationer_total; ?></td>
                                        <td><?php echo $weekend_amount_total; ?></td>
                                        <td><?php echo $day_shift_count; ?></td>
                                        <td><?php echo $mid_shift_count; ?></td>
                                        <td><?php echo $night_shift_count; ?></td>
                                        <td><?php echo $no_of_days_in_month; ?></td>
                                        <td><?php echo $week_total; ?></td>
                                        <td><?php echo $comp_off_pending; ?></td>
                                        <td><?php echo $attendance_allowance_payout; ?></td>
                                        <td><?php echo $weekend_allowance_payout; ?></td>
                                        <td><?php echo $shift_allowance_payout; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            if ($user_role == 1) {
                                $i = 1;
                                $this->db->group_by('Employee_Id');
                                $data_report = array(
                                    'Reporting_To' => $emp_no,
                                    'Status' => 1
                                );
                                $this->db->where($data_report);
                                $q_emp_report = $this->db->get('tbl_employee_career');
                                foreach ($q_emp_report->Result() as $row_emp_report) {
                                    $employee_id = $row_emp_report->Employee_Id;
                                    $data = array(
                                        'Emp_Number' => $employee_id,
                                        'Status' => 1
                                    );
                                    $this->db->where($data);
                                    $q = $this->db->get('tbl_employee');
                                    foreach ($q->result() as $row) {
                                        $emp_firstname = $row->Emp_FirstName;
                                        $emp_middlename = $row->Emp_MiddleName;
                                        $emp_lastname = $row->Emp_LastName;
                                        $employee_no = $row->Emp_Number;
                                        $doj = $row->Emp_Doj;
                                        $emp_doj = date("d-m-Y", strtotime($doj));
                                        $interval = date_diff(date_create(), date_create($doj));
                                        $no_days = $interval->format("%a");
                                        $this->db->where('employee_number', $employee_no);
                                        $q_code = $this->db->get('tbl_emp_code');
                                        foreach ($q_code->Result() as $row_code) {
                                            $emp_code = $row_code->employee_code;
                                        }
                                        if ($no_days > 89) {
                                            $weekend_eligibility = "YES";
                                        } else {
                                            $weekend_eligibility = "NO";
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $emp_code . $employee_no; ?></td>
                                            <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                            <td><?php echo $emp_doj; ?></td>
                                            <td><?php echo $no_days; ?></td>
                                            <?php
                                            $p = 0;
                                            $a = 0;
                                            $wp = 0;
                                            $wo = 0;
                                            $h = 0;
                                            $hp = 0;
                                            $no_of_w_days = 0;
                                            $lop = 0;
                                            $dis_lop = 0;
                                            $week_half_day = 0;
                                            $week_satfull_day = 0;
                                            $week_satnightfull_day = 0;
											$week_satmidfull_day=0;
                                            $week_sunfull_day = 0;
                                            $week_sunnightfull_day = 0;
											$week_sunmidfull_day=0;
                                            $week_both_day = 0;
                                            $week_both_night = 0;
                                            $comp_off_availed = 0;
                                            $weekend_probationer_total = 0;
                                            $weekend_amount_total = 0;
                                            $day_shift_count = 0;
                                            $mid_shift_count = 0;
                                            $night_shift_count = 0;
                                            $comp_off_taken = 0;
                                            $total_hours = 0;
                                            if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                                                $month = $this->uri->segment(3);
                                                $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                                                $year = $this->uri->segment(4);
                                                $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                            }

                                            $no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                                            for ($i = 1; $i <= $num; $i++) {
                                                $mktime = mktime(0, 0, 0, $month, $i, $year);
                                                $date = date("d", $mktime);
                                                $dates_month[$i] = $date;

                                                $date_1 = date("d-m-Y", $mktime);
                                                $dates_month_1 = date("Y-m-d", $mktime);

                                                $data_compoff = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Date' => $dates_month_1,
                                                    'Type' => 'Comp Off',
                                                    'Approval' => 'Yes',
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_compoff);
                                                $q_compoff = $this->db->get('tbl_attendance_mark');
                                                $count_compoff = $q_compoff->num_rows();

                                                $data_lop = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Date' => $dates_month_1,
                                                    'Type' => 'LOP',
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_lop);
                                                $q_lop = $this->db->get('tbl_attendance_mark');
                                                $count_lop = $q_lop->num_rows();

                                                $data_dislop = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Date' => $dates_month_1,
                                                    'Type' => 'Disciplinary LOP',
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_dislop);
                                                $q_dislop = $this->db->get('tbl_attendance_mark');
                                                $count_dislop = $q_dislop->num_rows();

                                                if ($count_compoff == 1) {
                                                    echo "<td style = 'background-color:#58FAD0;color:#000'>COMP-OFF</td>";
                                                    $comp_off_taken = $comp_off_taken + 1;
                                                } else if ($count_lop == 1) {
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>LOP</td>";
                                                    $lop = $lop + 1;
                                                } else if ($count_dislop == 1) {
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>Disciplinary LOP</td>";
                                                    $dis_lop = $dis_lop + 1;
                                                } else {
                                                    $dat_no_1 = date('N', strtotime($date_1));
                                                    if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                                                        $data_in_weekend = array(
                                                            'Emp_Id' => $employee_no,
                                                            'Login_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($data_in_weekend);
                                                        $q_in_weekend = $this->db->get('tbl_attendance');
                                                        $count_in_weekend = $q_in_weekend->num_rows();
                                                        if ($count_in_weekend == 1) {
                                                            foreach ($q_in_weekend->result() as $row_in_weekend) {
                                                                $A_Id_in_weekend = $row_in_weekend->A_Id;
                                                                $Login_Date1_weekend = $row_in_weekend->Login_Date;
                                                                $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                                $Login_Time_weekend = $row_in_weekend->Login_Time;
                                                                $shift_name_weekend = $row_in_weekend->Shift_Name;
                                                                $Logout_Date1_weekend = $row_in_weekend->Logout_Date;
                                                                $Logout_Date_weekend = date("d-m-Y", strtotime($Logout_Date1_weekend));
                                                                $Logout_Time_weekend = $row_in_weekend->Logout_Time;

                                                                $h1_weekend = strtotime($Login_Time_weekend);
                                                                $h2_weekend = strtotime($Logout_Time_weekend);
                                                                $seconds_weekend = $h2_weekend - $h1_weekend;
                                                                $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                                $min_time_weekend = "04:30:00";
                                                                if ($total_hours_weekend > $min_time_weekend) {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff'>";
                                                                    if ($shift_name_weekend == "DS") {
                                                                        echo "DS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satfull_day = $week_satfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunfull_day = $week_sunfull_day + 1;
                                                                        }
                                                                        $day_shift_count = $day_shift_count + 1;
                                                                    }

                                                                    if ($shift_name_weekend == "MS") {
                                                                        echo "MS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                        }
                                                                        $mid_shift_count = $mid_shift_count + 1;
                                                                    }

                                                                    if ($shift_name_weekend == "NS") {
                                                                        echo "NS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                        }
                                                                        $night_shift_count = $night_shift_count + 1;
                                                                    }
                                                                    echo "</td>";
                                                                    $total_hours = $total_hours_weekend + $total_hours;
                                                                } else {
                                                                    echo "<td style = 'background-color:#00a651'>";
                                                                     if ($shift_name_weekend == "DS") {
                                                                        echo "DS";
                                                                        $day_shift_count = $day_shift_count + 0.5;
                                                                    }if ($shift_name_weekend == "MS") {
                                                                        echo "MS";
                                                                        $mid_shift_count = $mid_shift_count + 0.5;
                                                                    }
                                                                    if ($shift_name_weekend == "NS") {
                                                                        echo "NS";
                                                                        $night_shift_count = $night_shift_count + 0.5;
                                                                    }
                                                                    echo "</td>";
                                                                    $week_half_day = $week_half_day + 1;
                                                                    $total_hours = $total_hours_weekend + $total_hours;
                                                                }
                                                            }
                                                            $wp = $wp + 1;
                                                        } else {
                                                            if ($dat_no_1 == 6) {
                                                                echo "<td style = 'background-color:#fad839'>SAT</td>";
                                                            }if ($dat_no_1 == 7) {
                                                                echo "<td style = 'background-color:#fad839'>SUN</td>";
                                                            }
                                                        }
                                                        $wo = $wo + 1;
                                                    } else {
                                                        $holiday_data = array(
                                                            'Holiday_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($holiday_data);
                                                        $q_hol = $this->db->get('tbl_holiday');
                                                        $count_hol = $q_hol->num_rows();
                                                        if ($count_hol == 1) {
															$data_in = array(
                                                                'Emp_Id' => $employee_no,
                                                                'Login_Date' => $dates_month_1,
                                                                'Status' => 1
                                                            );
                                                            $this->db->where($data_in);
                                                            $q_in = $this->db->get('tbl_attendance');
                                                            $count_in = $q_in->num_rows();
                                                            if ($count_in == 1) {
                                                                foreach ($q_in->result() as $row_in) {
                                                                    $A_Id_in = $row_in->A_Id;
                                                                    $Login_Date1 = $row_in->Login_Date;
                                                                    $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                                    $Login_Time = $row_in->Login_Time;
                                                                    $shift_name = $row_in->Shift_Name;

                                                                    $Logout_Date1 = $row_in->Logout_Date;
                                                                    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                                    $Logout_Time = $row_in->Logout_Time;

                                                                    $h1 = strtotime($Login_Time);
                                                                    $h2 = strtotime($Logout_Time);
                                                                    $seconds = $h2 - $h1;
                                                                    $total_hours_present = gmdate("H:i:s", $seconds);
                                                                    $min_time = "04:30:00";
                                                                    if ($total_hours_present > $min_time) {
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #fff;'>";
                                                                        if ($shift_name == "DS") {
                                                                            echo "DS";
                                                                            if ($dat_no_1 == 6) {
                                                                                $week_satfull_day = $week_satfull_day + 1;
                                                                            }if ($dat_no_1 == 7) {
                                                                                $week_sunfull_day = $week_sunfull_day + 1;
                                                                            }
                                                                            $day_shift_count = $day_shift_count + 1;
                                                                        }

                                                                        if ($shift_name == "MS") {
                                                                            echo "MS";
                                                                            if ($dat_no_1 == 6) {
                                                                                $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                            }if ($dat_no_1 == 7) {
                                                                                $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                            }
                                                                            $mid_shift_count = $mid_shift_count + 1;
                                                                        }

                                                                        if ($shift_name == "NS") {
                                                                            echo "NS";
                                                                            if ($dat_no_1 == 6) {
                                                                                $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                            }if ($dat_no_1 == 7) {
                                                                                $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                            }
                                                                            $night_shift_count = $night_shift_count + 1;
                                                                        }
                                                                        echo "</td>";
                                                                        $p = $p + 1;
                                                                        $total_hours = $total_hours_present + $total_hours;
                                                                    } else {
                                                                        echo "<td style = 'background-color:#00ffff;border:1px solid #fff;'>HP</td>";
                                                                        $hp = $hp + 1;
                                                                        $total_hours = $total_hours_present + $total_hours;
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#0072bc;color:#fff'>H</td>";
                                                            }
                                                            $h = $h + 1;
                                                        } else {
                                                            $data_in = array(
                                                                'Emp_Id' => $employee_no,
                                                                'Login_Date' => $dates_month_1,
                                                                'Status' => 1
                                                            );
                                                            $this->db->where($data_in);
                                                            //   $this->db->group_by(array("Log_Date", "Emp_Id"));
                                                            $q_in = $this->db->get('tbl_attendance');
                                                            $count_in = $q_in->num_rows();
                                                            if ($count_in == 1) {
                                                                foreach ($q_in->result() as $row_in) {
                                                                    $A_Id_in = $row_in->A_Id;
                                                                    $Login_Date1 = $row_in->Login_Date;
                                                                    $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                                    $Login_Time = $row_in->Login_Time;
                                                                    $shift_name = $row_in->Shift_Name;

                                                                    $Logout_Date1 = $row_in->Logout_Date;
                                                                    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                                    $Logout_Time = $row_in->Logout_Time;

                                                                    $h1 = strtotime($Login_Time);
                                                                    $h2 = strtotime($Logout_Time);
                                                                    $seconds = $h2 - $h1;
                                                                    $total_hours_present = gmdate("H:i:s", $seconds);
                                                                    $min_time = "04:30:00";
                                                                    if ($total_hours_present > $min_time) {
                                                                        echo "<td style = 'background-color:#00a651;color:#fff'>";
                                                                        if ($shift_name == "DS") {
                                                                            echo "DS";
                                                                            if ($dat_no_1 == 6) {
                                                                                $week_satfull_day = $week_satfull_day + 1;
                                                                            }if ($dat_no_1 == 7) {
                                                                                $week_sunfull_day = $week_sunfull_day + 1;
                                                                            }
                                                                            $day_shift_count = $day_shift_count + 1;
                                                                        }

                                                                        if ($shift_name == "MS") {
                                                                            echo "MS";
                                                                            if ($dat_no_1 == 6) {
                                                                                $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                            }if ($dat_no_1 == 7) {
                                                                                $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                            }
                                                                            $mid_shift_count = $mid_shift_count + 1;
                                                                        }

                                                                        if ($shift_name == "NS") {
                                                                            echo "NS";
                                                                            if ($dat_no_1 == 6) {
                                                                                $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                            }if ($dat_no_1 == 7) {
                                                                                $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                            }
                                                                            $night_shift_count = $night_shift_count + 1;
                                                                        }
                                                                        echo "</td>";
                                                                        $p = $p + 1;
                                                                        $total_hours = $total_hours_present + $total_hours;
                                                                    } else {
                                                                        echo "<td style = 'background-color:#00FFFF'>HP</td>";
                                                                        $hp = $hp + 1;
                                                                        $total_hours = $total_hours_present + $total_hours;
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#d42020;color:#fff'>A</td>";
                                                                $a = $a + 1;
                                                            }
                                                        }
                                                    }
                                                }
                                                $no_of_w_days = $no_of_w_days + 1;
                                            }
                                            if (($week_satnightfull_day > 1) && ($week_sunnightfull_day > 1)) {
                                                $week_both_night = $week_satnightfull_day + $week_sunnightfull_day;
                                            }
                                            if (($week_satfull_day > 1) && ($week_sunfull_day > 1)) {
                                                $week_both_day = $week_satfull_day + $week_sunfull_day;
                                            }
                                            $week_total = $week_satnightfull_day + $week_sunnightfull_day + $week_satfull_day + $week_sunfull_day + $week_half_day;
                                            $no_of_days_present = $p;
                                            $no_of_working_days = $no_of_w_days - $wo - $h;
                                            if ($no_days > 89 && $no_of_working_days == $no_of_days_present) {
                                                $attendance_eligibility = "YES";
                                            } else {
                                                $attendance_eligibility = "NO";
                                            }
                                            if ($attendance_eligibility == "YES") {
                                                $attendance_allowance_payout = 500;
                                            } else {
                                                $attendance_allowance_payout = 0;
                                            }
											$weekend_allowance_payout=$week_satnightfull_day*$saturday_night + $week_sunnightfull_day*$sunday_night + $week_satfull_day*$saturday_full_day + $week_sunfull_day*$sunday_full_day + $week_half_day*$saturday_half_day;
                                            //$weekend_allowance_payout = $week_half_day * $saturday_half_day + $week_satfull_day * $saturday_full_day + $week_satnightfull_day * $saturday_night + $week_sunfull_day * $sunday_full_day + $week_sunnightfull_day * $sunday_night + $week_both_day * $both_day + $week_both_night * $both_night;
                                            $shift_allowance_payout = (int) ((1000 / $no_of_working_days) * $night_shift_count);
                                            $comp_off_pending = $week_total - $comp_off_taken;
                                            ?>
                                            <td><?php echo $no_of_working_days; ?></td>
                                            <td><?php echo $h; ?></td>
                                            <td><?php echo $lop; ?></td>
                                            <td><?php echo $dis_lop; ?></td>
                                            <td><?php echo $total_hours; ?></td>
                                            <td><?php echo $no_of_days_present; ?></td>
                                            <td><?php echo $a; ?></td>
                                            <td><?php echo $hp; ?></td>  
                                            <td><?php echo $wo; ?></td>
                                            <td><?php echo $week_half_day; ?></td>
                                            <td><?php echo $week_satfull_day; ?></td>
                                            <td><?php echo $week_satnightfull_day; ?></td>
                                            <td><?php echo $week_sunfull_day; ?></td>
                                            <td><?php echo $week_sunnightfull_day; ?></td>
                                            <td><?php echo $week_both_day; ?></td>
                                            <td><?php echo $week_both_night; ?></td>
                                            <td><?php echo $week_total; ?></td>
                                            <td><?php echo $comp_off_taken; ?></td>
                                            <td><?php echo $weekend_eligibility; ?></td>
                                            <td><?php echo $attendance_eligibility; ?></td>
                                            <td><?php echo $weekend_probationer_total; ?></td>
                                            <td><?php echo $weekend_amount_total; ?></td>
                                            <td><?php echo $day_shift_count; ?></td>
                                            <td><?php echo $mid_shift_count; ?></td>
                                            <td><?php echo $night_shift_count; ?></td>
                                            <td><?php echo $no_of_days_in_month; ?></td>
                                            <td><?php echo $week_total; ?></td>
                                            <td><?php echo $comp_off_pending; ?></td>
                                            <td><?php echo $attendance_allowance_payout; ?></td>
                                            <td><?php echo $weekend_allowance_payout; ?></td>
                                            <td><?php echo $shift_allowance_payout; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
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

        <!-- Edit Attendance Start Here -->

        <div class="modal fade custom-width" id="edit_monthly_attendance">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Attendance</h3>
                    </div>
                    <form role="form" id="edit_monthlyattendance_form" name="edit_monthlyattendance_form" method="post" class="validate" >
                        <div class="modal-body">
                            <div id="edit_monthly_timesheet_view"></div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="editattendance_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="editattendance_success" class="alert alert-success" style="display:none;">Attendance updated successfully.</div>
                                    <div id="editattendance_error" class="alert alert-danger" style="display:none;">Failed to update attendance.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Select Type</label>
                                        <div class="input-group">
                                            <select name="edit_att_type" id="edit_att_type" class="round" onchange="show_attendance(this.value)"> 
                                                <option value="Present">Present</option>
                                                <option value="Absent">Absent</option>
                                                <option value="Comp Off">COMP-OFF</option>
                                                <option value="LOP">LOP</option>
                                                <option value="Disciplinary LOP">Disciplinary LOP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="attendance">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Login Date</label>
                                            <div class="input-group">
                                                <input type="text" name="edit_att_login_date" id="edit_att_login_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Login Time</label>
                                            <input type="text" name="edit_att_login_time" id="edit_att_login_time" class="form-control timepicker" placeholder="H:i:s" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Logout Date</label>
                                            <div class="input-group">
                                                <input type="text" name="edit_att_logout_date" id="edit_att_logout_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Logout Time</label>
                                            <input type="text" name="edit_att_logout_time" id="edit_att_logout_time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="attendance_mark" style="display:none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Select Date</label>
                                            <div class="input-group">
                                                <input type="text" name="edit_lop_date" id="edit_lop_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Remarks</label>
                                            <div class="input-group">
                                                <textarea name="edit_lop_remarks" id="edit_lop_remarks" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit" >Update</button>
                            <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="edit_monthwise_attendance">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Attendance</h3>
                    </div>
                    <form role="form" id="edit_monthwise_attendance_form" name="edit_monthwise_attendance_form" method="post" class="validate" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="edit_monthwise_attendance_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="edit_monthwise_attendance_success" class="alert alert-success" style="display:none;">Attendance updated successfully.</div>
                                    <div id="edit_monthwise_attendance_error" class="alert alert-danger" style="display:none;">Failed to update attendance.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="emp_id_div"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Select Type</label>
                                        <div class="input-group">
                                            <select name="edit_monthwise_att_type" id="edit_monthwise_att_type" class="round" onchange="show_attendance_month(this.value)"> 
                                                <option value="Present">Present</option>
                                                <option value="Comp Off">COMP-OFF</option>
                                                <option value="LOP">LOP</option>
                                                <option value="Disciplinary LOP">Disciplinary LOP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="monthwise_attendance">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Login Date</label>
                                            <div class="input-group">
                                                <input type="text" name="edit_monthwise_att_login_date" id="edit_monthwise_att_login_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Login Time</label>
                                            <input type="text" name="edit_monthwise_att_login_time" id="edit_monthwise_att_login_time" class="form-control timepicker" placeholder="H:i:s" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Logout Date</label>
                                            <div class="input-group">
                                                <input type="text" name="edit_monthwise_att_logout_date" id="edit_monthwise_att_logout_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Logout Time</label>
                                            <input type="text" name="edit_monthwise_att_logout_time" id="edit_monthwise_att_logout_time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="monthwise_attendance_mark" style="display:none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Select Date</label>
                                            <div class="input-group">
                                                <input type="text" name="edit_monthwise_lop_date" id="edit_monthwise_lop_date" class="form-control datepicker" data-format="dd-mm-yyyy">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Remarks</label>
                                            <div class="input-group">
                                                <textarea name="edit_monthwise_lop_remarks" id="edit_monthwise_lop_remarks" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit" >Update</button>
                            <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="export_attendance" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content" id="import_div">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Export Attendance Data</h3>
                    </div>
                    <form role="form" id="exportattendance_form" name="exportattendance_form" method="post" class="validate" action="<?php echo site_url('Attendance/ExportTimesheet') ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">From</label>
                                        <div class="input-group">
                                            <input type="text" name="export_attendance_from" id="export_attendance_from" class="form-control datepicker" placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">To</label>
                                        <div class="input-group">
                                            <input type="text" name="export_attendance_to" id="export_attendance_to" class="form-control datepicker"  placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="Export">Export</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Export Attendance End Here -->

        <!-- Table Script -->
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('css/freeze_table/jquery.dataTables.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('css/freeze_table/fixedColumns.dataTables.min.css') ?>">
        <script src="<?php echo site_url('css/freeze_table/dataTables.fixedColumns.min.js') ?>"></script>
        <script type="text/javascript">
                                                var responsiveHelper;
                                                var breakpointDefinition = {
                                                    tablet: 1024, phone: 480
                                                };
                                                var tableContainer;
                                                jQuery(document).ready(function ($) {
                                                    tableContainer = $("#timesheet_table");
                                                    tableContainer.dataTable({
                                                        "scrollY": 400,
                                                        "scrollX": true,
                                                        fixedColumns: {
                                                            leftColumns: 2
                                                        },
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

        <!-- Download Table Content -->
        <div id="dv">
            <div id="timesheet_table_download" class="timesheet_table_download" style="display:none">

                <?php
                if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                    $month = $this->uri->segment(3);
                    $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                    $year = $this->uri->segment(4);
                    $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                } else {
                    $month = date("m");
                    $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                    $year = date("Y");
                    $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                }
                ?>
                <h3 class="col-sm-8" id="curr_div" style="border:1px solid #000;">Daily Attendance for the Month of <?php echo $cur_month_name . " " . $year ?></h3>

                <table class="table table-bordered">
                    <thead> 
                        <tr>
                            <th style="border:1px solid #000;">Employee Code</th>
                            <th style="border:1px solid #000;">Employees</th>
                            <th style="border:1px solid #000;">DOJ</th>
                            <th style="border:1px solid #000;">No of Days</th>
                            <?php
                            for ($i = 1; $i <= $num; $i++) {
                                $mktime = mktime(0, 0, 0, $month, $i, $year);
                                $date = date("d", $mktime);
                                $dates_month[$i] = $date;
                                $date_n = date("d-m-Y", $mktime);
                                ?>
                                <th style="border:1px solid #000;"><p style="transform: rotate(270deg);"><?php echo "'$date_n"; ?></p></th>
                        <?php
                    }
                    ?>

                    <th style="border:1px solid #000;">No. of Working Days</th>
                    <th style="border:1px solid #000;">Total Holidays (H)</th>
                    <th style="border:1px solid #000;">LOP</th>
                    <th style="border:1px solid #000;">Total Hours</th>
                    <th style="border:1px solid #000;">No. Days Present (P)</th>
                    <th style="border:1px solid #000;">No. of Day Absent (A)</th>
                    <th style="border:1px solid #000;">No. of Days Half day Present (HP)</th>
                    <th style="border:1px solid #000;">Total Week Off ( Sat/ Sun)(WO)</th>
                    <th style="border:1px solid #000;">Week End - Half Day</th>
                    <th style="border:1px solid #000;">Week End - Day - Sat</th>
                    <th style="border:1px solid #000;">Week End - Night - Sat</th>
                    <th style="border:1px solid #000;">Week End - Day - Sun</th>
                    <th style="border:1px solid #000;">Week End - Night - Sun</th>
                    <th style="border:1px solid #000;">Week End - Both - Day</th>
                    <th style="border:1px solid #000;">Week End - Both - Night</th>
                    <th style="border:1px solid #000;">Week End - Total</th>
                    <th style="border:1px solid #000;">Comp Off Availed</th>
                    <th style="border:1px solid #000;">Weekend Eligibility</th>
                    <th style="border:1px solid #000;">Attendance Eligibility</th>
                    <th style="border:1px solid #000;">Weekend for Probationer Total</th>
                    <th style="border:1px solid #000;">Weekend Amount Total</th>
                    <th style="border:1px solid #000;">Day Shift Count</th>
                    <th style="border:1px solid #000;">Mid Shift Count</th>
                    <th style="border:1px solid #000;">Night Shift Count</th>
                    <th style="border:1px solid #000;">Number of days in the month</th>
                    <th style="border:1px solid #000;">Total comp offs</th>
                    <th style="border:1px solid #000;">Comp off Pending</th>
                    <th style="border:1px solid #000;">Production Met Criteria for probationer</th>
                    <th style="border:1px solid #000;">Attendance Allowance Payout(Rs)</th>
                    <th style="border:1px solid #000;">Weekend Allowance Payout(Rs)</th>
                    <th style="border:1px solid #000;">Shift allowances Payout(Rs)</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($user_role == 2 || $user_role == 6) {
                            $i = 1;
                            $data_download = array(
                                'Status' => 1
                            );
                            $this->db->where($data_download);
                            $q_emp_download = $this->db->get('tbl_employee');
                            foreach ($q_emp_download->result() as $row_emp_download) {
                                $emp_firstname = $row_emp_download->Emp_FirstName;
                                $emp_middlename = $row_emp_download->Emp_MiddleName;
                                $emp_lastname = $row_emp_download->Emp_LastName;
                                $employee_no = $row_emp_download->Emp_Number;
                                $doj = $row_emp_download->Emp_Doj;
                                $emp_doj = date("d-m-Y", strtotime($doj));
                                $interval = date_diff(date_create(), date_create($doj));
                                $no_days = $interval->format("%a");
                                $this->db->where('employee_number', $employee_no);
                                $q_code_download = $this->db->get('tbl_emp_code');
                                foreach ($q_code_download->Result() as $row_code_download) {
                                    $emp_code = $row_code_download->employee_code;
                                }
                                if ($no_days > 89) {
                                    $weekend_eligibility = "YES";
                                } else {
                                    $weekend_eligibility = "NO";
                                }
                                ?>
                                <tr>
                                    <td style="border:1px solid #000;"><?php echo $emp_code . $employee_no; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                    <td style="border:1px solid #000;"><?php echo "'$emp_doj"; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $no_days; ?></td>
                                    <?php
                                    $p = 0;
                                    $a = 0;
                                    $wp = 0;
                                    $wo = 0;
                                    $h = 0;
                                    $hp = 0;
                                    $no_of_w_days = 0;
                                    $lop = 0;
                                    $week_half_day = 0;
                                    $week_satfull_day = 0;
                                    $week_satmidfull_day = 0;
                                    $week_satnightfull_day = 0;
                                    $week_sunfull_day = 0;
                                    $week_sunmidfull_day = 0;
                                    $week_sunnightfull_day = 0;
                                    $week_both_day = 0;
                                    $week_both_night = 0;
                                    $comp_off_availed = 0;
                                    $weekend_probationer_total = 0;
                                    $weekend_amount_total = 0;
                                    $day_shift_count = 0;
                                    $mid_shift_count = 0;
                                    $night_shift_count = 0;
                                    $comp_off_taken = 0;
                                    $total_hours = 0;
                                    if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                                        $month = $this->uri->segment(3);
                                        $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                                        $year = $this->uri->segment(4);
                                        $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                    }

                                    $no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                                    for ($i = 1; $i <= $num; $i++) {
                                        $mktime = mktime(0, 0, 0, $month, $i, $year);
                                        $date = date("d", $mktime);
                                        $dates_month[$i] = $date;

                                        $date_1 = date("d-m-Y", $mktime);
                                        $dates_month_1 = date("Y-m-d", $mktime);

                                        $data_compoff = array(
                                            'Emp_Id' => $employee_no,
                                            'Date' => $dates_month_1,
                                            'Type' => 'Comp Off',
                                            'Approval' => 'Yes',
                                            'Status' => 1
                                        );
                                        $this->db->where($data_compoff);
                                        $q_compoff = $this->db->get('tbl_attendance_mark');
                                        $count_compoff = $q_compoff->num_rows();

                                        $data_lop = array(
                                            'Emp_Id' => $employee_no,
                                            'Date' => $dates_month_1,
                                            'Type' => 'LOP',
                                            'Status' => 1
                                        );
                                        $this->db->where($data_lop);
                                        $q_lop = $this->db->get('tbl_attendance_mark');
                                        $count_lop = $q_lop->num_rows();

                                        if ($count_compoff == 1) {
                                            echo "<td style = 'background-color:#58fad0;color:#000;border:1px solid #000;'>COMP-OFF</td>";
                                            $comp_off_taken = $comp_off_taken + 1;
                                        } else if ($count_lop == 1) {
                                            echo "<td style = 'background-color:#bf00ff;color:#fff;border:1px solid #000;'>LOP</td>";
                                            $lop = $lop + 1;
                                        } else {
                                            $dat_no_1 = date('N', strtotime($date_1));
                                            if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                                                $data_in_weekend = array(
                                                    'Emp_Id' => $employee_no,
                                                    'Login_Date' => $dates_month_1,
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_in_weekend);
                                                //$this->db->group_by(array("Log_Date", "Emp_Id"));
                                                $q_in_weekend = $this->db->get('tbl_attendance');
                                                $count_in_weekend = $q_in_weekend->num_rows();
                                                if ($count_in_weekend == 1) {
                                                    foreach ($q_in_weekend->result() as $row_in_weekend) {
                                                        $A_Id_in_weekend = $row_in_weekend->A_Id;
                                                        $Login_Date1_weekend = $row_in_weekend->Login_Date;
                                                        $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                        $Login_Time_weekend = $row_in_weekend->Login_Time;
                                                        $shift_name_weekend = $row_in_weekend->Shift_Name;
                                                        $Logout_Date1_weekend = $row_in_weekend->Logout_Date;
                                                        $Logout_Date_weekend = date("d-m-Y", strtotime($Logout_Date1_weekend));
                                                        $Logout_Time_weekend = $row_in_weekend->Logout_Time;

                                                        $h1_weekend = strtotime($Login_Time_weekend);
                                                        $h2_weekend = strtotime($Logout_Time_weekend);
                                                        $seconds_weekend = $h2_weekend - $h1_weekend;
                                                        $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                        $min_time_weekend = "04:30:00";
                                                        if ($total_hours_weekend > $min_time_weekend) {
                                                            echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;'>";
                                                            if ($shift_name_weekend == "DS") {
                                                                echo "DS";
                                                                if ($dat_no_1 == 6) {
                                                                    $week_satfull_day = $week_satfull_day + 1;
                                                                }if ($dat_no_1 == 7) {
                                                                    $week_sunfull_day = $week_sunfull_day + 1;
                                                                }
                                                                $day_shift_count = $day_shift_count + 1;
                                                            }
                                                            if ($shift_name_weekend == "MS") {
                                                                echo "MS";
                                                                if ($dat_no_1 == 6) {
                                                                    $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                }if ($dat_no_1 == 7) {
                                                                    $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                }
                                                                $mid_shift_count = $mid_shift_count + 1;
                                                            }

                                                            if ($shift_name_weekend == "NS") {
                                                                echo "NS";
                                                                if ($dat_no_1 == 6) {
                                                                    $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                }if ($dat_no_1 == 7) {
                                                                    $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                }
                                                                $night_shift_count = $night_shift_count + 1;
                                                            }
                                                            echo "</td>";
                                                            $total_hours = $total_hours_weekend + $total_hours;
                                                        } else {
                                                            echo "<td style = 'background-color:#00a651;border:1px solid #000;'>";
                                                             if ($shift_name_weekend == "DS") {
                                                                        echo "DS";
                                                                        $day_shift_count = $day_shift_count + 0.5;
                                                                    }if ($shift_name_weekend == "MS") {
                                                                        echo "MS";
                                                                        $mid_shift_count = $mid_shift_count + 0.5;
                                                                    }
                                                                    if ($shift_name_weekend == "NS") {
                                                                        echo "NS";
                                                                        $night_shift_count = $night_shift_count + 0.5;
                                                                    }
                                                                    echo "</td>";
                                                            $week_half_day = $week_half_day + 1;
                                                            $total_hours = $total_hours_weekend + $total_hours;
                                                        }
                                                    }
                                                    //   echo "<td style = 'background-color:#00a651'>P</td>";
                                                    $wp = $wp + 1;
                                                } else {
                                                    if ($dat_no_1 == 6) {
                                                        echo "<td style = 'background-color:#fad839;border:1px solid #000;'>SAT</td>";
                                                    }if ($dat_no_1 == 7) {
                                                        echo "<td style = 'background-color:#fad839;border:1px solid #000;'>SUN</td>";
                                                    }
                                                }
                                                $wo = $wo + 1;
                                            } else {
                                                $holiday_data = array(
                                                    'Holiday_Date' => $dates_month_1,
                                                    'Status' => 1
                                                );
                                                $this->db->where($holiday_data);
                                                $q_hol = $this->db->get('tbl_holiday');
                                                $count_hol = $q_hol->num_rows();
                                                if ($count_hol == 1) {
                                                    echo "<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;'>H</td>";
                                                    $h = $h + 1;
                                                } else {
                                                    $data_in = array(
                                                        'Emp_Id' => $employee_no,
                                                        'Login_Date' => $dates_month_1,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($data_in);
                                                    //   $this->db->group_by(array("Log_Date", "Emp_Id"));
                                                    $q_in = $this->db->get('tbl_attendance');
                                                    $count_in = $q_in->num_rows();
                                                    if ($count_in == 1) {
                                                        foreach ($q_in->result() as $row_in) {
                                                            $A_Id_in = $row_in->A_Id;
                                                            $Login_Date1 = $row_in->Login_Date;
                                                            $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                            $Login_Time = $row_in->Login_Time;
                                                            $shift_name = $row_in->Shift_Name;

                                                            $Logout_Date1 = $row_in->Logout_Date;
                                                            $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                            $Logout_Time = $row_in->Logout_Time;

                                                            $h1 = strtotime($Login_Time);
                                                            $h2 = strtotime($Logout_Time);
                                                            $seconds = $h2 - $h1;
                                                            $total_hours_present = gmdate("H:i:s", $seconds);
                                                            $min_time = "04:30:00";
                                                            if ($total_hours_present > $min_time) {
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;'>";
                                                                if ($shift_name == "DS") {
                                                                    echo "DS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satfull_day = $week_satfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunfull_day = $week_sunfull_day + 1;
                                                                    }
                                                                    $day_shift_count = $day_shift_count + 1;
                                                                }

                                                                if ($shift_name == "MS") {
                                                                    echo "MS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                    }
                                                                    $mid_shift_count = $mid_shift_count + 1;
                                                                }

                                                                if ($shift_name == "NS") {
                                                                    echo "NS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                    }
                                                                    $night_shift_count = $night_shift_count + 1;
                                                                }
                                                                echo "</td>";
                                                                $p = $p + 1;
                                                                $total_hours = $total_hours_present + $total_hours;
                                                            } else {
                                                                echo "<td style = 'background-color:#00ffff;border:1px solid #000;'>HP</td>";
                                                                $hp = $hp + 1;
                                                                $total_hours = $total_hours_present + $total_hours;
                                                            }
                                                        }
                                                    } else {
                                                        echo "<td style = 'background-color:#d42020;color:#fff;border:1px solid #000;'>A</td>";
                                                        $a = $a + 1;
                                                    }
                                                }
                                            }
                                        }
                                        $no_of_w_days = $no_of_w_days + 1;
                                    }
                                    if (($week_satnightfull_day > 1) && ($week_sunnightfull_day > 1)) {
                                        $week_both_night = $week_satnightfull_day + $week_sunnightfull_day;
                                    }
                                    if (($week_satfull_day > 1) && ($week_sunfull_day > 1)) {
                                        $week_both_day = $week_satfull_day + $week_sunfull_day;
                                    }
                                    $week_total = $week_satnightfull_day + $week_sunnightfull_day + $week_satfull_day + $week_sunfull_day + $week_half_day;
                                    $no_of_days_present = $p;
                                    $no_of_working_days = $no_of_w_days - $wo - $h;
                                    if ($no_days > 89 && $no_of_working_days == $no_of_days_present) {
                                        $attendance_eligibility = "YES";
                                    } else {
                                        $attendance_eligibility = "NO";
                                    }
                                    if ($attendance_eligibility == "YES") {
                                        $attendance_allowance_payout = 500;
                                    } else {
                                        $attendance_allowance_payout = 0;
                                    }
									$weekend_allowance_payout=$week_satnightfull_day*$saturday_night + $week_sunnightfull_day*$sunday_night + $week_satfull_day*$saturday_full_day + $week_sunfull_day*$sunday_full_day + $week_half_day*$saturday_half_day;
                                    //$weekend_allowance_payout = $week_half_day * $saturday_half_day + $week_satfull_day * $saturday_full_day + $week_satnightfull_day * $saturday_night + $week_sunfull_day * $sunday_full_day + $week_sunnightfull_day * $sunday_night + $week_both_day * $both_day + $week_both_night * $both_night;
                                    $shift_allowance_payout = (int) ((1000 / $no_of_working_days) * $night_shift_count);
                                    $comp_off_pending = $week_total - $comp_off_taken;
                                    ?>
                                    <td style="border:1px solid #000;"><?php echo $no_of_working_days; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $h; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $lop; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $total_hours; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $no_of_days_present; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $a; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $hp; ?></td>  
                                    <td style="border:1px solid #000;"><?php echo $wo; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_half_day; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_satfull_day; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_satnightfull_day; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_sunfull_day; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_sunnightfull_day; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_both_day; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_both_night; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_total; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $comp_off_taken; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $weekend_eligibility; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $attendance_eligibility; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $weekend_probationer_total; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $weekend_amount_total; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $day_shift_count; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $mid_shift_count; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $night_shift_count; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $no_of_days_in_month; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $week_total; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $comp_off_pending; ?></td>
                                    <td style="border:1px solid #000;"></td>
                                    <td style="border:1px solid #000;"><?php echo $attendance_allowance_payout; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $weekend_allowance_payout; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $shift_allowance_payout; ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        if ($user_role == 1) {
                            $i = 1;
                            $this->db->group_by('Employee_Id');
                            $data_report = array(
                                'Reporting_To' => $emp_no,
                                'Status' => 1
                            );
                            $this->db->where($data_report);
                            $q_emp_report = $this->db->get('tbl_employee_career');
                            foreach ($q_emp_report->Result() as $row_emp_report) {
                                $employee_id = $row_emp_report->Employee_Id;
                                $data = array(
                                    'Emp_Number' => $employee_id,
                                    'Status' => 1
                                );
                                $this->db->where($data);
                                $q = $this->db->get('tbl_employee');
                                foreach ($q->result() as $row) {
                                    $emp_firstname = $row->Emp_FirstName;
                                    $emp_middlename = $row->Emp_MiddleName;
                                    $emp_lastname = $row->Emp_LastName;
                                    $employee_no = $row->Emp_Number;
                                    $doj = $row->Emp_Doj;
                                    $emp_doj = date("d-m-Y", strtotime($doj));
                                    $interval = date_diff(date_create(), date_create($doj));
                                    $no_days = $interval->format("%a");
                                    $this->db->where('employee_number', $employee_no);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->Result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }
                                    if ($no_days > 89) {
                                        $weekend_eligibility = "YES";
                                    } else {
                                        $weekend_eligibility = "NO";
                                    }
                                    ?>
                                    <tr>
                                        <td style="border:1px solid #000;"><?php echo $emp_code . $employee_no; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $emp_doj; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $no_days; ?></td>
                                        <?php
                                        $p = 0;
                                        $a = 0;
                                        $wp = 0;
                                        $wo = 0;
                                        $h = 0;
                                        $hp = 0;
                                        $no_of_w_days = 0;
                                        $lop = 0;
                                        $dis_lop = 0;
                                        $week_half_day = 0;
                                        $week_satfull_day = 0;
                                        $week_satmidfull_day = 0;
                                        $week_satnightfull_day = 0;
                                        $week_sunfull_day = 0;
                                        $week_sunmidfull_day = 0;
                                        $week_sunnightfull_day = 0;
                                        $week_both_day = 0;
                                        $week_both_night = 0;
                                        $comp_off_availed = 0;
                                        $weekend_probationer_total = 0;
                                        $weekend_amount_total = 0;
                                        $day_shift_count = 0;
                                        $night_shift_count = 0;
                                        $comp_off_taken = 0;
                                        $total_hours = 0;
                                        if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                                            $month = $this->uri->segment(3);
                                            $cur_month_name = date("F", mktime(0, 0, 0, $month, 10));
                                            $year = $this->uri->segment(4);
                                            $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                        }
                                        $no_of_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                        for ($i = 1; $i <= $num; $i++) {
                                            $mktime = mktime(0, 0, 0, $month, $i, $year);
                                            $date = date("d", $mktime);
                                            $dates_month[$i] = $date;

                                            $date_1 = date("d-m-Y", $mktime);
                                            $dates_month_1 = date("Y-m-d", $mktime);

                                            $data_compoff = array(
                                                'Emp_Id' => $employee_no,
                                                'Date' => $dates_month_1,
                                                'Type' => 'Comp Off',
                                                'Approval' => 'Yes',
                                                'Status' => 1
                                            );
                                            $this->db->where($data_compoff);
                                            $q_compoff = $this->db->get('tbl_attendance_mark');
                                            $count_compoff = $q_compoff->num_rows();

                                            $data_lop = array(
                                                'Emp_Id' => $employee_no,
                                                'Date' => $dates_month_1,
                                                'Type' => 'LOP',
                                                'Status' => 1
                                            );
                                            $this->db->where($data_lop);
                                            $q_lop = $this->db->get('tbl_attendance_mark');
                                            $count_lop = $q_lop->num_rows();

                                            $data_dislop = array(
                                                'Emp_Id' => $employee_no,
                                                'Date' => $dates_month_1,
                                                'Type' => 'Disciplinary LOP',
                                                'Status' => 1
                                            );
                                            $this->db->where($data_dislop);
                                            $q_dislop = $this->db->get('tbl_attendance_mark');
                                            $count_dislop = $q_dislop->num_rows();

                                            if ($count_compoff == 1) {
                                                echo "<td style = 'background-color:#58fad0;color:#000;border:1px solid #000;'>COMP-OFF</td>";
                                                $comp_off_taken = $comp_off_taken + 1;
                                            } else if ($count_lop == 1) {
                                                echo "<td style = 'background-color:#bf00ff;color:#fff;border:1px solid #000;'>LOP</td>";
                                                $lop = $lop + 1;
                                            } else if ($count_dislop == 1) {
                                                echo "<td style = 'background-color:#bf00ff;color:#fff;border:1px solid #000;'>Disciplinary LOP</td>";
                                                $dis_lop = $dis_lop + 1;
                                            } else {
                                                $dat_no_1 = date('N', strtotime($date_1));
                                                if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                                                    $data_in_weekend = array(
                                                        'Emp_Id' => $employee_no,
                                                        'Login_Date' => $dates_month_1,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($data_in_weekend);
                                                    $q_in_weekend = $this->db->get('tbl_attendance');
                                                    $count_in_weekend = $q_in_weekend->num_rows();
                                                    if ($count_in_weekend == 1) {
                                                        foreach ($q_in_weekend->result() as $row_in_weekend) {
                                                            $A_Id_in_weekend = $row_in_weekend->A_Id;
                                                            $Login_Date1_weekend = $row_in_weekend->Login_Date;
                                                            $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                            $Login_Time_weekend = $row_in_weekend->Login_Time;
                                                            $shift_name_weekend = $row_in_weekend->Shift_Name;
                                                            $Logout_Date1_weekend = $row_in_weekend->Logout_Date;
                                                            $Logout_Date_weekend = date("d-m-Y", strtotime($Logout_Date1_weekend));
                                                            $Logout_Time_weekend = $row_in_weekend->Logout_Time;

                                                            $h1_weekend = strtotime($Login_Time_weekend);
                                                            $h2_weekend = strtotime($Logout_Time_weekend);
                                                            $seconds_weekend = $h2_weekend - $h1_weekend;
                                                            $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                            $min_time_weekend = "04:30:00";
                                                            if ($total_hours_weekend > $min_time_weekend) {
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;'>";
                                                                if ($shift_name_weekend == "DS") {
                                                                    echo "DS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satfull_day = $week_satfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunfull_day = $week_sunfull_day + 1;
                                                                    }
                                                                    $day_shift_count = $day_shift_count + 1;
                                                                }

                                                                if ($shift_name_weekend == "MS") {
                                                                    echo "MS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                    }
                                                                    $mid_shift_count = $mid_shift_count + 1;
                                                                }

                                                                if ($shift_name_weekend == "NS") {
                                                                    echo "NS";
                                                                    if ($dat_no_1 == 6) {
                                                                        $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                    }if ($dat_no_1 == 7) {
                                                                        $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                    }
                                                                    $night_shift_count = $night_shift_count + 1;
                                                                }
                                                                echo "</td>";
                                                                $total_hours = $total_hours_weekend + $total_hours;
                                                            } else {
                                                                echo "<td style = 'background-color:#00a651;border:1px solid #000;'>";
                                                                 if ($shift_name_weekend == "DS") {
                                                                        echo "DS";
                                                                        $day_shift_count = $day_shift_count + 0.5;
                                                                    }if ($shift_name_weekend == "MS") {
                                                                        echo "MS";
                                                                        $mid_shift_count = $mid_shift_count + 0.5;
                                                                    }
                                                                    if ($shift_name_weekend == "NS") {
                                                                        echo "NS";
                                                                        $night_shift_count = $night_shift_count + 0.5;
                                                                    }
                                                                    echo "</td>";
                                                                $week_half_day = $week_half_day + 1;
                                                                $total_hours = $total_hours_weekend + $total_hours;
                                                            }
                                                        }
                                                        $wp = $wp + 1;
                                                    } else {
                                                        if ($dat_no_1 == 6) {
                                                            echo "<td style = 'background-color:#fad839;border:1px solid #000;'>SAT</td>";
                                                        }if ($dat_no_1 == 7) {
                                                            echo "<td style = 'background-color:#fad839;border:1px solid #000;'>SUN</td>";
                                                        }
                                                    }
                                                    $wo = $wo + 1;
                                                } else {
                                                    $holiday_data = array(
                                                        'Holiday_Date' => $dates_month_1,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($holiday_data);
                                                    $q_hol = $this->db->get('tbl_holiday');
                                                    $count_hol = $q_hol->num_rows();
                                                    if ($count_hol == 1) {
                                                        echo "<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;'>H</td>";
                                                        $h = $h + 1;
                                                    } else {
                                                        $data_in = array(
                                                            'Emp_Id' => $employee_no,
                                                            'Login_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($data_in);
                                                        //   $this->db->group_by(array("Log_Date", "Emp_Id"));
                                                        $q_in = $this->db->get('tbl_attendance');
                                                        $count_in = $q_in->num_rows();
                                                        if ($count_in == 1) {
                                                            foreach ($q_in->result() as $row_in) {
                                                                $A_Id_in = $row_in->A_Id;
                                                                $Login_Date1 = $row_in->Login_Date;
                                                                $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                                $Login_Time = $row_in->Login_Time;
                                                                $shift_name = $row_in->Shift_Name;

                                                                $Logout_Date1 = $row_in->Logout_Date;
                                                                $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                                $Logout_Time = $row_in->Logout_Time;

                                                                $h1 = strtotime($Login_Time);
                                                                $h2 = strtotime($Logout_Time);
                                                                $seconds = $h2 - $h1;
                                                                $total_hours_present = gmdate("H:i:s", $seconds);
                                                                $min_time = "04:30:00";
                                                                if ($total_hours_present > $min_time) {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;'>";
                                                                    if ($shift_name == "DS") {
                                                                        echo "DS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satfull_day = $week_satfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunfull_day = $week_sunfull_day + 1;
                                                                        }
                                                                        $day_shift_count = $day_shift_count + 1;
                                                                    }

                                                                    if ($shift_name == "MS") {
                                                                        echo "MS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satmidfull_day = $week_satmidfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunmidfull_day = $week_sunmidfull_day + 1;
                                                                        }
                                                                        $mid_shift_count = $mid_shift_count + 1;
                                                                    }

                                                                    if ($shift_name == "NS") {
                                                                        echo "NS";
                                                                        if ($dat_no_1 == 6) {
                                                                            $week_satnightfull_day = $week_satnightfull_day + 1;
                                                                        }if ($dat_no_1 == 7) {
                                                                            $week_sunnightfull_day = $week_sunnightfull_day + 1;
                                                                        }
                                                                        $night_shift_count = $night_shift_count + 1;
                                                                    }
                                                                    echo "</td>";
                                                                    $p = $p + 1;
                                                                    $total_hours = $total_hours_present + $total_hours;
                                                                } else {
                                                                    echo "<td style = 'background-color:#00ffff;border:1px solid #000;'>HP</td>";
                                                                    $hp = $hp + 1;
                                                                    $total_hours = $total_hours_present + $total_hours;
                                                                }
                                                            }
                                                        } else {
                                                            echo "<td style = 'background-color:#d42020;color:#fff;border:1px solid #000;'>A</td>";
                                                            $a = $a + 1;
                                                        }
                                                    }
                                                }
                                            }
                                            $no_of_w_days = $no_of_w_days + 1;
                                        }
                                        if (($week_satnightfull_day > 1) && ($week_sunnightfull_day > 1)) {
                                            $week_both_night = $week_satnightfull_day + $week_sunnightfull_day;
                                        }
                                        if (($week_satfull_day > 1) && ($week_sunfull_day > 1)) {
                                            $week_both_day = $week_satfull_day + $week_sunfull_day;
                                        }
                                        $week_total = $week_satnightfull_day + $week_sunnightfull_day + $week_satfull_day + $week_sunfull_day + $week_half_day;
                                        $no_of_days_present = $p;
                                        $no_of_working_days = $no_of_w_days - $wo - $h;
                                        if ($no_days > 89 && $no_of_working_days == $no_of_days_present) {
                                            $attendance_eligibility = "YES";
                                        } else {
                                            $attendance_eligibility = "NO";
                                        }
                                        if ($attendance_eligibility == "YES") {
                                            $attendance_allowance_payout = 500;
                                        } else {
                                            $attendance_allowance_payout = 0;
                                        }
                                        //$weekend_allowance_payout = $week_half_day * $saturday_half_day + $week_satfull_day * $saturday_full_day + $week_satnightfull_day * $saturday_night + $week_sunfull_day * $sunday_full_day + $week_sunnightfull_day * $sunday_night + $week_both_day * $both_day + $week_both_night * $both_night;
										$weekend_allowance_payout=$week_satnightfull_day*$saturday_night + $week_sunnightfull_day*$sunday_night + $week_satfull_day*$saturday_full_day + $week_sunfull_day*$sunday_full_day + $week_half_day*$saturday_half_day;
                                        $shift_allowance_payout = (int) ((1000 / $no_of_working_days) * $night_shift_count);
                                        $comp_off_pending = $week_total - $comp_off_taken;
                                        ?>
                                        <td style="border:1px solid #000;"><?php echo $no_of_working_days; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $h; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $lop; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $dis_lop; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $total_hours; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $no_of_days_present; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $a; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $hp; ?></td>  
                                        <td style="border:1px solid #000;"><?php echo $wo; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_half_day; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_satfull_day; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_satnightfull_day; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_sunfull_day; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_sunnightfull_day; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_both_day; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_both_night; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_total; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $comp_off_taken; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $weekend_eligibility; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $attendance_eligibility; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $weekend_probationer_total; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $weekend_amount_total; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $day_shift_count; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $mid_shift_count; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $night_shift_count; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $no_of_days_in_month; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $week_total; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $comp_off_pending; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $attendance_allowance_payout; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $weekend_allowance_payout; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $shift_allowance_payout; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>