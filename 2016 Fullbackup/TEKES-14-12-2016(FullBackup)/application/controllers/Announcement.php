<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Announcement extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Announcement Details Start Here */

// Controller function
    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Announcement',
                'main_content' => 'Announcement/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    // Add(Insert)Announcement query start
    public function add_announcement() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_announcement_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('add_announcement_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('add_announcement_message', 'Message', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $add_announcement_title = $this->input->post('add_announcement_title');
                $add_announcement_date1 = $this->input->post('add_announcement_date');
                //Date format converted
                $add_announcement_date = date("Y-m-d", strtotime($add_announcement_date1));
                $add_announcement_message = $this->input->post('add_announcement_message');

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                // File Attachment upload insert query
                $announcement_file = $_FILES['userfile']['name'];

                if ($announcement_file != "") {
                    $announcement_files = uniqid() . $announcement_file;
                    $config = array(
                        'file_name' => $announcement_files,
                        'allowed_types' => 'jpg|jpeg|png|gif|csv|xlsx|pdf',
                        'upload_path' => 'announcement_image/',
                        'max_size' => 2048,                        
                    );
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $this->upload->do_upload('userfile');

                    $insert_data = array(
                        'Title' => $add_announcement_title,
                        'Date' => $add_announcement_date,
                        'Message' => $add_announcement_message,
                        'File' => $announcement_files,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                } else {
                    $insert_data = array(
                        'Title' => $add_announcement_title,
                        'Date' => $add_announcement_date,
                        'Message' => $add_announcement_message,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                }
                $q = $this->db->insert('tbl_announcement', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }

    // Edit Controller Function    
    public function Editannouncement() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $A_Id = $this->input->post('A_Id');
            $data = array(
                'A_Id' => $A_Id
            );
            $this->load->view('announcement/edit_announcement', $data);
        } else {
            redirect("Profile");
        }
    }

    // View Upcoming Announcement Controller Function    
    public function Viewannouncement() {
        $user_role = $this->session->userdata('user_role');
            $A_Id = $this->input->post('A_Id');
            $data = array(
                'A_Id' => $A_Id
            );
            $this->load->view('announcement/view_announcement', $data);
       
    }

    // Edit Query validation
    public function edit_announcement() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_announcement_id', 'ID', 'trim|required');
            $this->form_validation->set_rules('edit_announcement_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('edit_announcement_date', 'Date', 'trim|required');
            $this->form_validation->set_rules('edit_announcement_message', 'Message', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $edit_announcement_id = $this->input->post('edit_announcement_id');
                $edit_announcement_title = $this->input->post('edit_announcement_title');
                $edit_announcement_date1 = $this->input->post('edit_announcement_date');
                //Date format converted
                $edit_announcement_date = date("Y-m-d", strtotime($edit_announcement_date1));
                $edit_announcement_message = $this->input->post('edit_announcement_message');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                // File Attachment upload Update Edit query            
                $announcement_edit_file = $_FILES['edit_userfile']['name'];
                
                if ($announcement_edit_file != "") {
                    $announcement_edit_file1 = uniqid() . $announcement_edit_file;
                    $config = array(
                        'file_name' => $announcement_edit_file1,
                        'allowed_types' => 'jpg|jpeg|png|gif',
                        'upload_path' => 'announcement_image/',
                        'max_size' => 2048
                    );
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $this->upload->do_upload('edit_userfile');
                
                    $update_data = array(
                        'Title' => $edit_announcement_title,
                        'Date' => $edit_announcement_date,
                        'Message' => $edit_announcement_message,
                        'File' => $announcement_edit_file1,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                    
                    }else {
                        $update_data = array(
                        'Title' => $edit_announcement_title,
                        'Date' => $edit_announcement_date,
                        'Message' => $edit_announcement_message,                   
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                }              
                
            $this->db->where('A_Id', $edit_announcement_id);
            $q = $this->db->update('tbl_announcement', $update_data);

            if ($q) {
                echo "success";
            } else {
                // echo "<script>alert('Failed to update Announcement details')</script>";
                echo "fail";
            }
        }
    }
    }
    // Delete Controller start
    public function Deleteannouncement() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $A_Id = $this->input->post('A_Id');
            $data = array(
                'A_Id' => $A_Id
            );
            $this->load->view('announcement/delete_announcement', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Announcement Delete Details Start Here */

    public function delete_announcement() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_announcement_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_announcement_id = $this->input->post('delete_announcement_id');
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
//                $update_data = array(                
//                      'ID' => $delete_announcement_id,                     
//                      'Modified_By' => $modified_id,
//                      'Modified_Date' => date('Y-m-d H:i:s')
                $update_data = array(
                    'Status' => 0
                );
            }
            $this->db->where('A_Id', $delete_announcement_id);
            $q = $this->db->update('tbl_announcement', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Announcement Delete Details End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }
}
?>