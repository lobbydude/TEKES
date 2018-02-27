<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Payslip extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Payslip Info Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Payslip',
                'main_content' => 'payslip/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function preview() {
		 $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
        $employee_list = $this->input->post('employee_list');
        $year_list = $this->input->post('preview_year');
        $month_list = $this->input->post('preview_month');
        $data = array(
            'Emp_Id' => $employee_list,
            'Month' => $month_list,
            'Year' => $year_list
        );
        $this->load->view('payslip/preview', $data);
		} else {
            redirect("Profile");
        }
    }

    public function Editpayslip() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Payslip',
                'main_content' => 'payslip/edit_payslip'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_payslip() {
        $this->form_validation->set_rules('edit_payslipinfo_nodays', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_disclop', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_leaveballop', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_lopoffered', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_additionalinsurance', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_incometax', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_deductionothers', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_salaryadvance', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_attendance', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_salaryarrears', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_nightshift', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_weekend', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_referralbonus', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_additionalothers', '', 'trim|required');
        $this->form_validation->set_rules('edit_payslipinfo_incentives', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $payslip_id = $this->input->post('edit_payslip_id');
            $employee_id = $this->input->post('edit_payslipinfo_emp_no');
            $Monthly_CTC = $this->input->post('edit_payslipinfo_mctc');
            $C_CTC = $Monthly_CTC * 12;
            $year = $this->input->post('edit_payslipinfo_year');
            $month = $this->input->post('edit_payslipinfo_month');
            $no_of_days = $this->input->post('edit_payslipinfo_nodays');
            $disclop = $this->input->post('edit_payslipinfo_disclop');
            $leaveballop = $this->input->post('edit_payslipinfo_leaveballop');
            $lopoffered = $this->input->post('edit_payslipinfo_lopoffered');
            $no_of_days_lop = $disclop + $leaveballop + $lopoffered;
            $additional_insurance1 = $this->input->post('edit_payslipinfo_additionalinsurance');
            $additional_insurance = str_replace(',', '', $additional_insurance1);
            $income_tax1 = $this->input->post('edit_payslipinfo_incometax');
            $income_tax = str_replace(',', '', $income_tax1);
            $deduction_others1 = $this->input->post('edit_payslipinfo_deductionothers');
            $deduction_others = str_replace(',', '', $deduction_others1);
            $salary_advance1 = $this->input->post('edit_payslipinfo_salaryadvance');
            $salary_advance = str_replace(',', '', $salary_advance1);
            $attendance1 = $this->input->post('edit_payslipinfo_attendance');
            $attendance = str_replace(',', '', $attendance1);
            $salary_arrears1 = $this->input->post('edit_payslipinfo_salaryarrears');
            $salary_arrears = str_replace(',', '', $salary_arrears1);
            $night_shift1 = $this->input->post('edit_payslipinfo_nightshift');
            $night_shift = str_replace(',', '', $night_shift1);
            $weekend1 = $this->input->post('edit_payslipinfo_weekend');
            $weekend = str_replace(',', '', $weekend1);
            $referal_bonus1 = $this->input->post('edit_payslipinfo_referralbonus');
            $referal_bonus = str_replace(',', '', $referal_bonus1);
            $additional_others1 = $this->input->post('edit_payslipinfo_additionalothers');
            $additional_others = str_replace(',', '', $additional_others1);
            $incentives1 = $this->input->post('edit_payslipinfo_incentives');
            $incentives = str_replace(',', '', $incentives1);
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

            $no_of_days_present = $no_of_days - $no_of_days_lop;
            $monthly_basicpay = ($Basicpay / $no_of_days) * $no_of_days_present;
            $monthly_hra = ($Hra / $no_of_days) * $no_of_days_present;
            $monthly_conveyance = ($Conveyance / $no_of_days) * $no_of_days_present;
            $monthly_skill_allowance = ($Skill_allowance / $no_of_days) * $no_of_days_present;
            $monthly_medical = ($Medical / $no_of_days) * $no_of_days_present;
            $monthly_child_education = ($Child_education / $no_of_days) * $no_of_days_present;
            $monthly_special = ($Special_allowance / $no_of_days) * $no_of_days_present;
            $total_actual_gross = $monthly_basicpay + $monthly_hra + $monthly_conveyance + $monthly_skill_allowance + $monthly_medical + $monthly_child_education + $monthly_special;
            if ($Total_Fixed_Gross <= 21000) {
                $monthly_employee_esi = ($total_actual_gross * 1.75) / 100;
            } else {
                $monthly_employee_esi = 0;
            }
            $monthly_employee_PF_amount = (($monthly_basicpay + $monthly_special) * 12) / 100;
            if ($monthly_employee_PF_amount >= 1800) {
                $monthly_employee_PF = 1800;
            } else {
                $monthly_employee_PF = $monthly_employee_PF_amount;
            }
            if ($Total_Fixed_Gross >= 15000) {
                $monthly_prof_tax = 200;
            } else {
                $monthly_prof_tax = 0;
            }
            if ($Employer_ESI > 0) {
                $monthly_insurance = 0;
            } else {
                if ($additional_insurance > 0) {
                    $monthly_insurance = 200 + $additional_insurance;
                } else {
                    $monthly_insurance = 200;
                }
            }
            $monthly_incometax = $income_tax;
            $monthly_deduction_others = $deduction_others;
            $monthly_salary_advance = $salary_advance;
            $total_deduction = $monthly_employee_esi + $monthly_employee_PF + $monthly_prof_tax + $monthly_insurance + $monthly_incometax + $monthly_deduction_others + $monthly_salary_advance;
            $total_income = $attendance + $salary_arrears + $night_shift + $weekend + $referal_bonus + $additional_others + $incentives;
            $net_salary = $total_income + $total_actual_gross - $total_deduction;
            $amount_words = $this->convert_number_to_words(round($net_salary));
            $total_earnings = $total_income + $total_actual_gross;
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data = array(
                'Emp_Id' => $employee_id,
                'Month' => $month,
                'Year' => $year,
                'Monthly_CTC' => $Monthly_CTC,
                'No_Of_Days' => $no_of_days,
                'No_Of_Days_Worked' => $no_of_days_present,
                'Disc_LOP' => $disclop,
                'Leave_Balance_LOP' => $leaveballop,
                'LOP_Offered_Date' => $lopoffered,
                'No_Of_Days_LOP' => $no_of_days_lop,
                'Basic' => number_format(round($monthly_basicpay), 2, '.', ','),
                'HRA' => number_format(round($monthly_hra), 2, '.', ','),
                'Conveyance' => number_format(round($monthly_conveyance), 2, '.', ','),
                'Skill_Allowance' => number_format(round($monthly_skill_allowance), 2, '.', ','),
                'Medical_Allowance' => number_format(round($monthly_medical), 2, '.', ','),
                'Child_Education' => number_format(round($monthly_child_education), 2, '.', ','),
                'Special_Allowance' => number_format(round($monthly_special), 2, '.', ','),
                'Total_Gross' => number_format(round($total_actual_gross), 2, '.', ','),
                'ESI_Employee' => number_format(round($monthly_employee_esi), 2, '.', ','),
                'PF_Employee' => number_format(round($monthly_employee_PF), 2, '.', ','),
                'Professional_Tax' => number_format(round($monthly_prof_tax), 2, '.', ','),
                'Additioanl_Insurance' => number_format(round($additional_insurance), 2, '.', ','),
                'Insurance' => number_format(round($monthly_insurance), 2, '.', ','),
                'Income_Tax' => number_format(round($monthly_incometax), 2, '.', ','),
                'Deduction_Others' => number_format(round($monthly_deduction_others), 2, '.', ','),
                'Salary_Advance' => number_format(round($monthly_salary_advance), 2, '.', ','),
                'Total_Deductions' => number_format(round($total_deduction), 2, '.', ','),
                'Attendance_Allowance' => number_format(round($attendance), 2, '.', ','),
                'Salary_Arrears' => number_format(round($salary_arrears), 2, '.', ','),
                'Night_Shift_Allowance' => number_format(round($night_shift), 2, '.', ','),
                'Weekend_Allowance' => number_format(round($weekend), 2, '.', ','),
                'Referral_Bonus' => number_format(round($referal_bonus), 2, '.', ','),
                'Additional_Others' => number_format(round($additional_others), 2, '.', ','),
                'Incentives' => number_format(round($incentives), 2, '.', ','),
                'Total_Income' => number_format(round($total_income), 2, '.', ','),
                'Total_Earnings' => number_format(round($total_earnings), 2, '.', ','),
                'Net_Amount' => number_format(round($net_salary), 2, '.', ','),
                'Amount_Words' => ucwords($amount_words) . " Rupees Only",
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Payslip_Id', $payslip_id);
            $q = $this->db->update('tbl_payslip_info', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    public function Deletepayslip() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $payslip_id = $this->input->post('payslip_id');
            $data = array(
                'payslip_id' => $payslip_id
            );
            $this->load->view('payslip/delete_payslip', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_payslip() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $payslip_id = $this->input->post('delete_payslip_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Payslip_Id', $payslip_id);
            $q = $this->db->update('tbl_payslip_info', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    function export_payroll() {
        $export_type = $this->input->post('export_payroll_type');
        if ($export_type == "Monthly_Statement") {
            $contents = "Employee Name,";
            $contents .= "Employee Id,";
            $contents .= "Bank Name,";
            $contents .= "IFSC Code,";
            $contents .= "Account Number,";
            $contents .= "Gender,";
            $contents .= "DOJ,";
            $contents .= "Employee Status,";
            $contents .= "Designation,";
            $contents .= "Department,";
            $contents .= "Date Of Birth,";
            $contents .= "Marital Status,";
            $contents .= "Father's Name,";
            $contents .= "PF Number,";
            $contents .= "UAN Number,";
            $contents .= "ESI,";
            $contents .= "PAN Card,";
            $contents .= "Appraised Annual CTC,";
            $contents .= "Monthly CTC,";
            $contents .= "Employer ESI,";
            $contents .= "Employer PF,";
            $contents .= "Basic + DA,";
            $contents .= "HRA,";
            $contents .= "Conveyance,";
            $contents .= "Skill Allowance,";
            $contents .= "Medical,";
            $contents .= "Child Education,";
            $contents .= "Special Allowance,";
            $contents .= "Total Fixed Gross,";
            $contents .= "No. of Days,";
            $contents .= "No. of Days Present,";
            $contents .= "No. of Days LOP,";
            $contents .= "Basic + DA,";
            $contents .= "HRA,";
            $contents .= "Conveyance,";
            $contents .= "Skill Allowance,";
            $contents .= "Medical,";
            $contents .= "Child Education,";
            $contents .= "Special Allowance,";
            $contents .= "Total Actual Gross,";
            $contents .= "Employee ESI,";
            $contents .= "Employee PF,";
            $contents .= "Professional Tax,";
            $contents .= "Insurance,";
            $contents .= "Income Tax,";
            $contents .= "Others Allowance,";
            $contents .= "Total Deductions,";
            $contents .= "Attendance,";
            $contents .= "Salary Arrears,";
            $contents .= "Night Shift,";
            $contents .= "Weekend Allowance,";
            $contents .= "Referral Bonus,";
            $contents .= "Other Allowance,";
            $contents .= "Total Income,";
            $contents .= "Net Salary,";
            $contents .= "Per Day Salary,";
            $contents .="\n";

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

            $month = $this->input->post('export_payroll_month');
            $year = $this->input->post('export_payroll_year');
            $Mon_name = date('F', mktime(0, 0, 0, $month, 10));
            $get_data = array(
                'Month' => $month,
                'Year' => $year,
                'Status' => 1
            );
            $this->db->where($get_data);
            $q_payslip = $this->db->get('tbl_payslip_info');
            $count_payslip = $q_payslip->num_rows();
            if ($count_payslip != 0) {
                foreach ($q_payslip->result() as $row_payslip) {
                    $Payslip_Id = $row_payslip->Payslip_Id;
                    $Emp_Id = $row_payslip->Emp_Id;
                    $employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
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
                        'Emp_Id' => $Emp_Id,
                        'Month' => $month,
                        'Year' => $year,
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
                        $Emp_name = $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename;
                        $Emp_Gender = $row_employee->Emp_Gender;
                        $Emp_Doj = $row_employee->Emp_Doj;
                        $doj = date("d-M-Y", strtotime($Emp_Doj));
                        $Emp_Mode = $row_employee->Emp_Mode;
                        $Emp_Dob = $row_employee->Emp_Dob;
                        $dob = date("d-M-Y", strtotime($Emp_Dob));
                    }

                    $this->db->where('Employee_Id', $employee_id);
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
                    $this->db->where('Employee_Id', $employee_id);
                    $q_personal = $this->db->get('tbl_employee_personal');
                    foreach ($q_personal->result() as $row_personal) {
                        $Emp_Marrial = $row_personal->Emp_Marrial;
                    }

                    $family_data = array(
                        'Employee_Id' => $employee_id,
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

                    $contents.= $Emp_name . ",";
                    $contents.= $emp_code . $employee_id . ",";
                    $contents.= $Emp_Bankname . ",";
                    $contents.= $Emp_IFSCcode . ",";
                    $contents.= "'" . $Emp_Accno . ",";
                    $contents.= $Emp_Gender . ",";
                    $contents.=$doj . ",";
                    $contents.=$Emp_Mode . ",";
                    $contents.=$designation_name . ",";
                    $contents.=$department_name . ",";
                    $contents.=$dob . ",";
                    $contents.=$Emp_Marrial . ",";
                    $contents.=$father_name . ",";
                    $contents.=$Emp_PFno . ",";
                    $contents.=$Emp_UANno . ",";
                    $contents.=$Emp_ESI . ",";
                    $contents.=$Emp_PANcard . ",";
                    $contents.=sprintf('%.2f', $C_CTC) . ",";
                    $contents.=sprintf('%.2f', $Monthly_CTC) . ",";
                    $contents.=sprintf('%.2f', $Employer_ESI_Company) . ",";
                    $contents.=sprintf('%.2f', $Employer_PF_Company) . ",";
                    $contents.=sprintf('%.2f', $Basicpay_Company) . ",";
                    $contents.=sprintf('%.2f', $Hra_Company) . ",";
                    $contents.=sprintf('%.2f', $Conveyance_Company) . ",";
                    $contents.=sprintf('%.2f', $Skill_allowance_Company) . ",";
                    $contents.=sprintf('%.2f', $Medical_Company) . ",";
                    $contents.=sprintf('%.2f', $Child_education_Company) . ",";
                    $contents.=sprintf('%.2f', $Special_allowance_Company) . ",";
                    $contents.=sprintf('%.2f', $Total_Fixed_Gross_Company) . ",";
                    $contents.=$No_Of_Days . ",";
                    $contents.=$No_Of_Days_Present . ",";
                    $contents.=$No_Of_Days_LOP . ",";
                    $contents.=sprintf('%.2f', $Basic) . ",";
                    $contents.=sprintf('%.2f', $HRA) . ",";
                    $contents.= sprintf('%.2f', $Conveyance) . ",";
                    $contents.= sprintf('%.2f', $Skill_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Medical_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Child_Education) . ",";
                    $contents.= sprintf('%.2f', $Special_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Total_Gross) . ",";
                    $contents.= sprintf('%.2f', $ESI_Employee) . ",";
                    $contents.= sprintf('%.2f', $PF_Employee) . ",";
                    $contents.= sprintf('%.2f', $Professional_Tax) . ",";
                    $contents.= sprintf('%.2f', $Insurance) . ",";
                    $contents.= sprintf('%.2f', $Income_Tax) . ",";
                    $contents.= sprintf('%.2f', $Deduction_Others) . ",";
                    $contents.= sprintf('%.2f', $Total_Deductions) . ",";
                    $contents.= sprintf('%.2f', $Attendance_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Salary_Arrears) . ",";
                    $contents.= sprintf('%.2f', $Night_Shift_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Weekend_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Referral_Bonus) . ",";
                    $contents.= sprintf('%.2f', $Additional_Others) . ",";
                    $contents.= sprintf('%.2f', $Total_Income) . ",";
                    $contents.= sprintf('%.2f', $Net_Amount) . ",";
                    $contents.= sprintf('%.2f', $Per_Day_Salary) . "\n";

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
            }

            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.=sprintf('%.2f', $Total_C_CTC) . ",";
            $contents.=sprintf('%.2f', $Total_Monthly_CTC) . ",";
            $contents.=sprintf('%.2f', $Total_Employer_ESI_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Employer_PF_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Basicpay_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Hra_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Conveyance_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Skill_allowance_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Medical_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Child_education_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Special_allowance_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Total_Fixed_Gross_Company) . ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= sprintf('%.2f', $Total_Basic) . ",";
            $contents.= sprintf('%.2f', $Total_HRA) . ",";
            $contents.= sprintf('%.2f', $Total_Conveyance) . ",";
            $contents.= sprintf('%.2f', $Total_Skill_Allowance) . ",";
            $contents.= sprintf('%.2f', $Total_Medical_Allowance) . ",";
            $contents.= sprintf('%.2f', $Total_Child_Education) . ",";
            $contents.= sprintf('%.2f', $Total_Special_Allowance) . ",";
            $contents.= sprintf('%.2f', $Total_Total_Gross) . ",";
            $contents.= sprintf('%.2f', $Total_ESI_Employee) . ",";
            $contents.= sprintf('%.2f', $Total_PF_Employee) . ",";
            $contents.= sprintf('%.2f', $Total_Professional_Tax) . ",";
            $contents.= sprintf('%.2f', $Total_Insurance) . ",";
            $contents.= sprintf('%.2f', $Total_Income_Tax) . ",";
            $contents.= sprintf('%.2f', $Total_Deduction_Others) . ",";
            $contents.= sprintf('%.2f', $Total_Total_Deductions) . ",";
            $contents.= sprintf('%.2f', $Total_Attendance_Allowance) . ",";
            $contents.= sprintf('%.2f', $Total_Salary_Arrears) . ",";
            $contents.= sprintf('%.2f', $Total_Night_Shift_Allowance) . ",";
            $contents.= sprintf('%.2f', $Total_Weekend_Allowance) . ",";
            $contents.= sprintf('%.2f', $Total_Referral_Bonus) . ",";
            $contents.= sprintf('%.2f', $Total_Additional_Others) . ",";
            $contents.= sprintf('%.2f', $Total_Total_Income) . ",";
            $contents.= sprintf('%.2f', $Total_Net_Amount) . ",";
            $contents.= sprintf('%.2f', $Total_Per_Day_Salary) . "\n";

            $filename = $Mon_name . "_" . $year . "_Statement.csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            print $contents;
        } else if ($export_type == "Arrears_Statement")
          {
            $contents = "Employee Name,";
            $contents .= "Employee Id,";
            $contents .= "Bank Name,";
            $contents .= "IFSC Code,";
            $contents .= "Account Number,";
            $contents .= "Gender,";
            $contents .= "DOJ,";
            $contents .= "Employee Status,";
            $contents .= "Designation,";
            $contents .= "Department,";
            $contents .= "Date Of Birth,";
            $contents .= "Marital Status,";
            $contents .= "Father's Name,";
            $contents .= "PF Number,";
            $contents .= "UAN Number,";
            $contents .= "ESI,";
            $contents .= "PAN Card,";
            $contents .= "Appraised Annual CTC,";
            $contents .= "Monthly CTC,";
            $contents .= "Employer ESI,";
            $contents .= "Employer PF,";
            $contents .= "Basic + DA,";
            $contents .= "HRA,";
            $contents .= "Conveyance,";
            $contents .= "Skill Allowance,";
            $contents .= "Medical,";
            $contents .= "Child Education,";
            $contents .= "Special Allowance,";
            $contents .= "Total Fixed Gross,";
            $contents .= "No. of Days,";
            $contents .= "No. of Days Arrear,";
            $contents .= "Basic + DA,";
            $contents .= "HRA,";
            $contents .= "Conveyance,";
            $contents .= "Skill Allowance,";
            $contents .= "Medical,";
            $contents .= "Child Education,";
            $contents .= "Special Allowance,";
            $contents .= "Total Actual Gross,";
            $contents .= "Employee ESI,";
            $contents .= "Employee PF,";
            $contents .= "Professional Tax,";
            $contents .= "Insurance,";
            $contents .= "Income Tax,";
            $contents .= "Others Allowance,";
            $contents .= "Total Deductions,";
            $contents .= "Attendance,";
            $contents .= "Night Shift,";
            $contents .= "Weekend Allowance,";
            $contents .= "Referral Bonus,";
            $contents .= "Other Allowance,";
            $contents .= "Total Income,";
            $contents .= "Net Salary,";
            $contents .= "Per Day Salary,";
            $contents .="\n";

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

            $month = $this->input->post('export_payroll_month');
            $year = $this->input->post('export_payroll_year');
            $Mon_name = date('F', mktime(0, 0, 0, $month, 10));
            $get_data = array(
                'Month' => $month,
                'Year' => $year,
                'Status' => 1
            );
            $this->db->where($get_data);
            $q_payslip = $this->db->get('tbl_payslip_arrear');
            $count_payslip = $q_payslip->num_rows();
            if ($count_payslip != 0) {
                foreach ($q_payslip->result() as $row_payslip) {
                    $Payslip_Id = $row_payslip->Payslip_Id;
                    $Emp_Id = $row_payslip->Emp_Id;
                    $employee_id = str_pad(($Emp_Id), 4, '0', STR_PAD_LEFT);
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
                        $Emp_name = $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename;
                        $Emp_Gender = $row_employee->Emp_Gender;
                        $Emp_Doj = $row_employee->Emp_Doj;
                        $doj = date("d-M-Y", strtotime($Emp_Doj));
                        $Emp_Mode = $row_employee->Emp_Mode;
                        $Emp_Dob = $row_employee->Emp_Dob;
                        $dob = date("d-M-Y", strtotime($Emp_Dob));
                    }

                    $this->db->where('Employee_Id', $employee_id);
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
                    $this->db->where('Employee_Id', $employee_id);
                    $q_personal = $this->db->get('tbl_employee_personal');
                    foreach ($q_personal->result() as $row_personal) {
                        $Emp_Marrial = $row_personal->Emp_Marrial;
                    }

                    $family_data = array(
                        'Employee_Id' => $employee_id,
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

                    $contents.= $Emp_name . ",";
                    $contents.= $emp_code . $employee_id . ",";
                    $contents.= $Emp_Bankname . ",";
                    $contents.= $Emp_IFSCcode . ",";
                    $contents.= "'" . $Emp_Accno . ",";
                    $contents.= $Emp_Gender . ",";
                    $contents.=$doj . ",";
                    $contents.=$Emp_Mode . ",";
                    $contents.=$designation_name . ",";
                    $contents.=$department_name . ",";
                    $contents.=$dob . ",";
                    $contents.=$Emp_Marrial . ",";
                    $contents.=$father_name . ",";
                    $contents.=$Emp_PFno . ",";
                    $contents.=$Emp_UANno . ",";
                    $contents.=$Emp_ESI . ",";
                    $contents.=$Emp_PANcard . ",";
                    $contents.=sprintf('%.2f', $C_CTC) . ",";
                    $contents.=sprintf('%.2f', $Monthly_CTC) . ",";
                    $contents.=sprintf('%.2f', $Employer_ESI_Company) . ",";
                    $contents.=sprintf('%.2f', $Employer_PF_Company) . ",";
                    $contents.=sprintf('%.2f', $Basicpay_Company) . ",";
                    $contents.=sprintf('%.2f', $Hra_Company) . ",";
                    $contents.=sprintf('%.2f', $Conveyance_Company) . ",";
                    $contents.=sprintf('%.2f', $Skill_allowance_Company) . ",";
                    $contents.=sprintf('%.2f', $Medical_Company) . ",";
                    $contents.=sprintf('%.2f', $Child_education_Company) . ",";
                    $contents.=sprintf('%.2f', $Special_allowance_Company) . ",";
                    $contents.=sprintf('%.2f', $Total_Fixed_Gross_Company) . ",";
                    $contents.=$No_Of_Days . ",";
                    $contents.=$No_Of_Days_Present . ",";
                    $contents.=sprintf('%.2f', $Basic) . ",";
                    $contents.=sprintf('%.2f', $HRA) . ",";
                    $contents.= sprintf('%.2f', $Conveyance) . ",";
                    $contents.= sprintf('%.2f', $Skill_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Medical_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Child_Education) . ",";
                    $contents.= sprintf('%.2f', $Special_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Total_Gross) . ",";
                    $contents.= sprintf('%.2f', $ESI_Employee) . ",";
                    $contents.= sprintf('%.2f', $PF_Employee) . ",";
                    $contents.= sprintf('%.2f', $Professional_Tax) . ",";
                    $contents.= sprintf('%.2f', $Insurance) . ",";
                    $contents.= sprintf('%.2f', $Income_Tax) . ",";
                    $contents.= sprintf('%.2f', $Deduction_Others) . ",";
                    $contents.= sprintf('%.2f', $Total_Deductions) . ",";
                    $contents.= sprintf('%.2f', $Attendance_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Night_Shift_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Weekend_Allowance) . ",";
                    $contents.= sprintf('%.2f', $Referral_Bonus) . ",";
                    $contents.= sprintf('%.2f', $Additional_Others) . ",";
                    $contents.= sprintf('%.2f', $Total_Income) . ",";
                    $contents.= sprintf('%.2f', $Net_Amount) . ",";
                    $contents.= sprintf('%.2f', $Per_Day_Salary) . "\n";

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
            }

            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.= ",";
            $contents.=sprintf('%.2f', $Total_C_CTC) . ",";
            $contents.=sprintf('%.2f', $Total_Monthly_CTC) . ",";
            $contents.=sprintf('%.2f', $Total_Employer_ESI_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Employer_PF_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Basicpay_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Hra_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Conveyance_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Skill_allowance_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Medical_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Child_education_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Special_allowance_Company) . ",";
            $contents.=sprintf('%.2f', $Total_Total_Fixed_Gross_Company) . ",";
            $contents.= ",";
            $contents.= ",";
            $contents.=sprintf('%.2f', $Total_Basic) . ",";
            $contents.=sprintf('%.2f', $Total_HRA) . ",";
            $contents.=sprintf('%.2f', $Total_Conveyance) . ",";
            $contents.=sprintf('%.2f', $Total_Skill_Allowance) . ",";
            $contents.=sprintf('%.2f', $Total_Medical_Allowance) . ",";
            $contents.=sprintf('%.2f', $Total_Child_Education) . ",";
            $contents.=sprintf('%.2f', $Total_Special_Allowance) . ",";
            $contents.=sprintf('%.2f', $Total_Total_Gross) . ",";
            $contents.=sprintf('%.2f', $Total_ESI_Employee) . ",";
            $contents.=sprintf('%.2f', $Total_PF_Employee) . ",";
            $contents.=sprintf('%.2f', $Total_Professional_Tax) . ",";
            $contents.=sprintf('%.2f', $Total_Insurance) . ",";
            $contents.=sprintf('%.2f', $Total_Income_Tax) . ",";
            $contents.=sprintf('%.2f', $Total_Deduction_Others) . ",";
            $contents.=sprintf('%.2f', $Total_Total_Deductions) . ",";
            $contents.=sprintf('%.2f', $Total_Attendance_Allowance) . ",";
            $contents.=sprintf('%.2f', $Total_Night_Shift_Allowance) . ",";
            $contents.=sprintf('%.2f', $Total_Weekend_Allowance) . ",";
            $contents.=sprintf('%.2f', $Total_Referral_Bonus) . ",";
            $contents.=sprintf('%.2f', $Total_Additional_Others) . ",";
            $contents.=sprintf('%.2f', $Total_Total_Income) . ",";
            $contents.=sprintf('%.2f', $Total_Net_Amount) . ",";
            $contents.= sprintf('%.2f', $Total_Per_Day_Salary) . "\n";

            $filename = $Mon_name . "_" . $year . "_Arrear_Statement.csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            print $contents;
        }
    }

    /* Payslip Info End Here */

    /* Arrear Statement Start Here */

    public function Arrear() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Payslip',
                'main_content' => 'payslip/arrear'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function arrear_preview() {
        $employee_list = $this->input->post('employee_list');
        $year_list = $this->input->post('preview_year');
        $month_list = $this->input->post('preview_month');
        $data = array(
            'Emp_Id' => $employee_list,
            'Month' => $month_list,
            'Year' => $year_list
        );
        $this->load->view('payslip/arrear_preview', $data);
    }

    public function Editarrear_payslip() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Payslip',
                'main_content' => 'payslip/edit_arrear_payslip'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_arrear_payslip() {
        $this->form_validation->set_rules('edit_paysliparrear_nodays', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_present', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_additionalinsurance', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_incometax', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_deductionothers', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_salaryadvance', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_attendance', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_nightshift', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_weekend', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_referralbonus', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_additionalothers', '', 'trim|required');
        $this->form_validation->set_rules('edit_paysliparrear_incentives', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $payslip_id = $this->input->post('edit_payslip_id');
            $employee_id = $this->input->post('edit_paysliparrear_emp_no');
            $Monthly_CTC = $this->input->post('edit_paysliparrear_mctc');
            $C_CTC = $Monthly_CTC * 12;
            $year = $this->input->post('edit_paysliparrear_year');
            $month = $this->input->post('edit_paysliparrear_month');
            $no_of_days = $this->input->post('edit_paysliparrear_nodays');
            $no_of_days_present = $this->input->post('edit_paysliparrear_present');
            $additional_insurance1 = $this->input->post('edit_paysliparrear_additionalinsurance');
            $additional_insurance = str_replace(',', '', $additional_insurance1);
            $income_tax1 = $this->input->post('edit_paysliparrear_incometax');
            $income_tax = str_replace(',', '', $income_tax1);
            $deduction_others1 = $this->input->post('edit_paysliparrear_deductionothers');
            $deduction_others = str_replace(',', '', $deduction_others1);
            $salary_advance1 = $this->input->post('edit_paysliparrear_salaryadvance');
            $salary_advance = str_replace(',', '', $salary_advance1);
            $attendance1 = $this->input->post('edit_paysliparrear_attendance');
            $attendance = str_replace(',', '', $attendance1);
            $night_shift1 = $this->input->post('edit_paysliparrear_nightshift');
            $night_shift = str_replace(',', '', $night_shift1);
            $weekend1 = $this->input->post('edit_paysliparrear_weekend');
            $weekend = str_replace(',', '', $weekend1);
            $referal_bonus1 = $this->input->post('edit_paysliparrear_referralbonus');
            $referal_bonus = str_replace(',', '', $referal_bonus1);
            $additional_others1 = $this->input->post('edit_paysliparrear_additionalothers');
            $additional_others = str_replace(',', '', $additional_others1);
            $incentives1 = $this->input->post('edit_paysliparrear_incentives');
            $incentives = str_replace(',', '', $incentives1);
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

            $monthly_basicpay = ($Basicpay / $no_of_days) * $no_of_days_present;
            $monthly_hra = ($Hra / $no_of_days) * $no_of_days_present;
            $monthly_conveyance = ($Conveyance / $no_of_days) * $no_of_days_present;
            $monthly_skill_allowance = ($Skill_allowance / $no_of_days) * $no_of_days_present;
            $monthly_medical = ($Medical / $no_of_days) * $no_of_days_present;
            $monthly_child_education = ($Child_education / $no_of_days) * $no_of_days_present;
            $monthly_special = ($Special_allowance / $no_of_days) * $no_of_days_present;
            $total_actual_gross = $monthly_basicpay + $monthly_hra + $monthly_conveyance + $monthly_skill_allowance + $monthly_medical + $monthly_child_education + $monthly_special;
            if ($Employer_ESI > 0) {
                if ($Total_Fixed_Gross <= 21000) {
                    $monthly_employee_esi = ($total_actual_gross * 1.75) / 100;
                } else {
                    $monthly_employee_esi = 0;
                }
            } else {
                $monthly_employee_esi = 0;
            }
            $monthly_employee_PF_amount = (($monthly_basicpay + $monthly_special) * 12) / 100;
            if ($monthly_employee_PF_amount >= 1800) {
                $monthly_employee_PF = 1800;
            } else {
                $monthly_employee_PF = $monthly_employee_PF_amount;
            }

            $monthly_prof_tax = 0;
            $monthly_insurance = 0;
            $monthly_incometax = $income_tax;
            $monthly_deduction_others = $deduction_others;
            $monthly_salary_advance = $salary_advance;
            $total_deduction = $monthly_employee_esi + $monthly_employee_PF + $monthly_prof_tax + $monthly_insurance + $monthly_incometax + $monthly_deduction_others + $monthly_salary_advance;
            $total_income = $attendance + $night_shift + $weekend + $referal_bonus + $additional_others + $incentives;
            $net_salary = $total_income + $total_actual_gross - $total_deduction;
            $amount_words = $this->convert_number_to_words(round($net_salary));
            $total_earnings = $total_income + $total_actual_gross;
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data = array(
                'Emp_Id' => $employee_id,
                'Month' => $month,
                'Year' => $year,
                'Monthly_CTC' => $Monthly_CTC,
                'No_Of_Days' => $no_of_days,
                'No_Of_Days_Arrear' => $no_of_days_present,
                'Basic' => number_format(round($monthly_basicpay), 2, '.', ','),
                'HRA' => number_format(round($monthly_hra), 2, '.', ','),
                'Conveyance' => number_format(round($monthly_conveyance), 2, '.', ','),
                'Skill_Allowance' => number_format(round($monthly_skill_allowance), 2, '.', ','),
                'Medical_Allowance' => number_format(round($monthly_medical), 2, '.', ','),
                'Child_Education' => number_format(round($monthly_child_education), 2, '.', ','),
                'Special_Allowance' => number_format(round($monthly_special), 2, '.', ','),
                'Total_Gross' => number_format(round($total_actual_gross), 2, '.', ','),
                'ESI_Employee' => number_format(round($monthly_employee_esi), 2, '.', ','),
                'PF_Employee' => number_format(round($monthly_employee_PF), 2, '.', ','),
                'Professional_Tax' => number_format(round($monthly_prof_tax), 2, '.', ','),
                'Additioanl_Insurance' => number_format(round($additional_insurance), 2, '.', ','),
                'Insurance' => number_format(round($monthly_insurance), 2, '.', ','),
                'Income_Tax' => number_format(round($monthly_incometax), 2, '.', ','),
                'Deduction_Others' => number_format(round($monthly_deduction_others), 2, '.', ','),
                'Salary_Advance' => number_format(round($monthly_salary_advance), 2, '.', ','),
                'Total_Deductions' => number_format(round($total_deduction), 2, '.', ','),
                'Attendance_Allowance' => number_format(round($attendance), 2, '.', ','),
                'Night_Shift_Allowance' => number_format(round($night_shift), 2, '.', ','),
                'Weekend_Allowance' => number_format(round($weekend), 2, '.', ','),
                'Referral_Bonus' => number_format(round($referal_bonus), 2, '.', ','),
                'Additional_Others' => number_format(round($additional_others), 2, '.', ','),
                'Incentives' => number_format(round($incentives), 2, '.', ','),
                'Total_Income' => number_format(round($total_income), 2, '.', ','),
                'Total_Earnings' => number_format(round($total_earnings), 2, '.', ','),
                'Net_Amount' => number_format(round($net_salary), 2, '.', ','),
                'Amount_Words' => ucwords($amount_words) . " Rupees Only",
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Payslip_Id', $payslip_id);
            $q = $this->db->update('tbl_payslip_arrear', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deletearrear_payslip() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $payslip_id = $this->input->post('payslip_id');
            $data = array(
                'payslip_id' => $payslip_id
            );
            $this->load->view('payslip/delete_arrear_payslip', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_arrear_payslip() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $payslip_id = $this->input->post('delete_arrear_payslip_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Payslip_Id', $payslip_id);
            $q = $this->db->update('tbl_payslip_arrear', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Arrear Statement End Here */

    function convert_number_to_words($number) {
        $hyphen = ' ';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }
        return $string;
    }

	public function Employee() {
        $data = array(
            'title' => 'Payslip',
            'main_content' => 'payslip/employee'
        );
        $this->load->view('Common/content', $data);
    }

    public function Emppreview() {
        $employee_list = $this->input->post('employee_list');
        $year_list = $this->input->post('year_list');
        $month_list = $this->input->post('month_list');
        $data = array(
            'Emp_Id' => $employee_list,
            'Month' => $month_list,
            'Year' => $year_list
        );
        $this->load->view('payslip/preview', $data);
    }
	
    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   