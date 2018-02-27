<?php
if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Holidays extends CI_Controller {

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
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Holiday',
                'main_content' => 'holidays/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_holiday() {

        $this->form_validation->set_rules('add_holiday_name', '', 'trim|required');
        $this->form_validation->set_rules('add_holiday_date', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $add_holiday_name = $this->input->post('add_holiday_name');
            $add_holiday_date = $this->input->post('add_holiday_date');
            $holiday_date = date("Y-m-d", strtotime($add_holiday_date));
            $holiday_year = date('Y', strtotime($holiday_date));

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Holiday_Name' => $add_holiday_name,
                'Holiday_Date' => $holiday_date,
		'Holiday_Year' => $holiday_year,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_holiday', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
           // $this->load->view('error');
        }
    }

    public function Editholiday() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $holiday_id = $this->input->post('holiday_id');
            $data = array(
                'holiday_id' => $holiday_id
            );
            $this->load->view('holidays/edit_holiday', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_holiday() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_holiday_name', '', 'trim|required');
              $this->form_validation->set_rules('edit_holiday_date', '', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $holiday_id = $this->input->post('edit_holiday_id');
                $holiday_name = $this->input->post('edit_holiday_name');
                $edit_holiday_date = $this->input->post('edit_holiday_date');
                $holiday_date = date("Y-m-d", strtotime($edit_holiday_date));
		$holiday_year = date('Y', strtotime($holiday_date));
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Holiday_Name' => $holiday_name,
                    'Holiday_Date' => $holiday_date,
                    'Holiday_Year' => $holiday_year,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Holiday_Id', $holiday_id);
                $q = $this->db->update('tbl_holiday', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deleteholiday() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $holiday_id = $this->input->post('holiday_id');
            $data = array(
                'holiday_id' => $holiday_id
            );
            $this->load->view('holidays/delete_holiday', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_holiday() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_holiday_id', '', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $holiday_id = $this->input->post('delete_holiday_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('Holiday_Id', $holiday_id);
                $q = $this->db->update('tbl_holiday', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //  $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>