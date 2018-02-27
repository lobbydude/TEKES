<?php
$emp_no = $this->session->userdata('username');

$this->db->where('employee_number', $emp_no);
$q_code = $this->db->get('tbl_emp_code');
foreach ($q_code->result() as $row_code) {
    $emp_code = $row_code->employee_code;
}

$this->db->where('Emp_Number', $emp_no);
$q_employee = $this->db->get('tbl_employee');
foreach ($q_employee->result() as $row_employee) {
    $Emp_Doj = $row_employee->Emp_Doj;
    $employee_gender = $row_employee->Emp_Gender;
}

$this->db->where('Employee_Id', $emp_no);
$q_employee_personal = $this->db->get('tbl_employee_personal');
foreach ($q_employee_personal->result() as $row_employee_personal) {
    $Emp_Marrial = $row_employee_personal->Emp_Marrial;
}

$this->db->where('Employee_Id', $emp_no);
$this->db->limit(1);
$emp_q_career = $this->db->get('tbl_employee_career');
foreach ($emp_q_career->result() as $emp_row_career) {
    $emp_designation_id = $emp_row_career->Designation_Id;
    $emp_report_to_id = $emp_row_career->Reporting_To;

    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_name = $row_emp->Emp_FirstName;
    }
}

$update_data = array(
    'Emp_read' => 'read'
);
$this->db->where('Employee_Id', $emp_no);
$this->db->update('tbl_leaves', $update_data);

$this->db->order_by('L_Id', 'desc');
$get_leave_data = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($get_leave_data);
$q = $this->db->get('tbl_leaves');

$this->db->where('Status', 1);
$q_leave_type = $this->db->get('tbl_leavetype');

/* Leave Balance Start Here */
$leave_pending_data = array(
    'Emp_Id' => $emp_no,
    'Status' => 1
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
?>

<script>
    $(document).ready(function () {
        $('#addleave_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_leave_reporting_to: $('#add_leave_reporting_to').val(),
                add_leave_type: $('#add_leave_type').val(),
                add_leave_duration: $('#add_leave_duration').val(),
                // add_leave_pattern: $('#add_leave_pattern').val(),
                add_leave_fromdate: $('#add_leave_fromdate').val(),
                add_leave_todate: $('#add_leave_todate').val(),
                add_leave_reason: $('#add_leave_reason').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/apply_leave') ?>",
                type: 'post',
                data: formdata,
                success: function (html) {
                    //alert("Your Leave Successfully Applyed");
                    window.location.reload();
                }


                /*success: function (msg) {
                 if (msg == 'fail') {
                 $('#applyleave_error').show();
                 }
                 if (msg == 'success') {
                 $('#applyleave_success').show();
                 window.location.reload();
                 }
                 }*/

            });
        });
    });

    function leave_status(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/ViewLeave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                $("#leave_status_form").html(html);
            }
        });
    }

    function cancel_leave(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/CancelLeave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                $("#cancel_leave_form").html(html);
            }
        });
    }

    function get_duration(duration) {
        if (duration == "Half Day") {
            $("#add_leave_todate").prop("disabled", true);
        } else {
            $("#add_leave_todate").prop("disabled", false);
        }
    }

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
</script>


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Leaves</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#apply_leave').modal('show', {backdrop: 'static'});">
                                Apply Leave
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
                                    <?php
                                    $current_Date = date('Y-m-d');
                                    $start = strtotime($Emp_Doj);
                                    $end = strtotime($current_Date);
                                    $count = 0;
                                    while (date('Y-m-d', $start) <= date('Y-m-d', $end)) {
                                        $count += date('N', $start) < 6 ? 1 : 0;
                                        $start = strtotime("+1 day", $start);
                                    }
                                    if ($count >= 240) {
                                        ?>
                                        <tr>
                                            <?php
                                            $el_leave_balance = 0;
                                            foreach ($q_leave_pending->result() as $row_leave_pending) {
                                                $el_leave = $row_leave_pending->EL;
                                                ?>
                                                <td>Annual Leave</td>
                                                <td><?php echo $el_leave; ?></td>
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
                                                <td><?php echo $el_taken; ?></td>
                                                <td><?php echo $el_leave_balance; ?></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <?php
                                        $cl_leave_balance = 0;
                                        foreach ($q_leave_pending->result() as $row_leave_pending) {
                                            $cl_leave = $row_leave_pending->CL;
                                            ?>
                                            <td>Casual Leave</td>
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
                                    <?php if ($employee_gender == "Female" && $Emp_Marrial == "Married") { ?>
                                        <tr>
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
                                        </tr>
                                    <?php } if ($employee_gender == "Male" && $Emp_Marrial == "Married") { ?>
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
                                            }
                                            ?>
                                        </tr>
                                    <?php } ?>
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
                                        <td><a href="#leave_entitledcompoff" data-toggle='modal' onclick="leave_entitledcompoff('<?php echo $emp_no; ?>')"><?php echo $count_leave_entitled_compoff; ?></a></td>
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
                                <th>Pattern</th>
                                <th>Apply Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Action</th>
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
                                $Leave_Pattern = $row->Leave_Pattern;
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
                                    <td><?php echo $Leave_Pattern; ?></td>
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
                                    <td>
                                        <a data-toggle='modal' href='#leave_status' class="btn btn-default btn-sm btn-icon icon-left" onclick="leave_status(<?php echo $Leave_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            View
                                        </a>
                                        <?php if ((date("Y-m-d")) <= $Leave_From1) { ?>
                                            <a data-toggle='modal' href='#cancel_leave' class="btn btn-danger btn-sm btn-icon icon-left" onclick="cancel_leave(<?php echo $Leave_Id; ?>)">
                                                <i class="entypo-cancel"></i>
                                                Cancel
                                            </a>
                                        <?php } ?>
                                    </td>
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

        <!-- Add Leave Start Here -->

        <div class="modal fade custom-width" id="apply_leave">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Apply Leave</h3>
                    </div>
                    <form role="form" id="addleave_form" name="addleave_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addleave_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addleave_success" class="alert alert-success" style="display:none;">Leave applied successfully.</div>
                                    <div id="addleave_error" class="alert alert-danger" style="display:none;">Failed to apply leave.</div>
                                </div>
                            </div>

                            <div class="row">
                                <?php if ($count >= 240) { ?>
                                    <div class="col-md-4">
                                        <label class="control-label">EL Balance : </label> <?php echo $el_leave_balance; ?>
                                    </div>
                                <?php } ?>
                                <div class="col-md-4">
                                    <label class="control-label">CL Balance : </label> <?php echo $cl_leave_balance; ?>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 20px;"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reporting To</label>
                                        <input type="text" class="form-control" value="<?php echo $emp_reporting_name . " (" . $emp_code . $emp_report_to_id . ")"; ?>" disabled="disabled">
                                        <input type="hidden" name="add_leave_reporting_to" id="add_leave_reporting_to" class="form-control" value="<?php echo $emp_report_to_id ?>" disabled="disabled">
                                    </div>	
                                </div>
                                <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:13%;left:50%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Leave Type</label>
                                        <select name="add_leave_type" id="add_leave_type" class="round" data-validate="required" data-message-required="Please select Leave type">
                                            <option value="">Select Leave Type</option>
                                            <?php
                                            if ($count >= 240) {
                                                $this->db->where('Status', 1);
                                                $q_leave_type = $this->db->get('tbl_leavetype');
                                                foreach ($q_leave_type->result() as $row_leave_type) {
                                                    $leavetype_id = $row_leave_type->L_Id;
                                                    $leavetype_title = $row_leave_type->Leave_Title;
                                                    ?>
                                                    <option value="<?php echo $leavetype_id; ?>"><?php echo $leavetype_title; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                $get_leave_type_data = array(
                                                    'L_Id !=' => 1,
                                                    'Status' => 1
                                                );
                                                $this->db->where($get_leave_type_data);
                                                $q_leave_type = $this->db->get('tbl_leavetype');
                                                foreach ($q_leave_type->result() as $row_leave_type) {
                                                    $leavetype_id = $row_leave_type->L_Id;
                                                    $leavetype_title = $row_leave_type->Leave_Title;
                                                    ?>
                                                    <option value="<?php echo $leavetype_id; ?>"><?php echo $leavetype_title; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($compoff_leave_balance > 0) {
                                                ?>
                                                <option value="Comp Off">Comp Off</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Duration</label>
                                        <select name="add_leave_duration" id="add_leave_duration" class="round" onchange="get_duration(this.value);" data-validate="required" data-message-required="Please select duration type">
                                            <option value="">Select Duration Type</option>
                                            <option value="Full Day">Full Day</option>
                                            <option value="Half Day">Half Day</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">From Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_leave_fromdate" id="add_leave_fromdate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select from date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">To Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_leave_todate" id="add_leave_todate" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select to date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reason</label>
                                        <textarea name="add_leave_reason" id="add_leave_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter reason."></textarea>
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


        <!-- Leave Status Start Here -->

        <div class="modal fade custom-width" id="leave_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Leave</h3>
                    </div>
                    <form role="form" id="leave_status_form" name="leave_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Leave Status End Here -->

        <!-- Leave Cancel Start Here -->

        <div class="modal fade" id="cancel_leave">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Cancel Leave</h3>
                    </div>                                                    
                    <form role="form" id="cancel_leave_form" name="cancel_leave_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Leave Cancel End Here -->

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
