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
        if ($user_role == 2) {
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
        if ($user_role == 2) {
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
        if ($user_role == 2) {
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
        if ($user_role == 2) {
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
        if ($user_role == 2) {
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
        if ($user_role == 2) {
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

    /* Apply Leave Start Here  */

    public function apply_leave() {

        $this->form_validation->set_rules('add_leave_reporting_to', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_type', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_duration', '', 'trim|required');
        $this->form_validation->set_rules('add_leave_fromdate', '', 'trim|required');
        //  $this->form_validation->set_rules('add_leave_todate', '', 'trim|required');
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
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $emp_no = $this->session->userdata('username');
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
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Apply Leave End Here  */

    public function Employee() {
        $data = array(
            'title' => 'Leave',
            'main_content' => 'leaves/employee'
        );
        $this->load->view('operation/content', $data);
    }

    /* Reply Leave Start Here  */

    public function ReplyLeave() {
        $leave_id = $this->input->post('leave_id');
        $data = array(
            'leave_id' => $leave_id
        );
        $this->load->view('leaves/reply_leave', $data);
    }

    public function reply_leave() {
        $leave_id = $this->input->post('leave_id');
        $approval = $this->input->post('approval');
        $leave_reply_remarks = $this->input->post('leave_reply_remarks');
        $leave_reply_type_id = $this->input->post('leave_reply_type_id');
        $leave_reply_total_days = $this->input->post('leave_reply_total_days');
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
        $cancel_leave_emp_id = $this->input->post('cancel_leave_emp_id');
        $cancel_leave_type_id = $this->input->post('cancel_leave_type_id');
        $cancel_leave_total_days = $this->input->post('cancel_leave_total_days');

        $this->db->where('Emp_Id', $cancel_leave_emp_id);
        $q_leave_pending = $this->db->get('tbl_leave_pending');
        foreach ($q_leave_pending->result() as $row_leave_pending) {
            $EL = $row_leave_pending->EL;
            $CL = $row_leave_pending->CL;
        }
        if ($cancel_leave_type_id == 1) {
            $el_balance = $EL + $cancel_leave_total_days;
            $update_data2 = array(
                'EL' => $el_balance
            );
        }
        if ($cancel_leave_type_id == 2) {
            $cl_balance = $CL + $cancel_leave_total_days;
            $update_data2 = array(
                'CL' => $cl_balance
            );
        }
        $this->db->where('Emp_Id', $cancel_leave_emp_id);
        $this->db->update('tbl_leave_pending', $update_data2);

        $update_data1 = array(
            'Approval' => 'Cancel'
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
    }

    /* Import Pending Leave End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>