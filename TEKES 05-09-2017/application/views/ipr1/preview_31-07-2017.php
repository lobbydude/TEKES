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
        // $Salary_Arrears = $row_payslip->Salary_Arrears;
        $Night_Shift_Allowance = $row_payslip->Night_Shift_Allowance;
        $Weekend_Allowance = $row_payslip->Weekend_Allowance;
        $Referral_Bonus = $row_payslip->Referral_Bonus;
        $Additional_Others = $row_payslip->Additional_Others;
        $Incentives = $row_payslip->Incentives;
        $Total_Income = $row_payslip->Total_Income;
        $Total_Earnings = $row_payslip->Total_Earnings;
        $Net_Amount = $row_payslip->Net_Amount;
        $Amount_Words = $row_payslip->Amount_Words;

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


        // My code tbl_iprmaster1 Import data Start here
        $this->db->where('IPR_Id', $employee_id);
        $q_emp_ipr = $this->db->get('tbl_iprmaster1');
        foreach ($q_emp_ipr->result() as $row_emp_ipr) {
            $IPR_Id = $row_emp_ipr->IPR_Id;
            //$Emp_Id = $row_emp_ipr->Emp_Id;                        
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
        
        
        
        
        
    }
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
                            <a style="cursor:pointer; text-decoration:underline;" title="Efficiency Calculation" href="javascript:;" onclick="jQuery('#modal-1').modal('show');" ><?php echo $Efficiency; ?></a>
                        </td>
                        <td>Efficiency : <?php echo $Total_Efficiency; ?>% <br> Total Orders : 14 <?php //$Total_Orders; ?></td>
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
                        <td>Present : <?php echo "$Attendance"; ?> <br> Leave : <?php echo "$Leaves"; ?> <br> LOP :<?php echo "$No_Of_Days_LOP"; ?> </td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"></textarea></td>                                                                        
                    </tr>
                    <tr>
                        <td>Process Knowledge - Weightage 20%</td>
                        <td><?php echo "$Process_Knowledge"; ?></td>
                        <td></td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"></textarea></td>                                                               
                    </tr>
                    <tr>
                        <td>Team Work & Flexibility – Weightage 10%</td>
                        <td><?php echo "$Teamwork_Flexibility"; ?></td>
                        <td>Week End Login : <?php echo "$Weekend_Working"; ?></td>
                        <td><textarea rows="2" cols="30" placeholder="Comments"></textarea></td>                                                         
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
                                <td><b>Date :</b>  <input type="text" name="pin" maxlength="4" size="27" placeholder="30-07-2017"></td>
                                <td><b>Date :</b>  <input type="text" name="pin" maxlength="4" size="27" placeholder="30-07-2017"></td>
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