<?php
$employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
$m = (int) $Month;
$get_data = array(
    'Emp_Id' => $employee_id,
    'Month' => $m,
    'Year' => $Year,
    'Status' => 1
);
$this->db->where($get_data);
$q_payslip = $this->db->get('tbl_payslip_arrear');
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
        $No_Of_Days_Arrear = $row_payslip->No_Of_Days_Arrear;
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
    }
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
                <h4><b>Payslip for the month of <?php echo $MonthName . " " . $Year;?></b></h4>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-3" style="margin-left:-60px;margin-top:45px">
                <a href="<?php echo site_url('Payslip/Editarrear_payslip/' . $Payslip_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                    <i class="entypo-pencil"></i>
                    Edit
                </a>
                <a data-toggle='modal' href='#delete_arrear_payslip' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Arrear_Payslip(<?php echo $Payslip_Id; ?>)">
                    <i class="entypo-cancel"></i>
                    Delete
                </a>
                <a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Arrearpayslip.mrt&param1=' . $Payslip_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                    <i class="entypo-download"></i>
                    Download
                </a>
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
                        <td><?php echo $No_Of_Days_Arrear; ?> Days</td>                                                                                                    </tr>
                    <tr>
                        <td><b>Employee Code : </b></td>
                        <td><?php echo $emp_code . $Emp_Id; ?></td>
                        <td><b>Pan Card No : </b></td>
                        <td><?php echo $Emp_PANcard; ?></td>                                                                        
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
                        <td></td>
                        <td></td>
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
                <td>Skill Allowance</td>
                <td><p class="pull-right"><?php echo $Skill_Allowance; ?></p></td>
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
                <td><p class="pull-right"><?php echo $Deduction_Others; ?></p></td>                                                                            
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
                <td>Others</td>
                <td><p class="pull-right"><?php echo $Additional_Others; ?></p></td>
                <td></td>
                <td></td>                                                                          
            </tr>
            <tr>
                <td><b>Total Earnings</b></td>
                <td><p class="pull-right"><?php echo $Total_Earnings; ?></p></td>
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

    <!-- Delete Arrear Payslip Start Here -->

    <div class="modal fade" id="delete_arrear_payslip">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header info-bar">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Delete Arrear Payslip</h3>
                </div>
                <form role="form" id="deletearrear_payslip_form" name="deletearrear_payslip_form" method="post" class="validate">

                </form>
            </div>
        </div>
    </div>
    <script>
        function delete_Arrear_Payslip(id) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Payslip/Deletearrear_payslip') ?>",
                data: "payslip_id=" + id,
                cache: false,
                success: function (html) {
                    $("#deletearrear_payslip_form").html(html);
                }
            });
        }
    </script>

    <!-- Delete Arrear Payslip End Here -->
<?php } else { ?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <p>No Records Found.</p>
        </div>
    </div>
<?php } ?>

