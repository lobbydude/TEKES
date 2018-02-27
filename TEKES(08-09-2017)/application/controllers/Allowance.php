<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Allowance extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Allowance Details Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Allowance',
                'main_content' => 'allowance/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Add Allowance Start Here */

    public function add_allowance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_allowance_name', '', 'trim|required');
            $this->form_validation->set_rules('add_allowance_amount', '', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $add_allowance_name = $this->input->post('add_allowance_name');
                $add_allowance_amount = $this->input->post('add_allowance_amount');
                $add_start_date1 = $this->input->post('add_start_date');                
                $add_start_date = date("Y-m-d", strtotime($add_start_date1));
                $add_end_date1 = $this->input->post('add_end_date');                
                $add_end_date = date("Y-m-d", strtotime($add_end_date1));

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Allowance_Name' => $add_allowance_name,
                    'Allowance_Amount' => $add_allowance_amount,
                    'Allowance_Startdate' => $add_start_date,
                    'Allowance_Enddate' => $add_end_date,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_allowance', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }

    /* Add Allowance End Here */

    /* Edit Allowance Start Here */

    public function Editallowance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $A_Id = $this->input->post('A_Id');
            $data = array(
                'A_Id' => $A_Id
            );
            $this->load->view('allowance/edit_allowance', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_allowance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_allowance_id', '', 'trim|required');
            $this->form_validation->set_rules('edit_allowance_name', '', 'trim|required');
            $this->form_validation->set_rules('edit_allowance_amount', '', 'trim|required');
            $this->form_validation->set_rules('edit_start_date', '', 'trim|required');
            $this->form_validation->set_rules('edit_end_date', '', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $edit_allowance_id = $this->input->post('edit_allowance_id');
                $edit_allowance_name = $this->input->post('edit_allowance_name');
                $edit_allowance_amount = $this->input->post('edit_allowance_amount');
                $edit_start_date = $this->input->post('edit_start_date');
                $edit_end_date = $this->input->post('edit_end_date');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Allowance_Name' => $edit_allowance_name,
                    'Allowance_Amount' => $edit_allowance_amount,
                    'Allowance_Startdate' => $edit_start_date,
                    'Allowance_Enddate' => $edit_end_date,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('A_Id', $edit_allowance_id);
            $q = $this->db->update('tbl_allowance', $update_data);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

    /* Edit Allowance End Here */

    /* Delete Allowance Start Here */

    public function Deleteallowance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $A_Id = $this->input->post('A_Id');
            $data = array(
                'A_Id' => $A_Id
            );
            $this->load->view('allowance/delete_allowance', $data);
        } else {
            redirect('Profile');
        }
    }

    public function delete_allowance() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_allowance_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_allowance_id = $this->input->post('delete_allowance_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Status' => 0,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('A_Id', $delete_allowance_id);
            $q = $this->db->update('tbl_allowance', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Delete Allowance End Here */

    /* Allowance End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>   