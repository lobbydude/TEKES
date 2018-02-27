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
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Monthly Attendance</h2>
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
                                                <option value="<?php echo site_url('Attendance/MonthAttendance/' . $m); ?>" <?php
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
                                                <option value="<?php echo site_url('Attendance/MonthAttendance/' . $m); ?>" <?php
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
                                        $week_satnightfull_day = 0;
                                        $week_sunfull_day = 0;
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
                                            $curr_date_calender = strtotime(date('d-m-Y'));
                                            $calender_date = strtotime($date_1);
                                            if ($curr_date_calender > $calender_date) {
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
                                                    echo "COMP-OFF";
                                                    echo "</td>";
                                                } else if ($count_lop == 1) {
                                                    $lop_text = "Lop";
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>";
                                                    echo "LOP";
                                                    echo "</td>";
                                                } else if ($count_dislop == 1) {
                                                    $dis_lop_text = "Disciplinary_LOP";
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>";
                                                    echo "Disciplinary LOP";
                                                    echo "</td>";
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
                                                                    if ($shift_name_weekend == "NIGHT -1" || $shift_name_weekend == "NIGHT -2") {
                                                                        echo "$Login_Time_weekend : $Logout_Time_weekend";
                                                                    } else {
                                                                        echo "$Login_Time_weekend : $Logout_Time_weekend";
                                                                    }
                                                                    echo "</td>";
                                                                } else {
                                                                    echo "<td style = 'background-color:#00a651'>";
                                                                    echo "$Login_Time_weekend : $Logout_Time_weekend";
                                                                    echo "</td>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($dat_no_1 == 6) {
                                                                echo "<td style = 'background-color:#fad839'>";
                                                                echo "SAT";
                                                                echo "</td>";
                                                            }if ($dat_no_1 == 7) {
                                                                echo "<td style = 'background-color:#fad839'>";
                                                                echo "SUN";
                                                                echo "</td>";
                                                            }
                                                        }
                                                    } else {
                                                        $holiday_data = array(
                                                            'Holiday_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($holiday_data);
                                                        $q_hol = $this->db->get('tbl_holiday');
                                                        $count_hol = $q_hol->num_rows();
                                                        if ($count_hol == 1) {
                                                            echo "<td style = 'background-color:#0072bc;color:#fff'>";
                                                            echo "H";
                                                            echo "</td>";
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
                                                                        if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                                            echo "$Login_Time : $Logout_Time";
                                                                        } else {
                                                                            echo "$Login_Time : $Logout_Time";
                                                                        }
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td style = 'background-color:#00FFFF'>";
                                                                        echo "$Login_Time : $Logout_Time";
                                                                        echo "</td>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#d42020;color: #fff;'>";
                                                                echo "A";
                                                                echo "</td>";
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "<td style = 'background-color:#d42020;color:#fff'>";
                                                echo "-";
                                                echo "</td>";
                                            }
                                        }
                                        ?>
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
                                                } else if ($count_lop == 1) {
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>LOP</td>";
                                                } else if ($count_dislop == 1) {
                                                    echo "<td style = 'background-color:#BF00FF;color:#fff'>Disciplinary LOP</td>";
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

                                                                    if ($shift_name_weekend == "NIGHT -1" || $shift_name_weekend == "NIGHT -2") {
                                                                        echo "$Login_Time_weekend : $Logout_Time_weekend";
                                                                    } else {
                                                                        echo "$Login_Time_weekend : $Logout_Time_weekend";
                                                                    }
                                                                    echo "</td>";
                                                                } else {
                                                                    echo "<td style = 'background-color:#00a651'>";
                                                                    echo "$Login_Time_weekend : $Logout_Time_weekend";
                                                                    echo "</td>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($dat_no_1 == 6) {
                                                                echo "<td style = 'background-color:#fad839'>SAT</td>";
                                                            }if ($dat_no_1 == 7) {
                                                                echo "<td style = 'background-color:#fad839'>SUN</td>";
                                                            }
                                                        }
                                                    } else {
                                                        $holiday_data = array(
                                                            'Holiday_Date' => $dates_month_1,
                                                            'Status' => 1
                                                        );
                                                        $this->db->where($holiday_data);
                                                        $q_hol = $this->db->get('tbl_holiday');
                                                        $count_hol = $q_hol->num_rows();
                                                        if ($count_hol == 1) {
                                                            echo "<td style = 'background-color:#0072bc;color:#fff'>H</td>";
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
                                                                        if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                                            echo "$Login_Time : $Logout_Time";
                                                                        } else {
                                                                            echo "$Login_Time : $Logout_Time";
                                                                        }
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td style = 'background-color:#00FFFF'>";
                                                                        echo "$Login_Time : $Logout_Time";
                                                                        echo "</td>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#d42020;color:#fff'>A</td>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
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
                            <th rowspan="2" style="border:1px solid #000;">Employee Code</th>
                            <th rowspan="2" style="border:1px solid #000;">Employees</th>
                            <th rowspan="2" style="border:1px solid #000;">DOJ</th>
                            <?php
                            for ($i = 1; $i <= $num; $i++) {
                                $mktime = mktime(0, 0, 0, $month, $i, $year);
                                $date = date("d", $mktime);
                                $dates_month[$i] = $date;
                                $date_n = date("d-m-Y", $mktime);
                                ?>
                                <th style="border:1px solid #000;" colspan="6"><p style="transform: rotate(270deg);"><?php echo "'$date_n"; ?></p></th>
                        <?php
                    }
                    ?>
                    </tr>

                    <tr>
                        <?php
                        for ($si = 1; $si <= $num; $si++) {
                            ?>
                            <th style="border:1px solid #000;">Shift Time</th>
                            <th style="border:1px solid #000;">Login</th>
                            <th style="border:1px solid #000;">Logout</th>
                            <th style="border:1px solid #000;">Total Hours</th>
                            <th style="border:1px solid #000;">Late Hours</th>
                            <th style="border:1px solid #000;">Early Hours</th>
                            <?php
                        }
                        ?>
                    <th rowspan="1" style="border:1px solid #000;">Total Late Hours</th>
                    <!--<th rowspan="1" style="border:1px solid #000;">Total Early Hours</th>-->
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
                                $this->db->where('employee_number', $employee_no);
                                $q_code_download = $this->db->get('tbl_emp_code');
                                foreach ($q_code_download->Result() as $row_code_download) {
                                    $emp_code = $row_code_download->employee_code;
                                }
                                ?>
                                <tr>
                                    <td style="border:1px solid #000;"><?php echo $emp_code . $employee_no; ?></td>
                                    <td style="border:1px solid #000;"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                    <td style="border:1px solid #000;"><?php echo "'$emp_doj"; ?></td>
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
                                    $week_satnightfull_day = 0;
                                    $week_sunfull_day = 0;
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
                                    
                                    $total_early_Login_mintes = 0;
                                    $total_early_Login_hours = 0;
                                    $total_late_Login_mintes = 0;
                                    $total_late_Login_hours = 0;
                                    
                                    //$Total_Late1 = 0;
                                    $total_late_Login_mintes1 = 0;
                                    $total_late_Login_hours1 = 0;
                                    
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

                                        $data_shift_all = array(
                                            'Employee_Id' => $employee_no,
                                            'Date' => $dates_month_1,
                                            'Status' => 1
                                        );
                                        $this->db->where($data_shift_all);
                                        $q_shift_all = $this->db->get('tbl_shift_allocate');
                                        $count_shift_all = $q_shift_all->num_rows();
                                        if ($count_shift_all == 1) {
                                            foreach ($q_shift_all->result() as $row_shift_all) {
                                                $Shift_Id = $row_shift_all->Shift_Id;
                                            }
                                            $data_shift = array(
                                                'Shift_Id' => $Shift_Id,
                                                'Status' => 1
                                            );
                                            $this->db->where($data_shift);
                                            $q_shift = $this->db->get('tbl_shift_details');
                                            foreach ($q_shift->result() as $row_shift) {
                                                $Shift_Name = $row_shift->Shift_Name;
                                                $Shift_From1 = $row_shift->Shift_From;
                                                $Shift_From = date("H:i", strtotime($Shift_From1));
                                                $Shift_To1 = $row_shift->Shift_To;
                                                $Shift_To = date("H:i", strtotime($Shift_To1));
                                            }
                                            echo "<td style = 'background-color:#a95c73;color:#fff;border:1px solid #000;text-align:center'>" . $Shift_Name . "(" . $Shift_From . ":" . $Shift_To . ")" . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
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
                                            echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center' colspan='5'>COMP-OFF</td>";
                                        } else if ($count_lop == 1) {
                                            echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center' colspan='5'>LOP</td>";
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
                                                        if ($Logout_Time_weekend == "" || $Logout_Time_weekend == "00:00:00") {
                                                            $total_hours_weekend = "";
                                                        } else {
                                                            $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                        }
                                                       
                                                        $min_time_weekend = "04:30:00";

                                                        $shift_24_hour_format_weekend = date("H:i:s", strtotime("$Shift_From1"));
                                                        $to_time_weekend = strtotime("$Login_Date1_weekend $shift_24_hour_format_weekend");
                                                        $from_time_weekend = strtotime("$Login_Date1_weekend $Login_Time_weekend");
                                                        $diff_total_mins_weekend = round(abs($to_time_weekend - $from_time_weekend) / 60, 2) . " minute";
                                                        $diff_hours_weekend = floor($diff_total_mins_weekend / 60);
                                                        $diff_minutes_weekend = $diff_total_mins_weekend % 60;
                                                        // Testing only
                                                        $total_late_Login_mintes = $diff_minutes_weekend + $total_late_Login_mintes;
                                                        $total_late_Login_hours = $diff_hours_weekend + $total_late_Login_hours;                                    
                                                        $Late1 = $total_late_Login_hours + $total_late_Login_mintes;
                                                        $Total_Late1 = gmdate("H:i:s", $Late1);
                                                        /*$shift_grace_time1 = strtotime("+16 minutes", strtotime($Late1));                                        
                                                        $shift_grace_time = date('H:i:s', $shift_grace_time1);*/
                                                        // Testing only

                                                        if ($total_hours_weekend > $min_time_weekend) {
                                                            if ($shift_name_weekend == "NIGHT -1" || $shift_name_weekend == "NIGHT -2") {
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$Login_Time_weekend";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$Logout_Time_weekend";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$total_hours_weekend";
                                                                echo "</td>";
                                                                if ($Shift_Name != "") {
                                                                    if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time_weekend)) {
                                                                        echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                    if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time_weekend)) {
                                                                        echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                } else {
                                                                    echo "<td></td>";
                                                                    echo "<td></td>";
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$Login_Time_weekend";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$Logout_Time_weekend";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$total_hours_weekend";
                                                                echo "</td>";
                                                                if ($Shift_Name != "") {
                                                                    if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time_weekend)) {
                                                                        echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                    if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time_weekend)) {
                                                                        echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                } else {
                                                                    echo "<td></td>";
                                                                    echo "<td></td>";
                                                                }
                                                            }
                                                        } else {
                                                            echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                            echo "$Login_Time_weekend";
                                                            echo "</td>";
                                                            echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                            echo "$Logout_Time_weekend";
                                                            echo "</td>";
                                                            echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            echo "$total_hours_weekend";
                                                            echo "</td>";
                                                            if ($Shift_Name != "") {
                                                                if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time_weekend)) {
                                                                    echo "<td style = 'background-color:#FF4500;border:1px solid #000;text-align:center'>";
                                                                    echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                    echo "</td>";
                                                                } else {
                                                                    echo "<td></td>";
                                                                }
                                                                if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time_weekend)) {
                                                                    echo "<td style = 'background-color:#0919b7;border:1px solid #000;text-align:center'>";
                                                                    echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                    echo "</td>";
                                                                } else {
                                                                    echo "<td></td>";
                                                                }
                                                            } else {
                                                                echo "<td></td>";
                                                                echo "<td></td>";
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if ($dat_no_1 == 6) {
                                                        echo "<td style = 'background-color:#fad839;border:1px solid #000;text-align:center' colspan='5'>SAT</td>";
                                                    }if ($dat_no_1 == 7) {
                                                        echo "<td style = 'background-color:#fad839;border:1px solid #000;text-align:center' colspan='5'>SUN</td>";
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
                                                    echo "<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center' colspan='5'>H</td>";
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

                                                            if ($Logout_Time == "" || $Logout_Time == "00:00:00") {
                                                                $total_hours_present = "";
                                                            } else {
                                                                $total_hours_present = gmdate("H:i:s", $seconds);
                                                            }

                                                            $min_time = "04:30:00";
                                                            $shift_24_hour_format_present = date("H:i:s", strtotime("$Shift_From1"));
                                                            $to_time_present = strtotime("$Login_Date1 $shift_24_hour_format_present");
                                                            $from_time_present = strtotime("$Login_Date1 $Login_Time");
                                                            $diff_total_mins_present = round(abs($to_time_present - $from_time_present) / 60, 2) . " minute";
                                                            $diff_hours_present = floor($diff_total_mins_present / 60);
                                                            $diff_minutes_present = $diff_total_mins_present % 60;
                                                            // my code Start Total Early Login
                                                            $total_early_Login_mintes = $diff_minutes_present + $total_early_Login_mintes;
                                                            $total_early_Login_hours = $diff_hours_present + $total_early_Login_hours;
                                                            $Early = $total_early_Login_hours + $total_early_Login_mintes;
                                                            $Total_Early = gmdate("i:s", $Early);
                                                            // my code End
                                                            
                                                            if ($total_hours_present > $min_time) {
                                                                if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Login_Time";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Logout_Time";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$total_hours_present";
                                                                    echo "</td>";
                                                                    if ($Shift_Name != "") {
                                                                        if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_present H : $diff_minutes_present M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                        if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_present H : $diff_minutes_present M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td></td>";
                                                                        echo "<td></td>";
                                                                    }
                                                                } else {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Login_Time";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Logout_Time";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$total_hours_present";
                                                                    echo "</td>";
                                                                    if ($Shift_Name != "") {   // Main KALA NITHI Late Login details
                                                                        if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_present H : $diff_minutes_present M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }                                                                        
                                                                        // my code Total Late Login 
                                                                        $total_late_Login_mintes = $diff_minutes_present + $total_late_Login_mintes;
                                                                        $total_late_Login_hours = $diff_hours_present + $total_late_Login_hours;                                    
                                                                        $Late = $total_late_Login_hours + $total_late_Login_mintes;
                                                                        $Total_Late = gmdate("i:s", $Late);                                                                        
                                                                        // my code End 
                                                                        // Main RAJA SEKAR Early Login details
                                                                        if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_present H : $diff_minutes_present M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td></td>";
                                                                        echo "<td></td>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                                echo "$Login_Time";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                                echo "$Logout_Time";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                echo "$total_hours_present";
                                                                echo "</td>";
                                                                if ($Shift_Name != "") { 
                                                                    if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                        echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_present H : $diff_minutes_present M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                    if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                        echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_present H : $diff_minutes_present M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                } else {
                                                                    echo "<td></td>";
                                                                    echo "<td></td>";
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo "<td style = 'background-color:#d42020;color:#fff;border:1px solid #000;text-align:center' colspan='5'>A</td>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    echo "<td style = 'background-color:yellow;color:#000;border:1px solid #000;text-align:center'>";
                                    echo "$Total_Early";
                                    echo "</td>";
                                    /*echo "<td>$Total_Late</td>";                                    
                                    echo "<td>$Total_Early</td>";*/                                    
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        
                        
                        
                        // Manager Controll Start here
                        
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
                                    $this->db->where('employee_number', $employee_no);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->Result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }
                                    ?>
                                    <tr>
                                        <td style="border:1px solid #000;"><?php echo $emp_code . $employee_no; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                        <td style="border:1px solid #000;"><?php echo $emp_doj; ?></td>
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
                                        $week_sunfull_day = 0;
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

                                            $data_shift_all = array(
                                                'Employee_Id' => $employee_no,
                                                'Date' => $dates_month_1,
                                                'Status' => 1
                                            );
                                            $this->db->where($data_shift_all);
                                            $q_shift_all = $this->db->get('tbl_shift_allocate');
                                            $count_shift_all = $q_shift_all->num_rows();
                                            if ($count_shift_all == 1) {
                                                foreach ($q_shift_all->result() as $row_shift_all) {
                                                    $Shift_Id = $row_shift_all->Shift_Id;
                                                }
                                                $data_shift = array(
                                                    'Shift_Id' => $Shift_Id,
                                                    'Status' => 1
                                                );
                                                $this->db->where($data_shift);
                                                $q_shift = $this->db->get('tbl_shift_details');
                                                foreach ($q_shift->result() as $row_shift) {
                                                    $Shift_Name = $row_shift->Shift_Name;
                                                    $Shift_From1 = $row_shift->Shift_From;
                                                    $Shift_From = date("H:i", strtotime($Shift_From1));
                                                    $Shift_To1 = $row_shift->Shift_To;
                                                    $Shift_To = date("H:i", strtotime($Shift_To1));
                                                }
                                                echo "<td style = 'background-color:#a95c73;color:#fffborder:1px solid #000;text-align:center'>" . $Shift_Name . "(" . $Shift_From . ":" . $Shift_To . ")</td>";
                                            } else {
                                                echo "<td></td>";
                                            }

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
                                                echo "<td style = 'background-color:#58FAD0;color:#000;border:1px solid #000;text-align:center' colspan='5'>COMP-OFF</td>";
                                            } else if ($count_lop == 1) {
                                                echo "<td style = 'background-color:#BF00FF;color:#fff;border:1px solid #000;text-align:center' colspan='5'>LOP</td>";
                                            } else if ($count_dislop == 1) {
                                                echo "<td style = 'background-color:#BF00FF;color:#fff;border:1px solid #000;text-align:center' colspan='5'>Disciplinary LOP</td>";
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
                                                            if ($Logout_Time_weekend == "" || $Logout_Time_weekend == "00:00:00") {
                                                                $total_hours_weekend = "";
                                                            } else {
                                                                $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                            }
                                                            $min_time_weekend = "04:30:00";

                                                            $shift_24_hour_format_weekend = date("H:i:s", strtotime("$Shift_From1"));
                                                            $to_time_weekend = strtotime("$Login_Date1_weekend $shift_24_hour_format_weekend");
                                                            $from_time_weekend = strtotime("$Login_Date1_weekend $Login_Time_weekend");
                                                            $diff_total_mins_weekend = round(abs($to_time_weekend - $from_time_weekend) / 60, 2) . " minute";
                                                            $diff_hours_weekend = floor($diff_total_mins_weekend / 60);
                                                            $diff_minutes_weekend = $diff_total_mins_weekend % 60;

                                                            if ($total_hours_weekend > $min_time_weekend) {
                                                                if ($shift_name_weekend == "NIGHT -1" || $shift_name_weekend == "NIGHT -2") {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Login_Time_weekend";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Logout_Time_weekend";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$total_hours_weekend";
                                                                    echo "</td>";
                                                                    if ($Shift_From1 != "" || $Shift_From1 != "00:00:00") {
                                                                        if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                        if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td></td>";
                                                                        echo "<td></td>";
                                                                    }
                                                                } else {
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Login_Time_weekend";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$Logout_Time_weekend";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    echo "$total_hours_weekend";
                                                                    echo "</td>";
                                                                    if ($Shift_From1 != "" || $Shift_From1 != "00:00:00") {
                                                                        if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                        if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td></td>";
                                                                        echo "<td></td>";
                                                                    }
                                                                }
                                                            } else {
                                                                echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                                echo "$Login_Time_weekend";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                                echo "$Logout_Time_weekend";
                                                                echo "</td>";
                                                                echo "<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                                echo "$total_hours_weekend";
                                                                echo "</td>";
                                                                if ($Shift_From1 != "" || $Shift_From1 != "00:00:00") {
                                                                    if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time)) {
                                                                        echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                    if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time)) {
                                                                        echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                        echo "</td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                } else {
                                                                    echo "<td></td>";
                                                                    echo "<td></td>";
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if ($dat_no_1 == 6) {
                                                            echo "<td style = 'background-color:#fad839;border:1px solid #000;text-align:center' colspan='5'>SAT</td>";
                                                        }if ($dat_no_1 == 7) {
                                                            echo "<td style = 'background-color:#fad839;border:1px solid #000;text-align:center' colspan='5'>SUN</td>";
                                                        }
                                                    }
                                                } else {
                                                    $holiday_data = array(
                                                        'Holiday_Date' => $dates_month_1,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($holiday_data);
                                                    $q_hol = $this->db->get('tbl_holiday');
                                                    $count_hol = $q_hol->num_rows();
                                                    if ($count_hol == 1) {
                                                        echo "<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center' colspan='5'>H</td>";
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

                                                                if ($Logout_Time == "" || $Logout_Time == "00:00:00") {
                                                                    $total_hours_present = "";
                                                                } else {
                                                                    $total_hours_present = gmdate("H:i:s", $seconds);
                                                                }
                                                                $min_time = "04:30:00";
                                                                $shift_24_hour_format_present = date("H:i:s", strtotime("$Shift_From1"));
                                                                $to_time_present = strtotime("$Login_Date1 $shift_24_hour_format_present");
                                                                $from_time_present = strtotime("$Login_Date1 $Login_Time");
                                                                $diff_total_mins_present = round(abs($to_time_present - $from_time_present) / 60, 2) . " minute";
                                                                $diff_hours_present = floor($diff_total_mins_present / 60);
                                                                $diff_minutes_present = $diff_total_mins_present % 60;
                                                                if ($total_hours_present > $min_time) {
                                                                    if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$Login_Time";
                                                                        echo "</td>";
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$Logout_Time";
                                                                        echo "</td>";
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$total_hours_present";
                                                                        echo "</td>";
                                                                        if ($Shift_From1 != "" || $Shift_From1 != "00:00:00") {
                                                                            if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                                echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                                echo "$diff_hours_present H : $diff_minutes_present M";
                                                                                echo "</td>";
                                                                            } else {
                                                                                echo "<td></td>";
                                                                            }
                                                                            if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                                echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                                echo "$diff_hours_present H : $diff_minutes_present M";
                                                                                echo "</td>";
                                                                            } else {
                                                                                echo "<td></td>";
                                                                            }
                                                                        } else {
                                                                            echo "<td></td>";
                                                                            echo "<td></td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$Login_Time";
                                                                        echo "</td>";
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$Logout_Time";
                                                                        echo "</td>";
                                                                        echo "<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        echo "$total_hours_present";
                                                                        echo "</td>";
                                                                        if ($Shift_From1 != "" || $Shift_From1 != "00:00:00") {
                                                                            if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                                echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                                echo "$diff_hours_present H : $diff_minutes_present M";
                                                                                echo "</td>";
                                                                            } else {
                                                                                echo "<td></td>";
                                                                            }
                                                                            if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                                echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                                echo "$diff_hours_present H : $diff_minutes_present M";
                                                                                echo "</td>";
                                                                            } else {
                                                                                echo "<td></td>";
                                                                            }
                                                                        } else {
                                                                            echo "<td></td>";
                                                                            echo "<td></td>";
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo "<td style = 'background-color:#00FFFF;border:1px solid #000;text-align:center'>";
                                                                    echo "$Login_Time";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00FFFF;border:1px solid #000;text-align:center'>";
                                                                    echo "$Logout_Time";
                                                                    echo "</td>";
                                                                    echo "<td style = 'background-color:#00FFFF;border:1px solid #000;text-align:center'>";
                                                                    echo "$total_hours_present";
                                                                    echo "</td>";
                                                                    if ($Shift_From1 != "" || $Shift_From1 != "00:00:00") {
                                                                        if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_present H : $diff_minutes_present M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                        if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                            echo "<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                            echo "$diff_hours_present H : $diff_minutes_present M";
                                                                            echo "</td>";
                                                                        } else {
                                                                            echo "<td></td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td></td>";
                                                                        echo "<td></td>";
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo "<td style = 'background-color:#d42020;color:#fff;border:1px solid #000;text-align:center' colspan='5'>A</td>";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
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