<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Company extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }

    /* Company Details Start Here */

    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Company',
                'main_content' => 'company/company'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function add_company() {

        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            // $this->form_validation->set_delimeters('<div class="error">', '</div>');

            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('company_address', 'Company Address', 'trim|required');
            $this->form_validation->set_rules('add_company_country', '', 'trim|required');
            $this->form_validation->set_rules('add_company_state', '', 'trim|required');
            $this->form_validation->set_rules('add_company_district', '', 'trim|required');
            $this->form_validation->set_rules('company_city', 'Company City', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $company_name = $this->input->post('company_name');
                $company_slogan = $this->input->post('company_slogan');
                $company_reg_no = $this->input->post('company_reg_no');
                $company_address = $this->input->post('company_address');
                $company_country = $this->input->post('add_company_country');
                $company_state = $this->input->post('add_company_state');
                $company_district = $this->input->post('add_company_district');
                $company_city = $this->input->post('company_city');
                $company_pincode = $this->input->post('company_pincode');
                $company_telno = $this->input->post('company_telno');
                $company_fax = $this->input->post('company_fax');
                $company_email = $this->input->post('company_email');
                $company_website = $this->input->post('company_website');

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $logo = $_FILES['userfile']['name'];

                if ($logo != "") {
                    $cmp_logo = uniqid() . $logo;
                    $config = array(
                        'file_name' => $cmp_logo,
                        'allowed_types' => 'jpg|jpeg|png|gif',
                        'upload_path' => 'company_logo/',
                        'max_size' => 2048
                    );
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $this->upload->do_upload('userfile');
                    $insert_data = array(
                        'Company_Name' => $company_name,
                        'Comp_slogan' => $company_slogan,
                        'Comp_RegistrationNo' => $company_reg_no,
                        'Comp_Address' => $company_address,
                        'Comp_Country' => $company_country,
                        'Comp_State' => $company_state,
                        'Comp_District' => $company_district,
                        'Comp_City' => $company_city,
                        'Comp_Pincode' => $company_pincode,
                        'Comp_Phone' => $company_telno,
                        'Comp_Fax' => $company_fax,
                        'Comp_Email' => $company_email,
                        'Comp_Web' => $company_website,
                        'Comp_Logo' => $cmp_logo,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                } else {

                    $insert_data = array(
                        'Company_Name' => $company_name,
                        'Comp_slogan' => $company_slogan,
                        'Comp_RegistrationNo' => $company_reg_no,
                        'Comp_Address' => $company_address,
                        'Comp_Country' => $company_country,
                        'Comp_State' => $company_state,
                        'Comp_District' => $company_district,
                        'Comp_City' => $company_city,
                        'Comp_Pincode' => $company_pincode,
                        'Comp_Phone' => $company_telno,
                        'Comp_Fax' => $company_fax,
                        'Comp_Email' => $company_email,
                        'Comp_Web' => $company_website,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'),
                        'Status' => 1
                    );
                }
                $q = $this->db->insert('tbl_company', $insert_data);
                if ($q) {
                    redirect('Company');
                } else {
                    echo "<script>alert('Failed to add company details')</script>";
                }
            } else {
                //$this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Editcompany() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $company_id = $this->input->post('company_id');
            $data = array(
                'company_id' => $company_id
            );
            $this->load->view('company/edit_company', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_company() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            // $this->form_validation->set_delimeters('<div class="error">', '</div>');

            $this->form_validation->set_rules('edit_company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('edit_company_address', 'Company Address', 'trim|required');
            $this->form_validation->set_rules('edit_company_country', '', 'trim|required');
            $this->form_validation->set_rules('edit_company_state', '', 'trim|required');
            $this->form_validation->set_rules('edit_company_district', '', 'trim|required');
            $this->form_validation->set_rules('edit_company_city', 'Company City', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $company_id = $this->input->post('edit_company_id');
                $company_name = $this->input->post('edit_company_name');
                $company_slogan = $this->input->post('edit_company_slogan');
                $company_reg_no = $this->input->post('edit_company_reg_no');
                $company_address = $this->input->post('edit_company_address');
                $company_country = $this->input->post('edit_company_country');
                $company_state = $this->input->post('edit_company_state');
                $company_district = $this->input->post('edit_company_district');
                $company_city = $this->input->post('edit_company_city');
                $company_pincode = $this->input->post('edit_company_pincode');
                $company_telno = $this->input->post('edit_company_telno');
                $company_fax = $this->input->post('edit_company_fax');
                $company_email = $this->input->post('edit_company_email');
                $company_website = $this->input->post('edit_company_website');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $logo = $_FILES['edit_userfile']['name'];
                if ($logo != "") {
                    $cmp_logo = rand() . $logo;
                    $config = array(
                        'file_name' => $cmp_logo,
                        'allowed_types' => 'jpg|jpeg|png|gif',
                        'upload_path' => './company_logo/',
                        'max_size' => 2048
                    );
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    $this->upload->do_upload('edit_userfile');
                    $update_data = array(
                        'Company_Name' => $company_name,
                        'Comp_slogan' => $company_slogan,
                        'Comp_RegistrationNo' => $company_reg_no,
                        'Comp_Address' => $company_address,
                        'Comp_Country' => $company_country,
                        'Comp_State' => $company_state,
                        'Comp_District' => $company_district,
                        'Comp_City' => $company_city,
                        'Comp_Pincode' => $company_pincode,
                        'Comp_Phone' => $company_telno,
                        'Comp_Fax' => $company_fax,
                        'Comp_Email' => $company_email,
                        'Comp_Web' => $company_website,
                        'Comp_Logo' => $cmp_logo,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                } else {
                    $update_data = array(
                        'Company_Name' => $company_name,
                        'Comp_slogan' => $company_slogan,
                        'Comp_RegistrationNo' => $company_reg_no,
                        'Comp_Address' => $company_address,
                        'Comp_Country' => $company_country,
                        'Comp_State' => $company_state,
                        'Comp_District' => $company_district,
                        'Comp_City' => $company_city,
                        'Comp_Pincode' => $company_pincode,
                        'Comp_Phone' => $company_telno,
                        'Comp_Fax' => $company_fax,
                        'Comp_Email' => $company_email,
                        'Comp_Web' => $company_website,
                        'Modified_By' => $modified_id,
                        'Modified_Date' => date('Y-m-d H:i:s')
                    );
                }

                $this->db->where('Company_Id', $company_id);
                $q = $this->db->update('tbl_company', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    // echo "<script>alert('Failed to update company details')</script>";
                    echo "fail";
                }
            } else {
                $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletecompany() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $company_id = $this->input->post('company_id');
            $data = array(
                'company_id' => $company_id
            );
            $this->load->view('company/delete_company', $data);
        } else {
            redirect('Profile');
        }
    }

    public function delete_company() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $company_id = $this->input->post('delete_company_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Company_Id', $company_id);
            $q = $this->db->update('tbl_company', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Company Details End Here */

    /* Branch Details Start Here */

    public function Branch() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Branch',
                'main_content' => 'company/branch'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_branch() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
            $this->form_validation->set_rules('branch_address', 'Branch Address', 'trim|required');
            $this->form_validation->set_rules('country', '', 'trim|required');
            $this->form_validation->set_rules('state', '', 'trim|required');
            $this->form_validation->set_rules('district', '', 'trim|required');
            $this->form_validation->set_rules('branch_city', 'Branch City', 'trim|required');


            if ($this->form_validation->run() == TRUE) {

                $company_name = $this->input->post('company_name');
                $branch_name = $this->input->post('branch_name');
                $branch_code = $this->input->post('branch_code');
                $branch_address = $this->input->post('branch_address');
                $branch_country = $this->input->post('country');
                $branch_state = $this->input->post('state');
                $branch_district = $this->input->post('district');
                $branch_city = $this->input->post('branch_city');
                $branch_pincode = $this->input->post('branch_pincode');
                $branch_telno = $this->input->post('branch_telno');
                $branch_fax = $this->input->post('branch_fax');
                $branch_email = $this->input->post('branch_email');
                $branch_website = $this->input->post('branch_website');

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Company_Id' => $company_name,
                    'Branch_Name' => $branch_name,
                    'Branch_Code' => $branch_code,
                    'Branch_Address' => $branch_address,
                    'Branch_Country' => $branch_country,
                    'Branch_State' => $branch_state,
                    'Branch_District' => $branch_district,
                    'Branch_City' => $branch_city,
                    'Branch_Pincode' => $branch_pincode,
                    'Branch_Phone' => $branch_telno,
                    'Branch_Fax' => $branch_fax,
                    'Branch_Email' => $branch_email,
                    'Branch_Web' => $branch_website,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_branch', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                // $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Editbranch() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $branch_id = $this->input->post('branch_id');
            $data = array(
                'branch_id' => $branch_id
            );
            $this->load->view('company/edit_branch', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_branch() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_branch_name', 'Branch Name', 'trim|required');
            $this->form_validation->set_rules('country', '', 'trim|required');
            $this->form_validation->set_rules('state', '', 'trim|required');
            $this->form_validation->set_rules('district', '', 'trim|required');
            $this->form_validation->set_rules('edit_branch_city', 'Branch City', 'trim|required');


            if ($this->form_validation->run() == TRUE) {
                $branch_id = $this->input->post('edit_branch_id');
                $branch_name = $this->input->post('edit_branch_name');
                $company_name = $this->input->post('edit_company_name');
                $branch_code = $this->input->post('edit_branch_code');
                $branch_address = $this->input->post('edit_branch_address');
                $branch_country = $this->input->post('country');
                $branch_state = $this->input->post('state');
                $branch_district = $this->input->post('district');
                $branch_city = $this->input->post('edit_branch_city');
                $branch_pincode = $this->input->post('edit_branch_pincode');
                $branch_telno = $this->input->post('edit_branch_telno');
                $branch_fax = $this->input->post('edit_branch_fax');
                $branch_email = $this->input->post('edit_branch_email');
                $branch_website = $this->input->post('edit_branch_website');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                date_default_timezone_set('UTC');
                $update_data = array(
                    'Branch_Name' => $branch_name,
                    'Branch_Code' => $branch_code,
                    'Branch_Address' => $branch_address,
                    'Branch_Country' => $branch_country,
                    'Branch_State' => $branch_state,
                    'Branch_District' => $branch_district,
                    'Branch_City' => $branch_city,
                    'Branch_Pincode' => $branch_pincode,
                    'Branch_Phone' => $branch_telno,
                    'Branch_Fax' => $branch_fax,
                    'Branch_Email' => $branch_email,
                    'Branch_Web' => $branch_website,
                    'Company_Id' => $company_name,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );

                $this->db->where('Branch_ID', $branch_id);
                $q = $this->db->update('tbl_branch', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                // $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletebranch() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $branch_id = $this->input->post('branch_id');
            $data = array(
                'branch_id' => $branch_id
            );
            $this->load->view('company/delete_branch', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_branch() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $company_id = $this->input->post('delete_branch_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Branch_ID', $company_id);
            $q = $this->db->update('tbl_branch', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Branch Details End Here */

    /* Department Details Start Here */

    public function Department() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Department',
                'main_content' => 'company/department'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_department() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $company_id = $this->input->post('company_name');
                $branch_id = $this->input->post('branch_name');
                $department_name = $this->input->post('department_name');

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Company_Id' => $company_id,
                    'Branch_Id' => $branch_id,
                    'Department_Name' => $department_name,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_department', $insert_data);
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

    public function Editdepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $dept_id = $this->input->post('department_id');
            $data = array(
                'department_id' => $dept_id
            );
            $this->load->view('company/edit_department', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_department() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_department_name', 'Department Name', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $company_id = $this->input->post('company_name');
                $branch_id = $this->input->post('branch_name');
                $department_name = $this->input->post('edit_department_name');
                $department_id = $this->input->post('edit_department_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Company_Id' => $company_id,
                    'Branch_Id' => $branch_id,
                    'Department_Name' => $department_name,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Department_Id', $department_id);
                $q = $this->db->update('tbl_department', $update_data);
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

    public function Deletedepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $dept_id = $this->input->post('department_id');
            $data = array(
                'department_id' => $dept_id
            );
            $this->load->view('company/delete_department', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_department() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_department_id', 'Department Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $department_id = $this->input->post('delete_department_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('Department_Id', $department_id);
                $q = $this->db->update('tbl_department', $update_data);
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

    /* Department Details End Here */

    /* Sub Department Details Start Here */

    public function SubDepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Client',
                'main_content' => 'company/subdepartment'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_subdepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
            $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
            $this->form_validation->set_rules('client_name', 'Client Name', 'trim|required');
            $this->form_validation->set_rules('subdepartment_name', 'Sub Department Name', 'trim|required');
			//$this->form_validation->set_rules('add_process', 'Process', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $dept_id = $this->input->post('department_name');
                $client_name = $this->input->post('client_name');
                $subdepartment_name = $this->input->post('subdepartment_name');
				//$add_process = $this->input->post('add_process');
				
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Department_Id' => $dept_id,
                    'Client_Name' => $client_name,
                    'Subdepartment_Name' => $subdepartment_name,
					//'Process' => $add_process,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_subdepartment', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                // $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Editsubdepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $subdept_id = $this->input->post('subdepartment_id');
            $data = array(
                'subdepartment_id' => $subdept_id
            );
            $this->load->view('company/edit_subdepartment', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_subdepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
            $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
            $this->form_validation->set_rules('client_name', 'Client Name', 'trim|required');
            $this->form_validation->set_rules('edit_subdepartment_name', 'Sub Department Name', 'trim|required');
			//$this->form_validation->set_rules('edit_process', 'Process', 'trim|required');
            if ($this->form_validation->run() == TRUE) {

                $subdepartment_id = $this->input->post('edit_subdepartment_id');
                $client_name = $this->input->post('client_name');
                $subdepartment_name = $this->input->post('edit_subdepartment_name');
                $department_id = $this->input->post('department_name');
				//$edit_process = $this->input->post('edit_process');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Department_Id' => $department_id,
                    'Subdepartment_Name' => $subdepartment_name,
                    'Client_Name' => $client_name,
					//'Process' => $edit_process,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Subdepartment_Id', $subdepartment_id);
                $q = $this->db->update('tbl_subdepartment', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                // $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletesubdepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $subdept_id = $this->input->post('subdepartment_id');
            $data = array(
                'subdepartment_id' => $subdept_id
            );
            $this->load->view('company/delete_subdepartment', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_subdepartment() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_subdepartment_id', 'Sub Department Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $subdepartment_id = $this->input->post('delete_subdepartment_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('Subdepartment_Id', $subdepartment_id);
                $q = $this->db->update('tbl_subdepartment', $update_data);
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

    /* Sub Department Details End Here */

    /* Designation Details Start Here */

    public function Designation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Designation',
                'main_content' => 'company/designation'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect("Profile");
        }
    }

    public function add_designation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {

            $this->form_validation->set_rules('branch_name', 'Branch', 'trim|required');
            $this->form_validation->set_rules('department_name', 'Department', 'trim|required');
            $this->form_validation->set_rules('client_name', 'Client', 'trim|required');
            $this->form_validation->set_rules('sub_process', 'Sub Process', 'trim|required');
            $this->form_validation->set_rules('designation_name', 'Designation Name', 'trim|required');
            $this->form_validation->set_rules('grade_name', 'Grade Name', 'trim|required');
            $this->form_validation->set_rules('role', 'Role', 'trim|required');
            $this->form_validation->set_rules('notice_period', 'Notice Period', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $grade_name = $this->input->post('grade_name');
                $designation_name = $this->input->post('designation_name');
                $client_name = $this->input->post('client_name');
                $role = $this->input->post('role');
                $notice_period = $this->input->post('notice_period');

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $insert_data = array(
                    'Client_Id' => $client_name,
                    'Designation_Name' => $designation_name,
                    'Grade' => $grade_name,
                    'Role' => $role,
                    'Notice_Period' => $notice_period,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_designation', $insert_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                //   $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Editdesignation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $designation_id = $this->input->post('designation_id');
            $data = array(
                'designation_id' => $designation_id
            );
            $this->load->view('company/edit_designation', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_designation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('branch_name', 'Branch', 'trim|required');
            $this->form_validation->set_rules('department_name', 'Department', 'trim|required');
            $this->form_validation->set_rules('client_name', 'Client', 'trim|required');
            $this->form_validation->set_rules('sub_process', 'Sub Process', 'trim|required');
            $this->form_validation->set_rules('edit_designation_name', 'Designation Name', 'trim|required');
            $this->form_validation->set_rules('edit_grade_name', 'Grade Name', 'trim|required');
            $this->form_validation->set_rules('edit_role_name', 'Role Name', 'trim|required');
            $this->form_validation->set_rules('edit_notice_period', 'Notice Period', 'trim|required');

            if ($this->form_validation->run() == TRUE) {

                $designation_id = $this->input->post('edit_designation_id');
                $designation_name = $this->input->post('edit_designation_name');
                $client_name = $this->input->post('client_name');
                $grade_name = $this->input->post('edit_grade_name');
                $role = $this->input->post('edit_role_name');
                $notice_period = $this->input->post('edit_notice_period');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Client_Id' => $client_name,
                    'Designation_Name' => $designation_name,
                    'Grade' => $grade_name,
                    'Role' => $role,
                    'Notice_Period' => $notice_period,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Designation_Id', $designation_id);
                $q = $this->db->update('tbl_designation', $update_data);
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

    public function Deletedesignation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $designation_id = $this->input->post('designation_id');
            $data = array(
                'designation_id' => $designation_id
            );
            $this->load->view('company/delete_designation', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_designation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('delete_designation_id', 'Designation Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $designation_id = $this->input->post('delete_designation_id');

                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];

                $update_data = array(
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 0
                );
                $this->db->where('Designation_Id', $designation_id);
                $q = $this->db->update('tbl_designation', $update_data);
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

    /* Designation Details End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>