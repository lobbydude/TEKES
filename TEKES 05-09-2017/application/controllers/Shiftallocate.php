<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Shiftallocate extends CI_Controller {

    public static $db;

    public function __construct() {
        parent::__construct();
        $this->clear_cache();
        self::$db = & get_instance()->db;
        if (!$this->authenticate->isAdmin()) {
            redirect('Login');
        }
    }
    
    /* Shift Timing Details Start Here */

// Controller function
    public function Index() {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6 || $user_role == 1) {
            $data = array(
                'title' => 'Shift Time Allocation',
                'main_content' => 'shift/allocate/index'
            );
            $this->load->view('operation/content', $data);
        } else {
            redirect('Profile');
        }
    }

    // Add(Insert)Shift Timing query start here
    public function Add_shift_timing() {
        $this->form_validation->set_rules('add_year', '', 'trim|required');
        $this->form_validation->set_rules('add_month', '', 'trim|required');
        $this->form_validation->set_rules('add_shiftid', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $add_year = $this->input->post('add_year');
            $add_month = $this->input->post('add_month');
            $add_shiftid = $this->input->post('add_shiftid');
            $shift_emp_id = $this->input->post('shift_emp_id');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            // Month to Date convertaion Start
            $num = cal_days_in_month(CAL_GREGORIAN, $add_month, $add_year);

            for ($i = 1; $i <= $num; $i++) {
                $mktime = mktime(0, 0, 0, $add_month, $i, $add_year);
                $date_n = date("Y-m-d", $mktime);
                // Month to Date convertaion End
                for ($j = 0; $j < sizeof($shift_emp_id); $j++) {
                    //  Get the Value
                    $get_data = array(
                        'Year' => $add_year,
                        'Month' => $add_month,
                        'Employee_Id' => $shift_emp_id[$j],
                        'Date' => $date_n,
                        'Status' => 1
                    );
                    $this->db->where($get_data);
                    $shift_get = $this->db->get('tbl_shift_allocate');
                    $count_info = $shift_get->num_rows();
                    if ($count_info == 1) {
                        foreach ($shift_get->result() as $row_in) {
                            $SA_Id = $row_in->SA_Id;
                        }
                        $update1 = array(
                            'Shift_Id' => $add_shiftid,
                            'Modified_By' => $inserted_id,
                            'Modified_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('SA_Id', $SA_Id);
                        $q1 = $this->db->update('tbl_shift_allocate', $update1);
                    } else {
                        $insert_data1 = array(
                            'Year' => $add_year,
                            'Month' => $add_month,
                            'Shift_Id' => $add_shiftid,
                            'Employee_Id' => $shift_emp_id[$j],
                            'Date' => $date_n,
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $q1 = $this->db->insert('tbl_shift_allocate', $insert_data1);
                    }
                }
            }
            if ($q1) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }
    // Shift name time add Individual employee
    public function Add_shift_individual_emp() {
        $this->form_validation->set_rules('add_year', '', 'trim|required');
        $this->form_validation->set_rules('add_month', '', 'trim|required');
        $this->form_validation->set_rules('add_shiftid', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $add_year = $this->input->post('add_year');
            $add_month = $this->input->post('add_month');
            $add_shiftid = $this->input->post('add_shiftid');
            $shift_emp_id = $this->input->post('shift_emp_id');

            $sess_data = $this->session->all_userdata();
            $inserted_id = $sess_data['user_id'];
            // Month to Date convertaion Start
            $num = cal_days_in_month(CAL_GREGORIAN, $add_month, $add_year);

            for ($i = 1; $i <= $num; $i++) {
                $mktime = mktime(0, 0, 0, $add_month, $i, $add_year);
                $date_n = date("Y-m-d", $mktime);
                // Month to Date convertaion End                
                    //  Get the Value
                    $get_data = array(
                        'Year' => $add_year,
                        'Month' => $add_month,
                        'Employee_Id' => $shift_emp_id,
                        'Date' => $date_n,
                        'Status' => 1
                    );
                    $this->db->where($get_data);
                    $shift_get = $this->db->get('tbl_shift_allocate');
                    $count_info = $shift_get->num_rows();

                    if ($count_info == 1) {
                        foreach ($shift_get->result() as $row_in) {
                            $SA_Id = $row_in->SA_Id;
                        }
                        $update1 = array(
                            'Shift_Id' => $add_shiftid,
                            'Modified_By' => $inserted_id,
                            'Modified_Date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('SA_Id', $SA_Id);
                        $q1 = $this->db->update('tbl_shift_allocate', $update1);
                    } else {
                        $insert_data1 = array(
                            'Year' => $add_year,
                            'Month' => $add_month,
                            'Shift_Id' => $add_shiftid,
                            'Employee_Id' => $shift_emp_id,
                            'Date' => $date_n,
                            'Inserted_By' => $inserted_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Status' => 1
                        );
                        $q1 = $this->db->insert('tbl_shift_allocate', $insert_data1);
                    }                
            }
            if ($q1) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }
        
    // Carry forward Shift time details Start here
    /*$get_carry_month_data = array(
        'Month' => date('m'),
        'Year' => date('Y'),
        'Shift_Id' => $shift_emp_id('$j'),
        'Employee_Id' => $shift_emp_id,
        'Date' => $date_n,
        'Status' => 1
    );    
    $this->db->where($get_carry_month_data);
    $shift_get_carry_data = $this->db->get('tbl_shift_allocate');
    $count_carry_info = $shift_get_carry_data->num_rows();
    if($count_carry_info == '1'){
        $Month = $row_in->Month;
    }        
    $insert_carry_data = array(
        'Year' => $add_year,
        'Month' => $add_month,
        'Shift_Id' => $add_shiftid,
        'Employee_Id' => $shift_emp_id,
        'Date' => $date_n,
        'Inserted_By' => $inserted_id,
        'Inserted_Date' => date('Y-m-d H:i:s'),
        'Status' => 1
    ); */    
    // Carry forward Shift time details End here

    public function Fetch_employee() {
        $emp_year = $this->input->post('add_year');
        $emp_month = $this->input->post('add_month');
        $data = array(
            'Year' => $emp_year,
            'Month' => $emp_month
        );
        $this->load->view('shift/allocate/fetchemployee', $data);
    }


// Edit Shift timing Controller
    public function Editshift_allocate() {
        $SA_Id = $this->input->post('SA_Id');
        $data = array(
            'SA_Id' => $SA_Id
        );
        $this->load->view('shift/allocate/edit_shiftsetup', $data);
    }

    // Edit Shift timing query start
    public function edit_shift_allocate() {
        $this->form_validation->set_rules('edit_year', '', 'trim|required');
        $this->form_validation->set_rules('edit_month', '', 'trim|required');
        //$this->form_validation->set_rules('edit_shiftid', '', 'trim|required');
        $this->form_validation->set_rules('edit_date', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $edit_shift_allo_id = $this->input->post('edit_shift_allo_id');
            $edit_year = $this->input->post('edit_year');
            $edit_month = $this->input->post('edit_month');
            $edit_shiftid = $this->input->post('edit_shiftid');
            //$edit_shift_emp_id = $this->input->post('edit_shift_emp_id');
            //$edit_date = $this->input->post('edit_date');            
            $edit_date1 = $this->input->post('edit_date');
            $edit_date = date("Y-m-d", strtotime($edit_date1));

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            //echo "$edit_date";
            //die();
            // Month to Date convertaion Start           
            $update_data = array(
                'Year' => $edit_year,
                'Month' => $edit_month,
                'Shift_Id' => $edit_shiftid,
                //'Employee_Id' => $edit_shift_emp_id[$j],
                'Date' => $edit_date,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('SA_Id', $edit_shift_allo_id);
            $q = $this->db->update('tbl_shift_allocate', $update_data);

            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    // Individual Emp Edit Controller
    public function Editshift_allocate1() {
        $SA_Id = $this->input->post('SA_Id');
        $data = array(
            'SA_Id' => $SA_Id
        );
        $this->load->view('shift/allocate/edit_shiftsetup1', $data);
    }

    // Individual Emp Edit function Start here
    public function edit_shift_allocate1() {
        $this->form_validation->set_rules('edit_year', '', 'trim|required');
        $this->form_validation->set_rules('edit_month', '', 'trim|required');
        $this->form_validation->set_rules('edit_shiftid', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $edit_shift_allo_id = $this->input->post('edit_shift_allo_id');
            $edit_year = $this->input->post('edit_year');
            $edit_month = $this->input->post('edit_month');
            $edit_shiftid = $this->input->post('edit_shiftid');
            $edit_shift_emp_id = $this->input->post('edit_shift_emp_id');

            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];

            $update_data = array(
                'Year' => $edit_year,
                'Month' => $edit_month,
                'Shift_Id' => $edit_shiftid,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('SA_Id', $edit_shift_allo_id);
            $this->db->update('tbl_shift_allocate', $update_data);

            $this->db->where('SA_Id', $edit_shift_allo_id);
            $this->db->delete('tbl_shift_employee');

            for ($i = 0; $i < sizeof($edit_shift_emp_id); $i++) {
                $insert_data = array(
                    'Employee_Id' => $edit_shift_emp_id[$i],
                    'SA_Id' => $edit_shift_allo_id,
                    'Inserted_By' => $modified_id,
                    'Inserted_Date' => date('Y-m-d H:i:s'),
                    'Status' => 1
                );
                $q = $this->db->insert('tbl_shift_employee', $insert_data);
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

    // Delete Shift timing Controller
    public function Deleteshift_Allocate() {
        $SA_Id = $this->input->post('SA_Id');
        $data = array(
            'SA_Id' => $SA_Id
        );
        $this->load->view('shift/allocate/delete_shiftsetup', $data);
    }

    public function delete_shiftallocate() {
        $this->form_validation->set_rules('delete_shift_time_id', '', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $delete_shift_time_id = $this->input->post('delete_shift_time_id');
            $sess_data = $this->session->all_userdata();
            $modified_id = $sess_data['user_id'];
            $update_data = array(
                'Status' => 0,
                'Modified_By' => $modified_id,
                'Modified_Date' => date('Y-m-d H:i:s')
            );
            $this->db->where('SA_Id', $delete_shift_time_id);
            $q = $this->db->update('tbl_shift_allocate', $update_data);
            if ($q) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            $this->load->view('error');
        }
    }

    /* Shift Time Info Start Here */

    public function Info() {
        $data = array(
            'title' => 'Shift Time Setup ',
            'main_content' => 'shift/allocate/info'
        );
        $this->load->view('operation/content', $data);
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>