<div class="row">
    <div class="col-md-6">
        <p style="font-weight: bold">
            <?php
            $this->db->where('employee_number', $emp_id);
            $q_code = $this->db->get('tbl_emp_code');
            foreach ($q_code->result() as $row_code) {
                $emp_code = $row_code->employee_code;
            }

            $this->db->where('Emp_Number', $emp_id);
            $q_employee = $this->db->get('tbl_employee');
            foreach ($q_employee->result() as $row_employee) {
                $Emp_FirstName = $row_employee->Emp_FirstName;
                $Emp_Middlename = $row_employee->Emp_MiddleName;
                $Emp_LastName = $row_employee->Emp_LastName;
            }

            $this->db->where('Employee_Id', $emp_id);
            $this->db->limit(1);
            $emp_q_career = $this->db->get('tbl_employee_career');
            foreach ($emp_q_career->result() as $emp_row_career) {
                $emp_report_to_id = $emp_row_career->Reporting_To;

                $this->db->where('Emp_Number', $emp_report_to_id);
                $q_emp = $this->db->get('tbl_employee');
                foreach ($q_emp->result() as $row_emp) {
                    $emp_reporting_name = $row_emp->Emp_FirstName;
                    $emp_reporting_name .= " " . $row_emp->Emp_LastName;
                    $emp_reporting_name .= " " . $row_emp->Emp_MiddleName;
                }
            }

            $leave_taken_el = array(
                'Employee_Id' => $emp_id,
                'Status' => 1,
                'Leave_Type' => 1,
                'Approval' => 'Yes'
            );
            $this->db->where($leave_taken_el);
            $q_leave_taken_el = $this->db->get('tbl_leaves');
            $count_el = $q_leave_taken_el->num_rows();
            $el_taken = 0;
            foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                $Leave_Duration_el = $row_leave_taken_el->Leave_Duration;
                $Leave_From1_el = $row_leave_taken_el->Leave_From;
                $Leave_From_el = date("d-m-Y", strtotime($Leave_From1_el));
                $Leave_To1_el = $row_leave_taken_el->Leave_To;
                $Leave_To_include_el = date('Y-m-d', strtotime($Leave_To1_el . "+1 days"));
                $Leave_To_el = date("d-m-Y", strtotime($Leave_To1_el));
                if ($Leave_Duration_el == "Full Day") {
                    $interval_el = date_diff(date_create($Leave_To_include_el), date_create($Leave_From1_el));
                    $No_days_el = $interval_el->format("%a");
                } else {
                    $No_days_el = 0.5;
                }
                $el_taken = $el_taken + $No_days_el;
            }
            $leave_taken_cl = array(
                'Employee_Id' => $emp_id,
                'Status' => 1,
                'Leave_Type' => 2,
                'Approval' => 'Yes'
            );
            $this->db->where($leave_taken_cl);
            $q_leave_taken_cl = $this->db->get('tbl_leaves');
            $count_cl = $q_leave_taken_cl->num_rows();
            $cl_taken = 0;
            foreach ($q_leave_taken_cl->result() as $row_leave_taken_cl) {
                $Leave_Duration = $row_leave_taken_cl->Leave_Duration;
                $Leave_From1 = $row_leave_taken_cl->Leave_From;
                $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                $Leave_To1 = $row_leave_taken_cl->Leave_To;
                $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                if ($Leave_Duration == "Full Day") {
                    $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                    $No_days = $interval->format("%a");
                } else {
                    $No_days = 0.5;
                }
                $cl_taken = $cl_taken + $No_days;
            }

            $leave_pending_data = array(
                'Emp_Id' => $emp_id,
                'Status' => 1
            );
            $this->db->where($leave_pending_data);
            $q_leave_pending = $this->db->get('tbl_leave_pending');
            foreach ($q_leave_pending->result() as $row_leave_pending) {
                $el_leave = $row_leave_pending->EL;
                $cl_leave = $row_leave_pending->CL;
            }

            $el_leave_balance = $el_leave - $el_taken;
            $cl_leave_balance = $cl_leave - $cl_taken;
            echo "Employee : " . $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $emp_code . $emp_id . ")";
            ?>
        </p>
    </div>
    <div class="col-md-6">
        <p style="font-weight: bold">
            <?php echo "Reporting To : " . $emp_reporting_name . "(" . $emp_code . $emp_report_to_id . ")"; ?>
        </p>
    </div>
    <div class="col-md-6">
        <p style="font-weight: bold">
            Annual Leave : <?php echo $el_leave_balance; ?>
        </p>
    </div>
    <div class="col-md-6">
        <p style="font-weight: bold">
            Casual Leave : <?php echo $cl_leave_balance; ?>
        </p>
    </div>

    <input type="hidden" name="apply_leave_emp_id" id="apply_leave_emp_id" class="form-control" value="<?php echo $emp_id ?>">
    <input type="hidden" name="apply_leave_reporting_to" id="apply_leave_reporting_to" class="form-control" value="<?php echo $emp_report_to_id ?>">
</div>


