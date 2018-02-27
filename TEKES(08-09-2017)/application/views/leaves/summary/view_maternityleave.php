<?php
$user_role = $this->session->userdata('user_role');
$leave_taken_maternity = array(
    'Employee_Id' => $emp_id,
    'Status' => 1,
    'Approval' => 'Yes',
    'Leave_Type' => 3
);
$this->db->where($leave_taken_maternity);
$q_leave_taken_maternity = $this->db->get('tbl_leaves');
$count = $q_leave_taken_maternity->num_rows();
?>
<script>
    function delete_maternityleave(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Deletematernityleave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                window.location.reload();
            }
        });
    }
</script>
<div class="modal-body">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3">
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
                    <th>Type</th>
                    <th>Duration</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>No of Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <?php if ($user_role == 2 || $user_role == 6) { ?>
                        <th>Action</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if ($count > 0) {
                    foreach ($q_leave_taken_maternity->Result() as $row) {
                        $Leave_Id = $row->L_Id;
                        //   $emp_report_to_id = $row->Reporting_To;

                        $Leave_Type_Id = $row->Leave_Type;
                        $this->db->where('L_Id', $Leave_Type_Id);
                        $q_leave_type = $this->db->get('tbl_leavetype');
                        foreach ($q_leave_type->result() as $row_leave_type) {
                            $Leave_Title = $row_leave_type->Leave_Title;
                        }

                        $Leave_Duration = $row->Leave_Duration;
                        $Leave_From1 = $row->Leave_From;
                        $Leave_From = date("d-m-Y", strtotime($Leave_From1));

                        $Leave_To1 = $row->Leave_To;
                        $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                        $Leave_To = date("d-m-Y", strtotime($Leave_To1));

                        if ($Leave_Duration == "Full Day") {
                            $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                            $No_days = $interval->format("%a") . " Days";
                        } else {
                            $No_days = "Half Day";
                        }

                        $Reason = $row->Reason;
                        $Approval = $row->Approval;
                        $status = $row->Status;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $Leave_Title; ?></td>
                            <td><?php echo $Leave_Duration; ?></td>
                            <td><?php echo $Leave_From; ?></td>
                            <td><?php echo $Leave_To; ?></td>
                            <td><?php echo $No_days; ?></td>
                            <td><?php echo $Reason; ?></td>
                            <td>
                                <?php
                                if ($Approval == "Request") {
                                    echo "Processing...";
                                }if ($Approval == "Yes") {
                                    echo "Approved";
                                }if ($Approval == "No") {
                                    echo "Not Approved";
                                }
                                if ($Approval == "Cancel") {
                                    echo "Canceled";
                                }
                                ?>
                            </td>
                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                <td>
                                    <a class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_maternityleave(<?php echo $Leave_Id; ?>)">
                                        <i class="entypo-cancel"></i>
                                        Delete
                                    </a>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php
                        $i++;
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


