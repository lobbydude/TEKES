<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        self::$db = & get_instance()->db;
    }

public function Index_old() {
       // $logged_user = get_current_user();
		$logged_user=$this->uri->segment(2);
        $data = array(
           // 'Username' => $logged_user,
		'Employee_Id' => $logged_user,
        'Status' => 1
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_user');
        $count = $q->num_rows();
        if ($count == 1) {
            $row = $q->row_array();
            $sess_data = array(
                'user_id' => $row['User_id'],
                'emp_username' => $row['Username'],
                'username' => $row['Employee_Id'],
                'user_role' => $row['User_RoleId'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($sess_data);
            redirect('Profile');
        } else {
            echo "invalid";
        }
        //$this->load->view('Login/Index');
    }

    public function Index() {
        $this->load->view('Login/Index');
    }

    public function validate() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE) {    
			date_default_timezone_set("Asia/Kolkata");		
            $username = $this->input->post('username');
            $password = base64_encode($this->input->post('password'));

            $data = array(
                'Username' => $username,
                'Password' => $password
            );
            $this->db->where($data);
            $q = $this->db->get('tbl_user');
            $count = $q->num_rows();
            if ($count == 1) {
                $row = $q->row_array();
                $sess_data = array(
                    'user_id' => $row['User_id'],
                    'emp_username' => $row['Username'],
                    'username' => $row['Employee_Id'],
                    'password' => $row['Password'],
                    'user_role' => $row['User_RoleId'],
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($sess_data);
				
				// Carry forward Shift time details start here
                $current_month = date('m');
                        $current_year = date('Y');
                $get_shiftall_data = array(
                    'Employee_Id' => $row['Employee_Id'],
                    'Month' => $current_month,
                    'Year' => $current_year,
                    'Status' => 1
                );
                $this->db->where($get_shiftall_data);
                $q_shiftall = $this->db->get('tbl_shift_allocate');
                $count_shiftall = $q_shiftall->num_rows();
                if ($count_shiftall == 0) {
                    $get_carry_data = array(
                        'Employee_Id' => $row['Employee_Id'],
                        'Month' => $current_month - 1,
                        'Year' => $current_year,
                        'Status' => 1
                    );
                    $this->db->where($get_carry_data);
                    $q_shift_carry = $this->db->get('tbl_shift_allocate');
                    $count_shift_carry = $q_shift_carry->num_rows();
                    if ($count_shift_carry != 0) {
                        foreach ($q_shift_carry->result() as $row_shift_carry) {
                            $shift_id = $row_shift_carry->Shift_Id;
                        }
                        
                        $num = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
                        for ($i = 1; $i <= $num; $i++) {
                            $mktime = mktime(0, 0, 0, $current_month, $i, $current_year);
                            $date_n = date("Y-m-d", $mktime);
                            // Month to Date convertaion End
							
                            $insert_shift_all_data = array(
                                'Year' => $current_year,
                                'Month' => $current_month,
                                'Shift_Id' => $shift_id,
                                'Employee_Id' => $row['Employee_Id'],
                                'Date' => $date_n,
                                'Inserted_By' => $row['User_id'],
                                'Inserted_Date' => date('Y-m-d H:i:s'),
                                'Status' => 1
                            );
                            $this->db->insert('tbl_shift_allocate', $insert_shift_all_data);
                        }
                    }
                }
                // Carry forward Shift time details End here
				$get_att = array(
                    'Emp_Id' => $row['Employee_Id'],
                    'Login_Date' => date('Y-m-d'),
                    'Status' => 1
                );
                $this->db->where($get_att);
                $q_att = $this->db->get('tbl_attendance');
                $count_att = $q_att->num_rows();
                $totay = date("Y-m-d");
                $yes_date = date("Y-m-d", strtotime("$totay -1 day"));
                $get_attendance_data = array(
                    'Emp_Id' => $row['Employee_Id'],
                    'Login_Date' => $yes_date,
                    'Status' => 1
                );
                $this->db->where($get_attendance_data);
                $q_attendance = $this->db->get('tbl_attendance');
				$count_attendance = $q_attendance->num_rows();
				if($count_attendance==1){
                foreach ($q_attendance->result() as $row_attendance) {
                    $Login_Time = $row_attendance->Login_Time;
                }
				}else{
				$Login_Time="";
				}
                $yest_datetime = StrToTime($yes_date . ' ' . $Login_Time);
                $today_datetime = StrToTime(date('Y-m-d H:i:s'));
                $diff = $today_datetime - $yest_datetime;
                $hours = $diff / ( 60 * 60 );
				
				$login_time = date('H:i:s');
				$daytime_start = '01:00:00';
                $daytime_end = '11:59:00';
                $midtime_start = '12:00:00';
                $midtime_end = '16:59:00';
                $nighttime_start = '17:00:00';
                $nighttime_end = '23:59:00';
                if ((strtotime($daytime_start) <= strtotime($login_time)) && (strtotime($login_time) <= strtotime($daytime_end))) {
                    $shift = 'DS';
                }
                if ((strtotime($midtime_start) <= strtotime($login_time)) && (strtotime($login_time) <= strtotime($midtime_end))) {
                    $shift = 'MS';
                }
                if ((strtotime($nighttime_start) <= strtotime($login_time)) && (strtotime($login_time) <= strtotime($nighttime_end))) {
                    $shift = 'NS';
                }
                //if ($hours > 14) {
                    if ($count_att == 0) {
                        $insert_attendance_data = array(
                            'Emp_Id' => $row['Employee_Id'],
                            'Login_Date' => date('Y-m-d'),
                            'Login_Time' => date('H:i:s'),
							'Shift_Name' => $shift,
                            'Inserted_By' => $row['User_id'],
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_attendance', $insert_attendance_data);
                    }
					if ($count_att == 1) {
                    foreach ($q_att->result() as $row_att) {
                        $exit_Login_date = $row_att->Login_Date;
                        $exit_Login_Time = $row_att->Login_Time;
                        $exit_Logout_date = $row_att->Logout_Date;
                        $exit_Logout_Time = $row_att->Logout_Time;
                        if (strtotime($exit_Logout_Time) != strtotime("00:00:00")) {
                            $diff_logout_time = strtotime("$exit_Login_date $exit_Login_Time");
                            $diff_login_time = strtotime("$exit_Logout_date $exit_Logout_Time");
                            $timediff = round(abs($diff_logout_time - $diff_login_time) / 60, 2);                            
                            $total_hours = gmdate("H:i:s", $timediff);                                                                                                               
                            if (strtotime($total_hours) >= strtotime("00:90:30")) {
                                $insert_attendance_data = array(
                                    'Emp_Id' => $row['Employee_Id'],
                                    'Login_Date' => date('Y-m-d'),
                                    'Login_Time' => $current_time,
                                    'Shift_Name' => $shift,
                                    'Inserted_By' => $row['User_id'],
                                    'Inserted_Date' => date('Y-m-d H:i:s'),
                                    'Status' => 1
                                );
                                $this->db->insert('tbl_attendance', $insert_attendance_data);
                            }
                        }
                    }
                }
                //}
                echo $row['User_RoleId'];
            } else {
                echo "invalid";
            }
        } else {
            $this->load->view('error');
        }
    }

}

?>
