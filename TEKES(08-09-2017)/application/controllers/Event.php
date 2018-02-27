<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Event extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
    }

    /* Event Details Start Here */

    public function Index() {
		
        date_default_timezone_set("Asia/Kolkata");
        $current_date = date('Y-m-d H:i:s');
        $this->load->view('phpmailer/class_phpmailer');
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
        $mail->FromName = "24 Hours Leave Report";
        $mail->isHTML(true);
        $this->db->group_by('Reporting_To');
        $q_manager = $this->db->get('tbl_employee_career');
        foreach ($q_manager->result() as $row_manager) {
            $manager_id = $row_manager->Reporting_To;
            $msg = "Dear Sir,<br>"
                    . "<p style='text-indent:60px'>These are the below employee are applied leave and applied date crossed 24 hours kindly check the TEKES software http://192.168.12.151:82/TEKES/ for more info.</p></b>"
                    . "<table border='2' cellpadding='6' style='border-collapse:collapse;font-family: Helvetica;font-size:14px'><tr>"
                    . "<th style='background-color:#3598dc;color:#fff;'>Employee Name</th>"
                    . "<th style='background-color:#3598dc;color:#fff;'>Apply Date</th>"
                    . "<th style='background-color:#3598dc;color:#fff;'>From Date</th>"
                    . "<th style='background-color:#3598dc;color:#fff;'>To Date</th>"
                    . "<th style='background-color:#3598dc;color:#fff;'>Reason</th>"
                    . "<th style='background-color:#3598dc;color:#fff;'>Reporting Manager</th>"
                    . "</tr>";
            $get_data = array(
                'Approval' => 'Request',
                'Reporting_To' => $manager_id,
                'Status' => 1
            );
            $this->db->where($get_data);
            $q_leave = $this->db->get('tbl_leaves');
            $count = $q_leave->num_rows();
            if ($count > 0) {
                foreach ($q_leave->result() as $row_leave) {
                    $applied_date = $row_leave->Inserted_Date;
                    $diff = strtotime($current_date) - strtotime($applied_date);
                    $diff_in_hrs = round($diff / 3600);
                    if (24 <= $diff_in_hrs && $diff_in_hrs <= 25) {
                        $Employee_Id = $row_leave->Employee_Id;
                        $Reason = $row_leave->Reason;
                        $Leave_Duration = $row_leave->Leave_Duration;
                        $Leave_From = $row_leave->Leave_From;
                        $Leave_To = $row_leave->Leave_To;

                        $this->db->where('Emp_Number', $Employee_Id);
                        $q_employee = $this->db->get('tbl_employee');
                        foreach ($q_employee->result() as $row_employee) {
                            $employee_name = $row_employee->Emp_FirstName;
                            $employee_name .= " " . $row_employee->Emp_LastName;
                            $employee_name .= " " . $row_employee->Emp_MiddleName;
                        }

                        $this->db->where('Emp_Number', $manager_id);
                        $q_emp = $this->db->get('tbl_employee');
                        foreach ($q_emp->result() as $row_emp) {
                            $emp_reporting_name = $row_emp->Emp_FirstName;
                            $emp_reporting_name .= " " . $row_emp->Emp_LastName;
                            $emp_reporting_name .= " " . $row_emp->Emp_MiddleName;
                            $Emp_Officialemail = $row_emp->Emp_Officialemail;
                        }
                        $apply_date = date("d-m-Y H:i:s", strtotime($applied_date));
                        $from_Date = date("d-m-Y", strtotime($Leave_From));
                        $to_Date = date("d-m-Y", strtotime($Leave_To));
                        $msg .= "<tr>"
                                . "<td>$employee_name</td>  "
                                . "<td>$apply_date</td> "
                                . "<td>$from_Date</td>  "
                                . "<td>$to_Date</td> "
                                . "<td>$Reason</td>"
                                . "<td>$emp_reporting_name</td>"
                                . "</tr>";
                    }
                }				
                $msg .= "</table> <br><br>"
                        . "Thanks & Regards,<br><b>"
                        . "<font size=3 color='#1f497d' face='Monotype Corsiva'>TEKES My Info</b>"
                        . "</font> "
                        . "<br><font size=5 color='#1f497d' face='Monotype Corsiva'>"
                        . "<b>DRN Definite Solutions Pvt Ltd.,</b></font><br>"
                        . "<font size=2.5 color='#1F497D' face='Calibri'>"
                        . "<b>Off: 16, 4th Flr, Lakshya Tower, 1st Cross, Guava Garden 5th Blk, Koramangala, Bangalore, Karnataka – 560 095</b>"
                        . "</font><br> "
                        . "<font size=2.5 color='#1F497D' face='Calibri'>"
                        . "<b>Office: +91 80 6567 6115,+91 80 6569 1240|Fax: +91 80 6688 6115</b></font><br>"
                        . "<font size=2.5 color='#1F497D' face='Calibri'><u>info@drnds.com</u> | <u>www.drnds.com</u>"
                        . "</font><br/>---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
This e-mail and any files transmitted with it are for the sole use of the intended recipient(s) and may contain confidential and privileged information. If you are not the intended recipient, please contact the sender by reply e-mail and destroy all copies of the original message.  Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful.
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
";
                $subject = "Request for Leave Approval";
                $mail->Subject = $subject;
                $mail->Body = "<font size=2.5 face='Century Gothic'>$msg</font>";
				//$mail->addAddress("techteam@drnds.com");
				if (24 <= $diff_in_hrs && $diff_in_hrs <= 25) {
				$mail->addAddress("$Emp_Officialemail");
				$mail->addCC("naveen@drnds.com");
				$mail->addBCC("techteam@drnds.com");
                $mail->SMTPDebug = 1;   
                    $mail->send();
                }
            }
        }
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   