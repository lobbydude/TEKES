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
        $data = array(
            'title' => 'Attendance',
            'main_content' => 'attendance/index'
        );
        $this->load->view('common/content', $data);
    }

    public function MarkAttendance() {

        $this->form_validation->set_rules('emp_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            date_default_timezone_set("Asia/Kolkata");
            $timezone = new DateTimeZone("Asia/Kolkata");
            $date = new DateTime();
            $date->setTimezone($timezone);
            $login_time = $date->format('H:i:s');
            $time_format = $date->format('A');
            $login_date = $date->format('Y-m-d');
            $emp_id = $this->input->post('emp_id');
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $data = array(
                'Employee_Id' => $emp_id,
                'Login_Date' => $login_date
            );
            $this->db->where($data);
            $select = $this->db->get('tbl_attendance');
            $count = $select->num_rows();
            if ($count == 0) {
                $insert_data = array(
                    'Employee_Id' => $emp_id,
                    'Login_Date' => $login_date,
                    'Login_Time' => $login_time,
                    'Login_TimeFormat' => $time_format,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Action' => 'Login',
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_attendance', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        } else {
            $this->load->view('error');
        }
    }

    public function LogoutAttendance() {
        $attendance_id = $this->input->post('attendance_id');

        date_default_timezone_set("Asia/Kolkata");
        $timezone = new DateTimeZone("Asia/Kolkata");
        $date = new DateTime();
        $date->setTimezone($timezone);
        $logout_time = $date->format('H:i:s');
        $time_format = $date->format('A');
        $logout_date = $date->format('Y-m-d');

        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['user_id'];

        $data_select = array(
            'A_Id' => $attendance_id,
            'Action' => 'Login'
        );
        $this->db->where($data_select);
        $query = $this->db->get('tbl_attendance');
        $count = $query->num_rows();
        if ($count == 1) {
            $update_data = array(
                'Logout_Date' => $logout_date,
                'Logout_Time' => $logout_time,
                'Logout_TimeFormat' => $time_format,
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Action' => 'Logout'
            );

            $this->db->where('A_Id', $attendance_id);
            $q = $this->db->update('tbl_attendance', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    public function employee() {
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

    public function import_attendance_old() {
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

//                $shift_name = $empData[4];
//                $this->db->where('Shift_Name', $shift_name);
//                $q_shift = $this->db->get('tbl_shift_details');
//                foreach ($q_shift->result() as $row_shift) {
//                    $shift_id = $row_shift->Shift_Id;
//                }

                $get_data = array(
                    'Emp_Id' => $employee_id,
                    'Log_Date' => $login_date,
                    'Type' => $empData[3]
                );
                $this->db->where($get_data);
                $q = $this->db->get('tbl_attendance');
                $count = $q->num_rows();
                if ($count == 1) {
                    $data = $q->result_array();
                    $a_id = $data[0]['A_Id'];
                    $update_data1 = array(
                        'Emp_Id' => $employee_id,
                        'Log_Date' => $login_date,
                        'Log_Time' => $empData[2],
                        'Type' => $empData[3],
                        'Shift_Name' => $empData[4],
                        'Modified_By' => $inserted_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('A_Id', $a_id);
                    $this->db->update('tbl_attendance', $update_data1);
                } else {
                    $insert_data1 = array(
                        'Emp_Id' => $employee_id,
                        'Log_Date' => $login_date,
                        'Log_Time' => $empData[2],
                        'Type' => $empData[3],
                        'Shift_Name' => $empData[4],
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $this->db->insert('tbl_attendance', $insert_data1);
                }
            }
            echo "success";
            // fclose($file);
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

    public function Timesheet() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2) {
            $data = array(
                'title' => 'Attendance',
                'main_content' => 'attendance/timesheet'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function get_days() {
        $month = $this->input->post('month');
        $monthName = date('F', mktime(0, 0, 0, $month, 10));
        $year = $this->input->post('year');
        $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dates_month = array();

        $q_data = array(
            'Status' => 1
        );
        $this->db->where($q_data);
        $q = $this->db->get('tbl_employee');

        $data = "<table class='table table-bordered datatable' id='timesheet_table' class='timesheet_table'>";
        $data .= "<h3 class='col-sm-8'>Daily Attendance for the Month of " . $monthName . " " . $year . "</h3>";
        $data .= "<thead><tr><th>Employee Code</th><th>Employees</th>";
        for ($i = 1; $i <= $num; $i++) {
            $mktime = mktime(0, 0, 0, $month, $i, $year);
            $date = date("d", $mktime);
            $dates_month[$i] = $date;

            $date_n = date("Y-m-d", $mktime);
            $dat_no = date('N', strtotime($date_n));
            $data .="<th>";
            if ($dat_no == 1) {
                $data .="Mon";
            }
            if ($dat_no == 2) {
                $data .="Tue";
            }
            if ($dat_no == 3) {
                $data .="Wed";
            }
            if ($dat_no == 4) {
                $data .="Thu";
            }
            if ($dat_no == 5) {
                $data .="Fri";
            }
            if ($dat_no == 6) {
                $data .="Sat";
            }
            if ($dat_no == 7) {
                $data .= "Sun";
            }
            $data .="<br />$dates_month[$i]</th>";
        }
        $data .="<th>No. Days Present (P)</th>";
        $data .="<th>No. of Day Leave (L)</th>";
        $data .="<th>No. of Days Half day Present (HP)</th>";
        $data .="<th>Total Week Off ( Sat/ Sun) (WO)</th>";
        $data .="<th>Total Week off worked  (WP)</th>";
        $data .="<th>Total Holidays (H)</th>";
        $data .="</tr></thead>";
        $data .="<tbody>";
        foreach ($q->result() as $row) {
            $emp_firstname = $row->Emp_FirstName;
            $emp_middlename = $row->Emp_MiddleName;
            $emp_lastname = $row->Emp_LastName;
            $emp_no = $row->Emp_Number;
            $this->db->where('employee_number', $emp_no);
            $q_code = $this->db->get('tbl_emp_code');
            foreach ($q_code->Result() as $row_code) {
                $emp_code = $row_code->employee_code;
            }
            $data .="<tr>";
            $data .="<td>" . $emp_code . $emp_no . "</td>";
            $data .="<td>" . $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . "</td>";

            $p = 0;
            $a = 0;
            $wp = 0;
            $wo = 0;
            $h = 0;
            $hp = 0;

            $num_1 = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $dates_month_1 = array();
            for ($i_1 = 1; $i_1 <= $num_1; $i_1++) {
                $mktime_1 = mktime(0, 0, 0, $month, $i_1, $year);
                $date_1 = date("Y-m-d", $mktime_1);
                $dates_month_1[$i_1] = $date_1;

                // $data .="<td>$dates_month[$i]</td>";
                $dat_no1 = date('N', strtotime($date_1));
                if ($dat_no1 == 6 || $dat_no1 == 7) {

                    $data_in = array(
                        'Type' => "IN",
                        'Emp_Id' => $emp_no,
                        'Log_Date' => $dates_month_1[$i_1],
                        'Status' => 1
                    );
                    $this->db->where($data_in);
                    $this->db->group_by(array("Log_Date", "Emp_Id"));
                    $q_in = $this->db->get('tbl_attendance_temporary');
                    $count_in = $q_in->num_rows();
                    if ($count_in == 1) {
                        $data .="<td style = 'background-color:#00c600'>P</td>";
                        $wp = $wp + 1;
                    } else {
                        $data .="<td style = 'background-color:#FFFF00'>WO</td>";
                        $wo = $wo + 1;
                    }

                    //   $data .="<td style='background-color:#FFFF00'>WO</td>";
                } else {
                    $holiday_data = array(
                        'Holiday_Date' => $dates_month_1[$i_1],
                        'Status' => 1
                    );
                    $this->db->where($holiday_data);
                    $q_hol = $this->db->get('tbl_holiday');
                    $count_hol = $q_hol->num_rows();
                    if ($count_hol == 1) {
                        $data .="<td style = 'background-color:#0000c6;color:#fff'>H</td>";
                        $h = $h + 1;
                    } else {
                        $data_in1 = array(
                            'Type' => "IN",
                            'Emp_Id' => $emp_no,
                            'Log_Date' => $dates_month_1[$i_1],
                            'Status' => 1
                        );
                        $this->db->where($data_in1);
                        $this->db->group_by(array("Log_Date", "Emp_Id"));
                        $q_in1 = $this->db->get('tbl_attendance_temporary');
                        $count_in1 = $q_in1->num_rows();
                        if ($count_in1 == 1) {

                            foreach ($q_in1->result() as $row_in1) {
                                $A_Id_in = $row_in1->A_Id;
                                $Login_Date1 = $row_in1->Log_Date;
                                $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                $Login_Time = $row_in1->Log_Time;
                                $shift_name = $row_in1->Shift_Name;
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
                                        $data .="<td style = 'background-color:#00c600'>P</td>";
                                        $p = $p + 1;
                                    } else {
                                        $data .="<td style = 'background-color:#00c600'>HP</td>";
                                        $hp = $hp + 1;
                                    }
                                }
                            }

                            //       $data .="<td style='background-color:#00c600'>P</td>";
                        } else {
                            $data .="<td style='background-color:#c60000;color:#fff'>A</td>";
                            $a = $a + 1;
                        }
                    }
                }
            }

            $data .="<td>$p</td>";
            $data .="<td>$a</td>";
            $data .="<td>$hp</td>  ";
            $data .="<td>$wo</td>";
            $data .="<td>$wp</td>";
            $data .="<td>$h</td>";
            $data .="</tr>";
        }
        $data .="</tbody></table>";
        echo $data;
    }

    public function MonthTimesheet() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2) {
            // $from_date = $this->input->post('export_attendance_from');
            //  $to_date = $this->input->post('export_attendance_to');
            $data = array(
                //  'from_date' => $from_date,
                //   'to_date' => $to_date,
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

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Emp_Id' => $emp_id,
                'Comp_Date' => $attendance_date,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_compoff', $insert_data);
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