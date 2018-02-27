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
        $employee_list = $this->input->post('employee_list');
        $year_list = $this->input->post('preview_year');
        $month_list = $this->input->post('preview_month');
        $data = array(
            'Emp_Id' => $employee_list,
            'Month' => $month_list,
            'Year' => $year_list
        );
        $this->load->view('payslip/preview', $data);
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
            if ($Basic >= 8000) {
                $Basicpay = $Basic;
            } else {
                $Basicpay = 8000;
            }
            if ($C_CTC <= 250000) {
                $Hra = ($Basicpay * 10) / 100;
            } else {
                $Hra = ($Basicpay * 40) / 100;
            }
            if ($Basicpay >= 8000) {
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

            $no_of_days_present = $no_of_days - $no_of_days_lop;
            $monthly_basicpay = ($Basicpay / $no_of_days) * $no_of_days_present;
            $monthly_hra = ($Hra / $no_of_days) * $no_of_days_present;
            $monthly_conveyance = ($Conveyance / $no_of_days) * $no_of_days_present;
            $monthly_skill_allowance = ($Skill_allowance / $no_of_days) * $no_of_days_present;
            $monthly_medical = ($Medical / $no_of_days) * $no_of_days_present;
            $monthly_child_education = ($Child_education / $no_of_days) * $no_of_days_present;
            $monthly_special = ($Special_allowance / $no_of_days) * $no_of_days_present;
            $total_actual_gross = $monthly_basicpay + $monthly_hra + $monthly_conveyance + $monthly_skill_allowance + $monthly_medical + $monthly_child_education + $monthly_special;
            if ($total_actual_gross <= 15000) {
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
            $amount_words = $this->convert_number_to_words($net_salary);
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

    function import_payslip() {
        $filename = $_FILES["import_payslipfile"]["tmp_name"];
        if ($_FILES["import_payslipfile"]["size"] > 0) {
            $file = fopen($filename, "r");
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $n = 1;
            while (($payslipData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($n != 1) {
                    $empcode = $payslipData[1];
                    $year = $payslipData[2];
                    $month = $payslipData[3];
                    $employee_id = str_replace('DRN/', '', $empcode);
                    $data_payslip = array(
                        'Emp_Id' => $employee_id,
                        'Month' => $month,
                        'Year' => $year,
                        'Status' => 1
                    );
                    $this->db->where($data_payslip);
                    $q_payslip = $this->db->get('tbl_payslip_info');
                    $count_payslip = $q_payslip->num_rows();

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
                            $salary_arrears = filter_var(round(str_replace(',', '', $row_arrear_payslip->Net_Amount)), FILTER_SANITIZE_NUMBER_INT);
                        }
                    } else {
                        $salary_arrears = 0;
                    }

                    $no_of_days = $payslipData[4];
                    $disclop = $payslipData[5];
                    $leaveballop = $payslipData[6];
                    $lopoffered = $payslipData[7];
                    $no_of_days_lop = $disclop + $leaveballop + $lopoffered;
                    $additional_insurance = $payslipData[8];
                    $income_tax = $payslipData[9];
                    $deduction_others = $payslipData[10];
                    $salary_advance = $payslipData[11];
                    $attendance = $payslipData[12];
                    //$salary_arrears = $payslipData[13];
                    $night_shift = $payslipData[13];
                    $weekend = $payslipData[14];
                    $referal_bonus = $payslipData[15];
                    $additional_others = $payslipData[16];
                    $incentives = $payslipData[17];
                    $Basic = ($Monthly_CTC * 45) / 100;
                    if ($Basic >= 8000) {
                        $Basicpay = $Basic;
                    } else {
                        $Basicpay = 8000;
                    }
                    if ($C_CTC <= 250000) {
                        $Hra = ($Basicpay * 10) / 100;
                    } else {
                        $Hra = ($Basicpay * 40) / 100;
                    }
                    if ($Basicpay >= 8000) {
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

                    $no_of_days_present = $no_of_days - $no_of_days_lop;
                    $monthly_basicpay = ($Basicpay / $no_of_days) * $no_of_days_present;
                    $monthly_hra = ($Hra / $no_of_days) * $no_of_days_present;
                    $monthly_conveyance = ($Conveyance / $no_of_days) * $no_of_days_present;
                    $monthly_skill_allowance = ($Skill_allowance / $no_of_days) * $no_of_days_present;
                    $monthly_medical = ($Medical / $no_of_days) * $no_of_days_present;
                    $monthly_child_education = ($Child_education / $no_of_days) * $no_of_days_present;
                    $monthly_special = ($Special_allowance / $no_of_days) * $no_of_days_present;
                    $total_actual_gross = $monthly_basicpay + $monthly_hra + $monthly_conveyance + $monthly_skill_allowance + $monthly_medical + $monthly_child_education + $monthly_special;
                    if ($total_actual_gross <= 15000) {
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
                    $amount_words = $this->convert_number_to_words($net_salary);
                    $total_earnings = $total_income + $total_actual_gross;
                    $sess_data = $this->session->all_userdata();
                    $inserted_id = $sess_data['user_id'];
                    if ($count_payslip == 0) {
                        $insert_data = array(
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
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_payslip_info', $insert_data);
                    } else {
                        foreach ($q_payslip->result() as $row_payslip) {
                            $payslip_id = $row_payslip->Payslip_Id;
                        }
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
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->where('Payslip_Id', $payslip_id);
                        $this->db->update('tbl_payslip_info', $update_data);
                    }
                }
                $n++;
            }
            echo "success";
            // fclose($file);
        }
    }

    function export_payslip() {
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

        $month = $this->input->post('month_list');
        $year = $this->input->post('year_list');
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
                //  $Basic = filter_var(round(str_replace(',', '', $row_payslip->Basic)), FILTER_SANITIZE_NUMBER_INT);
                $HRA = filter_var(round(str_replace(',', '', $row_payslip->HRA)), FILTER_SANITIZE_NUMBER_INT);
                $Conveyance = filter_var(round(str_replace(',', '', $row_payslip->Conveyance)), FILTER_SANITIZE_NUMBER_INT);
                $Skill_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Skill_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Medical_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Medical_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Child_Education = filter_var(round(str_replace(',', '', $row_payslip->Child_Education)), FILTER_SANITIZE_NUMBER_INT);
                $Special_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Special_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Gross = filter_var(round(str_replace(',', '', $row_payslip->Total_Gross)), FILTER_SANITIZE_NUMBER_INT);
                $ESI_Employee = filter_var(round(str_replace(',', '', $row_payslip->ESI_Employee)), FILTER_SANITIZE_NUMBER_INT);
                $PF_Employee = filter_var(round(str_replace(',', '', $row_payslip->PF_Employee)), FILTER_SANITIZE_NUMBER_INT);
                $Professional_Tax = filter_var(round(str_replace(',', '', $row_payslip->Professional_Tax)), FILTER_SANITIZE_NUMBER_INT);
                $Insurance = filter_var(round(str_replace(',', '', $row_payslip->Insurance)), FILTER_SANITIZE_NUMBER_INT);
                $Income_Tax = filter_var(round(str_replace(',', '', $row_payslip->Income_Tax)), FILTER_SANITIZE_NUMBER_INT);
                $Deduction_Others = filter_var(round(str_replace(',', '', $row_payslip->Deduction_Others)), FILTER_SANITIZE_NUMBER_INT);
                $Salary_Advance = filter_var(round(str_replace(',', '', $row_payslip->Salary_Advance)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Deductions = filter_var(round(str_replace(',', '', $row_payslip->Total_Deductions)), FILTER_SANITIZE_NUMBER_INT);
                $Attendance_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Attendance_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                //$Salary_Arrears = filter_var(round(str_replace(',', '', $row_payslip->Salary_Arrears)), FILTER_SANITIZE_NUMBER_INT);
                $Night_Shift_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Night_Shift_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Weekend_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Weekend_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Referral_Bonus = filter_var(round(str_replace(',', '', $row_payslip->Referral_Bonus)), FILTER_SANITIZE_NUMBER_INT);
                $Additional_Others = filter_var(round(str_replace(',', '', $row_payslip->Additional_Others)), FILTER_SANITIZE_NUMBER_INT);
                $Incentives = filter_var(round(str_replace(',', '', $row_payslip->Incentives)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Income = filter_var(round(str_replace(',', '', $row_payslip->Total_Income)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Earnings = filter_var(round(str_replace(',', '', $row_payslip->Total_Earnings)), FILTER_SANITIZE_NUMBER_INT);
                $Net_Amount = filter_var(round(str_replace(',', '', $row_payslip->Net_Amount)), FILTER_SANITIZE_NUMBER_INT);
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
                if ($Basic_Company >= 8000) {
                    $Basicpay_Company = $Basic_Company;
                } else {
                    $Basicpay_Company = 8000;
                }
                if ($C_CTC <= 250000) {
                    $Hra_Company = ($Basicpay_Company * 10) / 100;
                } else {
                    $Hra_Company = ($Basicpay_Company * 40) / 100;
                }
                if ($Basicpay_Company >= 8000) {
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
                if ($Total_Fixed_Gross_Company <= 15000) {
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
                if ($Total_Fixed_Gross_Company <= 15000) {
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
                $contents.=$C_CTC . ",";
                $contents.=$Monthly_CTC . ",";
                $contents.=$Employer_ESI_Company . ",";
                $contents.=$Employer_PF_Company . ",";
                $contents.=$Basicpay_Company . ",";
                $contents.=$Hra_Company . ",";
                $contents.=$Conveyance_Company . ",";
                $contents.=$Skill_allowance_Company . ",";
                $contents.=$Medical_Company . ",";
                $contents.=$Child_education_Company . ",";
                $contents.=$Special_allowance_Company . ",";
                $contents.=$Total_Fixed_Gross_Company . ",";
                $contents.=$No_Of_Days . ",";
                $contents.=$No_Of_Days_Present . ",";
                $contents.=$No_Of_Days_LOP . ",";
                $contents.=$Basic . ",";
                $contents.=$HRA . ",";
                $contents.= $Conveyance . ",";
                $contents.= $Skill_Allowance . ",";
                $contents.= $Medical_Allowance . ",";
                $contents.= $Child_Education . ",";
                $contents.= $Special_Allowance . ",";
                $contents.= $Total_Gross . ",";
                $contents.= $ESI_Employee . ",";
                $contents.= $PF_Employee . ",";
                $contents.= $Professional_Tax . ",";
                $contents.= $Insurance . ",";
                $contents.= $Income_Tax . ",";
                $contents.= $Deduction_Others . ",";
                $contents.= $Total_Deductions . ",";
                $contents.= $Attendance_Allowance . ",";
                $contents.= $Salary_Arrears . ",";
                $contents.= $Night_Shift_Allowance . ",";
                $contents.= $Weekend_Allowance . ",";
                $contents.= $Referral_Bonus . ",";
                $contents.= $Additional_Others . ",";
                $contents.= $Total_Income . ",";
                $contents.= $Net_Amount . ",";
                $contents.= $Per_Day_Salary . "\n";
            }
        }
        $filename = $Mon_name . "_Statement.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        print $contents;
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
            if ($Basic >= 8000) {
                $Basicpay = $Basic;
            } else {
                $Basicpay = 8000;
            }
            if ($C_CTC <= 250000) {
                $Hra = ($Basicpay * 10) / 100;
            } else {
                $Hra = ($Basicpay * 40) / 100;
            }
            if ($Basicpay >= 8000) {
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

            $monthly_basicpay = ($Basicpay / $no_of_days) * $no_of_days_present;
            $monthly_hra = ($Hra / $no_of_days) * $no_of_days_present;
            $monthly_conveyance = ($Conveyance / $no_of_days) * $no_of_days_present;
            $monthly_skill_allowance = ($Skill_allowance / $no_of_days) * $no_of_days_present;
            $monthly_medical = ($Medical / $no_of_days) * $no_of_days_present;
            $monthly_child_education = ($Child_education / $no_of_days) * $no_of_days_present;
            $monthly_special = ($Special_allowance / $no_of_days) * $no_of_days_present;
            $total_actual_gross = $monthly_basicpay + $monthly_hra + $monthly_conveyance + $monthly_skill_allowance + $monthly_medical + $monthly_child_education + $monthly_special;
			if ($Employer_ESI > 0) {
            if ($total_actual_gross <= 15000) {
                $monthly_employee_esi = ($total_actual_gross * 1.75) / 100;
            } else {
                $monthly_employee_esi = 0;
            }
			}else{
				 $monthly_employee_esi = 0;
			}
            $monthly_employee_PF_amount = (($monthly_basicpay + $monthly_special) * 12) / 100;
            if ($monthly_employee_PF_amount >= 1800) {
                $monthly_employee_PF = 1800;
            } else {
                $monthly_employee_PF = $monthly_employee_PF_amount;
            }
       
			$monthly_prof_tax=0;
            $monthly_insurance=0;
            $monthly_incometax = $income_tax;
            $monthly_deduction_others = $deduction_others;
            $monthly_salary_advance = $salary_advance;
            $total_deduction = $monthly_employee_esi + $monthly_employee_PF + $monthly_prof_tax + $monthly_insurance + $monthly_incometax + $monthly_deduction_others + $monthly_salary_advance;
            $total_income = $attendance + $night_shift + $weekend + $referal_bonus + $additional_others + $incentives;
            $net_salary = $total_income + $total_actual_gross - $total_deduction;
            $amount_words = $this->convert_number_to_words($net_salary);
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

    function import_salary_arrear() {
        $filename = $_FILES["import_salary_arrearfile"]["tmp_name"];
        if ($_FILES["import_salary_arrearfile"]["size"] > 0) {
            $file = fopen($filename, "r");
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $n = 1;
            while (($payslipData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($n != 1) {
                    $empcode = $payslipData[1];
                    $year = $payslipData[2];
                    $month = $payslipData[3];
                    $employee_id = str_replace('DRN/', '', $empcode);
                    $data_payslip = array(
                        'Emp_Id' => $employee_id,
                        'Month' => $month,
                        'Year' => $year,
                        'Status' => 1
                    );
                    $this->db->where($data_payslip);
                    $q_payslip = $this->db->get('tbl_payslip_arrear');
                    $count_payslip = $q_payslip->num_rows();

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

                    $no_of_days = $payslipData[4];
                    $no_of_days_arrear = $payslipData[5];
                    $additional_insurance = $payslipData[6];
                    $income_tax = $payslipData[7];
                    $deduction_others = $payslipData[8];
                    $salary_advance = $payslipData[9];
                    $attendance = $payslipData[10];
                    $night_shift = $payslipData[11];
                    $weekend = $payslipData[12];
                    $referal_bonus = $payslipData[13];
                    $additional_others = $payslipData[14];
                    $incentives = $payslipData[15];
                    $Basic = ($Monthly_CTC * 45) / 100;
                    if ($Basic >= 8000) {
                        $Basicpay = $Basic;
                    } else {
                        $Basicpay = 8000;
                    }
                    if ($C_CTC <= 250000) {
                        $Hra = ($Basicpay * 10) / 100;
                    } else {
                        $Hra = ($Basicpay * 40) / 100;
                    }
                    if ($Basicpay >= 8000) {
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

                    $monthly_basicpay = ($Basicpay / $no_of_days) * $no_of_days_arrear;
                    $monthly_hra = ($Hra / $no_of_days) * $no_of_days_arrear;
                    $monthly_conveyance = ($Conveyance / $no_of_days) * $no_of_days_arrear;
                    $monthly_skill_allowance = ($Skill_allowance / $no_of_days) * $no_of_days_arrear;
                    $monthly_medical = ($Medical / $no_of_days) * $no_of_days_arrear;
                    $monthly_child_education = ($Child_education / $no_of_days) * $no_of_days_arrear;
                    $monthly_special = ($Special_allowance / $no_of_days) * $no_of_days_arrear;
                    $total_actual_gross = $monthly_basicpay + $monthly_hra + $monthly_conveyance + $monthly_skill_allowance + $monthly_medical + $monthly_child_education + $monthly_special;
					if ($Employer_ESI > 0) {
                    if ($total_actual_gross <= 15000) {
                        $monthly_employee_esi = ($total_actual_gross * 1.75) / 100;
                    } else {
                        $monthly_employee_esi = 0;
                    }
					}else{
						 $monthly_employee_esi = 0;
					}
                    $monthly_employee_PF_amount = (($monthly_basicpay + $monthly_special) * 12) / 100;
                    if ($monthly_employee_PF_amount >= 1800) {
                        $monthly_employee_PF = 1800;
                    } else {
                        $monthly_employee_PF = $monthly_employee_PF_amount;
                    }
					
					$monthly_prof_tax=0;
					$monthly_insurance=0;
                    $monthly_incometax = $income_tax;
                    $monthly_deduction_others = $deduction_others;
                    $monthly_salary_advance = $salary_advance;
                    $total_deduction = $monthly_employee_esi + $monthly_employee_PF + $monthly_prof_tax + $monthly_insurance + $monthly_incometax + $monthly_deduction_others + $monthly_salary_advance;
                    $total_income = $attendance + $night_shift + $weekend + $referal_bonus + $additional_others + $incentives;
                    $net_salary = $total_income + $total_actual_gross - $total_deduction;
                    $amount_words = $this->convert_number_to_words($net_salary);
                    $total_earnings = $total_income + $total_actual_gross;
                    $sess_data = $this->session->all_userdata();
                    $inserted_id = $sess_data['user_id'];
                    if ($count_payslip == 0) {
                        $insert_data = array(
                            'Emp_Id' => $employee_id,
                            'Month' => $month,
                            'Year' => $year,
                            'Monthly_CTC' => $Monthly_CTC,
                            'No_Of_Days' => $no_of_days,
                            'No_Of_Days_Arrear' => $no_of_days_arrear,
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
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_payslip_arrear', $insert_data);
                    } else {
                        foreach ($q_payslip->result() as $row_payslip) {
                            $payslip_id = $row_payslip->Payslip_Id;
                        }
                        $update_data = array(
                            'Emp_Id' => $employee_id,
                            'Month' => $month,
                            'Year' => $year,
                            'Monthly_CTC' => $Monthly_CTC,
                            'No_Of_Days' => $no_of_days,
                            'No_Of_Days_Arrear' => $no_of_days_arrear,
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
                        $this->db->update('tbl_payslip_arrear', $update_data);
                    }
                }
                $n++;
            }
            echo "success";
            // fclose($file);
        }
    }

    function export_arrear_payslip() {
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

        $month = $this->input->post('arrear_month_list');
        $year = $this->input->post('arrear_year_list');
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
                $Basic = filter_var(round(str_replace(',', '', $row_payslip->Basic)), FILTER_SANITIZE_NUMBER_INT);
                $HRA = filter_var(round(str_replace(',', '', $row_payslip->HRA)), FILTER_SANITIZE_NUMBER_INT);
                $Conveyance = filter_var(round(str_replace(',', '', $row_payslip->Conveyance)), FILTER_SANITIZE_NUMBER_INT);
                $Skill_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Skill_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Medical_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Medical_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Child_Education = filter_var(round(str_replace(',', '', $row_payslip->Child_Education)), FILTER_SANITIZE_NUMBER_INT);
                $Special_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Special_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Gross = filter_var(round(str_replace(',', '', $row_payslip->Total_Gross)), FILTER_SANITIZE_NUMBER_INT);
                $ESI_Employee = filter_var(round(str_replace(',', '', $row_payslip->ESI_Employee)), FILTER_SANITIZE_NUMBER_INT);
                $PF_Employee = filter_var(round(str_replace(',', '', $row_payslip->PF_Employee)), FILTER_SANITIZE_NUMBER_INT);
                $Professional_Tax = filter_var(round(str_replace(',', '', $row_payslip->Professional_Tax)), FILTER_SANITIZE_NUMBER_INT);
                $Insurance = filter_var(round(str_replace(',', '', $row_payslip->Insurance)), FILTER_SANITIZE_NUMBER_INT);
                $Income_Tax = filter_var(round(str_replace(',', '', $row_payslip->Income_Tax)), FILTER_SANITIZE_NUMBER_INT);
                $Deduction_Others = filter_var(round(str_replace(',', '', $row_payslip->Deduction_Others)), FILTER_SANITIZE_NUMBER_INT);
                $Salary_Advance = filter_var(round(str_replace(',', '', $row_payslip->Salary_Advance)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Deductions = filter_var(round(str_replace(',', '', $row_payslip->Total_Deductions)), FILTER_SANITIZE_NUMBER_INT);
                $Attendance_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Attendance_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Night_Shift_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Night_Shift_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Weekend_Allowance = filter_var(round(str_replace(',', '', $row_payslip->Weekend_Allowance)), FILTER_SANITIZE_NUMBER_INT);
                $Referral_Bonus = filter_var(round(str_replace(',', '', $row_payslip->Referral_Bonus)), FILTER_SANITIZE_NUMBER_INT);
                $Additional_Others = filter_var(round(str_replace(',', '', $row_payslip->Additional_Others)), FILTER_SANITIZE_NUMBER_INT);
                $Incentives = filter_var(round(str_replace(',', '', $row_payslip->Incentives)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Income = filter_var(round(str_replace(',', '', $row_payslip->Total_Income)), FILTER_SANITIZE_NUMBER_INT);
                $Total_Earnings = filter_var(round(str_replace(',', '', $row_payslip->Total_Earnings)), FILTER_SANITIZE_NUMBER_INT);
                $Net_Amount = filter_var(round(str_replace(',', '', $row_payslip->Net_Amount)), FILTER_SANITIZE_NUMBER_INT);
                $Amount_Words = $row_payslip->Amount_Words;

                $C_CTC = $Monthly_CTC * 12;
                $Basic_Company = ($Monthly_CTC * 45) / 100;
                if ($Basic_Company >= 8000) {
                    $Basicpay_Company = $Basic_Company;
                } else {
                    $Basicpay_Company = 8000;
                }
                if ($C_CTC <= 250000) {
                    $Hra_Company = ($Basicpay_Company * 10) / 100;
                } else {
                    $Hra_Company = ($Basicpay_Company * 40) / 100;
                }
                if ($Basicpay_Company >= 8000) {
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
                if ($Total_Fixed_Gross_Company <= 15000) {
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
                if ($Total_Fixed_Gross_Company <= 15000) {
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
                $contents.=$C_CTC . ",";
                $contents.=$Monthly_CTC . ",";
                $contents.=$Employer_ESI_Company . ",";
                $contents.=$Employer_PF_Company . ",";
                $contents.=$Basicpay_Company . ",";
                $contents.=$Hra_Company . ",";
                $contents.=$Conveyance_Company . ",";
                $contents.=$Skill_allowance_Company . ",";
                $contents.=$Medical_Company . ",";
                $contents.=$Child_education_Company . ",";
                $contents.=$Special_allowance_Company . ",";
                $contents.=$Total_Fixed_Gross_Company . ",";
                $contents.=$No_Of_Days . ",";
                $contents.=$No_Of_Days_Present . ",";
                $contents.=$Basic . ",";
                $contents.=$HRA . ",";
                $contents.= $Conveyance . ",";
                $contents.= $Skill_Allowance . ",";
                $contents.= $Medical_Allowance . ",";
                $contents.= $Child_Education . ",";
                $contents.= $Special_Allowance . ",";
                $contents.= $Total_Gross . ",";
                $contents.= $ESI_Employee . ",";
                $contents.= $PF_Employee . ",";
                $contents.= $Professional_Tax . ",";
                $contents.= $Insurance . ",";
                $contents.= $Income_Tax . ",";
                $contents.= $Deduction_Others . ",";
                $contents.= $Total_Deductions . ",";
                $contents.= $Attendance_Allowance . ",";
                $contents.= $Night_Shift_Allowance . ",";
                $contents.= $Weekend_Allowance . ",";
                $contents.= $Referral_Bonus . ",";
                $contents.= $Additional_Others . ",";
                $contents.= $Total_Income . ",";
                $contents.= $Net_Amount . ",";
                $contents.= $Per_Day_Salary . "\n";
            }
        }
        $filename =$Mon_name . "_Arrear_Statement.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        print $contents;
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

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   