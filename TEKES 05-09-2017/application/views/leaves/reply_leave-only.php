<?php
$this->db->where('L_Id', $leave_id);
$q = $this->db->get('tbl_leaves');
foreach ($q->result() as $row) {

    $employee_id = $row->Employee_Id;

    $this->db->where('employee_number', $employee_id);
    $q_code = $this->db->get('tbl_emp_code');
    foreach ($q_code->result() as $row_code) {
        $emp_code = $row_code->employee_code;
    }
    $this->db->where('Emp_Number', $employee_id);
    $q_employee = $this->db->get('tbl_employee');
    foreach ($q_employee->result() as $row_employee) {
        $Emp_FirstName = $row_employee->Emp_FirstName;
        $Emp_Middlename = $row_employee->Emp_MiddleName;
        $Emp_LastName = $row_employee->Emp_LastName;
        $Emp_Doj = $row_employee->Emp_Doj;
    }

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
        $total_no_days = $interval->format("%a");
        $No_days = $interval->format("%a") . " Days";
    } else {
        $total_no_days = 0.5;
        $No_days = "Half Day";
    }

    $Leave_Pattern = $row->Leave_Pattern;
    $Leave_Type = $row->Leave_Type;
    $Reason = $row->Reason;
    $Approval = $row->Approval;
    $Remarks = $row->Remarks;
    $Canceled_By = $row->Canceled_By;
    $this->db->where('Emp_Number', $Canceled_By);
    $q_emp_cancel = $this->db->get('tbl_employee');
    foreach ($q_emp_cancel->result() as $row_emp_cancel) {
        $emp_cancel_firstname = $row_emp_cancel->Emp_FirstName;
        $emp_cancel_lastname = $row_emp_cancel->Emp_LastName;
        $emp_cancel_middlename = $row_emp_cancel->Emp_MiddleName;
    }
}
/* Employee Balance Leave Dashboard Start Here */
$leave_pending_data = array(
    'Emp_Id' => $employee_id,
);
$this->db->where($leave_pending_data);
$q_leave_pending = $this->db->get('tbl_leave_pending');

$leave_taken_el = array(
    'Employee_Id' => $employee_id,
    'Status' => 1,
    'Leave_Type' => 1,
    'Approval' => 'Yes'
);
$this->db->where($leave_taken_el);
$q_leave_taken_el = $this->db->get('tbl_leaves');

$leave_taken_cl = array(
    'Employee_Id' => $employee_id,
    'Status' => 1,
    'Leave_Type' => 2,
    'Approval' => 'Yes'
);
$this->db->where($leave_taken_cl);
$q_leave_taken_cl = $this->db->get('tbl_leaves');

/* Employee Balance Leave Dashboard End Here */
// Count 240 days Start here
$current_Date = date('Y-m-d');
$start = strtotime($Emp_Doj);
$end = strtotime($current_Date);
$count = 0;
while (date('Y-m-d', $start) <= date('Y-m-d', $end)) {
    $count += date('N', $start) < 6 ? 1 : 0;
    $start = strtotime("+1 day", $start);
}
?>
<script>
    $(document).ready(function () {
        $('#replyleave_form').submit(function (e) {
            e.preventDefault();
            var approval;
            if (document.getElementById("leave_reply_approval_yes").checked) {
                approval = document.getElementById("leave_reply_approval_yes").value;
            } else {
                approval = document.getElementById("leave_reply_approval_no").value;
            }

            var formdata = {
                leave_id: $('#leave_id').val(),
                emp_id: $('#leave_reply_emp_id').val(),
                leave_reply_type_id: $('#leave_reply_type_id').val(),
                leave_reply_pattern: $('#leave_reply_pattern').val(),
                leave_reply_total_days: $('#leave_reply_total_days').val(),
                approval: approval,
                leave_reply_remarks: $('#leave_reply_remarks').val(),
                leave_reply_type: $('#leave_reply_type').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/reply_leave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {                   
                    if (msg == 'fail') {
                        $('#replyleave_error').show();
                    }
                    if (msg == 'success') {
                        $('#replyleave_success').show();
                        window.location.reload();
                    }

                }

            });
        });
    });
</script>
<div class="modal-body">
    <!-- Employee Balance Leave Dashboard Start here-->
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-5">
            <table class="table table-bordered">
                <!--<thead>
                    <tr>
                        <th>Type</th>
                        <th>Entitled</th>
                        <th>Taken</th>
                        <th>Balance</th>
                    </tr>
                </thead>-->
                <tbody>
                    <tr>
                        <?php
                        $el_leave_balance = 0;
                        foreach ($q_leave_pending->result() as $row_leave_pending) {
                            $el_leave = $row_leave_pending->EL;
                            ?>
                            <!--<td>
                                <span 
                                <?php
                                //if ($count < 240) {
                                    ?>
                                        style="color: red"
                                        <?php
                                    }
                                    ?>>
                                    Annual Leave
                                </span>
                            </td>-->
                            <!--<td>
                                <span 
                                <?php
                                //if ($count < 240) {
                                    ?>
                                        style="color: red"
                                        <?php
                                   // }
                                    ?>>
                                        <?php //echo $el_leave;?>
                                </span>
                            </td>-->
                            <?php
                            $el_taken = 0;
                            foreach ($q_leave_taken_el->result() as $row_leave_taken_el) {
                                $Leave_Duration = $row_leave_taken_el->Leave_Duration;
                                $Leave_From1 = $row_leave_taken_el->Leave_From;
                                $Leave_From = date("d-m-Y", strtotime($Leave_From1));
                                $Leave_To1 = $row_leave_taken_el->Leave_To;
                                $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                                $Leave_To = date("d-m-Y", strtotime($Leave_To1));
                                if ($Leave_Duration == "Full Day") {
                                    $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                    $No_days = $interval->format("%a");
                                } else {
                                    $No_days = 0.5;
                                }
                                $el_taken = $el_taken + $No_days;
                            }
                            $el_leave_balance = $el_leave - $el_taken;
                            ?>
                            <!--<td>
                                <span 
                                <?php
                                //if ($count < 240) {
                                    ?>
                                        style="color: red"
                                        <?php
                                    //}
                                    ?>>
                                        <?php //echo $el_taken;?>
                                </span>
                            </td>-->
                            <!--<td><span 
                                <?php
                                //if ($count < 240) {
                                    ?>
                                        style="color: red"
                                        <?php
                                   // }
                                    ?>>
                                        <?php //echo $el_leave_balance;?>
                                </span>
                            </td>-->
                            <?php
                        //}
                        ?>
                    </tr>

                    <tr>
                        <?php
                        $cl_leave_balance = 0;
                        foreach ($q_leave_pending->result() as $row_leave_pending) {
                            $cl_leave = $row_leave_pending->CL;
                            ?>
                            <!--<td>Casual Leave</td>
                            <td><?php //echo $cl_leave; ?></td>-->
                            <?php
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
                            $cl_leave_balance = $cl_leave - $cl_taken;
                            ?>
                            <!--<td><?php //echo $cl_taken; ?></td>
                            <td><?php //echo $cl_leave_balance; ?></td>-->
                            <?php
                        }
                        ?>
                    </tr>

                    
                    
                </tbody>
            </table>
        </div>
    </div>
    <!-- Employee Balance Leave Dashboard End here-->
    <div class="row">
        <div class="col-md-3">
            <h3> Annual Balance: <?php echo "$el_leave_balance"?></h3>
        </div>
        <div class="col-md-3">
            <h3> Sick Balance: <?php echo "$cl_leave_balance"?></h3>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-10">
            <div id="replyleave_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="replyleave_success" class="alert alert-success" style="display:none;">Leave status sent successfully.</div>
            <div id="replyleave_error" class="alert alert-danger" style="display:none;">Failed to send leave status.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" id="leave_id" name="leave_id" value="<?php echo $leave_id ?>">
        <div class="col-md-6">
            <div class="form-group">
                <label for="field-3" class="control-label">Employee Name : </label>
                <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "( " . $emp_code . $employee_id . ")" ?>
            </div>
        </div>
        <input type="hidden" name="leave_reply_emp_id" id="leave_reply_emp_id" value="<?php echo $employee_id ?>">
        <input type="hidden" name="leave_reply_type_id" id="leave_reply_type_id" value="<?php echo $Leave_Type_Id; ?>">
        <input type="hidden" name="leave_reply_total_days" id="leave_reply_total_days" value="<?php echo $total_no_days; ?>">

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label"><font style="color:#01B1EC;">Leave Type:</font> </label>
                <?php echo $Leave_Title; ?>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Duration : </label>
                <?php echo $Leave_Duration; ?>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">From Date : </label>
                <?php echo $Leave_From; ?>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">To Date : </label>
                <?php echo $Leave_To; ?>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">No of Days : </label>
                <?php echo $No_days; ?>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Reason : </label>
                <?php echo $Reason; ?>
            </div>	
        </div>
    </div>
    <hr/>
    <?php
    if ($Approval == "Cancel") {
        ?>
        <div class="row">
            <div class="col-md-12">
                <strong><?php echo "Leave Canceled by " . $emp_cancel_firstname . " " . $emp_cancel_lastname . " " . $emp_cancel_middlename; ?></strong>
            </div>
        </div>
        <?php
    } else {
        ?>
    
    <div class="row">
        <div class="col-md-2">
                <div class="form-group">
                    <label for="field-1" class="control-label"><font style="color:#01B1EC;"> Leave Type</font></label>
                    <select name="leave_reply_type" id="leave_reply_type" required class="round" placeholder="Leave type" required data-validate="required" data-message-required="Please select Leave type">                                                
                        <option value="">Select Leave</option>
                        <?php
                        $this->db->where('Status', 1);
                        $q_leave_type = $this->db->get('tbl_leavetype');                        
                        foreach ($q_leave_type->result() as $row_leave_type) {
                            $leavetype_id = $row_leave_type->L_Id;
                            $leavetype_title = $row_leave_type->Leave_Title;
                            ?>
                            <option value="<?php echo $leavetype_id; ?>" <?php
                            if ($leavetype_title == $leavetype_id) {
                                echo "selected=selected";
                            }
                            ?>>
                               <?php echo $leavetype_title;?></option>                                                        
                            <?php
                        }
                        ?>
                    </select>
                </div>	
            </div>            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label"><font style="color:#01B1EC;">Patten Type </font></label>
                    <select name="leave_reply_pattern" id="leave_reply_pattern" required class="round" data-validate="required" value="<?php echo $Leave_Pattern; ?>">
                        <option value="Planned Leave">Select Patten Type</option>
                        <option value="Planned Leave">Planned Leave</option>
                        <option value="Unplanned Leave">Unplanned Leave</option>
                        <option value="Emergency">Emergency</option>
                        <option value="Last Minute Call">Last Minute Call</option>
                        <option value="No Call No Show">No Call No Show</option>
                        <!--<option value="Comp Off Leave">Comp Off Leave</option>-->
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Manager Approval</label>
                    <div class="col-md-5">
                        <div class="radio">
                            <input type="radio" id="leave_reply_approval_yes" name="approval"  value="Yes" <?php
                            if ($Approval == "Yes" || $Approval == "Request") {
                                echo "checked";
                            }
                            ?>>
                            <label>Yes</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="radio">
                            <input type="radio" id="leave_reply_approval_no"  name="approval" value="No" <?php
                            if ($Approval == "No") {
                                echo "checked";
                            }
                            ?>>
                            <label>No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-3" class="control-label">Remarks</label>
                    <textarea name="leave_reply_remarks" id="leave_reply_remarks" class="form-control"><?php echo $Remarks; ?></textarea>
                </div>	
            </div>
        </div>
    <?php } ?>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>