<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class User extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* User Role Details Start Here */

    public function Userrole() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'User Role',
                'main_content' => 'user/user_role'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_role() {
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $role_name = $this->input->post('role_name');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Role_Name' => $role_name,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_user_role', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function edit_role() {
        $this->form_validation->set_rules('edit_role_name', 'Role Name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $role_name = $this->input->post('edit_role_name');
            $role_id = $this->input->post('edit_role_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Role_Name' => $role_name,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Role_Id', $role_id);
            $q = $this->db->update('tbl_user_role', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function delete_role() {
        $this->form_validation->set_rules('delete_role_id', 'Role Id', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $role_id = $this->input->post('delete_role_id');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Role_Id', $role_id);
            $q = $this->db->update('tbl_user_role', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* User Role Details End Here */

    /* User Details Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'User',
                'main_content' => 'user/user'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function Edituser() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_no' => $emp_id
            );
            $this->load->view('user/edit_user', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_user() {

        $this->form_validation->set_rules('edit_branch_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_user_role', '', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $edit_branch_name = $this->input->post('edit_branch_name');
            $edit_user_role = $this->input->post('edit_user_role');
            $edit_emp_id = $this->input->post('edit_emp_id');


            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $img = $_FILES['userfile']['name'];

            if ($img != "") {
                $user_img = uniqid() . $img;
                $config = array(
                    'file_name' => $user_img,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'upload_path' => 'user_img/',
                    'max_size' => 2048,
                    'height' => 115,
                    'width' => 115
                );
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $update_data = array(
                    'User_RoleId' => $edit_user_role,
                    'User_Photo' => $user_img,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            } else {

                $update_data = array(
                    'User_RoleId' => $edit_user_role,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('Employee_Id', $edit_emp_id);
            $q = $this->db->update('tbl_user', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    public function Deleteuser() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_no' => $emp_id
            );
            $this->load->view('user/delete_user', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_user() {
        $emp_id = $this->input->post('delete_emp_id');
        $update_data = array(
            'Status' => 0
        );
        $this->db->where('Employee_Id', $emp_id);
        $this->db->update('tbl_employee', $update_data);

        $this->db->where('Employee_Id', $emp_id);
        $q = $this->db->update('tbl_user', $update_data);
        if ($q) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    /* User Details End Here */
	 /* Reset Password Start Here */

    public function ResetPwd() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Reset Password',
                'main_content' => 'user/reset_password'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function reset_pwd() {
        $this->form_validation->set_rules('employee_reset_name', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $employee_reset_id = $this->input->post('employee_reset_name');
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $string = '';
            for ($i = 0; $i < 10; $i++) {
                $string .= $characters[rand(0, strlen($characters) - 1)];
            }
            $random_password = base64_encode($string);
            $update_data = array(
                'Password' => $random_password
            );
            $this->db->where('Employee_Id', $employee_reset_id);
            $q = $this->db->update('tbl_user', $update_data);
            $new_password = base64_decode($random_password);
            if ($q) {
                echo $new_password;
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    /* Reset Password End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>