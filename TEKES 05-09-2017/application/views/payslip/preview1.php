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
        $this->db->where('Employee_Id', $employee_id);
        $q_emp_bank = $this->db->get('tbl_employee_bankdetails');
        foreach ($q_emp_bank->result() as $row_emp_bank) {
            $Emp_Accno = $row_emp_bank->Emp_Accno;
            $Emp_PANcard = $row_emp_bank->Emp_PANcard;
            $Emp_UANno = $row_emp_bank->Emp_UANno;
            $Emp_PFno = $row_emp_bank->Emp_PFno;
            $Emp_ESI = $row_emp_bank->Emp_ESI;
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

        $get_arrear_data = array(
            'Emp_Id' => $employee_id,
            'Month' => $m,
            'Year' => $Year,
            'Status' => 1
        );
        $this->db->where($get_arrear_data);
        $q_arrear_payslip = $this->db->get('tbl_payslip_arrear');
        $count_arrear_payslip = $q_arrear_payslip->num_rows();
        if ($count_arrear_payslip == 1) {
            foreach ($q_arrear_payslip->result() as $row_arrear_payslip) {
                $Salary_Arrears = $row_arrear_payslip->Net_Amount;
            }
        } else {
            $Salary_Arrears = 0;
        }
    }
	if($username=="0037" || $username=="0070" || $username=="0135" || $username=="0166" || $username=="0165" ){
		?>
		<div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-8">
               <p style="text-align: center;">No Records Found.</p>
            </div>
        </div>
		<?php
	}else{
            if (($user_role == 1 && ($curr_date_calender > $set_calender_date)) || ($user_role == 3 && ($curr_date_calender > $set_calender_date)) || ($user_role == 4 && ($curr_date_calender > $set_calender_date)) || ($user_role == 7 && ($curr_date_calender > $set_calender_date)) || ($user_role == 5 && ($curr_date_calender > $set_calender_date)) || $user_role == 2 || $user_role == 6) {
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-2"></div>                           
                <div class="col-sm-2">
                    <img src="<?php echo site_url('images/drn.png'); ?>"> 
                </div>
                <div class="col-sm-5" style="margin-left:-60px;margin-top:27px">
                    <h3>DRN DEFINITE SOLUTIONS PVT LTD</h3>
                    <p>
                        No. 16, Lakshya Towers, 4th Floor, 5th Block, Koramangala<br>
                        Bangalore, Karnataka, India Pin - 560 095.<br> 
                        Tel: 080 65691240 , Email : accounts@drnds.com
                    </p>
                    <h4><b>IPR for the month of <?php echo $MonthName . " " . $Year; ?></b></h4>
                </div>
                <div class="col-sm-1"></div>
                <!--<div class="col-sm-3" style="margin-left:-60px;margin-top:45px">
				<?php //if ($user_role == 2 || $user_role == 6) { ?>
                    <a href="<?php //echo site_url('Payslip/Editpayslip/' . $Payslip_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                    <a data-toggle='modal' href='#delete_payslip' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Payslip(<?php //echo $Payslip_Id; ?>)">
                        <i class="entypo-cancel"></i>
                        Delete
                    </a>
				<?php //} ?>
                    <a target="_blank" href="<?php //echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Pay slip.mrt&param1=' . $Payslip_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-download"></i>
                        Download
                    </a>
                </div>-->
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
                    <td>Efficiency</td>
                    <td>2.5</td>
                    <td>Efficiency: 55% <br> Total Orders: 492</td>
                    <td><p class="pull-right"></p></td>                                                                        
                </tr>
                <tr>
                    <td>Accuracy</td>
                    <td>4</td>
                    <td>99.80% <br>Internal: 0 <br> External: 1 </td>
                    <td><p class="pull-right"></p></td>                                                                        
                </tr>
                <tr>
                    <td>Punctuality & Discipline</td>
                    <td>2</td>
                    <td>Present: 21 <br> Leave: 4 <br> LOP: 0 </td>
                    <td><p class="pull-right"></p></td>                                                                        
                </tr>
                <tr>
                    <td>Process Knowledge</td>
                    <td>3</td>
                    <td></td>
                    <td><p class="pull-right"></p></td>                                                                        
                </tr>
                <tr>
                    <td>Team Work & Flexibility</td>
                    <td>4</td>
                    <td>Week End Login: 2</td>
                    <td><p class="pull-right"></p></td>                                                                        
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td><b>Overall Score</b></td>
                    <td><b>63%</b></td>
                    <td><b>Final Rating</b></td>
                    <td><b>2</b></td>                                                                        
                </tr>                
                <!--<tr>
                    <td><b>Total Earnings</b></td>
                    <td><p class="pull-right"></p></td>
                    <td><b>Total Deductions</b></td>
                    <td><p class="pull-right"></p></td>                                                                        
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
                            <td><textarea rows="2" cols="80" placeholder="Comments"></textarea></td>                                                                                                  
                        </tr>
                        <tr>
                            <td><b>Employee Signature :</b></td>
                            <td><b>Date</b></td>
                            <td><b>Reviewer’s Signature: </b></td>
                            <td><b>Date</b></td>
                        </tr>
                    </tbody>
                </table>
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

