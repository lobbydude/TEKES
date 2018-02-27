<?php
$employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
$user_role = $this->session->userdata('user_role');
$username = $this->session->userdata('username');
$m = (int) $Month;
$curr_date_calender = strtotime(date('d-m-Y'));
$set_calender_date = strtotime(date("10-$m-$Year"));
$get_data = array(
    'Emp_Id' => $employee_id,
    'Month' => $m,
    'Year' => $Year,
    'Status' => 1
);
$this->db->where($get_data);
$q_payslip = $this->db->get('tbl_payslip_info');
$count_payslip = $q_payslip->num_rows();

if ($count_payslip == 1) {
    foreach ($q_payslip->result() as $row_payslip) {
        $Payslip_Id = $row_payslip->Payslip_Id;
        $Emp_Id = $row_payslip->Emp_Id;
        $employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
        $Month = $row_payslip->Month;
        $MonthName = date('F', mktime(0, 0, 0, $Month, 10));
        $Year = $row_payslip->Year;
        $No_Of_Days = $row_payslip->No_Of_Days;
        $No_Of_Days_Present = $row_payslip->No_Of_Days_Worked;
        $No_Of_Days_LOP = $row_payslip->No_Of_Days_LOP;
        $Basic = $row_payslip->Basic;
        $HRA = $row_payslip->HRA;
        $Conveyance = $row_payslip->Conveyance;
        $Skill_Allowance = $row_payslip->Skill_Allowance;
        $Medical_Allowance = $row_payslip->Medical_Allowance;
        $Child_Education = $row_payslip->Child_Education;
        $Special_Allowance = $row_payslip->Special_Allowance;
        $Total_Gross = $row_payslip->Total_Gross;
        $ESI_Employee = $row_payslip->ESI_Employee;
        $PF_Employee = $row_payslip->PF_Employee;
        $Professional_Tax = $row_payslip->Professional_Tax;
        $Insurance = $row_payslip->Insurance;
        $Income_Tax = $row_payslip->Income_Tax;
        $Deduction_Others = $row_payslip->Deduction_Others;
        $Salary_Advance = $row_payslip->Salary_Advance;
        $Total_Deductions = $row_payslip->Total_Deductions;
        $Attendance_Allowance = $row_payslip->Attendance_Allowance;
        $Night_Shift_Allowance = $row_payslip->Night_Shift_Allowance;
        $Weekend_Allowance = $row_payslip->Weekend_Allowance;
        $Referral_Bonus = $row_payslip->Referral_Bonus;
        $Additional_Others = $row_payslip->Additional_Others;
        $Incentives = $row_payslip->Incentives;
        $Total_Income = $row_payslip->Total_Income;
        $Total_Earnings = $row_payslip->Total_Earnings;
        $Net_Amount = $row_payslip->Net_Amount;
        $Amount_Words = $row_payslip->Amount_Words;
        $Monthly_Leave_Taken = $row_payslip->Total_Leave_Taken;

        //Punctuality Calculation
        if ($Monthly_Leave_Taken == 0) {
            $Emp_Leave_Punctuality = 5;
        } else if ($Monthly_Leave_Taken > 0 && $Monthly_Leave_Taken <= 1) {
            $Emp_Leave_Punctuality = 4;
        } else if ($Monthly_Leave_Taken > 1 && $Monthly_Leave_Taken <= 2) {
            $Emp_Leave_Punctuality = 3;
        } else if ($Monthly_Leave_Taken > 2 && $Monthly_Leave_Taken <= 5) {
            $Emp_Leave_Punctuality = 2;
        } else if ($Monthly_Leave_Taken > 5) {
            $Emp_Leave_Punctuality = 1;
        } else {
            $Emp_Leave_Punctuality = 0;
        }

        // Emp Code get the table
        $this->db->where('employee_number', $employee_id);
        $q_code = $this->db->get('tbl_emp_code');
        foreach ($q_code->result() as $row_code) {
            $emp_code = $row_code->employee_code;
        }
        // Employee Name get the table
        $this->db->where('Emp_Number', $employee_id);
        $q_employee = $this->db->get('tbl_employee');
        foreach ($q_employee->result() as $row_employee) {
            $Emp_FirstName = $row_employee->Emp_FirstName;
            $Emp_Middlename = $row_employee->Emp_MiddleName;
            $Emp_LastName = $row_employee->Emp_LastName;
            $Emp_Doj = $row_employee->Emp_Doj;
            $doj = date("d-m-Y", strtotime($Emp_Doj));
        }

        $this->db->where('Employee_Id', $employee_id);
        $q_career = $this->db->get('tbl_employee_career');
        foreach ($q_career->Result() as $row_career) {
            $department_id = $row_career->Department_Id;
            $designation_id = $row_career->Designation_Id;
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
        // Designation Name get the table
        $this->db->where('Designation_Id', $designation_id);
        $q_designation = $this->db->get('tbl_designation');
        foreach ($q_designation->Result() as $row_designation) {
            $designation_name = $row_designation->Designation_Name;
        }
        // Department Name get the table
        $this->db->where('Department_Id', $department_id);
        $q_dept = $this->db->get('tbl_department');
        foreach ($q_dept->result() as $row_dept) {
            $department_name = $row_dept->Department_Name;
        }

        // tbl_process_knowledge get the value
        $this->db->where('Employee_Id', $employee_id);
        $q_emp_process = $this->db->get('tbl_process_knowledge');
        foreach ($q_emp_process->result() as $row_emp_process) {
            $P_Id = $row_emp_process->P_Id;
            $pk_employee_id = $row_emp_process->Employee_Id;
            $pk_year = $row_emp_process->Year;
            $pk_month1 = $row_emp_process->Month;
            $pk_month = date('F', mktime(0, 0, 0, $pk_month1, 10));
            $pk_employee_name = $row_emp_process->Employee_Name;
            $pk_rating = $row_emp_process->Rating;
            $pk_comments = $row_emp_process->Comments;
        }
        // tbl_teamwork get the value
        $this->db->where('Employee_Id', $employee_id);
        $q_emp_teamwork = $this->db->get('tbl_teamwork');
        foreach ($q_emp_teamwork->result() as $row_emp_teamwork) {
            $T_Id = $row_emp_teamwork->T_Id;
            $tw_employee_id = $row_emp_process->Employee_Id;
            $tw_year = $row_emp_teamwork->Year;
            $tw_month1 = $row_emp_teamwork->Month;
            $pk_month = date('F', mktime(0, 0, 0, $tw_month1, 10));
            $tw_employee_name = $row_emp_teamwork->Employee_Name;
            $tw_rating = $row_emp_teamwork->Rating;
            $tw_comments = $row_emp_teamwork->Comments;
        }

        // tbl_effeciency table get Value Start here             
        $this->db->where('Employee_Id', $employee_id);
        $q_emp_eff = $this->db->get('tbl_effeciency');
        foreach ($q_emp_eff->result() as $row_emp_eff) {
            $E_Id = $row_emp_eff->E_Id;
            $eff_employee_id = $row_emp_eff->Employee_Id;
            $eff_year = $row_emp_eff->Year;
            $eff_month1 = $row_emp_eff->Month;
            $eff_month = date('F', mktime(0, 0, 0, $eff_month1, 10));
            $eff_username = $row_emp_eff->Username;
            $eff_production_date1 = $row_emp_eff->Production_Date;
            $eff_production_date = date("d-m-Y", strtotime($eff_production_date1));
            $eff_order_type = $row_emp_eff->Order_Type;
            $eff_order_type_abs = $row_emp_eff->Order_Type_ABS;
            $eff_order_status = $row_emp_eff->Order_Status;
            $eff_state = $row_emp_eff->State;
            $eff_county = $row_emp_eff->County;
            $eff_borrower_name = $row_emp_eff->Borrower_Name;
            $eff_progress_status = $row_emp_eff->Progress_Status;
            $eff_start_time = $row_emp_eff->Start_Time;
            $eff_end_time = $row_emp_eff->End_Time;
            $eff_total_time = $row_emp_eff->Total_Time;
            $eff_order_number = $row_emp_eff->Order_Number;
            $eff_type = $row_emp_eff->Type;
            $eff_reporting_to = $row_emp_eff->Reporting_To;
            $eff_shift = $row_emp_eff->Shift;
            $eff_task = $row_emp_eff->Task;
            $eff_target_coding = $row_emp_eff->Target_Coding;
            $eff_category_salary_bracket = $row_emp_eff->Category_Salary_Bracket;
            $eff_target = $row_emp_eff->Target;
            $eff_efficiency = $row_emp_eff->Efficiency;
        }

        // Efficiency Sum Calculation        
        $sql = "SELECT SUM(Efficiency)as Eff from tbl_effeciency where Employee_Id='$eff_employee_id' and Month='$eff_month1' and Year='$eff_year'";
        $query = $this->db->query($sql);
        $array1 = $query->row_array();

        $results = $query->result();
        $result = $results[0];
        $Emp_Sum_Eff = $result->Eff;

        // Number of Days Calculation  
        $sql2 = "SELECT COUNT(distinct tbl_effeciency.Production_Date)as No_Of_Days from tbl_effeciency where Employee_Id='$eff_employee_id' and Month='$eff_month1' and Year='$eff_year'";

        $query2 = $this->db->query($sql2);
        $array2 = $query2->row_array();

        $result2 = $query2->result();
        $result3 = $result2[0];
        $Emp_No_Days = $result3->No_Of_Days;

        //Efficiency + No of Order Calculation
        $emp_effeciency = ($Emp_Sum_Eff / $Emp_No_Days);

        // No of Orders Efficiency Calculation 
        $sql3 = "SELECT distinct COUNT(tbl_effeciency.Order_Number)as No_Of_Orders from tbl_effeciency where Employee_Id='$eff_employee_id' and Month='$eff_month1' and Year='$eff_year' and Order_Number is not null";
        $query3 = $this->db->query($sql3);
        $array3 = $query3->row_array();

        $result4 = $query3->result();
        $result5 = $result4[0];
        $Emp_No_Orders = $result5->No_Of_Orders;


        if ($emp_effeciency < 25) {
            $Eff_Rating = 1;
        } else if ($emp_effeciency > 25 && $emp_effeciency <= 50) {
            $Eff_Rating = 2;
        } else if ($emp_effeciency > 50 && $emp_effeciency <= 65) {
            $Eff_Rating = 2.5;
        } else if ($emp_effeciency > 65 && $emp_effeciency <= 90) {
            $Eff_Rating = 3;
        } else if ($emp_effeciency > 90 && $emp_effeciency < 100) {
            $Eff_Rating = 4;
        } else if ($emp_effeciency > 100) {
            $Eff_Rating = 5;
        } else {
            $Eff_Rating = 0;
        }

        // tbl_accuracy table get Value Start here
        $this->db->where('Employee_Id', $employee_id);
        $q_emp_acc = $this->db->get('tbl_accuracy');
        foreach ($q_emp_acc->result() as $row_emp_acc) {
            $A_Id = $row_emp_acc->A_Id;
            $acc_employee_id = $row_emp_acc->Employee_Id;
            $acc_year = $row_emp_acc->Year;
            $acc_month1 = $row_emp_acc->Month;
            $acc_month = date('F', mktime(0, 0, 0, $acc_month1, 10));
            $acc_Order_Number = $row_emp_acc->Order_Number;
            $acc_Order_Type = $row_emp_acc->Order_Type;
            $acc_Error_Type = $row_emp_acc->Error_Type;
            $acc_Error_Description = $row_emp_acc->Error_Description;
            $acc_Comments = $row_emp_acc->Comments;
            $acc_Error_Status = $row_emp_acc->Error_Status;
            $acc_Error_Username = $row_emp_acc->Error_Username;
            $acc_Error_User_DRN_Code = $row_emp_acc->Error_User_DRN_Code;
            $acc_QC_Status = $row_emp_acc->QC_Status;
            $acc_QC_Username = $row_emp_acc->QC_Username;
            $acc_QC_User_DRN_Code = $row_emp_acc->QC_User_DRN_Code;
            $acc_production_date = $row_emp_acc->Production_Date;
            $acc_Analysis = $row_emp_acc->Analysis;
            $acc_Dispute_Comments = $row_emp_acc->Dispute_Comments;
            $acc_Error = $row_emp_acc->Error;
            $acc_Internal = $row_emp_acc->Internal;
            $acc_External = $row_emp_acc->External;
        }

        // Accuracy Sum Calculation        
        $acc_sql = "SELECT distinct COUNT(tbl_accuracy.Order_Number)as No_Of_Error from tbl_accuracy where Employee_Id='$acc_employee_id' and Month='$acc_month1' and Year='$acc_year' and Error='YES'";
        $acc_query = $this->db->query($acc_sql);
        $acc_results = $acc_query->result();
        $acc_final_result = $acc_results[0];
        $Emp_Error_Count = $acc_final_result->No_Of_Error;

        // No of Orders Accuracy Calculation
        $acc_sql_Order = "SELECT distinct COUNT(tbl_accuracy.Order_Number)as No_Of_Orders from tbl_accuracy where Employee_Id='$acc_employee_id' and Month='$acc_month1' and Year='$acc_year'";
        $acc_query_Order = $this->db->query($acc_sql_Order);
        $acc_results_Order = $acc_query_Order->result();
        $acc_final_result_Order = $acc_results_Order[0];
        $Emp_Acc_No_Orders = $acc_final_result_Order->No_Of_Orders;

        // Calculation 
        $Emp_Accurancy = 1 - ($Emp_Error_Count / $Emp_Acc_No_Orders);
        $Emp_Accuracy_percentage = $Emp_Accurancy * 100;

        if ($Emp_Accurancy < 0.9) {
            $Acc_Rating = 1;
        } else if ($Emp_Accurancy > 0.9 && $Emp_Accurancy <= 0.95) {
            $Acc_Rating = 2;
        } else if ($Emp_Accurancy > 0.50 && $Emp_Accurancy <= 0.65) {
            $Acc_Rating = 2.5;
        } else if ($Emp_Accurancy > 0.65 && $Emp_Accurancy <= 0.9) {
            $Acc_Rating = 3;
        } else if ($Emp_Accurancy > 0.9 && $Emp_Accurancy <= 1.01) {
            $Acc_Rating = 4;
        } else if ($Emp_Accurancy > 1.01) {
            $Acc_Rating = 5;
        } else {
            $Acc_Rating = 0;
        }
        // tbl_accuracy table get Value End here
        // Overall Score Calculation here
        $Overall_Score = ($Eff_Rating / 5) * 30 + ($Acc_Rating / 5) * 30 + ($Emp_Leave_Punctuality / 5) * 10 + ($pk_rating / 5) * 20 + ($tw_rating / 5) * 10;
        // Final Rating Score Calculation here
        $Final_Rating = ($Overall_Score * 5) / 100;
        /* ---------------***********--------------------- */
        // Employee Month of Present Login Start here   
        $att_sql = "SELECT distinct COUNT(Login_Date) as Login_Date from tbl_attendance where MONTH(Login_Date)='$Month' and YEAR(Login_Date)='$Year' and tbl_attendance.Emp_Id='$employee_id'";
        $att_query2 = $this->db->query($att_sql);
        $att_results_Order = $att_query2->result();
        $att_final_result_Order = $att_results_Order[0];
        $Emp_No_of_days_Present = $att_final_result_Order->Login_Date;
        //echo "$Emp_No_of_days_Present"; die();

        $this->db->where('Emp_Id', $employee_id);
        $q_attendance = $this->db->get('tbl_attendance');
        foreach ($q_attendance->Result() as $row_attendance) {
            $attendance_emplopyee_id = $row_attendance->Emp_Id;
            $attendance_login_date1 = $row_attendance->Login_Date;
            $attendance_login_month = date("m", strtotime($attendance_login_date1));
            $attendance_login_year = date("Y", strtotime($attendance_login_date1));
            $attendance_login_time = $row_attendance->Login_Time;
            $attendance_logout_date = $row_attendance->Logout_Date;
            $attendance_logout_time = $row_attendance->Logout_Time;
            $attendance_shift_name = $row_attendance->Shift_Name;
        }
        // Employee Month of Present Login End here 
        // Weekend Login Emp Login Start
        $att_weekend_sql = "SELECT distinct COUNT(Login_Date) as Login_Date FROM `tbl_attendance` where DAYOFWEEK(Login_Date) in (1,7) and Month(Login_Date)='$Month' and Year(Login_Date)='$Year' and Emp_Id='$employee_id'";
        $att_weekend_query2 = $this->db->query($att_weekend_sql);
        $att_weekend_results = $att_weekend_query2->result();
        $att_weekend_count = $att_weekend_results[0];
        $Emp_Weekend_days_Present = $att_weekend_count->Login_Date;

        // Employee LOP Count get the value
        $lop_sql = "SELECT distinct COUNT(Date) as Date from tbl_attendance_mark where MONTH(Date)='$Month' and YEAR(Date)='$Year' and tbl_attendance_mark.Emp_Id='$employee_id'";
        $lop_query2 = $this->db->query($lop_sql);
        $lop_results_Order = $lop_query2->result();
        $lop_final_result_Order = $lop_results_Order[0];
        $Emp_No_of_days_LOP = $lop_final_result_Order->Date;

        // Employee Total Leave Count get the value
        //$emp_leave_sql = "SELECT distinct COUNT(Employee_Id) as EMP_ID FROM `tbl_leaves` WHERE MONTH(Leave_From)='$Month' AND MONTH(Leave_To)='$Month' AND YEAR(Leave_From)='$Year' and Employee_Id='$employee_id'";
        //$emp_leave_sql = "SELECT Employee_Id,Leave_From,Leave_To,(To_days( Leave_To ) - TO_DAYS(Leave_From))+1 as difference FROM `tbl_leaves`";
        //$emp_leave_sql = "SELECT Employee_Id,Leave_From,Leave_To,(To_days( Leave_To ) - TO_DAYS(Leave_From))+1 as difference FROM `tbl_leaves`";
        $emp_leave_sql = "select datediff(Leave_To,Leave_From)+1 from `tbl_leaves` WHERE `Employee_Id`='$employee_id' and Leave_From > '$Year-$Month-01' and Leave_To < '$Year-$Month-31'";
        $leave_query2 = $this->db->query($emp_leave_sql);
        $leave_results_Order = $leave_query2->result();
        //$leave_final_result_Order = $leave_results_Order[0];
        //print_r($leave_final_result_Order); die();
        //$Emp_No_of_days_Leave = $leave_final_result_Order->leavecount;
        // echo "$Emp_No_of_days_Leave"; die();
        // 15-08-2017 code start
        /* $get_emp_leave = array(
          'Employee_Id' => $employee_id,
          'Status' => 1
          );
          $this->db->where($get_emp_leave);
          $q_emp_leave = $this->db->get('tbl_leaves');
          foreach ($q_emp_leave->result() as $row_emp_leave) {
          $Emp_Leave_Id = $row_emp_leave->Employee_Id;
          $Emp_Reporting_To = $row_emp_leave->Reporting_To;
          $Emp_Leave_Type = $row_emp_leave->Leave_Type;
          $Emp_Reason = $row_emp_leave->Reason;
          $Emp_Leave_Duration = $row_emp_leave->Leave_Duration;
          $Emp_Leave_From = $row_emp_leave->Leave_From;
          $Emp_Leave_To = $row_emp_leave->Leave_To;
          $Leave_From1 = $row->Leave_From;
          $Leave_From = date("d-m-Y", strtotime($Leave_From1));
          $Leave_To1 = $row->Leave_To;
          $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
          $Leave_To = date("d-m-Y", strtotime($Leave_To1));

          } */
        // 15-08-2017 code End
        // Stimulsoft Report Download Query Start here
        $m = (int) $Month;
        $curr_date_calender = strtotime(date('d-m-Y'));
        $set_calender_date = strtotime(date("10-$m-$Year"));
        $get_data1 = array(
            'Employee_Id' => $employee_id,
            'Month' => $m,
            'Year' => $Year,
            'Status' => 1
        );
        $this->db->where($get_data1);
        $q_ipr = $this->db->get('tbl_iprreport');

        $this->db->where('Employee_Id', $employee_id);
        $q_ipr_report = $this->db->get('tbl_iprreport');
        foreach ($q_ipr->Result() as $row_ipr) {
            $IPR_Id = $row_ipr->I_Id;
            $Emp_Id = $row_ipr->Employee_Id;
        }
        // Stimulsoft Report Download Query End here
    } //End 

    if ($username == "0037" || $username == "0070" || $username == "0135" || $username == "0166" || $username == "0165") {
        ?>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-8">
                <p style="text-align: center;">No Records Found.</p>
            </div>
        </div>
        <?php
    } else {
        if (($user_role == 1 && ($curr_date_calender > $set_calender_date)) || ($user_role == 3 && ($curr_date_calender > $set_calender_date)) || ($user_role == 4 && ($curr_date_calender > $set_calender_date)) || ($user_role == 7 && ($curr_date_calender > $set_calender_date)) || ($user_role == 5 && ($curr_date_calender > $set_calender_date)) || $user_role == 2 || $user_role == 6) {
            ?> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2"></div>                           
                    <div class="col-sm-2">
                        <img src="<?php echo site_url('images/drn.png'); ?>"> 
                    </div>
                    <div class="col-sm-5" style="margin-left:-60px;margin-top:-7px">
                        <h3>DRN DEFINITE SOLUTIONS PVT LTD</h3>
                        <p>
                            No. 16, Lakshya Towers, 4th Floor, 5th Block, Koramangala<br>
                            Bangalore, Karnataka, India Pin - 560 095.<br> 
                            Tel: 080 65691240 , Email : accounts@drnds.com
                        </p>
                        <h4><b>IPR Report Month of <?php echo $MonthName . " " . $Year; ?></b></h4>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3" style="margin-left:-60px;margin-top:45px">
                        <?php //if ($user_role == 2 || $user_role == 6) {      ?>

                        <?php //}     ?>                        
                        <a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Ipr.mrt&param1=' . $IPR_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-download"></i>
                            Download
                        </a>
                    </div>             
                </div>
            </div>         

            <script>
                $(document).ready(function () {
                    $('#add_ipr_report_form').submit(function (e) {
                        e.preventDefault();
                        var formdata = {
                            add_ipr_month: $('#add_ipr_month').val(),
                            add_ipr_year: $('#add_ipr_year').val(),
                            add_ipr_empid: $('#add_ipr_empid').val(),
                            add_ipr_empcode: $('#add_ipr_empcode').val(),
                            add_ipr_emp_name: $('#add_ipr_emp_name').val(),
                            add_ipr_emp_doj: $('#add_ipr_emp_doj').val(),
                            add_ipr_emp_destignation: $('#add_ipr_emp_destignation').val(),
                            add_ipr_emp_reporting_person: $('#add_ipr_emp_reporting_person').val(),
                            add_ipr_efficiency_rating: $('#add_ipr_efficiency_rating').val(),
                            add_ipr_accuracy_rating: $('#add_ipr_accuracy_rating').val(),
                            add_ipr_punctuality_rating: $('#add_ipr_punctuality_rating').val(),
                            add_ipr_process_knowledge_rating: $('#add_ipr_process_knowledge_rating').val(),
                            add_ipr_teamwork_rating: $('#add_ipr_teamwork_rating').val(),
                            add_ipr_overallscore: $('#add_ipr_overallscore').val(),
                            add_ipr_efficiency: $('#add_ipr_efficiency').val(),
                            add_ipr_total_orders: $('#add_ipr_total_orders').val(),
                            add_ipr_accuracy: $('#add_ipr_accuracy').val(),
                            add_ipr_internal: $('#add_ipr_internal').val(),
                            add_ipr_external: $('#add_ipr_external').val(),
                            add_ipr_monthly_present: $('#add_ipr_monthly_present').val(),
                            add_ipr_monthly_leave: $('#add_ipr_monthly_leave').val(),
                            add_ipr_monthly_lop: $('#add_ipr_monthly_lop').val(),
                            add_ipr_monthly_weekend_login: $('#add_ipr_monthly_weekend_login').val(),
                            add_ipr_final_rating: $('#add_ipr_final_rating').val(),
                            add_ipr_efficiency_comments: $('#add_ipr_efficiency_comments').val(),
                            add_ipr_accuracy_comments: $('#add_ipr_accuracy_comments').val(),
                            add_ipr_punctuality_comments: $('#add_ipr_punctuality_comments').val(),
                            add_ipr_process_knowledge_comments: $('#add_ipr_process_knowledge_comments').val(),
                            add_ipr_teamwork_comments: $('#add_ipr_teamwork_comments').val(),
                            add_ipr_supervisor_comments: $('#add_ipr_supervisor_comments').val(),
                            add_ipr_employee_comments: $('#add_ipr_employee_comments').val(),
                            add_ipr_emp_other_comments: $('#add_ipr_emp_other_comments').val(),
                            add_ipr_sup_other_comments: $('#add_ipr_sup_other_comments').val(),
                            add_ipr_supervisor_date: $('#add_ipr_supervisor_date').val(),
                            add_ipr_employee_date: $('#add_ipr_employee_date').val(),
                            add_ipr_supervisor_signature: $('#add_ipr_supervisor_signature').val(),
                            add_ipr_employee_signature: $('#add_ipr_employee_signature').val()
                        };
                        $.ajax({
                            url: "<?php echo site_url('Ipr1/add_iprreport') ?>",
                            type: 'post',
                            data: formdata,
                            success: function (msg) {
                                alert('IPR data Updated Successfully');
                                if (msg == 'fail') {
                                    $('#addipr_report_error').show();
                                }
                                if (msg == 'success') {
                                    $('#addipr_report_success').show();
                                    window.location.reload();
                                }
                            }
                        });
                    });
                });
            </script>


            <script>
                $(document).ready(function (e) {
                    $("#add_ipr_report_form1").on('submit', (function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: "<?php echo site_url('Payslip1/add_iprreport1') ?>",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data)
                            {
                                alert(data);
                                if (data.trim() == "fail") {
                                    $('#addipr_report_success').hide();
                                    $('#addipr_report_error').show();
                                }
                                if (data.trim() == "success") {
                                    $('#addipr_report_error').hide();
                                    $('#addipr_report_success').show();
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





            <style>
                #Efficiency{
                    height: 100px;
                    width: 20px;
                }
            </style>       

            <form role="form" id="add_ipr_report_form" name="add_ipr_report_form" method="post" class="validate">
                <div class="row">
                    <div class="col-md-10">
                        <div id="addipr_report_server_error" class="alert alert-info" style="display:none;"></div>
                        <div id="addipr_report_success" class="alert alert-success" style="display:none;">IPR Report details added successfully.</div>
                        <div id="addipr_report_error" class="alert alert-danger" style="display:none;">Failed to add IPR Report details.</div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                    <input type="hidden" name="add_ipr_emp_name" id="add_ipr_emp_name" value="<?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?>">                            
                    <input type="hidden" name="add_ipr_empid" id="add_ipr_empid" value="<?php echo $Emp_Id; ?>">
                    <input type="hidden" name="add_ipr_empcode" id="add_ipr_empcode" value="<?php echo $emp_code; ?>">
                    <td><b>Name of the Employee :</b></td>
                    <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                    <td><b>Employee Code : </b></td>
                    <td><?php echo $emp_code . $Emp_Id; ?></td>
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_month" id="add_ipr_month" value="<?php echo $Month; ?>">
                    <input type="hidden" name="add_ipr_year" id="add_ipr_year" value="<?php echo $MonthName . " " . $Year; ?>">
                    <input type="hidden" name="add_ipr_emp_doj" id="add_ipr_emp_doj" value="<?php echo $doj; ?>">
                    <td><b>Month & Year : </b></td>
                    <td><?php echo $MonthName . " " . $Year; ?></td>
                    <td><b>Date of Joining :</b></td>
                    <td><?php echo $doj; ?></td>                                                                       
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_emp_destignation" id="add_ipr_emp_destignation" value="<?php echo $designation_name; ?>">
                    <input type="hidden" name="add_ipr_emp_reporting_person" id="add_ipr_emp_reporting_person" value="<?php echo $emp_reporting_name; ?>">
                    <td><b>Designation :</b></td>
                    <td><?php echo $designation_name; ?></td>
                    <td><b>Reporting Person :</b></td>
                    <td><?php echo $emp_reporting_name; ?></td>
                    </tr>

                    <tr style="background-color:#f2f2f2;">
                        <th>Performance</th>
                        <th>Rating</th>                                
                        <th>Supporting score if any</th>
                        <th>Comments</th>                               
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_efficiency_rating" id="add_ipr_efficiency_rating" value="<?php echo $Eff_Rating; ?>">
                    <input type="hidden" name="add_ipr_efficiency" id="add_ipr_efficiency" value="<?php echo $emp_effeciency; ?>">
                    <input type="hidden" name="add_ipr_total_orders" id="add_ipr_total_orders" value="<?php echo $Emp_No_Orders; ?>">
                    <td>Efficiency - Weightage 30%</td>                    
                    <td align="center">
                        <a style="cursor:pointer; text-decoration:underline;" title="Efficiency Calculation Rating" href="javascript:;" onclick="jQuery('#modal-1').modal('show');" ><?php echo $Eff_Rating; ?></a>
                    </td>
                    <td>Efficiency :  <a style="cursor:pointer; text-decoration:underline;" title="Efficiency Calculation" href="javascript:;" onclick="jQuery('#modal-4').modal('show');" ><?php echo number_format(round($emp_effeciency), 0, '.', ','); ?>%</a>  
                        <br> Total Orders : <a style="cursor:pointer; text-decoration:underline;" title="Total Orders" href="javascript:;" onclick="jQuery('#modal-6').modal('show');" ><?php echo $Emp_No_Orders; ?></a></td>
                    <td><textarea rows="2" cols="30"  name="add_ipr_efficiency_comments" id="add_ipr_efficiency_comments" placeholder="Comments"></textarea></td>                                                          
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_accuracy_rating" id="add_ipr_accuracy_rating" value="<?php echo $Acc_Rating; ?>">
                    <input type="hidden" name="add_ipr_accuracy" id="add_ipr_accuracy" value="<?php echo $Emp_Accuracy_percentage; ?>">
                    <input type="hidden" name="add_ipr_internal" id="add_ipr_internal" value="<?php echo $acc_Internal; ?>">
                    <input type="hidden" name="add_ipr_external" id="add_ipr_external" value="<?php echo $acc_External; ?>">
                    <input type="hidden" name="add_ipr_accuracy_comments" id="add_ipr_accuracy_comments" value="<?php echo $acc_Dispute_Comments; ?>">
                    <td>Accuracy - Weightage 30%</td>
                    <td align="center">
                        <a style="cursor:pointer; text-decoration:underline;" title="Accuracy Calculation Rating" href="javascript:;" onclick="jQuery('#modal-2').modal('show');" ><?php echo $Acc_Rating; ?></a>                        
                    </td>
                    <td>Accuracy : <a style="cursor:pointer; text-decoration:underline;" title="Accuracy Calculation" href="javascript:;" onclick="jQuery('#modal-5').modal('show');" ><?php echo number_format(round($Emp_Accuracy_percentage), 0, '.', ','); ?>% </a>
                        <br>Internal : <?php echo "$acc_Internal"; ?> <br> External : <?php echo "$acc_External"; ?></td>
                    <td><textarea name="add_ipr_accuracy_comments" id="add_ipr_accuracy_comments" rows="2" cols="30" placeholder="Comments"><?php echo "$acc_Dispute_Comments"; ?></textarea></td>                                                                        
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_punctuality_rating" id="add_ipr_punctuality_rating" value="<?php echo $Emp_Leave_Punctuality; ?>">
                    <input type="hidden" name="add_ipr_monthly_present" id="add_ipr_monthly_present" value="<?php echo $Emp_No_of_days_Present; ?>">
                    <input type="hidden" name="add_ipr_monthly_leave" id="add_ipr_monthly_leave" value="<?php echo $Monthly_Leave_Taken; ?>">
                    <input type="hidden" name="add_ipr_monthly_lop" id="add_ipr_monthly_lop" value="<?php echo $Emp_No_of_days_LOP; ?>">
                    <td>Punctuality & Discipline Weightage 10%</td>
                    <td align="center"><a style="cursor:pointer; text-decoration:underline;" title="Punctuality Calculation Rating" href="javascript:;" onclick="jQuery('#modal-11').modal('show');" ><?php echo $Emp_Leave_Punctuality; ?></a></td>
                    <td>Present : <a style="cursor:pointer; text-decoration:underline;" title="No of Days Present" href="javascript:;" onclick="jQuery('#modal-7').modal('show');" ><?php echo "$Emp_No_of_days_Present"; ?></a> 
                        <br> 
                        Leave : <a style="cursor:pointer; text-decoration:underline;" title="Total Leaves" href="javascript:;" onclick="jQuery('#modal-10').modal('show');" > <?php echo "$Monthly_Leave_Taken"; ?></a> 
                        <br>                            
                        LOP :<a style="cursor:pointer; text-decoration:underline;" title="No of Days LOP" href="javascript:;" onclick="jQuery('#modal-9').modal('show');" ><?php echo "$Emp_No_of_days_LOP"; ?></a></td>
                    <td><textarea name="add_ipr_punctuality_comments" id="add_ipr_punctuality_comments" rows="2" cols="30" placeholder="Comments"></textarea></td>                            
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_process_knowledge_rating" id="add_ipr_process_knowledge_rating" value="<?php echo $pk_rating; ?>">
                    <input type="hidden" name="add_ipr_process_knowledge_comments" id="add_ipr_process_knowledge_comments" value="<?php echo $pk_comments; ?>">
                    <td>Process Knowledge - Weightage 20%</td>
                    <td align="center"><?php echo "$pk_rating"; ?></td>
                    <td></td>
                    <td><textarea rows="2" cols="30" placeholder="Comments"><?php echo "$pk_comments"; ?></textarea></td>                                                               
                    </tr>
                    <tr>
                    <input type="hidden" name="add_ipr_teamwork_rating" id="add_ipr_teamwork_rating" value="<?php echo $tw_rating; ?>">
                    <input type="hidden" name="add_ipr_monthly_weekend_login" id="add_ipr_monthly_weekend_login" value="<?php echo $Emp_Weekend_days_Present; ?>">
                    <input type="hidden" name="add_ipr_teamwork_comments" id="add_ipr_teamwork_comments" value="<?php echo $tw_comments; ?>">
                    <td>Team Work & Flexibility Weightage 10%</td>
                    <td align="center"><?php echo "$tw_rating"; ?></td>
                    <td>Week End Login : <a style="cursor:pointer; text-decoration:underline;" title="Weekend Login" href="javascript:;" onclick="jQuery('#modal-8').modal('show');" ><?php echo "$Emp_Weekend_days_Present"; ?></a></td>
                    <td><textarea rows="2" cols="30" placeholder="Comments"><?php echo "$tw_comments"; ?></textarea></td>                                                         
                    </tr>                
                    <tr style="background-color:#ebebe0;">
                    <input type="hidden" name="add_ipr_overallscore" id="add_ipr_overallscore" value="<?php echo $Overall_Score; ?>">
                    <input type="hidden" name="add_ipr_final_rating" id="add_ipr_final_rating" value="<?php echo $Final_Rating; ?>">
                    <td><b>Overall Score</b> </td>
                    <td align="center">
                        <a style="cursor:pointer; text-decoration:underline;" title="Overall Score Calculation" href="javascript:;" onclick="jQuery('#modal-3').modal('show');"><b class="btn btn-success"><?php echo "$Overall_Score"; ?>% </b></a>
                    </td>
                    <td><b>Final Rating</b></td>
                    <td><b class="btn btn-success"><?php echo "$Final_Rating"; ?></b></td>                                                                        
                    </tr>
                    <tr>                            
                        <td><b>Employee Date :</b> <br/>
                            <input name="add_ipr_employee_date" id="add_ipr_employee_date" type="text" size="27" placeholder="2017-08-31"></td>                            
                        <td><b>Employee Signature :</b><br/>
                            <textarea name="add_ipr_employee_signature" id="add_ipr_employee_signature" rows="2" cols="30" placeholder="Employee Signature"></textarea></td>
                        <td><b>Comments from Employee : </b><br/>
                            <textarea name="add_ipr_employee_comments" id="add_ipr_employee_comments" rows="2" cols="30" placeholder="Employee Comments"></textarea></td>
                        <td><b>Other Comments : </b><br/>
                            <textarea name="add_ipr_emp_other_comments" id="add_ipr_emp_other_comments" rows="2" cols="30" placeholder="Employee Other Comments"></textarea></td>
                    </tr>
                    <tr>
                        <td><b>Supervisor Date :</b> <br/><input name="add_ipr_supervisor_date" id="add_ipr_supervisor_date" type="text" size="27" placeholder="2017-08-31"></td>
                        <td><b>Supervisor Signature :</b><br/>
                            <textarea name="add_ipr_supervisor_signature" id="add_ipr_supervisor_signature" rows="2" cols="30" placeholder="Supervisor Signature"></textarea></td>
                        <td><b>Comments from Supervisor : </b><br/>
                            <textarea name="add_ipr_supervisor_comments" id="add_ipr_supervisor_comments" rows="2" cols="30" placeholder="Supervisor Comments"></textarea></td>
                        <td><b>Other Comments: </b><br/>
                            <textarea name="add_ipr_sup_other_comments" id="add_ipr_sup_other_comments" rows="2" cols="30" placeholder="Supervisor Other Comments"></textarea></td>
                    </tr>                    
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="margin:0px 568px 0px 0px;">Submit</button>
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>            
            </form>

            <div class="row">
                <div class="col-md-12">
                    <!--<table class="table table-bordered">
                        <tbody>                              
                            <tr>
                                <td><b>Employee Date :</b> <br/><input type="text" size="27" placeholder="23-08-2017"></td>
                                <td><b>Employee Signature :</b><br/>
                               <textarea rows="2" cols="30" placeholder="Employee Signature"></textarea></td>
                                <td><b>Comments from Employee : </b><br/>
                                <textarea rows="2" cols="30" placeholder=" Employee Comments"></textarea></td>                                                                
                            </tr>
                            <tr>
                                <td><b>Supervisor Date :</b> <br/><input type="text" size="27" placeholder="31-08-2017"></td>
                                <td><b>Supervisor Signature :</b><br/>
                               <textarea rows="2" cols="30" placeholder="Supervisor Signature"></textarea></td>
                                <td><b>Comments from Supervisor : </b><br/>
                                <textarea rows="2" cols="30" placeholder="Supervisor Comments"></textarea></td>                                                                
                            </tr>                                        
                        </tbody>                  
                    </table>-->
                    <!--<div class="footer">
                        <button style="margin:-1% 0 0 46%;" type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>                        
                    </div>-->   

                    <span class="pull-left" style="margin:5px;"> DRN/HR/IPR-Report</span> <span class="pull-right" style="margin: 5px;">Ver 1.0</span>                
                    <br/>
                </div>
            </div>

            <!-- Delete Payslip Start Here -->
            <div class="modal fade" id="delete_payslip">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Delete Payslip</h3>
                        </div>
                        <form role="form" id="deletepayslip_form" name="deletepayslip_form" method="post" class="validate">

                        </form>
                    </div>
                </div>
            </div>
            <script>
                function delete_Payslip(id) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Payslip/Deletepayslip') ?>",
                        data: "payslip_id=" + id,
                        cache: false,
                        success: function (html) {
                            $("#deletepayslip_form").html(html);
                        }
                    });
                }
            </script>
            <!-- Delete Payslip End Here -->
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-8">
                    <p>No Records Found.</p>
                </div>
            </div>
            <?php
        }
    }
} else {
    ?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <p>No Records Found.</p>
        </div>
    </div>
<?php } ?>


<!-- Efficiency Calculation Instructions Start here-->
<div class="modal fade" id="modal-1">
    <div class="modal-dialog" style="width:25%;">
        <div class="modal-content">            
            <div class="modal-body">
                <table class="table table-bordered datatable">
                    <thead>
                    <th>Efficiency</th>
                    <th>Rating</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td> >100%</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td> >=90% and <=100%</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td> >=65% and <90%</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td> >= 50% and <65%</td>
                            <td>2.5</td>
                        </tr>
                        <tr>
                            <td> >= 25% and <50%</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td> <25%</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <button style="margin:-4% 0 1% 75%;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                        
            </div>
        </div>
    </div>
</div>
<!-- Efficiency Calculation Instructions End here-->
<!-- Accuracy Calculation Instructions Start here-->          
<div class="modal fade" id="modal-2">
    <div class="modal-dialog" style="width:25%;">
        <div class="modal-content">            
            <div class="modal-body">
                <table class="table table-bordered datatable">
                    <thead>
                    <th>Accuracy</th>
                    <th>Rating</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td> >100%</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td> >=98% and <100%</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td> >= 95% and <98%</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td> >= 90% and <95%</td>
                            <td>2</td>
                        </tr>                        
                        <tr>
                            <td> <90%</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <button style="margin:-4% 0 1% 75%;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                        
            </div>
        </div>
    </div>
</div> 
<!-- Accuracy Calculation Instructions End here--> 
<!-- Punctuality Calculation Instructions Start here-->          
<div class="modal fade" id="modal-11">
    <div class="modal-dialog" style="width:25%;">
        <div class="modal-content">            
            <div class="modal-body">
                <table class="table table-bordered datatable">
                    <thead>
                    <th>Punctuality</th>
                    <th>Rating</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td> >0</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Leave >0 and Leave <=1</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Leave > 1 and Leave <= 2</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Leave > 2 and Leave <= 5</td>
                            <td>2</td>
                        </tr>                        
                        <tr>
                            <td>Leave >5</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <button style="margin:-4% 0 1% 75%;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                        
            </div>
        </div>
    </div>
</div> 
<!-- Punctuality Calculation Instructions End here--> 

<!-- Overall Score Calculation Instructions Start here-->          
<div class="modal fade" id="modal-3">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content">
            <div class="modal-body">
                <table class="table table-bordered datatable">
                    <thead>
                    <th>Overall Calculation Process</th>                    
                    </thead>
                    <tbody>
                        <tr>
                            <td>(Efficiency Weightage 30% / 5) * 30 + </td>                            
                        </tr>
                        <tr>
                            <td>(Accuracy Weightage 30% / 5) * 30 + </td>                            
                        </tr>
                        <tr>
                            <td>(Punctuality & Discipline Weightage 10% / 5) * 10 +</td>                            
                        </tr>
                        <tr>
                            <td>(Process Knowledge Weightage 20% / 5) * 20 + </td>                            
                        </tr>                        
                        <tr>
                            <td>(Team Work & Flexibility Weightage 10% / 5) * 10</td>                            
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <button style="margin:-3% 0% 1% 81%;" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                        
            </div>
        </div>
    </div>
</div> 
<!-- Overall Score Calculation Instructions End here-->

<!-- Efficiency Calculation Start here-->
<div class="modal fade custom-width" id="modal-4">
    <div class="modal-dialog" style="width:96%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Efficiency Calculation</h4>
            </div>

            <div style="height:400px; width: 100%; overflow-y:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead>
                    <th>Order Number</th>
                    <th>Order Type</th>  
                    <th>State</th>
                    <th>County</th>
                    <th>Production Date</th>                  
                    <th>Order Task</th>                    
                    <th>Progress Status</th>                    
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Time</th>                    
                    <th>Type</th>                    
                    <th>Efficiency</th>
                    </thead>
                    <tbody> 
                        <?php
// Efficiency Select Query 
                        $efficiency_query = $this->db->query("SELECT Employee_Id,Production_Date,Order_Type,Order_Type_ABS,Order_Status,State,County,Borrower_Name,Progress_Status,Start_Time,End_Time,Total_Time,Order_Number,Type,Reporting_To,Task,Efficiency FROM `tbl_effeciency` where Employee_Id='$eff_employee_id'");
                        foreach ($efficiency_query->result() as $row_pemp_eff) {
                            $effp_production_date1 = $row_pemp_eff->Production_Date;
                            $effp_production_date = date("d-m-Y", strtotime($effp_production_date1));
                            $effp_order_type = $row_pemp_eff->Order_Type;
                            $effp_order_status = $row_emp_eff->Order_Status;
                            $effp_state = $row_pemp_eff->State;
                            $effp_county = $row_pemp_eff->County;
                            $effp_borrower_name = $row_pemp_eff->Borrower_Name;
                            $effp_progress_status = $row_pemp_eff->Progress_Status;
                            $effp_start_time = $row_pemp_eff->Start_Time;
                            $effp_end_time = $row_pemp_eff->End_Time;
                            $effp_total_time = $row_pemp_eff->Total_Time;
                            $effp_order_number = $row_pemp_eff->Order_Number;
                            $effp_type = $row_pemp_eff->Type;
                            $effp_efficiency = $row_pemp_eff->Efficiency;
                            ?>
                            <tr>
                                <td><?php echo "$effp_order_number"; ?></td>
                                <td><?php echo "$effp_order_type"; ?></td>  
                                <td><?php echo "$effp_state"; ?></td>
                                <td><?php echo "$effp_county"; ?></td>
                                <td><?php echo "$effp_production_date"; ?></td>                        
                                <td><?php echo "$effp_order_status"; ?></td>                            
                                <td><?php echo "$effp_progress_status"; ?></td>
                                <td><?php echo "$effp_start_time"; ?></td>
                                <td><?php echo "$effp_end_time"; ?></td>
                                <td><?php echo "$effp_total_time"; ?></td>
                                <td><?php echo "$effp_type"; ?></td>                                
                                <td><?php echo "$effp_efficiency"; ?></td>                            
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

<!-- Accuracy Calculation Start here-->
<div class="modal fade custom-width" id="modal-5">
    <div class="modal-dialog" style="width:93%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Accuracy Calculation</h4>
            </div>

            <div style="height:400px; width: 100%; overflow:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead>                                        
                    <th>Order Number</th>                  
                    <th>Order Type</th>
                    <th>Production Date</th>
                    <th>Error Type</th>
                    <th>Error Description</th>                    
                    <th>Error Task</th>
                    <th>Error Username</th>                    
                    <th>Analysis</th>                                       
                    <th>Error</th>
                    </thead>
                    <tbody> 
                        <?php
// Accuracy Select Query 
                        $accuracy_query = $this->db->query("SELECT Employee_Id,Order_Number,Order_Type,Error_Type,Error_Description,Comments,Error_Status,Error_Username,Error_User_DRN_Code,Production_Date,Analysis,Dispute_Comments,Error FROM `tbl_accuracy` where Employee_Id='$acc_employee_id'");
                        foreach ($accuracy_query->result() as $row_aemp_acc) {
                            $accp_employee_id = $row_aemp_acc->Employee_Id;
                            $accp_Order_Number = $row_aemp_acc->Order_Number;
                            $accp_Order_Type = $row_aemp_acc->Order_Type;
                            $accp_Error_Type = $row_aemp_acc->Error_Type;
                            $accp_Error_Description = $row_aemp_acc->Error_Description;
                            $accp_Error_Status = $row_aemp_acc->Error_Status;
                            $accp_Error_Username = $row_aemp_acc->Error_Username;
                            $accp_production_date1 = $row_aemp_acc->Production_Date;
                            $accp_production_date = date("d-m-Y", strtotime($accp_production_date1));
                            $accp_Analysis = $row_aemp_acc->Analysis;
                            $accp_Dispute_Comments = $row_aemp_acc->Dispute_Comments;
                            $accp_Error = $row_aemp_acc->Error;
                            ?>
                            <tr>                            
                                <td><?php echo "$accp_Order_Number"; ?></td>                     
                                <td><?php echo "$accp_Order_Type"; ?></td>
                                <td><?php echo "$accp_production_date"; ?></td>
                                <td><?php echo "$accp_Error_Type"; ?></td>
                                <td><?php echo "$accp_Error_Description"; ?></td>                                
                                <td><?php echo "$accp_Error_Status"; ?></td>
                                <td><?php echo "$accp_Error_Username"; ?></td>                                                            

                                <td><?php echo "$accp_Analysis"; ?></td>                                                 
                                <td><?php echo "$accp_Error"; ?></td>                            
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
<!-- Accuracy Calculation End here-->

<!-- Total Number Orders Start here-->
<div class="modal fade custom-width" id="modal-6">
    <div class="modal-dialog" style="width:96%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Total Number Orders [<?php echo "$Emp_No_Orders"; ?> ] </h4>
            </div>

            <div style="height:400px; width: 100%; overflow-y:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead> 
                    <th>S.No</th>    
                    <th>Username</th>
                    <th>Order Number</th>
                    <th>Production Date</th>                  
                    <th>Order Type</th>
                    <th>Order Type ABS</th>
                    <th>Order Status</th>
                    <th>State</th>
                    <th>County</th>                   
                    <th>Progress Status</th>                    
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Time</th>                    
                    <th>Type</th>                                       
                    <th>Efficiency</th>
                    </thead>
                    <tbody> 
                        <?php
// Efficiency Select Query 
                        $i = 1;
                        $total_orders_query = $this->db->query("SELECT Employee_Id,Username,Production_Date,Order_Type,Order_Type_ABS,Order_Status,State,County,Borrower_Name,Progress_Status,Start_Time,End_Time,Total_Time,Order_Number,Type,Reporting_To,Task,Efficiency FROM `tbl_effeciency` where Employee_Id='$eff_employee_id'");
                        foreach ($total_orders_query->result() as $row_pemp_eff) {
                            $effp_username = $row_pemp_eff->Username;
                            $effp_production_date1 = $row_pemp_eff->Production_Date;
                            $effp_production_date = date("d-m-Y", strtotime($effp_production_date1));
                            $effp_order_type = $row_pemp_eff->Order_Type;
                            $effp_order_type_abs = $row_pemp_eff->Order_Type_ABS;
                            $effp_order_status = $row_emp_eff->Order_Status;
                            $effp_state = $row_pemp_eff->State;
                            $effp_county = $row_pemp_eff->County;
                            $effp_progress_status = $row_pemp_eff->Progress_Status;
                            $effp_start_time = $row_pemp_eff->Start_Time;
                            $effp_end_time = $row_pemp_eff->End_Time;
                            $effp_total_time = $row_pemp_eff->Total_Time;
                            $effp_order_number = $row_pemp_eff->Order_Number;
                            $effp_type = $row_pemp_eff->Type;
                            $effp_efficiency = $row_pemp_eff->Efficiency;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo "$effp_username"; ?></td>
                                <td><?php echo "$effp_order_number"; ?></td>
                                <td><?php echo "$effp_production_date"; ?></td>                                
                                <td><?php echo "$effp_order_type"; ?></td>
                                <td><?php echo "$effp_order_type_abs"; ?></td>
                                <td><?php echo "$effp_order_status"; ?></td>
                                <td><?php echo "$effp_state"; ?></td>
                                <td><?php echo "$effp_county"; ?></td>                                
                                <td><?php echo "$effp_progress_status"; ?></td>
                                <td><?php echo "$effp_start_time"; ?></td>
                                <td><?php echo "$effp_end_time"; ?></td>
                                <td><?php echo "$effp_total_time"; ?></td>

                                <td><?php echo "$effp_type"; ?></td>                                                    
                                <td><?php echo "$effp_efficiency"; ?></td>                            
                            </tr>                        
                        </tbody>                    
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>
<!-- Total Number Orders End here-->

<!-- Attendance Present Start here -->
<div class="modal fade custom-width" id="modal-7">
    <div class="modal-dialog" style="width:65%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">No of Days Present [ <?php echo "$Emp_No_of_days_Present"; ?> ]</h4>
            </div>

            <div style="height:400px; width: 100%; overflow-y:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead> 
                    <th>S.No</th>
                    <th>Emp Name</th>
                    <th>Emp Id</th>
                    <th>Login Date</th>                   
                    <th>Login Time</th>
                    <th>Logout Date</th>
                    <th>Logout Time</th>
                    <th>Total Hours</th>
                    <th>Shift Name</th>
                    <!--<th>System Number</th>-->
                    </thead>
                    <tbody> 
                        <?php
// Attendance Select Query 
                        $i = 1;
                        $attendance_select_query = $this->db->query("SELECT Emp_Id,Login_Date,Login_Time,Logout_Date,Logout_Time,Shift_Name,IP_Address FROM tbl_attendance WHERE Year(Login_Date) = '$Year' and Month(Login_Date) = '$Month' and Emp_Id='$Emp_Id'");
                        foreach ($attendance_select_query->result() as $row_emp_att) {
                            $attendace_emp_id = $row_emp_att->Emp_Id;
                            $att_Login_Date1 = $row_emp_att->Login_Date;
                            $att_Login_Date = date("d-m-Y", strtotime($att_Login_Date1));
                            $att_Login_Month = date("m", strtotime($att_Login_Date1));
                            $att_Login_Year = date("Y", strtotime($att_Login_Date1));
                            $att_Login_Time = $row_emp_att->Login_Time;
                            $att_Logout_Date1 = $row_emp_att->Logout_Date;
                            $att_Logout_Date = date("d-m-Y", strtotime($att_Logout_Date1));
                            $att_Logout_Time = $row_emp_att->Logout_Time;
                            $att_ShiftName = $row_emp_att->Shift_Name;
                            $h1 = strtotime($att_Login_Time);
                            $h2 = strtotime($att_Logout_Time);
                            $seconds = $h2 - $h1;
                            $total_hours = gmdate("H:i:s", $seconds);
                            //echo "$total_hours "; die();
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                <td><?php echo $emp_code . $Emp_Id; ?></td>
                                <td><?php echo "$att_Login_Date"; ?></td>
                                <td><?php echo "$att_Login_Time"; ?></td>
                                <td><?php echo "$att_Logout_Date"; ?></td>
                                <td><?php echo "$att_Logout_Time"; ?></td>
                                <td><?php echo "$total_hours"; ?></td>
                                <td><?php echo "$att_ShiftName"; ?></td>                                              
                            </tr>                        
                        </tbody>                    
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>
<!-- Attendance Present End here -->

<!-- Weekend Login Present Start here -->
<div class="modal fade custom-width" id="modal-8">
    <div class="modal-dialog" style="width:60%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Weekend Login Present [ <?php echo "$Emp_Weekend_days_Present"; ?> ] days</h4>
            </div>

            <div style="height:300px; width: 100%; overflow-y:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead> 
                    <th>S.No</th>
                    <th>Emp Name</th>
                    <th>Emp Id</th>
                    <th>Login Date</th>                   
                    <th>Login Time</th>
                    <th>Logout Date</th>
                    <th>Logout Time</th>
                    <th>Total Hours</th>
                    <th>Shift Name</th>
                    <!--<th>System Number</th>-->
                    </thead>
                    <tbody> 
                        <?php
                        // Attendance Select Query 
                        $i = 1;
                        //$attendance_select_query = $this->db->query("SELECT Emp_Id,Login_Date,Login_Time,Logout_Date,Logout_Time,Shift_Name,IP_Address FROM `tbl_attendance` where Emp_Id='$Emp_Id'");
                        $weekend_attendance_select_query = $this->db->query("SELECT Emp_Id,Login_Date,Login_Time,Logout_Date,Logout_Time,Shift_Name,IP_Address FROM `tbl_attendance` where DAYOFWEEK(Login_Date) in (1,7) and Month(Login_Date)='$Month' and Year(Login_Date)='$Year' and Emp_Id='$Emp_Id'");
                        foreach ($weekend_attendance_select_query->result() as $row_emp_att_weeknd) {
                            $weekend_att_emp_id = $row_emp_att_weeknd->Emp_Id;
                            $weekend_att_Login_Date1 = $row_emp_att_weeknd->Login_Date;
                            $weekend_att_Login_Date = date("d-m-Y", strtotime($weekend_att_Login_Date1));
                            $weekend_att_Login_Month = date("m", strtotime($weekend_att_Login_Date1));
                            $weekend_att_Login_Year = date("Y", strtotime($weekend_att_Login_Date1));
                            $weekend_att_Login_Time = $row_emp_att_weeknd->Login_Time;
                            $weekend_att_Logout_Date1 = $row_emp_att_weeknd->Logout_Date;
                            $weekend_att_Logout_Date = date("d-m-Y", strtotime($weekend_att_Logout_Date1));
                            $weekend_att_Logout_Time = $row_emp_att_weeknd->Logout_Time;
                            $weekend_att_ShiftName = $row_emp_att_weeknd->Shift_Name;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                <td><?php echo $emp_code . $Emp_Id; ?></td>
                                <td><?php echo "$weekend_att_Login_Date"; ?></td>
                                <td><?php echo "$weekend_att_Login_Time"; ?></td>
                                <td><?php echo "$weekend_att_Logout_Date"; ?></td>
                                <td><?php echo "$weekend_att_Logout_Time"; ?></td>
                                <td><?php echo "$total_hours"; ?></td>
                                <td><?php echo "$weekend_att_ShiftName"; ?></td>                                              
                            </tr>                        
                        </tbody>                    
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>
<!-- Weekend Login  Present End here -->
<!-- LOP details Start here -->
<div class="modal fade custom-width" id="modal-9">
    <div class="modal-dialog" style="width:58%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">No of LOP [ <?php echo "$Emp_No_of_days_LOP"; ?> ]</h4>
            </div>

            <div style="height:250px; width: 100%; overflow-y:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead> 
                    <th>S.No</th>
                    <th>Emp Name</th>
                    <th>Emp Id</th>
                    <th>LOP Date</th>                   
                    <th>Type</th>
                    <th>Comments</th>
                    <th>Approval</th>
                    <th>Reason</th>                    
                    </thead>
                    <tbody> 
                        <?php
                        // Lop Select Query 
                        $i = 1;
                        $lop_select_query = $this->db->query("SELECT Emp_Id,Date,Type,Remarks,Approval,Reason FROM tbl_attendance_mark WHERE Year(Date) = '$Year' and Month(Date) = '$Month' and Emp_Id='$Emp_Id'");
                        foreach ($lop_select_query->result() as $row_emp_lop) {
                            $lop_emp_id = $row_emp_lop->Emp_Id;
                            $lop_emp_date1 = $row_emp_lop->Date;
                            $lop_emp_date = date("d-m-Y", strtotime($lop_emp_date1));
                            $lop_emp_month = date("m", strtotime($lop_emp_date1));
                            $lop_emp_year = date("Y", strtotime($lop_emp_date1));
                            $lop_emp_type = $row_emp_lop->Type;
                            $lop_emp_remarks = $row_emp_lop->Remarks;
                            $lop_emp_approval = $row_emp_lop->Approval;
                            $lop_emp_reason = $row_emp_lop->Reason;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                <td><?php echo $emp_code . $Emp_Id; ?></td>
                                <td><?php echo "$lop_emp_date"; ?></td>
                                <td><?php echo "$lop_emp_type"; ?></td>
                                <td><?php echo "$lop_emp_remarks"; ?></td>
                                <td><?php echo "$lop_emp_approval"; ?></td>
                                <td><?php echo "$lop_emp_reason"; ?></td>                                              
                            </tr>                        
                        </tbody>                    
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>
<!-- LOP details Start here -->

<!-- Employee Leave Taken in particular Month details Start here -->
<div class="modal fade custom-width" id="modal-10">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Total Leaves Taken  <?php //echo "$Emp_No_of_days_Leaves";      ?> </h4>
            </div>

            <div style="height:250px; width: 100%; overflow-y:scroll; ">
                <table class="table table-bordered responsive">                    
                    <thead> 
                    <th>S.No</th>
                    <th>Emp Name</th>
                    <th>Emp Id</th>
                    <th>Reporting To</th>                  
                    <th>Leave Duration</th>
                    <th>Leave Pattern</th>
                    <th>Leave From</th>                    
                    <th>Leave To</th>
                    <th>No of Days</th> 
                    <th>Reason</th>
                    <th>Approval</th>                                        
                    </thead>
                    <tbody> 
                        <?php
                        // Lop Select Query 
                        $j = 1;
                        //$leave_select_query = $this->db->query("SELECT Emp_Id,Date,Type,Remarks,Approval,Reason FROM tbl_attendance_mark WHERE Year(Date) = '$Year' and Month(Date) = '$Month' and Emp_Id='$Emp_Id'");
                        $leave_select_query = $this->db->query("SELECT Employee_Id,Leave_Type,Reason,Leave_Duration,Leave_Pattern,Leave_From,Leave_To,Approval,Remarks FROM `tbl_leaves` WHERE `Employee_Id`='$Emp_Id' and Leave_From>='$Year-$Month-01' and Leave_From<='$Year-$Month-31'");
                        foreach ($leave_select_query->result() as $row_emp_leave) {
                            $leave_emp_id = $row_emp_leave->Employee_Id;
                            $leave_emp_reason = $row_emp_leave->Reason;
                            $Leave_Duration = $row_emp_leave->Leave_Duration;
                            $leave_pattern = $row_emp_leave->Leave_Pattern;
                            $Leave_From1 = $row_emp_leave->Leave_From;
                            $Leave_From = date("d-m-Y", strtotime($Leave_From1));
                            $Leave_To1 = $row_emp_leave->Leave_To;
                            $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                            $Leave_To = date("d-M-Y", strtotime($Leave_To1));

                            if ($Leave_Duration == "Full Day") {
                                $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                $No_days = $interval->format("%a");
                            } else {
                                $No_days = 0.5;
                            }
                            $leave_approval = $row_emp_leave->Approval;
                            ?>
                            <tr>
                                <td><?php echo $j; ?></td>
                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                <td><?php echo $emp_code . $Emp_Id; ?></td>
                                <td><?php echo "$emp_reporting_name"; ?></td>                                                                              
                                <td><?php echo "$Leave_Duration"; ?></td>
                                <td><?php echo "$leave_pattern"; ?></td>                                              
                                <td><?php echo "$Leave_From"; ?></td>
                                <td><?php echo "$Leave_To"; ?></td>
                                <td><?php echo "$No_days Days"; ?></td>
                                <td><?php echo "$leave_emp_reason"; ?></td>
                                <td><?php echo "$leave_approval"; ?></td>                                
                            </tr>                        
                        </tbody>                    
                        <?php
                        $j++;
                    }
                    ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>
<!-- Employee Leave Taken in particular Month details End here -->



<script>
    $(document).ready(function () {
        $('#payslip_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                employee_list: $('#employee_list').val(),
                year_list: $('#year_list').val(),
                month_list: $('#month_list').val()
            };
            $.ajax({
                url: "<?php echo site_url('Payslip/Employeepreview') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    $("#salary_table_wrapper").hide();
                    $('#employee_payslip').html(msg);
                }
            });
        });

    });
</script>