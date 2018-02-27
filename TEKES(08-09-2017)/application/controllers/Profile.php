<?php
if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Profile extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
 $current_month = date('m');
 $this->db->where('Status',1);
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
                    'Added_Month' => $current_month,
                    'Added_Year' => date('Y')
                );
                $this->db->where('Emp_Id', $emp_id);
                $this->db->update('tbl_leave_pending', $update_data);
            }
        }
    }

    public function Index() {
        $data = array(
            'title' => 'Profile',
            'main_content' => 'profile/index'
        );
        $this->load->view('common/content', $data);
    }

 
    public function fetch_department() {
        $branch_id = ($_REQUEST["branch_id"] <> "") ? trim($_REQUEST["branch_id"]) : "";
        if ($branch_id <> "") {
            $this->db->where(
                    array(
                        'Branch_Id' => $branch_id,
                        'Status' => 1
                    )
            );
            $this->db->order_by('Department_Name');
            $sql_dept = $this->db->get('tbl_department');
            $count_dept = $sql_dept->num_rows();
            if ($count_dept > 0) {
                ?>
                    <option value="">Select Department</option>
                    <?php foreach ($sql_dept->result() as $row_dept) { ?>
                        <option value="<?php echo $row_dept->Department_Id; ?>"><?php echo $row_dept->Department_Name; ?></option>
                    <?php } ?>
            <?php } else {
                ?>
                    <option value="">Select Department</option>
                <?php
            }
        }
    }

    public function fetch_client() {
        $dept_id = ($_REQUEST["dept_id"] <> "") ? trim($_REQUEST["dept_id"]) : "";
        if ($dept_id <> "") {
            $this->db->where(
                    array(
                        'Department_Id' => $dept_id,
                        'Status' => 1
                    )
            );
            $this->db->order_by('Client_Name');
            $sql_subdept = $this->db->get('tbl_subdepartment');
            $count_sqldept = $sql_subdept->num_rows();
            if ($count_sqldept > 0) {
                ?>
                    <option value="">Select Client</option>
                    <?php foreach ($sql_subdept->result() as $row_subdept) { ?>
                        <option value="<?php echo $row_subdept->Subdepartment_Id; ?>"><?php echo $row_subdept->Client_Name . " : " . $row_subdept->Subdepartment_Name; ?></option>
                    <?php } ?>
            <?php } else {
                ?>
                    <option value="">Select Client</option>
                <?php
            }
        }
    }

    public function fetch_subprocess() {
        $dept_id = ($_REQUEST["client_id"] <> "") ? trim($_REQUEST["client_id"]) : "";
        if ($dept_id <> "") {
            $this->db->where(
                    array(
                        'Subdepartment_Id' => $dept_id,
                        'Status' => 1
                    )
            );
            $this->db->order_by('Client_Name');
            $sql_subdept = $this->db->get('tbl_subdepartment');
            $count_sqldept = $sql_subdept->num_rows();
            if ($count_sqldept > 0) {
                ?>
                    <option value="">Select Sub Process</option>
                    <?php foreach ($sql_subdept->result() as $row_subdept) { ?>
                        <option value="<?php echo $row_subdept->Subdepartment_Id; ?>"><?php echo $row_subdept->Subdepartment_Name; ?></option>
                    <?php } ?>
            <?php } else {
                ?>
                    <option value="">Select Sub Process</option>
                <?php
            }
        }
    }
    
    public function fetch_designation() {
        $subdept_id = ($_REQUEST["subdept_id"] <> "") ? trim($_REQUEST["subdept_id"]) : "";
        if ($subdept_id <> "") {
            $this->db->where(
                    array(
                        'Client_Id' => $subdept_id,
                        'Status' => 1
                    )
            );
            $this->db->order_by('Designation_Name');
            $sql_desn = $this->db->get('tbl_designation');
            $count_desn = $sql_desn->num_rows();
            if ($count_desn > 0) {
                ?>
                    <option value="">Select Designation</option>
                    <?php foreach ($sql_desn->result() as $row_desn) { ?>
                        <option value="<?php echo $row_desn->Designation_Id; ?>"><?php echo $row_desn->Designation_Name; ?></option>
                    <?php } ?>
            <?php } else {
                ?>
                   <option value="">Select Designation</option>
                <?php
            }
        }
    }

     public function fetch_grade() {
        $designation_id = ($_REQUEST["designation_id"] <> "") ? trim($_REQUEST["designation_id"]) : "";
        if ($designation_id <> "") {
            $this->db->where(
                    array(
                        'Designation_Id' => $designation_id,
                        'Status' => 1
                    )
            );
            $this->db->order_by('Grade');
            $sql_grade = $this->db->get('tbl_designation');
            $count_grade = $sql_grade->num_rows();
            if ($count_grade > 0) {
                ?>
                    <option value="">Select Grade</option>
                    <?php foreach ($sql_grade->result() as $row_grade) { ?>
                        <option value="<?php echo $row_grade->Designation_Id; ?>"><?php echo $row_grade->Grade; ?></option>
                    <?php } ?>
            <?php } else {
                ?>
                   <option value="">Select Grade</option>
                <?php
            }
        }
    }
    
     public function fetch_departmentrole() {
        $grade_id = ($_REQUEST["grade_id"] <> "") ? trim($_REQUEST["grade_id"]) : "";
        if ($grade_id <> "") {
            $this->db->where(
                    array(
                        'Designation_Id' => $grade_id,
                        'Status' => 1
                    )
            );
            $this->db->order_by('Role');
            $sql_role = $this->db->get('tbl_designation');
            $count_role = $sql_role->num_rows();
            if ($count_role > 0) {
                ?>
                    <option value="">Select Role</option>
                    <?php foreach ($sql_role->result() as $row_role) { ?>
                        <option value="<?php echo $row_role->Designation_Id; ?>"><?php echo $row_role->Role; ?></option>
                    <?php } ?>
            <?php } else {
                ?>
                   <option value="">Select Role</option>
                <?php
            }
        }
    }
    
    public function fetch_state() {
        $country_id = ($_REQUEST["country_id"] <> "") ? trim($_REQUEST["country_id"]) : "";
        if ($country_id <> "") {
            $this->db->where('countryID', $country_id);
            $this->db->order_by('stateName');
            $sql_state = $this->db->get('tbl_states');
            $count_state = $sql_state->num_rows();
            if ($count_state > 0) {
                ?>

                    <option value="">Select State</option>
                    <?php foreach ($sql_state->result() as $row_state) { ?>
                        <option value="<?php echo $row_state->stateID; ?>"><?php echo $row_state->stateName; ?></option>
                    <?php } ?>

                <?php
            } else {
                ?>
                    <option value="">Select State</option>
                <?php
            }
        }
    }

    public function fetch_district() {
        $state_id = ($_REQUEST["state_id"] <> "") ? trim($_REQUEST["state_id"]) : "";
        if ($state_id <> "") {
            $this->db->where('stateID', $state_id);
            $this->db->order_by('districtName');
            $sql_district = $this->db->get('tbl_districts');

            $count_district = $sql_district->num_rows();
            if ($count_district > 0) {
                ?>
                    <option value="">Select District</option>
                    <?php foreach ($sql_district->result() as $row_district) { ?>
                        <option value="<?php echo $row_district->districtID; ?>"><?php echo $row_district->districtName; ?></option>
                    <?php } ?>
                <?php
            } else {
                ?>
                    <option value="">Select District</option>
                <?php
            }
        }
    }

    public function Logout() {
        $sess_data = $this->session->all_userdata();
        $username = $sess_data['username'];
        $data = array(
            'Last_login' => date('Y-m-d H:i:s')
        );

        $this->db->where('Employee_Id', $username);
        $update = $this->db->update('tbl_user', $data);
		
        if ($update) {
            $this->session->sess_Destroy();
            redirect('Login');
        }
    }

    /* Change Password Start Here */

    function change_password() {
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
        if ($this->form_validation->run() == TRUE) {

            $username = $this->session->userdata('username');

            $curr_password = $this->input->post('current_password');
            $current_password = base64_encode($curr_password);

            $data1 = array(
                'Employee_Id' => $username,
                'Password' => $current_password
            );
            $this->db->where($data1);
            $q = $this->db->get('tbl_user', $data1);
            $count = $q->num_rows();
            if ($count == 1) {
                $password = $this->input->post('new_password');
                $new_password = base64_encode($password);


                $data = array(
                    'Password' => $new_password,
                    'Password_Updated' => 'Yes'
                );
                $this->db->where('Employee_Id', $username);
                $update = $this->db->update('tbl_user', $data);
                if ($update) {
                    echo "success";
                } else {
                    echo "fail";
                }
            } else {
                echo "invalid";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Change Password End Here */

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}
?>