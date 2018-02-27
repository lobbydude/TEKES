<?php
$payslip_id = $this->uri->segment(3);
$user_role = $this->session->userdata('user_role');
$this->db->where('Payslip_Id', $payslip_id);
$q_payslip = $this->db->get('tbl_payslip_arrear');
foreach ($q_payslip->result() as $row_payslip) {
    $Emp_Id = $row_payslip->Emp_Id;
    $employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
    $year = $row_payslip->Year;
    $month = $row_payslip->Month;
    $no_of_days = $row_payslip->No_Of_Days;
    $no_of_days_arrear = $row_payslip->No_Of_Days_Arrear;
    $additional_insurance = $row_payslip->Additioanl_Insurance;
    $income_tax = $row_payslip->Income_Tax;
    $deduction_others = $row_payslip->Deduction_Others;
    $salary_advance = $row_payslip->Salary_Advance;
    $attendance = $row_payslip->Attendance_Allowance;
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
?>

<script>
    $(document).ready(function () {
        $('#editpaysliparrear_form').submit(function (e) {
            e.preventDefault();
            var emp_no = $('#edit_paysliparrear_emp_no').val();
            var formdata = {
                edit_payslip_id: $('#edit_payslip_id').val(),
                edit_paysliparrear_emp_no: $('#edit_paysliparrear_emp_no').val(),
                edit_paysliparrear_mctc: $('#edit_paysliparrear_mctc').val(),
                edit_paysliparrear_year: $('#edit_paysliparrear_year').val(),
                edit_paysliparrear_month: $('#edit_paysliparrear_month').val(),
                edit_paysliparrear_nodays: $('#edit_paysliparrear_nodays').val(),
                edit_paysliparrear_present: $('#edit_paysliparrear_present').val(),
                edit_paysliparrear_additionalinsurance: $('#edit_paysliparrear_additionalinsurance').val(),
                edit_paysliparrear_incometax: $('#edit_paysliparrear_incometax').val(),
                edit_paysliparrear_deductionothers: $('#edit_paysliparrear_deductionothers').val(),
                edit_paysliparrear_salaryadvance: $('#edit_paysliparrear_salaryadvance').val(),
                edit_paysliparrear_attendance: $('#edit_paysliparrear_attendance').val(),
                edit_paysliparrear_nightshift: $('#edit_paysliparrear_nightshift').val(),
                edit_paysliparrear_weekend: $('#edit_paysliparrear_weekend').val(),
                edit_paysliparrear_referralbonus: $('#edit_paysliparrear_referralbonus').val(),
                edit_paysliparrear_additionalothers: $('#edit_paysliparrear_additionalothers').val(),
                edit_paysliparrear_incentives: $('#edit_paysliparrear_incentives').val()
            };
            $.ajax({
                url: "<?php echo site_url('Payslip/edit_arrear_payslip') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#editpaysliparrear_exists').hide();
                        $('#editpaysliparrear_success').hide();
                        $('#editpaysliparrear_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#editpaysliparrear_exists').hide();
                        $('#editpaysliparrear_error').hide();
                        $('#editpaysliparrear_success').show();
                    }
                    if (msg.trim() == 'exists') {
                        $('#editpaysliparrear_error').hide();
                        $('#editpaysliparrear_success').hide();
                        $('#editpaysliparrear_exists').show();
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
                    <form role="form" id="editpaysliparrear_form" name="editpaysliparrear_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="editpaysliparrear_exists" class="alert alert-info" style="display:none;">Arrear details already exists.</div>
                                    <div id="editpaysliparrear_success" class="alert alert-success" style="display:none;">Arrear details updated successfully.</div>
                                    <div id="editpaysliparrear_error" class="alert alert-danger" style="display:none;">Failed to update arrear details.</div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_payslip_id" id="edit_payslip_id" value="<?php echo $payslip_id; ?>">
                            <input type="hidden" name="edit_paysliparrear_emp_no" id="edit_paysliparrear_emp_no" value="<?php echo $employee_id; ?>"> 
                            <input type="hidden" name="edit_paysliparrear_mctc" id="edit_paysliparrear_mctc" value="<?php echo $Monthly_CTC; ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Year</label>
                                        <div class="input-group">
                                            <?php
                                            define('DOB_YEAR_START', 2010);
                                            $current_year = date('Y');
                                            ?>
                                            <select id="edit_paysliparrear_year" name="edit_paysliparrear_year" class="round">
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
                                            <select class="round" id="edit_paysliparrear_month" name="edit_paysliparrear_month">
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
                                            <input type="text" name="edit_paysliparrear_nodays" id="edit_paysliparrear_nodays" class="form-control" data-validate="required,number" data-message-required="Please enter No. of days." value="<?php echo $no_of_days; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">No. of Arrear Days</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_present" id="edit_paysliparrear_present" class="form-control" data-validate="required,number" data-message-required="Please enter No. of Arrear days" value="<?php echo $no_of_days_arrear; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Additional Insurance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_additionalinsurance" id="edit_paysliparrear_additionalinsurance" class="form-control" data-validate="required,number" data-message-required="Please enter additional insurance." value="<?php echo $additional_insurance; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Income Tax</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_incometax" id="edit_paysliparrear_incometax" class="form-control" data-validate="required,number" data-message-required="Please enter Income Tax." value="<?php echo $income_tax; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Deduction Others</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_deductionothers" id="edit_paysliparrear_deductionothers" class="form-control" data-validate="required,number" data-message-required="Please enter deduction others." value="<?php echo $deduction_others; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Salary Advance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_salaryadvance" id="edit_paysliparrear_salaryadvance" class="form-control" data-validate="required,number" data-message-required="Please enter salary advance." value="<?php echo $salary_advance; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Attendance Allowance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_attendance" id="edit_paysliparrear_attendance" class="form-control" data-validate="required,number" data-message-required="Please enter attendance allowance." value="<?php echo $attendance; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Night Shift Allowance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_nightshift" id="edit_paysliparrear_nightshift" class="form-control" data-validate="required,number" data-message-required="Please enter nightshift allowance." value="<?php echo $night_shift; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Weekend Allowance</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_weekend" id="edit_paysliparrear_weekend" class="form-control" data-validate="required,number" data-message-required="Please enter weekend allowance." value="<?php echo $weekend; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Referral Bonus</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_referralbonus" id="edit_paysliparrear_referralbonus" class="form-control" data-validate="required,number" data-message-required="Please enter referral bonus." value="<?php echo $referal_bonus; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Additional Others</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_additionalothers" id="edit_paysliparrear_additionalothers" class="form-control" data-validate="required,number" data-message-required="Please enter additional others." value="<?php echo $additional_others; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Incentives</label>
                                        <div class="input-group">
                                            <input type="text" name="edit_paysliparrear_incentives" id="edit_paysliparrear_incentives" class="form-control" data-validate="required,number" data-message-required="Please enter incentives." value="<?php echo $incentives; ?>">
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