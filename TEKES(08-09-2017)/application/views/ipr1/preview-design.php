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
		
        /*$Monthly_Weekend_Working = $row_payslip->Weekend_Working;
        $Monthly_Leave_Taken = $row_payslip->Total_Leave_Taken;*/
        


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
            $Emp_Doj = $row_employee->Emp_Doj;
            $doj = date("d-m-Y", strtotime($Emp_Doj));
        }        

        $this->db->where('Employee_Id', $employee_id);
        $q_career = $this->db->get('tbl_employee_career');
        foreach ($q_career->Result() as $row_career) {
            $department_id = $row_career->Department_Id;
            $designation_id = $row_career->Designation_Id;
        } 
        
        $this->db->where('Designation_Id', $designation_id);
        $q_designation = $this->db->get('tbl_designation');
        foreach ($q_designation->Result() as $row_designation) {
            $designation_name = $row_designation->Designation_Name;
        }
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
            $eff_production_date = $row_emp_eff->Production_Date;             
            //$eff_production_date = date("d-m-Y", strtotime($eff_production_date1));            
            $eff_client_name = $row_emp_eff->Client_Name;            
            $eff_sub_process = $row_emp_eff->Sub_Process;
            $eff_order_type = $row_emp_eff->Order_Type;
            //$eff_teamwork_flexibility = $row_emp_eff->Teamwork_Flexibility;
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
    //}
     

    /*if ($emp_effeciency <0.25) {
            $Eff_Rating=1;
        }
        if ($emp_effeciency > 0.25 && $emp_effeciency <= 0.50) {
            $Eff_Rating= 2;
        }
        if ($emp_effeciency > 0.50 && $emp_effeciency <= 0.65) {
            $Eff_Rating= 2.5;
        }
        if ($emp_effeciency > 0.65 && $emp_effeciency <= 0.9) {
            $Eff_Rating= 3;
        }
        if ($emp_effeciency >0.9 && $emp_effeciency <= 1.01) {
            $Eff_Rating= 4;
        }
        if ($emp_effeciency >1.01) {
            $Eff_Rating= 5;
        }
       else
       {
               $Eff_Rating= 0;           
       }*/
        
      
        

        // tbl_accuracy table get Value Start here
        $this->db->where('Employee_Id', $employee_id);
        $q_emp_acc = $this->db->get('tbl_accuracy');
        foreach ($q_emp_eff->result() as $row_emp_acc) {
            $A_Id = $row_emp_acc->A_Id;
            $acc_employee_id = $row_emp_acc->Employee_Id;                        
            $acc_year = $row_emp_acc->Year;                  
            $acc_month1 = $row_emp_acc->Month;            
            $acc_month = date('F', mktime(0, 0, 0, $acc_month1, 10));
            $acc_Order_Number = $row_emp_acc->Order_Number; 
            /*$acc_Client_Name = $row_emp_acc->Client_Name;
            $acc_Subprocess_Name = $row_emp_acc->Subprocess_Name;
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
			$acc_analysis = $row_emp_acc->Analysis;
            $acc_production_date = $row_emp_acc->Production_Date;             
            //$acc_production_date = date("d-m-Y", strtotime($acc_production_date1));*/
            
                     
        }
        // tbl_accuracy table get Value End here
        
		// My code Jegathis told tbl_iprmaster1 Import data Start here
        $this->db->where('IPR_Id', $employee_id);
        $q_emp_ipr = $this->db->get('tbl_iprmaster1');
        foreach ($q_emp_ipr->result() as $row_emp_ipr) {
            $IPR_Id = $row_emp_ipr->IPR_Id;
            $Emp_Id1 = $row_emp_ipr->Emp_Id;                        
            $Employee_Name = $row_emp_ipr->Employee_Name;
            $Month1 = $row_payslip->Month;
            $MonthName1 = date('F', mktime(0, 0, 0, $Month1, 10));
            $Year1 = $row_emp_ipr->Year;
            
			$Efficiency = $row_emp_ipr->Efficiency;
            $Accuracy = $row_emp_ipr->Accuracy;
            $Punctuality = $row_emp_ipr->Punctuality;
            $Process_Knowledge = $row_emp_ipr->Process_Knowledge;
            $Teamwork_Flexibility = $row_emp_ipr->Teamwork_Flexibility;
            $Total_Efficiency = $row_emp_ipr->Total_Efficiency;
            $Total_Accuracy = $row_emp_ipr->Total_Accuracy;
            $Internal = $row_emp_ipr->Internal;
            $External = $row_emp_ipr->External;
            $Total_Orders = $row_emp_ipr->Total_Orders;
            $Total_Errors = $row_emp_ipr->Total_Errors;
            $Attendance = $row_emp_ipr->Attendance;
            $Leaves = $row_emp_ipr->Leaves;
            
			$Weekend_Working = $row_emp_ipr->Weekend_Working;
            $LOP = $row_emp_ipr->LOP;
            $Overall_Score = $row_emp_ipr->Overall_Score;
            $Final_Rating = $row_emp_ipr->Final_Rating;
        }
        // My code tbl_iprmaster1 Import data End here
        
        
        
        
              
        
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

            <script>
                function myFunction() {
                    window.print();
                }
            </script>
            <script src="<?php echo site_url('js/neon-custom.js') ?>"></script>

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
                        <h4><b>IPR for the month of <?php echo $MonthName . " " . $Year; ?></b></h4>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3" style="margin-left:-60px;margin-top:45px">
                        <?php //if ($user_role == 2 || $user_role == 6) { ?>

                        <?php //} ?>
                        <a onclick="myFunction()" href="<?php //echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Pay slip.mrt&param1=' . $Payslip_Id)  ?>" class="btn btn-default btn-sm btn-icon icon-left">
                            <i class="entypo-print"></i>
                            Print
                        </a>                    
                    </div>             
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tbody>                                
                            <tr>
                                <td><b>Name of the Employee :</b></td>
                                <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                <td><b>Employee Code : </b></td>
                                <td><?php echo $emp_code . $Emp_Id; ?></td>
                            </tr>
                            <tr>
                                <td><b>Month & Year : </b></td>
                                <td><?php echo $MonthName . " " . $Year; ?></td>
                                <td><b>Date of Joining :</b></td>
                                <td><?php echo $doj; ?></td>                                                                       
                            </tr>
                            <tr>
                            <td><b>Department :</b></td>
                            <td><?php echo $department_name; ?></td>
                            <td><b>Designation :</b></td>
                            <td><?php echo $designation_name; ?></td>                                                                        
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <style>
                #Efficiency{
                    height: 100px;
                    width: 20px;
                }
            </style>
    
            <table class="table table-bordered datatable">
                <thead style="margin-right: 10px;">
                    <tr>
                        <th>Performance</th>
                        <th>Rating</th>                                
                        <th>Supporting score if any</th>
                        <th>Comments</th>                               
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Efficiency - Weightage 30%</td>                    
                        <td>
                            <a style="cursor:pointer; text-decoration:underline;" title="Efficiency Calculation" href="javascript:;" onclick="jQuery('#modal-1').modal('show');" ><?php echo $Eff_Rating; ?></a>
                        </td>
                        <td>Efficiency : <?php echo $emp_effeciency; ?>% <br> Total Orders : 14 <?php //$Total_Orders; ?></td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"></textarea></td>                                                          
                    </tr>
                    <tr>
                        <td>Accuracy - Weightage 30%</td>
                        <td>
                            <a style="cursor:pointer; text-decoration:underline;" title="Accuracy Calculation" href="javascript:;" onclick="jQuery('#modal-2').modal('show');" ><?php echo $Accuracy; ?></a>                        
                        </td>
                        <td>Accuracy : <?php echo $Total_Accuracy; ?>% <br>Internal : <?php echo "$Internal"; ?> <br> External : <?php echo "$External"; ?></td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"></textarea></td>                                                                        
                    </tr>
                    <tr>
                        <td>Punctuality & Discipline – Weightage 10%</td>
                        <td><?php echo "$Punctuality"; ?></td>
                        <td>Present : <?php echo "$No_Of_Days_Present"; ?> <br> Leave : 2 <br> LOP :<?php echo "$No_Of_Days_LOP"; ?> </td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"></textarea></td>                                                                        
                    </tr>
                    <tr>
                        <td>Process Knowledge - Weightage 20%</td>
                        <td><?php echo "$pk_rating"; ?></td>
                        <td></td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"><?php echo "$pk_comments"; ?></textarea></td>                                                               
                    </tr>
                    <tr>
                        <td>Team Work & Flexibility – Weightage 10%</td>
                        <td><?php echo "$tw_rating"; ?></td>
                        <td>Week End Login : 4</td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"><?php echo "$tw_comments"; ?></textarea></td>                                                         
                    </tr>                
                    <tr style="background-color:lightblue;">
                        <td><b>Overall Score</b></td>
                        <td>
                            <a style="cursor:pointer; text-decoration:underline;" title="Overall Score Calculation" href="javascript:;" onclick="jQuery('#modal-3').modal('show');"><b class="btn btn-success">80<?php //$Overall_Score; ?> %</b></a>
                        </td>
                        <td><b>Final Rating</b></td>
                        <td><b class="btn btn-success"><?php echo "$Final_Rating"; ?></b></td>                                                                        
                    </tr>                
                    <!--<tr>
                        <td><b>Total Earnings</b></td>
                        <td></td>
                        <td><b>Total Deductions</b></td>
                        <td></td>                                                                        
                    </tr>                                                        
                    <tr>
                        <td></td>
                        <td></td>  
                        <td><b>Net Amount</b></td>
                        <td><p class="pull-right"></p></td>                                                                        
                    </tr>-->                                                    
                </tbody>                         
            </table>
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tbody>                              
                            <tr>
                                <td><b>Comments from Supervisor : </b></td>
                                <td><textarea rows="2" cols="50" placeholder="Comments"></textarea></td>                                                                                                  
                            </tr>
                            <tr>
                                <td><b>Employee Signature :</b> <br/> <textarea rows="1" cols="30" placeholder="Signature"></textarea></td>
                                <td><b>Reviewer’s Signature :</b> <br/> <textarea rows="1" cols="30" placeholder="Signature"></textarea>  </td>

                            </tr>
                            <tr>                           
                                <td><b>Date :</b>  <input type="text" size="27" placeholder="01-08-2017"></td>
                                <td><b>Date :</b>  <input type="text" size="27" placeholder="01-08-2017"></td>
                            </tr>                   
                        </tbody>                  
                    </table>
                    <span class="pull-left" style="margin:5px;"> DRN/HR/Appraisal</span> <span class="pull-right" style="margin: 5px;">Ver 1.0</span>                
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

<!-- Efficiency Calculation Start here-->
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
<!-- Efficiency Calculation End here-->
<!-- Accuracy Calculation Start here-->          
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
<!-- Accuracy Calculation End here-->
<!-- Overall Score Calculation Start here-->          
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
                            <td>(Team Work & Flexibility Weightage 10%) * 10</td>                            
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
<!-- Overall Score Calculation End here-->