<?php
$emp_no = $this->session->userdata('username');
$employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);

$data_select = array(
    'Emp_Id' => $emp_no,
    'Status' => 1
);
$this->db->order_by('Login_Date', 'desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_attendance');
// Dashboard Query Start here
// IPR Total Employee Open Count Start here
$sql = "SELECT COUNT(distinct tbl_effeciency.Employee_Id)as No_Of_Employee from tbl_effeciency where Month='6' and Year='2017'";
$query = $this->db->query($sql);
$array = $query->row_array();
$result = $query->result();
$results = $result[0];
$Ipr_open_total_employee_effiency = $results->No_Of_Employee;
// IPR Total Employee Open Count End Here
// IPR Total Employee Open Count Start here
$sql2 = "SELECT count(tbl_iprreport.Employee_Id) as No_Of_Employee FROM `tbl_iprreport` WHERE 
IPR_Status in (3) and tbl_iprreport.Month=6 and tbl_iprreport.Year=2017";
$query2 = $this->db->query($sql2);
$array2 = $query2->row_array();
$result2 = $query2->result();
$results2 = $result2[0];
$Ipr_total_employee = $results2->No_Of_Employee;

// IPR Total Manager Count Start here
$sql3 = "SELECT count(tbl_iprreport.Employee_Id) as No_Of_Employee FROM `tbl_iprreport` WHERE IPR_Status 
in (2) and tbl_iprreport.Month='6' and tbl_iprreport.Year='2017'";
$query3 = $this->db->query($sql3);
$array3 = $query3->row_array();
$result3 = $query3->result();
$results3 = $result3[0];
$Ipr_Manager_total_employee = $results3->No_Of_Employee;
// IPR Total Manager Count End here
// IPR Total HR Count Start here
$sql4 = "SELECT count(tbl_iprreport.Employee_Id) as No_Of_Employee FROM `tbl_iprreport` WHERE IPR_Status 
in (4) and tbl_iprreport.Month='6' and tbl_iprreport.Year='2017'";
$query4 = $this->db->query($sql4);
$array4 = $query4->row_array();
$result4 = $query4->result();
$results4 = $result4[0];
$Ipr_Hr_total_employee = $results4->No_Of_Employee;
// IPR Total HR Count End here


$sql5 = "SELECT count(tbl_iprreport.Employee_Id) as No_Of_Employee FROM `tbl_iprreport` WHERE tbl_iprreport.Month='6' and tbl_iprreport.Year='2017' ";
$query5 = $this->db->query($sql5);
$array5 = $query5->row_array();
$result5 = $query5->result();
$results5 = $result5[0];
$Ipr_Open_total_employees = $results5->No_Of_Employee;
$total_Ipr_Open = $Ipr_open_total_employee_effiency - $Ipr_Open_total_employees;

//echo "$Ipr_open_total_employee - $Ipr_Manager_total_employee - $Ipr_Hr_total_employee"; die();
?>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>IPR Dasboard</h2>
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
                                                <option value="<?php echo site_url('Ipr1/iprdashboard/' . $m); ?>" <?php
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
                                                <option value="<?php echo site_url('Ipr1/iprdashboard/' . $m); ?>" <?php
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
                        <br /><br /> <br />
                    </div>

                </div>

                <!-- IPR Dashboard Count Start here-->
                <div class="row">
                    <div class="col-sm-1">                        
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="tile-stats tile-aqua">
                            <h3>IPR Open Employees</h3>
                            <div class="icon"><i class="entypo-users"></i></div>
                            <a href="javascript:;" onclick="jQuery('#modal-1').modal('show');">
                                <div style="text-align:center;" class="num" data-start="0" data-end="<?php echo "$total_Ipr_Open"; ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="tile-stats tile-blue">
                            <h3>IPR With Managers</h3>
                            <div class="icon"><i class="entypo-chart-bar"></i></div>
                            <a href="javascript:;" onclick="jQuery('#modal-2').modal('show');">
                                <div style="text-align:center;" class="num" data-start="0" data-end="<?php echo "$Ipr_Manager_total_employee"; ?>" data-postfix="" data-duration="1500" data-delay="600">0</div>                            
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="tile-stats tile-purple">
                            <h3>IPR With Employees</h3>
                            <div class="icon"><i class="entypo-user"></i></div>
                            <a href="javascript:;" onclick="jQuery('#modal-3').modal('show');">
                                <div style="text-align:center;" class="num" data-start="0" data-end="<?php echo "$Ipr_total_employee"; ?>" data-postfix="" data-duration="1500" data-delay="1200">0</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="tile-stats tile-green">
                            <h3>IPR With Human Resource</h3>
                            <div class="icon"><i class="entypo-user"></i></div>
                            <a href="javascript:;" onclick="jQuery('#modal-4').modal('show');"> 
                                <div style="text-align:center;" class="num" data-start="0" data-end="<?php echo "$Ipr_Hr_total_employee"; ?>"  data-postfix="" data-duration="1500" data-delay="1200">0</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6" style="display:none;">                        
                        <div class="tile-stats tile-brown">
                            <h3>IPR Completed Employees</h3>
                            <div class="icon"><i class="entypo-chart-bar"></i></div>
                            <div style="text-align:center;" class="num" data-start="0" data-end="75" data-postfix="" data-duration="1500" data-delay="1800">0</div>
                        </div>
                    </div>

                </div><br />
                <!-- IPR Dashboard Count End here-->

            </div>
        </section>

        <!-- IPR Total Employee Count Start here-->
        <div class="modal fade" id="modal-11">
            <div class="modal-dialog" style="width:32%;">
                <div class="modal-content">            
                    <div class="modal-body">
                        <table class="table table-bordered datatable">
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>
                            <th>Reporting Person</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DRN/0017</td>
                                    <td>Shashikala R</td>
                                    <td>Jegadeesh Jayanthilal</td>
                                </tr>
                                <tr>
                                    <td>DRN/0104</td>
                                    <td>Shaik Javeed</td>
                                    <td>Jegadeesh Jayanthilal</td>
                                </tr>
                                <tr>
                                    <td>DRN/0121</td>
                                    <td>Kavitha K</td>
                                    <td>Jegadeesh Jayanthilal</td>
                                </tr>
                                <tr>
                                    <td>DRN/0136</td>
                                    <td>Rajith Kumar</td>
                                    <td>Premkumar M</td>
                                </tr>                        
                            </tbody>
                        </table>
                    </div>

                    <div class="footer">
                        <button style="margin:-3% 0 1% 81%;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- IPR Total Employee Count End here-->

        <div class="modal fade custom-width" id="modal-1">
            <div class="modal-dialog" style="width:33%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IPR Total Employees</h4>
                    </div>

                    <div style="height:400px; width: 100%; overflow-y:scroll; ">
                        <table class="table table-bordered responsive">                    
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>
                            <th>Reporting Person</th>
                            </thead>
                            <tbody> 
                                <?php
// Total IPR Employee Efficiency Select Query 
                                $efficiency_query = $this->db->query("SELECT  DISTINCT Year,Month,Employee_Id,Reporting_To FROM `tbl_effeciency` WHERE tbl_effeciency.Employee_Id NOT IN (SELECT DISTINCT tbl_iprreport.Employee_Id FROM tbl_iprreport WHERE tbl_iprreport.Month='6' AND Year='2017') AND tbl_effeciency. Month='6' AND Year='2017'");
                                foreach ($efficiency_query->result() as $row_totaleff_emp) {
                                    $eff_year = $row_totaleff_emp->Year;
                                    $eff_month1 = $row_totaleff_emp->Month;
                                    $eff_month = date("d-m-Y", strtotime($eff_month1));
                                    $eff_employee_id = $row_totaleff_emp->Employee_Id;
                                    $eff_employee_reporting_person = $row_totaleff_emp->Reporting_To;

                                    // Employee Name get the table
                                    $this->db->where('Emp_Number', $eff_employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                        $Emp_Doj = $row_employee->Emp_Doj;
                                        $doj = date("d-m-Y", strtotime($Emp_Doj));
                                    }
                                    // Reporting Person Name Start here
                                    $this->db->where('Employee_Id', $employee_id);
                                    $this->db->limit(1);
                                    $emp_q_career = $this->db->get('tbl_employee_career');
                                    foreach ($emp_q_career->result() as $emp_row_career) {
                                        $emp_designation_id = $emp_row_career->Designation_Id;
                                        $emp_report_to_id = $emp_row_career->Reporting_To;

                                        $this->db->where('Emp_Number', $emp_report_to_id);
                                        $q_emp = $this->db->get('tbl_employee');
                                        foreach ($q_emp->result() as $row_emp) {
                                            $emp_reporting_name = $row_emp->Emp_FirstName;
                                        }
                                    }
                                    // Reporting Person Name End here
                                    ?>
                                    <tr>
                                        <td><?php echo "DRN/$eff_employee_id"; ?></td>
                                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>                                                                
                                        <td><?php echo "$eff_employee_reporting_person"; ?></td>                                                  
                                    </tr>                        
                                </tbody>                    
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
                    </div>
                </div>
            </div>
        </div>
        <!-- Efficiency Calculation End here-->

        <div class="modal fade custom-width" id="modal-1">
            <div class="modal-dialog" style="width:33%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IPR With Employees</h4>
                    </div>

                    <div style="height:400px; width: 100%; overflow-y:scroll; ">
                        <table class="table table-bordered responsive">                    
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>
                            <th>Reporting Person</th>
                            </thead>
                            <tbody> 
                                <?php
// Total IPR Employee Efficiency Select Query 
                                $efficiency_query = $this->db->query("SELECT  DISTINCT Year,Month,Employee_Id,Reporting_To FROM `tbl_effeciency` WHERE tbl_effeciency.Employee_Id NOT IN (SELECT DISTINCT tbl_iprreport.Employee_Id FROM tbl_iprreport WHERE tbl_iprreport.Month='6' AND Year='2017') AND tbl_effeciency. Month='6' AND Year='2017'");
                                foreach ($efficiency_query->result() as $row_totaleff_emp) {
                                    $eff_year = $row_totaleff_emp->Year;
                                    $eff_month1 = $row_totaleff_emp->Month;
                                    $eff_month = date("d-m-Y", strtotime($eff_month1));
                                    $eff_employee_id = $row_totaleff_emp->Employee_Id;
                                    $eff_employee_reporting_person = $row_totaleff_emp->Reporting_To;

                                    // Employee Name get the table
                                    $this->db->where('Emp_Number', $eff_employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                        $Emp_Doj = $row_employee->Emp_Doj;
                                        $doj = date("d-m-Y", strtotime($Emp_Doj));
                                    }
                                    // Reporting Person Name Start here
                                    $this->db->where('Employee_Id', $employee_id);
                                    $this->db->limit(1);
                                    $emp_q_career = $this->db->get('tbl_employee_career');
                                    foreach ($emp_q_career->result() as $emp_row_career) {
                                        $emp_designation_id = $emp_row_career->Designation_Id;
                                        $emp_report_to_id = $emp_row_career->Reporting_To;

                                        $this->db->where('Emp_Number', $emp_report_to_id);
                                        $q_emp = $this->db->get('tbl_employee');
                                        foreach ($q_emp->result() as $row_emp) {
                                            $emp_reporting_name = $row_emp->Emp_FirstName;
                                        }
                                    }
                                    // Reporting Person Name End here
                                    ?>
                                    <tr>
                                        <td><?php echo "DRN/$eff_employee_id"; ?></td>
                                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>                                                                
                                        <td><?php echo "$emp_reporting_name"; ?></td>                                                  
                                    </tr>                        
                                </tbody>                    
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
                    </div>
                </div>
            </div>
        </div>


        <!--IPR With Managers-->
        <div class="modal fade custom-width" id="modal-2">
            <div class="modal-dialog" style="width:33%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IPR With Manager</h4><br>
                        <input type="radio" id="Processing" name="Processing" value="Processing"> Processing &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="Completed" name="Completed" value="Completed"> Completed                
                    </div>

                    <div style="height:400px; width: 100%; overflow-y:scroll; ">
                        <table class="table table-bordered responsive">                    
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>                    
                            </thead>
                            <tbody> 
                                <?php
// Total IPR Employee Efficiency Select Query 
                                $efficiency_query = $this->db->query("select * from tbl_employee inner join tbl_iprreport on 
tbl_employee.Emp_Number=tbl_iprreport.Employee_Id where tbl_iprreport.Year='2017' and 
tbl_iprreport.Month='6' and tbl_iprreport.IPR_Status in (2)");
                                foreach ($efficiency_query->result() as $row_totaleff_emp) {
                                    $eff_year = $row_totaleff_emp->Year;
                                    $eff_month1 = $row_totaleff_emp->Month;
                                    $eff_month = date("d-m-Y", strtotime($eff_month1));
                                    $eff_employee_id = $row_totaleff_emp->Employee_Id;
                                    //$eff_employee_reporting_person = $row_totaleff_emp->Reporting_To; 
                                    // Employee Name get the table
                                    $this->db->where('Emp_Number', $eff_employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                        $Emp_Doj = $row_employee->Emp_Doj;
                                        $doj = date("d-m-Y", strtotime($Emp_Doj));
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo "DRN/$eff_employee_id"; ?></td>
                                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>                                                                                                
                                    </tr>                        
                                </tbody>                    
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="modal-2">
            <div class="modal-dialog" style="width:33%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IPR With Managers</h4>
                        <input type="radio" id="Processing" name="Processing" value="Processing" checked> Processing &nbsp;
                        <input type="radio" id="Completed" name="Completed" value="Completed"> Completed                
                    </div>

                    <div style="height:400px; width: 100%; overflow-y:scroll; ">
                        <table class="table table-bordered responsive">                    
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>                    
                            </thead>
                            <tbody> 
                                <?php
// Total IPR Employee Efficiency Select Query 
                                $efficiency_query = $this->db->query("select Emp_Number, 
Emp_FirstName,Emp_MiddleName,Emp_LastName,tbl_ipr_status_master.ipr_Status from 
tbl_employee inner join tbl_iprreport on tbl_employee.Emp_Number=tbl_iprreport.Employee_Id 
INNER JOIN tbl_ipr_status_master ON tbl_iprreport.IPR_Status= 
tbl_ipr_status_master.IPR_Status_Id where tbl_iprreport.Year='2017' and 
tbl_iprreport.Month='6' and tbl_iprreport.IPR_Status in (3,4)");
                                foreach ($efficiency_query->result() as $row_totaleff_emp) {
                                    $eff_year = $row_totaleff_emp->Year;
                                    $eff_month1 = $row_totaleff_emp->Month;
                                    $eff_month = date("d-m-Y", strtotime($eff_month1));
                                    $eff_employee_id = $row_totaleff_emp->Employee_Id;
                                    //$eff_employee_reporting_person = $row_totaleff_emp->Reporting_To; 
                                    // Employee Name get the table
                                    $this->db->where('Emp_Number', $eff_employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                        $Emp_Doj = $row_employee->Emp_Doj;
                                        $doj = date("d-m-Y", strtotime($Emp_Doj));
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo "DRN/$eff_employee_id"; ?></td>
                                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>                                                                                                
                                    </tr>                        
                                </tbody>                    
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
                    </div>
                </div>
            </div>
        </div>

        <!-- IPR With Employee-->
        <div class="modal fade custom-width" id="modal-3">
            <div class="modal-dialog" style="width:33%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IPR With Employees</h4>                
                    </div>

                    <div style="height:400px; width: 100%; overflow-y:scroll; ">
                        <table class="table table-bordered responsive">                    
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>                    
                            </thead>
                            <tbody> 
                                <?php
// Total IPR Employee Efficiency Select Query 
                                $efficiency_query3 = $this->db->query("select * from tbl_employee inner join tbl_iprreport on 
tbl_employee.Emp_Number=tbl_iprreport.Employee_Id where tbl_iprreport.Year='2017' and 
tbl_iprreport.Month='6' and tbl_iprreport.IPR_Status in (3)");
                                foreach ($efficiency_query3->result() as $row_ipr_emp) {
                                    $eff_year = $row_ipr_emp->Year;
                                    $eff_month1 = $row_ipr_emp->Month;
                                    $eff_month = date("d-m-Y", strtotime($eff_month1));
                                    $eff_employee_id = $row_ipr_emp->Employee_Id;
                                    //$eff_employee_reporting_person = $row_totaleff_emp->Reporting_To; 
                                    // Employee Name get the table
                                    $this->db->where('Emp_Number', $eff_employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                        $Emp_Doj = $row_employee->Emp_Doj;
                                        $doj = date("d-m-Y", strtotime($Emp_Doj));
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo "DRN/$eff_employee_id"; ?></td>
                                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>                                                                                                
                                    </tr>                        
                                </tbody>                    
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
                    </div>
                </div>
            </div>
        </div>

        <!-- IPR With HR Completed-->
        <div class="modal fade custom-width" id="modal-4">
            <div class="modal-dialog" style="width:33%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IPR With Human Resource</h4>                
                    </div>

                    <div style="height:400px; width: 100%; overflow-y:scroll; ">
                        <table class="table table-bordered responsive">                    
                            <thead>
                            <th>Employee Id</th>
                            <th>Employee Name</th>                    
                            </thead>
                            <tbody> 
                                <?php
// Total IPR Employee Efficiency Select Query 
                                $efficiency_query4 = $this->db->query("select * from tbl_employee inner join tbl_iprreport on 
tbl_employee.Emp_Number=tbl_iprreport.Employee_Id where tbl_iprreport.Year='2017' and 
tbl_iprreport.Month='6' and tbl_iprreport.IPR_Status in (4)");
                                foreach ($efficiency_query4->result() as $row_totaleff_emp) {
                                    $eff_year = $row_totaleff_emp->Year;
                                    $eff_month1 = $row_totaleff_emp->Month;
                                    $eff_month = date("d-m-Y", strtotime($eff_month1));
                                    $eff_employee_id = $row_totaleff_emp->Employee_Id;
                                    //$eff_employee_reporting_person = $row_totaleff_emp->Reporting_To; 
                                    // Employee Name get the table
                                    $this->db->where('Emp_Number', $eff_employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                        $Emp_Doj = $row_employee->Emp_Doj;
                                        $doj = date("d-m-Y", strtotime($Emp_Doj));
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo "DRN/$eff_employee_id"; ?></td>
                                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>                                                                                                
                                    </tr>                        
                                </tbody>                    
                            <?php } ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
                    </div>
                </div>
            </div>
        </div>






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