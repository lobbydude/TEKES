<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Operation extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
 $current_month = date('m');
        $q = $this->db->get('tbl_leave_pending');
        foreach ($q->result() as $row) {
            $el = $row->EL;
            $cl = $row->CL;
            $emp_id = $row->Emp_Id;
            $added_month = $row->Added_Month;
            if ($added_month != $current_month) {
                $update_data = array(
                    'EL' => $el + 1,
                    'CL' => $cl + 1,
                    'Added_Month' => $current_month
                );
                $this->db->where('Emp_Id', $emp_id);
                $this->db->update('tbl_leave_pending', $update_data);
            }
        }
    }

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role==2 || $user_role == 6 || $user_role == 4 || $user_role == 5 || $user_role == 7) {
            $data = array(
                'title' => 'Profile',
                'main_content' => 'operation/index'
            );
            $this->load->view('operation/content', $data);
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