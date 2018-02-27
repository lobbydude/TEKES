<?php
$employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
$m = (int) $Month;
$get_data = array(
    'Emp_Id' => $employee_id,
    'Month' => $m,
    'Year' => $Year
);
$this->db->where($get_data);
$q = $this->db->get('tbl_payslip');
$count_payslip = $q->num_rows();
if ($count_payslip != 0) {
    foreach ($q->result() as $row) {
        $Payslip_Id = $row->Payslip_Id;
        $No_Of_Days_Worked = $row->No_Of_Days_Worked;
        $No_Of_Days_LOP = $row->No_Of_Days_LOP;
        $Basic = $row->Basic;
        $HRA = $row->HRA;
        $Conveyance = $row->Conveyance;
        $Medical_Allowance = $row->Medical_Allowance;
        $Special_Allowance = $row->Special_Allowance;
        $Attendance_Allowance = $row->Attendance_Allowance;
        $Weekend_Allowance = $row->Weekend_Allowance;
        $Night_Shift_Allowance = $row->Night_Shift_Allowance;
        $Referral_Bonus = $row->Referral_Bonus;
        $Incentives = $row->Incentives;
        $Arrears = $row->Arrears;
		$Additional_others=$row->Additional_Others;
        $Total_Gross = $row->Total_Gross;
        $PF_Employee = $row->PF_Employee;
        $ESI_Employee = $row->ESI_Employee;
        $Insurance = $row->Insurance;
        $Salary_Advance = $row->Salary_Advance;
        $Professional_Tax = $row->Professional_Tax;
        $Income_Tax = $row->Income_Tax;
		 $Deduction_others=$row->Deduction_Others;
        $Total_Deductions = $row->Total_Deductions;
        $Net_Amount = $row->Net_Amount;
        $Amount_Words = $row->Amount_Words;
    }

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
    ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-3"></div>                           
            <div class="col-sm-2">
                <img src="<?php echo site_url('images/drn.png'); ?>"> 
            </div>
            <div class="col-sm-4" style="margin-left:-60px;margin-top:27px">
                <p>
                    <b>DRN DEFINITE SOLUTIONS PVT LTD</b><br>
                    No. 16, Lakshya Towers, 4th Floor, 5th Block, Koramangala<br>
                    Bangalore, Karnataka, India Pin - 560 095.<br> 
                    Tel: 080 65691240 , Email : info@drnds.com
                </p>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-2" style="margin-left:-60px;margin-top:45px">
                <a class="btn btn-primary" target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Payslip.mrt&param1=' . $Payslip_Id) ?>">Download</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>                                
                    <tr>
                        <td><b>Name of the Employees :</b></td>
                        <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                        <td><b>No. of Days worked : </b></td>
                        <td><?php echo $No_Of_Days_Worked; ?> Days</td>                                                                                                    </tr>
                    <tr>
                        <td><b>Employee Code : </b></td>
                        <td><?php echo $emp_code . $Emp_Id; ?></td>
                        <td><b>No. of Days LOP : </b></td>
                        <td><?php echo $No_Of_Days_LOP; ?></td>                                                                        
                    </tr>
                    <tr>
                        <td><b>Designation :</b></td>
                        <td><?php echo $designation_name; ?></td>
                        <td><b>PF No : </b></td>
                        <td><?php echo $Emp_PFno; ?></td>                                                                        
                    </tr>
                    <tr>
                        <td><b>Date of Joining :</b></td>
                        <td><?php echo $doj; ?></td>
                        <td><b>UAN No :</b></td>
                        <td><?php echo $Emp_UANno; ?></td>                                                                        
                    </tr>
                    <tr>
                        <td><b>Department :</b></td>
                        <td><?php echo $department_name; ?></td>
                        <td><b>ESIC No :</b></td>
                        <td><?php echo $Emp_ESI; ?></td>                                                                        
                    </tr>
                    <tr>
                        <td><b>Pan Card No : </b></td>
                        <td><?php echo $Emp_PANcard; ?></td>
                        <td><b>Bank : ICICI / Acc No :</b></td>
                        <td><?php echo $Emp_Accno; ?></td>                                                                        
                    </tr>                                    
                </tbody>
            </table>
        </div>
    </div>

    <table class="table table-bordered datatable">
        <thead style="margin-right: 10px;">
            <tr>
                <th>Particulars</th>
                <th>Amount in Rs</th>                                
                <th>Deductions</th>
                <th>Amount in Rs</th>                               
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic + DA</td>
                <td><p class="pull-right"><?php echo $Basic; ?></p></td>
                <td>PF Employee</td>
                <td><p class="pull-right"><?php echo $PF_Employee ?></p></td>                                                                        
            </tr>
            <tr>
                <td>HRA</td>
                <td><p class="pull-right"><?php echo $HRA; ?></p></td>
                <td>ESI Employee</td>
                <td><p class="pull-right"><?php echo $ESI_Employee; ?></p></td>                                                                        
            </tr>
            <tr>
                <td>Conveyance</td>
                <td><p class="pull-right"><?php echo $Conveyance; ?></p></td>
                <td>Insurance</td>
                <td><p class="pull-right"><?php echo $Insurance; ?></p></td>                                                                        
            </tr>
            <tr>
                <td>Medical Allowance</td>
                <td><p class="pull-right"><?php echo $Medical_Allowance; ?></p></td>
                <td>Salary Advance</td>
                <td><p class="pull-right"><?php echo $Salary_Advance; ?></p></td>                                                                        
            </tr>
            <tr>
                <td>Special Allowance</td>
                <td><p class="pull-right"><?php echo $Special_Allowance; ?></p></td>
                <td>Professional Tax</td>
                <td><p class="pull-right"><?php echo $Professional_Tax; ?></p></td>                                                                        
            </tr>
            <tr>
                <td>Attendance Allowance</td>
                <td><p class="pull-right"><?php echo $Attendance_Allowance; ?></p></td>
                <td>Income Tax</td>
                <td><p class="pull-right"><?php echo $Income_Tax; ?></p></td>                                                                        
            </tr>
            <tr>
                <td>Weekend  Allowance</td>
                <td><p class="pull-right"><?php echo $Weekend_Allowance; ?></p></td>
                <td>Others</td>
                <td><p class="pull-right"><?php echo $Deduction_others; ?></p></td>                                                                   
            </tr>
            <tr>
                <td>Night Shift Allowance</td>
                <td><p class="pull-right"><?php echo $Night_Shift_Allowance; ?></p></td>
                <td></td>
                <td></td>                                                                            
            </tr>
            <tr>
                <td>Referral Bonus</td>
                <td><p class="pull-right"><?php echo $Referral_Bonus; ?></p></td>
                <td></td>
                <td></td>                                                                         
            </tr>
            <tr>
                <td>Incentives</td>
                <td><p class="pull-right"><?php echo $Incentives; ?></p></td>
                <td></td>
                <td></td>                                                                        
            </tr>
            <tr>
                <td>Arrears</td>
                <td><p class="pull-right"><?php echo $Arrears; ?></p></td>
                <td></td>
                <td></td>                                                                          
            </tr>
			<tr>
                <td>Others</td>
                <td><p class="pull-right"><?php echo $Additional_others; ?></p></td>
                <td></td>
                <td></td>                                                                          
            </tr>
            <tr>
                <td><b>Total Earnings</b></td>
                <td><p class="pull-right"><?php echo $Total_Gross; ?></p></td>
                <td><b>Total Deductions</b></td>
                <td><p class="pull-right"><?php echo $Total_Deductions; ?></p></td>                                                                        
            </tr>                                                        
            <tr>
                <td></td>
                <td></td>  
                <td><b>Net Amount</b></td>
                <td><p class="pull-right"><?php echo "र.  " . $Net_Amount; ?></p></td>                                                                        
            </tr>                                                    
        </tbody>                         
    </table>
    <div class="row">
        <div class="col-sm-12">
            <p style="margin-left: 10px"><b>( <?php echo $Amount_Words; ?> )</b></p>
        </div>
        <div class="col-sm-9">
            <p style="margin-left: 10px"><b>Note :</b> This is computer generated pay slip hence signature is not required</p>
        </div>
        <div class="col-sm-3">
            <p class="pull-right">** Private & Confidential  **</p>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <p>No Records Found.</p>
        </div>
    </div>
<?php } ?>

