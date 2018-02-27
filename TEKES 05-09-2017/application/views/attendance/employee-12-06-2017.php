<?php
$emp_no = $this->session->userdata('username');

$data_select = array(
    'Emp_Id' => $emp_no,
    'Status' => 1
);
$this->db->order_by('Login_Date', 'desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_attendance');
?>
<script>
    function exit_attendance(attendance_id) {
        var formdata = {
            attendance_id: attendance_id
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Attendance/Exitattendance') ?>",
            data: formdata,
            cache: false,
            success: function (msg) {
                if (msg == "success") {
                    window.location.reload();
                }
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
                            <h2>Attendance</h2>
                        </div>
                    </div>
                    <div class="row">
                        <br /><br />
                        <div class="col-md-1"></div>
                        <form role="form" id="month_form" name="month_form" method="post" class="validate">
                            <div class="col-md-8">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    define('DOB_YEAR_START', 2000);
                                    ?>
                                    <select id="year_list" name="year_list" class="round">
                                        <?php
                                        $present_year = date('Y');
                                        if ($this->uri->segment(3) != "") {
                                            $current_year = $this->uri->segment(4);
                                            for ($count = $present_year; $count >= DOB_YEAR_START; $count--) {
                                                ?>
                                                <option value='<?php echo $count; ?>' <?php
                                                if ($current_year == $count) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $count; ?></option>
                                                        <?php
                                                    }
                                                } else {

                                                    for ($count = $present_year; $count >= DOB_YEAR_START; $count--) {
                                                        echo "<option value='{$count}'>{$count}</option>";
                                                    }
                                                }
                                                ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="round" id="month_list" name="month_list" onchange="location = this.options[this.selectedIndex].value + '/' + $('#year_list').val();">
                                        <?php
                                        if ($this->uri->segment(3) != "") {
                                            for ($m = 1; $m <= 12; $m++) {
                                                $current_month = $this->uri->segment(3);
                                                $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                ?>
                                                <option value="<?php echo site_url('Attendance/employee/' . $m); ?>" <?php
                                                if ($current_month == $m) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $month; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    for ($m = 1; $m <= 12; $m++) {
                                                        $current_month = date('m');
                                                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                        ?>
                                                <option value="<?php echo site_url('Attendance/employee/' . $m); ?>" <?php
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
                            </div>
                        </form>
                        <br /><br /> <br /><br />
                    </div>
                    <!-- Attendance Table Format Start Here -->

                    <table class="table table-bordered datatable" id="attendance_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Shift Type</th>
                                <th>Shift</th>
                                <th>Login Date</th>
                                <th>Login Time</th>
                                <th>Logout Date</th>
                                <th>Logout Time</th>
                                <th>Total Hours</th>
                                <th>Early Login</th>                                
                                <th>Late Login</th>                                                                
                                <!--<th>Total Late Login</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;                            
                            $total_early_Login_mintes ="00:00:00";
                            $total_early_Login_hours ="00:00:00";
                            $total_late_Login_mintes ="00:00:00";
                            $total_late_Login_hours ="00:00:00";
                            $Monthly_total_working_hours = 0;
                            foreach ($q->Result() as $row) {
                                $A_Id = $row->A_Id;
                                $Login_Date1 = $row->Login_Date;
                                $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                $Login_Time = $row->Login_Time;

                                $Logout_Date1 = $row->Logout_Date;
                                if ($Logout_Date1 == "0000-00-00") {
                                    $Logout_Date = "";
                                    $Logout_Time = "";
                                } else {
                                    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                    $Logout_Time = $row->Logout_Time;
                                }
                                $login_year = date('Y', strtotime($Login_Date1));
                                $login_month = date('m', strtotime($Login_Date1));
                                if ($this->uri->segment(3) != "") {
                                    $selected_month = $this->uri->segment(3);
                                    $selected_year = $this->uri->segment(4);
                                } else {
                                    $selected_month = date('m');
                                    $selected_year = date('Y');
                                }
                                if ($login_year == $selected_year && $login_month == $selected_month) {
                                    $shift_name = $row->Shift_Name;
                                    $h1 = strtotime($Login_Time);
                                    $h2 = strtotime($Logout_Time);
                                    $seconds = $h2 - $h1;
                                    $total_hours = gmdate("H:i:s", $seconds);                                   
                                    
                                    $get_shift_data = array(
                                        'Employee_Id' => $emp_no,
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
                                    //$count =0;
                                    if ($count_shift_all > 0) {
                                        if ($shift_grace_time < $Login_Time) {
                                            echo "style='background-color:lightblue;'";
                                        } if ($shift_grace_time > $Login_Time) {
                                            echo "style='background-color:#fff;'";
                                            //$count=$count+1;
                                        }
                                    }
                                    ?>>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $shift_name; ?></td>
                                        <td>
                                            <?php
                                            if ($count_shift_all > 0) {
                                                echo $Shift_Name . " [ " . $Shift_From . " " . $Shift_To . " ] ";
                                            }
                                            ?>
                                        </td> 
                                        <td><?php echo $Login_Date; ?></td>
                                        <td><?php echo $Login_Time; ?></td>
                                        <td>
                                            <?php
                                            if ($Logout_Date1 != "0000-00-00") {
                                                echo $Logout_Date;
                                            } else {
                                                $login_date_time = $Login_Date1 . $Login_Time;
                                                $twelehour = date("Y-m-d H:i:s", strtotime($login_date_time . " +14 hours"));

                                                if (date("Y-m-d H:i:s") < $twelehour) {
                                                    ?>
                                                    <a class="btn btn-danger btn-sm btn-icon icon-left" onclick="exit_attendance(<?php echo $A_Id; ?>)">
                                                        <i class="entypo-logout"></i>
                                                        Exit
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $Logout_Time; ?></td>                                        
                                        <td>
                                            <?php
                                            if ($Logout_Date1 != "0000-00-00") {
                                                echo $total_hours;
                                            }
                                            $Monthly_total_working_hours = $Monthly_total_working_hours + $total_hours;                                             
                                            ?>
                                        </td>
                                        <td>
                                            <?php // Early Login Details
                                            if ($count_shift_all != "") {
                                                $shift_24_hour_format = date("H:i:s", strtotime("$Shift_From1"));
                                                $to_time = strtotime("$Login_Date1 $shift_24_hour_format");
                                                $from_time = strtotime("$Login_Date1 $Login_Time");
                                                if (strtotime($shift_24_hour_format) > strtotime($Login_Time)) {
                                                    $before_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                    $before_hours = floor($before_total_mins / 60);                                                    
                                                    $before_minutes = $before_total_mins % 60;                                                                                                     
                                                    echo "<span style='color:#006400;'>$before_hours H : $before_minutes M </span>";                                                                                                                                                            
                                                }
                                            }
                                            ?>
                                        </td>                                                                                                                       
                                        <td>
                                            <?php // Late Login Details Start
                                            $Latelogin_count = 0;
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
                                        
                                            <?php // Total Late Login Details Start here my code
                                            $Latelogin_count = 0;
                                            $totallateCount = 0;                                                                           
                                            if ($count_shift_all != "") {
                                                if (strtotime($shift_24_hour_format) < strtotime($Login_Time)) {
                                                    $late_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                    $late_hours = floor($late_total_mins / 60);
                                                    $late_minutes = $late_total_mins % 60;                                                     
                                                    //echo "<span style='color:red'>$late_hours H : $late_minutes M</span>";                                                    
                                                   if($late_minutes > 15 || $late_hours > 0)
                                                    {
                                                       $Latelogin_count = $Latelogin_count + 1; 
                                                       $totallateCount = $totallateCount + $Latelogin_count;                                                      
                                                    } 
                                                    //echo "$Latelogin_count";
                                                }
                                            } 
                                            ?>                                        
                                        
                                        
                                            <?php // Total_Early_Login Details
                                            if ($count_shift_all != "") {                                                
                                                $shift_24_hour_format = date("H:i:s", strtotime("$Shift_From1"));
                                                $to_time = strtotime("$Login_Date1 $shift_24_hour_format");
                                                $from_time = strtotime("$Login_Date1 $Login_Time");
                                                if (strtotime($shift_24_hour_format) > strtotime($Login_Time)) {
                                                    $before_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                    $before_hours = floor($before_total_mins / 60);                                                    
                                                    $before_minutes = $before_total_mins % 60;
                                                    $before_second = date("s", strtotime($shift_24_hour_format));                                                   
                                                    $total_early_Login_mintes = $before_minutes + $total_early_Login_mintes;
                                                    $total_early_Login_hours = $before_hours + $total_early_Login_hours;                                                  
                                                }
                                            }                                          
                                            ?>                                        
                                            <?php // Total Late Login Details
                                            if ($count_shift_all != "") {
                                                if (strtotime($shift_24_hour_format) < strtotime($Login_Time)) {
                                                    $late_total_mins = round(abs($to_time - $from_time) / 60, 2) . " minute";
                                                    $late_hours = floor($late_total_mins / 60);
                                                    $late_minutes = $late_total_mins % 60;                                                    
                                                    $late_second = 0;                                                  
                                                    $total_late_Login_mintes = $late_minutes + $total_late_Login_mintes;
                                                    $total_late_Login_hours = $late_hours + $total_late_Login_hours;
                                                }
                                            }
                                            ?>                                    
                                    </tr>                                    
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                        <tbody>
                            <tr>
                                <th colspan="8">
                                    Total Hours 
                                </th>
                                <?php
                                // Monthly Total Hours Working Office
                                $Monthly_total_working = gmdate('H:i:s',$Monthly_total_working_hours);                               
                                
                                // Total Early Login Details Start code
                                $totalearly_hours = $total_early_Login_hours * 3600;
                                $totalearly_minutes = $total_early_Login_mintes * 60; 
                                $totalearly_Login = $totalearly_hours + $totalearly_minutes;  
                                $Monthly_totalearly = gmdate('H:i:s', $totalearly_Login);
                                
                               // Total Late Login Details Start code
                                $totalhours = $total_late_Login_hours * 3600;
                                $totalminutes = $total_late_Login_mintes * 60; 
                                $totallate_Login = $totalhours + $totalminutes;
                                $Monthly_totalLate = gmdate('H:i:s', $totallate_Login);
                                ?> 
                                
                                <td><?php echo "<span style='color:blue'>$Monthly_totalearly</span>";?> </td>
                                <td><?php echo "<span style='color:blue'>$Monthly_totalLate</span>";?> </td>                                
                                <!--<td><?php //echo "<a href='#' style='color:blue'>$totallateCount</a>";?> </td>-->
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Attendance Table Format End Here -->
                </div>
            </div>
        </section>


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
                tableContainer = $("#attendance_table");

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