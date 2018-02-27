<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Leaves extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Leavetype Details Start Here */

    public function Type() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leavetype',
                'main_content' => 'leaves/leavetype/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Add Leave Type Start Here  */

    public function add_leavetype() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_leavetype_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('add_leavetype_leavetype', 'Leave Type', 'trim|required');
            $this->form_validation->set_rules('add_leavetype_gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('add_leavetype_leavedays', 'Leave Days', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $add_leavetype_title = $this->input->post('add_leavetype_title');
                $add_leavetype_leavetype = $this->input->post('add_leavetype_leavetype');
                $add_leavetype_gender = $this->input->post('add_leavetype_gender');
                $add_leavetype_leavedays = $this->input->post('add_leavetype_leavedays');

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Leave_Title' => $add_leavetype_title,
                    'Leave_Type' => $add_leavetype_leavetype,
                    'Leave_Gender' => $add_leavetype_gender,
                    'Leave_Days' => $add_leavetype_leavedays,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_leavetype', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }

    /* Add Leave Type End Here  */

    /* Edit Leave Type Start Here */

    public function Editleavetype() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $L_Id = $this->input->post('L_Id');
            $data = array(
                'L_Id' => $L_Id
            );
            $this->load->view('leaves/leavetype/edit_leavetype', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_leavetype() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_leavetype_id', 'ID', 'trim|required');
            $this->form_validation->set_rules('edit_leavetype_title', 'Leave Title', 'trim|required');
            $this->form_validation->set_rules('edit_leavetype_leavetype', 'Leave Type', 'trim|required');
            $this->form_validation->set_rules('edit_leavetype_gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('edit_leavetype_leavedays', 'Leave Days', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $edit_leavetype_id = $this->input->post('edit_leavetype_id');
                $edit_leavetype_title = $this->input->post('edit_leavetype_title');
                $edit_leavetype_leavetype = $this->input->post('edit_leavetype_leavetype');
                $edit_leavetype_gender = $this->input->post('edit_leavetype_gender');
                $edit_leavetype_leavedays = $this->input->post('edit_leavetype_leavedays');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                if ($edit_leavetype_title == "Maternity") {
                    $get_emp_data = array(
                        'Emp_Gender' => 'Female',
                        'Status' => 1
                    );
                    $this->db->where($get_emp_data);
                    $q_employee = $this->db->get('tbl_employee');
                    foreach ($q_employee->result() as $row_employee) {
                        $Emp_Number = $row_employee->Emp_Number;
                        $update_leavepending_data = array(
                            'Maternity' => $edit_leavetype_leavedays,
                            'Modified_By' => $modified_id,
                            'Modified_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('Emp_Id', $Emp_Number);
                        $this->db->update('tbl_leave_pending', $update_leavepending_data);
                    }
                }
                if ($edit_leavetype_title == "Paternity") {
                    $get_emp_data1 = array(
                        'Emp_Gender' => 'Male',
                        'Status' => 1
                    );
                    $this->db->where($get_emp_data1);
                    $q_employee1 = $this->db->get('tbl_employee');
                    foreach ($q_employee1->result() as $row_employee1) {
                        $Emp_Number1 = $row_employee1->Emp_Number;
                        $update_leavepending_data1 = array(
                            'Paternity' => $edit_leavetype_leavedays,
                            'Modified_By' => $modified_id,
                            'Modified_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('Emp_Id', $Emp_Number1);
                        $this->db->update('tbl_leave_pending', $update_leavepending_data1);
                    }
                }
                $update_data = array(
                    'Leave_Title' => $edit_leavetype_title,
                    'Leave_Type' => $edit_leavetype_leavetype,
                    'Leave_Gender' => $edit_leavetype_gender,
                    'Leave_Days' => $edit_leavetype_leavedays,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('L_Id', $edit_leavetype_id);
            $q = $this->db->update('tbl_leavetype', $update_data);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Edit Leave Type End Here */

    /*  Delete Leave Type Start here */

    public function Deleteleavetype() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $L_Id = $this->input->post('L_Id');
            $data = array(
                'L_Id' => $L_Id
            );
            $this->load->view('leaves/leavetype/delete_leavetype', $data);
        } else {
            redirect('Profile');
        }
    }

    public function delete_leavetype() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_leavetype_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_leavetype_id = $this->input->post('delete_leavetype_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Status' => 0
                );
            }
            $this->db->where('L_Id', $delete_leavetype_id);
            $q = $this->db->update('tbl_leavetype', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /*  Delete Leave Type End here */
    /* Leavetype Details Start Here */

    /* Leave Table Details Start Here */

    public function Index() {
        $data = array(
            'title' => 'Leave',
            'main_content' => 'leaves/index'
        );
        $this->load->view('common/content', $data);
    }

    /* Leave Table Details End Here */

    public function Mode() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leave',
                'main_content' => 'leaves/mode'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Apply Leave Start Here  */

    public function apply_leave() {
        //$this->form_validation->set_rules('add_leave_type', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_duration', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_fromdate', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_todate', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_reason', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $add_leave_reporting_to = $this->input->post('add_leave_reporting_to');
            $add_leave_type = $this->input->post('add_leave_type');
            $add_leave_duration = $this->input->post('add_leave_duration');
            $add_leave_fromdate1 = $this->input->post('add_leave_fromdate');
            $add_leave_fromdate = date("Y-m-d", strtotime($add_leave_fromdate1));
            if ($add_leave_duration == "Half Day") {
                $add_leave_todate = $add_leave_fromdate;
            } else {
                $add_leave_todate1 = $this->input->post('add_leave_todate');
                $add_leave_todate = date("Y-m-d", strtotime($add_leave_todate1));
            }
            $add_leave_reason = $this->input->post('add_leave_reason');
            $inserted_id = $this->session->userdata('user_id');
            $emp_no = $this->session->userdata('username');
            date_default_timezone_set("Asia/Kolkata");
            $Apply_Date = date("d-M-Y H:i:s");

            if ($add_leave_type == "Comp Off") {
                $end1 = date("Y-m-d", strtotime("$add_leave_todate +1 day"));
                $begin = new DateTime($add_leave_fromdate);
                $end = new DateTime($end1);
                $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                foreach ($daterange as $date) {
                    $insert_data = array(
                        'Emp_Id' => $emp_no,
                        'Date' => $date->format("Y-m-d"),
                        'Type' => $add_leave_type,
                        'Reason' => $add_leave_reason,
                        'Approval' => 'Request',
                        'Manager_Read' => 'unread',
                        'Hr_Read' => 'unread',
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_attendance_mark', $insert_data);
                }
            } else {
                $insert_data = array(
                    'Employee_Id' => $emp_no,
                    'Reporting_To' => $add_leave_reporting_to,
                    'Leave_Type' => $add_leave_type,
                    'Reason' => $add_leave_reason,
                    'Leave_Duration' => $add_leave_duration,
                    'Leave_From' => $add_leave_fromdate,
                    'Leave_To' => $add_leave_todate,
                    'Approval' => 'Request',
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1,
                    'Manager_read' => 'unread',
                    'Hr_read' => 'unread'
                );
                $q = $this->db->insert('tbl_leaves', $insert_data);
            }

            $this->db->where('Emp_Number', $emp_no);
            $q_employee = $this->db->get('tbl_employee');
            foreach ($q_employee->result() as $row_employee) {
                $emp_firstname = $row_employee->Emp_FirstName;
                $emp_lastname = " " . $row_employee->Emp_LastName;
                $emp_middlename = " " . $row_employee->Emp_MiddleName;
            }

            $this->db->where('Emp_Number', $add_leave_reporting_to);
            $q_emp_report = $this->db->get('tbl_employee');
            foreach ($q_emp_report->result() as $row_emp_report) {
                $report_firstname = $row_emp_report->Emp_FirstName;
                $report_lastname = " " . $row_emp_report->Emp_LastName;
                $report_middlename = " " . $row_emp_report->Emp_MiddleName;
                $Emp_Officialemail = $row_emp_report->Emp_Officialemail;
            }
			// Leave Count start here
            $this->db->where('Employee_Id', $emp_no);
            $q_empleave = $this->db->get('tbl_leaves');
            foreach ($q_empleave->result() as $row_empleave) {
                $Leave_Duration = $row_empleave->Leave_Duration;
                $Leave_From1 = $row_empleave->Leave_From;
                $Leave_From = date("d-m-Y", strtotime($Leave_From1));                                
                $Leave_To1 = $row_empleave->Leave_To;
                $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                $Leave_To = date("d-m-Y", strtotime($Leave_To1));                                            
            }            
            if ($Leave_Duration == "Full Day") {
                    $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                    $No_days = $interval->format("%a");
                } else {
                    $No_days = 0.5;
            }           
            // Leave Count End
            $this->load->view('phpmailer/class_phpmailer');
            $msg = "Dear Sir,<br><br>"
                    . "<p style='text-indent:65px'>I would like to apply the leave from <b>$add_leave_fromdate1</b>"
                    . " to <b>$add_leave_todate1</b>,"
                    . "Because of <b>$add_leave_reason</b>. "
                    . "Kindly I request you to approve on the same.</p>"
                    . "<b>Employee Name :</b> "
                    . "$emp_firstname $emp_lastname $emp_middlename <br><br>"
                    . "<b>Leave Apply Date :</b> "
                    . "$Apply_Date<br><br>" 
					. "<b>No of Days Leave :</b> "
                    . "$No_days days<br><br>" 
                    . "<b>Reporting Manager :</b>  "
                    . "$report_firstname $report_lastname $report_middlename<br><br><br><br>"
                    . "Thanks & Regards,<br><b>"
                    . "<font size=3 face='Monotype Corsiva'>$emp_firstname $emp_lastname $emp_middlename</b>"
                    . "</font> "
                    . "<br><font size=4 color='#0070C0' face='Monotype Corsiva'>"
                    . "<b>DRN Definite Solutions Pvt Ltd.,</b></font><br>"
                    . "<font size=2.5 color='#1F497D' face='Calibri'>"
                    . "<b>Corp: 3240 East State Street Ext Hamilton, NJ 08619</b>"
                    . "</font><br> "
                    . "<font size=2.5 color='#1F497D' face='Calibri'>"
                    . "<b>Direct: Office: 1- (443)-221-4551|Fax:(760)-280-6000</b></font><br>"
                    . "<font size=2.5 color='#1F497D' face='Calibri'><u>info@drnds.com</u> | <u>www.drnds.com</u>"
                    . "</font> ";

            $subject = "Request for Leave";
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = "smtpout.secureserver.net";
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->Username = "techteam@drnds.com";
            $mail->Password = "nop539";
            $mail->SMTPSecure = 'ssl';
            $mail->From = "techteam@drnds.com";
            $mail->FromName = $emp_firstname . " " . $emp_lastname . " " . $emp_middlename;
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<font size=2.5 face='Century Gothic'>$msg</font>";
            //$mail->addAddress("techteam@drnds.com");
            $mail->addAddress("$Emp_Officialemail");
            $mail->addCC("naveen@drnds.com");
            $mail->addBCC("devindra@drnds.com");
			if ($No_days > 2) {
                $mail->addCC("dineshkumar.b@drnds.com");               
            }
            $mail->SMTPDebug = 1;
            $mail->send();
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Apply Leave End Here  */

    public function AllEmployee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 6) {
            $data = array(
                'title' => 'Leave',
                'main_content' => 'leaves/all_employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function Employee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leave',
                'main_content' => 'leaves/employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Reply Leave Start Here  */

    public function ReplyLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $leave_id = $this->input->post('leave_id');
            $data = array(
                'leave_id' => $leave_id
            );
            $this->load->view('leaves/reply_leave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function reply_leave() {
        /* $this->form_validation->set_rules('leave_reply_pattern', '', 'trim|required');
          $this->form_validation->set_rules('leave_reply_type', '', 'trim|required'); */

        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $leave_id = $this->input->post('leave_id');
            $leave_reply_type_id = $this->input->post('leave_reply_type_id');
            $leave_reply_total_days = $this->input->post('leave_reply_total_days');
            $leave_reply_pattern = $this->input->post('leave_reply_pattern');
            $approval = $this->input->post('approval');
            $leave_reply_remarks = $this->input->post('leave_reply_remarks');
            $leave_reply_type = $this->input->post('leave_reply_type');
            $emp_no = $this->input->post('emp_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];
            $update_data1 = array(
                'Remarks' => $leave_reply_remarks,
                'Leave_Pattern' => $leave_reply_pattern,
                'Leave_Type' => $leave_reply_type,
                'Approval' => $approval,
                'Hr_read' => 'unread',
                'Emp_read' => 'unread',
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
            );

            $this->db->where('L_Id', $leave_id);
            $q = $this->db->update('tbl_leaves', $update_data1);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect('Profile');
        }
    }

    public function reply_leave_old() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $leave_id = $this->input->post('leave_id');
            $approval = $this->input->post('approval');
            $leave_reply_remarks = $this->input->post('leave_reply_remarks');
            $leave_reply_type_id = $this->input->post('leave_reply_type_id');
            $leave_reply_total_days = $this->input->post('leave_reply_total_days');
            $leave_reply_pattern = $this->input->post('leave_reply_pattern');
            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];
            if ($approval == "Yes") {
                $emp_id = $this->input->post('emp_id');
                $this->db->where('Emp_Id', $emp_id);
                $q_leave_pending = $this->db->get('tbl_leave_pending');
                foreach ($q_leave_pending->result() as $row_leave_pending) {
                    $EL = $row_leave_pending->EL;
                    $CL = $row_leave_pending->CL;
                    $total_balance = $EL + $CL;
                }
                if ($total_balance >= $leave_reply_total_days) {
                    if ($CL > $leave_reply_total_days) {
                        $cl_balance = $CL - $leave_reply_total_days;
                        $update_data2 = array(
                            'CL' => $cl_balance
                        );
                    } elseif ($EL > $leave_reply_total_days) {
                        $el_balance = $EL - $leave_reply_total_days;
                        $update_data2 = array(
                            'EL' => $el_balance
                        );
                    } else {
                        $pending_taken = $leave_reply_total_days - $CL;
                        $CL_balance_new = 0;
                        $EL_balance_new = $EL - $pending_taken;
                        $update_data2 = array(
                            'CL' => $CL_balance_new,
                            'EL' => $EL_balance_new
                        );
                    }
                    $this->db->where('Emp_Id', $emp_id);
                    $this->db->update('tbl_leave_pending', $update_data2);
                }
                if ($total_balance < $leave_reply_total_days) {
                    if ($total_balance == 0) {
                        $lop = $leave_reply_total_days - $total_balance;
                        $insert_data = array(
                            'Emp_Id' => $emp_id,
                            'Leave_Id' => $leave_id,
                            'No_of_Days' => $lop,
                            'Inserted_By' => $modified_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_lop', $insert_data);
                    } else {
                        $lop = $leave_reply_total_days - $total_balance;
                        $insert_data = array(
                            'Emp_Id' => $emp_id,
                            'Leave_Id' => $leave_id,
                            'No_of_Days' => $lop,
                            'Inserted_By' => $modified_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_lop', $insert_data);
                        $CL_balance_new = 0;
                        $EL_balance_new = 0;
                        $update_data2 = array(
                            'CL' => $CL_balance_new,
                            'EL' => $EL_balance_new
                        );
                        $this->db->where('Emp_Id', $emp_id);
                        $this->db->update('tbl_leave_pending', $update_data2);
                    }
                }
            }
            $update_data1 = array(
                'Remarks' => $leave_reply_remarks,
                'Approval' => $approval,
                'Leave_Pattern' => $leave_reply_pattern,
                'Hr_read' => 'unread',
                'Emp_read' => 'unread',
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
            );

            $this->db->where('L_Id', $leave_id);
            $q = $this->db->update('tbl_leaves', $update_data1);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect('Profile');
        }
    }

    /* Reply Leave End Here  */

    /* View Leave Start Here  */

    public function ViewLeave() {
        $leave_id = $this->input->post('leave_id');
        $data = array(
            'leave_id' => $leave_id
        );
        $this->load->view('leaves/view_leave', $data);
    }

    /* View Leave End Here  */

    /* Cancel Leave Start Here  */

    public function CancelLeave() {
        $leave_id = $this->input->post('leave_id');
        $data = array(
            'leave_id' => $leave_id
        );
        $this->load->view('leaves/cancel_leave', $data);
    }

    public function cancel_leave() {
        $cancel_leave_id = $this->input->post('cancel_leave_id');
        $username = $this->session->userdata('username');
        $update_data1 = array(
            'Approval' => 'Cancel',
            'Canceled_By' => $username
        );
        $this->db->where('L_Id', $cancel_leave_id);
        $q = $this->db->update('tbl_leaves', $update_data1);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Cancel Leave End Here  */

    /* Import Pending Leave Start Here */

    public function import_pending_leave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $filename = $_FILES["import_leave_file"]["tmp_name"];
            if ($_FILES["import_leave_file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];
                while (($leaveData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $emp_number = $leaveData[0];
                    $employee_id = str_pad(($emp_number), 4, '0', STR_PAD_LEFT);

                    $this->db->where('Emp_Id', $employee_id);
                    $q_select = $this->db->get('tbl_leave_pending');
                    $q_count = $q_select->num_rows();
                    if ($q_count == 1) {
                        $update_data = array(
                            'EL' => $leaveData[1],
                            'CL' => $leaveData[2],
                            'Added_Month' => $leaveData[3],
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->where('Emp_Id', $employee_id);
                        $this->db->update('tbl_leave_pending', $update_data);
                    } else {
                        $insert_data = array(
                            'Emp_Id' => $employee_id,
                            'EL' => $leaveData[1],
                            'CL' => $leaveData[2],
                            'Added_Month' => $leaveData[3],
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_leave_pending', $insert_data);
                    }
                }
                echo "success";
            }
        } else {
            redirect('Profile');
        }
    }

    /* Import Pending Leave End Here */

    public function Summary() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leave',
                'main_content' => 'leaves/summary/summary'
            );
            $this->load->view('operation/content', $data);
        }
    }

    public function View_ELLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/view_elleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function View_CLLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/view_clleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function View_MaternityLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/view_maternityleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function View_PaternityLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/view_paternityleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function View_LOPLeave() {
        $emp_id = $this->input->post('emp_id');
        $data = array(
            'emp_id' => $emp_id
        );
        $this->load->view('leaves/summary/view_lopleave', $data);
    }

    public function View_YetLOPLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/view_yetlopleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function View_DisLOPLeave() {
        $emp_id = $this->input->post('emp_id');
        $data = array(
            'emp_id' => $emp_id
        );
        $this->load->view('leaves/summary/view_dislopleave', $data);
    }

    public function View_CompOff() {
        $emp_id = $this->input->post('emp_id');
        $data = array(
            'emp_id' => $emp_id
        );
        $this->load->view('leaves/summary/view_compoff', $data);
    }

    public function View_CompOffLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/view_compoffleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function Add_NewLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('leaves/summary/add_new_leave', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Apply Leave Start Here  */

    public function apply_newleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('apply_leave_emp_id', '', 'trim|required');
            $this->form_validation->set_rules('apply_leave_reporting_to', '', 'trim|required');
            $this->form_validation->set_rules('apply_leave_type', '', 'trim|required');
            $this->form_validation->set_rules('apply_leave_duration', '', 'trim|required');
            $this->form_validation->set_rules('apply_leave_fromdate', '', 'trim|required');
            $this->form_validation->set_rules('apply_leave_todate', '', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $add_leave_emp_id = $this->input->post('apply_leave_emp_id');
                $add_leave_reporting_to = $this->input->post('apply_leave_reporting_to');
                $add_leave_type = $this->input->post('apply_leave_type');
                $add_leave_duration = $this->input->post('apply_leave_duration');
                $add_leave_fromdate1 = $this->input->post('apply_leave_fromdate');
                $add_leave_fromdate = date("Y-m-d", strtotime($add_leave_fromdate1));
                if ($add_leave_duration == "Half Day") {
                    $add_leave_todate = $add_leave_fromdate;
                } else {
                    $add_leave_todate1 = $this->input->post('apply_leave_todate');
                    $add_leave_todate = date("Y-m-d", strtotime($add_leave_todate1));
                }
                $add_leave_reason = $this->input->post('apply_leave_reason');
                $leave_reply_pattern = $this->input->post('leave_reply_pattern');
                $approval = $this->input->post('approval');
                $leave_reply_remarks = $this->input->post('leave_reply_remarks');
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];
                if ($add_leave_type == "LOP" || $add_leave_type == "Disciplinary LOP" || $add_leave_type == "Comp Off") {
                    $end1 = date("Y-m-d", strtotime("$add_leave_todate +1 day"));
                    $begin = new DateTime($add_leave_fromdate);
                    $end = new DateTime($end1);
                    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

                    foreach ($daterange as $date) {
                        $get_attendance_data = array(
                            'Emp_Id' => $add_leave_emp_id,
                            'Date' => $date->format("Y-m-d"),
                            'Status' => 1
                        );
                        $this->db->where($get_attendance_data);
                        $q_attendance = $this->db->get('tbl_attendance_mark');
                        $count_attendance = $q_attendance->num_rows();
                        if ($count_attendance != 1) {
                            $insert_data = array(
                                'Emp_Id' => $add_leave_emp_id,
                                'Date' => $date->format("Y-m-d"),
                                'Type' => $add_leave_type,
                                'Remarks' => $leave_reply_remarks,
                                'Approval' => 'Yes',
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
                            echo "exists";
                        }
                    }
                } else {
                    $get_leave_data = array(
                        'Employee_Id' => $add_leave_emp_id,
                        'Leave_From' => $add_leave_fromdate,
                        'Approval !=' => 'Cancel',
                        'Status' => 1
                    );
                    $this->db->where($get_leave_data);
                    $q_leaves = $this->db->get('tbl_leaves');
                    $count_leaves = $q_leaves->num_rows();
                    if ($count_leaves != 1) {
                        $insert_data = array(
                            'Employee_Id' => $add_leave_emp_id,
                            'Reporting_To' => $add_leave_reporting_to,
                            'Leave_Type' => $add_leave_type,
                            'Reason' => $add_leave_reason,
                            'Leave_Duration' => $add_leave_duration,
                            'Leave_From' => $add_leave_fromdate,
                            'Leave_To' => $add_leave_todate,
                            'Leave_Pattern' => $leave_reply_pattern,
                            'Approval' => $approval,
                            'Remarks' => $leave_reply_remarks,
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1,
                            'Manager_read' => 'unread'
                        );
                        $q = $this->db->insert('tbl_leaves', $insert_data);
                        if ($q) {
                            echo "success";
                        } else {
                            echo "fail";
                        }
                    } else {
                        echo "exists";
                    }
                }
            }
        } else {
            redirect('Profile');
        }
    }

    /* Apply Leave End Here  */

    /* Delete Leave Start Here */

    public function Deleteclleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('leave_id', 'Leave Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leave_id = $this->input->post('leave_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('L_Id', $leave_id);
                $q = $this->db->update('tbl_leaves', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletematernityleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('leave_id', 'Leave Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leave_id = $this->input->post('leave_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('L_Id', $leave_id);
                $q = $this->db->update('tbl_leaves', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletepaternityleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('leave_id', 'Leave Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leave_id = $this->input->post('leave_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('L_Id', $leave_id);
                $q = $this->db->update('tbl_leaves', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deleteelleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('leave_id', 'Leave Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leave_id = $this->input->post('leave_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('L_Id', $leave_id);
                $q = $this->db->update('tbl_leaves', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletelopleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('leave_id', 'Leave Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leave_id = $this->input->post('leave_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('A_M_Id', $leave_id);
                $q = $this->db->update('tbl_attendance_mark', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletecompoffleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('leave_id', 'Leave Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leave_id = $this->input->post('leave_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('A_M_Id', $leave_id);
                $q = $this->db->update('tbl_attendance_mark', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    /* Delete Leave End Here */

    function export_leave() {
        $contents = "Employee Id,";
        $contents .= "Employee Name,";
        $contents .= "Entitled EL,";
        $contents .= "Entitled CL,";
        $contents .= "Entitled Maternity,";
        $contents .= "Entitled Paternity,";
        $contents .= "Taken EL,";
        $contents .= "Taken CL,";
        $contents .= "Taken Maternity,";
        $contents .= "Taken Paternity,";
        $contents .= "Balance EL,";
        $contents .= "Balance CL,";
        $contents .= "Balance Maternity,";
        $contents .= "Balance Paternity,";
        $contents .= "Accumulation,";
        $contents .= "Balance Accumulation,";
        $contents .= "LOP,";
        $contents .= "Yet to Deduct LOP,";
        $contents .= "Disciplinary LOP,";
        $contents .= "Comp Off,";
        $contents .="\n";

        $this->db->where('Status', 1);
        $q_emp = $this->db->get('tbl_employee');
        $i = 1;
        foreach ($q_emp->Result() as $row) {
            $employee_id = $row->Emp_Number;
            $emp_no = str_pad(($employee_id), 4, '0', STR_PAD_LEFT);

            $this->db->where('employee_number', $emp_no);
            $q_code = $this->db->get('tbl_emp_code');
            foreach ($q_code->Result() as $row_code) {
                $emp_code = $row_code->employee_code;
            }

            $emp_firstname = $row->Emp_FirstName;
            $emp_middlename = $row->Emp_MiddleName;
            $emp_lastname = $row->Emp_LastName;
            $emp_gender = $row->Emp_Gender;

            $this->db->where('Employee_Id', $emp_no);
            $q_employee_personal = $this->db->get('tbl_employee_personal');
            foreach ($q_employee_personal->result() as $row_employee_personal) {
                $Emp_Marrial = $row_employee_personal->Emp_Marrial;
            }

            $leave_pending_data = array(
                'Emp_Id' => $emp_no,
                'Status' => 1
            );
            $this->db->where($leave_pending_data);
            $q_leave_pending = $this->db->get('tbl_leave_pending');
            foreach ($q_leave_pending->result() as $row_leave_pending) {
                $el_leave = $row_leave_pending->EL;
                $cl_leave = $row_leave_pending->CL;
                $maternity_leave = $row_leave_pending->Maternity;
                $paternity_leave = $row_leave_pending->Paternity;
                $Accumulation = $row_leave_pending->Accumulation;
                $Bal_Accumulation = $row_leave_pending->Bal_Accumulation;
                $contents.= $emp_code . $emp_no . ",";
                $contents.= $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . ",";
                $contents.= $el_leave . ",";
                $contents.= $cl_leave . ",";
                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                    $contents.= $maternity_leave . ",";
                } else {
                    $contents.= 0 . ",";
                }
                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                    $contents.= $paternity_leave . ",";
                } else {
                    $contents.= 0 . ",";
                }
                $el_taken = 0;
                $leave_taken_el = array(
                    'Employee_Id' => $emp_no,
                    'Status' => 1,
                    'Leave_Type' => 1,
                    'Approval' => 'Yes'
                );
                $this->db->where($leave_taken_el);
                $q_leave_taken_el = $this->db->get('tbl_leaves');

                foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                    $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                    $Leave_From1_el = $row_leave_taken_el->Leave_From;
                    $Leave_From_el = date("d-m-Y", strtotime($Leave_From1_el));
                    $Leave_To1_el = $row_leave_taken_el->Leave_To;
                    $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                    $Leave_To_el = date("d-m-Y", strtotime($Leave_To1_el));
                    if ($Leave_Duration_el == "Full Day") {
                        $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                        $No_days_el = $interval_el->format("%a");
                    } else {
                        $No_days_el = 0.5;
                    }
                    $el_taken = $el_taken + $No_days_el;
                }
                $el_leave_balance = $el_leave - $el_taken;

                $leave_taken_cl = array(
                    'Employee_Id' => $emp_no,
                    'Status' => 1,
                    'Leave_Type' => 2,
                    'Approval' => 'Yes'
                );
                $this->db->where($leave_taken_cl);
                $q_leave_taken_cl = $this->db->get('tbl_leaves');

                $cl_taken = 0;
                foreach ($q_leave_taken_cl->result() as $row_leave_taken_cl) {
                    $Leave_Duration = $row_leave_taken_cl->Leave_Duration;
                    $Leave_From1 = $row_leave_taken_cl->Leave_From;
                    $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                    $Leave_To1 = $row_leave_taken_cl->Leave_To;
                    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                    $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                    if ($Leave_Duration == "Full Day") {
                        $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                        $No_days = $interval->format("%a");
                    } else {
                        $No_days = 0.5;
                    }
                    $cl_taken = $cl_taken + $No_days;
                }
                $cl_leave_balance = $cl_leave - $cl_taken;
                $leave_taken_maternity = array(
                    'Employee_Id' => $emp_no,
                    'Status' => 1,
                    'Leave_Type' => 3,
                    'Approval' => 'Yes'
                );
                $this->db->where($leave_taken_maternity);
                $q_leave_taken_maternity = $this->db->get('tbl_leaves');

                $maternity_taken = 0;
                foreach ($q_leave_taken_maternity->result() as $row_leave_taken_maternity) {
                    $Leave_Duration = $row_leave_taken_maternity->Leave_Duration;
                    $Leave_From1 = $row_leave_taken_maternity->Leave_From;
                    $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                    $Leave_To1 = $row_leave_taken_cl->Leave_To;
                    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                    $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                    if ($Leave_Duration == "Full Day") {
                        $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                        $No_days = $interval->format("%a");
                    } else {
                        $No_days = 0.5;
                    }
                    $maternity_taken = $maternity_taken + $No_days;
                }
                $maternity_leave_balance = $maternity_leave - $maternity_taken;
                $leave_taken_paternity = array(
                    'Employee_Id' => $emp_no,
                    'Status' => 1,
                    'Leave_Type' => 4,
                    'Approval' => 'Yes'
                );
                $this->db->where($leave_taken_paternity);
                $q_leave_taken_paternity = $this->db->get('tbl_leaves');

                $paternity_taken = 0;
                foreach ($q_leave_taken_paternity->result() as $row_leave_taken_paternity) {
                    $Leave_Duration = $row_leave_taken_paternity->Leave_Duration;
                    $Leave_From1 = $row_leave_taken_paternity->Leave_From;
                    $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                    $Leave_To1 = $row_leave_taken_cl->Leave_To;
                    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                    $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                    if ($Leave_Duration == "Full Day") {
                        $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                        $No_days = $interval->format("%a");
                    } else {
                        $No_days = 0.5;
                    }
                    $paternity_taken = $paternity_taken + $No_days;
                }
                $paternity_leave_balance = $paternity_leave - $paternity_taken;

                $contents.= $el_taken . ",";
                $contents.= $cl_taken . ",";
                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                    $contents.= $maternity_taken . ",";
                } else {
                    $contents.= 0 . ",";
                }
                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                    $contents.= $paternity_taken . ",";
                } else {
                    $contents.= 0 . ",";
                }
                $contents.= $el_leave_balance . ",";
                $contents.= $cl_leave_balance . ",";
                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                    $contents.= $maternity_leave_balance . ",";
                } else {
                    $contents.= 0 . ",";
                }
                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                    $contents.= $paternity_leave_balance . ",";
                } else {
                    $contents.= 0 . ",";
                }
                $contents.= $Accumulation . ",";
                $contents.= $Bal_Accumulation . ",";
                $leave_lop = array(
                    'Emp_Id' => $emp_no,
                    'Status' => 1,
                    'Type' => 'LOP'
                );
                $this->db->where($leave_lop);
                $q_leave_lop = $this->db->get('tbl_attendance_mark');
                $count_lop = $q_leave_lop->num_rows();
                $contents.= $count_lop . ",";

                $yet_lop_count = 0;
                if ($count_lop > 0) {
                    $last_month_date = new DateTime(date('Y-' . (date('m') - 1) . '-20'));
                    $current_month_date = new DateTime(date('Y-m-19'));
                    foreach ($q_leave_lop->result() as $row_leave_yet_lop) {
                        $yet_lop_date = new DateTime($row_leave_yet_lop->Date);
                        if (($last_month_date <= $yet_lop_date) && ($current_month_date >= $yet_lop_date)) {
                            $yet_lop_count = 1 + $yet_lop_count;
                        }
                    }
                    $contents.= $yet_lop_count . ",";
                }

                $leave_dislop = array(
                    'Emp_Id' => $emp_no,
                    'Status' => 1,
                    'Type' => 'Disciplinary LOP'
                );
                $this->db->where($leave_dislop);
                $q_leave_dislop = $this->db->get('tbl_attendance_mark');
                $count_dislop = $q_leave_dislop->num_rows();
                $contents.= $count_dislop . ",";

                $leave_compoff = array(
                    'Emp_Id' => $emp_no,
                    'Status' => 1,
                    'Type' => 'Comp Off'
                );
                $this->db->where($leave_compoff);
                $q_leave_compoff = $this->db->get('tbl_attendance_mark');
                $count_compoff = $q_leave_compoff->num_rows();
                $contents.= $count_compoff . "\n";
                $i++;
            }
        }

        $filename = "leaves.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        print $contents;
    }

    function export_leave_manager() {
        $contents = "Employee Id,";
        $contents .= "Employee Name,";
        $contents .= "Entitled EL,";
        $contents .= "Entitled CL,";
        $contents .= "Entitled Maternity,";
        $contents .= "Entitled Paternity,";
        $contents .= "Taken EL,";
        $contents .= "Taken CL,";
        $contents .= "Taken Maternity,";
        $contents .= "Taken Paternity,";
        $contents .= "Balance EL,";
        $contents .= "Balance CL,";
        $contents .= "Balance Maternity,";
        $contents .= "Balance Paternity,";
        $contents .= "Accumulation,";
        $contents .= "Balance Accumulation,";
        $contents .= "LOP,";
        $contents .= "Yet to Deduct LOP,";
        $contents .= "Disciplinary LOP,";
        $contents .= "Comp Off,";
        $contents .="\n";

        $i = 1;
        $report_id = $this->session->userdata('username');
        $this->db->group_by('Employee_Id');
        $data_report = array(
            'Reporting_To' => $report_id,
            'Status' => 1
        );
        $this->db->where($data_report);
        $q_emp_report = $this->db->get('tbl_employee_career');
        foreach ($q_emp_report->Result() as $row_emp_report) {
            $employee_id = $row_emp_report->Employee_Id;
            $data_emp = array(
                'Emp_Number' => $employee_id,
                'Status' => 1
            );
            $this->db->where($data_emp);
            $q_emp = $this->db->get('tbl_employee');
            foreach ($q_emp->Result() as $row) {
                //$employee_id = $row->Emp_Number;
                $emp_no = str_pad(($employee_id), 4, '0', STR_PAD_LEFT);

                $this->db->where('employee_number', $emp_no);
                $q_code = $this->db->get('tbl_emp_code');
                foreach ($q_code->Result() as $row_code) {
                    $emp_code = $row_code->employee_code;
                }

                $emp_firstname = $row->Emp_FirstName;
                $emp_middlename = $row->Emp_MiddleName;
                $emp_lastname = $row->Emp_LastName;
                $emp_gender = $row->Emp_Gender;

                $this->db->where('Employee_Id', $emp_no);
                $q_employee_personal = $this->db->get('tbl_employee_personal');
                foreach ($q_employee_personal->result() as $row_employee_personal) {
                    $Emp_Marrial = $row_employee_personal->Emp_Marrial;
                }

                $leave_pending_data = array(
                    'Emp_Id' => $emp_no,
                    'Status' => 1
                );
                $this->db->where($leave_pending_data);
                $q_leave_pending = $this->db->get('tbl_leave_pending');
                foreach ($q_leave_pending->result() as $row_leave_pending) {
                    $el_leave = $row_leave_pending->EL;
                    $cl_leave = $row_leave_pending->CL;
                    $maternity_leave = $row_leave_pending->Maternity;
                    $paternity_leave = $row_leave_pending->Paternity;
                    $Accumulation = $row_leave_pending->Accumulation;
                    $Bal_Accumulation = $row_leave_pending->Bal_Accumulation;
                    $contents.= $emp_code . $emp_no . ",";
                    $contents.= $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . ",";
                    $contents.= $el_leave . ",";
                    $contents.= $cl_leave . ",";
                    if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                        $contents.= $maternity_leave . ",";
                    } else {
                        $contents.= 0 . ",";
                    }
                    if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                        $contents.= $paternity_leave . ",";
                    } else {
                        $contents.= 0 . ",";
                    }
                    $el_taken = 0;
                    $leave_taken_el = array(
                        'Employee_Id' => $emp_no,
                        'Status' => 1,
                        'Leave_Type' => 1,
                        'Approval' => 'Yes'
                    );
                    $this->db->where($leave_taken_el);
                    $q_leave_taken_el = $this->db->get('tbl_leaves');

                    foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                        $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                        $Leave_From1_el = $row_leave_taken_el->Leave_From;
                        $Leave_From_el = date("d-m-Y", strtotime($Leave_From1_el));
                        $Leave_To1_el = $row_leave_taken_el->Leave_To;
                        $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                        $Leave_To_el = date("d-m-Y", strtotime($Leave_To1_el));
                        if ($Leave_Duration_el == "Full Day") {
                            $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                            $No_days_el = $interval_el->format("%a");
                        } else {
                            $No_days_el = 0.5;
                        }
                        $el_taken = $el_taken + $No_days_el;
                    }
                    $el_leave_balance = $el_leave - $el_taken;

                    $leave_taken_cl = array(
                        'Employee_Id' => $emp_no,
                        'Status' => 1,
                        'Leave_Type' => 2,
                        'Approval' => 'Yes'
                    );
                    $this->db->where($leave_taken_cl);
                    $q_leave_taken_cl = $this->db->get('tbl_leaves');

                    $cl_taken = 0;
                    foreach ($q_leave_taken_cl->result() as $row_leave_taken_cl) {
                        $Leave_Duration = $row_leave_taken_cl->Leave_Duration;
                        $Leave_From1 = $row_leave_taken_cl->Leave_From;
                        $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                        $Leave_To1 = $row_leave_taken_cl->Leave_To;
                        $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                        $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                        if ($Leave_Duration == "Full Day") {
                            $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                            $No_days = $interval->format("%a");
                        } else {
                            $No_days = 0.5;
                        }
                        $cl_taken = $cl_taken + $No_days;
                    }
                    $cl_leave_balance = $cl_leave - $cl_taken;
                    $leave_taken_maternity = array(
                        'Employee_Id' => $emp_no,
                        'Status' => 1,
                        'Leave_Type' => 3,
                        'Approval' => 'Yes'
                    );
                    $this->db->where($leave_taken_maternity);
                    $q_leave_taken_maternity = $this->db->get('tbl_leaves');

                    $maternity_taken = 0;
                    foreach ($q_leave_taken_maternity->result() as $row_leave_taken_maternity) {
                        $Leave_Duration = $row_leave_taken_maternity->Leave_Duration;
                        $Leave_From1 = $row_leave_taken_maternity->Leave_From;
                        $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                        $Leave_To1 = $row_leave_taken_cl->Leave_To;
                        $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                        $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                        if ($Leave_Duration == "Full Day") {
                            $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                            $No_days = $interval->format("%a");
                        } else {
                            $No_days = 0.5;
                        }
                        $maternity_taken = $maternity_taken + $No_days;
                    }
                    $maternity_leave_balance = $maternity_leave - $maternity_taken;
                    $leave_taken_paternity = array(
                        'Employee_Id' => $emp_no,
                        'Status' => 1,
                        'Leave_Type' => 4,
                        'Approval' => 'Yes'
                    );
                    $this->db->where($leave_taken_paternity);
                    $q_leave_taken_paternity = $this->db->get('tbl_leaves');

                    $paternity_taken = 0;
                    foreach ($q_leave_taken_paternity->result() as $row_leave_taken_paternity) {
                        $Leave_Duration = $row_leave_taken_paternity->Leave_Duration;
                        $Leave_From1 = $row_leave_taken_paternity->Leave_From;
                        $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                        $Leave_To1 = $row_leave_taken_cl->Leave_To;
                        $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                        $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                        if ($Leave_Duration == "Full Day") {
                            $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                            $No_days = $interval->format("%a");
                        } else {
                            $No_days = 0.5;
                        }
                        $paternity_taken = $paternity_taken + $No_days;
                    }
                    $paternity_leave_balance = $paternity_leave - $paternity_taken;
                    $contents.= $el_taken . ",";
                    $contents.= $cl_taken . ",";
                    if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                        $contents.= $maternity_taken . ",";
                    } else {
                        $contents.= 0 . ",";
                    }
                    if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                        $contents.= $paternity_taken . ",";
                    } else {
                        $contents.= 0 . ",";
                    }
                    $contents.= $el_leave_balance . ",";
                    $contents.= $cl_leave_balance . ",";
                    if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                        $contents.= $maternity_leave_balance . ",";
                    } else {
                        $contents.= 0 . ",";
                    }
                    if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                        $contents.= $paternity_leave_balance . ",";
                    } else {
                        $contents.= 0 . ",";
                    }
                    $contents.= $Accumulation . ",";
                    $contents.= $Bal_Accumulation . ",";
                    $leave_lop = array(
                        'Emp_Id' => $emp_no,
                        'Status' => 1,
                        'Type' => 'LOP'
                    );
                    $this->db->where($leave_lop);
                    $q_leave_lop = $this->db->get('tbl_attendance_mark');
                    $count_lop = $q_leave_lop->num_rows();
                    $contents.= $count_lop . ",";

                    $yet_lop_count = 0;
                    if ($count_lop > 0) {
                        $last_month_date = new DateTime(date('Y-' . (date('m') - 1) . '-20'));
                        $current_month_date = new DateTime(date('Y-m-19'));
                        foreach ($q_leave_lop->result() as $row_leave_yet_lop) {
                            $yet_lop_date = new DateTime($row_leave_yet_lop->Date);
                            if (($last_month_date <= $yet_lop_date) && ($current_month_date >= $yet_lop_date)) {
                                $yet_lop_count = 1 + $yet_lop_count;
                            }
                        }
                        $contents.= $yet_lop_count . ",";
                    }

                    $leave_dislop = array(
                        'Emp_Id' => $emp_no,
                        'Status' => 1,
                        'Type' => 'Disciplinary LOP'
                    );
                    $this->db->where($leave_dislop);
                    $q_leave_dislop = $this->db->get('tbl_attendance_mark');
                    $count_dislop = $q_leave_dislop->num_rows();
                    $contents.= $count_dislop . ",";

                    $leave_compoff = array(
                        'Emp_Id' => $emp_no,
                        'Status' => 1,
                        'Type' => 'Comp Off'
                    );
                    $this->db->where($leave_compoff);
                    $q_leave_compoff = $this->db->get('tbl_attendance_mark');
                    $count_compoff = $q_leave_compoff->num_rows();
                    $contents.= $count_compoff . "\n";
                    $i++;
                }
            }
        }

        $filename = "leaves.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        print $contents;
    }

    /* Leave carry forward Details Start Here */

    public function Carryforward() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leave Carry Forward',
                'main_content' => 'leaves/carryforward/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Add Leave Carry Forward Start Here  */

    public function add_leavecarryforward() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('start_year_list', '', 'trim|required');
            $this->form_validation->set_rules('end_year_list', '', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $start_year_list1 = $this->input->post('start_year_list');
                $start_year_list = date("Y-m-d", strtotime($start_year_list1));
                $start_year = date("Y", strtotime($start_year_list));
                $end_year_list1 = $this->input->post('end_year_list');
                $end_year_list = date("Y-m-d", strtotime($end_year_list1));
                $end_month = date("m", strtotime($end_year_list));
                $end_year = date("Y", strtotime($end_year_list));
                $inserted_id = $this->session->userdata('user_id');
                $insert_carryfwd_data = array(
                    'Start_Year' => $start_year_list,
                    'End_Year' => $end_year_list,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_leave_carryforward_type', $insert_carryfwd_data);
                $carryfwd_id = $this->db->insert_id();
                $this->db->where('Status', 1);
                $q_emp = $this->db->get('tbl_employee');
                foreach ($q_emp->Result() as $row) {
                    $emp_no = $row->Emp_Number;
                    $leave_pending_data = array(
                        'Emp_Id' => $emp_no
                    );
                    $this->db->where($leave_pending_data);
                    $q_leave_pending = $this->db->get('tbl_leave_pending');
                    foreach ($q_leave_pending->result() as $row_leave_pending) {
                        $el_leave = ($row_leave_pending->EL) - 1;
                        $el_taken = 0;
                        $leave_taken_el = array(
                            'Employee_Id' => $emp_no,
                            'Status' => 1,
                            'Leave_Type' => 1,
                            'Approval' => 'Yes'
                        );
                        $this->db->where($leave_taken_el);
                        $q_leave_taken_el = $this->db->get('tbl_leaves');
                        foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                            $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                            $Leave_From1_el = $row_leave_taken_el->Leave_From;
                            $Leave_From_el = date("d-m-Y", strtotime($Leave_From1_el));
                            $Leave_To1_el = $row_leave_taken_el->Leave_To;
                            $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                            $Leave_To_el = date("d-m-Y", strtotime($Leave_To1_el));
                            if ($Leave_Duration_el == "Full Day") {
                                $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                                $No_days_el = $interval_el->format("%a");
                            } else {
                                $No_days_el = 0.5;
                            }
                            $el_taken = $el_taken + $No_days_el;
                        }
                        $el_leave_balance = $el_leave - $el_taken;
                        $leave_carryforward = array(
                            'Year' => ($start_year - 1),
                            'Status' => 1
                        );
                        $this->db->where($leave_carryforward);
                        $q_leave_carryforward = $this->db->get('tbl_leave_carryforward');
                        $count_leave_carryforward = $q_leave_carryforward->num_rows();
                        if ($count_leave_carryforward > 0) {
                            foreach ($q_leave_carryforward->result() as $row_leave_carryforward) {
                                $accumulation_last = $row_leave_carryforward->Accumulation;
                                $accumulation_bal_last = $row_leave_carryforward->Bal_Accumulation;
                            }
                        } else {
                            $accumulation_last = 0;
                            $accumulation_bal_last = 0;
                        }
                        if ($el_leave_balance >= 12) {
                            $el_leave = 12;
                            $accumulation_current = $el_leave_balance - 12;
                            $total_accumulation = $accumulation_bal_last + $accumulation_current;
                            if ($total_accumulation > 30) {
                                $bal_accumulation = $total_accumulation - 30;
                            } else {
                                $bal_accumulation = 0;
                            }
                        } else {
                            $el_leave = $el_leave_balance;
                            $accumulation_current = 0;
                            $total_accumulation = $accumulation_bal_last + $accumulation_current;
                            if ($total_accumulation > 30) {
                                $bal_accumulation = $total_accumulation - 30;
                            } else {
                                $bal_accumulation = 0;
                            }
                        }

                        $insert_data = array(
                            'Carryfwd_Id' => $carryfwd_id,
                            'Employee_Id' => $emp_no,
                            'EL' => $el_leave,
                            'Year' => $start_year,
                            'Accumulation' => $total_accumulation,
                            'Bal_Accumulation' => $bal_accumulation,
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $this->db->insert('tbl_leave_carryforward', $insert_data);
                        $update_data = array(
                            'EL' => $el_leave + 1,
                            'CL' => 1,
                            'Added_Month' => $end_month + 1,
                            'Added_Year' => $start_year,
                            'Accumulation' => $total_accumulation,
                            'Bal_Accumulation' => $bal_accumulation,
                            'Modified_By' => $inserted_id,
                            'Modified_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('Emp_Id', $emp_no);
                        $q = $this->db->update('tbl_leave_pending', $update_data);
                    }
                }
                if ($q) {
                    $leave_tablename = "tbl_leaves_$start_year";
                    $leave_mastertable = "tbl_leaves";
                    $this->db->query("CREATE TABLE $leave_tablename LIKE $leave_mastertable");
                    $leave_query = $this->db->get($leave_mastertable);
                    foreach ($leave_query->result() as $leave_row) {
                        $this->db->insert($leave_tablename, $leave_row);
                    }
                    $this->db->truncate($leave_mastertable);

                    $att_tablename = "tbl_attendance_mark_$start_year";
                    $att_mastertable = "tbl_attendance_mark";
                    $this->db->query("CREATE TABLE $att_tablename LIKE $att_mastertable");
                    $att_query = $this->db->get($att_mastertable);
                    foreach ($att_query->result() as $att_row) {
                        $this->db->insert($att_tablename, $att_row);
                    }
                    $this->db->truncate($att_mastertable);
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

    /* Add Leave Carry Forward End Here  */

    /* Edit Leave Carry Forward Start Here */

    public function Editleavecarryforward() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $L_Id = $this->input->post('L_Id');
            $data = array(
                'L_Id' => $L_Id
            );
            $this->load->view('leaves/carryforward/edit_leavecarryfwd', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_leavecarryforward() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_start_year_list', '', 'trim|required');
            $this->form_validation->set_rules('edit_end_year_list', 'Gender', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $leavecarryforward_id = $this->input->post('edit_leavecarryforward_id');
                $start_year_list1 = $this->input->post('edit_start_year_list');
                $start_year_list = date("Y-m-d", strtotime($start_year_list1));
                $end_year_list1 = $this->input->post('edit_end_year_list');
                $end_year_list = date("Y-m-d", strtotime($end_year_list1));
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Start_Year' => $start_year_list,
                    'End_Year' => $end_year_list,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('L_Id', $leavecarryforward_id);
            $q = $this->db->update('tbl_leave_carryforward_type', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Edit Leave Carry Forward End Here */

    /*  Delete Leave Carry Forward Start here */

    public function Deleteleavecarryforward() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $L_Id = $this->input->post('L_Id');
            $data = array(
                'L_Id' => $L_Id
            );
            $this->load->view('leaves/carryforward/delete_leavecarryfwd', $data);
        } else {
            redirect('Profile');
        }
    }

    public function delete_leavecarryforward() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_leavecarryfwd_id', '', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_leavecarryfwd_id = $this->input->post('delete_leavecarryfwd_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Status' => 0,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('L_Id', $delete_leavecarryfwd_id);
            $q = $this->db->update('tbl_leave_carryforward_type', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /*  Delete Leave Carry Forward End here */

    /* Leave Carry Forward Details Start Here */

    /* Comp Off Leave Start Here  */

    public function Compoff() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leave',
                'main_content' => 'leaves/compoff'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Reply Comp Off Leave Start Here  */

    public function ReplyCompOffLeave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $leave_id = $this->input->post('leave_id');
            $data = array(
                'leave_id' => $leave_id
            );
            $this->load->view('leaves/reply_compoffleave', $data);
        } else {
            redirect('Profile');
        }
    }

    public function reply_compoffleave() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $leave_id = $this->input->post('leave_id');
            $approval = $this->input->post('approval');
            $leave_reply_remarks = $this->input->post('leave_reply_remarks');
            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];
            $update_data1 = array(
                'Remarks' => $leave_reply_remarks,
                'Approval' => $approval,
                'Hr_read' => 'unread',
                'Emp_read' => 'unread',
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
            );

            $this->db->where('A_M_Id', $leave_id);
            $q = $this->db->update('tbl_attendance_mark', $update_data1);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect('Profile');
        }
    }

    /* Reply Comp Off Leave End Here  */

    /* Cancel Comp Off Leave Start Here  */

    public function CancelCompOffLeave() {
        $leave_id = $this->input->post('leave_id');
        $data = array(
            'leave_id' => $leave_id
        );
        $this->load->view('leaves/cancel_compoffleave', $data);
    }

    public function Cancel_CompOffLeave() {
        $cancel_leave_id = $this->input->post('cancel_leave_id');
        $username = $this->session->userdata('username');
        $update_data1 = array(
            'Approval' => 'Cancel',
            'Canceled_By' => $username
        );
        $this->db->where('A_M_Id', $cancel_leave_id);
        $q = $this->db->update('tbl_attendance_mark', $update_data1);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* Cancel Comp Off Leave End Here  */

    /* Comp Off Leave End Here  */

    public function View_EntitledCompOff() {
        $emp_id = $this->input->post('emp_id');
        $data = array(
            'emp_id' => $emp_id
        );
        $this->load->view('leaves/summary/view_entitledcompoff', $data);
    }

    public function Leavecompoff() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Leave Compoff',
                'main_content' => 'leaves/leavecompoff/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    // Add Leave Compoff Start here
    public function add_leavecompoff() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_leavecompoff_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('add_leavecompoff_date', 'Leave Date', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $add_leavecompoff_title = $this->input->post('add_leavecompoff_title');
                $add_leavecompoff_date1 = $this->input->post('add_leavecompoff_date');
                $add_leavecompoff_date = date("Y-m-d", strtotime($add_leavecompoff_date1));
                // Compoff year search start                
                $compoff_date = date("Y-m-d", strtotime($add_leavecompoff_date));
                $compoff_year = date('Y', strtotime($compoff_date));             
                
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Title' => $add_leavecompoff_title,
                    'Comp_Date' => $add_leavecompoff_date,
                    //'Compoff_Year' => $compoff_year,                    
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
            }
        }
    }

// Leave Compoff Edit Controller Start here
    public function Editleavecompoff() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $C_Id = $this->input->post('C_Id');
            $data = array(
                'C_Id' => $C_Id
            );
            $this->load->view('leaves/leavecompoff/edit_leavecompoff', $data);
        } else {
            redirect("Profile");
        }
    }

    // Edit Leave Compoff Start Here
    function edit_leavecompoff() {
        $this->form_validation->set_rules('edit_leavecompoff_title', '', 'trim|required');
        $this->form_validation->set_rules('edit_leavecompoff_date', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $edit_leavecompoff_id = $this->input->post('edit_leavecompoff_id');
            $edit_leavecompoff_title = $this->input->post('edit_leavecompoff_title');
            $edit_leavecompoff_date1 = $this->input->post('edit_leavecompoff_date');
            $edit_leavecompoff_date = date("Y-m-d", strtotime($edit_leavecompoff_date1));
            
            $edit_holiday_date = $this->input->post('edit_holiday_date');
            $edit_compoff_date = date("Y-m-d", strtotime($edit_leavecompoff_date));
            $edit_compoff_year = date('Y', strtotime($edit_compoff_date));
            
            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];
            $update_data = array(
                'Title' => $edit_leavecompoff_title,
                'Comp_Date' => $edit_leavecompoff_date,
                'Compoff_Year' => $edit_compoff_year,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Comp_Id', $edit_leavecompoff_id);
            $q = $this->db->update('tbl_compoff', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    // Leave Compoff Delete Controller Start here
    public function Deleteleavecompoff() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $C_Id = $this->input->post('C_Id');
            $data = array(
                'C_Id' => $C_Id
            );
            $this->load->view('leaves/leavecompoff/delete_leavecompoff', $data);
        } else {
            redirect('Profile');
        }
    }

// Delete Leave Compoff Start Here
    public function delete_leavecompoff() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_leavecompoff_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_leavecompoff_id = $this->input->post('delete_leavecompoff_id');
                $update_data = array(
                    'Status' => 0
                );
            }
            $this->db->where('Comp_Id', $delete_leavecompoff_id);
            $q = $this->db->update('tbl_compoff', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
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