<?php
$user_role = $this->session->userdata('user_role');
$this->db->where('Status', 1);
$q_leave_type = $this->db->get('tbl_leavetype');
$count_leave_type = $q_leave_type->num_rows();
?>

<script>
    function el_taken(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_ELLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_el_leave").html(html);
            }
        });
    }

    function cl_taken(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_CLLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_cl_leave").html(html);
            }
        });
    }

    function maternity_taken(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_MaternityLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_maternity_leave").html(html);
            }
        });
    }

    function paternity_taken(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_PaternityLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_paternity_leave").html(html);
            }
        });
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

    function leave_yetlop(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/View_YetLOPLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_yetlop_leave").html(html);
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
            url: "<?php echo site_url('Leaves/View_CompOffLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#view_compoff_leave").html(html);
            }
        });
    }

    function add_newleave(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/Add_NewLeave') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#emp_data_div").html(html);
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

    function get_duration(duration) {
        if (duration == "Half Day") {
            $("#apply_leave_todate").prop("disabled", true);
        } else {
            $("#apply_leave_todate").prop("disabled", false);
        }
    }

</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Leave Summary</h2>
                        </div>
                        <?php
                        if ($user_role == 2 || $user_role == 6) {
                            ?>
                            <div class="panel-options">
                                <a href="<?php echo site_url('Leaves/export_leave') ?>" style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                    Export
                                    <i class="entypo-export"></i>
                                </a>
                            </div>
                        <?php } if ($user_role == 1) {
                            ?>
                            <div class="panel-options">
                                <a href="<?php echo site_url('Leaves/export_leave_manager') ?>" style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                    Export
                                    <i class="entypo-export"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Summary Table Format Start Here -->

                    <table class="table table-bordered datatable" id="summary_table">
                        <thead>
                            <tr>
                                <th rowspan="2" style="border: 2px solid #000;"><p>Employee Id</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p>Employee Name</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p>No Of Days</p></th>
								<th colspan="<?php echo $count_leave_type; ?>" style="text-align: center;border: 2px solid #009900;">Entitled Leave</th>
								<th colspan="<?php echo $count_leave_type; ?>" style="text-align: center;border: 2px solid #009900;">Leave Taken</th>
								<th colspan="<?php echo $count_leave_type; ?>" style="text-align: center;border: 2px solid #009900;">Balance Leave</th>
								<th rowspan="2" style="border: 2px solid #000;"><p class='vertical-align-leave'>Accumulation</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p class='vertical-align-leave'>Bal. Accumulation</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p class='vertical-align-leave'>LOP Deducted</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p class='vertical-align-leave'>Yet to Deduct LOP</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p class='vertical-align-leave'>Disciplinary LOP</p></th>
								<th rowspan="2" style="border: 2px solid #000;"><p class='vertical-align-leave'>Comp Off</p></th>
								<?php if ($user_role == 6) { ?>
								<th rowspan="2" style="border: 2px solid #000;"><p>Actions</p></th>
								<?php } ?>
							</tr>
							<tr>
								<?php
								for ($no = 1; $no < 4; $no++) {
									foreach ($q_leave_type->result() as $row_leave_type) {
										$leavetype_id = $row_leave_type->L_Id;
										$leavetype_title = $row_leave_type->Leave_Title;
                                    ?>
                                    <th <?php if($no==1){ echo "style='border: 2px solid #009900'";}if($no==2){ echo "style='border: 2px solid #990000'";}if($no==3){ echo "style='border: 2px solid #000099'";} ?>><p class='vertical-align-leave'><?php echo $leavetype_title; ?></p></th>
                                <?php
									}
								}
								?>
							</tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 2 || $user_role == 6) {
                                $i = 1;
                                $this->db->where('Status', 1);
                                $q_emp = $this->db->get('tbl_employee');
                                foreach ($q_emp->Result() as $row) {
                                    $emp_id = $row->Employee_Id;
                                    $emp_no = $row->Emp_Number;

                                    $this->db->where('employee_number', $emp_no);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->Result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }

                                    $emp_firstname = $row->Emp_FirstName;
                                    $emp_middlename = $row->Emp_MiddleName;
                                    $emp_lastname = $row->Emp_LastName;
                                    $emp_gender = $row->Emp_Gender;
                                    $this->db->where('Employee_Id', $emp_no);
                                    $q_employee_personal = $this->db->get('tbl_employee_personal');
                                    foreach ($q_employee_personal->result() as $row_employee_personal) {
                                        $Emp_Marrial = $row_employee_personal->Emp_Marrial;
                                    }
                                    $Emp_Doj = $row->Emp_Doj;
                                    $current_Date = date('Y-m-d');
                                    $start = strtotime($Emp_Doj);
                                    $end = strtotime($current_Date);
                                    $count = 0;
                                    while (date('Y-m-d', $start) <= date('Y-m-d', $end)) {
                                        $count += date('N', $start) < 6 ? 1 : 0;
                                        $start = strtotime("+1 day", $start);
                                    }
                                    $leave_pending_data = array(
                                        'Emp_Id' => $emp_no,
                                        'Status' => 1
                                    );
                                    $this->db->where($leave_pending_data);
                                    $q_leave_pending = $this->db->get('tbl_leave_pending');
                                    foreach ($q_leave_pending->result() as $row_leave_pending) {
                                        $el_leave = $row_leave_pending->EL;
                                        $cl_leave = $row_leave_pending->CL;
                                        $maternity_leave = $row_leave_pending->Maternity;
                                        $paternity_leave = $row_leave_pending->Paternity;
                                        $Accumulation = $row_leave_pending->Accumulation;
                                        $Bal_Accumulation = $row_leave_pending->Bal_Accumulation;
                                        ?>
                                        <tr>
                                            <td style="border: 2px solid #000;"><?php echo $emp_code . $emp_no; ?></td>
                                            <td style="border: 2px solid #000;"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                            <td style="border: 2px solid #000;">
                                                <span
                                                <?php
                                                if ($count < 240) {
                                                    ?>
                                                        style="color: red"
                                                        <?php
                                                    }
                                                    ?>>
                                                        <?php echo $count; ?>
                                                </span>
                                            </td>
                                            <td style="border: 2px solid #009900;">
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
                                            <td style="border: 2px solid #009900;"><?php echo $cl_leave; ?></td>
                                            <td style="border: 2px solid #009900;">
                                                <?php if ($emp_gender == "Female" && $Emp_Marrial == "Married") { ?>
                                                    <?php echo $maternity_leave; ?>
                                                <?php } ?>
                                            </td style="border: 2px solid #009900;">
                                            <td style="border: 2px solid #009900;">
                                                <?php if ($emp_gender == "Male" && $Emp_Marrial == "Married") { ?>
                                                    <?php echo $paternity_leave; ?>
                                                <?php } ?>
                                            </td>
                                            <td style="border: 2px solid #990000;">
                                                <?php
                                                $el_taken = 0;
                                                $leave_taken_el = array(
                                                    'Employee_Id' => $emp_no,
                                                    'Status' => 1,
                                                    'Leave_Type' => 1,
                                                    'Approval' => 'Yes'
                                                );
                                                $this->db->where($leave_taken_el);
                                                $q_leave_taken_el = $this->db->get('tbl_leaves');
                                                $count_el = $q_leave_taken_el->num_rows();

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
                                                $el_leave_balance = $el_leave - $el_taken;
                                                ?>
                                                <a href="#el_taken" data-toggle='modal' onclick="el_taken('<?php echo $emp_no; ?>')"><?php echo $el_taken; ?></a>
                                            </td>
                                            <td style="border: 2px solid #990000;">
                                                <?php
                                                $leave_taken_cl = array(
                                                    'Employee_Id' => $emp_no,
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
                                                $cl_leave_balance = $cl_leave - $cl_taken;
                                                ?>
                                                <a href="#cl_taken" data-toggle='modal' onclick="cl_taken('<?php echo $emp_no; ?>')"><?php echo $cl_taken; ?></a>
                                            </td>
                                            <td style="border: 2px solid #990000;">
                                                <?php
                                                $leave_taken_maternity = array(
                                                    'Employee_Id' => $emp_no,
                                                    'Status' => 1,
                                                    'Leave_Type' => 3,
                                                    'Approval' => 'Yes'
                                                );
                                                $this->db->where($leave_taken_maternity);
                                                $q_leave_taken_maternity = $this->db->get('tbl_leaves');
                                                $count_maternity = $q_leave_taken_maternity->num_rows();
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
                                                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                    ?>
                                                    <a href="#maternity_taken" data-toggle='modal' onclick="maternity_taken('<?php echo $emp_no; ?>')"><?php echo $maternity_taken; ?></a>
                                                <?php } ?>
                                            </td>
                                            <td style="border: 2px solid #990000;">
                                                <?php
                                                $leave_taken_paternity = array(
                                                    'Employee_Id' => $emp_no,
                                                    'Status' => 1,
                                                    'Leave_Type' => 4,
                                                    'Approval' => 'Yes'
                                                );
                                                $this->db->where($leave_taken_paternity);
                                                $q_leave_taken_paternity = $this->db->get('tbl_leaves');
                                                $count_paternity = $q_leave_taken_paternity->num_rows();
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
                                                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                    ?>
                                                    <a href="#paternity_taken" data-toggle='modal' onclick="paternity_taken('<?php echo $emp_no; ?>')"><?php echo $paternity_taken; ?></a>
                                                <?php } ?>
                                            </td>
                                            <td style="border: 2px solid #000099;"><?php echo $el_leave_balance; ?></td>
                                            <td style="border: 2px solid #000099;"><?php echo $cl_leave_balance; ?></td>
                                            <td style="border: 2px solid #000099;">
                                                <?php
                                                if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                    echo $maternity_leave_balance;
                                                }
                                                ?>
                                            </td>
                                            <td style="border: 2px solid #000099;">
                                                <?php
                                                if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                    echo $paternity_leave_balance;
                                                }
                                                ?>
                                            </td>
                                            <td style="border: 2px solid #000;"><?php echo $Accumulation; ?></td>
                                            <td style="border: 2px solid #000;"><?php echo $Bal_Accumulation; ?></td>
                                            <td style="border: 2px solid #000;">
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
                                                <a href="#leave_lop" data-toggle='modal' onclick="leave_lop('<?php echo $emp_no; ?>')"><?php echo $count_lop; ?></a>
                                            </td>
                                            <td style="border: 2px solid #000;">
                                                <?php
                                                $yet_lop_count = 0;
                                                $leave_yet_lop = array(
                                                    'Emp_Id' => $emp_no,
                                                    'Status' => 1,
                                                    'Type' => 'LOP'
                                                );
                                                $this->db->where($leave_yet_lop);
                                                $q_leave_yet_lop = $this->db->get('tbl_attendance_mark');
                                                $count_yet_lop = $q_leave_lop->num_rows();
                                                if ($count_yet_lop > 0) {
                                                    $last_month_date = new DateTime(date('Y-' . (date('m') - 1) . '-20'));
                                                    $current_month_date = new DateTime(date('Y-m-19'));
                                                    foreach ($q_leave_yet_lop->result() as $row_leave_yet_lop) {
                                                        $yet_lop_date = new DateTime($row_leave_yet_lop->Date);
                                                        if (($last_month_date <= $yet_lop_date) && ($current_month_date >= $yet_lop_date)) {
                                                            $yet_lop_count = 1 + $yet_lop_count;
                                                        }
                                                    }
                                                    ?>
                                                    <a href="#leave_yetlop" data-toggle='modal' onclick="leave_yetlop('<?php echo $emp_no; ?>')"><?php echo $yet_lop_count; ?></a>
                                                <?php } else {
                                                    ?>
                                                    0
                                                <?php }
                                                ?>
                                            </td>
                                            <td style="border: 2px solid #000;">
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
                                                <a href="#leave_dislop" data-toggle='modal' onclick="leave_dislop('<?php echo $emp_no; ?>')"><?php echo $count_dislop; ?></a>
                                            </td>
                                            <td style="border: 2px solid #000;">
                                                <?php
                                                $leave_compoff = array(
                                                    'Emp_Id' => $emp_no,
                                                    'Status' => 1,
                                                    'Approval' => 'Yes',
                                                    'Type' => 'Comp Off'
                                                );
                                                $this->db->where($leave_compoff);
                                                $q_leave_compoff = $this->db->get('tbl_attendance_mark');
                                                $count_compoff = $q_leave_compoff->num_rows();
                                                ?>
                                                <a href="#leave_compoff" data-toggle='modal' onclick="leave_compoff('<?php echo $emp_no; ?>')"><?php echo $count_compoff; ?></a>
                                            </td>
                                            <?php if ($user_role == 6) { ?>
                                                <td style="border: 2px solid #000;">
                                                    <a href="#add_newleave" data-toggle='modal' class="btn btn-default btn-sm btn-icon icon-left" onclick="add_newleave('<?php echo $emp_no; ?>')">
                                                        <i class="entypo-pencil"></i>
                                                        Edit
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }if ($user_role == 1) {
                                $i = 1;
                                $report_id = $this->session->userdata('username');
                                $this->db->group_by('Employee_Id');
                                $data_report = array(
                                    'Reporting_To' => $report_id,
                                    'Status' => 1
                                );
                                $this->db->where($data_report);
                                $q_emp_report = $this->db->get('tbl_employee_career');
                                foreach ($q_emp_report->Result() as $row_emp_report) {
                                    $employee_id = $row_emp_report->Employee_Id;
                                    $data_emp = array(
                                        'Emp_Number' => $employee_id,
                                        'Status' => 1
                                    );
                                    $this->db->where($data_emp);
                                    $q_emp = $this->db->get('tbl_employee');
                                    foreach ($q_emp->Result() as $row) {
                                        $emp_id = $row->Employee_Id;
                                        $emp_no = $row->Emp_Number;

                                        $this->db->where('employee_number', $emp_no);
                                        $q_code = $this->db->get('tbl_emp_code');
                                        foreach ($q_code->Result() as $row_code) {
                                            $emp_code = $row_code->employee_code;
                                        }

                                        $emp_firstname = $row->Emp_FirstName;
                                        $emp_middlename = $row->Emp_MiddleName;
                                        $emp_lastname = $row->Emp_LastName;
                                        $Emp_Doj = $row->Emp_Doj;
                                        $emp_gender = $row->Emp_Gender;
                                        $this->db->where('Employee_Id', $emp_no);
                                        $q_employee_personal = $this->db->get('tbl_employee_personal');
                                        foreach ($q_employee_personal->result() as $row_employee_personal) {
                                            $Emp_Marrial = $row_employee_personal->Emp_Marrial;
                                        }
                                        $current_Date = date('Y-m-d');
                                        $start = strtotime($Emp_Doj);
                                        $end = strtotime($current_Date);
                                        $count = 0;
                                        while (date('Y-m-d', $start) <= date('Y-m-d', $end)) {
                                            $count += date('N', $start) < 6 ? 1 : 0;
                                            $start = strtotime("+1 day", $start);
                                        }
                                        $leave_pending_data = array(
                                            'Emp_Id' => $emp_no,
                                            'Status' => 1
                                        );
                                        $this->db->where($leave_pending_data);
                                        $q_leave_pending = $this->db->get('tbl_leave_pending');
                                        foreach ($q_leave_pending->result() as $row_leave_pending) {
                                            $el_leave = $row_leave_pending->EL;
                                            $cl_leave = $row_leave_pending->CL;
                                            $maternity_leave = $row_leave_pending->Maternity;
                                            $paternity_leave = $row_leave_pending->Paternity;
                                            $Accumulation = $row_leave_pending->Accumulation;
                                            $Bal_Accumulation = $row_leave_pending->Bal_Accumulation;
                                            ?>
                                            <tr>
                                                <td><?php echo $emp_code . $emp_no; ?></td>
                                                <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $el_leave; ?></td>
                                                <td><?php echo $cl_leave; ?></td>
                                                <td>
                                                    <?php if ($emp_gender == "Female" && $Emp_Marrial == "Married") { ?>
                                                        <?php echo $maternity_leave; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($emp_gender == "Male" && $Emp_Marrial == "Married") { ?>
                                                        <?php echo $paternity_leave; ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $el_taken = 0;
                                                    $leave_taken_el = array(
                                                        'Employee_Id' => $emp_no,
                                                        'Status' => 1,
                                                        'Leave_Type' => 1,
                                                        'Approval' => 'Yes'
                                                    );
                                                    $this->db->where($leave_taken_el);
                                                    $q_leave_taken_el = $this->db->get('tbl_leaves');
                                                    $count_el = $q_leave_taken_el->num_rows();

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
                                                    $el_leave_balance = $el_leave - $el_taken;
                                                    ?>
                                                    <a href="#el_taken" data-toggle='modal' onclick="el_taken('<?php echo $emp_no; ?>')"><?php echo $el_taken; ?></a>
                                                </td>
                                                <td>
                                                    <?php
                                                    $leave_taken_cl = array(
                                                        'Employee_Id' => $emp_no,
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
                                                    $cl_leave_balance = $cl_leave - $cl_taken;
                                                    ?>
                                                    <a href="#cl_taken" data-toggle='modal' onclick="cl_taken('<?php echo $emp_no; ?>')"><?php echo $cl_taken; ?></a>
                                                </td>
                                                <td>
                                                    <?php
                                                    $leave_taken_maternity = array(
                                                        'Employee_Id' => $emp_no,
                                                        'Status' => 1,
                                                        'Leave_Type' => 3,
                                                        'Approval' => 'Yes'
                                                    );
                                                    $this->db->where($leave_taken_maternity);
                                                    $q_leave_taken_maternity = $this->db->get('tbl_leaves');
                                                    $count_maternity = $q_leave_taken_maternity->num_rows();
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
                                                    if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                        ?>
                                                        <a href="#maternity_taken" data-toggle='modal' onclick="maternity_taken('<?php echo $emp_no; ?>')"><?php echo $maternity_taken; ?></a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $leave_taken_paternity = array(
                                                        'Employee_Id' => $emp_no,
                                                        'Status' => 1,
                                                        'Leave_Type' => 4,
                                                        'Approval' => 'Yes'
                                                    );
                                                    $this->db->where($leave_taken_paternity);
                                                    $q_leave_taken_paternity = $this->db->get('tbl_leaves');
                                                    $count_paternity = $q_leave_taken_paternity->num_rows();
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
                                                    if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                        ?>
                                                        <a href="#paternity_taken" data-toggle='modal' onclick="paternity_taken('<?php echo $emp_no; ?>')"><?php echo $paternity_taken; ?></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $el_leave_balance; ?></td>
                                                <td><?php echo $cl_leave_balance; ?></td>
                                                <td>
                                                    <?php
                                                    if ($emp_gender == "Female" && $Emp_Marrial == "Married") {
                                                        echo $maternity_leave_balance;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($emp_gender == "Male" && $Emp_Marrial == "Married") {
                                                        echo $paternity_leave_balance;
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $Accumulation; ?></td>
                                                <td><?php echo $Bal_Accumulation; ?></td>
                                                <td>
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
                                                    <a href="#leave_lop" data-toggle='modal' onclick="leave_lop('<?php echo $emp_no; ?>')"><?php echo $count_lop; ?></a>
                                                </td>
                                                <td>
                                                    <?php
                                                    $yet_lop_count = 0;
                                                    $leave_yet_lop = array(
                                                        'Emp_Id' => $emp_no,
                                                        'Status' => 1,
                                                        'Type' => 'LOP'
                                                    );
                                                    $this->db->where($leave_yet_lop);
                                                    $q_leave_yet_lop = $this->db->get('tbl_attendance_mark');
                                                    $count_yet_lop = $q_leave_lop->num_rows();
                                                    if ($count_yet_lop > 0) {
                                                        $last_month_date = new DateTime(date('Y-' . (date('m') - 1) . '-20'));
                                                        $current_month_date = new DateTime(date('Y-m-19'));
                                                        foreach ($q_leave_yet_lop->result() as $row_leave_yet_lop) {
                                                            $yet_lop_date = new DateTime($row_leave_yet_lop->Date);
                                                            if (($last_month_date <= $yet_lop_date) && ($current_month_date >= $yet_lop_date)) {
                                                                $yet_lop_count = 1 + $yet_lop_count;
                                                            }
                                                        }
                                                        ?>
                                                        <a href="#leave_yetlop" data-toggle='modal' onclick="leave_yetlop('<?php echo $emp_no; ?>')"><?php echo $yet_lop_count; ?></a>
                                                    <?php } else {
                                                        ?>
                                                        0
                                                    <?php }
                                                    ?>
                                                </td>
                                                <td>
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
                                                    <a href="#leave_dislop" data-toggle='modal' onclick="leave_dislop('<?php echo $emp_no; ?>')"><?php echo $count_dislop; ?></a>
                                                </td>
                                                <td>
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
                                                    <a href="#leave_compoff" data-toggle='modal' onclick="leave_compoff('<?php echo $emp_no; ?>')"><?php echo $count_compoff; ?></a>
                                                </td>
                                                <?php if ($user_role == 2 || $user_role == 6) { ?>
                                                    <td>
                                                        <a href="#add_newleave" data-toggle='modal' class="btn btn-default btn-sm btn-icon icon-left" onclick="add_newleave('<?php echo $emp_no; ?>')">
                                                            <i class="entypo-pencil"></i>
                                                            Edit
                                                        </a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Employee Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- View Leave Start Here -->

        <div class="modal fade custom-width" id="el_taken">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Annual Leave</h3>
                    </div>
                    <form role="form" id="view_el_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="cl_taken">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Casual Leave</h3>
                    </div>
                    <form role="form" id="view_cl_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="maternity_taken">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Maternity Leave</h3>
                    </div>
                    <form role="form" id="view_maternity_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="paternity_taken">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Paternity Leave</h3>
                    </div>
                    <form role="form" id="view_paternity_leave">

                    </form>
                </div>
            </div>
        </div>

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

        <div class="modal fade custom-width" id="leave_yetlop">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Yet to Deduct LOP</h3>
                    </div>
                    <form role="form" id="view_yetlop_leave">

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

        <!-- View Leave End Here -->

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


        <!-- Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024, phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($) {
                tableContainer = $("#summary_table");

                tableContainer.dataTable({
                    //  "scrollX": true,
                    "scrollY": 400,
                    "scrollX": true,
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

