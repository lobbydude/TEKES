<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Ipr extends CI_Controller {

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
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $data = array(
                'title' => 'KP Master',
                'main_content' => 'ipr/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }
	
	// IPR Design Report I Start here
    public function Employee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $data = array(
                'title' => 'IPR Report',
                'main_content' => 'ipr/employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }  
	// IPR Design Report I End here

    // Add(Insert)IPR Master query start
    public function add_kpmaster() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $this->form_validation->set_rules('add_kpmaster_department', 'Department Name', 'trim|required');
            $this->form_validation->set_rules('add_kpmaster_testname', 'Test Name', 'trim|required');
            $this->form_validation->set_rules('add_kpmaster_enable_date', 'Enable Date', 'trim|required');
            $this->form_validation->set_rules('add_kpmaster_duration_time', 'Time', 'trim|required');
            $filename = $_FILES["iprquestionfile"]["tmp_name"];
            if ($_FILES["iprquestionfile"]["size"] > 0) {
                if ($this->form_validation->run() == TRUE) {
                    $add_kpmaster_department = $this->input->post('add_kpmaster_department');
                    $add_kpmaster_testname = $this->input->post('add_kpmaster_testname');
                    $add_kpmaster_enable_date1 = $this->input->post('add_kpmaster_enable_date');
                    $add_kpmaster_enable_date = date("Y-m-d", strtotime($add_kpmaster_enable_date1));
                    $add_kpmaster_duration_time = $this->input->post('add_kpmaster_duration_time');

                    $sess_data = $this->session->all_userdata();
                    $inserted_id = $sess_data['user_id'];
                    $insert_data = array(
                        'Department_Id' => $add_kpmaster_department,
                        'Test_Name' => $add_kpmaster_testname,
                        'Enable_Date' => $add_kpmaster_enable_date,
                        'Duration_Time' => $add_kpmaster_duration_time,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_kpmaster', $insert_data);
                    $kp_id = $this->db->insert_id();

                    $file = fopen($filename, "r");
                    while (($iprData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $insert_data2 = array(
                            'Kp_Id' => $kp_id,
                            'Question' => $iprData[0],
                            'Option1' => $iprData[1],
                            'Option2' => $iprData[2],
                            'Option3' => $iprData[3],
                            'Option4' => $iprData[4],
                            'Answer' => $iprData[5],
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $q1 = $this->db->insert('tbl_kpquestions', $insert_data2);
                    }
                    if ($q1) {
                        echo "success";
                    } else {
                        echo "fail";
                    }
                }
            }
        }
    }

    // Edit Controller Function    
    public function Editkpmaster() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $Kp_Id = $this->input->post('Kp_Id');
            $data = array(
                'Kp_Id' => $Kp_Id
            );

            $this->load->view('ipr/edit_kpmaster', $data);
        } else {
            redirect("Profile");
        }
    }

    // Edit Query validation
    public function edit_kpmaster() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $this->form_validation->set_rules('edit_kpmaster_id', 'ID', 'trim|required');
            $this->form_validation->set_rules('edit_kpmaster_department', 'Depart Name', 'trim|required');
            $this->form_validation->set_rules('edit_kpmaster_testname', 'Test Name', 'trim|required');
            $this->form_validation->set_rules('edit_kpmaster_enable_date', 'Enable Name', 'trim|required');
            $this->form_validation->set_rules('edit_kpmaster_duration_time', 'Duration Date', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $edit_kpmaster_id = $this->input->post('edit_kpmaster_id');
                $edit_kpmaster_testname = $this->input->post('edit_kpmaster_testname');
                $edit_kpmaster_department = $this->input->post('edit_kpmaster_department');
                $edit_kpmaster_enable_date1 = $this->input->post('edit_kpmaster_enable_date');
                $edit_kpmaster_enable_date = date("Y-m-d", strtotime($edit_kpmaster_enable_date1));
                $edit_kpmaster_duration_time = $this->input->post('edit_kpmaster_duration_time');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Department_Id' => $edit_kpmaster_department,
                    'Test_Name' => $edit_kpmaster_testname,
                    'Enable_Date' => $edit_kpmaster_enable_date,
                    'Duration_Time' => $edit_kpmaster_duration_time,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Kp_Id', $edit_kpmaster_id);
                $q = $this->db->update('tbl_kpmaster', $update_data);

                $this->db->where('Kp_Id', $edit_kpmaster_id);
                $this->db->delete('tbl_kpquestions');

                $filename = $_FILES["iprquestionfile_edit_file"]["tmp_name"];
                if ($filename != "") {
                    if ($_FILES["iprquestionfile_edit_file"]["size"] > 0) {
                        $file = fopen($filename, "r");
                        while (($iprData = fgetcsv($file, 10000, ",")) !== FALSE) {
                            $insert_data3 = array(
                                'Kp_Id' => $edit_kpmaster_id,
                                'Question' => $iprData[0],
                                'Option1' => $iprData[1],
                                'Option2' => $iprData[2],
                                'Option3' => $iprData[3],
                                'Option4' => $iprData[4],
                                'Answer' => $iprData[5],
                                'Inserted_By' => $modified_id,
                                'Inserted_Date' => date('Y-m-d H:i:s'),
                                'Status' => 1
                            );
                            $this->db->insert('tbl_kpquestions', $insert_data3);
                        }
                    }
                }
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }else{
                echo "fail";
            }
        }
    }

    // Delete Controller start
    public function Deletekpmaster() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $Kp_Id = $this->input->post('Kp_Id');
            $data = array(
                'Kp_Id' => $Kp_Id
            );
            $this->load->view('ipr/delete_kpmaster', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Ipr master Delete Details Start Here */

    public function delete_kpmaster() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $this->form_validation->set_rules('delete_kpmaster_id', 'ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $delete_kpmaster_id = $this->input->post('delete_kpmaster_id');
                $sess_data = $this->session->all_userdata();
                $update_data = array(
                    'Status' => 0
                );
            }
            $this->db->where('Kp_Id', $delete_kpmaster_id);
            $q = $this->db->update('tbl_kpmaster', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Ipr master Delete Details End Here */

    /* IPR KP Questions Start Here */

    public function Question() {
        $data = array(
            'title' => 'Knowledge Process Questions',
            'main_content' => 'ipr/question/intro'
        );
        $this->load->view('Common/content', $data);
    }

    public function Questions() {
        $data = array(
            'title' => 'Knowledge Process Questions',
            'main_content' => 'ipr/question/index'
        );
        $this->load->view('Common/content', $data);
    }

    public function Result() {
        $data = array(
            'title' => 'Knowledge Process Questions',
            'main_content' => 'ipr/question/result'
        );
        $this->load->view('Common/content', $data);
    }

    public function add_result() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $this->form_validation->set_rules('add_kpemployee_score', 'Score', 'trim|required');
            $this->form_validation->set_rules('add_kpemployee_wronganswer', '', 'trim|required');
            $this->form_validation->set_rules('add_kpemployee_unanswer', 'Unanswer', 'trim|required');
            $this->form_validation->set_rules('add_kpemployee_duration_time', 'Duration Time', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $add_kpemployee_score = $this->input->post('add_kpemployee_score');
                $add_kpemployee_wronganswer = $this->input->post('add_kpemployee_wronganswer');
                $add_kpemployee_unanswer = $this->input->post('add_kpemployee_unanswer');
                $add_kpemployee_duration_time1 = $this->input->post('add_kpmaster_enable_date');
                //Time format converted
                $add_kpemployee_duration_time = date("H:i:s", strtotime($add_kpemployee_duration_time1));

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];
                // My code Start                      
                $emp_number = $empData[0];
                $employee_id = str_pad(($emp_number), 4, '0', STR_PAD_LEFT);
                $kp_id = $this->db->insert_id();

                // My code End                 
                $insert_data = array(
                    'Kp_Id' => $kp_id,
                    'Employee_Id' => $employee_id,
                    'Score' => $add_kpemployee_score,
                    'Wrong_Ans' => $add_kpemployee_wronganswer,
                    'Unanswer' => $add_kpemployee_unanswer,
                    'Duraion' => $add_kpemployee_duration_time,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Inserted_By' => $inserted_id,
                    'Status' => 1
                );
                $q2 = $this->db->insert('tbl_kpemployee', $insert_data);
                if ($q2) {
                    echo "success";
                } else {
                    echo "fail";
                }
            }
        }
    }
	
	// 20-07-2017 Host File Demo
	
	
	public function IPR_Info() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'IPR info',
                'main_content' => 'ipr/info/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }
	// IPR Information Import in Excel Add here
    public function add_iprinfo() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('add_kpmaster_enable_date', 'Enable Date', 'trim|required');

            $filename = $_FILES["iprquestionfile"]["tmp_name"];
            if ($_FILES["iprquestionfile"]["size"] > 0) {
                if ($this->form_validation->run() == TRUE) {
                    $add_kpmaster_enable_date1 = $this->input->post('add_kpmaster_enable_date');
                    $add_kpmaster_enable_date = date("Y-m-d", strtotime($add_kpmaster_enable_date1));

                    $sess_data = $this->session->all_userdata();
                    $inserted_id = $sess_data['user_id'];
                    $insert_data = array(
                        'Enable_Date' => $add_kpmaster_enable_date,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                    $q = $this->db->insert('tbl_iprmaster', $insert_data);
                    $kp_id = $this->db->insert_id();

                    $file = fopen($filename, "r");
                    while (($iprData1 = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $insert_data2 = array(
                            'Emp_Id' => $iprData1[0],
                            'Employee_Name' => $iprData1[1],
                            'Month' => $iprData1[2],
                            'Year' => $iprData1[3],
                            'Efficiency' => $iprData1[4],
                            'Accuracy' => $iprData1[5],
                            'Punctuality' => $iprData1[6],
                            'Process_Knowledge' => $iprData1[7],
                            'Teamwork_Flexibility' => $iprData1[8],
                            'Total_Efficiency' => $iprData1[9],
                            'Total_Accuracy' => $iprData1[10],
                            'Internal' => $iprData1[11],
                            'External' => $iprData1[12],
                            'Total_Orders' =>$iprData1[13],
                            'Total_Errors' => $iprData1[14],
                            'Attendance' => $iprData1[15],
                            'Leaves' => $iprData1[16],
                            'Weekend_Working' => $iprData1[17],
                            'LOP' => $iprData1[18],
                            'Overall_Score' => $iprData1[19],
                            'Final_Rating' => $iprData1[20],
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $q2 = $this->db->insert('tbl_iprmaster1', $insert_data2);
                    }
                    if ($q2) {
                        echo "success";
                    } else {
                        echo "fail";
                    }
                }
            }
        }
    }
	
	

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>