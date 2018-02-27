<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Meetings extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Meetings Details Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Meetings',
                'main_content' => 'Meetings/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Add Meetings Start Here */

    public function add_meeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_Title', 'Title', 'trim|required');
            $this->form_validation->set_rules('add_Start_Date', 'SDate', 'trim|required');
            $this->form_validation->set_rules('add_Start_Time', 'STime', 'trim|required');
            $this->form_validation->set_rules('add_End_Date', 'EDate', 'trim|required');
            $this->form_validation->set_rules('add_End_Time', 'ETime', 'trim|required');
            $this->form_validation->set_rules('add_To', 'To', 'required');
            $this->form_validation->set_rules('add_Location', 'Location', 'trim|required');
            $this->form_validation->set_rules('add_Message', 'Message', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $add_Title = $this->input->post('add_Title');
                $add_Start_Date1 = $this->input->post('add_Start_Date');
                $add_Start_Date = date("Y-m-d", strtotime($add_Start_Date1));
                $add_Start_Time = $this->input->post('add_Start_Time');
                $add_End_Date1 = $this->input->post('add_End_Date');
                $add_End_Date = date("Y-m-d", strtotime($add_End_Date1));
                $add_End_Time = $this->input->post('add_End_Time');
                $add_To = $this->input->post('add_To');
                $add_Location = $this->input->post('add_Location');
                $add_Message = $this->input->post('add_Message');
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];
                $from_emp = $this->session->userdata('username');
                $uniq_id = uniqid();
                $insert_data1 = array(
                    'M_From' => $from_emp,
                    'Title' => $add_Title,
                    'Start_Date' => $add_Start_Date,
                    'Start_Time' => $add_Start_Time,
                    'End_Date' => $add_End_Date,
                    'End_Time' => $add_End_Time,
                    'Location' => $add_Location,
                    'Message' => $add_Message,
                    'Unique' => $uniq_id,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_meetings', $insert_data1);
                $this->db->where('Unique', $uniq_id);
                $q_select = $this->db->get('tbl_meetings');
                foreach ($q_select->result() as $row_select) {
                    $meeting_id = $row_select->M_Id;
                }
                for ($i = 0; $i < sizeof($add_To); $i++) {
                    $insert_data2 = array(
                        'Emp_Id' => $add_To[$i],
                        'Meeting_Id' => $meeting_id,
                        'M_From' => $from_emp,
                        'Meeting_Status' => 'Received',
                        'Emp_Read' => 'unread',
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_meetings_to', $insert_data2);
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
    }

    /* Add Meetings End Here */

    /* Meetings Status Start Here */

    public function Viewmeeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $M_Id = $this->input->post('M_Id');
            $data = array(
                'M_Id' => $M_Id
            );
            $this->load->view('meetings/view_meeting', $data);
        } else {
            redirect("Profile");
        }
    }

    /* Meetings Status End Here */

    /* Edit Meetings Start Here */

    public function Editmeeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $M_Id = $this->input->post('M_Id');
            $data = array(
                'M_Id' => $M_Id
            );
            $this->load->view('meetings/edit_meeting', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_meeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_Title', 'Title', 'trim|required');
            $this->form_validation->set_rules('edit_Start_Date', 'SDate', 'trim|required');
            $this->form_validation->set_rules('edit_Start_Time', 'STime', 'trim|required');
            $this->form_validation->set_rules('edit_End_Date', 'EDate', 'trim|required');
            $this->form_validation->set_rules('edit_End_Time', 'ETime', 'trim|required');
            $this->form_validation->set_rules('edit_Location', 'Location', 'trim|required');
            $this->form_validation->set_rules('edit_Message', 'Message', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $edit_meeting_id = $this->input->post('edit_meeting_id');
                $edit_Title = $this->input->post('edit_Title');
                $edit_Start_Date1 = $this->input->post('edit_Start_Date');
                $edit_Start_Date = date("Y-m-d", strtotime($edit_Start_Date1));
                $edit_Start_Time = $this->input->post('edit_Start_Time');
                $edit_End_Date1 = $this->input->post('edit_End_Date');
                $edit_End_Date = date("Y-m-d", strtotime($edit_End_Date1));
                $edit_End_Time = $this->input->post('edit_End_Time');
                $edit_To = $this->input->post('edit_To');
                $edit_Location = $this->input->post('edit_Location');
                $edit_Message = $this->input->post('edit_Message');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Title' => $edit_Title,
                    'Start_Date' => $edit_Start_Date,
                    'Start_Time' => $edit_Start_Time,
                    'End_Date' => $edit_End_Date,
                    'End_Time' => $edit_End_Time,
                    'Location' => $edit_Location,
                    'Message' => $edit_Message,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('M_Id', $edit_meeting_id);
                $this->db->update('tbl_meetings', $update_data);

                $this->db->where('M_Id', $edit_meeting_id);
                $q_meet = $this->db->get('tbl_meetings');
                foreach ($q_meet->result() as $row_meet) {
                    $from_emp = $row_meet->M_From;
                }
                $this->db->where('Meeting_Id', $edit_meeting_id);
                $this->db->delete('tbl_meetings_to');

                for ($i = 0; $i < sizeof($edit_To); $i++) {
                    $insert_data = array(
                        'Emp_Id' => $edit_To[$i],
                        'Meeting_Id' => $edit_meeting_id,
                        'M_From' => $from_emp,
                        'Meeting_Status' => 'Received',
                        'Emp_Read' => 'unread',
                        'Inserted_By' => $modified_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_meetings_to', $insert_data);
                }
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }

    /* Edit Meetings Start Here */

    /* Delete Meetings Start Here */

    public function Deletemeeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $M_Id = $this->input->post('M_Id');
            $data = array(
                'M_Id' => $M_Id
            );
            $this->load->view('meetings/delete_meeting', $data);
        } else {
            redirect('Profile');
        }
    }

    public function Delete_meeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_meeting_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_meeting_id = $this->input->post('delete_meeting_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Status' => 0,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('M_Id', $delete_meeting_id);
            $q = $this->db->update('tbl_meetings', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Delete Meetings End Here */

    /* Cancel Meetings Start Here */

    public function Cancelmeeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $M_Id = $this->input->post('M_Id');
            $data = array(
                'M_Id' => $M_Id
            );
            $this->load->view('meetings/cancel_meeting', $data);
        } else {
            redirect('Profile');
        }
    }

    public function Cancel_meeting() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('cancel_meeting_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $cancel_meeting_id = $this->input->post('cancel_meeting_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data1 = array(
                    'M_Cancel' => "Cancelled",
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );

                $this->db->where('M_Id', $cancel_meeting_id);
                $q = $this->db->update('tbl_meetings', $update_data1);

                $update_data2 = array(
                    'Emp_Read' => "unread"
                );

                $this->db->where('Meeting_Id', $cancel_meeting_id);
                $this->db->update('tbl_meetings_to', $update_data2);

                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        } else {
            redirect("Profile");
        }
    }

    /* Cancel Meetings End Here */

    public function employee() {
        $data = array(
            'title' => 'Meetings',
            'main_content' => 'meetings/employee/index'
        );
        $this->load->view('common/content', $data);
    }

    public function Statusmeeting() {
        $M_Id = $this->input->post('M_Id');
        $status = $this->input->post('Status');
        $update_data = array(
            'Meeting_Status' => $status,
            'From_Read' => 'unread'
        );
        $this->db->where('M_Id', $M_Id);
        $q = $this->db->update('tbl_meetings_to', $update_data);
        if ($q) {
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