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
        $this->form_validation->set_rules('add_salary_CCTC', '', 'trim|required');
        $this->form_validation->set_rules('add_salary_MonthlyCTC', '', 'trim|required');
        $this->form_validation->set_rules('add_salary_from', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('add_salary_emp_no');
            $CCTC = $this->input->post('add_salary_CCTC');
            $MonthlyCTC = $this->input->post('add_salary_MonthlyCTC');
            $from_date = $this->input->post('add_salary_from');
            if ($from_date == "") {
                $from = "";
            } else {
                $from = date("Y-m-d", strtotime($from_date));
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
                'From_Date' => $from,
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
            //$this->load->view('error');
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
            $this->form_validation->set_rules('edit_salary_CCTC', '', 'trim|required');
            $this->form_validation->set_rules('edit_salary_MonthlyCTC', '', 'trim|required');
            $this->form_validation->set_rules('edit_salary_from', '', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $salary_id = $this->input->post('edit_salary_id');
                $CCTC = $this->input->post('edit_salary_CCTC');
                $MonthlyCTC = $this->input->post('edit_salary_MonthlyCTC');
                $from_date = $this->input->post('edit_salary_from');
                $from = date("Y-m-d", strtotime($from_date));
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
                    'From_Date' => $from,
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
                //$this->load->view('error');
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

    public function Viewsalary() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $salary_id = $this->input->post('salary_id');
            $data = array(
                'salary_id' => $salary_id
            );
            $this->load->view('salary/view_salary', $data);
        } else {
            redirect("Profile");
        }
    }

   function import_salary() {
        $filename = $_FILES["import_salaryfile"]["tmp_name"];
        if ($_FILES["import_salaryfile"]["size"] > 0) {
            $file = fopen($filename, "r");
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $n = 1;
            while (($salaryData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($n != 1) {
                    $empcode = $salaryData[1];
                    $Monthly_CTC = $salaryData[2];
                    $employee_id = str_replace('DRN/', '', $empcode);
                    $C_CTC = $Monthly_CTC * 12;
                    $from_date = $salaryData[3];
                    $to_date = $salaryData[4];
                    if ($from_date == "") {
                        $from = "";
                    } else {
                        $from = date("Y-d-m", strtotime($from_date));
                    }
                    if ($to_date == "") {
                        $to = "";
                    } else {
                        $to = date("Y-d-m", strtotime($to_date));
                    }
                    $sess_data = $this->session->all_userdata();
                    $inserted_id = $sess_data['user_id'];
                    $insert_data = array(
                        'Employee_Id' => $employee_id,
                        'C_CTC' => $C_CTC,
                        'Monthly_CTC' => $Monthly_CTC,
                        'From_Date' => $from,
                        'To_Date' => $to,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $this->db->insert('tbl_salary_info', $insert_data);
                }
                $n++;
            }
            echo "success";
            // fclose($file);
        }
    }

    /* Salary Info End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   