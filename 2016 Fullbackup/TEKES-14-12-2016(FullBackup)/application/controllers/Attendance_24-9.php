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
        if ($user_role == 1 || $user_role == 2) {
            $data = array(
                'title' => 'Attendance',
                'main_content' => 'attendance/employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function import_attendance() {
        $filename = $_FILES["import_file"]["tmp_name"];
        if ($_FILES["import_file"]["size"] > 0) {
            $file = fopen($filename, "r");

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

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
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_attendance_temporary', $insert_data);
            }

            /* Inserting to main table */

            $this->db->order_by('Log_Date', 'desc');
            $data_in = array(
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
                            'Type' => "OUT",
                            'Log_Date' => date("Y-m-d", strtotime("$Login_Date +1 day")),
                            'Emp_Id' => $employee_id,
                            'Status' => 1
                        );
                    } else {
                        $data_out = array(
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

        if ($this->form_validation->run() == TRUE) {
            $att_id_in = $this->input->post('edit_att_id_in');
            $login_date1 = $this->input->post('edit_att_login_date');
            $login_date = date("Y-m-d", strtotime($login_date1));
            $login_time = $this->input->post('edit_att_login_time');

            $logout_date1 = $this->input->post('edit_att_logout_date');
            $logout_date = date("Y-m-d", strtotime($logout_date1));
            $logout_time = $this->input->post('edit_att_logout_time');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data1 = array(
                'Login_Date' => $login_date,
                'Login_Time' => $login_time,
                'Logout_Date' => $logout_date,
                'Logout_Time' => $logout_time,
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
            $q = $this->db->update('tbl_attendance_temporary', $update_data1);

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
        if ($user_role == 1 || $user_role == 2) {
            $data = array(
                'title' => 'Attendance',
                'main_content' => 'attendance/month_timesheet'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function Editmonthtimesheet() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2) {
            $emp_no = $this->input->post('emp_id');
            $data = array(
                'emp_no' => $emp_no
            );
            $this->load->view('attendance/edit_monthtimesheet', $data);
        } else {
            redirect("Profile");
        }
    }

    public function Edit_Monthtimesheet() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2) {
            $emp_id = $this->input->post('emp_id');
            $attendance_date1 = $this->input->post('attendance_date');
            $attendance_date = date("Y-m-d", strtotime($attendance_date1));
            $editmonthtimesheet_type = $this->input->post('editmonthtimesheet_type');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Emp_Id' => $emp_id,
                'Date' => $attendance_date,
                'Type'=>$editmonthtimesheet_type,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_attendance_mark', $insert_data);
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
        if ($user_role == 2) {

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

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>