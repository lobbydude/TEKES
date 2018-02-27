<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Employee extends CI_Controller {

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
        if ($user_role == 1 ||  $user_role == 2 || $user_role == 6 || $user_role == 4 || $user_role == 5 || $user_role == 7) {
            $data = array(
                'title' => 'Employee',
                'main_content' => 'employee/employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Employee Code Setup Start Here */

    public function empcode_setup() {
        $this->form_validation->set_rules('emp_code', 'Employee Code', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $emp_code = $this->input->post('emp_code');
            $hidden_emp_code = $this->input->post('hidden_emp_code');
            //   $starting_format = $this->input->post('starting_format');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data1 = array(
                'employee_code' => $emp_code,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s')
            );

            //    $this->db->where('id', 1);
            $this->db->like('employee_code', $hidden_emp_code);
            $q = $this->db->update('tbl_emp_code', $update_data1);

            //$update_data2 = array(
            //    'Username' => $emp_code
           // );

            //$this->db->like('Username', $hidden_emp_code);
            //$this->db->update('tbl_user', $update_data2);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Employee Code Setup End Here */


    /* Add Employee Details Start Here */

    public function AddEmployee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Add Employee',
                'main_content' => 'employee/add_employee'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    /* Basic Information Start Here */

    function basicInfo() {

        $this->form_validation->set_rules('first_name', 'Frist Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Date of Birth', 'trim|required');
        $this->form_validation->set_rules('branch_name', 'Branch', 'trim|required');
        $this->form_validation->set_rules('department_name', 'Department', 'trim|required');
        $this->form_validation->set_rules('client_name', 'Client', 'trim|required');
        $this->form_validation->set_rules('subprocess', 'Sub Process', 'trim|required');
        $this->form_validation->set_rules('designation_name', 'Designation', 'trim|required');
        $this->form_validation->set_rules('department_role', 'Department Role', 'trim|required');
        $this->form_validation->set_rules('grade', 'Grade', 'trim|required');
        $this->form_validation->set_rules('reporting_to', 'Reporting To', 'trim|required');
        $this->form_validation->set_rules('joining_date', 'Join Date', 'trim|required');
        $this->form_validation->set_rules('confirmation_period', 'Confirmation Period', 'trim|required');
        $this->form_validation->set_rules('confirmation_date', 'Confirmation Date', 'trim|required');

        $confirmation_period = $this->input->post('confirmation_period');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $employee_code = $this->input->post('employee_code');
            $first_name = $this->input->post('first_name');
            $middle_name = $this->input->post('middle_name');
            $last_name = $this->input->post('last_name');
            $gender = $this->input->post('gender');

            $birthdate = $this->input->post('birthdate');
            $dob = date("Y-m-d", strtotime($birthdate));

            $actual_birthdate = $this->input->post('actual_birthdate');
            if ($actual_birthdate != "") {
                $actual_dob = date("Y-m-d", strtotime($actual_birthdate));
            } else {
                $actual_dob = $dob;
            }

            $blood_group = $this->input->post('blood_group');
            $mobile_number = $this->input->post('mobile_number');
            $alternate_number = $this->input->post('alternate_number');
            $official_email_address = $this->input->post('official_email_address');

            $bank_name = $this->input->post('bank_name');
            $acc_no = $this->input->post('acc_no');
            $ifsc_code = $this->input->post('ifsc_code');
            $pan_no = $this->input->post('pan_no');
            $uan_no = $this->input->post('uan_no');
            $pf_no = $this->input->post('pf_no');
            $esi = $this->input->post('esi');
            $medical_insurance = $this->input->post('medical_insurance');

            $branch = $this->input->post('branch_name');
            $department = $this->input->post('department_name');
            $client = $this->input->post('client_name');
            $designation_name = $this->input->post('designation_name');
            $reporting_to = $this->input->post('reporting_to');

            $joining_date = $this->input->post('joining_date');
            $doj = date("Y-m-d", strtotime($joining_date));

            $confirmation_period = $this->input->post('confirmation_period');

            $confirmation_date = $this->input->post('confirmation_date');
            $doc = date("Y-m-d", strtotime($confirmation_date));

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data1 = array(
                'employee_code' => $employee_code,
                'employee_number' => $employee_id,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $this->db->insert('tbl_emp_code', $insert_data1);

            $insert_data2 = array(
                'Emp_Number' => $employee_id,
                'Emp_FirstName' => $first_name,
                'Emp_MiddleName' => $middle_name,
                'Emp_LastName' => $last_name,
                'Emp_Dob' => $dob,
                'Emp_ActuallDob' => $actual_dob,
                'Emp_Gender' => $gender,
                'Emp_Bldgroup' => $blood_group,
                'Emp_Doj' => $doj,
                'Emp_Confirmationperiod' => $confirmation_period,
                'Emp_Confirmationdate' => $doc,
                'Emp_Contact' => $mobile_number,
                'Emp_AlternateContact' => $alternate_number,
                'Emp_Officialemail' => $official_email_address,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $this->db->insert('tbl_employee', $insert_data2);

            $insert_data3 = array(
                'Employee_Id' => $employee_id,
                'Emp_Bankname' => $bank_name,
                'Emp_Accno' => $acc_no,
                'Emp_IFSCcode' => $ifsc_code,
                'Emp_PANcard' => $pan_no,
                'Emp_UANno' => $uan_no,
                'Emp_PFno' => $pf_no,
                'Emp_ESI' => $esi,
                'Emp_Medicalinsurance' => $medical_insurance,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $this->db->insert('tbl_employee_bankdetails', $insert_data3);

            $insert_data4 = array(
                'Employee_Id' => $employee_id,
                'Branch_Id' => $branch,
                'Department_Id' => $department,
                'Client_Id' => $client,
                'Designation_Id' => $designation_name,
                'Reporting_To' => $reporting_to,
                'From' => $doj,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $this->db->insert('tbl_employee_career', $insert_data4);

            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $string = '';
            for ($i = 0; $i < 10; $i++) {
                $string .= $characters[rand(0, strlen($characters) - 1)];
            }
            $random_password = base64_encode($string);

            $insert_data5 = array(
                'User_RoleId' => 3,
                'Employee_Id' => $employee_id,
                'Username' => $employee_code . $employee_id,
                'Password' => $random_password,
                'Password_Updated' => "No",
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $this->db->insert('tbl_user', $insert_data5);

            $doj_day = date('d', strtotime($doj));
            $doj_month = date('m', strtotime($doj));
			$doj_year = date('Y', strtotime($doj));
            if ($doj_day >= 16) {
                $EL = 0;
                $CL = 0;
                $added_month = $doj_month;
				$added_year = $doj_year;
            } else {
                $EL = 1;
                $CL = 1;
                $added_month = $doj_month;
				$added_year = $doj_year;
            }
            $insert_data6 = array(
                'Emp_Id' => $employee_id,
                'EL' => $EL,
                'CL' => $CL,
                'Added_Month' => $added_month,
				'Added_Year' => $added_year,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_leave_pending', $insert_data6);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Basic Information End Here */

    /* Personal Information End Here */

    function personalInfo() {
        $this->form_validation->set_rules('nationality', '', 'trim|required');
        $this->form_validation->set_rules('religion', '', 'trim|required');
        $this->form_validation->set_rules('caste', '', 'trim|required');
        $this->form_validation->set_rules('mother_tongue', '', 'trim|required');
        $this->form_validation->set_rules('personal_blood_group', '', 'trim|required');
        $this->form_validation->set_rules('personal_birthdate', '', 'trim|required');
        $this->form_validation->set_rules('marital_status', '', 'trim|required');
        $this->form_validation->set_rules('mobile_number', '', 'trim|required|numeric');
        $this->form_validation->set_rules('personal_email_address', '', 'trim|required|valid_email');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $nationality = $this->input->post('nationality');
            $religion = $this->input->post('religion');
            $caste = $this->input->post('caste');
            $mother_tongue = $this->input->post('mother_tongue');

            $personal_blood_group = $this->input->post('personal_blood_group');
            $personal_birthdate = $this->input->post('personal_birthdate');
            $dob = date("Y-m-d", strtotime($personal_birthdate));
            $personal_actual_birthdate = $this->input->post('personal_actual_birthdate');
            $actual_dob = date("Y-m-d", strtotime($personal_actual_birthdate));

            $marital_status = $this->input->post('marital_status');
            $mobile_number = $this->input->post('mobile_number');
            $alternate_number = $this->input->post('alternate_number');
            $personal_email_address = $this->input->post('personal_email_address');
            $permanent_address = $this->input->post('permanent_address');
            $temporary_address = $this->input->post('temporary_address');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data1 = array(
                'Emp_Contact' => $mobile_number,
                'Emp_AlternateContact' => $alternate_number,
                'Emp_Dob' => $dob,
                'Emp_ActuallDob' => $actual_dob,
                'Emp_Bldgroup' => $personal_blood_group
            );
            $this->db->where('Emp_Number', $employee_id);
            $this->db->update('tbl_employee', $update_data1);


            $insert_data2 = array(
                'Employee_Id' => $employee_id,
                'Emp_Nationality' => $nationality,
                'Emp_Religion' => $religion,
                'Emp_Caste' => $caste,
                'Emp_Mother_Tongue' => $mother_tongue,
                'Emp_Marrial' => $marital_status,
                'Emp_PersonalEmail' => $personal_email_address,
                'Emp_Permanent' => $permanent_address,
                'Emp_Temporary' => $temporary_address,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_personal', $insert_data2);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    function language_details() {
        $this->form_validation->set_rules('lang_name', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $lang_name = $this->input->post('lang_name');
            $lang_read = $this->input->post('lang_read');
            $lang_speak = $this->input->post('lang_speak');
            $lang_write = $this->input->post('lang_write');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Lang_Name' => $lang_name,
                'Lang_Read' => $lang_read,
                'Lang_Speak' => $lang_speak,
                'Lang_Write' => $lang_write,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_language', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deletelang() {
        $lang_id = $this->input->post('lang_id');
        $data = array(
            'lang_id' => $lang_id
        );
        $this->load->view('employee/lang/delete_lang', $data);
    }

    function delete_lang_details() {
        $this->form_validation->set_rules('delete_lang_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $lang_id = $this->input->post('delete_lang_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Lang_Id', $lang_id);
            $q = $this->db->update('tbl_employee_language', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Personal Information End Here */


    /* Family Information Start Here */

    function family_details() {
        $this->form_validation->set_rules('family_member_name', '', 'trim|required');
        $this->form_validation->set_rules('family_member_relationship', '', 'trim|required');
        $this->form_validation->set_rules('family_member_gender', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $family_member_name = $this->input->post('family_member_name');
            $family_member_age = $this->input->post('family_member_age');
            $family_member_dob = $this->input->post('family_member_dob');
            $dob = date("Y-m-d", strtotime($family_member_dob));
            $family_member_relationship = $this->input->post('family_member_relationship');
            $family_member_gender = $this->input->post('family_member_gender');
            $family_member_occupation = $this->input->post('family_member_occupation');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Name' => $family_member_name,
                'Age' => $family_member_age,
                'DOB' => $dob,
                'Relationship' => $family_member_relationship,
                'Gender' => $family_member_gender,
                'Occupation' => $family_member_occupation,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_family', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Editfamily() {
        $family_id = $this->input->post('family_id');
        $data = array(
            'family_id' => $family_id
        );
        $this->load->view('employee/family/edit_family', $data);
    }

    function edit_family_details() {
        $this->form_validation->set_rules('edit_family_member_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_family_member_relationship', '', 'trim|required');
        $this->form_validation->set_rules('edit_family_member_gender', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $family_id = $this->input->post('edit_family_id');
            $family_member_name = $this->input->post('edit_family_member_name');
            $family_member_age = $this->input->post('edit_family_member_age');
            $family_member_dob = $this->input->post('edit_family_member_dob');
            $dob = date("Y-m-d", strtotime($family_member_dob));
            $family_member_relationship = $this->input->post('edit_family_member_relationship');
            $family_member_gender = $this->input->post('edit_family_member_gender');
            $family_member_occupation = $this->input->post('edit_family_member_occupation');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Name' => $family_member_name,
                'Age' => $family_member_age,
                'DOB' => $dob,
                'Relationship' => $family_member_relationship,
                'Gender' => $family_member_gender,
                'Occupation' => $family_member_occupation,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Family_Id', $family_id);
            $q = $this->db->update('tbl_employee_family', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deletefamily() {
        $family_id = $this->input->post('family_id');
        $data = array(
            'family_id' => $family_id
        );
        $this->load->view('employee/family/delete_family', $data);
    }

    function delete_family_details() {
        $this->form_validation->set_rules('delete_family_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $family_id = $this->input->post('delete_family_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Family_Id', $family_id);
            $q = $this->db->update('tbl_employee_family', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Family Information End Here */

    /* Education Information Start Here */

    function education_details() {
        $this->form_validation->set_rules('qualification', '', 'trim|required');
        $this->form_validation->set_rules('university_name', '', 'trim|required');
        $this->form_validation->set_rules('college_name', '', 'trim|required');
        $this->form_validation->set_rules('major_subject', '', 'trim|required');
        $this->form_validation->set_rules('marks', '', 'trim|required|numeric');
        $this->form_validation->set_rules('year_of_passing', '', 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $qualification = $this->input->post('qualification');
            $university_name = $this->input->post('university_name');
            $college_name = $this->input->post('college_name');
            $major_subject = $this->input->post('major_subject');
            $marks = $this->input->post('marks');
            $year_of_passing = $this->input->post('year_of_passing');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_ID' => $employee_id,
                'Course_Name' => $qualification,
                'University' => $university_name,
                'College_Name' => $college_name,
                'Major_Subject' => $major_subject,
                'Marks' => $marks,
                'Year' => $year_of_passing,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_educationdetails', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    public function Editeducation() {
        $edu_id = $this->input->post('edu_id');
        $data = array(
            'edu_id' => $edu_id
        );
        $this->load->view('employee/education/edit_education', $data);
    }

    function edit_education_details() {
        $this->form_validation->set_rules('edit_qualification', '', 'trim|required');
        $this->form_validation->set_rules('edit_university_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_college_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_major_subject', '', 'trim|required');
        $this->form_validation->set_rules('edit_marks', '', 'trim|required|numeric');
        $this->form_validation->set_rules('edit_year_of_passing', '', 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $edu_id = $this->input->post('edit_edu_id');
            $qualification = $this->input->post('edit_qualification');
            $university_name = $this->input->post('edit_university_name');
            $college_name = $this->input->post('edit_college_name');
            $major_subject = $this->input->post('edit_major_subject');
            $marks = $this->input->post('edit_marks');
            $year_of_passing = $this->input->post('edit_year_of_passing');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Course_Name' => $qualification,
                'University' => $university_name,
                'College_Name' => $college_name,
                'Major_Subject' => $major_subject,
                'Marks' => $marks,
                'Year' => $year_of_passing,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Emp_QualificationId', $edu_id);
            $q = $this->db->update('tbl_employee_educationdetails', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deleteeducation() {
        $edu_id = $this->input->post('edu_id');
        $data = array(
            'edu_id' => $edu_id
        );
        $this->load->view('employee/education/delete_education', $data);
    }

    function delete_education_details() {
        $this->form_validation->set_rules('delete_edu_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $delete_edu_id = $this->input->post('delete_edu_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Emp_QualificationId', $delete_edu_id);
            $q = $this->db->update('tbl_employee_educationdetails', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Education Information End Here */

    /* Skills Information Start Here */

    function skill_details() {
        $this->form_validation->set_rules('skill_name', '', 'trim|required');
        $this->form_validation->set_rules('no_of_month', '', 'trim|required|numeric');
        $this->form_validation->set_rules('training', '', 'trim|required');
        $this->form_validation->set_rules('skill_from', '', 'trim|required');
        $this->form_validation->set_rules('skill_to', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $skill_name = $this->input->post('skill_name');
            $no_of_month = $this->input->post('no_of_month');
            $training = $this->input->post('training');

            $skill_from = $this->input->post('skill_from');
            $from = date("Y-m-d", strtotime($skill_from));
            $skill_to = $this->input->post('skill_to');
            $to = date("Y-m-d", strtotime($skill_to));

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_ID' => $employee_id,
                'Skill_Name' => $skill_name,
                'Months' => $no_of_month,
                'Training' => $training,
                'Skill_From' => $from,
                'Skill_To' => $to,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_skills', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    public function Editskills() {
        $skills_id = $this->input->post('skills_id');
        $data = array(
            'skills_id' => $skills_id
        );
        $this->load->view('employee/skills/edit_skills', $data);
    }

    function edit_skills_details() {
        $this->form_validation->set_rules('edit_skill_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_no_of_month', '', 'trim|required');
        $this->form_validation->set_rules('edit_training', '', 'trim|required');
        $this->form_validation->set_rules('edit_skill_from', '', 'trim|required');
        $this->form_validation->set_rules('edit_skill_to', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $skills_id = $this->input->post('edit_skills_id');
            $edit_skill_name = $this->input->post('edit_skill_name');
            $edit_no_of_month = $this->input->post('edit_no_of_month');
            $edit_training = $this->input->post('edit_training');
            $edit_skill_from = $this->input->post('edit_skill_from');
            $from = date("Y-m-d", strtotime($edit_skill_from));
            $edit_skill_to = $this->input->post('edit_skill_to');
            $to = date("Y-m-d", strtotime($edit_skill_to));

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Skill_Name' => $edit_skill_name,
                'Months' => $edit_no_of_month,
                'Training' => $edit_training,
                'Skill_From' => $from,
                'Skill_To' => $to,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Skill_Id', $skills_id);
            $q = $this->db->update('tbl_employee_skills', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deleteskills() {
        $skills_id = $this->input->post('skills_id');
        $data = array(
            'skills_id' => $skills_id
        );
        $this->load->view('employee/skills/delete_skills', $data);
    }

    function delete_skills_details() {
        $this->form_validation->set_rules('delete_skills_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $skills_id = $this->input->post('delete_skills_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Skill_Id', $skills_id);
            $q = $this->db->update('tbl_employee_skills', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Skills Information End Here */

    /* Experience Information Start Here */

    function experience_details() {
        $this->form_validation->set_rules('prev_company_name', '', 'trim|required');
        $this->form_validation->set_rules('prev_designation', '', 'trim|required');
        $this->form_validation->set_rules('prev_company_location', '', 'trim|required');
        $this->form_validation->set_rules('prev_salary', '', 'trim|required');
        $this->form_validation->set_rules('prev_date_joined', '', 'trim|required');
        $this->form_validation->set_rules('prev_date_relieved', '', 'trim|required');
        $this->form_validation->set_rules('prev_reason_relieving', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $prev_company_name = $this->input->post('prev_company_name');
            $prev_designation = $this->input->post('prev_designation');
            $prev_company_location = $this->input->post('prev_company_location');
            $prev_salary = $this->input->post('prev_salary');
            $ori_prev_date_joined = $this->input->post('prev_date_joined');
            $prev_date_joined = date("Y-m-d", strtotime($ori_prev_date_joined));
            $ori_prev_date_relieved = $this->input->post('prev_date_relieved');
            $prev_date_relieved = date("Y-m-d", strtotime($ori_prev_date_relieved));
            $prev_reason_relieving = $this->input->post('prev_reason_relieving');
            $relevant_exp = $this->input->post('relevant_exp');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Previouscompany' => $prev_company_name,
                'Privious_Comp_Designation' => $prev_designation,
                'Privious_Comp_Location' => $prev_company_location,
                'Privious_Comp_Gross_Salray' => $prev_salary,
                'Privious_Comp_Joineddate' => $prev_date_joined,
                'Privious_Comp_LeavedDate' => $prev_date_relieved,
                'Privious_Comp_ReasonforLeaving' => $prev_reason_relieving,
                'Privious_Comp_ExpType' => $relevant_exp,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_expdetails', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //  $this->load->view('error');
        }
    }

    public function Editexperience() {
        $exp_id = $this->input->post('exp_id');
        $data = array(
            'exp_id' => $exp_id
        );
        $this->load->view('employee/experience/edit_experience', $data);
    }

    function edit_experience_details() {
        $this->form_validation->set_rules('edit_prev_company_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_company_location', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_designation', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_date_joined', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_date_relieved', '', 'trim|required');
        $this->form_validation->set_rules('relevant_exp', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_reason_relieving', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $exp_id = $this->input->post('edit_exp_id');
            $prev_company_name = $this->input->post('edit_prev_company_name');
            $prev_company_location = $this->input->post('edit_prev_company_location');
            $prev_designation = $this->input->post('edit_prev_designation');
            $ori_prev_date_joined = $this->input->post('edit_prev_date_joined');
            $prev_date_joined = date("Y-m-d", strtotime($ori_prev_date_joined));
            $ori_prev_date_relieved = $this->input->post('edit_prev_date_relieved');
            $prev_date_relieved = date("Y-m-d", strtotime($ori_prev_date_relieved));
            $relevant_exp = $this->input->post('relevant_exp');
            $prev_reason_relieving = $this->input->post('edit_prev_reason_relieving');
            $prev_salary = $this->input->post('edit_prev_salary');


            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Previouscompany' => $prev_company_name,
                'Privious_Comp_Designation' => $prev_designation,
                'Privious_Comp_Location' => $prev_company_location,
                'Privious_Comp_Gross_Salray' => $prev_salary,
                'Privious_Comp_Joineddate' => $prev_date_joined,
                'Privious_Comp_LeavedDate' => $prev_date_relieved,
                'Privious_Comp_ReasonforLeaving' => $prev_reason_relieving,
                'Privious_Comp_ExpType' => $relevant_exp,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Privious_Comp_ExpId', $exp_id);
            $q = $this->db->update('tbl_employee_expdetails', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    public function Deleteexperience() {
        $exp_id = $this->input->post('exp_id');
        $data = array(
            'exp_id' => $exp_id
        );
        $this->load->view('employee/experience/delete_experience', $data);
    }

    function delete_experience_details() {
        $this->form_validation->set_rules('delete_exp_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $exp_id = $this->input->post('delete_exp_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Privious_Comp_ExpId', $exp_id);
            $q = $this->db->update('tbl_employee_expdetails', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Experience Information End Here */

    /* Additioanal Information Start Here */

    function info_details() {
        $this->form_validation->set_rules('pancard_no', '', 'trim|required');
        $this->form_validation->set_rules('emergency_contactperson_name', '', 'trim|required');
        $this->form_validation->set_rules('emergency_contact_no', '', 'trim|required');
        // $this->form_validation->set_rules('aadhar_no', '', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');

            $pan_no = $this->input->post('pancard_no');
            $aadhar_no = $this->input->post('aadhar_no');
            $passport_no = $this->input->post('passport_no');
            $name_on_passport = $this->input->post('name_on_passport');
            $place_issue = $this->input->post('place_issue');
            $issue_date1 = $this->input->post('issue_date');
            $issue_date = date("Y-m-d", strtotime($issue_date1));

            $expiry_date1 = $this->input->post('expiry_date');
            $expiry_date = date("Y-m-d", strtotime($expiry_date1));

            $valid_visa = $this->input->post('valid_visa');
            $issue_country = $this->input->post('issue_country');

            $hobbies = $this->input->post('hobbies');
            $interest = $this->input->post('interest');
            $related_employee = $this->input->post('related_employee');
            $related_employee_name = $this->input->post('related_employee_name');
            //  $membership = $this->input->post('membership');
            //  $other = $this->input->post('other');
            $voter_id = $this->input->post('voter_id');

            $allergic = $this->input->post('allergic');
            $blood_pressure = $this->input->post('blood_pressure');
            $differently_abled = $this->input->post('differently_abled');
            $weight = $this->input->post('weight');
            $height = $this->input->post('height');
            $eye_sight = $this->input->post('eye_sight');
            $illness = $this->input->post('illness');
            $emergency_contactperson_name = $this->input->post('emergency_contactperson_name');
            $emergency_contact_no = $this->input->post('emergency_contact_no');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data1 = array(
                'Employee_ID' => $employee_id,
                'Emp_Aadharcard' => $aadhar_no,
                'Emp_Passportno' => $passport_no,
                'Emp_Passportname' => $name_on_passport,
                'Issue_Place' => $place_issue,
                'Issue_Date' => $issue_date,
                'Expiry_Date' => $expiry_date,
                'Valid_visa' => $valid_visa,
                'Issue_Country' => $issue_country,
                'Hobbies' => $hobbies,
                'Intresets' => $interest,
                'Related_Employee' => $related_employee,
                'Employee_Name' => $related_employee_name,
                //    'Membership' => $membership,
                //     'Suggesation' => $other,
                "Voter_Id" => $voter_id,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $this->db->insert('tbl_employee_additionalinformation', $insert_data1);

            $insert_data3 = array(
                'Emp_PANcard' => $pan_no
            );
            $this->db->where('Employee_Id', $employee_id);
            $this->db->update('tbl_employee_bankdetails', $insert_data3);

            $insert_data2 = array(
                'Employee_Id' => $employee_id,
                'Alergic' => $allergic,
                'BloodPressure' => $blood_pressure,
                'Differently_abled' => $differently_abled,
                'Weight' => $weight,
                'Height' => $height,
                'Eye_Sight' => $eye_sight,
                'Major_Illeness' => $illness,
                'Contact_Person' => $emergency_contactperson_name,
                'Mobileno' => $emergency_contact_no,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_emergency_details', $insert_data2);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    /* Additioanal Information End Here */


    /* Attachment Information Start Here */

    function attachment() {
//          $this->form_validation->set_rules('attach_file', 'Please select file', 'trim|required');
//
//        if ($this->form_validation->run() == TRUE) {
        if (is_array($_FILES)) {
            if (is_uploaded_file($_FILES['attach_file']['tmp_name'])) {

                $employee_id = $this->input->post('employee_id');
                $attach_type = $this->input->post('attach_type');

                $sourcePath = $_FILES['attach_file']['tmp_name'];
                $file_name = rand() . $_FILES['attach_file']['name'];
                $targetPath = "upload/" . $file_name;

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $insert_data = array(
                        'Employee_Id' => $employee_id,
                        'Document_Name' => $attach_type,
                        'Files' => $file_name,
                        'Inserted_By' => $inserted_id,
                        'Inserted_Date' => date('Y-m-d H:i:s'), 'Status' => 1
                    );
                    $file_url = "http://192.168.12.151:82/TEKES/upload/";
                    $q = $this->db->insert('tbl_employee_documents', $insert_data);
                    if ($q) {
                        echo "href=$file_url" . "$file_name";
                    } else {
                        echo "fail";
                    }
                }
            }
        }
//        }else{
//            $this->load->view('error');
//        }
    }

    /* Attachment Information End Here */

    /* Download Attachment Start Here */

    function download_attachment() {
        $doc_id = $this->input->post('doc_id');

        $this->db->where('Document_Id', $doc_id);
        $select_doc = $this->db->get('tbl_employee_documents');
        foreach ($select_doc->result() as $row_doc) {
            $doc_file = $row_doc->Files;
        }

        $this->load->helper('download');
        $data = file_get_contents("./upload/$doc_file");
        $name = $doc_file;
        force_download($name, $data);
    }

    /* Download Attachment End Here */

    /*  Background Verfication Start Here */

    function background_verification() {
        $employee_id = $this->input->post('employee_id');
        $background_verification = $this->input->post('background_verification');

        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['user_id'];

        $insert_data = array(
            'Employee_Id' => $employee_id,
            'BG_Verify' => $background_verification,
            'Inserted_By' => $inserted_id,
            'Inserted_Date' => date('Y-m-d H:i:s')
        );
        $q = $this->db->insert('tbl_employee_bgverify', $insert_data);
        if ($q) {
            $this->db->where('Employee_Id', $employee_id);
            $q_user = $this->db->get('tbl_user');
            foreach ($q_user->result() as $row_user) {
                $username = $row_user->Username;
                $random_password = $row_user->Password;
                $new_password = base64_decode($random_password);
            }
            echo "<b>Username:</b> $username <b>Password:</b> $new_password";			
            echo "<br/>";
            $this->db->order_by('Employee_Id', 'desc');
            $this->db->limit(1);                       
            $q_emp = $this->db->get('tbl_employee');
            foreach ($q_emp->result() as $row_empname) {
                $emp_firstname = $row_empname->Emp_FirstName;
                $emp_middlename = $row_empname->Emp_MiddleName;
                $emp_lastname = $row_empname->Emp_LastName;                
            }
            echo "<b>Employee Name:</b>  <b>$emp_firstname $emp_middlename $emp_lastname</b>"; 
        }
    }

    function edit_background_verification() {

        $employee_id = $this->input->post('employee_id');
        $background_verification = $this->input->post('background_verification');

        $sess_data = $this->session->all_userdata();
        $inserted_id = $sess_data['user_id'];

        $update_data = array(
            'BG_Verify' => $background_verification,
            'Modified_By' => $inserted_id,
            'Modified_Date' => date('Y-m-d H:i:s')
        );
        $this->db->where('Employee_Id', $employee_id);
        $q = $this->db->update('tbl_employee_bgverify', $update_data);
        if ($q) {
            echo "success";
        }
    }

    function reference_details() {
        $this->form_validation->set_rules('prev_cmpref_fullname', '', 'trim|required');
        $this->form_validation->set_rules('prev_cmpref_name', '', 'trim|required');
        $this->form_validation->set_rules('prev_cmpref_designation', '', 'trim|required');
       // $this->form_validation->set_rules('prev_cmpref_email', '', 'trim|required');
        $this->form_validation->set_rules('prev_cmpref_mobile', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $prev_cmpref_fullname = $this->input->post('prev_cmpref_fullname');
            $prev_cmpref_name = $this->input->post('prev_cmpref_name');
            $prev_cmpref_designation = $this->input->post('prev_cmpref_designation');
            $prev_cmpref_email = $this->input->post('prev_cmpref_email');
            $prev_cmpref_mobile = $this->input->post('prev_cmpref_mobile');
            $prev_cmpref_telephone = $this->input->post('prev_cmpref_telephone');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Privious_Comp_FullName' => $prev_cmpref_fullname,
                'Privious_Comp_Name' => $prev_cmpref_name,
                'Privious_Comp_Designation' => $prev_cmpref_designation,
                'Privious_Comp_Email' => $prev_cmpref_email,
                'Privious_Comp_Mobile' => $prev_cmpref_mobile,
                'Privious_Comp_Telephone' => $prev_cmpref_telephone,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_referencedetails', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //   $this->load->view('error');
        }
    }

    public function Editreference() {
        $resherref_id = $this->input->post('ref_id');
        $data = array(
            'ref_id' => $resherref_id
        );
        $this->load->view('employee/reference/edit_ref_exp', $data);
    }

    function edit_ref_details() {
        $this->form_validation->set_rules('edit_prev_cmpref_fullname', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_cmpref_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_cmpref_designation', '', 'trim|required');
        //$this->form_validation->set_rules('edit_prev_cmpref_email', '', 'trim|required');
        $this->form_validation->set_rules('edit_prev_cmpref_mobile', '', 'trim|required');
        //  $this->form_validation->set_rules('edit_prev_cmpref_telephone', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $ref_id = $this->input->post('edit_ref_id');
            $edit_prev_cmpref_fullname = $this->input->post('edit_prev_cmpref_fullname');
            $edit_prev_cmpref_name = $this->input->post('edit_prev_cmpref_name');
            $edit_prev_cmpref_designation = $this->input->post('edit_prev_cmpref_designation');
            $edit_prev_cmpref_email = $this->input->post('edit_prev_cmpref_email');
            $edit_prev_cmpref_mobile = $this->input->post('edit_prev_cmpref_mobile');
            $edit_prev_cmpref_telephone = $this->input->post('edit_prev_cmpref_telephone');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Privious_Comp_FullName' => $edit_prev_cmpref_fullname,
                'Privious_Comp_Name' => $edit_prev_cmpref_name,
                'Privious_Comp_Designation' => $edit_prev_cmpref_designation,
                'Privious_Comp_Email' => $edit_prev_cmpref_email,
                'Privious_Comp_Mobile' => $edit_prev_cmpref_mobile,
                'Privious_Comp_Telephone' => $edit_prev_cmpref_telephone,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Ref_Id', $ref_id);
            $q = $this->db->update('tbl_employee_referencedetails', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deletereference() {
        $resherref_id = $this->input->post('ref_id');
        $data = array(
            'ref_id' => $resherref_id
        );
        $this->load->view('employee/reference/delete_ref_exp', $data);
    }

    function delete_ref_details() {
        $this->form_validation->set_rules('delete_ref_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $ref_id = $this->input->post('delete_ref_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Ref_Id', $ref_id);
            $q = $this->db->update('tbl_employee_referencedetails', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    function fresherref_details() {
        $this->form_validation->set_rules('reference_person_name', '', 'trim|required');
        $this->form_validation->set_rules('reference_person_relation', '', 'trim|required');
        $this->form_validation->set_rules('reference_person_occupation', '', 'trim|required');
        $this->form_validation->set_rules('reference_person_mobile', '', 'trim|required');
        //$this->form_validation->set_rules('reference_person_email', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $reference_person_name = $this->input->post('reference_person_name');
            $reference_person_relation = $this->input->post('reference_person_relation');
            $reference_person_occupation = $this->input->post('reference_person_occupation');
            $reference_person_mobile = $this->input->post('reference_person_mobile');
            $reference_person_email = $this->input->post('reference_person_email');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Name' => $reference_person_name,
                'Relationship' => $reference_person_relation,
                'Occupation' => $reference_person_occupation,
                'Mobile_Number' => $reference_person_mobile,
                'Email_Id' => $reference_person_email,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_fresherref', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //   $this->load->view('error');
        }
    }

    public function Editfresherref() {
        $resherref_id = $this->input->post('resherref_id');
        $data = array(
            'resherref_id' => $resherref_id
        );
        $this->load->view('employee/reference/edit_fresherref', $data);
    }

    function edit_fresherref_details() {
        $this->form_validation->set_rules('edit_reference_person_name', '', 'trim|required');
        $this->form_validation->set_rules('edit_reference_person_relation', '', 'trim|required');
        $this->form_validation->set_rules('edit_reference_person_occupation', '', 'trim|required');
        $this->form_validation->set_rules('edit_reference_person_mobile', '', 'trim|required');
      //  $this->form_validation->set_rules('edit_reference_person_email', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $ref_id = $this->input->post('edit_fresherref_id');
            $edit_reference_person_name = $this->input->post('edit_reference_person_name');
            $edit_reference_person_relation = $this->input->post('edit_reference_person_relation');
            $edit_reference_person_occupation = $this->input->post('edit_reference_person_occupation');
            $edit_reference_person_mobile = $this->input->post('edit_reference_person_mobile');
            $edit_reference_person_email = $this->input->post('edit_reference_person_email');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Name' => $edit_reference_person_name,
                'Relationship' => $edit_reference_person_relation,
                'Occupation' => $edit_reference_person_occupation,
                'Mobile_Number' => $edit_reference_person_mobile,
                'Email_Id' => $edit_reference_person_email,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Fresher_RefId', $ref_id);
            $q = $this->db->update('tbl_employee_fresherref', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Deletefresherref() {
        $resherref_id = $this->input->post('resherref_id');
        $data = array(
            'resherref_id' => $resherref_id
        );
        $this->load->view('employee/reference/delete_fresherref', $data);
    }

    function delete_fresherref_details() {
        $this->form_validation->set_rules('delete_fresherref_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $ref_id = $this->input->post('delete_fresherref_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s'),
                'Status' => 0
            );
            $this->db->where('Fresher_RefId', $ref_id);
            $q = $this->db->update('tbl_employee_fresherref', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Background Verfication End Here */

    /* Add Employee Details End Here */


    /* Edit Employee Details Start Here */

    public function Editemployee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 3) {
            $data = array(
                'title' => 'Edit Employee',
                'main_content' => 'employee/edit_employee'
            );
            $this->load->view('common/content', $data);
        } if ($user_role == 2 || $user_role == 1 || $user_role == 6 || $user_role == 4 || $user_role == 5 || $user_role == 7) {
            if ($emp_no = $this->uri->segment(3) != "") {
                $data = array(
                    'title' => 'Edit Employee',
                    'main_content' => 'employee/edit_employee'
                );
                $this->load->view('operation/content', $data);
            } else {
                $data = array(
                    'title' => 'Edit Employee',
                    'main_content' => 'employee/edit_employee'
                );
                $this->load->view('common/content', $data);
            }
        }
    }

    /* Basic Information Start Here */

    /* Basic Information Start Here */

    function edit_basicInfo() {
        $this->form_validation->set_rules('first_name', 'Frist Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Date of Birth', 'trim|required');
      
        $this->form_validation->set_rules('branch_name', 'Branch', 'trim|required');
        $this->form_validation->set_rules('department_name', 'Department', 'trim|required');
        $this->form_validation->set_rules('client_name', 'Client', 'trim|required');
        $this->form_validation->set_rules('subprocess', 'Sub Process', 'trim|required');
        $this->form_validation->set_rules('designation_name', 'Designation', 'trim|required');
        $this->form_validation->set_rules('department_role', 'Department Role', 'trim|required');
        $this->form_validation->set_rules('grade', 'Grade', 'trim|required');
        $this->form_validation->set_rules('reporting_to', 'Reporting To', 'trim|required');
        $this->form_validation->set_rules('joining_date', 'Join Date', 'trim|required');
        $this->form_validation->set_rules('confirmation_period', 'Confirmation Period', 'trim|required');
        $this->form_validation->set_rules('confirmation_date', 'Confirmation Date', 'trim|required');

        $confirmation_period = $this->input->post('confirmation_period');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $employee_code = $this->input->post('employee_code');
            $first_name = $this->input->post('first_name');
            $middle_name = $this->input->post('middle_name');
            $last_name = $this->input->post('last_name');
            $gender = $this->input->post('gender');

            $birthdate = $this->input->post('birthdate');
            $dob = date("Y-m-d", strtotime($birthdate));

            $actual_birthdate = $this->input->post('actual_birthdate');
            if ($actual_birthdate != "") {
                $actual_dob = date("Y-m-d", strtotime($actual_birthdate));
            } else {
                $actual_dob = $dob;
            }

            $blood_group = $this->input->post('blood_group');
            $mobile_number = $this->input->post('mobile_number');
            $alternate_number = $this->input->post('alternate_number');
            $official_email_address = $this->input->post('official_email_address');

            $bank_name = $this->input->post('bank_name');
            $acc_no = $this->input->post('acc_no');
            $ifsc_code = $this->input->post('ifsc_code');
            $pan_no = $this->input->post('pan_no');
            $uan_no = $this->input->post('uan_no');
            $pf_no = $this->input->post('pf_no');
            $esi = $this->input->post('esi');
            $medical_insurance = $this->input->post('medical_insurance');

            $branch = $this->input->post('branch_name');
            $department = $this->input->post('department_name');
            $client = $this->input->post('client_name');
            $designation_name = $this->input->post('designation_name');
            $reporting_to = $this->input->post('reporting_to');

            $joining_date = $this->input->post('joining_date');
            $doj = date("Y-m-d", strtotime($joining_date));

            $confirmation_period = $this->input->post('confirmation_period');

            $confirmation_date = $this->input->post('confirmation_date');
            $doc = date("Y-m-d", strtotime($confirmation_date));

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data1 = array(
                'Emp_FirstName' => $first_name,
                'Emp_MiddleName' => $middle_name,
                'Emp_LastName' => $last_name,
                'Emp_Dob' => $dob,
                'Emp_ActuallDob' => $actual_dob,
                'Emp_Gender' => $gender,
                'Emp_Bldgroup' => $blood_group,
                'Emp_Doj' => $doj,
                'Emp_Confirmationperiod' => $confirmation_period,
                'Emp_Confirmationdate' => $doc,
                'Emp_Contact' => $mobile_number,
                'Emp_AlternateContact' => $alternate_number,
                'Emp_Officialemail' => $official_email_address,
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Emp_Number', $employee_id);
            $this->db->update('tbl_employee', $update_data1);

            $update_data2 = array(
                'Emp_Bankname' => $bank_name,
                'Emp_Accno' => $acc_no,
                'Emp_IFSCcode' => $ifsc_code,
                'Emp_PANcard' => $pan_no,
                'Emp_UANno' => $uan_no,
                'Emp_PFno' => $pf_no,
                'Emp_ESI' => $esi,
                'Emp_Medicalinsurance' => $medical_insurance
            );
            $this->db->where('Employee_Id', $employee_id);
            $this->db->update('tbl_employee_bankdetails', $update_data2);

            $insert_data4 = array(
                'Branch_Id' => $branch,
                'Department_Id' => $department,
                'Client_Id' => $client,
                'Designation_Id' => $designation_name,
                'Reporting_To' => $reporting_to,
                'From' => $doj,
                'Modified_By' => $inserted_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('Employee_Id', $employee_id);
            $q = $this->db->update('tbl_employee_career', $insert_data4);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Basic Information End Here */

    /* Personal Information End Here */

    function edit_personalInfo() {
        $this->form_validation->set_rules('nationality', '', 'trim|required');
        $this->form_validation->set_rules('religion', '', 'trim|required');
        $this->form_validation->set_rules('caste', '', 'trim|required');
        $this->form_validation->set_rules('mother_tongue', '', 'trim|required');
        $this->form_validation->set_rules('personal_blood_group', '', 'trim|required');
        $this->form_validation->set_rules('personal_birthdate', '', 'trim|required');
        $this->form_validation->set_rules('marital_status', '', 'trim|required');
        $this->form_validation->set_rules('mobile_number', '', 'trim|required|numeric');
        $this->form_validation->set_rules('personal_email_address', '', 'trim|required|valid_email');

        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');
            $nationality = $this->input->post('nationality');
            $religion = $this->input->post('religion');
            $caste = $this->input->post('caste');
            $mother_tongue = $this->input->post('mother_tongue');

            $personal_blood_group = $this->input->post('personal_blood_group');
            $personal_birthdate = $this->input->post('personal_birthdate');
            $dob = date("Y-m-d", strtotime($personal_birthdate));
            $personal_actual_birthdate = $this->input->post('personal_actual_birthdate');
            $actual_dob = date("Y-m-d", strtotime($personal_actual_birthdate));

            $marital_status = $this->input->post('marital_status');
            $mobile_number = $this->input->post('mobile_number');
            $alternate_number = $this->input->post('alternate_number');
            $personal_email_address = $this->input->post('personal_email_address');
            $permanent_address = $this->input->post('permanent_address');
            $temporary_address = $this->input->post('temporary_address');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $update_data1 = array(
                'Emp_Contact' => $mobile_number,
                'Emp_AlternateContact' => $alternate_number,
                'Emp_Dob' => $dob,
                'Emp_ActuallDob' => $actual_dob,
                'Emp_Bldgroup' => $personal_blood_group
            );
            $this->db->where('Emp_Number', $employee_id);
            $this->db->update('tbl_employee', $update_data1);

            $this->db->where('Employee_Id', $employee_id);
            $q_personal = $this->db->get('tbl_employee_personal');
            $count_personal = $q_personal->num_rows();
            if ($count_personal == 1) {
                $update_data2 = array(
                    'Emp_Nationality' => $nationality,
                    'Emp_Religion' => $religion,
                    'Emp_Caste' => $caste,
                    'Emp_Mother_Tongue' => $mother_tongue,
                    'Emp_Marrial' => $marital_status,
                    'Emp_PersonalEmail' => $personal_email_address,
                    'Emp_Permanent' => $permanent_address,
                    'Emp_Temporary' => $temporary_address,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Employee_Id', $employee_id);
                $q = $this->db->update('tbl_employee_personal', $update_data2);
            } else {
                $insert_data2 = array(
                    'Employee_Id' => $employee_id,
                    'Emp_Nationality' => $nationality,
                    'Emp_Religion' => $religion,
                    'Emp_Caste' => $caste,
                    'Emp_Mother_Tongue' => $mother_tongue,
                    'Emp_Marrial' => $marital_status,
                    'Emp_PersonalEmail' => $personal_email_address,
                    'Emp_Permanent' => $permanent_address,
                    'Emp_Temporary' => $temporary_address,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $q = $this->db->insert('tbl_employee_personal', $insert_data2);
            }

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    /* Personal Information End Here */

    /* Additioanal Information Start Here */

    function edit_info_details() {
        $this->form_validation->set_rules('pancard_no', '', 'trim|required');
        $this->form_validation->set_rules('emergency_contactperson_name', '', 'trim|required');
        $this->form_validation->set_rules('emergency_contact_no', '', 'trim|required');


        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('employee_id');

            $pan_no = $this->input->post('pancard_no');
            $aadhar_no = $this->input->post('aadhar_no');
            $passport_no = $this->input->post('passport_no');
            $name_on_passport = $this->input->post('name_on_passport');
            $place_issue = $this->input->post('place_issue');
            $issue_date1 = $this->input->post('issue_date');
            if ($issue_date1 != "") {
                $issue_date = date("Y-m-d", strtotime($issue_date1));
            } else {
                $issue_date = "";
            }

            $expiry_date1 = $this->input->post('expiry_date');
            if ($expiry_date1 != "") {
                $expiry_date = date("Y-m-d", strtotime($expiry_date1));
            } else {
                $expiry_date = "";
            }

            $valid_visa = $this->input->post('valid_visa');
            $issue_country = $this->input->post('issue_country');

            $hobbies = $this->input->post('hobbies');
            $interest = $this->input->post('interest');
            $related_employee = $this->input->post('related_employee');
            $related_employee_name = $this->input->post('related_employee_name');
            //  $membership = $this->input->post('membership');
            //   $other = $this->input->post('other');
            $voter_id = $this->input->post('voter_id');

            $allergic = $this->input->post('allergic');
            $blood_pressure = $this->input->post('blood_pressure');
            $differently_abled = $this->input->post('differently_abled');
            $weight = $this->input->post('weight');
            $height = $this->input->post('height');
            $eye_sight = $this->input->post('eye_sight');
            $illness = $this->input->post('illness');
            $emergency_contactperson_name = $this->input->post('emergency_contactperson_name');
            $emergency_contact_no = $this->input->post('emergency_contact_no');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Emp_PANcard' => $pan_no,
            );
            $this->db->where('Employee_Id', $employee_id);
            $this->db->update('tbl_employee_bankdetails', $update_data);

            $this->db->where('Employee_ID', $employee_id);
            $q_info = $this->db->get('tbl_employee_additionalinformation');
            $count_info = $q_info->num_rows();
            if ($count_info == 1) {
                $update_data1 = array(
                    'Emp_Aadharcard' => $aadhar_no,
                    'Emp_Passportno' => $passport_no,
                    'Emp_Passportname' => $name_on_passport,
                    'Issue_Place' => $place_issue,
                    'Issue_Date' => $issue_date,
                    'Expiry_Date' => $expiry_date,
                    'Valid_visa' => $valid_visa,
                    'Issue_Country' => $issue_country,
                    'Hobbies' => $hobbies,
                    'Intresets' => $interest,
                    'Related_Employee' => $related_employee,
                    'Employee_Name' => $related_employee_name,
                    //  'Membership' => $membership,
                    //  'Suggesation' => $other,
                    "Voter_Id" => $voter_id,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Employee_ID', $employee_id);
                $this->db->update('tbl_employee_additionalinformation', $update_data1);
            } else {
                $insert_data1 = array(
                    'Employee_ID' => $employee_id,
                    'Emp_Pancard' => $pan_no,
                    'Emp_Aadharcard' => $aadhar_no,
                    'Emp_Passportno' => $passport_no,
                    'Emp_Passportname' => $name_on_passport,
                    'Issue_Place' => $place_issue,
                    'Issue_Date' => $issue_date,
                    'Expiry_Date' => $expiry_date,
                    'Valid_visa' => $valid_visa,
                    'Issue_Country' => $issue_country,
                    'Hobbies' => $hobbies,
                    'Intresets' => $interest,
                    'Related_Employee' => $related_employee,
                    'Employee_Name' => $related_employee_name,
                    //  'Membership' => $membership,
                    //  'Suggesation' => $other,
                    "Voter_Id" => $voter_id,
                    'Inserted_By' => $modified_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_additionalinformation', $insert_data1);
            }
            $this->db->where('Employee_Id', $employee_id);
            $q_emer = $this->db->get('tbl_employee_emergency_details');
            $count_emer = $q_emer->num_rows();
            if ($count_emer == 1) {
                $update_data2 = array(
                    'Alergic' => $allergic,
                    'BloodPressure' => $blood_pressure,
                    'Weight' => $weight,
                    'Differently_abled' => $differently_abled,
                    'Height' => $height,
                    'Eye_Sight' => $eye_sight,
                    'Major_Illeness' => $illness,
                    'Contact_Person' => $emergency_contactperson_name,
                    'Mobileno' => $emergency_contact_no,
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );
                $this->db->where('Employee_Id', $employee_id);
                $q = $this->db->update('tbl_employee_emergency_details', $update_data2);
            } else {
                $insert_data2 = array(
                    'Employee_Id' => $employee_id,
                    'Alergic' => $allergic,
                    'BloodPressure' => $blood_pressure,
                    'Differently_abled' => $differently_abled,
                    'Weight' => $weight,
                    'Height' => $height,
                    'Eye_Sight' => $eye_sight,
                    'Major_Illeness' => $illness,
                    'Contact_Person' => $emergency_contactperson_name,
                    'Mobileno' => $emergency_contact_no,
                    'Inserted_By' => $modified_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_employee_emergency_details', $insert_data2);
            }
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    /* Edit Additioanal Information End Here */

    /* Aknowledgement Information Start Here */

    function aknowledgement_details() {
        $this->form_validation->set_rules('condition_agree', '', 'trim|required');
        $this->form_validation->set_rules('employee_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $condition_agree = $this->input->post('condition_agree');
            $employee_id = $this->input->post('employee_id');
            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Acknowledgement' => $condition_agree,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s')
            );
            $q = $this->db->insert('tbl_employee_acknowledgment', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //$this->load->view('error');
        }
    }

    /* Aknowledgement Details End Here */

    /* Edit Employee Details End Here */

    /* Delete Employee Details End Here */

    public function Deleteemployee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 6) {
            $emp_id = $this->input->post('emp_id');
            $data = array(
                'emp_id' => $emp_id
            );
            $this->load->view('employee/delete_employee', $data);
        } else {
            redirect('Profile');
        }
    }

    public function delete_employee() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 6) {
            $emp_id = $this->input->post('delete_employee_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Employee_Id', $emp_id);
            $this->db->update('tbl_employee', $update_data);

            $this->db->where('Employee_Id', $emp_id);
            $q_emp = $this->db->get('tbl_employee');
            foreach ($q_emp->result() as $row_emp) {
                $emp_no = $row_emp->Emp_Number;
            }
            $this->db->where('Employee_Id', $emp_no);
            $q = $this->db->update('tbl_user', $update_data);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Delete Employee Details End Here */

    /* Import Employee Start Here */

    function import_employee() {
        $filename = $_FILES["import_file"]["tmp_name"];
        if ($_FILES["import_file"]["size"] > 0) {

            $file = fopen($filename, "r");

            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $q_empcode = $this->db->get('tbl_emp_code');
            foreach ($q_empcode->result() as $row_empcode) {
                $employee_code = $row_empcode->employee_code;
                $start_number = $row_empcode->employee_number;
            }

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];



            $n = 1;
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $employee_id = str_pad(($start_number + $n), 4, '0', STR_PAD_LEFT);

                $insert_data1 = array(
                    'employee_code' => $employee_code,
                    'employee_number' => $employee_id,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_emp_code', $insert_data1);

                $doj = $emapData[5];
                $confirmation_date = date("Y-m-d", strtotime("$doj +91 day"));

                $insert_data2 = array(
                    'Emp_Number' => $employee_id,
                    'Emp_FirstName' => $emapData[0],
                    'Emp_MiddleName' => $emapData[1],
                    'Emp_LastName' => $emapData[2],
                    'Emp_Dob' => $emapData[3],
                    'Emp_ActuallDob' => $emapData[3],
                    'Emp_Gender' => $emapData[4],
                    'Emp_Doj' => $emapData[5],
                    'Emp_Confirmationperiod' => 3,
                    'Emp_Confirmationdate' => $confirmation_date,
                    'Emp_Contact' => $emapData[6],
                    'Emp_AlternateContact' => $emapData[7],
                    'Emp_Officialemail' => $emapData[8],
                    'Emp_Bldgroup' => $emapData[9],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee', $insert_data2);

                $insert_data3 = array(
                    'Employee_Id' => $employee_id,
                    'Emp_Bankname' => $emapData[10],
                    'Emp_Accno' => $emapData[11],
                    'Emp_IFSCcode' => $emapData[12],
                    'Emp_PANcard' => $emapData[13],
                    'Emp_UANno' => $emapData[14],
                    'Emp_PFno' => $emapData[15],
                    'Emp_ESI' => $emapData[16],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_bankdetails', $insert_data3);

                $insert_data4 = array(
                    'Employee_Id' => $employee_id,
                    'Branch_Id' => $emapData[17],
                    'Department_Id' => $emapData[18],
                    'Client_Id' => $emapData[19],
                    'Designation_Id' => $emapData[20],
                    'Reporting_To' => 0001,
                    'From' => $emapData[5],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_career', $insert_data4);

                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $string = '';
                for ($i = 0; $i < 10; $i++) {
                    $string .= $characters[rand(0, strlen($characters) - 1)];
                }
                $random_password = base64_encode($string);

                $insert_data5 = array(
                    'User_RoleId' => 3,
                    'Employee_Id' => $employee_id,
                    'Username' => $employee_code . $employee_id,
                    'Password' => $random_password,
                    'Password_Updated' => "No",
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_user', $insert_data5);

                $insert_data6 = array(
                    'Employee_Id' => $employee_id,
                    'Emp_Marrial' => $emapData[21],
                    'Emp_PersonalEmail' => $emapData[22],
                    'Emp_Permanent' => $emapData[23],
                    'Emp_Temporary' => $emapData[24],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_personal', $insert_data6);
                $insert_data7 = array(
                    'Employee_Id' => $employee_id,
                    'Mobileno' => $emapData[25],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_emergency_details', $insert_data7);

                $insert_data8 = array(
                    'Employee_Id' => $employee_id,
                    'BG_Verify' => 'Yes',
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_employee_bgverify', $insert_data8);

                $insert_data9 = array(
                    'Employee_ID' => $employee_id,
                    'Valid_visa' => 'No',
                    'Related_Employee' => 'No',
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_additionalinformation', $insert_data9);

                $n++;
            }
            echo "success";
            // fclose($file);
        }
    }

	function import_accountinfo() {
        $filename = $_FILES["import_accountinfofile"]["tmp_name"];
        if ($_FILES["import_accountinfofile"]["size"] > 0) {
            $file = fopen($filename, "r");
            $n = 1;
            while (($accountData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($n != 1) {
                    $empcode = $accountData[1];
                    $employee_id = str_replace('DRN/', '', $empcode);
                    $data_account = array(
                        'Employee_Id' => $employee_id,
                        'Status' => 1
                    );
                    $this->db->where($data_account);
                    $q_account = $this->db->get('tbl_employee_bankdetails');
                    $count_account = $q_account->num_rows();
                    $sess_data = $this->session->all_userdata();
                    $inserted_id = $sess_data['user_id'];
                    if ($count_account == 1) {
                        foreach ($q_account->Result() as $row_account) {
                            $account_id = $row_account->E_Id;
                            $update_data = array(
                                'Emp_Bankname' => $accountData[2],
                                'Emp_Accno' => $accountData[3],
                                'Emp_IFSCcode' => $accountData[4],
                                'Modified_By' => $inserted_id,
                                'Modified_Date' => date('Y-m-d H:i:s')
                            );
                            $this->db->where('E_Id', $account_id);
                            $this->db->update('tbl_employee_bankdetails', $update_data);
                        }
                    }
                }
                $n++;
            }
            echo "success";
        }
    }
	
    function import_employee_old() {
        $filename = $_FILES["import_file"]["tmp_name"];
        if ($_FILES["import_file"]["size"] > 0) {

            $file = fopen($filename, "r");

            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $q_empcode = $this->db->get('tbl_emp_code');
            foreach ($q_empcode->result() as $row_empcode) {
                $employee_code = $row_empcode->employee_code;
                $start_number = $row_empcode->employee_number;
            }

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];



            $n = 1;
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

                //   $employee_id = str_pad(($start_number + $n), 4, '0', STR_PAD_LEFT);

                $emp_id = $emapData[26];
                $search = 'DRN/';
                $employee_id = str_replace($search, '', $emp_id);

                $insert_data1 = array(
                    'employee_code' => $employee_code,
                    'employee_number' => $employee_id,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_emp_code', $insert_data1);

                $doj = $emapData[5];
                $confirmation_date = date("Y-m-d", strtotime("$doj +91 day"));

                $insert_data2 = array(
                    'Emp_Number' => $employee_id,
                    'Emp_FirstName' => $emapData[0],
                    'Emp_MiddleName' => $emapData[1],
                    'Emp_LastName' => $emapData[2],
                    'Emp_Dob' => $emapData[3],
                    'Emp_ActuallDob' => $emapData[3],
                    'Emp_Gender' => $emapData[4],
                    'Emp_Doj' => $emapData[5],
                    'Emp_Confirmationperiod' => 3,
                    'Emp_Confirmationdate' => $confirmation_date,
                    'Emp_Contact' => $emapData[6],
                    'Emp_AlternateContact' => $emapData[7],
                    'Emp_Officialemail' => $emapData[8],
                    'Emp_Bldgroup' => $emapData[9],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee', $insert_data2);

                $insert_data3 = array(
                    'Employee_Id' => $employee_id,
                    'Emp_Bankname' => $emapData[10],
                    'Emp_Accno' => $emapData[11],
                    'Emp_IFSCcode' => $emapData[12],
                    'Emp_PANcard' => $emapData[13],
                    'Emp_UANno' => $emapData[14],
                    'Emp_PFno' => $emapData[15],
                    'Emp_ESI' => $emapData[16],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_bankdetails', $insert_data3);

                $insert_data4 = array(
                    'Employee_Id' => $employee_id,
                    'Branch_Id' => $emapData[17],
                    'Department_Id' => $emapData[18],
                    'Client_Id' => $emapData[19],
                    'Designation_Id' => $emapData[20],
                    'Reporting_To' => 0001,
                    'From' => $emapData[5],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_career', $insert_data4);

                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $string = '';
                for ($i = 0; $i < 10; $i++) {
                    $string .= $characters[rand(0, strlen($characters) - 1)];
                }
                $random_password = base64_encode($string);

                $insert_data5 = array(
                    'User_RoleId' => 3,
                    'Employee_Id' => $employee_id,
                    'Username' => $emapData[26],
                    'Password' => $random_password,
                    'Password_Updated' => "No",
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_user', $insert_data5);

                $insert_data6 = array(
                    'Employee_Id' => $employee_id,
                    'Emp_Marrial' => $emapData[21],
                    'Emp_PersonalEmail' => $emapData[22],
                    'Emp_Permanent' => $emapData[23],
                    'Emp_Temporary' => $emapData[24],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_personal', $insert_data6);
                $insert_data7 = array(
                    'Employee_Id' => $employee_id,
                    'Mobileno' => $emapData[25],
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->insert('tbl_employee_emergency_details', $insert_data7);

                $insert_data8 = array(
                    'Employee_Id' => $employee_id,
                    'BG_Verify' => 'Yes',
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_employee_bgverify', $insert_data8);

                $n++;
            }
            echo "success";
            // fclose($file);
        }
    }

    /* Import Employee End Here */

    /* Export Specific Employee Start Here */

    function export_employee() {
        $contents = "Employee Id,";
        $contents .= "Password,";
        $contents .= "Name,";
        $contents .="\n";

        $export_data = array(
            'Password_Updated' => "No",
            'Status' => 1
        );
        $this->db->where($export_data);
        $sql_export = $this->db->get('tbl_user');


        foreach ($sql_export->result() as $row_export) {
            $emp_id = $row_export->Employee_Id;
            $emp_username = $row_export->Username;
            $emp_password = $row_export->Password;

            $employee_id = str_pad(($emp_id), 4, '0', STR_PAD_LEFT);

            $emp_data = array(
                'Emp_Number' => $employee_id,
                'Status' => 1
            );
            $this->db->where($emp_data);
            $sql_emp = $this->db->get('tbl_employee');
            foreach ($sql_emp->result() as $row_emp) {
                $emp_name = $row_emp->Emp_FirstName;
            }
            $password = base64_decode($emp_password);
            $contents.= $emp_username . ",";
            $contents.=$password . ",";
            $contents.=$emp_name . "\n";
        }

        $filename = "employee.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        print $contents;
    }

    /* Export Specific Employee End Here */

    /* Export All Employee Start Here */

    function export_allemployee() {
        $contents = "Employee Id,";
        $contents .= "Employee Name,";
        $contents .= "DOJ,";
		$contents .= "Date Of Birth,";
        $contents .= "Actual DOB,";
		$contents .= "Blood Group,";
        $contents .= "Contact Number,";
        $contents .= "Emergency Contact No,";
		 $contents .= "Religion,";
        $contents .= "Caste,";
        $contents .= "Mother Tongue,";
        $contents .= "Marital Status,";
        $contents .= "Department,";
        $contents .= "Client,";
        $contents .= "Sub Process,";
        $contents .= "Designation,";
        $contents .= "Reporting Manager,";
		$contents .= "Aadhar Card,";
		$contents .= "PAN Card,";
        $contents .= "Bank Name,";
        $contents .= "Account Number,";
        $contents .= "IFSC Code,";
        $contents .= "UAN Number,";
        $contents .= "PF Number,";
        $contents .= "ESI,";
        $contents .= "Medical Insurance,";
		$contents .= "Father Name,";
        $contents .= "Mother Name,";
		$contents .= "Personal Data Updated,";
        $contents .="\n";

        $emp_data = array(
            'Status' => 1
        );
        $this->db->where($emp_data);
        $sql_emp = $this->db->get('tbl_employee');
        foreach ($sql_emp->result() as $row_emp) {
            $emp_id = $row_emp->Emp_Number;
            $employee_id = str_pad(($emp_id), 4, '0', STR_PAD_LEFT);
            $emp_firstname = $row_emp->Emp_FirstName;
            $emp_middlename = $row_emp->Emp_MiddleName;
            $emp_lastname = $row_emp->Emp_LastName;
            $emp_name = $emp_firstname . " " . $emp_lastname . " " . $emp_middlename;

            $emp_doj = $row_emp->Emp_Doj;
           $doj = date("d-M-y", strtotime($emp_doj));
		   $emp_dob = $row_emp->Emp_Dob;
            $dob = date("d-M-y", strtotime($emp_dob));
            $Emp_ActuallDob = $row_emp->Emp_ActuallDob;
            $Emp_ActualDob = date("d-M-y", strtotime($Emp_ActuallDob));
			$Emp_Bldgroup = $row_emp->Emp_Bldgroup;
            $Emp_Contact = $row_emp->Emp_Contact;
			
            $data_career = array(
                'Employee_Id' => $employee_id,
                'Status' => 1
            );
            $this->db->order_by('Career_Id', 'desc');
            $this->db->limit(1);
            $this->db->where($data_career);
            $q_career = $this->db->get('tbl_employee_career');
            foreach ($q_career->result() as $row_career) {
                $department_id = $row_career->Department_Id;
                $designation_id = $row_career->Designation_Id;
                $report_to_id = $row_career->Reporting_To;
                $this->db->where('Designation_Id', $designation_id);
                $q_designation = $this->db->get('tbl_designation');
                foreach ($q_designation->result() as $row_designation) {
                    $designation_name = $row_designation->Designation_Name;
                    $subdepartment_id = $row_designation->Client_Id;

                    $this->db->where('Subdepartment_Id', $subdepartment_id);
                    $q_subdept = $this->db->get('tbl_subdepartment');
                    foreach ($q_subdept->result() as $row_subdept) {
                        $subdepartment_name = $row_subdept->Subdepartment_Name;
                        $client_name = $row_subdept->Client_Name;
                    }
                }
                $this->db->where('Department_Id', $department_id);
                $q_dept = $this->db->get('tbl_department');
                foreach ($q_dept->result() as $row_dept) {
                    $department_name = $row_dept->Department_Name;
                }

                $this->db->where('Emp_Number', $report_to_id);
                $q_emp = $this->db->get('tbl_employee');
                foreach ($q_emp->result() as $row_emp) {
                    $reporting_name = $row_emp->Emp_FirstName;
					$reporting_name .= " " . $row_emp->Emp_LastName;
                    $reporting_name .= " " . $row_emp->Emp_MiddleName;
                }
                $export_data = array(
                    'Employee_Id' => $employee_id,
                    'Status' => 1
                );
                $this->db->where($export_data);
                $sql_export = $this->db->get('tbl_user');
                foreach ($sql_export->result() as $row_export) {
                    $emp_username = $row_export->Username;
                }
				$this->db->group_by('Employee_Id');
                $this->db->where('Employee_Id', $employee_id);
                $q_ack = $this->db->get('tbl_employee_acknowledgment');
                $count_Ack = $q_ack->num_rows();
                if ($count_Ack > 0) {
                    foreach ($q_ack->Result() as $row_ack) {
                        $ack_status = $row_ack->Acknowledgement;
                    }
                } else {
                    $ack_status = "No";
                }
            }
			$this->db->where('Employee_Id', $employee_id);
            $q_bank = $this->db->get('tbl_employee_bankdetails');
            $count_bank = $q_bank->num_rows();
            if ($count_bank > 0) {
                foreach ($q_bank->Result() as $row_bank) {
                    $Emp_Bankname = $row_bank->Emp_Bankname;
                    $Emp_Accno = $row_bank->Emp_Accno;
                    $Emp_IFSCcode = $row_bank->Emp_IFSCcode;
                    $Emp_PANcard = $row_bank->Emp_PANcard;
                    $Emp_UANno = $row_bank->Emp_UANno;
                    $Emp_PFno = $row_bank->Emp_PFno;
                    $Emp_ESI = $row_bank->Emp_ESI;
                    $Emp_Medicalinsurance = $row_bank->Emp_Medicalinsurance;
                }
            }
            $this->db->where('Employee_Id', $employee_id);
            $q_add = $this->db->get('tbl_employee_additionalinformation');
            $count_add = $q_add->num_rows();
            if ($count_add > 0) {
                foreach ($q_add->Result() as $row_add) {
                    $Emp_Aadharcard = $row_add->Emp_Aadharcard;
                }
            } else {
                $Emp_Aadharcard = "";
            }

            $this->db->where('Employee_Id', $employee_id);
            $q_emergency = $this->db->get('tbl_employee_emergency_details');
            $count_emergency = $q_emergency->num_rows();
            if ($count_emergency > 0) {
                foreach ($q_emergency->Result() as $row_emergency) {
                    $Emergency_Mobileno = $row_emergency->Mobileno;
                }
            } else {
                $Emergency_Mobileno = "";
            }
			
			 $this->db->where('Employee_Id', $employee_id);
            $q_personal = $this->db->get('tbl_employee_personal');
            $count_personal = $q_personal->num_rows();
            if ($count_personal > 0) {
                foreach ($q_personal->Result() as $row_personal) {
                    $Emp_Religion = $row_personal->Emp_Religion;
                    $Emp_Caste = $row_personal->Emp_Caste;
                    $Emp_Mother_Tongue = $row_personal->Emp_Mother_Tongue;
                    $Emp_Marrial = $row_personal->Emp_Marrial;
                }
            }
			
			 $family_data_mother = array(
                'Employee_Id' => $employee_id,
				'Relationship'=>'Mother',
                'Status' => 1
            );
            $this->db->where($family_data_mother);
            $q_family_mother = $this->db->get('tbl_employee_family');
            $count_family_mother = $q_family_mother->num_rows();
            if ($count_family_mother > 0) {
                foreach ($q_family_mother->result() as $row_family_mother) {
                    $mother_name = $row_family_mother->Name;
                }
            }else{
				$mother_name="";
			}
			
			$family_data_father = array(
                'Employee_Id' => $employee_id,
				'Relationship'=>'Father',
                'Status' => 1
            );
            $this->db->where($family_data_father);
            $q_family_father = $this->db->get('tbl_employee_family');
            $count_family_father = $q_family_father->num_rows();
            if ($count_family_father > 0) {
                foreach ($q_family_father->result() as $row_family_father) {
                    $father_name = $row_family_father->Name;
                }
            }else{
				$father_name="";
			}
			
            $contents.= $emp_username . ",";
            $contents.= $emp_name . ",";
            $contents.=$doj . ",";
			$contents.=$dob . ",";
            $contents.=$Emp_ActualDob . ",";
			$contents.=$Emp_Bldgroup . ",";
            $contents.=$Emp_Contact . ",";
            $contents.=$Emergency_Mobileno . ",";
			$contents.=$Emp_Religion . ",";
            $contents.=$Emp_Caste . ",";
            $contents.=$Emp_Mother_Tongue . ",";
            $contents.=$Emp_Marrial . ",";
            $contents.=$department_name . ",";
            $contents.=$client_name . ",";
            $contents.=$subdepartment_name . ",";
            $contents.=$designation_name . ",";
            $contents.=$reporting_name . ",";
			 $contents.=$Emp_Aadharcard . ",";
            $contents.=$Emp_PANcard . ",";
            $contents.=$Emp_Bankname . ",";
            $contents.="'" . $Emp_Accno . ",";
            $contents.=$Emp_IFSCcode . ",";
            $contents.=$Emp_UANno . ",";
            $contents.=$Emp_PFno . ",";
            $contents.=$Emp_ESI . ",";
            $contents.=$Emp_Medicalinsurance . ",";
			$contents.=$father_name . ",";
            $contents.=$mother_name . ",";
			$contents.=$ack_status . "\n";
        }

        $filename = "employee.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        print $contents;
    }

    /* Export All Employee End Here */

    /* Career History Start Here */

    public function Career() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Career',
                'main_content' => 'employee/career/career'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    public function add_career() {
        $this->form_validation->set_rules('add_career_branch', 'Branch', 'trim|required');
        $this->form_validation->set_rules('add_career_department', 'Department', 'trim|required');
        $this->form_validation->set_rules('add_career_client', 'Client', 'trim|required');
        $this->form_validation->set_rules('add_career_subprocess', 'Sub Process', 'trim|required');
        $this->form_validation->set_rules('add_career_designation', 'Designation', 'trim|required');
        $this->form_validation->set_rules('add_career_departmentrole', 'Department Role', 'trim|required');
        $this->form_validation->set_rules('add_career_grade', 'Grade', 'trim|required');
        $this->form_validation->set_rules('add_career_reporting_to', 'Reporting To', 'trim|required');
        $this->form_validation->set_rules('add_career_from', 'Join Date', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $employee_id = $this->input->post('add_career_emp_no');
            $branch = $this->input->post('add_career_branch');
            $department = $this->input->post('add_career_department');
            $client = $this->input->post('add_career_client');
            $designation_name = $this->input->post('add_career_designation');
            $reporting_to = $this->input->post('add_career_reporting_to');

            $joining_date = $this->input->post('add_career_from');
            if ($joining_date == "") {
                $doj = "";
            } else {
                $doj = date("Y-m-d", strtotime($joining_date));
            }

            $to_date = $this->input->post('add_career_to');
            if ($to_date == "") {
                $to = "";
            } else {
                $to = date("Y-m-d", strtotime($to_date));
            }

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];

            $insert_data = array(
                'Employee_Id' => $employee_id,
                'Branch_Id' => $branch,
                'Department_Id' => $department,
                'Client_Id' => $client,
                'Designation_Id' => $designation_name,
                'Reporting_To' => $reporting_to,
                'From' => $doj,
                'To' => $to,
                'Inserted_By' => $inserted_id,
                'Inserted_Date' => date('Y-m-d H:i:s'),
                'Status' => 1
            );
            $q = $this->db->insert('tbl_employee_career', $insert_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    public function Editcareer() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $career_id = $this->input->post('career_id');
            $data = array(
                'career_id' => $career_id
            );
            $this->load->view('employee/career/edit_career', $data);
        } else {
            redirect("Profile");
        }
    }

    public function edit_career() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $this->form_validation->set_rules('edit_career_branch', 'Branch', 'trim|required');
            $this->form_validation->set_rules('edit_career_department', 'Department', 'trim|required');
            $this->form_validation->set_rules('edit_career_client', 'Client', 'trim|required');
            $this->form_validation->set_rules('edit_career_subprocess', 'Sub Process', 'trim|required');
            $this->form_validation->set_rules('edit_career_designation', 'Designation', 'trim|required');
            $this->form_validation->set_rules('edit_career_departmentrole', 'Department Role', 'trim|required');
            $this->form_validation->set_rules('edit_career_grade', 'Grade', 'trim|required');
            $this->form_validation->set_rules('edit_career_reporting_to', 'Reporting To', 'trim|required');
            $this->form_validation->set_rules('edit_career_from', 'Join Date', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $career_id = $this->input->post('edit_career_id');
                $branch = $this->input->post('edit_career_branch');
                $department = $this->input->post('edit_career_department');
                $client = $this->input->post('edit_career_client');
                $designation_name = $this->input->post('edit_career_designation');
                $reporting_to = $this->input->post('edit_career_reporting_to');

                $joining_date = $this->input->post('edit_career_from');
                $doj = date("Y-m-d", strtotime($joining_date));

                $to_date = $this->input->post('edit_career_to');
                if ($to_date == "") {
                    $to = "";
                } else {
                    $to = date("Y-m-d", strtotime($to_date));
                }

                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];

                $update_data = array(
                    'Branch_Id' => $branch,
                    'Department_Id' => $department,
                    'Client_Id' => $client,
                    'Designation_Id' => $designation_name,
                    'Reporting_To' => $reporting_to,
                    'From' => $doj,
                    'To' => $to,
                    'Modified_By' => $inserted_id,
                    'Modified_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $this->db->where('Career_Id', $career_id);
                $q = $this->db->update('tbl_employee_career', $update_data);
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                $this->load->view('error');
            }
        } else {
            redirect("Profile");
        }
    }

    public function Deletecareer() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $career_id = $this->input->post('career_id');
            $data = array(
                'career_id' => $career_id
            );
            $this->load->view('employee/career/delete_career', $data);
        } else {
            redirect("Profile");
        }
    }

    public function delete_career() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $career_id = $this->input->post('delete_career_id');
            $update_data = array(
                'Status' => 0
            );
            $this->db->where('Career_Id', $career_id);
            $q = $this->db->update('tbl_employee_career', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }

    /* Career History Ends Here */

 /* Confirmation Notification  Start Here */

    public function Confirmation() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 1 || $user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'Confirmation',
                'main_content' => 'employee/confirmation/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

public function Markconfirmation() {
        $this->form_validation->set_rules('emp_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $emp_id = $this->input->post('emp_id');
            $update_data = array(
                'Emp_Mode' => 'Confirmed'
            );
            $this->db->where('Employee_Id',$emp_id);
            $q = $this->db->update('tbl_employee', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Confirmation Notification  End Here */

 public function Empconfirmation() {
        $this->form_validation->set_rules('emp_no', '', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $emp_id = $this->input->post('emp_no');
            $emp_mode = $this->input->post('emp_mode');
            $emp_mode_comment = $this->input->post('mode_comment');
            $update_data = array(
                'Emp_Mode' => $emp_mode,
                'Emp_Mode_Comment' => $emp_mode_comment
            );
            $this->db->where('Emp_Number', $emp_id);
            $q = $this->db->update('tbl_employee', $update_data);
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