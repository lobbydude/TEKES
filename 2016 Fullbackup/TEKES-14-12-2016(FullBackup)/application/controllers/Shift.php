<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Shift extends CI_Controller {

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
            'title' => 'Shift',
            'main_content' => 'shift/index'
        );
        $this->load->view('operation/content', $data);
    }

    public function Add_shift() {

        $this->form_validation->set_rules('shift_name', '', 'trim|required');
        $this->form_validation->set_rules('shift_from', '', 'trim|required');
        $this->form_validation->set_rules('shift_to', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $shift_name = $this->input->post('shift_name');
            $shift_from = $this->input->post('shift_from');
            $shift_to = $this->input->post('shift_to');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Shift_Name' => $shift_name,
                'Shift_From' => $shift_from,
                'Shift_To' => $shift_to,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_shift_details', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Editshift() {
        $shift_id = $this->input->post('shift_id');
        $data = array(
            'shift_id' => $shift_id
        );
        $this->load->view('shift/edit_shift', $data);
    }

    function edit_shift() {
        $this->form_validation->set_rules('edit_shift_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_shift_from', '', 'trim|required');
        $this->form_validation->set_rules('edit_shift_to', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $shift_id = $this->input->post('edit_shift_id');
            $shift_name = $this->input->post('edit_shift_name');
            $shift_from = $this->input->post('edit_shift_from');
            $shift_to = $this->input->post('edit_shift_to');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Shift_Name' => $shift_name,
                'Shift_From' => $shift_from,
                'Shift_To' => $shift_to,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Shift_Id', $shift_id);
            $q = $this->db->update('tbl_shift_details', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deleteshift() {
        $shift_id = $this->input->post('shift_id');
        $data = array(
            'shift_id' => $shift_id
        );
        $this->load->view('shift/delete_shift', $data);
    }

    function delete_shift() {
        $this->form_validation->set_rules('delete_shift_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $shift_id = $this->input->post('delete_shift_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Status' => 0,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('shift_id', $shift_id);
            $q = $this->db->update('tbl_shift_details', $update_data);
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

?>