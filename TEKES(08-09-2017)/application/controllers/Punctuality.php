<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Punctuality extends CI_Controller {

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
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $data = array(
                'title' => 'Punctuality',
                'main_content' => 'punctuality/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function calculate() {
        $employee_no = $this->input->post('employee_list');
        $preview_year = $this->input->post('preview_year');
        $preview_month = $this->input->post('preview_month');
        $period_from1 = "01-" . $preview_month . "-" . $preview_year;
        $period_from = date("Y-m-d", strtotime($period_from1));
        $total_days = cal_days_in_month(CAL_GREGORIAN, $preview_month, $preview_year);
        $period_to1 = "$total_days-" . $preview_month . "-" . $preview_year;
        $period_to = date("Y-m-d", strtotime($period_to1));
        $period = new DatePeriod(new DateTime($period_from), new DateInterval('P1D'), new DateTime("$period_to +1 day"));
        $late_hour_count = 0;
        foreach ($period as $date) {
            $dates_month_1 = $date->format("Y-m-d");
            $data_shift_all = array(
                'Employee_Id' => $employee_no,
                'Date' => $dates_month_1,
                'Status' => 1
            );
            $this->db->where($data_shift_all);
            $q_shift_all = $this->db->get('tbl_shift_allocate');
            $count_shift_all = $q_shift_all->num_rows();
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
                }

                $date_1 = new DateTime($dates_month_1);
                $dat_no_1 = $date_1->format("N");
                if ($dat_no_1 != 6 || $dat_no_1 != 7) {
                    $holiday_data = array(
                        'Holiday_Date' => $dates_month_1,
                        'Status' => 1
                    );
                    $this->db->where($holiday_data);
                    $q_hol = $this->db->get('tbl_holiday');
                    $count_hol = $q_hol->num_rows();
                    if ($count_hol != 1) {
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
                                $Login_Date1 = $row_in->Login_Date;
                                $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                $Login_Time = $row_in->Login_Time;
                                $shift_grace_time1 = strtotime("+16 minutes", strtotime($Shift_From1));
                                $shift_grace_time = date('H:i:s', $shift_grace_time1);
                                if ($Shift_Name != "") {
                                    if (strtotime($shift_grace_time) < strtotime($Login_Time)) {
                                        $late_hour_count = $late_hour_count + 1;
                                    } else {
                                        $late_hour_count = $late_hour_count + 0;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($late_hour_count >= 1 && $late_hour_count <= 3) {
            echo 5;
        }
        if ($late_hour_count >= 4 && $late_hour_count <= 5) {
            echo 4;
        }
        if ($late_hour_count >= 6 && $late_hour_count <= 10) {
            echo 3;
        }
        if ($late_hour_count >= 11 && $late_hour_count <= 15) {
            echo 2;
        }
        if ($late_hour_count >= 16 && $late_hour_count <= 20) {
            echo 1;
        }
        if ($late_hour_count >= 21) {
            echo 0;
        }
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>