<?php
if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Manpower extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }
    /* Manpower Requisition Details Start Here */

// Controller function
    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $data = array(
                'title' => 'Manpower Requisitions',
                'main_content' => 'recruitment/manpower/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }      
    
    // Add Manpower JobPost Requisitions Start here
    public function add_jobpost_Requisitions() {
        $user_role = $this->session->userdata('user_role');        
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {           
            $this->form_validation->set_rules('add_jobpost_interview_date', 'Interview Date', 'trim|required');           
            $this->form_validation->set_rules('add_jobpost_request_person_name', 'Request Person Name', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_department_name', 'Department name', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_subdepartment_name', 'Sub Department name', 'trim|required');
            
            $this->form_validation->set_rules('add_jobpost_title_name', 'Title Name', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_type', 'Job Type', 'trim|required');            
            $this->form_validation->set_rules('add_jobpost_positions', 'No.of Position', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_jobskills', 'Job Skills', 'trim|required');
            
            $this->form_validation->set_rules('add_jobpost_location', 'Location', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_qualification', 'Qualification', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_experience', 'Experience', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_salary', 'Salary', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_gender', 'Gender', 'trim|required');
            
            $this->form_validation->set_rules('add_jobpost_working_hour', 'Working Hours', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_shift_time', 'Shif time', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_jobdescription', 'Job Description', 'trim|required');
            $this->form_validation->set_rules('add_jobpost_otherinformation', 'Other Information', 'trim|required');                     

            if ($this->form_validation->run() == TRUE) {               
                $add_jobpost_interview_date1 = $this->input->post('add_jobpost_interview_date');
                //Date format converted
                $add_jobpost_interview_date = date("Y-m-d", strtotime($add_jobpost_interview_date1));
                $add_jobpost_request_person_name = $this->input->post('add_jobpost_request_person_name');
                $add_jobpost_department_name = $this->input->post('add_jobpost_department_name');                 
                $add_jobpost_subdepartment_name = $this->input->post('add_jobpost_subdepartment_name');                
                
                $add_jobpost_title_name = $this->input->post('add_jobpost_title_name');
                $add_jobpost_type = $this->input->post('add_jobpost_type');
                $add_jobpost_positions = $this->input->post('add_jobpost_positions');                
                $add_jobpost_jobskills = $this->input->post('add_jobpost_jobskills');
                
                $add_jobpost_location = $this->input->post('add_jobpost_location');
                $add_jobpost_qualification = $this->input->post('add_jobpost_qualification');
                $add_jobpost_experience = $this->input->post('add_jobpost_experience');
                $add_jobpost_salary = $this->input->post('add_jobpost_salary');
                $add_jobpost_gender = $this->input->post('add_jobpost_gender');
                
                $add_jobpost_working_hour = $this->input->post('add_jobpost_working_hour');
                $add_jobpost_shift_time = $this->input->post('add_jobpost_shift_time');
                $add_jobpost_jobdescription = $this->input->post('add_jobpost_jobdescription');
                $add_jobpost_otherinformation = $this->input->post('add_jobpost_otherinformation');                                            
                                
                $sess_data = $this->session->all_userdata();
                $inserted_id = $sess_data['user_id'];
                //$uniq_id = uniqid();
                
                $insert_data = array(
                    //'Reference_No' => $uniq_id,
                    'Requisition_Date' => $add_jobpost_interview_date,
                    'Requisition_Name' => $add_jobpost_request_person_name,
                    'Department_Name' => $add_jobpost_department_name,
                    'Sub_Department_Name' => $add_jobpost_subdepartment_name,
                    
                    'Job_Title' => $add_jobpost_title_name,
                    'Job_Type' => $add_jobpost_type,
                    'Positions' => $add_jobpost_positions,                    
                    'Job_Skills' => $add_jobpost_jobskills, 
                    
                    'Job_Location' => $add_jobpost_location,
                    'Qualification' => $add_jobpost_qualification,
                    'Experience' => $add_jobpost_experience,                    
                    'Salary' => $add_jobpost_salary,                    
                    'Gender' => $add_jobpost_gender,
                    
                    'Working_Hours' => $add_jobpost_working_hour,
                    'Shift_Time' => $add_jobpost_shift_time,
                    'Job_Description' => $add_jobpost_jobdescription,
                    'Other_Information' => $add_jobpost_otherinformation,
                    'Inserted_By' => $inserted_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );           
                $q = $this->db->insert('tbl_manpower_requisition', $insert_data);                                               
                // Fetch the data in tables start here
                $emp_no = $this->session->userdata('username');                
                $this->db->where('Emp_Number', $emp_no);
                $q_employee = $this->db->get('tbl_employee');
                foreach ($q_employee->result() as $row_employee) {
                    $emp_firstname = $row_employee->Emp_FirstName;
                    $emp_lastname = " " . $row_employee->Emp_LastName;
                    $emp_middlename = " " . $row_employee->Emp_MiddleName;
                }
                // Department table            
                $this->db->where('Department_Id', $add_jobpost_department_name);
                $q_dept = $this->db->get('tbl_department');
                foreach ($q_dept->result() as $row_dept) {
                    $department_name = $row_dept->Department_Name;                              
                }
                // Designation table
                $this->db->where('Designation_Id', $add_jobpost_title_name);
                $q_destination = $this->db->get('tbl_designation');
                foreach ($q_destination->result() as $row_dest) {
                    $destination_name = $row_dest->Designation_Name;                              
                }                
                // Email Send Code Start here
                $this->load->view('phpmailer/class_phpmailer');
                $msg = "Dear Sir,<br><br>"
                        . "<p style='text-indent:60px'>I would like to Request for Job Requisitions,"                                                
                        . "Kindly I request Job Requisitions you to process, this position will be posted internally for at least one week..</p>"
                        . "If approved, the Human Resources Specialist will then begin the recruitment process and contact the requestor.
                           If not approved, the Associate Vice President of Human Resources will contact the requestor.<br><br>"             
                        . "<b>Requisition Person Name :</b> $emp_firstname $emp_lastname $emp_middlename &nbsp;&nbsp;&nbsp; <b>Requisition Request Date :</b> $add_jobpost_interview_date<br><br>"
                        . "<b>Department Name :</b> $department_name &nbsp;&nbsp;&nbsp; <b>Job Title</b> $destination_name<br><br>"                       
                        . "<b>Job Type :</b> $add_jobpost_type &nbsp;&nbsp;&nbsp; <b>Job No.of.Positions :</b> $add_jobpost_positions<br><br>"                         
                        . "<b>Experience :</b> $add_jobpost_experience &nbsp;&nbsp;&nbsp; <b>Gender :</b> $add_jobpost_gender &nbsp;&nbsp;<b>Qualification:</b> $add_jobpost_qualification<br><br>" 
                        . "<b>Shit Time :</b> $add_jobpost_shift_time &nbsp;&nbsp;&nbsp; <b>Working Hours :</b> $add_jobpost_working_hour<br><br>" 
                        . "<b>Job Location :</b> $add_jobpost_location &nbsp;&nbsp;&nbsp; <b>Job Skills :</b> $add_jobpost_jobskills<br><br><br><br>"
                        . "Thanks & Regards,<br><b>"
                        . "<font size=3 face='Monotype Corsiva'>$emp_firstname $emp_lastname $emp_middlename</b>"
                        . "</font> "
                        . "<br><font size=4 color='#0070C0' face='Monotype Corsiva'>"
                        . "<b>DRN Definite Solutions Pvt Ltd.,</b></font><br>"
                        . "<font size=2.5 color='#1F497D' face='Calibri'>"
                        . "<b>Corp: 3240 East State Street Ext Hamilton, NJ 08619</b>"
                        . "</font><br> "
                        . "<font size=2.5 color='#1F497D' face='Calibri'>"
                        . "<b>Direct: Office: 1- (443)-221-4551|Fax:(760)-280-6000</b></font><br>"
                        . "<font size=2.5 color='#1F497D' face='Calibri'><u>info@drnds.com</u> | <u>www.drnds.com</u>"
                        . "</font> ";
                $subject = "Request for Employees";
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->Host = "smtpout.secureserver.net";
                $mail->SMTPAuth = true;
                $mail->Port = 465;
                $mail->Username = "techteam@drnds.com";
                $mail->Password = "nop539";
                $mail->SMTPSecure = 'ssl';
                $mail->From = "techteam@drnds.com";
                $mail->FromName = $emp_firstname . " " . $emp_lastname . " " . $emp_middlename;
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = "<font size=2.5 face='Century Gothic'>$msg</font>";
                $mail->addAddress("techteam@drnds.com");
                /*$mail->addAddress("$Emp_Officialemail");
                $mail->addCC("naveen@drnds.com");
                $mail->addBCC("devindra@drnds.com");*/
                $mail->SMTPDebug = 1;
                $mail->send();
                if ($q) {
                    echo "success";
                } else {
                    echo "fail";
                }
                // Email Send Code End here 
            }
        }
    }    
    // Add Manpower JobPost Requisitions End here
    
    // Edit Manpower JobPost Requisitions Start here    
    public function Editjobpost() {
        $user_role = $this->session->userdata('user_role');        
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $MP_Id = $this->input->post('MP_Id');            
            $data = array(
                'MP_Id' => $MP_Id                  
            );
            $this->load->view('recruitment/manpower/edit_manpower', $data);
        } else {
            redirect("Profile");
        }
    } 
    public function edit_jobpost() {
        $user_role = $this->session->userdata('user_role');        
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {           
            $this->form_validation->set_rules('edit_jobpost_id', 'ID', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_interview_date', 'Interview Date', 'trim|required');  
            $this->form_validation->set_rules('edit_jobpost_request_person_name', 'Request Person', 'trim|required'); 
            $this->form_validation->set_rules('edit_jobpost_department_name', 'Department name', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_subdepartment_name', 'Sub Department name', 'trim|required');
            
            $this->form_validation->set_rules('edit_jobpost_title_name', 'Titlename', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_type', 'process', 'trim|required');                        
            $this->form_validation->set_rules('edit_jobpost_positions', 'No.of Position', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_skills', 'Jobtype', 'trim|required');
            
            $this->form_validation->set_rules('edit_jobpost_location', 'Location', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_qualification', 'Qualification', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_experience', 'Experience', 'trim|required');           
            $this->form_validation->set_rules('edit_jobpost_salary', 'Salary', 'trim|required');            
            $this->form_validation->set_rules('edit_jobpost_gender', 'Gender', 'trim|required');
            
            $this->form_validation->set_rules('edit_jobpost_shift_time', 'Shift Time', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_jobdescription', 'Job Description', 'trim|required');
            $this->form_validation->set_rules('edit_jobpost_otherinformation', 'Other Information', 'trim|required');

            if ($this->form_validation->run() == TRUE) {                
                $edit_jobpost_id = $this->input->post('edit_jobpost_id');
                $edit_jobpost_interview_date1 = $this->input->post('edit_jobpost_interview_date');
                //Date format converted
                $edit_jobpost_interview_date = date("Y-m-d", strtotime($edit_jobpost_interview_date1));
                $edit_jobpost_request_person_name = $this->input->post('edit_jobpost_request_person_name');
                $edit_jobpost_department_name = $this->input->post('edit_jobpost_department_name');
                $edit_jobpost_subdepartment_name = $this->input->post('edit_jobpost_subdepartment_name');
                
                $edit_jobpost_title_name = $this->input->post('edit_jobpost_title_name');
                $edit_jobpost_skills = $this->input->post('edit_jobpost_skills');
                $edit_jobpost_type = $this->input->post('edit_jobpost_type');
                $edit_jobpost_positions = $this->input->post('edit_jobpost_positions');
                
                $edit_jobpost_location = $this->input->post('edit_jobpost_location');
                $edit_jobpost_qualification = $this->input->post('edit_jobpost_qualification');
                $edit_jobpost_experience = $this->input->post('edit_jobpost_experience');               
                $edit_jobpost_salary = $this->input->post('edit_jobpost_salary');    
                $edit_jobpost_gender = $this->input->post('edit_jobpost_gender');
                
                $edit_jobpost_working_hour = $this->input->post('edit_jobpost_working_hour');    
                $edit_jobpost_shift_time = $this->input->post('edit_jobpost_shift_time');
                $edit_jobpost_jobdescription = $this->input->post('edit_jobpost_jobdescription');
                $edit_jobpost_otherinformation = $this->input->post('edit_jobpost_otherinformation'); 
                                
                $sess_data = $this->session->all_userdata();                
                $modified_id = $sess_data['user_id'];                

                $update_data = array(
                    'Requisition_Date' => $edit_jobpost_interview_date,
                    'Requisition_Name' => $edit_jobpost_request_person_name,
                    'Department_Name' => $edit_jobpost_department_name,
                    'Sub_Department_Name' => $edit_jobpost_subdepartment_name,
                    
                    'Job_Title' => $edit_jobpost_title_name,
                    'Job_Type' => $edit_jobpost_type,
                    'Positions' => $edit_jobpost_positions,
                    'Job_Skills' => $edit_jobpost_skills,
                    
                    'Job_Location' => $edit_jobpost_location,
                    'Qualification' => $edit_jobpost_qualification,
                    'Experience' => $edit_jobpost_experience,
                    'Salary' => $edit_jobpost_salary,
                    'Gender' => $edit_jobpost_gender,
                    
                    'Working_Hours' => $edit_jobpost_working_hour,
                    'Shift_Time' => $edit_jobpost_shift_time,                   
                    'Job_Description' => $edit_jobpost_jobdescription,                    
                    'Other_Information' => $edit_jobpost_otherinformation,                    
                    'Modified_By' => $modified_id,
                    'Modified_Date' => date('Y-m-d H:i:s')
                );         
                $this->db->where('MP_Id', $edit_jobpost_id);
                $q = $this->db->update('tbl_manpower_requisition', $update_data);                                
                if ($q) {
                    echo "success";
                } else {
                    // echo "<script>alert('Failed to update Job Post details')</script>";
                    echo "fail";
                }
            }
        }
    }
    // Edit Manpower JobPost Requisitions End here
   
    // Delete Job Post Requisitions Start here
    public function Deletejobpost() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $MP_Id = $this->input->post('MP_Id');
            $data = array(
                'MP_Id' => $MP_Id
            );            
            $this->load->view('recruitment/manpower/delete_manpower', $data);
        } else {
            redirect('Profile');
        }
    }
    /* Job Post Requisitions Delete Details Start Here */
    public function delete_jobpost() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $this->form_validation->set_rules('delete_jobpost_id', 'ID', 'trim|required');          
            if ($this->form_validation->run() == TRUE) {
                $delete_jobpost_id = $this->input->post('delete_jobpost_id');
                
                $sess_data = $this->session->all_userdata();
                $modified_id = $sess_data['user_id'];
                $update_data = array(
                    'Status' => 0
                );
            }
            $this->db->where('MP_Id', $delete_jobpost_id);
            $q = $this->db->update('tbl_manpower_requisition', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            redirect("Profile");
        }
    }
    // Recruitment Job post requisitions Dashboard
    public function Jobpostdashboard() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            $data = array(
                'title' => 'JobPost Requisitions Dashboard',
                'main_content' => 'recruitment/jobpost_dashboard'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }
    
    // Fetch the Values in table start here
    public function fetch_jobtitle() {
        $jobtitle_id = ($_REQUEST["j_id"] <> "") ? trim($_REQUEST["j_id"]) : "";
        if ($jobtitle_id <> "") {
            $this->db->where(
                    array(
                        'J_Id' => $jobtitle_id,
                        'Status' => 1
                    )
            );
            $sql_desgn = $this->db->get('tbl_jobskills');
            $count_desgn = $sql_desgn->num_rows();
            if ($count_desgn > 0) {
                ?>
                <?php foreach ($sql_desgn->result() as $row_desgn) { ?>
                    <option value="<?php echo $row_desgn->S_Id; ?>"><?php echo $row_desgn->Department_Name; ?></option>
                <?php } ?>
            <?php } else {
                ?>
                <option value="">Select Department Name</option>
                <?php
            }
        }
    }
    
    public function fetch_jobdesignation_Nochanges() {
        $category_id = ($_REQUEST["category_id"] <> "") ? trim($_REQUEST["category_id"]) : "";
        if ($category_id <> "") {
            $this->db->where(
                    array(
                        'Category_Id' => $category_id,
                        'Status' => 1
                    )
            );
            $sql_desgn = $this->db->get('tbl_jobdesignation');
            $count_desgn = $sql_desgn->num_rows();
            if ($count_desgn > 0) {
                ?>
                <?php foreach ($sql_desgn->result() as $row_desgn) { ?>
                    <option value="<?php echo $row_desgn->Designation_Id; ?>"><?php echo $row_desgn->Designation; ?></option>
                <?php } ?>
            <?php } else {
                ?>
                <option value="">Select Designation</option>
                <?php
            }
        }
    }     
    
    public function fetch_jobdesignation_new() {
        $category_id = ($_REQUEST["category_id"] <> "") ? trim($_REQUEST["category_id"]) : "";
        if ($category_id <> "") {
            $this->db->where(
                    array(
                        'Category_Id' => $category_id,
                        'Status' => 1
                    )
            );
            $sql_desgn = $this->db->get('tbl_jobskills');
            $count_desgn = $sql_desgn->num_rows();
            if ($count_desgn > 0) {
                ?>
                <?php foreach ($sql_desgn->result() as $row_desgn) { ?>
                    <option value="<?php echo $row_desgn->Designation_name; ?>"><?php echo $row_desgn->Designation; ?></option>
                <?php } ?>
            <?php } else {
                ?>
                <option value="">Select Designation</option>
                <?php
            }
        }
    }
    // Fetch the Values in table End here
    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }
}
?>