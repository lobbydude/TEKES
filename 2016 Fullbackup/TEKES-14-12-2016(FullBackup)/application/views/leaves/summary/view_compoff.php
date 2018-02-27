<?php
$user_role = $this->session->userdata('user_role');
$leave_compoff = array(
    'Emp_Id' => $emp_id,
    'Status' => 1,
    'Type' => 'Comp Off'
);
$this->db->where($leave_compoff);
$q_leave_compoff = $this->db->get('tbl_attendance_mark');
$count = $q_leave_compoff->num_rows();
?>
<script>
    function delete_compoffleave(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Deletecompoffleave') ?>",
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
                    <th>Reason</th>
                    <th>Remarks</th>
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
                    foreach ($q_leave_compoff->Result() as $row) {
                        $A_M_Id = $row->A_M_Id;
                        $Leave_From1 = $row->Date;
                        $Leave_From = date("d-m-Y", strtotime($Leave_From1));
                        $Reason = $row->Reason;
                        $Remarks = $row->Remarks;
                        $Approval_Stat = $row->Approval;
                        if($Approval_Stat=="Request"){
                            $Approval_Status="Processing";
                        }
                        if($Approval_Stat=="Yes"){
                            $Approval_Status="Approved";
                        }
                        if($Approval_Stat=="No"){
                            $Approval_Status="Not Approved";
                        }
						if($Approval_Stat=="Cancel"){
                            $Approval_Status="Cancelled";
                        }
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $Leave_From; ?></td>
                            <td><?php echo $Reason;?></td>
                            <td><?php echo $Remarks; ?></td>
                            <td><?php echo $Approval_Status; ?></td>
                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                <td>
                                    <a class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_compoffleave(<?php echo $A_M_Id; ?>)">
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


