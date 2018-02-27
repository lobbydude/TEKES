<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Salary extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Payslip Details Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Payslip',
                'main_content' => 'salary/payslip/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

      public function import_payslip() {
        $filename = $_FILES["import_payslipfile"]["tmp_name"];
        if ($_FILES["import_payslipfile"]["size"] > 0) {
            $file = fopen($filename, "r");
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $i = 1;
            while (($payslipData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($i != 1) {
                    $emp_number = $payslipData[1];
                    $employee_id = str_pad(($emp_number), 4, '0', STR_PAD_LEFT);
                    $payslip_month = $payslipData[2];
                    $payslip_year = $payslipData[3];
                    $No_of_days_worked = $payslipData[4];
                    $No_of_days_lop = $payslipData[5];
                    if ($payslipData[6] == "") {
                        $Basic = 0;
                    } else {
                        $Basic = $payslipData[6];
                    }
                    if ($payslipData[7] == "") {
                        $HRA = 0;
                    } else {
                        $HRA = $payslipData[7];
                    }
                    if ($payslipData[8] == "") {
                        $Conveyance = 0;
                    } else {
                        $Conveyance = $payslipData[8];
                    }

                    if ($payslipData[9] == "") {
                        $Medical = 0;
                    } else {
                        $Medical = $payslipData[9];
                    }
                    if ($payslipData[10] == "") {
                        $Special = 0;
                    } else {
                        $Special = $payslipData[10];
                    }

                    if ($payslipData[11] == "") {
                        $Attendance = 0;
                    } else {
                        $Attendance = $payslipData[11];
                    }

                    if ($payslipData[12] == "") {
                        $Weekend = 0;
                    } else {
                        $Weekend = $payslipData[12];
                    }

                    if ($payslipData[13] == "") {
                        $Night_Shift = 0;
                    } else {
                        $Night_Shift = $payslipData[13];
                    }

                    if ($payslipData[14] == "") {
                        $Referral = 0;
                    } else {
                        $Referral = $payslipData[14];
                    }

                    if ($payslipData[15] == "") {
                        $Incentives = 0;
                    } else {
                        $Incentives = $payslipData[15];
                    }

                    if ($payslipData[16] == "") {
                        $Arears = 0;
                    } else {
                        $Arears = $payslipData[16];
                    }

                    if ($payslipData[17] == "") {
                        $Additional_others = 0;
                    } else {
                        $Additional_others = $payslipData[17];
                    }

                    if ($payslipData[18] == "") {
                        $Total_Gross = 0;
                    } else {
                        $Total_Gross = $payslipData[18];
                    }

                    if ($payslipData[19] == "") {
                        $PF = 0;
                    } else {
                        $PF = $payslipData[19];
                    }

                    if ($payslipData[20] == "") {
                        $ESI = 0;
                    } else {
                        $ESI = $payslipData[20];
                    }

                    if ($payslipData[21] == "") {
                        $Insurance = 0;
                    } else {
                        $Insurance = $payslipData[21];
                    }

                    if ($payslipData[22] == "") {
                        $Salary_Advance = 0;
                    } else {
                        $Salary_Advance = $payslipData[22];
                    }

                    if ($payslipData[23] == "") {
                        $Prof_Tax = 0;
                    } else {
                        $Prof_Tax = $payslipData[23];
                    }

                    if ($payslipData[24] == "") {
                        $Income_Tax = 0;
                    } else {
                        $Income_Tax = $payslipData[24];
                    }

                    if ($payslipData[25] == "") {
                        $Deduction_others = 0;
                    } else {
                        $Deduction_others = $payslipData[25];
                    }

                    if ($payslipData[26] == "") {
                        $Total_Deductions = 0;
                    } else {
                        $Total_Deductions = $payslipData[26];
                    }

                    if ($payslipData[27] == "") {
                        $Net_Amount = 0;
                    } else {
                        $Net_Amount = $payslipData[27];
                    }

                    $Net_Amount1 = str_replace(',', '', $Net_Amount);
                    $amount_words = $this->convert_number_to_words($Net_Amount1);
                    $get_data = array(
                        'Emp_Id' => $employee_id,
                        'Month' => $payslip_month,
                        'Year' => $payslip_year
                    );
                    $this->db->where($get_data);
                    $q_payslip = $this->db->get('tbl_payslip');
                    $count_payslip = $q_payslip->num_rows();
                    if ($count_payslip == 1) {
                        $update_data = array(
                            'No_Of_Days_Worked' => $No_of_days_worked,
                            'No_Of_Days_LOP' => $No_of_days_lop,
                            'Basic' => number_format("$Basic", 2),
                            'HRA' => number_format("$HRA", 2),
                            'Conveyance' => number_format("$Conveyance", 2),
                            'Medical_Allowance' => number_format("$Medical", 2),
                            'Special_Allowance' => number_format("$Special", 2),
                            'Attendance_Allowance' => number_format("$Attendance", 2),
                            'Weekend_Allowance' => number_format("$Weekend", 2),
                            'Night_Shift_Allowance' => number_format("$Night_Shift", 2),
                            'Referral_Bonus' => number_format("$Referral", 2),
                            'Incentives' => number_format("$Incentives", 2),
                            'Arrears' => number_format("$Arears", 2),
                            'Additional_Others' => number_format("$Additional_others", 2),
                            'Total_Gross' => number_format("$Total_Gross", 2),
                            'PF_Employee' => number_format("$PF", 2),
                            'ESI_Employee' => number_format("$ESI", 2),
                            'Insurance' => number_format("$Insurance", 2),
                            'Salary_Advance' => number_format("$Salary_Advance", 2),
                            'Professional_Tax' => number_format("$Prof_Tax", 2),
                            'Income_Tax' => number_format("$Income_Tax", 2),
                            'Deduction_Others' => number_format("$Deduction_others", 2),
                            'Total_Deductions' => number_format("$Total_Deductions", 2),
                            'Net_Amount' => number_format("$Net_Amount", 2),
                            'Amount_Words' => ucwords($amount_words) . " Rupees Only",
                            'Modified_By' => $inserted_id,
                            'Modified_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where($get_data);
                        $this->db->update('tbl_payslip', $update_data);
                    } else {
                        $insert_data = array(
                            'Emp_Id' => $employee_id,
                            'Month' => $payslip_month,
                            'Year' => $payslip_year,
                            'No_Of_Days_Worked' => $No_of_days_worked,
                            'No_Of_Days_LOP' => $No_of_days_lop,
                            'Basic' => number_format("$Basic", 2),
                            'HRA' => number_format("$HRA", 2),
                            'Conveyance' => number_format("$Conveyance", 2),
                            'Medical_Allowance' => number_format("$Medical", 2),
                            'Special_Allowance' => number_format("$Special", 2),
                            'Attendance_Allowance' => number_format("$Attendance", 2),
                            'Weekend_Allowance' => number_format("$Weekend", 2),
                            'Night_Shift_Allowance' => number_format("$Night_Shift", 2),
                            'Referral_Bonus' => number_format("$Referral", 2),
                            'Incentives' => number_format("$Incentives", 2),
                            'Arrears' => number_format("$Arears", 2),
                            'Total_Gross' => number_format("$Total_Gross", 2),
                            'PF_Employee' => number_format("$PF", 2),
                            'ESI_Employee' => number_format("$ESI", 2),
                            'Insurance' => number_format("$Insurance", 2),
                            'Salary_Advance' => number_format("$Salary_Advance", 2),
                            'Professional_Tax' => number_format("$Prof_Tax", 2),
                            'Income_Tax' => number_format("$Income_Tax", 2),
                            'Total_Deductions' => number_format("$Total_Deductions", 2),
                            'Net_Amount' => number_format("$Net_Amount", 2),
                            'Amount_Words' => ucwords($amount_words) . " Rupees Only",
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('tbl_payslip', $insert_data);
                    }
                }
                $i++;
            }

            echo "success";
            // fclose($file);
        }
    }

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

    public function preview() {
        $employee_list = $this->input->post('employee_list');
        $year_list = $this->input->post('year_list');
        $month_list = $this->input->post('month_list');
        $data = array(
            'Emp_Id' => $employee_list,
            'Month' => $month_list,
            'Year' => $year_list
        );
        $this->load->view('salary/payslip/preview', $data);
    }

    public function Employee() {
        $data = array(
            'title' => 'Payslip',
            'main_content' => 'salary/payslip/salary'
        );
        $this->load->view('Common/content', $data);
    }

    /* Payslip End Here */

	/* Salary Info Start Here */

    public function Info() {
        $data = array(
            'title' => 'Salary',
            'main_content' => 'salary/info'
        );
        $this->load->view('operation/content', $data);
    }

    public function add_salary() {
        $this->form_validation->set_rules('add_salary_CCTC', 'Current CTC', 'trim|required');
        $this->form_validation->set_rules('add_salary_MonthlyCTC', 'Monthly CTC', 'trim|required');
        $this->form_validation->set_rules('add_salary_Netsalary', 'Net Salary', 'trim|required');
        $this->form_validation->set_rules('add_salary_from', 'Join Date', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('add_salary_emp_no');
            $CCTC = $this->input->post('add_salary_CCTC');
            $MonthlyCTC = $this->input->post('add_salary_MonthlyCTC');
            $Netsalary = $this->input->post('add_salary_Netsalary');

            $joining_date = $this->input->post('add_salary_from');
            if ($joining_date == "") {
                $doj = "";
            } else {
                $doj = date("Y-m-d", strtotime($joining_date));
            }

            $to_date = $this->input->post('add_salary_to');
            if ($to_date == "") {
                $to = "";
            } else {
                $to = date("Y-m-d", strtotime($to_date));
            }

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'C_CTC' => $CCTC,
                'Monthly_CTC' => $MonthlyCTC,
                'Net_Salary' => $Netsalary,
                'From_Date' => $doj,
                'To_Date' => $to,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_salary_info', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Editsalary() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $salary_id = $this->input->post('salary_id');
            $data = array(
                'salary_id' => $salary_id
            );
            $this->load->view('salary/edit_salary', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_salary() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_salary_CCTC', 'Reporting To', 'trim|required');
            $this->form_validation->set_rules('edit_salary_MonthlyCTC', 'Reporting To', 'trim|required');
            $this->form_validation->set_rules('edit_salary_Netsalary', 'Reporting To', 'trim|required');
            $this->form_validation->set_rules('edit_salary_from', 'Join Date', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $salary_id = $this->input->post('edit_salary_id');
                $CCTC = $this->input->post('edit_salary_CCTC');
                $MonthlyCTC = $this->input->post('edit_salary_MonthlyCTC');
                $Netsalary = $this->input->post('edit_salary_Netsalary');

                $joining_date = $this->input->post('edit_salary_from');
                $doj = date("Y-m-d", strtotime($joining_date));

                $to_date = $this->input->post('edit_salary_to');
                if ($to_date == "") {
                    $to = "";
                } else {
                    $to = date("Y-m-d", strtotime($to_date));
                }

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $update_data = array(
                    'C_CTC' => $CCTC,
                    'Monthly_CTC' => $MonthlyCTC,
                    'Net_Salary' => $Netsalary,
                    'From_Date' => $doj,
                    'To_Date' => $to,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Sal_Id', $salary_id);
                $q = $this->db->update('tbl_salary_info', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletesalary() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $salary_id = $this->input->post('salary_id');
            $data = array(
                'salary_id' => $salary_id
            );
            $this->load->view('salary/delete_salary', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_salary() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $salary_id = $this->input->post('delete_salary_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Sal_Id', $salary_id);
            $q = $this->db->update('tbl_salary_info', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Salary Info End Here */
	
    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   