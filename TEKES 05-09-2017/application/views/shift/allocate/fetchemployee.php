<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#shift_emp_id').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<div class="form-group">
    <label for="field-1" class="control-label">Employee Name</label>                                        
    <select name="shift_emp_id[]" id="shift_emp_id" data-validate="required" class="round" data-message-required="Employee Name" multiple>
        <?php
// Emp Name & Number get tbl_employee table
        $this->db->where('Status', 1);
        $q_employee = $this->db->get('tbl_employee');
        foreach ($q_employee->result() as $row_employee) {
            $Emp_Number = $row_employee->Emp_Number;
            $Emp_FirstName = $row_employee->Emp_FirstName;
            $Emp_Middlename = $row_employee->Emp_MiddleName;
            $Emp_LastName = $row_employee->Emp_LastName;

            $get_empl_code = array(
                "employee_number" => $Emp_Number,
                "Status" => 1
            );
            $this->db->where($get_empl_code);
            $q_emp_code = $this->db->get('tbl_emp_code');
            foreach ($q_emp_code->result() as $row_emp_code) {
                $emp_code = $row_emp_code->employee_code;
            }
            // Allocation        
            $get_fetch_emp = array(
                "Year" => $Year,
                "Month" => $Month,
                "Employee_Id" => $Emp_Number,
                "Status" => 1
            );
            $this->db->where($get_fetch_emp);
            $shift_get_carry_data = $this->db->get('tbl_shift_allocate');
            $count_fetch_emp = $shift_get_carry_data->num_rows();
            if ($count_fetch_emp == '0') {
                ?>
                <option value="<?php echo $Emp_Number; ?>"><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $emp_code . $Emp_Number . ")" ?></option>
                <?php
            }
        }
        ?>
    </select>
</div>