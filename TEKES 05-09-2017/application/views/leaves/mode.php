<?php
$emp_no = $this->uri->segment(3);
$user_role = $this->session->userdata('user_role');
$this->db->where('employee_number', $emp_no);
$q_code = $this->db->get('tbl_emp_code');
foreach ($q_code->result() as $row_code) {
    $emp_code = $row_code->employee_code;
}

$this->db->where('Emp_Number', $emp_no);
$q_employee = $this->db->get('tbl_employee');
foreach ($q_employee->result() as $row_employee) {
    $employee_name = $row_employee->Emp_FirstName;
    $employee_name .= " " . $row_employee->Emp_LastName;
    $employee_name .= " " . $row_employee->Emp_MiddleName;
    $employee_gender = $row_employee->Emp_Gender;
    $Emp_Doj = $row_employee->Emp_Doj;
}

$this->db->where('Employee_Id', $emp_no);
$q_employee_personal = $this->db->get('tbl_employee_personal');
$count_employee_personal = $q_employee_personal->num_rows();
if ($count_employee_personal > 0) {
    foreach ($q_employee_personal->result() as $row_employee_personal) {
        $Emp_Marrial = $row_employee_personal->Emp_Marrial;
    }
} else {
    $Emp_Marrial = "";
}

$this->db->where('Employee_Id', $emp_no);
$this->db->limit(1);
$emp_q_career = $this->db->get('tbl_employee_career');
foreach ($emp_q_career->result() as $emp_row_career) {
    $emp_designation_id = $emp_row_career->Designation_Id;
    $emp_report_to_id = $emp_row_career->Reporting_To;

    $this->db->where('Designation_Id', $emp_designation_id);
    $q_desig = $this->db->get('tbl_designation');
    foreach ($q_desig->result() as $row_desig) {
        $emp_notice_period = $row_desig->Notice_Period;
    }

    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_name = $row_emp->Emp_FirstName;
        $emp_reporting_name .= " " . $row_emp->Emp_LastName;
        $emp_reporting_name .= " " . $row_emp->Emp_MiddleName;
    }
}

$update_data = array(
    'Emp_read' => 'read'
);
$this->db->where('Employee_Id', $emp_no);
$this->db->update('tbl_leaves', $update_data);

$this->db->order_by('L_Id', 'desc');
$leave_get_data = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($leave_get_data);
$q = $this->db->get('tbl_leaves');

$this->db->where('Status', 1);
$q_leave_type = $this->db->get('tbl_leavetype');

/* Leave Balance Start Here */
$leave_pending_data = array(
    'Emp_Id' => $emp_no,
);
$this->db->where($leave_pending_data);
$q_leave_pending = $this->db->get('tbl_leave_pending');

$leave_taken_el = array(
    'Employee_Id' => $emp_no,
    'Status' => 1,
    'Leave_Type' => 1,
    'Approval' => 'Yes'
);
$this->db->where($leave_taken_el);
$q_leave_taken_el = $this->db->get('tbl_leaves');

$leave_taken_cl = array(
    'Employee_Id' => $emp_no,
    'Status' => 1,
    'Leave_Type' => 2,
    'Approval' => 'Yes'
);
$this->db->where($leave_taken_cl);
$q_leave_taken_cl = $this->db->get('tbl_leaves');

$leave_taken_maternity = array(
    'Employee_Id' => $emp_no,
    'Status' => 1,
    'Leave_Type' => 3,
    'Approval' => 'Yes'
);
$this->db->where($leave_taken_maternity);
$q_leave_taken_maternity = $this->db->get('tbl_leaves');

$leave_taken_paternity = array(
    'Employee_Id' => $emp_no,
    'Status' => 1,
    'Leave_Type' => 4,
    'Approval' => 'Yes'
);
$this->db->where($leave_taken_paternity);
$q_leave_taken_paternity = $this->db->get('tbl_leaves');

/* Leave Balance End Here */

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
    function leave_lop(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_LOPLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_lop_leave").html(html);
            }
        });
    }

    function leave_dislop(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_DisLOPLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_dislop_leave").html(html);
            }
        });
    }

    function leave_compoff(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_CompOff') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_compoff_leave").html(html);
            }
        });
    }

    function leave_entitledcompoff(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_EntitledCompOff') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_entitledcompoff_leave").html(html);
            }
        });
    }

    function delete_leave(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Deleteclleave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                window.location.reload();
            }
        });
    }
    $(document).ready(function () {
        $('#add_newleave_form').submit(function (e) {
            e.preventDefault();
            var approval;
            if (document.getElementById("leave_reply_approval_yes").checked) {
                approval = document.getElementById("leave_reply_approval_yes").value;
            } else {
                approval = document.getElementById("leave_reply_approval_no").value;
            }
            var formdata = {
                apply_leave_emp_id: $('#apply_leave_emp_id').val(),
                apply_leave_reporting_to: $('#apply_leave_reporting_to').val(),
                apply_leave_type: $('#apply_leave_type').val(),
                apply_leave_duration: $('#apply_leave_duration').val(),
                apply_leave_fromdate: $('#apply_leave_fromdate').val(),
                apply_leave_todate: $('#apply_leave_todate').val(),
                apply_leave_reason: $('#apply_leave_reason').val(),
                leave_reply_pattern: $('#leave_reply_pattern').val(),
                approval: approval,
                leave_reply_remarks: $('#leave_reply_remarks').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/apply_newleave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addleave_exists').hide();
                        $('#addleave_error').show();
                    }
                    if (msg == 'success') {
                        $('#addleave_success').show();
                        window.location.reload();
                    }
                    if (msg == 'exists') {
                        $('#addleave_error').hide();
                        $('#addleave_exists').show();
                    }
                }
            });
        });
    });

    function reply_leaves(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/ReplyLeave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                $("#replyleave_form").html(html);
            }
        });
    }
</script>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Leaves : <?php echo $employee_name . "( " . $emp_code . $emp_no . " )" ?></h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick=" history.back();">
                                Back
                                <i class=" entypo-back"></i>
                            </button>
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_newleave').modal('show', {backdrop: 'static'});">
                                Add Leave
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" style="margin-top:15px">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Entitled</th>
                                        <th>Taken</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $el_leave_balance = 0;
                                        foreach ($q_leave_pending->result() as $row_leave_pending) {
                                            $el_leave = $row_leave_pending->EL;
                                            ?>
                                            <td>
                                                <span 
                                                <?php
                                                if ($count < 240) {
                                                    ?>
                                                        style="color: red"
                                                        <?php
                                                    }
                                                    ?>>
                                                    Annual Leave
                                                </span>
                                            </td>
                                            <td>
                                                <span 
                                                <?php
                                                if ($count < 240) {
                                                    ?>
                                                        style="color: red"
                                                        <?php
                                                    }
                                                    ?>>
                                                        <?php echo $el_leave; ?>
                                                </span>
                                            </td>
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
                                            <td>
                                                <span 
                                                <?php
                                                if ($count < 240) {
                                                    ?>
                                                        style="color: red"
                                                        <?php
                                                    }
                                                    ?>>
                                                        <?php echo $el_taken; ?>
                                                </span>
                                            </td>
                                            <td><span 
                                                <?php
                                                if ($count < 240) {
                                                    ?>
                                                        style="color: red"
                                                        <?php
                                                    }
                                                    ?>>
                                                        <?php echo $el_leave_balance; ?>
                                                </span>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>

                                    <tr>
                                        <?php
                                        $cl_leave_balance = 0;
                                        foreach ($q_leave_pending->result() as $row_leave_pending) {
                                            $cl_leave = $row_leave_pending->CL;
                                            ?>
                                            <td>Sick Leave</td>
                                            <td><?php echo $cl_leave; ?></td>
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
                                            <td><?php echo $cl_taken; ?></td>
                                            <td><?php echo $cl_leave_balance; ?></td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php //if ($employee_gender == "Female" && $Emp_Marrial == "Married") { ?>
                                        <!--<tr>
                                    <?php
                                    $maternity_leave_balance = 0;
                                    foreach ($q_leave_pending->result() as $row_leave_pending) {
                                        $maternity_leave = $row_leave_pending->Maternity;
                                        ?>
                                                    <td>Maternity Leave</td>
                                                    <td><?php echo $maternity_leave; ?></td>
                                        <?php
                                        $maternity_taken = 0;
                                        foreach ($q_leave_taken_maternity->result() as $row_leave_taken_maternity) {
                                            $Leave_Duration_Maternity = $row_leave_taken_maternity->Leave_Duration;
                                            $Leave_From1_Maternity = $row_leave_taken_maternity->Leave_From;
                                            $Leave_From_Maternity = date("d-m-Y", strtotime($Leave_From1_Maternity));
                                            $Leave_To1_Maternity = $row_leave_taken_maternity->Leave_To;
                                            $Leave_To_include_Maternity = date('Y-m-d', strtotime($Leave_To1_Maternity . "+1 days"));
                                            $Leave_To_Maternity = date("d-m-Y", strtotime($Leave_To1_Maternity));

                                            if ($Leave_Duration_Maternity == "Full Day") {
                                                $interval_Maternity = date_diff(date_create($Leave_To_include_Maternity), date_create($Leave_From1_Maternity));
                                                $No_days_Maternity = $interval_Maternity->format("%a");
                                            } else {
                                                $No_days_Maternity = 0.5;
                                            }
                                            $maternity_taken = $maternity_taken + $No_days_Maternity;
                                        }
                                        $maternity_leave_balance = $maternity_leave - $maternity_taken;
                                        ?>
                                                    <td><?php echo $maternity_taken; ?></td>
                                                    <td><?php echo $maternity_leave_balance; ?></td>
                                        <?php
                                    }
                                    ?>
                                        </tr>-->
                                    <?php
                                    //} 
                                    /* if ($employee_gender == "Male" && $Emp_Marrial == "Married") { ?>
                                      <tr>
                                      <?php
                                      $paternity_leave_balance = 0;
                                      foreach ($q_leave_pending->result() as $row_leave_pending) {
                                      $paternity_leave = $row_leave_pending->Paternity;
                                      ?>
                                      <td>Paternity Leave</td>
                                      <td><?php echo $paternity_leave; ?></td>
                                      <?php
                                      $paternity_taken = 0;
                                      foreach ($q_leave_taken_paternity->result() as $row_leave_taken_paternity) {
                                      $Leave_Duration_Paternity = $row_leave_taken_paternity->Leave_Duration;
                                      $Leave_From1_Paternity = $row_leave_taken_paternity->Leave_From;
                                      $Leave_From_Paternity = date("d-m-Y", strtotime($Leave_From1_Paternity));
                                      $Leave_To1_Paternity = $row_leave_taken_paternity->Leave_To;
                                      $Leave_To_include_Paternity = date('Y-m-d', strtotime($Leave_To1_Paternity . "+1 days"));
                                      $Leave_To_Paternity = date("d-m-Y", strtotime($Leave_To1_Paternity));

                                      if ($Leave_Duration_Paternity == "Full Day") {
                                      $interval_Paternity = date_diff(date_create($Leave_To_include_Paternity), date_create($Leave_From1_Paternity));
                                      $No_days_Paternity = $interval_Paternity->format("%a");
                                      } else {
                                      $No_days_Paternity = 0.5;
                                      }
                                      $paternity_taken = $paternity_taken + $No_days_Paternity;
                                      }
                                      $paternity_leave_balance = $paternity_leave - $paternity_taken;
                                      ?>
                                      <td><?php echo $paternity_taken; ?></td>
                                      <td><?php echo $paternity_leave_balance; ?></td>
                                      <?php
                                      } */
                                    ?>
                                    </tr>
                                        <?php //}  ?>
                                    <tr>
                                        <?php
                                        $count_leave_entitled_compoff = 0;
                                        $compoff_leave_balance = 0;
                                        $this->db->where('Status', 1);
                                        $q_leave_entitled_compoff = $this->db->get('tbl_compoff');
                                        foreach ($q_leave_entitled_compoff->result() as $row_compoff) {
                                            $compoff_date = $row_compoff->Comp_Date;
                                            $attendance_data = array(
                                                'Login_Date' => $compoff_date,
                                                'Emp_Id' => $emp_no,
                                                'Status' => 1,
                                            );
                                            $this->db->where($attendance_data);
                                            $q_attendance = $this->db->get('tbl_attendance');
                                            $count_attendance = $q_attendance->num_rows();
                                            if ($count_attendance == 1) {
                                                $count_leave_entitled_compoff = $count_leave_entitled_compoff + 1;
                                                $days45 = date("Y-m-d", strtotime("$compoff_date +45 day"));
                                                $current_date_compoff = date('Y-m-d');
                                                if ($current_date_compoff <= $days45) {
                                                    $leave_taken_compoff = array(
                                                        'Emp_Id' => $emp_no,
                                                        'Date >' => $compoff_date,
                                                        'Date <=' => $days45,
                                                        'Status' => 1,
                                                        'Type' => 'Comp Off',
                                                        'Approval' => 'Yes'
                                                    );
                                                    $this->db->where($leave_taken_compoff);
                                                    $q_leave_taken_compoff = $this->db->get('tbl_attendance_mark');
                                                    $count_leave_taken_compoff = $q_leave_taken_compoff->num_rows();
                                                    if ($count_leave_taken_compoff == 0) {
                                                        $compoff_leave_balance = $compoff_leave_balance + 1;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <td>Comp Off</td>
                                        <td>
                                            <a href="#leave_entitledcompoff" data-toggle='modal' onclick="leave_entitledcompoff('<?php echo $emp_no; ?>')"><?php echo $count_leave_entitled_compoff; ?></a>
                                        </td>
                                        <?php
                                        $leave_compoff = array(
                                            'Emp_Id' => $emp_no,
                                            'Status' => 1,
                                            'Type' => 'Comp Off'
                                        );
                                        $this->db->where($leave_compoff);
                                        $q_leave_compoff = $this->db->get('tbl_attendance_mark');
                                        $count_compoff = $q_leave_compoff->num_rows();
                                        ?>
                                        <td>
                                            <a href="#leave_compoff" data-toggle='modal' onclick="leave_compoff('<?php echo $emp_no; ?>')"><?php echo $count_compoff; ?></a>
                                        </td>
                                        <td><?php echo $compoff_leave_balance; ?></td>
                                    </tr>
                                    <tr>
                                        <td>LOP</td>
                                        <?php
                                        $leave_lop = array(
                                            'Emp_Id' => $emp_no,
                                            'Status' => 1,
                                            'Type' => 'LOP'
                                        );
                                        $this->db->where($leave_lop);
                                        $q_leave_lop = $this->db->get('tbl_attendance_mark');
                                        $count_lop = $q_leave_lop->num_rows();
                                        ?>
                                        <td colspan="3">
                                            <a href="#leave_lop" data-toggle='modal' onclick="leave_lop('<?php echo $emp_no; ?>')"><?php echo $count_lop; ?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Disciplinary LOP</td>
                                        <?php
                                        $leave_dislop = array(
                                            'Emp_Id' => $emp_no,
                                            'Status' => 1,
                                            'Type' => 'Disciplinary LOP'
                                        );
                                        $this->db->where($leave_dislop);
                                        $q_leave_dislop = $this->db->get('tbl_attendance_mark');
                                        $count_dislop = $q_leave_dislop->num_rows();
                                        ?>
                                        <td colspan="3">
                                            <a href="#leave_dislop" data-toggle='modal' onclick="leave_dislop('<?php echo $emp_no; ?>')"><?php echo $count_dislop; ?></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Leave Table Format Start Here -->

                    <table class="table table-bordered datatable" id="leave_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Reporting To</th>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Apply Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <?php if ($user_role == 6) { ?>
                                    <th>Action</th>
								<?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $Leave_Id = $row->L_Id;
                                $Reporting_to = $row->Reporting_To;

                                $this->db->where('Emp_Number', $Reporting_to);
                                $q_report_employee = $this->db->get('tbl_employee');
                                foreach ($q_report_employee->result() as $row_report_employee) {
                                    $Report_Emp_FirstName = $row_report_employee->Emp_FirstName;
                                    $Report_Emp_Middlename = $row_report_employee->Emp_MiddleName;
                                    $Report_Emp_LastName = $row_report_employee->Emp_LastName;
                                }

                                $this->db->where('employee_number', $Reporting_to);
                                $q_report_code = $this->db->get('tbl_emp_code');
                                foreach ($q_report_code->result() as $row_report_code) {
                                    $emp_report_code = $row_report_code->employee_code;
                                }

                                $Leave_Type_Id = $row->Leave_Type;
                                $this->db->where('L_Id', $Leave_Type_Id);
                                $q_leave_type1 = $this->db->get('tbl_leavetype');
                                foreach ($q_leave_type1->result() as $row_leave_type1) {
                                    $Leave_Title1 = $row_leave_type1->Leave_Title;
                                }

                                $Leave_Duration = $row->Leave_Duration;
                                $Apply_Date1 = $row->Inserted_Date;
                                $Apply_Date = date("d-M-Y", strtotime($Apply_Date1));
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
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $Report_Emp_FirstName . " " . $Report_Emp_LastName . " " . $Report_Emp_Middlename . ' : ' . $emp_report_code . $Reporting_to; ?></td>
                                    <td><?php echo $Leave_Title1; ?></td>
                                    <td><?php echo $Leave_Duration; ?></td>
                                    <td><?php echo $Apply_Date; ?></td>
                                    <td><?php echo $Leave_From; ?></td>
                                    <td><?php echo $Leave_To; ?></td>
                                    <td><?php echo $No_days; ?></td>
                                    <td><?php echo $Reason; ?></td>
                                    <td>
                                        <?php
                                        if ($Approval == "Request") {
                                            echo "Processing ... ";
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
									<?php if ($user_role == 6) { ?>
                                        <td>
                                            <a data-toggle='modal' href='#reply_leaves' class="btn-default" onclick="reply_leaves(<?php echo $Leave_Id; ?>)">
                                                <i class="entypo-pencil"></i>
                                            </a>
                                            <a class="btn-danger" onclick="delete_leave(<?php echo $Leave_Id; ?>)">
                                                <i class="entypo-cancel"></i>
                                            </a>
                                        </td>
                                <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Leave Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Reply Leave Start Here -->

        <div class="modal fade custom-width" id="reply_leaves">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Leave</h3>
                    </div>
                    <form role="form" id="replyleave_form" name="replyleave_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Add Leave End Here -->

        <!-- Add Leave Start Here -->
        <div class="modal fade custom-width" id="add_newleave">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add Leave</h3>
                    </div>
                    <form role="form" id="add_newleave_form">
                        <div class="modal-body">
                            <div id="emp_data_div">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="font-weight: bold">
                                            <?php
                                            echo "Employee : " . $employee_name . "(" . $emp_code . $emp_no . ")";
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="font-weight: bold">
<?php echo "Reporting To : " . $emp_reporting_name . "(" . $emp_code . $emp_report_to_id . ")"; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        if ($count < 240) {
                                            ?>
                                            <p style="font-weight: bold;color:red"> Annual Leave : <?php echo $el_leave_balance; ?></p>
                                            <?php
                                        } else {
                                            ?>
                                            <p style="font-weight: bold;">
                                                Annual Leave : <?php echo $el_leave_balance; ?>
                                            </p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="font-weight: bold">
                                            Sick Leave : <?php echo $cl_leave_balance; ?>
                                        </p>
                                    </div>

                                    <input type="hidden" name="apply_leave_emp_id" id="apply_leave_emp_id" class="form-control" value="<?php echo $emp_no ?>">
                                    <input type="hidden" name="apply_leave_reporting_to" id="apply_leave_reporting_to" class="form-control" value="<?php echo $emp_report_to_id ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addleave_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addleave_success" class="alert alert-success" style="display:none;">Leave added successfully.</div>
                                    <div id="addleave_error" class="alert alert-danger" style="display:none;">Failed to add leave.</div>
                                    <div id="addleave_exists" class="alert alert-info" style="display:none;">Already entered this leave.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Leave Type</label>
                                        <select name="apply_leave_type" id="apply_leave_type" class="round" data-validate="required">
                                            <?php
                                            foreach ($q_leave_type->result() as $row_leave_type) {
                                                $leavetype_id = $row_leave_type->L_Id;
                                                $leavetype_title = $row_leave_type->Leave_Title;
                                                ?>
                                                <option value="<?php echo $leavetype_id; ?>"><?php echo $leavetype_title; ?></option>
                                                <?php
                                            }
                                            ?>
                                            <option value="LOP">LOP</option>
                                            <option value="Disciplinary LOP">Disciplinary LOP</option>
                                            <option value="Comp Off">Comp Off</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Duration</label>
                                        <select name="apply_leave_duration" id="apply_leave_duration" class="round" data-validate="required" onchange="get_duration(this.value);">
                                            <option value="Full Day">Full Day</option>
                                            <option value="Half Day">Half Day</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">From Date</label>
                                        <div class="input-group">
                                            <input type="text" name="apply_leave_fromdate" id="apply_leave_fromdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select from date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">To Date</label>
                                        <div class="input-group">
                                            <input type="text" name="apply_leave_todate" id="apply_leave_todate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select to date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reason</label>
                                        <textarea name="apply_leave_reason" id="apply_leave_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter reason."></textarea>
                                    </div>	
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Type</label>
                                        <select name="leave_reply_pattern" id="leave_reply_pattern" class="round" data-validate="required">
                                            <option value="Planned Leave">Planned Leave</option>
                                            <option value="Unplanned Leave">Unplanned Leave</option>
                                            <option value="Emergency">Emergency</option>
                                            <option value="Last Minute Call">Last Minute Call</option>
                                            <option value="No Call No Show">No Call No Show</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Manager Approval</label>
                                        <div class="col-md-6">
                                            <div class="radio">
                                                <input type="radio" id="leave_reply_approval_yes" name="approval"  value="Yes" checked>
                                                <label>Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="radio">
                                                <input type="radio" id="leave_reply_approval_no"  name="approval" value="No">
                                                <label>No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Remarks</label>
                                        <textarea name="leave_reply_remarks" id="leave_reply_remarks" class="form-control"></textarea>
                                    </div>	
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Leave End Here -->

        <div class="modal fade custom-width" id="leave_lop">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">LOP Deducted</h3>
                    </div>
                    <form role="form" id="view_lop_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="leave_dislop">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Disciplinary LOP</h3>
                    </div>
                    <form role="form" id="view_dislop_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="leave_compoff">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Comp Off</h3>
                    </div>
                    <form role="form" id="view_compoff_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="leave_entitledcompoff">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Comp Off</h3>
                    </div>
                    <form role="form" id="view_entitledcompoff_leave">

                    </form>
                </div>
            </div>
        </div>
        <!-- Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#leave_table");

                tableContainer.dataTable({
                    "sPaginationType": "bootstrap",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "bStateSave": true,
                    // Responsive Settings
                    bAutoWidth: false,
                    fnPreDrawCallback: function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper) {
                            responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
                        }
                    },
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        responsiveHelper.createExpandIcon(nRow);
                    },
                    fnDrawCallback: function (oSettings) {
                        responsiveHelper.respond();
                    }
                });

                $(".dataTables_wrapper select").select2({
                    minimumResultsForSearch: -1
                });
            });
        </script>

