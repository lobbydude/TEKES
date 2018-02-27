<?php
if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Report extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    public function Index() {
        $data = array(
            'title' => 'Report',
            'main_content' => 'report/index'
        );
        $this->load->view('operation/content', $data);
    }

    public function fetch_field() {
        $title = $this->input->post('title');
        $data = array(
            'title_id' => $title
        );
        $this->load->view('report/field', $data);
    }

    public function download() {
        $report_title_list = $this->input->post('report_title_list');
        $report_type = $this->input->post('report_type');
        $period_from1 = $this->input->post('period_from');
        $period_from = date("Y-m-d", strtotime($period_from1));
        $period_to1 = $this->input->post('period_to');
        $period_to = date("Y-m-d", strtotime($period_to1));
        $this->db->where('T_Id', $report_title_list);
        $q_title = $this->db->get('tbl_report_title');
        foreach ($q_title->result() as $row_title) {
            $Title = $row_title->Title;
            $Table_Name = $row_title->Table_Name;
            $Employee_Id_Type = $row_title->Emp_Id_Type;
        }
        $contents = "<table border=1>";
        $fieldlist = $this->input->post('field_list');
        if ($Table_Name == "tbl_attendance") {
            $contents .="<tr>";
            $contents .= "<th rowspan='2'>Employee Id</th>";
            $contents .= "<th rowspan='2'>Employee Name</th>";
            $contents .= "<th rowspan='2'>DOJ</th>";
            $period = new DatePeriod(new DateTime($period_from), new DateInterval('P1D'), new DateTime("$period_to +1 day"));
            $num = 0;
            foreach ($period as $date) {
                $date_n = $date->format("d-M-Y");
                $contents .="<th colspan=" . sizeof($fieldlist) . ">" . $date_n . "</th>";
                $num = $num + 1;
            }
            $contents .="</tr>";
            $contents .="<tr>";
            for ($si = 1; $si <= $num; $si++) {
                for ($i = 0; $i < sizeof($fieldlist); $i++) {
                    $this->db->where('F_Id', $fieldlist[$i]);
                    $q_field_head = $this->db->get('tbl_report_field');
                    foreach ($q_field_head->result() as $row_field_head) {
                        $Field = $row_field_head->Field;
                        $contents .= "<th>" . $Field . "</th>";
                    }
                }
            }
            $contents .="</tr>";
        } else if ($Title == "Leave Monthlywise" && $period_from != "" && $period_to != "") {
            $contents .="<tr>";
            $contents .= "<th rowspan='2'>Employee Id</th>";
            $contents .= "<th rowspan='2'>Employee Name</th>";
            $contents .= "<th rowspan='2'>DOJ</th>";
            $begin = new DateTime($period_from);
            $end = new DateTime($period_to);
            $leave_col = 0;
            while ($begin <= $end) {
                $contents .="<th colspan=" . sizeof($fieldlist) . ">" . $begin->format('M-Y') . "</th>";
                $begin->modify('first day of next month');
                $leave_col = $leave_col + 1;
            }
            $contents .="</tr>";
            $contents .="<tr>";
            for ($li = 1; $li <= $leave_col; $li++) {
                for ($i = 0; $i < sizeof($fieldlist); $i++) {
                    $this->db->where('F_Id', $fieldlist[$i]);
                    $q_field_head = $this->db->get('tbl_report_field');
                    foreach ($q_field_head->result() as $row_field_head) {
                        $Field = $row_field_head->Field;
                        $contents .= "<th>" . $Field . "</th>";
                    }
                }
            }
            $contents .="</tr>";
        } else if ($Table_Name == "tbl_payslip_info") {
            $contents .="<tr>";
            $contents .= "<th>Employee Id</th>";
            $contents .= "<th>Employee Name</th>";
            $contents .= "<th>DOJ</th>";
            $contents .= "<th>Bank Name</th>";
            $contents .= "<th>IFSC Code</th>";
            $contents .= "<th>Account Number</th>";
            $contents .= "<th>Gender</th>";
            $contents .= "<th>Employee Status</th>";
            $contents .= "<th>Designation</th>";
            $contents .= "<th>Department</th>";
            $contents .= "<th>Date Of Birth</th>";
            $contents .= "<th>Marital Status</th>";
            $contents .= "<th>Father's Name</th>";
            $contents .= "<th>PF Number</th>";
            $contents .= "<th>UAN Number</th>";
            $contents .= "<th>ESI</th>";
            $contents .= "<th>PAN Card</th>";
            $contents .= "<th>Annual CTC</th>";
            $contents .= "<th>Monthly CTC</th>";
            $contents .= "<th>Employer ESI</th>";
            $contents .= "<th>Employer PF</th>";
            $contents .= "<th>Basic + DA</th>";
            $contents .= "<th>HRA</th>";
            $contents .= "<th>Conveyance</th>";
            $contents .= "<th>Skill Allowance</th>";
            $contents .= "<th>Medical</th>";
            $contents .= "<th>Child Education</th>";
            $contents .= "<th>Special Allowance</th>";
            $contents .= "<th>Total Fixed Gross</th>";
            $contents .= "<th>No.of Days</th>";
            $contents .= "<th>No.of Days Present</th>";
            $contents .= "<th>No.of Days LOP</th>";
            $contents .= "<th>Basic + DA</th>";
            $contents .= "<th>HRA</th>";
            $contents .= "<th>Conveyance</th>";
            $contents .= "<th>Skill Allowance</th>";
            $contents .= "<th>Medical</th>";
            $contents .= "<th>Child Education</th>";
            $contents .= "<th>Special Allowance</th>";
            $contents .= "<th>Total Actual Gross</th>";
            $contents .= "<th>Employee ESI</th>";
            $contents .= "<th>Employee PF</th>";
            $contents .= "<th>Professional Tax</th>";
            $contents .= "<th>Insurance</th>";
            $contents .= "<th>Income Tax</th>";
            $contents .= "<th>Others Allowance</th>";
            $contents .= "<th>Total Deductions</th>";
            $contents .= "<th>Attendance</th>";
            $contents .= "<th>Salary Arrears</th>";
            $contents .= "<th>Night Shift</th>";
            $contents .= "<th>Weekend Allowance</th>";
            $contents .= "<th>Referral Bonus</th>";
            $contents .= "<th>Other Allowance</th>";
            $contents .= "<th>Total Income</th>";
            $contents .= "<th>Net Salary</th>";
            $contents .= "<th>Per Day Salary</th>";
            $contents .="</tr>";
        } else if ($Table_Name == "tbl_payslip_arrear") {
            $contents .="<tr>";
            $contents .= "<th>Employee Id</th>";
            $contents .= "<th>Employee Name</th>";
            $contents .= "<th>DOJ</th>";
            $contents .= "<th>Bank Name</th>";
            $contents .= "<th>IFSC Code</th>";
            $contents .= "<th>Account Number</th>";
            $contents .= "<th>Gender</th>";
            $contents .= "<th>Employee Status</th>";
            $contents .= "<th>Designation</th>";
            $contents .= "<th>Department</th>";
            $contents .= "<th>Date Of Birth</th>";
            $contents .= "<th>Marital Status</th>";
            $contents .= "<th>Father's Name</th>";
            $contents .= "<th>PF Number</th>";
            $contents .= "<th>UAN Number</th>";
            $contents .= "<th>ESI</th>";
            $contents .= "<th>PAN Card</th>";
            $contents .= "<th>Annual CTC</th>";
            $contents .= "<th>Monthly CTC</th>";
            $contents .= "<th>Employer ESI</th>";
            $contents .= "<th>Employer PF</th>";
            $contents .= "<th>Basic + DA</th>";
            $contents .= "<th>HRA</th>";
            $contents .= "<th>Conveyance</th>";
            $contents .= "<th>Skill Allowance</th>";
            $contents .= "<th>Medical</th>";
            $contents .= "<th>Child Education</th>";
            $contents .= "<th>Special Allowance</th>";
            $contents .= "<th>Total Fixed Gross</th>";
            $contents .= "<th>No.of Days</th>";
            $contents .= "<th>No.of Days Arrears</th>";
            $contents .= "<th>Basic + DA</th>";
            $contents .= "<th>HRA</th>";
            $contents .= "<th>Conveyance</th>";
            $contents .= "<th>Skill Allowance</th>";
            $contents .= "<th>Medical</th>";
            $contents .= "<th>Child Education</th>";
            $contents .= "<th>Special Allowance</th>";
            $contents .= "<th>Total Actual Gross</th>";
            $contents .= "<th>Employee ESI</th>";
            $contents .= "<th>Employee PF</th>";
            $contents .= "<th>Professional Tax</th>";
            $contents .= "<th>Insurance</th>";
            $contents .= "<th>Income Tax</th>";
            $contents .= "<th>Others Allowance</th>";
            $contents .= "<th>Total Deductions</th>";
            $contents .= "<th>Attendance</th>";
            $contents .= "<th>Night Shift</th>";
            $contents .= "<th>Weekend Allowance</th>";
            $contents .= "<th>Referral Bonus</th>";
            $contents .= "<th>Other Allowance</th>";
            $contents .= "<th>Total Income</th>";
            $contents .= "<th>Net Salary</th>";
            $contents .= "<th>Per Day Salary</th>";
            $contents .="</tr>";
        } else if ($Title == "Appraisal - April" || $Title == "Appraisal - October") {
            $contents .="<tr>";
            $contents .= "<th>Employee Id</th>";
            $contents .= "<th>Employee Name</th>";
            $contents .= "<th>DOJ</th>";
            $contents .= "<th>Department</th>";
            $contents .= "<th>Sub Process</th>";
            $contents .= "<th>Designation</th>";
            $contents .= "<th>Vintage</th>";
            $contents .= "<th>Mode</th>";
            $contents .= "<th>Reporting Manager</th>";
            $contents .="</tr>";
        } else {
            $contents .="<tr>";
            $contents .= "<th>Employee Id</th>";
            $contents .= "<th>Employee Name</th>";
            $contents .= "<th>DOJ</th>";
            for ($i = 0; $i < sizeof($fieldlist); $i++) {
                $this->db->where('F_Id', $fieldlist[$i]);
                $q_field_head = $this->db->get('tbl_report_field');
                foreach ($q_field_head->result() as $row_field_head) {
                    $Field = $row_field_head->Field;
                    $contents .= "<th>" . $Field . "</th>";
                }
            }
            $contents .="</tr>";
        }

        if ($report_type == "All") {
            $q_emp = $this->db->get('tbl_employee');
        }
        if ($report_type == "Active") {
            $this->db->where('Status', 1);
            $q_emp = $this->db->get('tbl_employee');
        }
        if ($report_type == "Inactive") {
            $this->db->where('Status', 0);
            $q_emp = $this->db->get('tbl_employee');
        }
        if ($Table_Name == "tbl_payslip_info") {
            $Total_C_CTC = 0;
            $Total_Monthly_CTC = 0;
            $Total_Employer_ESI_Company = 0;
            $Total_Employer_PF_Company = 0;
            $Total_Basicpay_Company = 0;
            $Total_Hra_Company = 0;
            $Total_Conveyance_Company = 0;
            $Total_Skill_allowance_Company = 0;
            $Total_Medical_Company = 0;
            $Total_Child_education_Company = 0;
            $Total_Special_allowance_Company = 0;
            $Total_Total_Fixed_Gross_Company = 0;
            $Total_Basic = 0;
            $Total_HRA = 0;
            $Total_Conveyance = 0;
            $Total_Skill_Allowance = 0;
            $Total_Medical_Allowance = 0;
            $Total_Child_Education = 0;
            $Total_Special_Allowance = 0;
            $Total_Total_Gross = 0;
            $Total_ESI_Employee = 0;
            $Total_PF_Employee = 0;
            $Total_Professional_Tax = 0;
            $Total_Insurance = 0;
            $Total_Income_Tax = 0;
            $Total_Deduction_Others = 0;
            $Total_Total_Deductions = 0;
            $Total_Attendance_Allowance = 0;
            $Total_Salary_Arrears = 0;
            $Total_Night_Shift_Allowance = 0;
            $Total_Weekend_Allowance = 0;
            $Total_Referral_Bonus = 0;
            $Total_Additional_Others = 0;
            $Total_Total_Income = 0;
            $Total_Net_Amount = 0;
            $Total_Per_Day_Salary = 0;
            foreach ($q_emp->result() as $row_emp) {
                $employee_no = $row_emp->Emp_Number;
                $this->db->where('employee_number', $employee_no);
                $q_code = $this->db->get('tbl_emp_code');
                foreach ($q_code->Result() as $row_code) {
                    $emp_code = $row_code->employee_code;
                }
                $emp_name = $row_emp->Emp_FirstName;
                $emp_name .= " " . $row_emp->Emp_LastName;
                $emp_name .= " " . $row_emp->Emp_MiddleName;
                $emp_doj = $row_emp->Emp_Doj;
                $Emp_Gender = $row_emp->Emp_Gender;
                $Emp_Doj = $row_emp->Emp_Doj;
                $doj = date("d-M-Y", strtotime($Emp_Doj));
                $Emp_Mode = $row_emp->Emp_Mode;
                $Emp_Dob = $row_emp->Emp_Dob;
                $dob = date("d-M-Y", strtotime($Emp_Dob));

                $payslip_month = date('m', strtotime($period_from));
                $payslip_year = date('Y', strtotime($period_from));
                $get_payslip_data = array(
                    'Emp_Id' => $employee_no,
                    'Month' => $payslip_month,
                    'Year' => $payslip_year,
                    'Status' => 1
                );
                $this->db->where($get_payslip_data);
                $q_payslip = $this->db->get('tbl_payslip_info');
                $count_payslip = $q_payslip->num_rows();
                if ($count_payslip != 0) {
                    $contents .="<tr>";
                    $contents .="<td>" . $emp_code . $employee_no . "</td>";
                    $contents .= "<td>" . $emp_name . "</td>";
                    if ($emp_doj == "0000-00-00" || $emp_doj == "1970-01-01") {
                        $contents .= "<td></td>";
                    } else {
                        $contents .= "<td>" . date("d-M-Y", strtotime($emp_doj)) . "</td>";
                    }
                    foreach ($q_payslip->result() as $row_payslip) {
                        $Payslip_Id = $row_payslip->Payslip_Id;
                        $Monthly_CTC = $row_payslip->Monthly_CTC;
                        $Month = $row_payslip->Month;
                        $MonthName = date('F', mktime(0, 0, 0, $Month, 10));
                        $Year = $row_payslip->Year;
                        $No_Of_Days = $row_payslip->No_Of_Days;
                        $No_Of_Days_Present = $row_payslip->No_Of_Days_Worked;
                        $No_Of_Days_LOP = $row_payslip->No_Of_Days_LOP;
                        $Basic = str_replace(',', '', $row_payslip->Basic);
                        $HRA = str_replace(',', '', $row_payslip->HRA);
                        $Conveyance = str_replace(',', '', $row_payslip->Conveyance);
                        $Skill_Allowance = str_replace(',', '', $row_payslip->Skill_Allowance);
                        $Medical_Allowance = str_replace(',', '', $row_payslip->Medical_Allowance);
                        $Child_Education = str_replace(',', '', $row_payslip->Child_Education);
                        $Special_Allowance = str_replace(',', '', $row_payslip->Special_Allowance);
                        $Total_Gross = str_replace(',', '', $row_payslip->Total_Gross);
                        $ESI_Employee = str_replace(',', '', $row_payslip->ESI_Employee);
                        $PF_Employee = str_replace(',', '', $row_payslip->PF_Employee);
                        $Professional_Tax = str_replace(',', '', $row_payslip->Professional_Tax);
                        $Insurance = str_replace(',', '', $row_payslip->Insurance);
                        $Income_Tax = str_replace(',', '', $row_payslip->Income_Tax);
                        $Deduction_Others = str_replace(',', '', $row_payslip->Deduction_Others);
                        $Salary_Advance = str_replace(',', '', $row_payslip->Salary_Advance);
                        $Total_Deductions = str_replace(',', '', $row_payslip->Total_Deductions);
                        $Attendance_Allowance = str_replace(',', '', $row_payslip->Attendance_Allowance);
                        $Night_Shift_Allowance = str_replace(',', '', $row_payslip->Night_Shift_Allowance);
                        $Weekend_Allowance = str_replace(',', '', $row_payslip->Weekend_Allowance);
                        $Referral_Bonus = str_replace(',', '', $row_payslip->Referral_Bonus);
                        $Additional_Others = str_replace(',', '', $row_payslip->Additional_Others);
                        $Incentives = str_replace(',', '', $row_payslip->Incentives);
                        $Total_Income = str_replace(',', '', $row_payslip->Total_Income);
                        $Total_Earnings = str_replace(',', '', $row_payslip->Total_Earnings);
                        $Net_Amount = str_replace(',', '', $row_payslip->Net_Amount);
                        $Amount_Words = $row_payslip->Amount_Words;

                        $get_arrear_data = array(
                            'Emp_Id' => $employee_no,
                            'Month' => $payslip_month,
                            'Year' => $payslip_year,
                            'Status' => 1
                        );
                        $this->db->where($get_arrear_data);
                        $q_arrear_payslip = $this->db->get('tbl_payslip_arrear');
                        $count_arrear_payslip = $q_arrear_payslip->num_rows();
                        if ($count_arrear_payslip == 1) {
                            foreach ($q_arrear_payslip->result() as $row_arrear_payslip) {
                                $Salary_Arrears = filter_var(round(str_replace(',', '', $row_arrear_payslip->Net_Amount)), FILTER_SANITIZE_NUMBER_INT);
                            }
                        } else {
                            $Salary_Arrears = 0;
                        }

                        $C_CTC = $Monthly_CTC * 12;
                        $Basic_Company = ($Monthly_CTC * 45) / 100;
                        if ($Basic_Company >= 8500) {
                            $Basicpay_Company = $Basic_Company;
                        } else {
                            $Basicpay_Company = 8500;
                        }
                        if ($C_CTC <= 250000) {
                            $Hra_Company = ($Basicpay_Company * 10) / 100;
                        } else {
                            $Hra_Company = ($Basicpay_Company * 40) / 100;
                        }
                        if ($Basicpay_Company >= 8500) {
                            $Conveyance_Company = ($Basicpay_Company * 10) / 100;
                        } else {
                            $Conveyance_Company = 800;
                        }
                        if ($C_CTC > 250000) {
                            $Medical_Company = 1250;
                        } else {
                            $Medical_Company = 0;
                        }
                        $Child_education_Company = 0;
                        $Special_allowance_Company = 0;
                        $Employer_PF_Amount_Company = (($Basicpay_Company + $Special_allowance_Company) * 12) / 100;
                        if ($Employer_PF_Amount_Company >= 1800) {
                            $Employer_PF_Company = 1800;
                        } else {
                            $Employer_PF_Company = $Employer_PF_Amount_Company;
                        }
                        $Employer_ESI_Company = 0;
                        $Total_Fixed_Gross_Company = $Monthly_CTC - ($Employer_ESI_Company + $Employer_PF_Company);
                        if ($Total_Fixed_Gross_Company <= 21000) {
                            $Employer_ESI_Company = ($Total_Fixed_Gross_Company * 4.75) / 100;
                        } else {
                            $Employer_ESI_Company = 0;
                        }
                        $Total_Fixed_Gross_Company = $Monthly_CTC - ($Employer_ESI_Company + $Employer_PF_Company);
                        if ($Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company) < 0) {
                            $Skill_allowance_Company = 0;
                        } else {
                            $Skill_allowance_Company = $Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company);
                        }
                        if ($Total_Fixed_Gross_Company <= 21000) {
                            $Employer_ESI_Company = ($Total_Fixed_Gross_Company * 4.75) / 100;
                        } else {
                            $Employer_ESI_Company = 0;
                        }
                        $Total_Fixed_Gross_Company = $Monthly_CTC - ($Employer_ESI_Company + $Employer_PF_Company);
                        if ($Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company) < 0) {
                            $Skill_allowance_Company = 0;
                        } else {
                            $Skill_allowance_Company = $Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company);
                        }
                        $Per_Day_Salary = round(str_replace(',', '', ($Total_Fixed_Gross_Company / 30)));

                        $this->db->where('employee_number', $employee_no);
                        $q_code = $this->db->get('tbl_emp_code');
                        foreach ($q_code->result() as $row_code) {
                            $emp_code = $row_code->employee_code;
                        }

                        $this->db->where('Employee_Id', $employee_no);
                        $q_emp_bank = $this->db->get('tbl_employee_bankdetails');
                        foreach ($q_emp_bank->result() as $row_emp_bank) {
                            $Emp_Bankname = $row_emp_bank->Emp_Bankname;
                            $Emp_Accno = $row_emp_bank->Emp_Accno;
                            $Emp_IFSCcode = $row_emp_bank->Emp_IFSCcode;
                            $Emp_PANcard = $row_emp_bank->Emp_PANcard;
                            $Emp_UANno = $row_emp_bank->Emp_UANno;
                            $Emp_PFno = $row_emp_bank->Emp_PFno;
                            $Emp_ESI = $row_emp_bank->Emp_ESI;
                        }

                        $this->db->where('Employee_Id', $employee_no);
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
                        $this->db->where('Employee_Id', $employee_no);
                        $q_personal = $this->db->get('tbl_employee_personal');
                        foreach ($q_personal->result() as $row_personal) {
                            $Emp_Marrial = $row_personal->Emp_Marrial;
                        }

                        $family_data = array(
                            'Employee_Id' => $employee_no,
                            'Relationship' => 'Father',
                            'Status' => 1
                        );
                        $this->db->where($family_data);
                        $q_family = $this->db->get('tbl_employee_family');
                        $count_family = $q_family->num_rows();
                        if ($count_family > 0) {
                            foreach ($q_family->result() as $row_family) {
                                $father_name = $row_family->Name;
                            }
                        } else {
                            $father_name = "";
                        }

                        $contents .= "<td>" . $Emp_Bankname . "</td>";
                        $contents .= "<td>" . $Emp_IFSCcode . "</td>";
                        $contents .= "<td>" . $Emp_Accno . "</td>";
                        $contents .= "<td>" . $Emp_Gender . "</td>";
                        $contents .= "<td>" . $Emp_Mode . "</td>";
                        $contents .= "<td>" . $designation_name . "</td>";
                        $contents .= "<td>" . $department_name . "</td>";
                        $contents .= "<td>" . $dob . "</td>";
                        $contents .= "<td>" . $Emp_Marrial . "</td>";
                        $contents .= "<td>" . $father_name . "</td>";
                        $contents .= "<td>" . $Emp_PFno . "</td>";
                        $contents .= "<td>" . $Emp_UANno . "</td>";
                        $contents .= "<td>" . $Emp_ESI . "</td>";
                        $contents .= "<td>" . $Emp_PANcard . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $C_CTC) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Monthly_CTC) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Employer_ESI_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Employer_PF_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Basicpay_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Hra_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Conveyance_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Skill_allowance_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Medical_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Child_education_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Special_allowance_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Fixed_Gross_Company) . "</td>";
                        $contents .= "<td>" . $No_Of_Days . "</td>";
                        $contents .= "<td>" . $No_Of_Days_Present . "</td>";
                        $contents .= "<td>" . $No_Of_Days_LOP . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Basic) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $HRA) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Conveyance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Skill_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Medical_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Child_Education) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Special_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Gross) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $ESI_Employee) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $PF_Employee) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Professional_Tax) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Insurance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Income_Tax) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Deduction_Others) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Deductions) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Attendance_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Salary_Arrears) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Night_Shift_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Weekend_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Referral_Bonus) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Additional_Others) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Income) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Net_Amount) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Per_Day_Salary) . "</td>";

                        $Total_C_CTC = $Total_C_CTC + $C_CTC;
                        $Total_Monthly_CTC = $Total_Monthly_CTC + $Monthly_CTC;
                        $Total_Employer_ESI_Company = $Total_Employer_ESI_Company + $Employer_ESI_Company;
                        $Total_Employer_PF_Company = $Total_Employer_PF_Company + $Employer_PF_Company;
                        $Total_Basicpay_Company = $Total_Basicpay_Company + $Basicpay_Company;
                        $Total_Hra_Company = $Total_Hra_Company + $Hra_Company;
                        $Total_Conveyance_Company = $Total_Conveyance_Company + $Conveyance_Company;
                        $Total_Skill_allowance_Company = $Total_Skill_allowance_Company + $Skill_allowance_Company;
                        $Total_Medical_Company = $Total_Medical_Company + $Medical_Company;
                        $Total_Child_education_Company = $Total_Child_education_Company + $Child_education_Company;
                        $Total_Special_allowance_Company = $Total_Special_allowance_Company + $Special_allowance_Company;
                        $Total_Total_Fixed_Gross_Company = $Total_Total_Fixed_Gross_Company + $Total_Fixed_Gross_Company;
                        $Total_Basic = $Total_Basic + $Basic;
                        $Total_HRA = $Total_HRA + $HRA;
                        $Total_Conveyance = $Total_Conveyance + $Conveyance;
                        $Total_Skill_Allowance = $Total_Skill_Allowance + $Skill_Allowance;
                        $Total_Medical_Allowance = $Total_Medical_Allowance + $Medical_Allowance;
                        $Total_Child_Education = $Total_Child_Education + $Child_Education;
                        $Total_Special_Allowance = $Total_Special_Allowance + $Special_Allowance;
                        $Total_Total_Gross = $Total_Total_Gross + $Total_Gross;
                        $Total_ESI_Employee = $Total_ESI_Employee + $ESI_Employee;
                        $Total_PF_Employee = $Total_PF_Employee + $PF_Employee;
                        $Total_Professional_Tax = $Total_Professional_Tax + $Professional_Tax;
                        $Total_Insurance = $Total_Insurance + $Insurance;
                        $Total_Income_Tax = $Total_Income_Tax + $Income_Tax;
                        $Total_Deduction_Others = $Total_Deduction_Others + $Deduction_Others;
                        $Total_Total_Deductions = $Total_Total_Deductions + $Total_Deductions;
                        $Total_Attendance_Allowance = $Total_Attendance_Allowance + $Attendance_Allowance;
                        $Total_Salary_Arrears = $Total_Salary_Arrears + $Salary_Arrears;
                        $Total_Night_Shift_Allowance = $Total_Night_Shift_Allowance + $Night_Shift_Allowance;
                        $Total_Weekend_Allowance = $Total_Weekend_Allowance + $Weekend_Allowance;
                        $Total_Referral_Bonus = $Total_Referral_Bonus + $Referral_Bonus;
                        $Total_Additional_Others = $Total_Additional_Others + $Additional_Others;
                        $Total_Total_Income = $Total_Total_Income + $Total_Income;
                        $Total_Net_Amount = $Total_Net_Amount + $Net_Amount;
                        $Total_Per_Day_Salary = $Total_Per_Day_Salary + $Per_Day_Salary;
                    }
                    $contents .= "</tr>";
                }
            }
            $contents .="<tr>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_C_CTC) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Monthly_CTC) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Employer_ESI_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Employer_PF_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Basicpay_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Hra_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Conveyance_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Skill_allowance_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Medical_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Child_education_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Special_allowance_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Fixed_Gross_Company) . "</td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Basic) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_HRA) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Conveyance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Skill_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Medical_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Child_Education) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Special_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Gross) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_ESI_Employee) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_PF_Employee) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Professional_Tax) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Insurance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Income_Tax) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Deduction_Others) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Deductions) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Attendance_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Salary_Arrears) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Night_Shift_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Weekend_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Referral_Bonus) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Additional_Others) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Income) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Net_Amount) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Per_Day_Salary) . "</td>";
            $contents .= "</tr>";
        } 
        else if ($Table_Name == "tbl_payslip_arrear") {
            $Total_C_CTC = 0;
            $Total_Monthly_CTC = 0;
            $Total_Employer_ESI_Company = 0;
            $Total_Employer_PF_Company = 0;
            $Total_Basicpay_Company = 0;
            $Total_Hra_Company = 0;
            $Total_Conveyance_Company = 0;
            $Total_Skill_allowance_Company = 0;
            $Total_Medical_Company = 0;
            $Total_Child_education_Company = 0;
            $Total_Special_allowance_Company = 0;
            $Total_Total_Fixed_Gross_Company = 0;
            $Total_Basic = 0;
            $Total_HRA = 0;
            $Total_Conveyance = 0;
            $Total_Skill_Allowance = 0;
            $Total_Medical_Allowance = 0;
            $Total_Child_Education = 0;
            $Total_Special_Allowance = 0;
            $Total_Total_Gross = 0;
            $Total_ESI_Employee = 0;
            $Total_PF_Employee = 0;
            $Total_Professional_Tax = 0;
            $Total_Insurance = 0;
            $Total_Income_Tax = 0;
            $Total_Deduction_Others = 0;
            $Total_Total_Deductions = 0;
            $Total_Attendance_Allowance = 0;
            $Total_Night_Shift_Allowance = 0;
            $Total_Weekend_Allowance = 0;
            $Total_Referral_Bonus = 0;
            $Total_Additional_Others = 0;
            $Total_Total_Income = 0;
            $Total_Net_Amount = 0;
            $Total_Per_Day_Salary = 0;

            foreach ($q_emp->result() as $row_emp) {
                $employee_no = $row_emp->Emp_Number;
                $this->db->where('employee_number', $employee_no);
                $q_code = $this->db->get('tbl_emp_code');
                foreach ($q_code->Result() as $row_code) {
                    $emp_code = $row_code->employee_code;
                }
                $emp_name = $row_emp->Emp_FirstName;
                $emp_name .= " " . $row_emp->Emp_LastName;
                $emp_name .= " " . $row_emp->Emp_MiddleName;
                $emp_doj = $row_emp->Emp_Doj;

                $Emp_Gender = $row_emp->Emp_Gender;
                $Emp_Doj = $row_emp->Emp_Doj;
                $doj = date("d-M-Y", strtotime($Emp_Doj));
                $Emp_Mode = $row_emp->Emp_Mode;
                $Emp_Dob = $row_emp->Emp_Dob;
                $dob = date("d-M-Y", strtotime($Emp_Dob));

                $arrear_month = date('m', strtotime($period_from));
                $arrear_year = date('Y', strtotime($period_from));
                $get_arrear_data = array(
                    'Emp_Id' => $employee_no,
                    'Month' => $arrear_month,
                    'Year' => $arrear_year,
                    'Status' => 1
                );
                $this->db->where($get_arrear_data);
                $q_payslip = $this->db->get('tbl_payslip_arrear');
                $count_payslip = $q_payslip->num_rows();
                if ($count_payslip != 0) {
                    $contents .="<tr>";
                    $contents .="<td>" . $emp_code . $employee_no . "</td>";
                    $contents .= "<td>" . $emp_name . "</td>";
                    if ($emp_doj == "0000-00-00" || $emp_doj == "1970-01-01") {
                        $contents .= "<td></td>";
                    } else {
                        $contents .= "<td>" . date("d-M-Y", strtotime($emp_doj)) . "</td>";
                    }
                    foreach ($q_payslip->result() as $row_payslip) {
                        $Payslip_Id = $row_payslip->Payslip_Id;
                        $Monthly_CTC = $row_payslip->Monthly_CTC;
                        $Month = $row_payslip->Month;
                        $MonthName = date('F', mktime(0, 0, 0, $Month, 10));
                        $Year = $row_payslip->Year;
                        $No_Of_Days = $row_payslip->No_Of_Days;
                        $No_Of_Days_Present = $row_payslip->No_Of_Days_Arrear;

                        $Basic = str_replace(',', '', $row_payslip->Basic);
                        $HRA = str_replace(',', '', $row_payslip->HRA);
                        $Conveyance = str_replace(',', '', $row_payslip->Conveyance);
                        $Skill_Allowance = str_replace(',', '', $row_payslip->Skill_Allowance);
                        $Medical_Allowance = str_replace(',', '', $row_payslip->Medical_Allowance);
                        $Child_Education = str_replace(',', '', $row_payslip->Child_Education);
                        $Special_Allowance = str_replace(',', '', $row_payslip->Special_Allowance);
                        $Total_Gross = str_replace(',', '', $row_payslip->Total_Gross);
                        $ESI_Employee = str_replace(',', '', $row_payslip->ESI_Employee);
                        $PF_Employee = str_replace(',', '', $row_payslip->PF_Employee);
                        $Professional_Tax = str_replace(',', '', $row_payslip->Professional_Tax);
                        $Insurance = str_replace(',', '', $row_payslip->Insurance);
                        $Income_Tax = str_replace(',', '', $row_payslip->Income_Tax);
                        $Deduction_Others = str_replace(',', '', $row_payslip->Deduction_Others);
                        $Salary_Advance = str_replace(',', '', $row_payslip->Salary_Advance);
                        $Total_Deductions = str_replace(',', '', $row_payslip->Total_Deductions);
                        $Attendance_Allowance = str_replace(',', '', $row_payslip->Attendance_Allowance);
                        $Night_Shift_Allowance = str_replace(',', '', $row_payslip->Night_Shift_Allowance);
                        $Weekend_Allowance = str_replace(',', '', $row_payslip->Weekend_Allowance);
                        $Referral_Bonus = str_replace(',', '', $row_payslip->Referral_Bonus);
                        $Additional_Others = str_replace(',', '', $row_payslip->Additional_Others);
                        $Incentives = str_replace(',', '', $row_payslip->Incentives);
                        $Total_Income = str_replace(',', '', $row_payslip->Total_Income);
                        $Total_Earnings = str_replace(',', '', $row_payslip->Total_Earnings);
                        $Net_Amount = str_replace(',', '', $row_payslip->Net_Amount);
                        $Amount_Words = $row_payslip->Amount_Words;

                        $C_CTC = $Monthly_CTC * 12;
                        $Basic_Company = ($Monthly_CTC * 45) / 100;
                        if ($Basic_Company >= 8500) {
                            $Basicpay_Company = $Basic_Company;
                        } else {
                            $Basicpay_Company = 8500;
                        }
                        if ($C_CTC <= 250000) {
                            $Hra_Company = ($Basicpay_Company * 10) / 100;
                        } else {
                            $Hra_Company = ($Basicpay_Company * 40) / 100;
                        }
                        if ($Basicpay_Company >= 8500) {
                            $Conveyance_Company = ($Basicpay_Company * 10) / 100;
                        } else {
                            $Conveyance_Company = 800;
                        }
                        if ($C_CTC > 250000) {
                            $Medical_Company = 1250;
                        } else {
                            $Medical_Company = 0;
                        }
                        $Child_education_Company = 0;
                        $Special_allowance_Company = 0;
                        $Employer_PF_Amount_Company = (($Basicpay_Company + $Special_allowance_Company) * 12) / 100;
                        if ($Employer_PF_Amount_Company >= 1800) {
                            $Employer_PF_Company = 1800;
                        } else {
                            $Employer_PF_Company = $Employer_PF_Amount_Company;
                        }
                        $Employer_ESI_Company = 0;
                        $Total_Fixed_Gross_Company = $Monthly_CTC - ($Employer_ESI_Company + $Employer_PF_Company);
                        if ($Total_Fixed_Gross_Company <= 21000) {
                            $Employer_ESI_Company = ($Total_Fixed_Gross_Company * 4.75) / 100;
                        } else {
                            $Employer_ESI_Company = 0;
                        }
                        $Total_Fixed_Gross_Company = $Monthly_CTC - ($Employer_ESI_Company + $Employer_PF_Company);
                        if ($Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company) < 0) {
                            $Skill_allowance_Company = 0;
                        } else {
                            $Skill_allowance_Company = $Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company);
                        }
                        if ($Total_Fixed_Gross_Company <= 21000) {
                            $Employer_ESI_Company = ($Total_Fixed_Gross_Company * 4.75) / 100;
                        } else {
                            $Employer_ESI_Company = 0;
                        }
                        $Total_Fixed_Gross_Company = $Monthly_CTC - ($Employer_ESI_Company + $Employer_PF_Company);
                        if ($Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company) < 0) {
                            $Skill_allowance_Company = 0;
                        } else {
                            $Skill_allowance_Company = $Total_Fixed_Gross_Company - ($Basicpay_Company + $Hra_Company + $Conveyance_Company + $Medical_Company);
                        }
                        $Per_Day_Salary = round(str_replace(',', '', ($Total_Fixed_Gross_Company / 30)));

                        $this->db->where('employee_number', $employee_no);
                        $q_code = $this->db->get('tbl_emp_code');
                        foreach ($q_code->result() as $row_code) {
                            $emp_code = $row_code->employee_code;
                        }

                        $this->db->where('Employee_Id', $employee_no);
                        $q_emp_bank = $this->db->get('tbl_employee_bankdetails');
                        foreach ($q_emp_bank->result() as $row_emp_bank) {
                            $Emp_Bankname = $row_emp_bank->Emp_Bankname;
                            $Emp_Accno = $row_emp_bank->Emp_Accno;
                            $Emp_IFSCcode = $row_emp_bank->Emp_IFSCcode;
                            $Emp_PANcard = $row_emp_bank->Emp_PANcard;
                            $Emp_UANno = $row_emp_bank->Emp_UANno;
                            $Emp_PFno = $row_emp_bank->Emp_PFno;
                            $Emp_ESI = $row_emp_bank->Emp_ESI;
                        }

                        $this->db->where('Employee_Id', $employee_no);
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
                        $this->db->where('Employee_Id', $employee_no);
                        $q_personal = $this->db->get('tbl_employee_personal');
                        foreach ($q_personal->result() as $row_personal) {
                            $Emp_Marrial = $row_personal->Emp_Marrial;
                        }

                        $family_data = array(
                            'Employee_Id' => $employee_no,
                            'Relationship' => 'Father',
                            'Status' => 1
                        );
                        $this->db->where($family_data);
                        $q_family = $this->db->get('tbl_employee_family');
                        $count_family = $q_family->num_rows();
                        if ($count_family > 0) {
                            foreach ($q_family->result() as $row_family) {
                                $father_name = $row_family->Name;
                            }
                        } else {
                            $father_name = "";
                        }

                        $contents .= "<td>" . $Emp_Bankname . "</td>";
                        $contents .= "<td>" . $Emp_IFSCcode . "</td>";
                        $contents .= "<td>" . $Emp_Accno . "</td>";
                        $contents .= "<td>" . $Emp_Gender . "</td>";
                        $contents .= "<td>" . $Emp_Mode . "</td>";
                        $contents .= "<td>" . $designation_name . "</td>";
                        $contents .= "<td>" . $department_name . "</td>";
                        $contents .= "<td>" . $dob . "</td>";
                        $contents .= "<td>" . $Emp_Marrial . "</td>";
                        $contents .= "<td>" . $father_name . "</td>";
                        $contents .= "<td>" . $Emp_PFno . "</td>";
                        $contents .= "<td>" . $Emp_UANno . "</td>";
                        $contents .= "<td>" . $Emp_ESI . "</td>";
                        $contents .= "<td>" . $Emp_PANcard . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $C_CTC) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Monthly_CTC) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Employer_ESI_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Employer_PF_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Basicpay_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Hra_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Conveyance_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Skill_allowance_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Medical_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Child_education_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Special_allowance_Company) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Fixed_Gross_Company) . "</td>";
                        $contents .= "<td>" . $No_Of_Days . "</td>";
                        $contents .= "<td>" . $No_Of_Days_Present . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Basic) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $HRA) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Conveyance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Skill_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Medical_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Child_Education) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Special_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Gross) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $ESI_Employee) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $PF_Employee) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Professional_Tax) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Insurance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Income_Tax) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Deduction_Others) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Deductions) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Attendance_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Night_Shift_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Weekend_Allowance) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Referral_Bonus) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Additional_Others) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Total_Income) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Net_Amount) . "</td>";
                        $contents .= "<td>" . sprintf('%.2f', $Per_Day_Salary) . "</td>";

                        $Total_C_CTC = $Total_C_CTC + $C_CTC;
                        $Total_Monthly_CTC = $Total_Monthly_CTC + $Monthly_CTC;
                        $Total_Employer_ESI_Company = $Total_Employer_ESI_Company + $Employer_ESI_Company;
                        $Total_Employer_PF_Company = $Total_Employer_PF_Company + $Employer_PF_Company;
                        $Total_Basicpay_Company = $Total_Basicpay_Company + $Basicpay_Company;
                        $Total_Hra_Company = $Total_Hra_Company + $Hra_Company;
                        $Total_Conveyance_Company = $Total_Conveyance_Company + $Conveyance_Company;
                        $Total_Skill_allowance_Company = $Total_Skill_allowance_Company + $Skill_allowance_Company;
                        $Total_Medical_Company = $Total_Medical_Company + $Medical_Company;
                        $Total_Child_education_Company = $Total_Child_education_Company + $Child_education_Company;
                        $Total_Special_allowance_Company = $Total_Special_allowance_Company + $Special_allowance_Company;
                        $Total_Total_Fixed_Gross_Company = $Total_Total_Fixed_Gross_Company + $Total_Fixed_Gross_Company;
                        $Total_Basic = $Total_Basic + $Basic;
                        $Total_HRA = $Total_HRA + $HRA;
                        $Total_Conveyance = $Total_Conveyance + $Conveyance;
                        $Total_Skill_Allowance = $Total_Skill_Allowance + $Skill_Allowance;
                        $Total_Medical_Allowance = $Total_Medical_Allowance + $Medical_Allowance;
                        $Total_Child_Education = $Total_Child_Education + $Child_Education;
                        $Total_Special_Allowance = $Total_Special_Allowance + $Special_Allowance;
                        $Total_Total_Gross = $Total_Total_Gross + $Total_Gross;
                        $Total_ESI_Employee = $Total_ESI_Employee + $ESI_Employee;
                        $Total_PF_Employee = $Total_PF_Employee + $PF_Employee;
                        $Total_Professional_Tax = $Total_Professional_Tax + $Professional_Tax;
                        $Total_Insurance = $Total_Insurance + $Insurance;
                        $Total_Income_Tax = $Total_Income_Tax + $Income_Tax;
                        $Total_Deduction_Others = $Total_Deduction_Others + $Deduction_Others;
                        $Total_Total_Deductions = $Total_Total_Deductions + $Total_Deductions;
                        $Total_Attendance_Allowance = $Total_Attendance_Allowance + $Attendance_Allowance;
                        $Total_Night_Shift_Allowance = $Total_Night_Shift_Allowance + $Night_Shift_Allowance;
                        $Total_Weekend_Allowance = $Total_Weekend_Allowance + $Weekend_Allowance;
                        $Total_Referral_Bonus = $Total_Referral_Bonus + $Referral_Bonus;
                        $Total_Additional_Others = $Total_Additional_Others + $Additional_Others;
                        $Total_Total_Income = $Total_Total_Income + $Total_Income;
                        $Total_Net_Amount = $Total_Net_Amount + $Net_Amount;
                        $Total_Per_Day_Salary = $Total_Per_Day_Salary + $Per_Day_Salary;
                    }
                    $contents .="</tr>";
                }
            }
            $contents .="<tr>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_C_CTC) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Monthly_CTC) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Employer_ESI_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Employer_PF_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Basicpay_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Hra_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Conveyance_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Skill_allowance_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Medical_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Child_education_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Special_allowance_Company) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Fixed_Gross_Company) . "</td>";
            $contents .= "<td></td>";
            $contents .= "<td></td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Basic) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_HRA) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Conveyance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Skill_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Medical_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Child_Education) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Special_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Gross) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_ESI_Employee) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_PF_Employee) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Professional_Tax) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Insurance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Income_Tax) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Deduction_Others) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Deductions) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Attendance_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Night_Shift_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Weekend_Allowance) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Referral_Bonus) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Additional_Others) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Total_Income) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Net_Amount) . "</td>";
            $contents .= "<td>" . sprintf('%.2f', $Total_Per_Day_Salary) . "</td>";
            $contents .= "</tr>";
        } 
        else if ($Table_Name == "tbl_appraisal") {
            foreach ($q_emp->result() as $row_emp) {
                $employee_no = $row_emp->Emp_Number;
                $this->db->where('employee_number', $employee_no);
                $q_code = $this->db->get('tbl_emp_code');
                foreach ($q_code->Result() as $row_code) {
                    $emp_code = $row_code->employee_code;
                }
                $emp_name = $row_emp->Emp_FirstName;
                $emp_name .= " " . $row_emp->Emp_LastName;
                $emp_name .= " " . $row_emp->Emp_MiddleName;
                $Emp_Doj = $row_emp->Emp_Doj;
                $doj = date("d-M-Y", strtotime($Emp_Doj));
                $Emp_Mode = $row_emp->Emp_Mode;
                $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                $interval = date_diff(date_create(), date_create($doj_no));
                $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                $no_days = $interval->format("%a");
                $no_days_Y = floor($no_days / 365);
                $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                $doj_date = explode("-", $Emp_Doj);
                $doj_year = $doj_date[0];
                $doj_month = $doj_date[1];
                $current_year = date('Y');
                $this->db->where('Employee_Id', $employee_no);
                $q_career = $this->db->get('tbl_employee_career');
                foreach ($q_career->Result() as $row_career) {
                    $branch_id = $row_career->Branch_Id;
                    $department_id = $row_career->Department_Id;
                    $designation_id = $row_career->Designation_Id;
                    $reporting_id = $row_career->Reporting_To;
                }
                $this->db->where('Emp_Number', $reporting_id);
                $q_reporting = $this->db->get('tbl_employee');
                foreach ($q_reporting->Result() as $row_reporting) {
                    $reporting_firstname = $row_reporting->Emp_FirstName;
                    $reporting_middlename = $row_reporting->Emp_MiddleName;
                    $reporting_lastname = $row_reporting->Emp_LastName;
                }
                $this->db->where('Designation_Id', $designation_id);
                $q_designation = $this->db->get('tbl_designation');
                foreach ($q_designation->Result() as $row_designation) {
                    $designation_name = $row_designation->Designation_Name;
                    $client_id = $row_designation->Client_Id;
                }
                $this->db->where('Subdepartment_Id', $client_id);
                $q_subdept = $this->db->get('tbl_subdepartment');
                foreach ($q_subdept->Result() as $row_subdept) {
                    $subdept_name = $row_subdept->Subdepartment_Name;
                }
                $this->db->where('Department_Id', $department_id);
                $q_dept = $this->db->get('tbl_department');
                foreach ($q_dept->result() as $row_dept) {
                    $department_name = $row_dept->Department_Name;
                }
                if ($Title == "Appraisal - April") {
                    if ($doj_month <= 6 && $current_year > $doj_year) {
                        if($no_days_Y<2){
                        $contents .="<tr>";
                        $contents .="<td>" . $emp_code . $employee_no . "</td>";
                        $contents .= "<td>" . $emp_name . "</td>";
                        if ($doj == "0000-00-00" || $doj == "1970-01-01") {
                            $contents .= "<td></td>";
                        } else {
                            $contents .= "<td>" . date("d-M-Y", strtotime($doj)) . "</td>";
                        }
                        $contents .= "<td>" . $department_name . "</td>";
                        $contents .= "<td>" . $subdept_name . "</td>";
                        $contents .= "<td>" . $designation_name . "</td>";
                        $contents .= "<td>" . $no_days_Y . " Years, " . $no_days_M . " Months," . $no_days_D . " Days</td>";
                        if ($Emp_Mode == "Probation") {
                            $contents .= "<td>Probationary</td>";
                        } elseif ($Emp_Mode == "Confirmed") {
                            $contents .= "<td>Permanent</td>";
                        } else {
                            $contents .= "<td></td>";
                        }
                        $contents .= "<td>" . $reporting_firstname . " " . $reporting_lastname . " " . $reporting_middlename . "</td>";
                        $contents .="</tr>";
                        }
                    }
                }
                if ($Title == "Appraisal - October") {
                    if ($doj_month > 6 && $current_year > $doj_year || $no_days_Y>=2) {
                        $contents .="<tr>";
                        $contents .="<td>" . $emp_code . $employee_no . "</td>";
                        $contents .= "<td>" . $emp_name . "</td>";
                        if ($doj == "0000-00-00" || $doj == "1970-01-01") {
                            $contents .= "<td></td>";
                        } else {
                            $contents .= "<td>" . date("d-M-Y", strtotime($doj)) . "</td>";
                        }
                        $contents .= "<td>" . $department_name . "</td>";
                        $contents .= "<td>" . $subdept_name . "</td>";
                        $contents .= "<td>" . $designation_name . "</td>";
                        $contents .= "<td>" . $no_days_Y . " Years, " . $no_days_M . " Months," . $no_days_D . " Days</td>";
                        if ($Emp_Mode == "Probation") {
                            $contents .= "<td>Probationary</td>";
                        } elseif ($Emp_Mode == "Confirmed") {
                            $contents .= "<td>Permanent</td>";
                        } else {
                            $contents .= "<td></td>";
                        }
                        $contents .= "<td>" . $reporting_firstname . " " . $reporting_lastname . " " . $reporting_middlename . "</td>";
                        $contents .="</tr>";
                    }
                }
            }
        } else {
            foreach ($q_emp->result() as $row_emp) {
                $employee_no = $row_emp->Emp_Number;
                $this->db->where('employee_number', $employee_no);
                $q_code = $this->db->get('tbl_emp_code');
                foreach ($q_code->Result() as $row_code) {
                    $emp_code = $row_code->employee_code;
                }
                $emp_name = $row_emp->Emp_FirstName;
                $emp_name .= " " . $row_emp->Emp_LastName;
                $emp_name .= " " . $row_emp->Emp_MiddleName;
                $emp_doj = $row_emp->Emp_Doj;
                $emp_gender = $row_emp->Emp_Gender;

                if ($Table_Name == "tbl_attendance") {
                    $contents .="<tr>";
                    $contents .="<td>" . $emp_code . $employee_no . "</td>";
                    $contents .= "<td>" . $emp_name . "</td>";
                    if ($emp_doj == "0000-00-00" || $emp_doj == "1970-01-01") {
                        $contents .= "<td></td>";
                    } else {
                        $contents .= "<td>" . date("d-M-Y", strtotime($emp_doj)) . "</td>";
                    }
                    /* For Employee Attendance Info */
                    foreach ($period as $date) {
                        for ($j = 0; $j < sizeof($fieldlist); $j++) {
                            $this->db->where('F_Id', $fieldlist[$j]);
                            $q_field_content = $this->db->get('tbl_report_field');
                            foreach ($q_field_content->result() as $row_field_content) {
                                $Field_Name = $row_field_content->Field;
                                $Field_Type = $row_field_content->Field_Type;

                                $dates_month_1 = $date->format("Y-m-d");
                                $data_shift_all = array(
                                    'Employee_Id' => $employee_no,
                                    'Date' => $dates_month_1,
                                    'Status' => 1
                                );
                                $this->db->where($data_shift_all);
                                $q_shift_all = $this->db->get('tbl_shift_allocate');
                                $count_shift_all = $q_shift_all->num_rows();
                                if ($Field_Name == "Shift") {
                                    if ($count_shift_all == 1) {
                                        foreach ($q_shift_all->result() as $row_shift_all) {
                                            $Shift_Id = $row_shift_all->Shift_Id;
                                        }
                                        $data_shift = array(
                                            'Shift_Id' => $Shift_Id,
                                            'Status' => 1
                                        );
                                        $this->db->where($data_shift);
                                        $q_shift = $this->db->get('tbl_shift_details');
                                        foreach ($q_shift->result() as $row_shift) {
                                            $Shift_Name = $row_shift->Shift_Name;
                                            $Shift_From1 = $row_shift->Shift_From;
                                            $Shift_From = date("H:i", strtotime($Shift_From1));
                                            $Shift_To1 = $row_shift->Shift_To;
                                            $Shift_To = date("H:i", strtotime($Shift_To1));
                                        }
                                        $contents .="<td style = 'background-color:#a95c73;color:#fff;border:1px solid #000;text-align:center'>" . $Shift_Name . "(" . $Shift_From . ":" . $Shift_To . ")" . "</td>";
                                    } else {
                                        $contents .="<td></td>";
                                    }
                                } if ($Field_Name == "Login Time" || $Field_Name == "Logout Time" || $Field_Name == "Total Hours" || $Field_Name == "Late Hours" || $Field_Name == "Early Hours" || $Field_Name == "Remarks") {
                                    $date_1 = new DateTime($dates_month_1);
                                    $dat_no_1 = $date_1->format("N");
                                    if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                                        $data_in_weekend = array(
                                            'Emp_Id' => $employee_no,
                                            'Login_Date' => $dates_month_1,
                                            'Status' => 1
                                        );
                                        $this->db->where($data_in_weekend);
                                        $q_in_weekend = $this->db->get('tbl_attendance');
                                        $count_in_weekend = $q_in_weekend->num_rows();
                                        if ($count_in_weekend == 1) {
                                            foreach ($q_in_weekend->result() as $row_in_weekend) {
                                                $A_Id_in_weekend = $row_in_weekend->A_Id;
                                                $Login_Date1_weekend = $row_in_weekend->Login_Date;
                                                $Login_Date_weekend = date("d-m-Y", strtotime($Login_Date1_weekend));
                                                $Login_Time_weekend = $row_in_weekend->Login_Time;
                                                $shift_name_weekend = $row_in_weekend->Shift_Name;
                                                $Logout_Date1_weekend = $row_in_weekend->Logout_Date;
                                                $Logout_Date_weekend = date("d-m-Y", strtotime($Logout_Date1_weekend));
                                                $Logout_Time_weekend = $row_in_weekend->Logout_Time;
												$comments = $row_in_weekend->Comments;
												
                                                $h1_weekend = strtotime($Login_Time_weekend);
                                                $h2_weekend = strtotime($Logout_Time_weekend);
                                                $seconds_weekend = $h2_weekend - $h1_weekend;
                                                if ($Logout_Time_weekend == "" || $Logout_Time_weekend == "00:00:00") {
                                                    $total_hours_weekend = "";
                                                } else {
                                                    $total_hours_weekend = gmdate("H:i:s", $seconds_weekend);
                                                }
                                                $min_time_weekend = "04:30:00";

                                                $shift_24_hour_format_weekend = date("H:i:s", strtotime("$Shift_From1"));
                                                $to_time_weekend = strtotime("$Login_Date1_weekend $shift_24_hour_format_weekend");
                                                $from_time_weekend = strtotime("$Login_Date1_weekend $Login_Time_weekend");
                                                $diff_total_mins_weekend = round(abs($to_time_weekend - $from_time_weekend) / 60, 2) . " minute";
                                                $diff_hours_weekend = floor($diff_total_mins_weekend / 60);
                                                $diff_minutes_weekend = $diff_total_mins_weekend % 60;

                                                if ($total_hours_weekend > $min_time_weekend) {
                                                    if ($shift_name_weekend == "NIGHT -1" || $shift_name_weekend == "NIGHT -2") {
                                                        if ($Field_Name == "Login Time") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$Login_Time_weekend";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Field_Name == "Logout Time") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$Logout_Time_weekend";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Field_Name == "Total Hours") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$total_hours_weekend";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Shift_Name != "") {
                                                            if ($Field_Name == "Late Hours") {
                                                                if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time_weekend)) {
                                                                    $contents .="<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    $contents .="$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                    $contents .="</td>";
                                                                } else {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
                                                            if ($Field_Name == "Early Hours") {
                                                                if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time_weekend)) {
                                                                    $contents .="<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    $contents .="$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                    $contents .="</td>";
                                                                } else {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($Field_Name == "Late Hours") {
                                                                $contents .="<td></td>";
                                                            }
                                                            if ($Field_Name == "Early Hours") {
                                                                $contents .="<td></td>";
                                                            }
                                                        }
														if ($Field_Name == "Remarks") {
                                                            $contents .="<td style = 'color:#000;border:1px solid #000;text-align:center'>";
                                                            $contents .="$comments";
                                                            $contents .="</td>";
                                                        }
                                                    } else {
                                                        if ($Field_Name == "Login Time") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$Login_Time_weekend";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Field_Name == "Logout Time") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$Logout_Time_weekend";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Field_Name == "Total Hours") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$total_hours_weekend";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Shift_Name != "") {
                                                            if ($Field_Name == "Late Hours") {
                                                                if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time_weekend)) {
                                                                    $contents .="<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    $contents .="$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                    $contents .="</td>";
                                                                } else {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
                                                            if ($Field_Name == "Early Hours") {
                                                                if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time_weekend)) {
                                                                    $contents .="<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    $contents .="$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                    $contents .="</td>";
                                                                } else {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($Field_Name == "Late Hours") {
                                                                $contents .="<td></td>";
                                                            }
                                                            if ($Field_Name == "Early Hours") {
                                                                $contents .="<td></td>";
                                                            }
                                                        }
														if ($Field_Name == "Remarks") {
                                                            $contents .="<td style = 'color:#000;border:1px solid #000;text-align:center'>";
                                                            $contents .="$comments";
                                                            $contents .="</td>";
                                                        }
                                                    }
                                                } else {
                                                    if ($Field_Name == "Login Time") {
                                                        $contents .="<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                        $contents .="$Login_Time_weekend";
                                                        $contents .="</td>";
                                                    }
                                                    if ($Field_Name == "Logout Time") {
                                                        $contents .="<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                        $contents .="$Logout_Time_weekend";
                                                        $contents .="</td>";
                                                    }
                                                    if ($Field_Name == "Total Hours") {
                                                        $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                        $contents .="$total_hours_weekend";
                                                        $contents .="</td>";
                                                    }
                                                    if ($Shift_Name != "") {
                                                        if ($Field_Name == "Late Hours") {
                                                            if (strtotime($shift_24_hour_format_weekend) < strtotime($Login_Time_weekend)) {
                                                                $contents .="<td style = 'background-color:#FF4500;border:1px solid #000;text-align:center'>";
                                                                $contents .="$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                $contents .="</td>";
                                                            } else {
                                                                $contents .="<td></td>";
                                                            }
                                                        }
                                                        if ($Field_Name == "Early Hours") {
                                                            if (strtotime($shift_24_hour_format_weekend) > strtotime($Login_Time_weekend)) {
                                                                $contents .="<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$diff_hours_weekend H : $diff_minutes_weekend M";
                                                                $contents .="</td>";
                                                            } else {
                                                                $contents .="<td></td>";
                                                            }
                                                        }
                                                    } else {
                                                        if ($Field_Name == "Late Hours") {
                                                            $contents .="<td></td>";
                                                        }
                                                        if ($Field_Name == "Early Hours") {
                                                            $contents .="<td></td>";
                                                        }
                                                    }
													if ($Field_Name == "Remarks") {
                                                            $contents .="<td style = 'color:#000;border:1px solid #000;text-align:center'>";
                                                            $contents .="$comments";
                                                            $contents .="</td>";
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($dat_no_1 == 6) {
                                                if ($Field_Name == "Login Time") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SAT</td>";
                                                }
                                                if ($Field_Name == "Logout Time") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SAT</td>";
                                                }
                                                if ($Field_Name == "Total Hours") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SAT</td>";
                                                }
                                                if ($Field_Name == "Late Hours") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SAT</td>";
                                                }
                                                if ($Field_Name == "Early Hours") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SAT</td>";
                                                }
												if ($Field_Name == "Remarks") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SAT</td>";
                                                }
                                            }if ($dat_no_1 == 7) {
                                                if ($Field_Name == "Login Time") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SUN</td>";
                                                }
                                                if ($Field_Name == "Logout Time") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SUN</td>";
                                                }
                                                if ($Field_Name == "Total Hours") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SUN</td>";
                                                }
                                                if ($Field_Name == "Late Hours") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SUN</td>";
                                                }
                                                if ($Field_Name == "Early Hours") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SUN</td>";
                                                }
												if ($Field_Name == "Remarks") {
                                                    $contents .="<td style = 'background-color:#fad839;border:1px solid #000;text-align:center'>SUN</td>";
                                                }
                                            }
                                        }
                                    } else {
                                        $holiday_data = array(
                                            'Holiday_Date' => $dates_month_1,
                                            'Status' => 1
                                        );
                                        $this->db->where($holiday_data);
                                        $q_hol = $this->db->get('tbl_holiday');
                                        $count_hol = $q_hol->num_rows();
                                        if ($count_hol == 1) {
                                            if ($Field_Name == "Login Time") {
                                                $contents .="<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center'>H</td>";
                                            }
                                            if ($Field_Name == "Logout Time") {
                                                $contents .="<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center'>H</td>";
                                            }
                                            if ($Field_Name == "Total Hours") {
                                                $contents .="<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center'>H</td>";
                                            }
                                            if ($Field_Name == "Late Hours") {
                                                $contents .="<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center'>H</td>";
                                            }
                                            if ($Field_Name == "Early Hours") {
                                                $contents .="<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center'>H</td>";
                                            }
											if ($Field_Name == "Remarks") {
                                                $contents .="<td style = 'background-color:#0072bc;color:#fff;border:1px solid #000;text-align:center'>H</td>";
                                            }
                                        } else {
                                            $data_in = array(
                                                'Emp_Id' => $employee_no,
                                                'Login_Date' => $dates_month_1,
                                                'Status' => 1
                                            );
                                            $this->db->where($data_in);
                                            $q_in = $this->db->get('tbl_attendance');
                                            $count_in = $q_in->num_rows();
                                            if ($count_in == 1) {
                                                foreach ($q_in->result() as $row_in) {
                                                    $A_Id_in = $row_in->A_Id;
                                                    $Login_Date1 = $row_in->Login_Date;
                                                    $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                                    $Login_Time = $row_in->Login_Time;
                                                    $shift_name = $row_in->Shift_Name;

                                                    $Logout_Date1 = $row_in->Logout_Date;
                                                    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                                    $Logout_Time = $row_in->Logout_Time;
													$comments = $row_in->Comments;
                                                    $h1 = strtotime($Login_Time);
                                                    $h2 = strtotime($Logout_Time);
                                                    $seconds = $h2 - $h1;
                                                    $total_hours_present = gmdate("H:i:s", $seconds);

                                                    if ($Logout_Time == "" || $Logout_Time == "00:00:00") {
                                                        $total_hours_present = "";
                                                    } else {
                                                        $total_hours_present = gmdate("H:i:s", $seconds);
                                                    }

                                                    $min_time = "04:30:00";

                                                    $shift_24_hour_format_present = date("H:i:s", strtotime("$Shift_From1"));
                                                    $to_time_present = strtotime("$Login_Date1 $shift_24_hour_format_present");
                                                    $from_time_present = strtotime("$Login_Date1 $Login_Time");
                                                    $diff_total_mins_present = round(abs($to_time_present - $from_time_present) / 60, 2) . " minute";
                                                    $diff_hours_present = floor($diff_total_mins_present / 60);
                                                    $diff_minutes_present = $diff_total_mins_present % 60;

                                                    if ($total_hours_present > $min_time) {
                                                        if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                            if ($Field_Name == "Login Time") {
                                                                $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$Login_Time";
                                                                $contents .="</td>";
                                                            }
                                                            if ($Field_Name == "Logout Time") {
                                                                $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$Logout_Time";
                                                                $contents .="</td>";
                                                            }
                                                            if ($Field_Name == "Total Hours") {
                                                                $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$total_hours_present";
                                                                $contents .="</td>";
                                                            }
                                                            if ($Shift_Name != "") {
                                                                if ($Field_Name == "Late Hours") {
                                                                    if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                        $contents .="<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        $contents .="$diff_hours_present H : $diff_minutes_present M";
                                                                        $contents .="</td>";
                                                                    } else {
                                                                        $contents .="<td></td>";
                                                                    }
                                                                }
                                                                if ($Field_Name == "Early Hours") {
                                                                    if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                        $contents .="<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        $contents .="$diff_hours_present H : $diff_minutes_present M";
                                                                        $contents .="</td>";
                                                                    } else {
                                                                        $contents .="<td></td>";
                                                                    }
                                                                }
                                                            } else {
                                                                if ($Field_Name == "Late Hours") {
                                                                    $contents .="<td></td>";
                                                                }
                                                                if ($Field_Name == "Early Hours") {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
															if ($Field_Name == "Remarks") {
																$contents .="<td style = 'color:#000;border:1px solid #000;text-align:center'>";
																$contents .="$comments";
																$contents .="</td>";
                                                            }
                                                        } else {
                                                            if ($Field_Name == "Login Time") {
                                                                $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$Login_Time";
                                                                $contents .="</td>";
                                                            }
                                                            if ($Field_Name == "Logout Time") {
                                                                $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$Logout_Time";
                                                                $contents .="</td>";
                                                            }
                                                            if ($Field_Name == "Total Hours") {
                                                                $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                                $contents .="$total_hours_present";
                                                                $contents .="</td>";
                                                            }
                                                            if ($Shift_Name != "") {
                                                                if ($Field_Name == "Late Hours") {
                                                                    if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                        $contents .="<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        $contents .="$diff_hours_present H : $diff_minutes_present M";
                                                                        $contents .="</td>";
                                                                    } else {
                                                                        $contents .="<td></td>";
                                                                    }
                                                                }
                                                                if ($Field_Name == "Early Hours") {
                                                                    if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                        $contents .="<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                        $contents .="$diff_hours_present H : $diff_minutes_present M";
                                                                        $contents .="</td>";
                                                                    } else {
                                                                        $contents .="<td></td>";
                                                                    }
                                                                }
                                                            } else {
                                                                if ($Field_Name == "Late Hours") {
                                                                    $contents .="<td></td>";
                                                                }
                                                                if ($Field_Name == "Early Hours") {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
															if ($Field_Name == "Remarks") {
																$contents .="<td style = 'color:#000;border:1px solid #000;text-align:center'>";
																$contents .="$comments";
																$contents .="</td>";
															}
                                                        }
                                                    } else {
                                                        if ($Field_Name == "Login Time") {
                                                            $contents .="<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                            $contents .="$Login_Time";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Field_Name == "Logout Time") {
                                                            $contents .="<td style = 'background-color:#00a651;border:1px solid #000;text-align:center'>";
                                                            $contents .="$Logout_Time";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Field_Name == "Total Hours") {
                                                            $contents .="<td style = 'background-color:#00a651;color:#fff;border:1px solid #000;text-align:center'>";
                                                            $contents .="$total_hours_present";
                                                            $contents .="</td>";
                                                        }
                                                        if ($Shift_Name != "") {
                                                            if ($Field_Name == "Late Hours") {
                                                                if (strtotime($shift_24_hour_format_present) < strtotime($Login_Time)) {
                                                                    $contents .="<td style = 'background-color:#FF4500;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    $contents .="$diff_hours_present H : $diff_minutes_present M";
                                                                    $contents .="</td>";
                                                                } else {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
                                                            if ($Field_Name == "Early Hours") {
                                                                if (strtotime($shift_24_hour_format_present) > strtotime($Login_Time)) {
                                                                    $contents .="<td style = 'background-color:#0919b7;color:#fff;border:1px solid #000;text-align:center'>";
                                                                    $contents .="$diff_hours_present H : $diff_minutes_present M";
                                                                    $contents .="</td>";
                                                                } else {
                                                                    $contents .="<td></td>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($Field_Name == "Late Hours") {
                                                                $contents .="<td></td>";
                                                            }
                                                            if ($Field_Name == "Early Hours") {
                                                                $contents .="<td></td>";
                                                            }
                                                        }
														if ($Field_Name == "Remarks") {
                                                            $contents .="<td style = 'color:#000;border:1px solid #000;text-align:center'>";
                                                            $contents .="$comments";
                                                            $contents .="</td>";
                                                        }
                                                    }
                                                }
                                            } else {
                                                if ($Field_Name == "Login Time") {
                                                    $contents .="<td></td>";
                                                }
                                                if ($Field_Name == "Logout Time") {
                                                    $contents .="<td></td>";
                                                }
                                                if ($Field_Name == "Total Hours") {
                                                    $contents .="<td></td>";
                                                }
                                                if ($Field_Name == "Late Hours") {
                                                    $contents .="<td></td>";
                                                }
                                                if ($Field_Name == "Early Hours") {
                                                    $contents .="<td></td>";
                                                }
												if ($Field_Name == "Remarks") {
                                                    $contents .="<td></td>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $contents .= "</tr>";
                } else if ($Title == "Leave Monthlywise" && $period_from != "" && $period_to != "") {
                    $contents .="<tr>";
                    $contents .="<td>" . $emp_code . $employee_no . "</td>";
                    $contents .= "<td>" . $emp_name . "</td>";
                    if ($emp_doj == "0000-00-00" || $emp_doj == "1970-01-01") {
                        $contents .= "<td></td>";
                    } else {
                        $contents .= "<td>" . date("d-M-Y", strtotime($emp_doj)) . "</td>";
                    }

                    $begin_date = new DateTime($period_from);
                    $end_date = new DateTime($period_to);
                    $interval = DateInterval::createFromDateString('1 month');
                    $period = new DatePeriod($begin_date, $interval, $end_date);
                    $l_counter = 0;
                    foreach ($period as $dt) {
                        $l_counter++;
                    }

                    $begin = new DateTime($period_from);
                    $end = new DateTime($period_to);
                    while ($begin <= $end) {
                        for ($li = 1; $li <= $l_counter; $li++) {
                            $firstday = $begin->format('Y-m-d');
                            $begin->modify('first day of this month');
                            $lastday = $begin->format('Y-m-t');
                            $begin->modify('first day of next month');
                            for ($j = 0; $j < sizeof($fieldlist); $j++) {
                                $this->db->where('F_Id', $fieldlist[$j]);
                                $q_field_content = $this->db->get('tbl_report_field');
                                foreach ($q_field_content->result() as $row_field_content) {
                                    $Field_Name = $row_field_content->Field;
                                    $Field_Type = $row_field_content->Field_Type;
                                    $this->db->where("$Employee_Id_Type", $employee_no);
                                    $sql_export = $this->db->get($Table_Name);
                                    $count_export = $sql_export->num_rows();
                                    if ($count_export > 0) {
                                        foreach ($sql_export->result() as $row_export) {
                                            $el_leave = $row_export->EL;
                                            $cl_leave = $row_export->CL;
                                            $maternity_leave = $row_export->Maternity;
                                            $paternity_leave = $row_export->Paternity;
                                            $Accumulation = $row_export->Accumulation;
                                            $Bal_Accumulation = $row_export->Bal_Accumulation;
                                            $this->db->where('Employee_Id', $employee_no);
                                            $q_personal = $this->db->get('tbl_employee_personal');
                                            foreach ($q_personal->Result() as $row_personal) {
                                                $Emp_Marrial = $row_personal->Emp_Marrial;
                                            }
                                            $el_taken = 0;
                                            $leave_taken_el = array(
                                                'Employee_Id' => $employee_no,
                                                'Status' => 1,
                                                'Leave_Type' => 1,
                                                'Leave_From >=' => $firstday,
                                                'Leave_From <=' => $lastday,
                                                'Approval' => 'Yes'
                                            );
                                            $this->db->where($leave_taken_el);
                                            $q_leave_taken_el = $this->db->get('tbl_leaves');
                                            foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                                                $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                                                $Leave_From1_el = $row_leave_taken_el->Leave_From;
                                                $Leave_To1_el = $row_leave_taken_el->Leave_To;
                                                $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                                                if ($Leave_Duration_el == "Full Day") {
                                                    $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                                                    $No_days_el = $interval_el->format("%a");
                                                } else {
                                                    $No_days_el = 0.5;
                                                }
                                                $el_taken = $el_taken + $No_days_el;
                                            }
                                            $el_leave_balance = $el_leave - $el_taken;
                                            $leave_taken_cl = array(
                                                'Employee_Id' => $employee_no,
                                                'Status' => 1,
                                                'Leave_Type' => 2,
                                                'Leave_From >=' => $firstday,
                                                'Leave_From <=' => $lastday,
                                                'Approval' => 'Yes'
                                            );
                                            $this->db->where($leave_taken_cl);
                                            $q_leave_taken_cl = $this->db->get('tbl_leaves');
                                            $cl_taken = 0;
                                            foreach ($q_leave_taken_cl->result() as $row_leave_taken_cl) {
                                                $Leave_Duration = $row_leave_taken_cl->Leave_Duration;
                                                $Leave_From1 = $row_leave_taken_cl->Leave_From;
                                                $Leave_To1 = $row_leave_taken_cl->Leave_To;
                                                $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                                                if ($Leave_Duration == "Full Day") {
                                                    $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                                    $No_days = $interval->format("%a");
                                                } else {
                                                    $No_days = 0.5;
                                                }
                                                $cl_taken = $cl_taken + $No_days;
                                            }
                                            $cl_leave_balance = $cl_leave - $cl_taken;
                                            $leave_taken_maternity = array(
                                                'Employee_Id' => $employee_no,
                                                'Status' => 1,
                                                'Leave_Type' => 3,
                                                'Leave_From >=' => $firstday,
                                                'Leave_From <=' => $lastday,
                                                'Approval' => 'Yes'
                                            );
                                            $this->db->where($leave_taken_maternity);
                                            $q_leave_taken_maternity = $this->db->get('tbl_leaves');
                                            $maternity_taken = 0;
                                            foreach ($q_leave_taken_maternity->result() as $row_leave_taken_maternity) {
                                                $Leave_Duration_Maternity = $row_leave_taken_maternity->Leave_Duration;
                                                $Leave_From1_Maternity = $row_leave_taken_maternity->Leave_From;
                                                $Leave_To1_Maternity = $row_leave_taken_maternity->Leave_To;
                                                $Leave_To_include_Maternity = date('Y-m-d', strtotime($Leave_To1_Maternity . "+1 days"));

                                                if ($Leave_Duration_Maternity == "Full Day") {
                                                    $interval_Maternity = date_diff(date_create($Leave_To_include_Maternity), date_create($Leave_From1_Maternity));
                                                    $No_days_Maternity = $interval_Maternity->format("%a");
                                                } else {
                                                    $No_days_Maternity = 0.5;
                                                }
                                                $maternity_taken = $maternity_taken + $No_days_Maternity;
                                            }
                                            $maternity_leave_balance = $maternity_leave - $maternity_taken;
                                            $leave_taken_paternity = array(
                                                'Employee_Id' => $employee_no,
                                                'Status' => 1,
                                                'Leave_Type' => 4,
                                                'Leave_From >=' => $firstday,
                                                'Leave_From <=' => $lastday,
                                                'Approval' => 'Yes'
                                            );
                                            $this->db->where($leave_taken_paternity);
                                            $q_leave_taken_paternity = $this->db->get('tbl_leaves');
                                            $paternity_taken = 0;
                                            foreach ($q_leave_taken_paternity->result() as $row_leave_taken_paternity) {
                                                $Leave_Duration_Paternity = $row_leave_taken_paternity->Leave_Duration;
                                                $Leave_From1_Paternity = $row_leave_taken_paternity->Leave_From;
                                                $Leave_To1_Paternity = $row_leave_taken_paternity->Leave_To;
                                                $Leave_To_include_Paternity = date('Y-m-d', strtotime($Leave_To1_Paternity . "+1 days"));
                                                if ($Leave_Duration_Paternity == "Full Day") {
                                                    $interval_Paternity = date_diff(date_create($Leave_To_include_Paternity), date_create($Leave_From1_Paternity));
                                                    $No_days_Paternity = $interval_Paternity->format("%a");
                                                } else {
                                                    $No_days_Paternity = 0.5;
                                                }
                                                $paternity_taken = $paternity_taken + $No_days_Paternity;
                                            }
                                            $paternity_leave_balance = $paternity_leave - $paternity_taken;
                                            $leave_lop = array(
                                                'Emp_Id' => $employee_no,
                                                'Status' => 1,
                                                'Date >=' => $firstday,
                                                'Date <=' => $lastday,
                                                'Type' => 'LOP'
                                            );
                                            $this->db->where($leave_lop);
                                            $q_leave_lop = $this->db->get('tbl_attendance_mark');
                                            $count_lop = $q_leave_lop->num_rows();
                                            $leave_dislop = array(
                                                'Emp_Id' => $employee_no,
                                                'Status' => 1,
                                                'Date >=' => $firstday,
                                                'Date <=' => $lastday,
                                                'Type' => 'Disciplinary LOP'
                                            );
                                            $this->db->where($leave_dislop);
                                            $q_leave_dislop = $this->db->get('tbl_attendance_mark');
                                            $count_dislop = $q_leave_dislop->num_rows();
                                            $leave_compoff = array(
                                                'Emp_Id' => $employee_no,
                                                'Status' => 1,
                                                'Date >=' => $firstday,
                                                'Date <=' => $lastday,
                                                'Type' => 'Comp Off',
                                                'Approval' => 'Yes'
                                            );
                                            $this->db->where($leave_compoff);
                                            $q_leave_compoff = $this->db->get('tbl_attendance_mark');
                                            $count_compoff = $q_leave_compoff->num_rows();
                                            if ($Field_Name == "Entitled - EL") {
                                                $contents .= "<td>$el_leave</td>";
                                            }if ($Field_Name == "Entitled - CL") {
                                                $contents .= "<td>$cl_leave</td>";
                                            }if ($Field_Name == "Entitled - Maternity") {
                                                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                    $contents .= "<td>$maternity_leave</td>";
                                                } else {
                                                    $contents .= "<td></td>";
                                                }
                                            }if ($Field_Name == "Entitled - Paternity") {
                                                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                    $contents .= "<td>$paternity_leave</td>";
                                                } else {
                                                    $contents .= "<td></td>";
                                                }
                                            }if ($Field_Name == "EL") {
                                                $contents .= "<td>$el_taken</td>";
                                            }if ($Field_Name == "CL") {
                                                $contents .= "<td>$cl_taken</td>";
                                            }if ($Field_Name == "Maternity") {
                                                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                    $contents .= "<td>$maternity_taken</td>";
                                                } else {
                                                    $contents .= "<td></td>";
                                                }
                                            }if ($Field_Name == "Paternity") {
                                                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                    $contents .= "<td>$paternity_taken</td>";
                                                } else {
                                                    $contents .= "<td></td>";
                                                }
                                            }if ($Field_Name == "Balance - EL") {
                                                $contents .= "<td>$el_leave_balance</td>";
                                            } if ($Field_Name == "Balance - CL") {
                                                $contents .= "<td>$cl_leave_balance</td>";
                                            }if ($Field_Name == "Balance - Maternity") {
                                                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                    $contents .= "<td>$maternity_leave_balance</td>";
                                                } else {
                                                    $contents .= "<td></td>";
                                                }
                                            }if ($Field_Name == "Balance - Paternity") {
                                                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                    $contents .= "<td>$paternity_leave_balance</td>";
                                                } else {
                                                    $contents .= "<td></td>";
                                                }
                                            }if ($Field_Name == "LOP") {
                                                $contents .= "<td>$count_lop</td>";
                                            }if ($Field_Name == "Disciplinary LOP") {
                                                $contents .= "<td>$count_dislop</td>";
                                            }if ($Field_Name == "Comp Off") {
                                                $contents .= "<td>$count_compoff</td>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $contents .="</tr>";
                } else {
                    if ($period_from1 != "") {
                        /* For Resignation Info */
                        if ($Table_Name == "tbl_resignation") {
                            $this->db->where('HR_FinalSettlement_Date >=', $period_from);
                            $this->db->where('HR_FinalSettlement_Date <=', $period_to);
                            $this->db->where($Employee_Id_Type, $employee_no);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        }

                        /* For Employee Info */ else if ($Table_Name == "tbl_employee") {
                            $this->db->where('Emp_Confirmationdate >=', $period_from);
                            $this->db->where('Emp_Confirmationdate <=', $period_to);
                            $this->db->where($Employee_Id_Type, $employee_no);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        }

                        /* For Employee Career Info */ else if ($Table_Name == "tbl_employee_career") {
                            $this->db->where('From >=', $period_from);
                            $this->db->where('From <=', $period_to);
                            $this->db->where($Employee_Id_Type, $employee_no);
                            $this->db->where('Status', 1);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        }

                        /* For Employee Salary Info */ else if ($Table_Name == "tbl_salary_info") {
                            $this->db->where('From_Date >=', $period_from);
                            $this->db->where('From_Date <=', $period_to);
                            $this->db->where($Employee_Id_Type, $employee_no);
                            $this->db->where('Status', 1);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        }

                        /* Other Info */ else {
                            $this->db->where($Employee_Id_Type, $employee_no);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        }
                    } else {
                        if ($Table_Name == "tbl_employee_family" || $Table_Name == "tbl_employee_career" || $Table_Name == "tbl_employee_educationdetails" || $Table_Name == "tbl_employee_expdetails" || $Table_Name == "tbl_salary_info") {
                            $this->db->where('Status', 1);
                            $this->db->where("$Employee_Id_Type", $employee_no);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        } else {
                            $this->db->where("$Employee_Id_Type", $employee_no);
                            $sql_export = $this->db->get($Table_Name);
                            $count_export = $sql_export->num_rows();
                        }
                    }
                    if ($count_export > 0) {
                        foreach ($sql_export->result() as $row_export) {
                            $contents .="<tr>";
                            $contents .="<td>" . $emp_code . $employee_no . "</td>";
                            $contents .= "<td>" . $emp_name . "</td>";
                            if ($emp_doj == "0000-00-00" || $emp_doj == "1970-01-01") {
                                $contents .= "<td></td>";
                            } else {
                                $contents .= "<td>" . date("d-M-Y", strtotime($emp_doj)) . "</td>";
                            }
                            for ($j = 0; $j < sizeof($fieldlist); $j++) {
                                $this->db->where('F_Id', $fieldlist[$j]);
                                $q_field_content = $this->db->get('tbl_report_field');
                                foreach ($q_field_content->result() as $row_field_content) {
                                    $Field_Name = $row_field_content->Field;
                                    $Field_Type = $row_field_content->Field_Type;

                                    /* Career Info Start Here */ if ($Table_Name == "tbl_employee_career") {
                                        $branch_id = $row_export->Branch_Id;
                                        $department_id = $row_export->Department_Id;
                                        $designation_id = $row_export->Designation_Id;
                                        $report_to_id = $row_export->Reporting_To;
                                        $from_date = $row_export->From;
                                        if ($from_date == "0000-00-00") {
                                            $from = "";
                                        } else {
                                            $from = date("d M y", strtotime($from_date));
                                        }
                                        $to_date = $row_export->To;
                                        if ($to_date == "0000-00-00") {
                                            $to = "";
                                        } else {
                                            $to = date("d M y", strtotime($to_date));
                                        }
                                        $this->db->where('Designation_Id', $designation_id);
                                        $q_designation = $this->db->get('tbl_designation');
                                        foreach ($q_designation->result() as $row_designation) {
                                            $designation_name = $row_designation->Designation_Name;
                                            $grade_name = $row_designation->Grade;
                                            $dept_role = $row_designation->Role;
                                            $subdepartment_id = $row_designation->Client_Id;

                                            $this->db->where('Subdepartment_Id', $subdepartment_id);
                                            $q_subdept = $this->db->get('tbl_subdepartment');
                                            foreach ($q_subdept->result() as $row_subdept) {
                                                $subdepartment_name = $row_subdept->Subdepartment_Name;
                                                $client_name = $row_subdept->Client_Name;
                                            }
                                        }
                                        $this->db->where('Department_Id', $department_id);
                                        $q_dept = $this->db->get('tbl_department');
                                        foreach ($q_dept->result() as $row_dept) {
                                            $department_name = $row_dept->Department_Name;
                                        }
                                        $this->db->where('Branch_ID', $branch_id);
                                        $q_career = $this->db->get('tbl_branch');
                                        foreach ($q_career->result() as $row_career) {
                                            $branch_name = $row_career->Branch_Name;
                                        }
                                        $this->db->where('Emp_Number', $report_to_id);
                                        $q_emp = $this->db->get('tbl_employee');
                                        foreach ($q_emp->result() as $row_emp) {
                                            $reporting_name = $row_emp->Emp_FirstName;
                                            $reporting_name .= " " . $row_emp->Emp_LastName;
                                            $reporting_name .= " " . $row_emp->Emp_MiddleName;
                                        }
                                        if ($Field_Name == "Branch") {
                                            $contents .="<td>$branch_name</td>";
                                        }
                                        if ($Field_Name == "Department") {
                                            $contents .="<td>$department_name</td>";
                                        }
                                        if ($Field_Name == "Client") {
                                            $contents .="<td>$client_name</td>";
                                        }
                                        if ($Field_Name == "Sub Process") {
                                            $contents .="<td>$subdepartment_name </td>";
                                        }
                                        if ($Field_Name == "Designation") {
                                            $contents .="<td>$designation_name</td>";
                                        }
                                        if ($Field_Name == "Grade") {
                                            $contents .="<td>$grade_name</td>";
                                        }
                                        if ($Field_Name == "Grade") {
                                            $contents .="<td>$dept_role</td>";
                                        }
                                        if ($Field_Name == "Reporting To") {
                                            $contents .="<td>$reporting_name</td>";
                                        }
                                        if ($Field_Name == "From Date") {
                                            $contents .="<td>$from</td>";
                                        }
                                        if ($Field_Name == "To Date") {
                                            $contents .="<td>$to</td>";
                                        }
                                    }
                                    /* Career Info End Here */

                                    /* Reporting Manager Start Here */ else if ($Field_Name == "Reporting Manager") {
                                        $emp_no = $row_export->$Field_Type;
                                        $this->db->where('Emp_Number', $emp_no);
                                        $q_employee = $this->db->get('tbl_employee');
                                        foreach ($q_employee->result() as $row_employee) {
                                            $this->db->where('employee_number', $emp_no);
                                            $q_code = $this->db->get('tbl_emp_code');
                                            foreach ($q_code->Result() as $row_code) {
                                                $emp_code = $row_code->employee_code;
                                            }
                                            $emp_name = $row_employee->Emp_FirstName;
                                            $emp_name .= " " . $row_employee->Emp_LastName;
                                            $emp_name .= " " . $row_employee->Emp_MiddleName;
                                            $contents .="<td>" . $emp_name . "( " . $emp_code . $emp_no . ")" . "</td>";
                                        }
                                    }
                                    /* Reporting Manager End Here */

                                    /* Salary Info Start Here */ else if ($Table_Name == "tbl_salary_info") {
                                        $salary_id = $row_export->Sal_Id;
                                        $this->db->where('Sal_Id', $salary_id);
                                        $q_salary = $this->db->get('tbl_salary_info');
                                        foreach ($q_salary->result() as $row_salary) {
                                            $C_CTC = $row_salary->C_CTC;
                                            $Monthly_CTC = $row_salary->Monthly_CTC;
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
                                        if ($Total_Fixed_Gross >= 21000) {
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
                                        if ($Field_Name == "Annual CTC") {
                                            $contents .="<td>" . number_format(round($C_CTC), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Monthly CTC") {
                                            $contents .="<td>" . number_format(round($Monthly_CTC), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Basic + DA") {
                                            $contents .="<td>" . number_format(round($Basic), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "HRA") {
                                            $contents .="<td>" . number_format(round($Hra), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Conveyance") {
                                            $contents .="<td>" . number_format(round($Conveyance), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Medical") {
                                            $contents .="<td>" . number_format(round($Medical), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Child Education") {
                                            $contents .="<td>" . number_format(round($Child_education), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Special Allowance") {
                                            $contents .="<td>" . number_format(round($Special_allowance), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Skill Allowance") {
                                            $contents .="<td>" . number_format(round($Skill_allowance), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Employer ESI") {
                                            $contents .="<td>" . number_format(round($Employer_ESI), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Employer PF") {
                                            $contents .="<td>" . number_format(round($Employer_PF), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Total Fixed Gross") {
                                            $contents .="<td>" . number_format(round($Total_Fixed_Gross), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Employee ESI") {
                                            $contents .="<td>" . number_format(round($Employee_ESI), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Employee PF") {
                                            $contents .="<td>" . number_format(round($Employee_PF), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Professional Tax") {
                                            $contents .="<td>" . number_format(round($Professional_Tax), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Insurance") {
                                            $contents .="<td>" . number_format(round($Insurance), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "Net Salary") {
                                            $contents .="<td>" . number_format(round($Net_Salary), 2, '.', ',') . "</td>";
                                        }
                                        if ($Field_Name == "From Date" || $Field_Name == "To Date") {
                                            $date = $row_export->$Field_Type;
                                            if ($date == "0000-00-00" || $date == "1970-01-01") {
                                                $contents .= "<td></td>";
                                            } else {
                                                $contents .= "<td>" . date("d-M-Y", strtotime($date)) . "</td>";
                                            }
                                        }
                                    }

                                    /* Salary Info End Here */

                                    /* Date Format Start Here */ else if ($Field_Name == "DOJ" || $Field_Name == "DOB" || $Field_Name == "Actual DOB" || $Field_Name == "Confirmation Date" || $Field_Name == "Date of Birth" || $Field_Name == "Date of Issue" || $Field_Name == "Date of Expiry" || $Field_Name == "Final Settlement Date" || $Field_Name == "Short LWD" || $Field_Name == "Extend LWD" || $Field_Name == "Last Working Date" || $Field_Name == "Resignation Date" || $Field_Name == "Notice Date" || $Field_Name == "Releaved Date" || $Field_Name == "Joined Date") {
                                        $date = $row_export->$Field_Type;
                                        if ($date == "0000-00-00" || $date == "1970-01-01") {
                                            $contents .= "<td></td>";
                                        } else {
                                            $contents .= "<td>" . date("d-M-Y", strtotime($date)) . "</td>";
                                        }
                                    }

                                    /* Date Format End Here */

                                    /* Leaves Info Start Here */ else if ($Title == "Leaves") {
                                        $el_leave = $row_export->EL;
                                        $cl_leave = $row_export->CL;
                                        $maternity_leave = $row_export->Maternity;
                                        $paternity_leave = $row_export->Paternity;
                                        $Accumulation = $row_export->Accumulation;
                                        $Bal_Accumulation = $row_export->Bal_Accumulation;
                                        $this->db->where('Employee_Id', $employee_no);
                                        $q_personal = $this->db->get('tbl_employee_personal');
                                        foreach ($q_personal->Result() as $row_personal) {
                                            $Emp_Marrial = $row_personal->Emp_Marrial;
                                        }
                                        $el_taken = 0;
                                        $leave_taken_el = array(
                                            'Employee_Id' => $employee_no,
                                            'Status' => 1,
                                            'Leave_Type' => 1,
                                            'Approval' => 'Yes'
                                        );
                                        $this->db->where($leave_taken_el);
                                        $q_leave_taken_el = $this->db->get('tbl_leaves');
                                        foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                                            $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                                            $Leave_From1_el = $row_leave_taken_el->Leave_From;
                                            $Leave_To1_el = $row_leave_taken_el->Leave_To;
                                            $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                                            if ($Leave_Duration_el == "Full Day") {
                                                $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                                                $No_days_el = $interval_el->format("%a");
                                            } else {
                                                $No_days_el = 0.5;
                                            }
                                            $el_taken = $el_taken + $No_days_el;
                                        }
                                        $el_leave_balance = $el_leave - $el_taken;
                                        $leave_taken_cl = array(
                                            'Employee_Id' => $employee_no,
                                            'Status' => 1, 'Leave_Type' => 2,
                                            'Approval' => 'Yes'
                                        );
                                        $this->db->where($leave_taken_cl);
                                        $q_leave_taken_cl = $this->db->get('tbl_leaves');
                                        $cl_taken = 0;
                                        foreach ($q_leave_taken_cl->result() as $row_leave_taken_cl) {
                                            $Leave_Duration = $row_leave_taken_cl->Leave_Duration;
                                            $Leave_From1 = $row_leave_taken_cl->Leave_From;
                                            $Leave_To1 = $row_leave_taken_cl->Leave_To;
                                            $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                                            if ($Leave_Duration == "Full Day") {
                                                $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                                $No_days = $interval->format("%a");
                                            } else {
                                                $No_days = 0.5;
                                            }
                                            $cl_taken = $cl_taken + $No_days;
                                        }
                                        $cl_leave_balance = $cl_leave - $cl_taken;
                                        $leave_taken_maternity = array(
                                            'Employee_Id' => $employee_no,
                                            'Status' => 1, 
                                            'Leave_Type' => 3,
                                            'Approval' => 'Yes'
                                        );
                                        $this->db->where($leave_taken_maternity);
                                        $q_leave_taken_maternity = $this->db->get('tbl_leaves');
                                        $maternity_taken = 0;
                                        foreach ($q_leave_taken_maternity->result() as $row_leave_taken_maternity) {
                                            $Leave_Duration_Maternity = $row_leave_taken_maternity->Leave_Duration;
                                            $Leave_From1_Maternity = $row_leave_taken_maternity->Leave_From;
                                            $Leave_To1_Maternity = $row_leave_taken_maternity->Leave_To;
                                            $Leave_To_include_Maternity = date('Y-m-d', strtotime($Leave_To1_Maternity . "+1 days"));

                                            if ($Leave_Duration_Maternity == "Full Day") {
                                                $interval_Maternity = date_diff(date_create($Leave_To_include_Maternity), date_create($Leave_From1_Maternity));
                                                $No_days_Maternity = $interval_Maternity->format("%a");
                                            } else {
                                                $No_days_Maternity = 0.5;
                                            }
                                            $maternity_taken = $maternity_taken + $No_days_Maternity;
                                        }
                                        $maternity_leave_balance = $maternity_leave - $maternity_taken;
                                        $leave_taken_paternity = array(
                                            'Employee_Id' => $employee_no,
                                            'Status' => 1, 
                                            'Leave_Type' => 4,
                                            'Approval' => 'Yes'
                                        );
                                        $this->db->where($leave_taken_paternity);
                                        $q_leave_taken_paternity = $this->db->get('tbl_leaves');
                                        $paternity_taken = 0;
                                        foreach ($q_leave_taken_paternity->result() as $row_leave_taken_paternity) {
                                            $Leave_Duration_Paternity = $row_leave_taken_paternity->Leave_Duration;
                                            $Leave_From1_Paternity = $row_leave_taken_paternity->Leave_From;
                                            $Leave_To1_Paternity = $row_leave_taken_paternity->Leave_To;
                                            $Leave_To_include_Paternity = date('Y-m-d', strtotime($Leave_To1_Paternity . "+1 days"));

                                            if ($Leave_Duration_Paternity == "Full Day") {
                                                $interval_Paternity = date_diff(date_create($Leave_To_include_Paternity), date_create($Leave_From1_Paternity));
                                                $No_days_Paternity = $interval_Paternity->format("%a");
                                            } else {
                                                $No_days_Paternity = 0.5;
                                            }
                                            $paternity_taken = $paternity_taken + $No_days_Paternity;
                                        }
                                        $paternity_leave_balance = $paternity_leave - $paternity_taken;
                                        $leave_lop = array(
                                            'Emp_Id' => $employee_no,
                                            'Status' => 1,
                                            'Type' => 'LOP'
                                        );
                                        $this->db->where($leave_lop);
                                        $q_leave_lop = $this->db->get('tbl_attendance_mark');
                                        $count_lop = $q_leave_lop->num_rows();
                                        $leave_dislop = array(
                                            'Emp_Id' => $employee_no,
                                            'Status' => 1,
                                            'Type' => 'Disciplinary LOP'
                                        );
                                        $this->db->where($leave_dislop);
                                        $q_leave_dislop = $this->db->get('tbl_attendance_mark');
                                        $count_dislop = $q_leave_dislop->num_rows();
                                        $leave_compoff = array(
                                            'Emp_Id' => $employee_no,
                                            'Status' => 1,
                                            'Type' => 'Comp Off',
                                             'Approval' => 'Yes'
                                        );
                                        $this->db->where($leave_compoff);
                                        $q_leave_compoff = $this->db->get('tbl_attendance_mark');
                                        $count_compoff = $q_leave_compoff->num_rows();
                                        if ($Field_Name == "Entitled - EL") {
                                            $contents .= "<td>$el_leave</td>";
                                        }if ($Field_Name == "Entitled - CL") {
                                            $contents .= "<td>$cl_leave</td>";
                                        }if ($Field_Name == "Entitled - Maternity") {
                                            if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                $contents .= "<td>$maternity_leave</td>";
                                            } else {
                                                $contents .= "<td></td>";
                                            }
                                        }if ($Field_Name == "Entitled - Paternity") {
                                            if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                $contents .= "<td>$paternity_leave</td>";
                                            } else {
                                                $contents .= "<td></td>";
                                            }
                                        }if ($Field_Name == "Taken - EL") {
                                            $contents .= "<td>$el_taken</td>";
                                        }if ($Field_Name == "Taken - CL") {
                                            $contents .= "<td>$cl_taken</td>";
                                        }if ($Field_Name == "Taken - Maternity") {
                                            if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                $contents .= "<td>$maternity_taken</td>";
                                            } else {
                                                $contents .= "<td></td>";
                                            }
                                        }if ($Field_Name == "Taken - Paternity") {
                                            if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                $contents .= "<td>$paternity_taken</td>";
                                            } else {
                                                $contents .= "<td></td>";
                                            }
                                        }if ($Field_Name == "Balance - EL") {
                                            $contents .= "<td>$el_leave_balance</td>";
                                        } if ($Field_Name == "Balance - CL") {
                                            $contents .= "<td>$cl_leave_balance</td>";
                                        }if ($Field_Name == "Balance - Maternity") {
                                            if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                $contents .= "<td>$maternity_leave_balance</td>";
                                            } else {
                                                $contents .= "<td></td>";
                                            }
                                        }if ($Field_Name == "Balance - Paternity") {
                                            if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                $contents .= "<td>$paternity_leave_balance</td>";
                                            } else {
                                                $contents .= "<td></td>";
                                            }
                                        }if ($Field_Name == "Accumulation") {
                                            $contents .= "<td>$Accumulation</td>";
                                        }if ($Field_Name == "Bal. Accumulation") {
                                            $contents .= "<td>$Bal_Accumulation</td>";
                                        }if ($Field_Name == "LOP Deducted") {
                                            $contents .= "<td>$count_lop</td>";
                                        }if ($Field_Name == "Disciplinary LOP") {
                                            $contents .= "<td>$count_dislop</td>";
                                        }if ($Field_Name == "Comp Off") {
                                            $contents .= "<td>$count_compoff</td>";
                                        }
                                    }
                                    /* Leaves Info End Here */

                                    /* Other Info Start Here */ else {
                                        $contents .= "<td>" . $row_export->$Field_Type . "</td>";
                                    }

                                    /* Other Info End Here */
                                }
                            }
                            $contents .="</tr>";
                        }
                    }
                }
            }
        }
        $filename = "$Title.xls";
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $contents;
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>