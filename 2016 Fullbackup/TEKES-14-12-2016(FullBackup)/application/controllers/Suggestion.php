<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Suggestion extends CI_Controller {

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
            'title' => 'Suggestion',
            'main_content' => 'suggestion/index'
        );
        $this->load->view('common/content', $data);
    }

    public function Employee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Suggestion',
                'main_content' => 'suggestion/employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    /* Add Suggestion Start here */

    public function add_suggestion() {
        $this->form_validation->set_rules('add_feedback', 'Feedback', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $add_feedback = $this->input->post('add_feedback');
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $from_emp = $this->session->userdata('username');
            $current_date = date('Y-m-d');
            $insert_data = array(
                'Feedback' => $add_feedback,
                'Emp_Id' => $from_emp,
                'Date' => $current_date,
				'HR_Read'=>'unread',
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_suggestion', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Add Suggestion End here */

    /* View Suggestion Start here */

    public function Viewsuggestion() {
        $S_Id = $this->input->post('S_Id');
        $data = array(
            'S_Id' => $S_Id
        );
        $this->load->view('suggestion/view_suggestion', $data);
    }

    /* View Suggestion End here */

  public function Deletesuggestion() {
        $suggestion_id = $this->input->post('S_Id');
        $data = array(
            'suggestion_id' => $suggestion_id
        );
        $this->load->view('suggestion/delete_suggestion', $data);
    }

    function delete_suggestion() {
        $this->form_validation->set_rules('delete_suggestion_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $suggestion_id = $this->input->post('delete_suggestion_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Status' => 0,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('S_Id', $suggestion_id);
            $q = $this->db->update('tbl_suggestion', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }
    

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
