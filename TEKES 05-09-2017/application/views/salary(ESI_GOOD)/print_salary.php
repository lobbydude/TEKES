<?php

$this->db->where('Sal_Id', $salary_id);
$q_salary = $this->db->get('tbl_salary_info');
foreach ($q_salary->result() as $row_salary) {
    $C_CTC = $row_salary->C_CTC;
    $Monthly_CTC = $row_salary->Monthly_CTC;
    $Emp_Id = $row_salary->Employee_Id;
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
if ($Total_Fixed_Gross <= 15000) {
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
if ($Total_Fixed_Gross <= 15000) {
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

if ($Total_Fixed_Gross <= 15000) {
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

$data_emp = array(
    'Emp_Number' => $Emp_Id,
    'Status' => 1
);
$this->db->where($data_emp);
$q_emp = $this->db->get('tbl_employee');
foreach ($q_emp->Result() as $row_emp) {
    $emp_name = $row_emp->Emp_FirstName;
    $emp_name .= " " . $row_emp->Emp_LastName;
    $emp_name .= " " . $row_emp->Emp_MiddleName;
}
$this->db->where('Employee_Id', $Emp_Id);
$q_career = $this->db->get('tbl_employee_career');
foreach ($q_career->Result() as $row_career) {
    $designation_id = $row_career->Designation_Id;
}

$this->db->where('Designation_Id', $designation_id);
$q_designation = $this->db->get('tbl_designation');
foreach ($q_designation->Result() as $row_designation) {
    $designation_name = $row_designation->Designation_Name;
}
$employer_total = $Employer_PF + $Employer_ESI;
$total_cost = $Total_Fixed_Gross + $employer_total;
$Total_Deduction = $Employee_ESI + $Employee_PF + $Professional_Tax + $Insurance;
$contents = "<div id='printsalary_div'>
<h2 align='center' style='font-family:arial;'>Annexure 1.1</h2>
    <table border='1' style='border:1px solid #000'>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td><b>Name</b></td>
            <td colspan='2'>$emp_name</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td><b>Designation</b></td>
            <td colspan='2'>$designation_name</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <th style='border:1px solid #000;width:220px'>Salary Head</th>
            <th style='border:1px solid #000;width:180px'>Per Month (Rs)</th>
            <th style='border:1px solid #000;width:180px'>Per Annum (Rs)</th>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Basic + DA</td>
            <td>" . number_format(round($Basicpay), 2, '.', ',') . "</td>
            <td>" . number_format((round($Basicpay) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>HRA</td>
            <td>" . number_format(round($Hra), 2, '.', ',') . "</td>
            <td>" . number_format((round($Hra) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Conveyance</td>
            <td>" . number_format(round($Conveyance), 2, '.', ',') . "</td>
            <td>" . number_format((round($Conveyance) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:30px;font-family:arial;vertical-align:middle'>
            <td>Children Education Allowance</td>
            <td>" . number_format(round($Child_education), 2, '.', ',') . "</td>
            <td>" . number_format((round($Child_education) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Medical Allowance</td>
            <td>" . number_format(round($Medical), 2, '.', ',') . "</td>
            <td>" . number_format((round($Medical) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Skill Allowance</td>
            <td>" . number_format(round($Skill_allowance), 2, '.', ',') . "</td>
            <td>" . number_format((round($Skill_allowance) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Special Allowance</td>
            <td>" . number_format(round($Special_allowance), 2, '.', ',') . "</td>
            <td>" . number_format((round($Special_allowance) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td style='border:1px solid #000'><b>Fixed Gross</b></td>
            <td style='border:1px solid #000'><b>" . number_format(round($Total_Fixed_Gross), 2, '.', ',') . "</b></td>
            <td style='border:1px solid #000'><b>" . number_format((round($Total_Fixed_Gross) * 12), 2, '.', ',') . "</b></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Employer PF</td>
            <td>" . number_format(round($Employer_PF), 2, '.', ',') . "</td>
            <td>" . number_format((round($Employer_PF) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:30px;font-family:arial;vertical-align:middle'>
            <td>Employer ESIC</td>
            <td>" . number_format(round($Employer_ESI), 2, '.', ',') . "</td>
            <td>" . number_format((round($Employer_ESI) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Ex-Gratia</td>
            <td></td>
            <td></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>L.T.A</td>
            <td></td>
            <td></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Bonus</td>
            <td></td>
            <td></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Leave Encashment</td>
            <td></td>
            <td></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Gratuity</td>
            <td></td>
            <td></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Superannuation</td>
            <td></td>
            <td></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td style='border:1px solid #000'><b>Total</b></td>
            <td style='border:1px solid #000'><b>" . number_format(round($employer_total), 2, '.', ',') . "</b></td>
            <td style='border:1px solid #000'><b>" . number_format((round($employer_total) * 12), 2, '.', ',') . "</b></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td style='border:1px solid #000'><b>COST TO COMPANY (CTC)</b></td>
            <td style='border:1px solid #000'><b>" . number_format(round($total_cost), 2, '.', ',') . "</b></td>
            <td style='border:1px solid #000'><b>" . number_format((round($total_cost) * 12), 2, '.', ',') . "</b></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Employee PF</td>
            <td>" . number_format(round($Employee_PF), 2, '.', ',') . "</td>
            <td>" . number_format((round($Employee_PF) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Employee ESIC</td>
            <td>" . number_format(round($Employee_ESI), 2, '.', ',') . "</td>
            <td>" . number_format((round($Employee_ESI) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Insurance</td>
            <td>" . number_format(round($Insurance), 2, '.', ',') . "</td>
            <td>" . number_format((round($Insurance) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Income Tax</td>
            <td>0.00</td>
            <td>0.00</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td>Professional Tax</td>
            <td>" . number_format(round($Professional_Tax), 2, '.', ',') . "</td>
            <td>" . number_format((round($Professional_Tax) * 12), 2, '.', ',') . "</td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td style='border:1px solid #000'><b>Total Deduction</b></td>
            <td style='border:1px solid #000'><b>" . number_format(round($Total_Deduction), 2, '.', ',') . "</b></td>
            <td style='border:1px solid #000'><b>" . number_format((round($Total_Deduction) * 12), 2, '.', ',') . "</b></td>
        </tr>
        <tr style='height:25px;font-family:arial;vertical-align:middle'>
            <td style='border:1px solid #000'><b>NET TAKE HOME</b></td>
            <td style='border:1px solid #000'><b>" . number_format(round($Net_Salary), 2, '.', ',') . "</b></td>
            <td style='border:1px solid #000'></td>
        </tr>
    </table>
    <p style='font-family:arial;'><b>Note :</b> Any tax liabilities arising out of the remuneration will be deducted as per the Income Tax rules.</p>
</div>";

$filename = "salary.xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="' . $filename . '"');
echo "$contents";
?>