<?php
$this->db->where('Sal_Id', $salary_id);
$q_salary = $this->db->get('tbl_salary_info');
foreach ($q_salary->result() as $row_salary) {
    $Employee_Id = $row_salary->Employee_Id;
    $C_CTC = $row_salary->C_CTC;
    $Monthly_CTC = $row_salary->Monthly_CTC;
    $Performance_Bonus = $row_salary->Performance_Bonus;
    $Salary_Comments = $row_salary->Salary_Comments;
    $original_AnnualCTC = $row_salary->Original_AnnualCTC;
    // Performance Bonus 10% Calculation
    $Bonus = ($C_CTC * 0.1);
    $C_CTC1 = $C_CTC - $Bonus;	
}
$Basic = ($Monthly_CTC * 45) / 100;
if ($Basic >= 8500) {
    $Basicpay = $Basic;
} else {
    $Basicpay = 8500;
}
if ($C_CTC <= 250000) {
    $Hra = ($Basicpay * 10) / 100;
} else {
    $Hra = ($Basicpay * 40) / 100;
}
if ($Basicpay >= 8500) {
    $Conveyance = ($Basicpay * 10) / 100;
} else {
    $Conveyance = 800;
}
if ($C_CTC > 250000) {
    $Medical = 1250;
} else {
    $Medical = 0;
}
$Child_education = 0;
$Special_allowance = 0;
$Employer_PF_Amount = (($Basicpay + $Special_allowance) * 12) / 100;
if ($Employer_PF_Amount >= 1800) {
    $Employer_PF = 1800;
} else {
    $Employer_PF = $Employer_PF_Amount;
}
$Employer_ESI = 0;
$Total_Fixed_Gross = $Monthly_CTC - ($Employer_ESI + $Employer_PF);
if ($Total_Fixed_Gross <= 21000) {
    $Employer_ESI = ($Total_Fixed_Gross * 4.75) / 100;
} else {
    $Employer_ESI = 0;
}
$Total_Fixed_Gross = $Monthly_CTC - ($Employer_ESI + $Employer_PF);
if ($Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical) < 0) {
    $Skill_allowance = 0;
} else {
    $Skill_allowance = $Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical);
}
if ($Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical) < 0) {
    $Skill_allowance = 0;
} else {
    $Skill_allowance = $Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical);
}
if ($Total_Fixed_Gross <= 21000) {
    $Employee_ESI = ($Total_Fixed_Gross * 1.75) / 100;
} else {
    $Employee_ESI = 0;
}
$Employee_PF_Amount = (($Basicpay + $Special_allowance) * 12) / 100;
if ($Employee_PF_Amount >= 1800) {
    $Employee_PF = 1800;
} else {
    $Employee_PF = $Employee_PF_Amount;
}
if ($Total_Fixed_Gross >= 15000) {
    $Professional_Tax = 200;
} else {
    $Professional_Tax = 0;
}
if ($Employee_ESI > 0) {
    $Insurance = 0;
} else {
    $Insurance = 200;
}
$Net_Salary = $Total_Fixed_Gross - ($Employee_ESI + $Employee_PF + $Professional_Tax + $Insurance);
?>
<div class="modal-body">
    <div class="row">          
        <?php // Performance Bonus 10% deducted in Particular Employees only
        if($Employee_Id=="0009" || $Employee_Id =="0011" || $Employee_Id=="0018" || $Employee_Id=="0023" || $Employee_Id =="0038" || $Employee_Id =="0058" || $Employee_Id =="0064" || $Employee_Id =="0106" || $Employee_Id =="0156"){
            ?>        	
        <div class="col-md-3">
            <div class="form-group">
                <strong>Original CTC : </strong><?php echo $original_AnnualCTC; ?>
            </div>
        </div>      
      <?php } ?>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Current CTC : </strong><?php echo $C_CTC; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Monthly CTC : </strong><?php echo $Monthly_CTC; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Basic + DA : </strong><?php echo $Basicpay; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <strong>HRA : </strong><?php echo $Hra; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Conveyance : </strong><?php echo $Conveyance; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Medical : </strong><?php echo $Medical; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <strong>Child Education : </strong><?php echo $Child_education; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Special Allowance : </strong><?php echo $Special_allowance; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Skill Allowance : </strong><?php echo $Skill_allowance; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <strong>Employer ESI : </strong><?php echo $Employer_ESI; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Employer PF : </strong><?php echo $Employer_PF; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Total Fixed Gross : </strong><?php echo $Total_Fixed_Gross;?>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <strong>Employee ESI : </strong><?php echo $Employee_ESI; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Employee PF : </strong><?php echo $Employee_PF; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Professional Tax : </strong><?php echo $Professional_Tax; ?>               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <strong>Insurance : </strong><?php echo $Insurance; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <strong>Net Salary : </strong><?php echo number_format(round($Net_Salary), 2, '.', ','); ?>
            </div>
        </div>
	<?php // Performance Bonus 10% deducted in Particular Employees only
        if($Employee_Id=="0009" || $Employee_Id =="0011" || $Employee_Id=="0018" || $Employee_Id=="0023" || $Employee_Id =="0038" || $Employee_Id =="0058" || $Employee_Id =="0064" || $Employee_Id =="0106" || $Employee_Id =="0156"){
            ?>        	
        <div class="col-md-6">
            <div class="form-group">
                <strong>Performance Bonus 10% Deduction : </strong><?php echo $Performance_Bonus; ?>
            </div>
        </div>      
      <?php } ?>
    </div>
	<div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <strong>Salary Comments: </strong><?php echo $Salary_Comments; ?>
            </div>
        </div> 
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>