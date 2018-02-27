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

    /* Payslip Details Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2) {
            $data = array(
                'title' => 'Payslip',
                'main_content' => 'payslip/index'
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

            while (($payslipData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $emp_number = $payslipData[1];
                $employee_id = str_pad(($emp_number), 4, '0', STR_PAD_LEFT);
                $payslip_month = $payslipData[2];
                $payslip_year = $payslipData[3];
                $No_of_days_worked = $payslipData[4];
                $No_of_days_lop = $payslipData[5];
                $Basic = $payslipData[6];
                $HRA = $payslipData[7];
                $Conveyance = $payslipData[8];
                $Medical = $payslipData[9];
                $Special = $payslipData[10];
                $Attendance = $payslipData[11];
                $Weekend = $payslipData[12];
                $Night_Shift = $payslipData[13];
                $Referral = $payslipData[14];
                $Incentives = $payslipData[15];
                $Arears = $payslipData[16];
                $Total_Gross = $payslipData[17];
                $Total_Inc = $payslipData[18];
                $PF = $payslipData[19];
                $ESI = $payslipData[20];
                $Insurance = $payslipData[21];
                $Salary_Advance = $payslipData[22];
                $Prof_Tax = $payslipData[23];
                $Income_Tax = $payslipData[24];
                $Total_Deductions = $payslipData[25];
                $Total_Gross1 = str_replace(',', '', $Total_Gross);
                $Total_Inc1 = str_replace(',', '', $Total_Inc);
                $Total_Earnings = $Total_Gross1 + $Total_Inc1;
                $Total_Earnings1 = number_format((float) $Total_Earnings, 2, '.', '');
                $Total_Deductions1 = str_replace(',', '', $Total_Deductions);
                $Net_Amount = $Total_Earnings1 - $Total_Deductions1;

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
                        'Basic' => $Basic,
                        'HRA' => $HRA,
                        'Conveyance' => $Conveyance,
                        'Medical_Allowance' => $Medical,
                        'Special_Allowance' => $Special,
                        'Attendance_Allowance' => $Attendance,
                        'Weekend_Allowance' => $Weekend,
                        'Night_Shift_Allowance' => $Night_Shift,
                        'Referral_Bonus' => $Referral,
                        'Incentives' => $Incentives,
                        'Arrears' => $Arears,
                        'Total_Gross' => $Total_Gross,
                        'Total_Inc' => $Total_Inc,
                        'Total_Earnings' => $Total_Earnings1,
                        'PF_Employee' => $PF,
                        'ESI_Employee' => $ESI,
                        'Insurance' => $Insurance,
                        'Salary_Advance' => $Salary_Advance,
                        'Professional_Tax' => $Prof_Tax,
                        'Income_Tax' => $Income_Tax,
                        'Total_Deductions' => $Total_Deductions,
                        'Net_Amount' => $Net_Amount,
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
                        'Basic' => $Basic,
                        'HRA' => $HRA,
                        'Conveyance' => $Conveyance,
                        'Medical_Allowance' => $Medical,
                        'Special_Allowance' => $Special,
                        'Attendance_Allowance' => $Attendance,
                        'Weekend_Allowance' => $Weekend,
                        'Night_Shift_Allowance' => $Night_Shift,
                        'Referral_Bonus' => $Referral,
                        'Incentives' => $Incentives,
                        'Arrears' => $Arears,
                        'Total_Gross' => $Total_Gross,
                        'Total_Inc' => $Total_Inc,
                        'Total_Earnings' => $Total_Earnings1,
                        'PF_Employee' => $PF,
                        'ESI_Employee' => $ESI,
                        'Insurance' => $Insurance,
                        'Salary_Advance' => $Salary_Advance,
                        'Professional_Tax' => $Prof_Tax,
                        'Income_Tax' => $Income_Tax,
                        'Total_Deductions' => $Total_Deductions,
                        'Net_Amount' => $Net_Amount,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('tbl_payslip', $insert_data);
                }
            }

            echo "success";
            // fclose($file);
        }
    }

    public function payslip() {
       // $user_role = $this->session->userdata('user_role');
       // if ($user_role == 2) {
            $employee_list = $this->input->post('employee_list');
            $year_list = $this->input->post('year_list');
            $month_list = $this->input->post('month_list');
            $data = array(
                'Emp_Id' => $employee_list,
                'Month' => $month_list,
                'Year' => $year_list
            );
            $this->load->view('payslip/payslip', $data);
       // } else {
       //     redirect("Profile");
       // }
    }

 public function salary() {
        $data = array(
            'title' => 'Payslip',
            'main_content' => 'payslip/salary'
        );
        $this->load->view('Common/content', $data);
    }

    /* Payslip End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   