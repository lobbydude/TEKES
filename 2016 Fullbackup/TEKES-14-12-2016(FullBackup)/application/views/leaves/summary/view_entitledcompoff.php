<?php
$user_role = $this->session->userdata('user_role');
$this->db->where('Status', 1);
$q_leave_entitled_compoff = $this->db->get('tbl_compoff');
$count_leave_entitled_compoff = $q_leave_entitled_compoff->num_rows();
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-3"></div>
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
                echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $emp_code . $emp_id . ")";
                ?>
            </p>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered datatable" id="leaves_table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if ($count_leave_entitled_compoff > 0) {
                    foreach ($q_leave_entitled_compoff->result() as $row_compoff) {
                        $compoff_date1 = $row_compoff->Comp_Date;
                        $compoff_date = date("d-m-Y", strtotime($compoff_date1));
                        $compoff_title = $row_compoff->Title;
                        $attendance_data = array(
                            'Login_Date' => $compoff_date1,
                            'Emp_Id' => $emp_id,
                            'Status' => 1,
                        );
                        $this->db->where($attendance_data);
                        $q_attendance = $this->db->get('tbl_attendance');
                        $count_attendance = $q_attendance->num_rows();
                        if ($count_attendance == 1) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $compoff_date; ?></td>
                                <td><?php echo $compoff_title; ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


