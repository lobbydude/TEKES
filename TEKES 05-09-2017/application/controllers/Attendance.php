<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Attendance extends CI_Controller {

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
        if ($user_role == 1 || $user_role == 2 || $user_role == 6 || $user_role == 7) {
            $data = array(
                'title' => 'Attendance',
                'main_content' => 'attendance/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }
	// Employee Daily Status start here
    public function DailyStatus() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6 || $user_role == 7) {
            $data = array(
                'title' => 'Daily Attendance',
                'main_content' => 'attendance/dailystatus'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }
	// Employee Daily Status End here

  public function Employee() {
        $data = array(
            'title' => 'Attendance',
            'main_content' => 'attendance/employee'
        );
        $this->load->view('common/content', $data);
    }

  public function import_attendance() {
        $filename = $_FILES["import_file"]["tmp_name"];
        if ($_FILES["import_file"]["size"] > 0) {
            $file = fopen($filename, "r");
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $uniq_id = uniqid();
            while (($empData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $emp_number = $empData[0];
                $employee_id = str_pad(($emp_number), 4, '0', STR_PAD_LEFT);

                $log_date = $empData[1];
                $date = str_replace('/', '-', $log_date);
                $login_date = date('Y-m-d', strtotime($date));

                $insert_data = array(
                    'Emp_Id' => $employee_id,
                    'Log_Date' => $login_date,
                    'Log_Time' => $empData[2],
                    'Type' => $empData[3],
                    'Shift_Name' => $empData[4],
                    'Shift_Start' => $empData[5],
                    'Shift_End' => $empData[6],
                    'Unique_Id' => $uniq_id,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_attendance_temporary', $insert_data);
            }

            /* Inserting to main table */

            $this->db->order_by('Log_Date', 'desc');
            $data_in = array(
                'Unique_Id' => $uniq_id,
                'Type' => "IN",
                'Status' => 1
            );
            $this->db->where($data_in);
            $this->db->group_by(array("Log_Date", "Emp_Id"));
            $q_in = $this->db->get('tbl_attendance_temporary');
            $count_in = $q_in->num_rows();

            if ($count_in > 0) {
                foreach ($q_in->Result() as $row_in) {
                    $A_Id_in = $row_in->A_Id;

                    $Login_Date = $row_in->Log_Date;
                    // $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                    $Login_Time = $row_in->Log_Time;

                    $shift_name = $row_in->Shift_Name;
                    $employee_id = $row_in->Emp_Id;

                    if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                        $data_out = array(
                            'Unique_Id' => $uniq_id,
                            'Type' => "OUT",
                            'Log_Date' => date("Y-m-d", strtotime("$Login_Date +1 day")),
                            'Emp_Id' => $employee_id,
                            'Status' => 1
                        );
                    } else {
                        $data_out = array(
                            'Unique_Id' => $uniq_id,
                            'Type' => "OUT",
                            'Log_Date' => $Login_Date,
                            'Emp_Id' => $employee_id,
                            'Status' => 1
                        );
                    }
                    $this->db->group_by('Log_Date');
                    $this->db->where($data_out);
                    $q_out = $this->db->get('tbl_attendance_temporary');

                    foreach ($q_out->result() as $row_out) {
                        $A_Id_out = $row_out->A_Id;
                        $Logout_Date = $row_out->Log_Date;
                        $Logout_Time = $row_out->Log_Time;

                        $insert_data1 = array(
                            'Emp_Id' => $employee_id,
                            'Login_Date' => $Login_Date,
                            'Login_Time' => $Login_Time,
                            'Logout_Date' => $Logout_Date,
                            'Logout_Time' => $Logout_Time,
                            'Shift_Name' => $shift_name,
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_attendance', $insert_data1);
                    }
                }
            }
            echo "success";
            // fclose($file);
        }
    }

	 function add_attendance() {
        $this->form_validation->set_rules('add_att_employee_name', '', 'trim|required');
        $this->form_validation->set_rules('add_att_login_date', '', 'trim|required');
        $this->form_validation->set_rules('add_att_login_time', '', 'trim|required');
        $this->form_validation->set_rules('add_att_logout_date', '', 'trim|required');
        $this->form_validation->set_rules('add_att_logout_time', '', 'trim|required');
		$this->form_validation->set_rules('add_shiftname', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $add_att_employee_name = $this->input->post('add_att_employee_name');
            $add_att_login_date = $this->input->post('add_att_login_date');
            $login_date = date("Y-m-d", strtotime($add_att_login_date));
            $login_time1 = $this->input->post('add_att_login_time');
            $login_time=date("H:i:s", strtotime($login_time1));
            $add_att_logout_date = $this->input->post('add_att_logout_date');
            $logout_date = date("Y-m-d", strtotime($add_att_logout_date));
            $logout_time1 = $this->input->post('add_att_logout_time');
            $logout_time=date("H:i:s", strtotime($logout_time1));
			$add_shiftname = $this->input->post('add_shiftname');
			$add_comments = $this->input->post('add_comments');
			
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $get_attendance_data =array(
                'Emp_Id' => $add_att_employee_name,
                'Login_Date' => $login_date,
                'Status' => 1
            );
            $this->db->where($get_attendance_data);
            $q_attendance = $this->db->get('tbl_attendance');
            $count_attendance = $q_attendance->num_rows();
            if ($count_attendance == 0) {
                $attendance_data = array(
                    'Emp_Id' => $add_att_employee_name,
                    'Login_Date' => $login_date,
                    'Login_Time' => $login_time,
                    'Logout_Date' => $logout_date,
                    'Logout_Time' => $logout_time,
					'Shift_Name' => $add_shiftname,
					'Comments'=>$add_comments,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'status' => 1
                );
                $q = $this->db->insert('tbl_attendance', $attendance_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "exists";
            }
        } else {
            $this->load->view('error');
        }
    }
	
    public function Editattendance() {
        $att_id_in = $this->input->post('att_id_in');
        $data = array(
            'att_id_in' => $att_id_in,
        );
        $this->load->view('attendance/edit_attendance', $data);
    }

    function edit_attendance() {
        $this->form_validation->set_rules('edit_att_login_date', '', 'trim|required');
        $this->form_validation->set_rules('edit_att_login_time', '', 'trim|required');
		$this->form_validation->set_rules('edit_shiftname', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $att_id_in = $this->input->post('edit_att_id_in');
            $login_date1 = $this->input->post('edit_att_login_date');
            $login_date = date("Y-m-d", strtotime($login_date1));
            $login_time = $this->input->post('edit_att_login_time');
			$edit_shiftname = $this->input->post('edit_shiftname');
			$edit_comments = $this->input->post('edit_comments');
            $logout_date1 = $this->input->post('edit_att_logout_date');
           if ($logout_date1 == "") {
                $logout_date = "";
            } else {
                $logout_date = date("Y-m-d", strtotime($logout_date1));
            }
            $logout_time = $this->input->post('edit_att_logout_time');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data1 = array(
                'Login_Date' => $login_date,
                'Login_Time' => $login_time,
                'Logout_Date' => $logout_date,
                'Logout_Time' => $logout_time,
				'Shift_Name' => $edit_shiftname,
				'Comments' => $edit_comments,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('A_Id', $att_id_in);
            $q = $this->db->update('tbl_attendance', $update_data1);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deleteattendance() {
        $att_id_in = $this->input->post('att_id_in');
        $data = array(
            'att_id_in' => $att_id_in
        );
        $this->load->view('attendance/delete_attendance', $data);
    }

    function delete_attendance() {
        $this->form_validation->set_rules('delete_att_id_in', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $delete_att_id_in = $this->input->post('delete_att_id_in');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data1 = array(
                'Status' => 0,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('A_Id', $delete_att_id_in);
            $q = $this->db->update('tbl_attendance', $update_data1);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function MonthTimesheet() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Attendance',
                'main_content' => 'attendance/month_timesheet'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

	public function MonthAttendance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Attendance',
                'main_content' => 'attendance/monthly_attendance'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }
	
     public function Editmonthlyattendance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $att_id_in = $this->input->post('att_id_in');
            $status = $this->input->post('status');
            $data = array(
                'att_id_in' => $att_id_in,
                'status' => $status
            );
            $this->load->view('attendance/edit_monthlyattendance', $data);
        }
    }

    function edit_monthlyattendance() {
        $this->form_validation->set_rules('edit_att_status', '', 'trim|required');
        $this->form_validation->set_rules('edit_att_type', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $edit_att_status = $this->input->post('edit_att_status');
            $edit_att_type = $this->input->post('edit_att_type');
            $edit_att_emp_id = $this->input->post('edit_att_emp_id');
            $att_id_in = $this->input->post('edit_att_id_in');
            $edit_att_login_date = $this->input->post('edit_att_login_date');
            $login_date = date("Y-m-d", strtotime($edit_att_login_date));
            $login_time1 = $this->input->post('edit_att_login_time');
            $login_time = date("H:i:s", strtotime($login_time1));
            $edit_att_logout_date = $this->input->post('edit_att_logout_date');
            if ($edit_att_logout_date == "") {
                $logout_date = "";
            } else {
                $logout_date = date("Y-m-d", strtotime($edit_att_logout_date));
            }
            $logout_time1 = $this->input->post('edit_att_logout_time');
            $logout_time = date("H:i:s", strtotime($logout_time1));
            $edit_lop_date = $this->input->post('edit_lop_date');
            $lop_date = date("Y-m-d", strtotime($edit_lop_date));
            $lop_remarks = $this->input->post('edit_lop_remarks');
            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];
            if ($edit_att_type == "Absent") {
                if ($edit_att_status == "Present") {
                    $update_data1 = array(
                        'Status' => 0,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('A_Id', $att_id_in);
                    $q = $this->db->update('tbl_attendance', $update_data1);
                }
                if ($edit_att_status == "Comp Off" || $edit_att_status == "LOP" || $edit_att_status == "Disciplinary LOP") {
                    $update_data2 = array(
                        'Status' => 0,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('A_M_Id', $att_id_in);
                    $q = $this->db->update('tbl_attendance_mark', $update_data2);
                }
            } else if ($edit_att_status == $edit_att_type) {
                if ($edit_att_type == "Present") {
                    $update_data3 = array(
                        'Login_Date' => $login_date,
                        'Login_Time' => $login_time,
                        'Logout_Date' => $logout_date,
                        'Logout_Time' => $logout_time,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('A_Id', $att_id_in);
                    $q = $this->db->update('tbl_attendance', $update_data3);
                }
                if ($edit_att_type == "Comp Off" || $edit_att_type == "LOP" || $edit_att_type == "Disciplinary LOP") {
                    $update_data4 = array(
                        'Date' => $lop_date,
                        'Type' => $edit_att_type,
                        'Remarks' => $lop_remarks,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('A_M_Id', $att_id_in);
                    $q = $this->db->update('tbl_attendance_mark', $update_data4);
                }
            } else {
                if ($edit_att_type == "Present") {
                    $update_data5 = array(
                        'Status' => 0,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('A_M_Id', $att_id_in);
                    $this->db->update('tbl_attendance_mark', $update_data5);
                    $insert_data1 = array(
                        'Emp_Id' => $edit_att_emp_id,
                        'Login_Date' => $login_date,
                        'Login_Time' => $login_time,
                        'Logout_Date' => $logout_date,
                        'Logout_Time' => $logout_time,
                        'Inserted_By' => $modified_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_attendance', $insert_data1);
                }
                if ($edit_att_type == "Comp Off" || $edit_att_type == "LOP" || $edit_att_type == "Disciplinary LOP") {
                    $update_data6 = array(
                        'Status' => 0,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s'),
                    );
                    $this->db->where('A_Id', $att_id_in);
                    $this->db->update('tbl_attendance', $update_data6);
                    $insert_data2 = array(
                        'Emp_Id' => $edit_att_emp_id,
                        'Date' => $lop_date,
                        'Type' => $edit_att_type,
                        'Remarks' => $lop_remarks,
                        'Inserted_By' => $modified_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_attendance_mark', $insert_data2);
                }
            }
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Edit_monthwise_attendance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $emp_no = $this->input->post('emp_id');
            $data = array(
                'emp_no' => $emp_no
            );
            $this->load->view('attendance/edit_monthtwise_attendance', $data);
        } else {
            redirect("Profile");
        }
    }

    public function Edit_MonthwiseAttendnace() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('edit_monthwise_att_empno');
            $att_type = $this->input->post('edit_monthwise_att_type');
             $inserted_id = $this->session->userdata('user_id');
            if ($att_type == "Present") {
                $login_date1 = $this->input->post('edit_monthwise_att_login_date');
                $login_date = date("Y-m-d", strtotime($login_date1));
                $login_time1 = $this->input->post('edit_monthwise_att_login_time');
                $login_time = date("H:i:s", strtotime($login_time1));
                $logout_date1 = $this->input->post('edit_monthwise_att_logout_date');
                $logout_date = date("Y-m-d", strtotime($logout_date1));
                $logout_time1 = $this->input->post('edit_monthwise_att_logout_time');
                $logout_time = date("H:i:s", strtotime($logout_time1));
                $insert_data1 = array(
                    'Emp_Id' => $emp_id,
                    'Login_Date' => $login_date,
                    'Login_Time' => $login_time,
                    'Logout_Date' => $logout_date,
                    'Logout_Time' => $logout_time,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_attendance', $insert_data1);
            } else {
                $lop_date1 = $this->input->post('edit_monthwise_lop_date');
                $lop_date = date("Y-m-d", strtotime($lop_date1));
                $lop_remarks = $this->input->post('edit_monthwise_lop_remarks');
                $insert_data2 = array(
                    'Emp_Id' => $emp_id,
                    'Date' => $lop_date,
                    'Type' => $att_type,
                    'Remarks' => $lop_remarks,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_attendance_mark', $insert_data2);
            }
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    function ExportTimesheet() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {

            $from_date = $this->input->post('export_attendance_from');
            $to_date = $this->input->post('export_attendance_to');

            $begin = new DateTime($from_date);
            $end = new DateTime($to_date);

            $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

            $contents = "Employee Id,";
            $contents .= "Employee Name,";
            $contents .= "DOJ,";
            $contents .= "No of Days,";
            foreach ($daterange as $date) {
                $contents .=$date->format('d-m-Y') . ",";
            }
            $contents .= "No. of Days Present (P),";
            $contents .= "No. of Day Leave (L),";
            $contents .= "No. of Days Half day Present (HP),";
            $contents .= "Total Week Off ( Sat/ Sun)(WO),";
            $contents .= "Total Week off worked (WP),";
            $contents .= "Total Holidays (H),";
            $contents .="\n";

            $emp_data = array(
                'Status' => 1
            );
            $this->db->where($emp_data);
            $sql_emp = $this->db->get('tbl_employee');
            foreach ($sql_emp->result() as $row_emp) {
                $emp_no = $row_emp->Emp_Number;
                $employee_id = str_pad(($emp_no), 4, '0', STR_PAD_LEFT);
                $emp_firstname = $row_emp->Emp_FirstName;
                $emp_middlename = $row_emp->Emp_MiddleName;
                $emp_lastname = $row_emp->Emp_LastName;
                $emp_name = $emp_firstname . " " . $emp_lastname . " " . $emp_middlename;
                $doj = $row_emp->Emp_Doj;
                $emp_doj = date("d-m-Y", strtotime($doj));
                $interval = date_diff(date_create(), date_create($doj));
                $no_days = $interval->format("%a");

                $export_data = array(
                    'Employee_Id' => $employee_id,
                    'Status' => 1
                );
                $this->db->where($export_data);
                $sql_export = $this->db->get('tbl_user');
                foreach ($sql_export->result() as $row_export) {
                    $emp_username = $row_export->Username;
                }
                $p = 0;
                $a = 0;
                $wp = 0;
                $wo = 0;
                $h = 0;
                $hp = 0;
                $contents.= $emp_username . ",";
                $contents.= $emp_name . ",";
                $contents.=$emp_doj . ",";
                $contents.=$no_days . ",";
                foreach ($daterange as $date) {
                    $date_1 = $date->format('d-m-Y');
                    $dates_month_1 = $date->format('Y-m-d');
                    $dat_no_1 = date('N', strtotime($date_1));
                    if ($dat_no_1 == 6 || $dat_no_1 == 7) {
                        $data_in = array(
                            'Type' => "IN",
                            'Emp_Id' => $emp_no,
                            'Log_Date' => $dates_month_1,
                            'Status' => 1
                        );
                        $this->db->where($data_in);
                        $this->db->group_by(array("Log_Date", "Emp_Id"));
                        $q_in = $this->db->get('tbl_attendance_temporary');
                        $count_in = $q_in->num_rows();
                        if ($count_in == 1) {
                            $contents .="P ,";
                            $wp = $wp + 1;
                        } else {
                            if ($dat_no_1 == 6) {
                                $contents .="SAT ,";
                            }if ($dat_no_1 == 7) {
                                $contents .="SUN ,";
                            }
                            $wo = $wo + 1;
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
                            $contents .="H ,";
                            $h = $h + 1;
                        } else {
                            $data_in = array(
                                'Type' => "IN",
                                'Emp_Id' => $emp_no,
                                'Log_Date' => $dates_month_1,
                                'Status' => 1
                            );
                            $this->db->where($data_in);
                            $this->db->group_by(array("Log_Date", "Emp_Id"));
                            $q_in = $this->db->get('tbl_attendance_temporary');
                            $count_in = $q_in->num_rows();
                            if ($count_in == 1) {
                                foreach ($q_in->result() as $row_in) {
                                    $A_Id_in = $row_in->A_Id;
                                    $Login_Date1 = $row_in->Log_Date;
                                    $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                    $Login_Time = $row_in->Log_Time;
                                    $shift_name = $row_in->Shift_Name;
                                    if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {

                                        $data_out = array(
                                            'Type' => "OUT",
                                            'Log_Date' => date("Y-m-d", strtotime("$Login_Date1 +1 day")),
                                            'Emp_Id' => $emp_no,
                                            'Status' => 1
                                        );
                                    } else {
                                        $data_out = array(
                                            'Type' => "OUT",
                                            'Log_Date' => $Login_Date1,
                                            'Emp_Id' => $emp_no,
                                            'Status' => 1
                                        );
                                    }
                                    $this->db->group_by('Log_Date');
                                    $this->db->where($data_out);
                                    $q_out = $this->db->get('tbl_attendance_temporary');
                                    foreach ($q_out->result() as $row_out) {
                                        $A_Id_out = $row_out->A_Id;
                                        $Logout_Date1 = $row_out->Log_Date;
                                        $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                        $Logout_Time = $row_out->Log_Time;

                                        $h1 = strtotime($Login_Time);
                                        $h2 = strtotime($Logout_Time);
                                        $seconds = $h2 - $h1;
                                        $total_hours = gmdate("H:i:s", $seconds);
                                        $min_time = "04:30:00";
                                        if ($total_hours > $min_time) {

                                            if ($shift_name == "NIGHT -1" || $shift_name == "NIGHT -2") {
                                                $contents .="NP ,";
                                            } else {
                                                $contents .="P ,";
                                            }
                                            $p = $p + 1;
                                        } else {
                                            $contents .="HP ,";
                                            $hp = $hp + 1;
                                        }
                                    }
                                }
                            } else {
                                $contents .="A ,";
                                $a = $a + 1;
                            }
                        }
                    }
                }
                $contents .=$p . ",";
                $contents .=$a . ",";
                $contents .=$hp . ",";
                $contents .=$wo . ",";
                $contents .=$wp . ",";
                $contents .=$h . ",";
                $contents .="\n";
            }

            $filename = "attendance.csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            print $contents;
        } else {
            redirect("Profile");
        }
    }

    function monthlyloginmovements() {
        $employee_id = $this->input->post('emp_id');
        $date = $this->input->post('date');
        $login_time = $this->input->post('login_time');
        $emp_id = str_pad(($employee_id), 4, '0', STR_PAD_LEFT);
        // echo $emp_id . " || " . $date . " || " . $login_time;
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['user_id'];

        $data_in = array(
            'Emp_Id' => $emp_id,
            'Login_Date' => $date,
            'Status' => 1
        );
        $this->db->where($data_in);
        $q_in = $this->db->get('tbl_attendance');
        $count_in = $q_in->num_rows();
        if ($count_in == 1) {
            foreach ($q_in->result() as $row_in) {
                $A_Id_in = $row_in->A_Id;
            }
            $update_data_in = array(
                'Login_Time' => $login_time,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('A_Id', $A_Id_in);
            $q = $this->db->update('tbl_attendance', $update_data_in);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }else{
            echo "no data";
        }
    }
    
     function monthlylogoutmovements() {
        $employee_id = $this->input->post('emp_id');
        $date = $this->input->post('date');
        $logout_time = $this->input->post('logout_time');
        $emp_id = str_pad(($employee_id), 4, '0', STR_PAD_LEFT);
        // echo $emp_id . " || " . $date . " || " . $login_time;
        $sess_data = $this->session->all_userdata();
        $modified_id = $sess_data['user_id'];

        $data_in = array(
            'Emp_Id' => $emp_id,
            'Logout_Date' => $date,
            'Status' => 1
        );
        $this->db->where($data_in);
        $q_out = $this->db->get('tbl_attendance');
        $count_out = $q_out->num_rows();
        if ($count_out == 1) {
            foreach ($q_out->result() as $row_out) {
                $A_Id_out = $row_out->A_Id;
            }
            $update_data_out = array(
                'Logout_Time' => $logout_time,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('A_Id', $A_Id_out);
            $q = $this->db->update('tbl_attendance', $update_data_out);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }else{
            echo "no data";
        }
    }

	function Exitattendance() {
        $attendance_id = $this->input->post('attendance_id');
        $user_id = $this->session->userdata('user_id');
        $update_attendance_data = array(
            'Logout_Date' => date('Y-m-d'),
            'Logout_Time' => date('H:i:s'),
            'Modified_By' => $user_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('A_Id', $attendance_id);
        $q = $this->db->update('tbl_attendance', $update_attendance_data);
        if ($q) {
            echo "success";
        }
    }
	// Employee Shift time and Late Login
	public function preview() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1 || $user_role == 7) {
            $employee_list = $this->input->post('employee_list');
            $period_from = $this->input->post('period_from');
            $period_to = $this->input->post('period_to');            
            $data = array(
                'Emp_Id' => $employee_list,
                'period_from' => $period_from,
                'period_to' => $period_to
            );
            $this->load->view('attendance/preview', $data);
        } else {
            redirect("Profile");
        }
    }
	
	
    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>