<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Report extends CI_Controller {

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
        $data = array(
            'title' => 'Report',
            'main_content' => 'report/index'
        );
        $this->load->view('operation/content', $data);
    }

    public function fetch_field() {
        $title = $this->input->post('title');
        $data = array(
            'title_id' => $title
        );
        $this->load->view('report/field', $data);
    }

    public function download() {
        $report_title_list = $this->input->post('report_title_list');
        $report_type = $this->input->post('report_type');
        $this->db->where('T_Id', $report_title_list);
        $q_title = $this->db->get('tbl_report_title');
        foreach ($q_title->result() as $row_title) {
            $Title = $row_title->Title;
            $Table_Name = $row_title->Table_Name;
        }
        $contents = "<table border=1><tr>";
        $fieldlist = $this->input->post('field_list');
        for ($i = 0; $i < sizeof($fieldlist); $i++) {
            $this->db->where('F_Id', $fieldlist[$i]);
            $q_field_head = $this->db->get('tbl_report_field');
            foreach ($q_field_head->result() as $row_field_head) {
                $Field = $row_field_head->Field;
                if ($Field == "Employee Name") {
                    $contents .= "<th>Employee Id</th>";
                    $contents .= "<th>" . $Field . "</th>";
                } else {
                    $contents .= "<th>" . $Field . "</th>";
                }
            }
        }
        $contents .="</tr>";
        if ($report_type == "Partial") {
            $period_from1 = $this->input->post('period_from');
            $period_from = date("Y-m-d", strtotime($period_from1));
            $period_to1 = $this->input->post('period_to');
            $period_to = date("Y-m-d", strtotime($period_to1));
            if ($Table_Name == "tbl_resignation") {
                $this->db->where('Resignation_Date >=', $period_from);
                $this->db->where('Resignation_Date <=', $period_to);
                $this->db->where('Status', 1);
                $sql_export = $this->db->get($Table_Name);
            } else if ($Table_Name == "tbl_employee") {
                $this->db->where('Emp_Doj >=', $period_from);
                $this->db->where('Emp_Doj <=', $period_to);
                $this->db->where('Status', 1);
                $sql_export = $this->db->get($Table_Name);
            } else {
                $this->db->where('Status', 1);
                $sql_export = $this->db->get($Table_Name);
            }
        } else {
            $this->db->where('Status', 1);
            $sql_export = $this->db->get($Table_Name);
        }
        foreach ($sql_export->result() as $row_export) {
            $contents .="<tr>";
            for ($j = 0; $j < sizeof($fieldlist); $j++) {
                $this->db->where('F_Id', $fieldlist[$j]);
                $q_field_content = $this->db->get('tbl_report_field');
                foreach ($q_field_content->result() as $row_field_content) {
                    $Field_Name = $row_field_content->Field;
                    $Field_Type = $row_field_content->Field_Type;
                    if ($Field_Name == "Employee Name") {
                        $emp_no = $row_export->$Field_Type;
                        $this->db->where('Emp_Number', $emp_no);
                        $q_employee = $this->db->get('tbl_employee');
                        $count_employee = $q_employee->num_rows();
                        if ($count_employee == 1) {
                            foreach ($q_employee->result() as $row_employee) {
                                $this->db->where('employee_number', $emp_no);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->Result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                }
                                $emp_name = $row_employee->Emp_FirstName;
                                $emp_name .= " " . $row_employee->Emp_LastName;
                                $emp_name .= " " . $row_employee->Emp_MiddleName;
                                $contents .="<td>" . $emp_code . $emp_no . "</td>";
                                $contents .= "<td>" . $emp_name . "</td>";
                            }
                        } else {
                            $contents .="<td></td>";
                            $contents .= "<td></td>";
                        }
                    } else if ($Field_Name == "Reporting Manager") {
                        $emp_no = $row_export->$Field_Type;
                        $this->db->where('Emp_Number', $emp_no);
                        $q_employee = $this->db->get('tbl_employee');
                        foreach ($q_employee->result() as $row_employee) {
                            $this->db->where('employee_number', $emp_no);
                            $q_code = $this->db->get('tbl_emp_code');
                            foreach ($q_code->Result() as $row_code) {
                                $emp_code = $row_code->employee_code;
                            }
                            $emp_name = $row_employee->Emp_FirstName;
                            $emp_name .= " " . $row_employee->Emp_LastName;
                            $emp_name .= " " . $row_employee->Emp_MiddleName;
                            $contents .="<td>" . $emp_name . "( " . $emp_code . $emp_no . ")" . "</td>";
                        }
                    } else if ($Field_Name == "Net Salary") {
                        $salary_id = $row_export->Sal_Id;
                        $this->db->where('Sal_Id', $salary_id);
                        $q_salary = $this->db->get('tbl_salary_info');
                        foreach ($q_salary->result() as $row_salary) {
                            $C_CTC = $row_salary->C_CTC;
                            $Monthly_CTC = $row_salary->Monthly_CTC;
                        }

                        $Basic = ($Monthly_CTC * 45) / 100;
                        if ($Basic >= 8500) {
                            $Basicpay = $Basic;
                        } else {
                            $Basicpay = 8500;
                        }
                        if ($C_CTC <= 250000) {
                            $Hra = ($Basicpay * 10) / 100;
                        } else {
                            $Hra = ($Basicpay * 40) / 100;
                        }
                        if ($Basicpay >= 8500) {
                            $Conveyance = ($Basicpay * 10) / 100;
                        } else {
                            $Conveyance = 800;
                        }
                        if ($C_CTC > 250000) {
                            $Medical = 1250;
                        } else {
                            $Medical = 0;
                        }
                        $Special_allowance = 0;
                        $Employer_PF_Amount = (($Basicpay + $Special_allowance) * 12) / 100;
                        if ($Employer_PF_Amount >= 1800) {
                            $Employer_PF = 1800;
                        } else {
                            $Employer_PF = $Employer_PF_Amount;
                        }
                        $Employer_ESI = 0;
                        $Total_Fixed_Gross = $Monthly_CTC - ($Employer_ESI + $Employer_PF);
                        if ($Total_Fixed_Gross <= 15000) {
                            $Employer_ESI = ($Total_Fixed_Gross * 4.75) / 100;
                        } else {
                            $Employer_ESI = 0;
                        }
                        $Total_Fixed_Gross = $Monthly_CTC - ($Employer_ESI + $Employer_PF);
                        if ($Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical) < 0) {
                            $Skill_allowance = 0;
                        } else {
                            $Skill_allowance = $Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical);
                        }
                        if ($Total_Fixed_Gross <= 15000) {
                            $Employer_ESI = ($Total_Fixed_Gross * 4.75) / 100;
                        } else {
                            $Employer_ESI = 0;
                        }
                        $Total_Fixed_Gross = $Monthly_CTC - ($Employer_ESI + $Employer_PF);
                        if ($Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical) < 0) {
                            $Skill_allowance = 0;
                        } else {
                            $Skill_allowance = $Total_Fixed_Gross - ($Basicpay + $Hra + $Conveyance + $Medical);
                        }
                        if ($Total_Fixed_Gross <= 15000) {
                            $Employee_ESI = ($Total_Fixed_Gross * 1.75) / 100;
                        } else {
                            $Employee_ESI = 0;
                        }
                        $Employee_PF_Amount = (($Basicpay + $Special_allowance) * 12) / 100;
                        if ($Employee_PF_Amount >= 1800) {
                            $Employee_PF = 1800;
                        } else {
                            $Employee_PF = $Employee_PF_Amount;
                        }
                        if ($Total_Fixed_Gross >= 15000) {
                            $Professional_Tax = 200;
                        } else {
                            $Professional_Tax = 0;
                        }
                        if ($Employee_ESI > 0) {
                            $Insurance = 0;
                        } else {
                            $Insurance = 200;
                        }
                        $Net_Salary = $Total_Fixed_Gross - ($Employee_ESI + $Employee_PF + $Professional_Tax + $Insurance);
                        $contents .="<td>$Net_Salary</td>";
                    } else if ($Field_Name == "DOJ" || $Field_Name == "DOB" || $Field_Name == "Actual Date of Birth" || $Field_Name == "Confirmation Date" || $Field_Name == "Date of Birth" || $Field_Name == "Date of Issue" || $Field_Name == "Date of Expiry" || $Field_Name == "Final Settlement Date" || $Field_Name == "Short LWD" || $Field_Name == "Extend LWD" || $Field_Name == "Last Working Date" || $Field_Name == "Resignation Date" || $Field_Name == "Notice Date" || $Field_Name == "From Date" || $Field_Name == "To Date") {
                        $date = $row_export->$Field_Type;
                        if ($date == "0000-00-00" || $date == "1970-01-01") {
                            $contents .= "<td></td>";
                        } else {
                            $contents .= "<td>" . date("d-M-Y", strtotime($date)) . "</td>";
                        }
                    } else if ($Table_Name == 'tbl_leave_pending') {
                        $el_leave = $row_export->EL;
                        $cl_leave = $row_export->CL;
                        $el_taken = 0;
                        $leave_taken_el = array(
                            'Employee_Id' => $emp_no,
                            'Status' => 1,
                            'Leave_Type' => 1,
                            'Approval' => 'Yes'
                        );
                        $this->db->where($leave_taken_el);
                        $q_leave_taken_el = $this->db->get('tbl_leaves');
                        foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                            $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                            $Leave_From1_el = $row_leave_taken_el->Leave_From;
                            $Leave_To1_el = $row_leave_taken_el->Leave_To;
                            $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                            if ($Leave_Duration_el == "Full Day") {
                                $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                                $No_days_el = $interval_el->format("%a");
                            } else {
                                $No_days_el = 0.5;
                            }
                            $el_taken = $el_taken + $No_days_el;
                        }
                        $el_leave_balance = $el_leave - $el_taken;
                        $leave_taken_cl = array(
                            'Employee_Id' => $emp_no,
                            'Status' => 1,
                            'Leave_Type' => 2,
                            'Approval' => 'Yes'
                        );
                        $this->db->where($leave_taken_cl);
                        $q_leave_taken_cl = $this->db->get('tbl_leaves');
                        $cl_taken = 0;
                        foreach ($q_leave_taken_cl->result() as $row_leave_taken_cl) {
                            $Leave_Duration = $row_leave_taken_cl->Leave_Duration;
                            $Leave_From1 = $row_leave_taken_cl->Leave_From;
                            $Leave_To1 = $row_leave_taken_cl->Leave_To;
                            $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                            if ($Leave_Duration == "Full Day") {
                                $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                $No_days = $interval->format("%a");
                            } else {
                                $No_days = 0.5;
                            }
                            $cl_taken = $cl_taken + $No_days;
                        }
                        $cl_leave_balance = $cl_leave - $cl_taken;
                        if ($Field_Name == "Entitled EL") {
                            $contents .= "<td>$el_leave</td>";
                        }if ($Field_Name == "Entitled CL") {
                            $contents .= "<td>$cl_leave</td>";
                        }if ($Field_Name == "Taken EL") {
                            $contents .= "<td>$el_taken</td>";
                        }if ($Field_Name == "Taken CL") {
                            $contents .= "<td>$cl_taken</td>";
                        }if ($Field_Name == "Balance EL") {
                            $contents .= "<td>$el_leave_balance</td>";
                        } if ($Field_Name == "Balance CL") {
                            $contents .= "<td>$cl_leave_balance</td>";
                        }
                    } else {
                        $contents .= "<td>" . $row_export->$Field_Type . "</td>";
                    }
                }
            }
            $contents .="</tr>";
        }
        $filename = "$Title.xlsx";
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $contents;
    }

    function clear_cache() {
        $this->output->set_header("cache-control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma:no-cache");
    }

}

?>