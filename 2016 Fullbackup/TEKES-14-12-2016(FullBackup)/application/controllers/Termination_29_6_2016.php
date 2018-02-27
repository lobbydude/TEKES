<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Termination extends CI_Controller {

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
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Termination',
                'main_content' => 'termination/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_termination() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role==2 || $user_role == 6) {
            $emp_no = $this->input->post('emp_id');
            $emp_id = str_pad(($emp_no), 4, '0', STR_PAD_LEFT);
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('employee/termination/index', $data);
        } else {
            redirect('Profile');
        }
    }

    public function AddTermination() {
        $this->form_validation->set_rules('add_termination_employee', '', 'trim|required');
        $this->form_validation->set_rules('add_termination_lwd', '', 'trim|required');
        $this->form_validation->set_rules('add_termination_date', '', 'trim|required');
        $this->form_validation->set_rules('add_termination_reporting_to', '', 'trim|required');
        $this->form_validation->set_rules('add_termination_reason', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $add_termination_date = $this->input->post('add_termination_date');
            $termination_date = date("Y-m-d", strtotime($add_termination_date));
            $add_termination_lwd = $this->input->post('add_termination_lwd');
            $termination_lwd = date("Y-m-d", strtotime($add_termination_lwd));
            $add_termination_employee = $this->input->post('add_termination_employee');
            $reporting_to = $this->input->post('add_termination_reporting_to');
            $reason = $this->input->post('add_termination_reason');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $terminated_by = $sess_data['username'];

            $user_role = $this->session->userdata('user_role');
            if ($user_role == 1) {
                $insert_data = array(
                    'Employee_Id' => $add_termination_employee,
                    'LWD_Date' => $termination_lwd,
                    'Terminated_Date' => $termination_date,
                    'Reporting_To' => $reporting_to,
                    'Reason' => $reason,
                    'Terminated_By' => $terminated_by,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1,
                    'HR_read' => 'unread'
                );
            }if ($user_role == 2 || $user_role == 6) {
                $insert_data = array(
                    'Employee_Id' => $add_termination_employee,
                    'LWD_Date' => $termination_lwd,
                    'Terminated_Date' => $termination_date,
                    'Reporting_To' => $reporting_to,
                    'Reason' => $reason,
                    'Terminated_By' => $terminated_by,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1,
                    'Manager_read' => 'unread'
                );
            }
            $q = $this->db->insert('tbl_termination', $insert_data);
            $update_data1 = array(
                    'Status' => 0,
					'Emp_Resigned_Status' => 'Terminated'
                );
                $this->db->where('Emp_Number', $add_termination_employee);
                $this->db->update('tbl_employee', $update_data1);
				 $update_leave_data = array(
                'Status' => 0
            );
            $this->db->where('Emp_Id', $add_termination_employee);
            $this->db->update('tbl_leave_pending', $update_leave_data);
			$this->db->where('Emp_Number', $add_termination_employee);
            $q_employee = $this->db->get('tbl_employee');
            foreach ($q_employee->result() as $row_employee) {
                $emp_firstname = $row_employee->Emp_FirstName;
                $emp_lastname = $row_employee->Emp_LastName;
                $emp_middlename = $row_employee->Emp_MiddleName;
            }
            $this->db->where('Employee_Id', $add_termination_employee);
            $q_career = $this->db->get('tbl_employee_career');
            foreach ($q_career->Result() as $row_career) {
                $designation_id = $row_career->Designation_Id;
            }
            $this->db->where('Designation_Id', $designation_id);
            $q_designation = $this->db->get('tbl_designation');
            foreach ($q_designation->Result() as $row_designation) {
                $designation_name = $row_designation->Designation_Name;
            }
            $q_company = $this->db->get('tbl_company');
            foreach ($q_company->Result() as $row_company) {
                $company_name = $row_company->Company_Name;
            }
            $this->db->where('Emp_Number', $reporting_to);
            $q_emp_report = $this->db->get('tbl_employee');
            foreach ($q_emp_report->result() as $row_emp_report) {
                $report_firstname = $row_emp_report->Emp_FirstName;
                $report_lastname = $row_emp_report->Emp_LastName;
                $report_middlename = $row_emp_report->Emp_MiddleName;
                $Emp_Officialemail = $row_emp_report->Emp_Officialemail;
            }
            $this->load->view('phpmailer/class_phpmailer');
            $msg = "Dear Sir,<br>"
                    . "<p style='text-indent:60px'>EMP Termination I am writing this letter of resignation to formally notify you of my decision to resign from the post of $designation_name with $company_name. I have taken this decision after through deliberation and assessment and I believe it is in my best interest to move on.</p>"
                    . "<b>Reporting Manager :</b>  "
                    . "$report_firstname $report_lastname $report_middlename<br><br>"
                    . "<b>Employee Name : </b>"
                    . " $emp_firstname $emp_lastname $emp_middlename <br><br>"
                    . "<b>Termination Date Time : </b>"
                    . date('d-m-Y H:i:s') . "<br><br>"
                    . "<b>Last Working Date :</b> "
                    . "$add_termination_lwd <br><br>"
                    . "<b>Termination Date :</b> "
                    . "$add_termination_date <br><br><b><b>"
                    . "<b>Reason :</b> "
                    . "$reason <br><br>"
                    . "Thanks & Regards,<br><b>"
                    . "<font size=3 face='Monotype Corsiva'>Meenakshi B</b>"
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
            $subject = "Employee Termination Mail ";
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = "smtpout.secureserver.net";
            $mail->SMTPAuth = true;
            $mail->Port = 465;
            $mail->Username = "techteam@drnds.com";
            $mail->Password = "nop539";
            $mail->SMTPSecure = 'ssl';
            $mail->From = "employees@drnds.com";
            $mail->FromName = $emp_firstname . " " . $emp_lastname . " " . $emp_middlename;
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<font size=2.5 face='Century Gothic'>$msg</font>";
           // $mail->addAddress("techteam@drnds.com");
            $mail->addAddress("$Emp_Officialemail");
            $mail->addCC("naveen@drnds.com");
			$mail->addBCC("devindra@drnds.com");
            $mail->SMTPDebug = 1;
            $mail->send();
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

	 public function edit_termination() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $termination_id = $this->input->post('termination_id');
            $data = array(
                'termination_id' => $termination_id
            );
            $this->load->view('termination/edit_termination', $data);
        } else {
            redirect('Profile');
        }
    }

    public function EditTermination() {
        $this->form_validation->set_rules('termination_lwd', '', 'trim|required');
        $this->form_validation->set_rules('termination_date', '', 'trim|required');
        $this->form_validation->set_rules('termination_reason', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $edit_termination_lwd = $this->input->post('termination_lwd');
            $termination_lwd = date("Y-m-d", strtotime($edit_termination_lwd));
            $edit_termination_date = $this->input->post('termination_date');
            $termination_date = date("Y-m-d", strtotime($edit_termination_date));
            $termination_reason = $this->input->post('termination_reason');
            $termination_id = $this->input->post('termination_id');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $update_data = array(
                'LWD_Date' => $termination_lwd,
                'Terminated_Date' => $termination_date,
                'Reason' => $termination_reason,
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 1,
                'Manager_read' => 'unread'
            );
            $this->db->where('T_Id', $termination_id);
            $q = $this->db->update('tbl_termination', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function cancel_termination() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $termination_id = $this->input->post('termination_id');
            $data = array(
                'termination_id' => $termination_id
            );
            $this->load->view('termination/cancel_termination', $data);
        } else {
            redirect('Profile');
        }
    }

    public function CancelTermination() {
        $termination_id = $this->input->post('termination_id');
        $employee_id = $this->input->post('employee_id');
        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['user_id'];

        $insert_data = array(
            'Modified_By' => $inserted_id,
            'Modified_Date' => date('Y-m-d H:i:s'),
            'Status' => 0
        );
        $this->db->where('T_Id', $termination_id);
        $q = $this->db->update('tbl_termination', $insert_data);
        $update_data1 = array(
            'Status' => 1,
            'Emp_Resigned_Status' => ''
        );
        $this->db->where('Emp_Number', $employee_id);
        $this->db->update('tbl_employee', $update_data1);
        $update_leave_data = array(
            'Status' => 1
        );
        $this->db->where('Emp_Id', $employee_id);
        $this->db->update('tbl_leave_pending', $update_leave_data);

        $update_user = array(
            'Status' => 1
        );
        $this->db->where('Employee_Id', $employee_id);
        $this->db->update('tbl_user', $update_user);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

	
    public function employee() {
        $data = array(
            'title' => 'Resignation',
            'main_content' => 'resignation/employee'
        );
        $this->load->view('operation/content', $data);
    }

    public function ReplyResignation() {
        $resignation_id = $this->input->post('resignation_id');
        $data = array(
            'resignation_id' => $resignation_id
        );
        $this->load->view('resignation/reply_resignation', $data);
    }

    public function reply_resignation() {
        $resignation_id = $this->input->post('resignation_id');
        $approval = $this->input->post('approval');
        $reply_notice_period = $this->input->post('reply_notice_period');

        $reply_last_working_date1 = $this->input->post('reply_last_working_date');
        if ($reply_last_working_date1 == "") {
            $reply_last_working_date = "";
        } else {
            $reply_last_working_date = date("Y-m-d", strtotime($reply_last_working_date1));
        }

        $reply_remarks = $this->input->post('reply_remarks');


        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['user_id'];

        if ($reply_notice_period == 0) {
            $update_data = array(
                'Extend_NP' => $reply_notice_period,
                'Extend_LWD' => $reply_last_working_date,
                'Remarks' => $reply_remarks,
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Approval' => $approval,
                'Hr_read' => 'unread',
                'Emp_read' => 'unread'
            );
        } else {
            $update_data = array(
                'Extend_NP' => $reply_notice_period,
                'Extend_LWD' => $reply_last_working_date,
                'Remarks' => $reply_remarks,
                'HR_FinalSettlement_Date' => $reply_last_working_date,
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Approval' => $approval,
                'Hr_read' => 'unread',
                'Emp_read' => 'unread'
            );
        }
        $this->db->where('R_Id', $resignation_id);
        $q = $this->db->update('tbl_resignation', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function exit_resignation() {
        $this->form_validation->set_rules('hr_reason', '', 'trim|required');
        $this->form_validation->set_rules('final_settlement', '', 'trim|required');
        $this->form_validation->set_rules('hr_remarks', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $resignation_id = $this->input->post('resignation_id');
            $employee_id = $this->input->post('employee_id');
            $hr_reason = $this->input->post('hr_reason');
            $final_settlement1 = $this->input->post('final_settlement');
            $hr_remarks = $this->input->post('hr_remarks');
            $exit_by = $this->input->post('exit_by');

            $short_notice_period = $this->input->post('short_notice_period');
            $short_notice_date1 = $this->input->post('short_notice_date');

            if ($short_notice_date1 == "") {
                $short_notice_date = "";
            } else {
                $short_notice_date = date("Y-m-d", strtotime($short_notice_date1));
            }

            if ($final_settlement1 == "") {
                $final_settlement = "";
            } else {
                $final_settlement = date("Y-m-d", strtotime($final_settlement1));
            }


            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            if ($short_notice_period == 0) {
                $update_data = array(
                    'HR_Reason' => $hr_reason,
                    'HR_FinalSettlement_Date' => $final_settlement,
                    'HR_Remarks' => $hr_remarks,
                    'exit_by' => $exit_by,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0,
                );
            } else {
                $update_data = array(
                    'HR_Reason' => $hr_reason,
                    'HR_FinalSettlement_Date' => $final_settlement,
                    'Short_NP' => $short_notice_period,
                    'Short_LWD' => $short_notice_date,
                    'HR_Remarks' => $hr_remarks,
                    'exit_by' => $exit_by,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0,
                );
            }

            $this->db->where('R_Id', $resignation_id);
            $q = $this->db->update('tbl_resignation', $update_data);
            if ($q) {
                $update_data1 = array(
                    'Status' => 0,
 'Emp_Resigned_Status' => 'Terminated'
                );
                $this->db->where('Emp_Number', $employee_id);
                $this->db->update('tbl_employee', $update_data1);
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function ViewResignation() {
        $resignation_id = $this->input->post('resignation_id');
        $data = array(
            'resignation_id' => $resignation_id
        );
        $this->load->view('resignation/view_resignation', $data);
    }

  public function ViewTermination() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('employee/termination/view_termination', $data);
        } else {
            redirect('Profile');
        }
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>