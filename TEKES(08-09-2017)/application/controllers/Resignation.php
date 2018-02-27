<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Resignation extends CI_Controller {

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
            'title' => 'Resignation',
            'main_content' => 'resignation/index'
        );
        $this->load->view('common/content', $data);
    }

    public function Mode() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Resignation',
                'main_content' => 'resignation/mode'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function add_resignation() {
        $this->form_validation->set_rules('notice_date', '', 'trim|required');
        $this->form_validation->set_rules('resignation_date', '', 'trim|required');
        $this->form_validation->set_rules('reporting_to', '', 'trim|required');
        $this->form_validation->set_rules('reason', '', 'trim|required');
        $this->form_validation->set_rules('notice_period', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $add_notice_date = $this->input->post('notice_date');
            $notice_date = date("Y-m-d", strtotime($add_notice_date));
            $add_resignation_date = $this->input->post('resignation_date');
            $resignation_date = date("Y-m-d", strtotime($add_resignation_date));
            $reporting_to = $this->input->post('reporting_to');
            $reason = $this->input->post('reason');
            $notice_period = $this->input->post('notice_period');
            $lwd = date('Y-m-d', strtotime($resignation_date . " + $notice_period days"));
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $emp_no = $this->input->post('emp_no');

            $insert_data = array(
                'Type'=>'Resignation',
                'Employee_Id' => $emp_no,
                'Notice_Date' => $notice_date,
                'Resignation_Date' => $resignation_date,
                'Reporting_To' => $reporting_to,
                'Reason' => $reason,
                'Notice_Period' => $notice_period,
                'Last_Working_Date' => $lwd,
                'HR_FinalSettlement_Date' => $lwd,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Approval' => "Request",
                'Status' => 1,
                'Manager_read' => 'unread',
                'Hr_read' => 'unread'
            );
            $q = $this->db->insert('tbl_resignation', $insert_data);
            $this->db->where('Emp_Number', $emp_no);
            $q_employee = $this->db->get('tbl_employee');
            foreach ($q_employee->result() as $row_employee) {
                $emp_firstname = $row_employee->Emp_FirstName;
                $emp_lastname = $row_employee->Emp_LastName;
                $emp_middlename = $row_employee->Emp_MiddleName;
            }
            $this->db->where('Employee_Id', $emp_no);
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
                    . "<p style='text-indent:60px'>DRNDS I am writing this letter of resignation to formally notify you of my decision to resign from the post of $designation_name with $company_name. I have taken this decision after through deliberation and assessment and I believe it is in my best interest to move on.</p>"
                    . "<b>Reporting Manager :</b>  "
                    . "$report_firstname $report_lastname $report_middlename<br><br>"
                    . "<b>Employee Name : </b>"
                    . " $emp_firstname $emp_lastname $emp_middlename <br><br>"
                    . "<b>Resignation Apply Date Time : </b>"
                    . date('d-m-Y H:i:s') . "<br><br>"
                    . "<b>Latter Date :</b> "
                    . "$add_notice_date <br><br>"
                    . "<b>Resignation Date :</b> "
                    . "$add_resignation_date <br><br><b><b>"
                    . "<b>Reason :</b> "
                    . "$reason <br><br>"
                    . "Thanks & Regards,<br><b>"
                    . "<font size=3 face='Monotype Corsiva'>$emp_firstname $emp_lastname $emp_middlename</b>"
                    . "</font> "
                    . "<br><font size=4 color='#0070C0' face='Monotype Corsiva'>"
                    . "<b>DRN Definite Solutions Pvt Ltd.,</b></font><br>"
                    . "<font size=2.5 color='#1F497D' face='Calibri'>"
                    . "<b>Off: 16, 4th Flr, Lakshya Tower, 1st Cross, Guava Garden 5th Blk, Koramangala, Bangalore, Karnataka – 560 095</b>"
                    . "</font><br> "
                    . "<font size=2.5 color='#1F497D' face='Calibri'>"
                    . "<b>Office: +91 80 6567 6115,+91 80 6569 1240|Fax: +91 80 6688 6115</b></font><br>"
                    . "<font size=2.5 color='#1F497D' face='Calibri'><u>info@drnds.com</u> | <u>www.drnds.com</u>"
                    . "</font><br/>---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- ";

            // Mail Function Start here
            $subject = "Request for Resignation";
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
            //$mail->addAddress("techteam@drnds.com");
            $mail->addAddress("$Emp_Officialemail");
            $mail->addCC("naveen@drnds.com");
            $mail->SMTPDebug = 1;
            $mail->send();
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Employee() {
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
        //$this->form_validation->set_rules('hr_remarks', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $resignation_id = $this->input->post('resignation_id');
            $employee_id = $this->input->post('employee_id');
            $hr_reason = $this->input->post('hr_reason');
            $final_settlement1 = $this->input->post('final_settlement');
            $hr_remarks = $this->input->post('hr_remarks');
            $exit_by = $this->input->post('exit_by');
            $short_notice_period = $this->input->post('short_notice_period');
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
                    'HR_Status' => 'exit'
                );
            } else {
                $update_data = array(
                    'HR_Reason' => $hr_reason,
                    'HR_FinalSettlement_Date' => $final_settlement,
                    'Short_NP' => $short_notice_period,
                    'HR_Remarks' => $hr_remarks,
                    'exit_by' => $exit_by,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'HR_Status' => 'exit'
                );
            }

            $this->db->where('R_Id', $resignation_id);
            $q = $this->db->update('tbl_resignation', $update_data);
            if ($q) {
                $update_data1 = array(
                    'Status' => 0,
                    'Emp_Resigned_Id' => $resignation_id
                );
                $this->db->where('Emp_Number', $employee_id);
                $this->db->update('tbl_employee', $update_data1);
                $update_leave_data = array(
                    'Status' => 0
                );
                $this->db->where('Emp_Id', $employee_id);
                $this->db->update('tbl_leave_pending', $update_leave_data);
                $update_user = array(
                    'Status' => 0
                );
                $this->db->where('Employee_Id', $employee_id);
                $this->db->update('tbl_user', $update_user);
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

    public function CancelResignation() {
        $resignation_id = $this->input->post('resignation_id');
        $data = array(
            'resignation_id' => $resignation_id
        );
        $this->load->view('resignation/cancel_resignation', $data);
    }

    public function cancel_resignation() {
        $resignation_id = $this->input->post('resignation_id');
        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['user_id'];
        $update_data = array(
            'Modified_By' => $inserted_id,
            'Modified_Date' => date('Y-m-d H:i:s'),
            'Approval' => "Cancel",
            'Hr_read' => 'read',
            'Emp_read' => 'unread',
            'Status' => 1
        );
        $this->db->where('R_Id', $resignation_id);
        $q = $this->db->update('tbl_resignation', $update_data);
        foreach ($q->result() as $row) {
            $employee_id = $row->Employee_Id;
        }
        if ($q) {
            $update_data1 = array(
                'Status' => 1,
                'Emp_Resigned_Status' => '',
                'Emp_Resigned_Id' => ""
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
            echo "success";
        } else {
            echo "fail";
        }
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }
}
?>