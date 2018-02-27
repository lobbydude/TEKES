<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        self::$db = & get_instance()->db;
    }

public function Index() {
        $logged_user = get_current_user();
        $data = array(
            'Username' => $logged_user,
        );
        $this->db->where($data);
        $q = $this->db->get('tbl_user');
        $count = $q->num_rows();
        if ($count == 1) {
            $row = $q->row_array();
            $sess_data = array(
                'user_id' => $row['User_id'],
                'emp_username' => $row['Username'],
                'username' => $row['Employee_Id'],
                'user_role' => $row['User_RoleId'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($sess_data);
            redirect('Profile');
        } else {
            echo "invalid";
        }
        //$this->load->view('Login/Index');
    }

    public function Index_old() {
        $this->load->view('Login/Index');
    }

    public function validate() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE) {
            

 $username = $this->input->post('username');
            $password = base64_encode($this->input->post('password'));

            $data = array(
                'Username' => $username,
                'Password' => $password
            );
            $this->db->where($data);
            $q = $this->db->get('tbl_user');
            $count = $q->num_rows();
            if ($count == 1) {
                $row = $q->row_array();
                $sess_data = array(
                    'user_id' => $row['User_id'],
                    'emp_username' => $row['Username'],
                    'username' => $row['Employee_Id'],
                    'password' => $row['Password'],
                    'user_role' => $row['User_RoleId'],
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($sess_data);
                echo $row['User_RoleId'];
            } else {
                echo "invalid";
            }
        } else {
            $this->load->view('error');
        }
    }

}

?>
