<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Appraisal extends CI_Controller {

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
                'title' => 'Appraisal',
                'main_content' => 'appraisal/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    // Add(Insert)Appraisal query start here
    public function add_appraisal() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_designation', 'Designation', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $add_designation = $this->input->post('add_designation');
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];
                $appraisal_file = $_FILES['userfile']['name'];
                if ($appraisal_file != "") {
                    $appraisal_files = uniqid() . $appraisal_file;
                    $config = array(
                        'file_name' => $appraisal_files,
                        'allowed_types' => 'jpg|jpeg|png|gif|csv|xlsx|pdf|doc|docx',
                        'upload_path' => 'appraisal_file/',
                        'max_size' => 2048,
                    );
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $this->upload->do_upload('userfile');

                    $insert_data = array(
                        'Designation' => $add_designation,
                        'File' => $appraisal_files,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                } else {
                    $insert_data = array(
                        'Designation' => $add_designation,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                }
                $q = $this->db->insert('tbl_appraisalform', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }

    // Edit Controller Function    
    public function Editappraisal() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $AP_Id = $this->input->post('AP_Id');
            $data = array(
                'AP_Id' => $AP_Id
            );
            $this->load->view('appraisal/edit_appraisal', $data);
        } else {
            redirect("Profile");
        }
    }

    // Edit Query validation start here
    public function edit_appraisal() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_appraisal_id', 'ID', 'trim|required');
            $this->form_validation->set_rules('edit_designation', 'Designation', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $edit_appraisal_id = $this->input->post('edit_appraisal_id');
                $edit_designation = $this->input->post('edit_designation');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $appraisal_edit_file = $_FILES['edit_userfile']['name'];
                if ($appraisal_edit_file != "") {
                    $appraisal_edit_file1 = uniqid() . $appraisal_edit_file;
                    $config = array(
                        'file_name' => $appraisal_edit_file1,
                        'allowed_types' => 'jpg|jpeg|png|gif|csv|xlsx|pdf|doc|docx',
                        'upload_path' => 'appraisal_file/',
                        'max_size' => 2048
                    );
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $this->upload->do_upload('edit_userfile');

                    $update_data = array(
                        'Designation' => $edit_designation,
                        'File' => $appraisal_edit_file1,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                } else {
                    $update_data = array(
                        'Designation' => $edit_designation,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                }

                $this->db->where('AP_Id', $edit_appraisal_id);
                $q = $this->db->update('tbl_appraisalform', $update_data);

                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }

    public function Deleteappraisal() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $AP_Id = $this->input->post('AP_Id');
            $data = array(
                'AP_Id' => $AP_Id
            );
            $this->load->view('appraisal/delete_appraisal', $data);
        } else {
            redirect('Profile');
        }
    }

    public function delete_appraisal() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_appraisal_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_appraisal_id = $this->input->post('delete_appraisal_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Status' => 0
                );
            }
            $this->db->where('AP_Id', $delete_appraisal_id);
            $q = $this->db->update('tbl_appraisalform', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    public function April() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $current_month = date('m');
            if ($current_month == 3 || $current_month == 4 || $current_month == 5 || $current_month == 6) {
                $data = array(
                    'title' => 'Appraisal',
                    'main_content' => 'appraisal/april'
                );
                $this->load->view('operation/content', $data);
            } else {
                redirect('Operation');
            }
        } else if ($user_role == 1) {
            $current_month = date('m');
            if ($current_month == 3 || $current_month == 4 || $current_month == 5 || $current_month == 6) {
                $data = array(
                    'title' => 'Appraisal',
                    'main_content' => 'appraisal/april_manager'
                );
                $this->load->view('operation/content', $data);
            } else {
                redirect('Operation');
            }
        } else {
            redirect('Profile');
        }
    }

    public function October() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $current_month = date('m');
            if ($current_month == 9 || $current_month == 10 || $current_month == 11) {
                $data = array(
                    'title' => 'Appraisal',
                    'main_content' => 'appraisal/october'
                );
                $this->load->view('operation/content', $data);
            } else {
                redirect('Operation');
            }
        } else if ($user_role == 1) {
            $current_month = date('m');
            if ($current_month == 9 || $current_month == 10 || $current_month == 11) {
                $data = array(
                    'title' => 'Appraisal',
                    'main_content' => 'appraisal/october_manager'
                );
                $this->load->view('operation/content', $data);
            } else {
                redirect('Operation');
            }
        } else {
            redirect('Profile');
        }
    }

    public function permission() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Appraisal',
                'main_content' => 'appraisal/settings'
            );
            $this->load->view('operation/content', $data);
        } else if ($user_role == 1) {
            $data = array(
                'title' => 'Appraisal',
                'main_content' => 'appraisal/settings_manager'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function manager_appraisal_settings() {
        $this->form_validation->set_rules('appraisal_year', '', 'trim|required');
        $this->form_validation->set_rules('appraisal_month', '', 'trim|required');
        $this->form_validation->set_rules('appraisal_from', '', 'trim|required');
        $this->form_validation->set_rules('appraisal_to', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $appraisal_role = $this->input->post('appraisal_role');
            $year = $this->input->post('appraisal_year');
            $month = $this->input->post('appraisal_month');
            $from1 = $this->input->post('appraisal_from');
            $from = date("Y-m-d", strtotime($from1));
            $to1 = $this->input->post('appraisal_to');
            $to = date("Y-m-d", strtotime($to1));
            $emp_no = $this->input->post('appraisal_empno');
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            for ($i = 0; $i < sizeof($emp_no); $i++) {
                $get_data = array(
                    'Year' => $year,
                    'Month' => $month,
                    'Employee_Id' => $emp_no[$i],
                    'Status' => 1
                );
                $this->db->where($get_data);
                $q_appraisal = $this->db->get('tbl_appraisal');
                $count_appraisal = $q_appraisal->num_rows();
                if ($count_appraisal > 0) {
                    foreach ($q_appraisal->result() as $row_appraisal) {
                        $appraisal_id = $row_appraisal->A_Id;
                    }
                    if ($appraisal_role == "Manager") {
                        $update_data = array(
                            'Visible_From_Manager' => $from,
                            'Visible_To_Manager' => $to
                        );
                    }
                    if ($appraisal_role == "Employee") {
                        $update_data = array(
                            'Visible_From_Employee' => $from,
                            'Visible_To_Employee' => $to
                        );
                    }
                    $this->db->where('A_Id', $appraisal_id);
                    $q = $this->db->update('tbl_appraisal', $update_data);
                } else {
                    $insert_data = array(
                        'Year' => $year,
                        'Month' => $month,
                        'Visible_From_Manager' => $from,
                        'Visible_To_Manager' => $to,
                        'Employee_Id' => $emp_no[$i],
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_appraisal', $insert_data);
                }
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

    public function frm() {
        $data = array(
            'title' => 'Appraisal',
            'main_content' => 'appraisal/form'
        );
        $this->load->view('common/content', $data);
    }

    public function upload_emp_appraisalform() {
        $this->form_validation->set_rules('appraisal_form_id', 'ID', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $A_Id = $this->input->post('appraisal_form_id');
            $appraisal_edit_file = $_FILES['userfile']['name'];
            if ($appraisal_edit_file != "") {
                $appraisal_edit_file1 = uniqid() . $appraisal_edit_file;
                $config = array(
                    'file_name' => $appraisal_edit_file1,
                    'allowed_types' => 'jpg|jpeg|png|gif|csv|xlsx|pdf|doc|docx',
                    'upload_path' => 'appraisal_file/employee/',
                    'max_size' => 2048
                );
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $update_data = array(
                    'Employee_File' => $appraisal_edit_file1
                );
            }
            $this->db->where('A_Id', $A_Id);
            $q = $this->db->update('tbl_appraisal', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }

     public function upload_manager_appraisalform() {
        $this->form_validation->set_rules('manager_appraisal_form_id', 'ID', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $A_Id = $this->input->post('manager_appraisal_form_id');
            $appraisal_edit_file = $_FILES['userfile']['name'];
            if ($appraisal_edit_file != "") {
                $appraisal_edit_file1 = uniqid() . $appraisal_edit_file;
                $config = array(
                    'file_name' => $appraisal_edit_file1,
                    'allowed_types' => 'jpg|jpeg|png|gif|csv|xlsx|pdf|doc|docx',
                    'upload_path' => 'appraisal_file/manager/',
                    'max_size' => 2048
                );
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $update_data = array(
                    'Manager_File' => $appraisal_edit_file1
                );
            }
            $this->db->where('A_Id', $A_Id);
            $q = $this->db->update('tbl_appraisal', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        }
    }
    
    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }
}

?>