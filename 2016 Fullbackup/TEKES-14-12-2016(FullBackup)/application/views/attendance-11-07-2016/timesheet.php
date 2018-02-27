<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');

$data = array(
    'Status' => 1
);
$this->db->where($data);
$q = $this->db->get('tbl_employee');
?>



<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Attendance Timesheet</h2>
                        </div>

                        <div class="panel-options">

                            <div class="row">
<!--                                <div class="col-md-5">
                                    <a data-toggle='modal' href='#export_attendance' style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                        Export Attendance
                                        <i class="entypo-upload"></i>
                                    </a>
                                </div>-->
                                <div class="col-md-6">
                                    <?php
                                    define('DOB_YEAR_START', 2000);
                                    $current_year = date('Y');
                                    ?>
                                    <select id="year_list" name="year_list" class="round" onchange="$('#change_timesheet').submit();">
                                        <?php
                                        if ($this->uri->segment(4) != "") {
                                            $cur_year = $this->uri->segment(4);
                                            ?>
                                            <option value="<?php echo $cur_year ?>" selected="selected"><?php echo $cur_year; ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $current_year; ?>" selected="selected"><?php echo $current_year; ?></option>
                                            <?php
                                        }
                                        for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                            echo "<option value='{$count}'>{$count}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="round" id="month_list" name="month_list" onchange="location = this.options[this.selectedIndex].value + '/' + $('#year_list').val();">
                                        <?php
                                        if ($this->uri->segment(3) != "") {
                                            $cur_month = $this->uri->segment(3);
                                            $cur_month_name = date("F", mktime(0, 0, 0, $cur_month, 10));
                                            ?>
                                            <option value="<?php echo $cur_month ?>" selected="selected"><?php echo $cur_month_name; ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo date('m') ?>" selected="selected"><?php echo date('M') ?></option>
                                            <?php
                                        }
                                        for ($m = 1; $m <= 12; $m++) {
                                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                            ?>
                                            <option value="<?php echo site_url('Attendance/MonthTimesheet/' . $m); ?>"><?php echo $month; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                        $cur_month = $this->uri->segment(3);
                        $cur_year = $this->uri->segment(4);
                        $cur_month_name = date("F", mktime(0, 0, 0, $cur_month, 10));
                    } else {
                        $cur_month = date('M');
                        $cur_month_name = date('M');
                        $cur_year = date('Y');
                    }
                    ?>
                    <!-- Attendance Table Format Start Here -->

                    <table class="table table-bordered" id="timesheet_table" class="timesheet_table">
                        <div class="panel-body">
                            <div class="icon-el col-md-2 col-sm-2"><a href="#"><i class="btn btn-blue">H</i> Holiday</a></div>
                            <div class="icon-el col-md-2 col-sm-2"><a href="#"><i class="btn btn-red">A</i> Absent</a></div>
                            <div class="icon-el col-md-2 col-sm-2"><a href="#"><i class="btn btn-warning">WO</i> Weekly Off</a></div>
                            <div class="icon-el col-md-2 col-sm-2"><a href="#"><i class="btn btn-success">P/NP</i>Present</a></div>
                            <div class="icon-el col-md-2 col-sm-2"><a href="#"><i class="btn btn-green">HP</i> Half Day Present</a></div>

                        </div>
                        <h3 class="col-sm-8" id="curr_div">Daily Attendance for the Month of <?php echo $cur_month_name . " " . $cur_year ?></h3>
                        <thead> 
                            <tr>
                                <th>Employee Code</th>
                                <th>Employees</th>
                                <?php
                                if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                                    $month = $this->uri->segment(3);
                                    $year = $this->uri->segment(4);
                                } else {
                                    $month = date('m');
                                    $year = date('Y');
                                }

                                $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                $dates_month = array();
                                for ($i = 1; $i <= $num; $i++) {
                                    $mktime = mktime(0, 0, 0, $month, $i, $year);
                                    $date = date("d", $mktime);
                                    $dates_month[$i] = $date;

                                    $date_n = date("Y-m-d", $mktime);
                                    $dat_no = date('N', strtotime($date_n));
                                    echo "<th>";
                                    if ($dat_no == 1) {
                                        echo "Mon";
                                    }
                                    if ($dat_no == 2) {
                                        echo "Tue";
                                    }
                                    if ($dat_no == 3) {
                                        echo "Wed";
                                    }
                                    if ($dat_no == 4) {
                                        echo "Thu";
                                    }
                                    if ($dat_no == 5) {
                                        echo "Fri";
                                    }
                                    if ($dat_no == 6) {
                                        echo "Sat";
                                    }
                                    if ($dat_no == 7) {
                                        echo "Sun";
                                    }
                                    echo "<br>" . $dates_month[$i];
                                    echo "</th>";
                                }
                                ?>
                                <th>No. Days Present (P)</th>
                                <th>No. of Day Leave (L)</th>
                                <th>No. of Days Half day Present (HP)</th>
                                <th>Total Week Off ( Sat/ Sun)(WO)</th>
                                <th>Total Week off worked (WP)</th>
                                <th>Total Holidays (H)</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($q->result() as $row) {
                                $emp_firstname = $row->Emp_FirstName;
                                $emp_middlename = $row->Emp_MiddleName;
                                $emp_lastname = $row->Emp_LastName;
                                $emp_no = $row->Emp_Number;
                                $this->db->where('employee_number', $emp_no);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->Result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $emp_code . $emp_no; ?></td>
                                    <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                    <?php
                                    $p = 0;
                                    $a = 0;
                                    $wp = 0;
                                    $wo = 0;
                                    $h = 0;
                                    $hp = 0;

                                    if ($this->uri->segment(3) != "" AND $this->uri->segment(4) != "") {
                                        $month_1 = $this->uri->segment(3);
                                        $year_1 = $this->uri->segment(4);
                                    } else {
                                        $month_1 = date('m');
                                        $year_1 = date('Y');
                                    }

                                    $num_1 = cal_days_in_month(CAL_GREGORIAN, $month_1, $year_1);
                                    $dates_month_1 = array();
                                    for ($i_1 = 1; $i_1 <= $num_1; $i_1++) {
                                        $mktime_1 = mktime(0, 0, 0, $month_1, $i_1, $year_1);
                                        $date_1 = date("Y-m-d", $mktime_1);
                                        $dates_month_1[$i_1] = $date_1;
                                        $dat_no_1 = date('N', strtotime($date_1));
                                        if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                                            $data_in = array(
                                                'Emp_Id' => $emp_no,
                                                'Login_Date' => $dates_month_1[$i_1],
                                                'Status' => 1
                                            );
                                            $this->db->where($data_in);
                                            $q_in = $this->db->get('tbl_attendance');
                                            $count_in = $q_in->num_rows();
                                            if ($count_in == 1) {
                                                echo "<td style = 'background-color:#00a651'>WP</td>";
                                                $wp = $wp + 1;
                                            } else {
                                                echo "<td style = 'background-color:#fad839'>WO</td>";
                                                $wo = $wo + 1;
                                            }
                                        } else {
                                            $holiday_data = array(
                                                'Holiday_Date' => $dates_month_1[$i_1],
                                                'Status' => 1
                                            );
                                            $this->db->where($holiday_data);
                                            $q_hol = $this->db->get('tbl_holiday');
                                            $count_hol = $q_hol->num_rows();
                                            if ($count_hol == 1) {
                                                echo "<td style = 'background-color:#0072bc;color:#fff'>H</td>";
                                                $h = $h + 1;
                                            } else {
                                                $data_in = array(
                                                    'Emp_Id' => $emp_no,
                                                    'Login_Date' => $dates_month_1[$i_1],
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
                                                        $total_hours = gmdate("H:i:s", $seconds);
                                                        $min_time = "04:30:00";
                                                        if ($total_hours > $min_time) {
                                                            echo "<td style = 'background-color:#00a651;color:#fff'>";
                                                            if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                                echo "NP";
                                                            } else {
                                                                echo "P";
                                                            }
                                                            echo "</td>";
                                                            $p = $p + 1;
                                                        } else {
                                                            echo "<td style = 'background-color:#00a651'>HP</td>";
                                                            $hp = $hp + 1;
                                                        }
                                                    }
                                                } else {
                                                    echo "<td style = 'background-color:#d42020;color:#fff'>A</td>";
                                                    $a = $a + 1;
                                                }
                                            }
                                        }

                                        // echo "<td><input type = 'hidden' id = 'date' name = 'date' value = '$dates_month[$i]'></td>";
                                    }
                                    ?>
                                    <td><?php echo $p; ?></td>
                                    <td><?php echo $a; ?></td>
                                    <td><?php echo $hp; ?></td>  
                                    <td><?php echo $wo; ?></td>
                                    <td><?php echo $wp; ?></td>
                                    <td><?php echo $h; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Attendance Table Format End Here -->
                </div>
            </div>
        </section>


        <!-- Export Attendance Start Here -->

        <div class="modal fade" id="export_attendance" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content" id="import_div">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Export Attendance Data</h3>
                    </div>
                    <!--<form role="form" id="exportattendance_form" name="exportattendance_form" method="post" class="validate" action="<?php echo site_url('Attendance/ExportTimesheet') ?>">-->
                    <form role="form" id="exportattendance_form" name="exportattendance_form" method="post" class="validate" action="<?php echo site_url('Attendance/MonthTimesheet') ?>">

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
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#timesheet_table");

                tableContainer.dataTable({
                    //  "scrollX": true,
                    "scrollY": 400,
                    "scrollX": true,
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
