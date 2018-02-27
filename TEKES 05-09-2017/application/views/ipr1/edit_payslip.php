<?php
$payslip_id = $this->uri->segment(3);
$user_role = $this->session->userdata('user_role');
$this->db->where('Payslip_Id', $payslip_id);
$q_payslip = $this->db->get('tbl_payslip_info');
foreach ($q_payslip->result() as $row_payslip) {
    $Emp_Id = $row_payslip->Emp_Id;
    $employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
    $year = $row_payslip->Year;
    $month = $row_payslip->Month;
    $no_of_days = $row_payslip->No_Of_Days;
    $desc_lop = $row_payslip->Disc_LOP;
    $leave_balance_lop = $row_payslip->Leave_Balance_LOP;
    $lop_offered = $row_payslip->LOP_Offered_Date;
    $no_of_days_lop = $row_payslip->No_Of_Days_LOP;
    $additional_insurance = $row_payslip->Additioanl_Insurance;
    $income_tax = $row_payslip->Income_Tax;
    $deduction_others = $row_payslip->Deduction_Others;
    $salary_advance = $row_payslip->Salary_Advance;
    $attendance = $row_payslip->Attendance_Allowance;
    // $salary_arrears = $row_payslip->Salary_Arrears;
    $night_shift = $row_payslip->Night_Shift_Allowance;
    $weekend = $row_payslip->Weekend_Allowance;
    $referal_bonus = $row_payslip->Referral_Bonus;
    $additional_others = $row_payslip->Additional_Others;
    $incentives = $row_payslip->Incentives;

    $this->db->where('Emp_Number', $employee_id);
    $q_employee = $this->db->get('tbl_employee');
    foreach ($q_employee->result() as $row_employee) {
        $employee_name = $row_employee->Emp_FirstName;
        $employee_name .= " " . $row_employee->Emp_LastName;
        $employee_name .= " " . $row_employee->Emp_MiddleName;
    }

    $this->db->where('employee_number', $employee_id);
    $q_employee_code = $this->db->get('tbl_emp_code');
    foreach ($q_employee_code->result() as $row_employee_code) {
        $employee_code = $row_employee_code->employee_code;
    }
}
$this->db->order_by('Sal_Id', 'desc');
$this->db->limit(1);
$data_salary = array(
    'Employee_Id' => $employee_id,
    'Status' => 1
);
$this->db->where($data_salary);
$q_salary = $this->db->get('tbl_salary_info');
foreach ($q_salary->Result() as $row_salary) {
    $Monthly_CTC = number_format(($row_salary->Monthly_CTC), 2, '.', '');
    $C_CTC = number_format(($row_salary->C_CTC), 2, '.', '');
}

$get_arrear_data = array(
    'Emp_Id' => $employee_id,
    'Month' => $month,
    'Year' => $year,
    'Status' => 1
);
$this->db->where($get_arrear_data);
$q_arrear_payslip = $this->db->get('tbl_payslip_arrear');
$count_arrear_payslip = $q_arrear_payslip->num_rows();
if ($count_arrear_payslip == 1) {
    foreach ($q_arrear_payslip->result() as $row_arrear_payslip) {
        $salary_arrears = $row_arrear_payslip->Net_Amount;
    }
} else {
    $salary_arrears = 0;
}
?>

<script>
    $(document).ready(function () {
        $('#editpayslipinfo_form').submit(function (e) {
            e.preventDefault();
            var emp_no = $('#edit_payslipinfo_emp_no').val();
            var formdata = {
                edit_payslip_id: $('#edit_payslip_id').val(),
                edit_payslipinfo_emp_no: $('#edit_payslipinfo_emp_no').val(),
                edit_payslipinfo_mctc: $('#edit_payslipinfo_mctc').val(),
                edit_payslipinfo_year: $('#edit_payslipinfo_year').val(),
                edit_payslipinfo_month: $('#edit_payslipinfo_month').val(),
                edit_payslipinfo_nodays: $('#edit_payslipinfo_nodays').val(),
                edit_payslipinfo_disclop: $('#edit_payslipinfo_disclop').val(),
                edit_payslipinfo_leaveballop: $('#edit_payslipinfo_leaveballop').val(),
                edit_payslipinfo_lopoffered: $('#edit_payslipinfo_lopoffered').val(),
                edit_payslipinfo_additionalinsurance: $('#edit_payslipinfo_additionalinsurance').val(),
                edit_payslipinfo_incometax: $('#edit_payslipinfo_incometax').val(),
                edit_payslipinfo_deductionothers: $('#edit_payslipinfo_deductionothers').val(),
                edit_payslipinfo_salaryadvance: $('#edit_payslipinfo_salaryadvance').val(),
                edit_payslipinfo_attendance: $('#edit_payslipinfo_attendance').val(),
                edit_payslipinfo_salaryarrears: $('#edit_payslipinfo_salaryarrears').val(),
                edit_payslipinfo_nightshift: $('#edit_payslipinfo_nightshift').val(),
                edit_payslipinfo_weekend: $('#edit_payslipinfo_weekend').val(),
                edit_payslipinfo_referralbonus: $('#edit_payslipinfo_referralbonus').val(),
                edit_payslipinfo_additionalothers: $('#edit_payslipinfo_additionalothers').val(),
                edit_payslipinfo_incentives: $('#edit_payslipinfo_incentives').val()
            };
            $.ajax({
                url: "<?php echo site_url('Payslip/edit_payslip') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#editpayslipinfo_exists').hide();
                        $('#editpayslipinfo_success').hide();
                        $('#editpayslipinfo_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#editpayslipinfo_exists').hide();
                        $('#editpayslipinfo_error').hide();
                        $('#editpayslipinfo_success').show();
                    }
                    if (msg.trim() == 'exists') {
                        $('#editpayslipinfo_error').hide();
                        $('#editpayslipinfo_success').hide();
                        $('#editpayslipinfo_exists').show();
                    }
                }

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
                            <h2>Payslip : <?php echo $employee_name . "( " . $employee_code . $employee_id . " )"; ?></h2>
                        </div>
                    </div>
                    <form role="form" id="editpayslipinfo_form" name="editpayslipinfo_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="editpayslipinfo_exists" class="alert alert-info" style="display:none;">Payslip details already exists.</div>
                                    <div id="editpayslipinfo_success" class="alert alert-success" style="display:none;">Payslip details updated successfully.</div>
                                    <div id="editpayslipinfo_error" class="alert alert-danger" style="display:none;">Failed to update payslip details.</div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_payslip_id" id="edit_payslip_id" value="<?php echo $payslip_id; ?>">
                            <input type="hidden" name="edit_payslipinfo_emp_no" id="edit_payslipinfo_emp_no" value="<?php echo $employee_id; ?>"> 
                            <input type="hidden" name="edit_payslipinfo_mctc" id="edit_payslipinfo_mctc" value="<?php echo $Monthly_CTC; ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Year</label>
                                        <div class="input-group">
                                            <?php
                                            define('DOB_YEAR_START', 2010);
                                            $current_year = date('Y');
                                            ?>
                                            <select id="edit_payslipinfo_year" name="edit_payslipinfo_year" class="round">
                                                <?php
                                                for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                                    ?>
                                                    <option value="<?php echo $count; ?>" <?php
                                                if ($count == $year) {
                                                    echo "selected";
                                                }
                                                    ?>><?php echo $count; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Month</label>
                                        <div class="input-group">
                                            <select class="round" id="edit_payslipinfo_month" name="edit_payslipinfo_month">
                                                <?php
                                                for ($m = 1; $m <= 12; $m++) {
                                                    $monthname = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                    ?>
                                                    <option value="<?php echo $m; ?>" <?php
                                                if ($month == $m) {
                                                    echo "selected=selected";
                                                }
                                                    ?>><?php echo $monthname; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">No. of Days</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_nodays" id="edit_payslipinfo_nodays" class="form-control" data-validate="required,number" data-message-required="Please enter No. of days." value="<?php echo $no_of_days; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Disc LOP</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_disclop" id="edit_payslipinfo_disclop" class="form-control" data-validate="required,number" data-message-required="Please enter No. of Lop days" value="<?php echo $desc_lop; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Leave Balance LOP</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_leaveballop" id="edit_payslipinfo_leaveballop" class="form-control" data-validate="required,number" data-message-required="Please enter No. of Lop days" value="<?php echo $leave_balance_lop; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">LOP based Offer date</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_lopoffered" id="edit_payslipinfo_lopoffered" class="form-control" data-validate="required,number" data-message-required="Please enter No. of Lop days" value="<?php echo $lop_offered; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Additional Insurance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_additionalinsurance" id="edit_payslipinfo_additionalinsurance" class="form-control" data-validate="required,number" data-message-required="Please enter additional insurance." value="<?php echo $additional_insurance; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Income Tax</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_incometax" id="edit_payslipinfo_incometax" class="form-control" data-validate="required,number" data-message-required="Please enter Income Tax." value="<?php echo $income_tax; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Deduction Others</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_deductionothers" id="edit_payslipinfo_deductionothers" class="form-control" data-validate="required,number" data-message-required="Please enter deduction others." value="<?php echo $deduction_others; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Salary Advance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_salaryadvance" id="edit_payslipinfo_salaryadvance" class="form-control" data-validate="required,number" data-message-required="Please enter salary advance." value="<?php echo $salary_advance; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Attendance Allowance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_attendance" id="edit_payslipinfo_attendance" class="form-control" data-validate="required,number" data-message-required="Please enter attendance allowance." value="<?php echo $attendance; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Salary Arrears</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_salaryarrears" id="edit_payslipinfo_salaryarrears" class="form-control" data-validate="required,number" data-message-required="Please enter salary arrears." value="<?php echo $salary_arrears; ?>" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Night Shift Allowance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_nightshift" id="edit_payslipinfo_nightshift" class="form-control" data-validate="required,number" data-message-required="Please enter nightshift allowance." value="<?php echo $night_shift; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Weekend Allowance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_weekend" id="edit_payslipinfo_weekend" class="form-control" data-validate="required,number" data-message-required="Please enter weekend allowance." value="<?php echo $weekend; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Referral Bonus</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_referralbonus" id="edit_payslipinfo_referralbonus" class="form-control" data-validate="required,number" data-message-required="Please enter referral bonus." value="<?php echo $referal_bonus; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Additional Others</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_additionalothers" id="edit_payslipinfo_additionalothers" class="form-control" data-validate="required,number" data-message-required="Please enter additional others." value="<?php echo $additional_others; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Incentives</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_payslipinfo_incentives" id="edit_payslipinfo_incentives" class="form-control" data-validate="required,number" data-message-required="Please enter incentives." value="<?php echo $incentives; ?>">
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-default" onclick="window.history.back();">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>