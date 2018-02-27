<?php
$user_role = $this->session->userdata('user_role');

$this->db->where('Status', 1);
$q_emp = $this->db->get('tbl_employee');
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
            var formdata = {
                apply_leave_emp_id: $('#apply_leave_emp_id').val(),
                apply_leave_reporting_to: $('#apply_leave_reporting_to').val(),
                apply_leave_type: $('#apply_leave_type').val(),
                apply_leave_duration: $('#apply_leave_duration').val(),
                apply_leave_fromdate: $('#apply_leave_fromdate').val(),
                apply_leave_todate: $('#apply_leave_todate').val(),
                apply_leave_reason: $('#apply_leave_reason').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/apply_newleave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addleave_error').show();
                    }
                    if (msg == 'success') {
                        $('#addleave_success').show();
                        window.location.reload();
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
                    </div>

                    <!-- Summary Table Format Start Here -->

                    <table class="table table-bordered datatable" id="summary_table">
                        <thead>
                            <tr>
                                <th rowspan="2"><p>S.No</p></th>
                        <th rowspan="2"><p>Employee Id</p></th>
                        <th rowspan="2"><p>Employee Name</p></th>
                        <th colspan="2" style="text-align: center">Entitled Leave</th>
                        <th colspan="2" style="text-align: center">Leave Taken</th>
                        <th colspan="2" style="text-align: center">Balance Leave</th>
                        <th rowspan="2"><p>LOP</p></th>
                        <th rowspan="2"><p>Disciplinary LOP</p></th>
                        <?php if ($user_role == 2) { ?>
                            <th rowspan="2"><p>Actions</p></th>
                        <?php } ?>
                        </tr>
                        <tr>
                            <?php
                            $this->db->where('Status', 1);
                            $q_leave_type = $this->db->get('tbl_leavetype');
                            for ($no = 1; $no < 4; $no++) {
                                foreach ($q_leave_type->result() as $row_leave_type) {
                                    $leavetype_id = $row_leave_type->L_Id;
                                    $leavetype_title = $row_leave_type->Leave_Title;
                                    ?>
                                    <th><?php echo $leavetype_title; ?></th>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 2) {
                                $i = 1;
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

                                    $leave_pending_data = array(
                                        'Emp_Id' => $emp_no,
                                        'Status' => 1
                                    );
                                    $this->db->where($leave_pending_data);
                                    $q_leave_pending = $this->db->get('tbl_leave_pending');
                                    foreach ($q_leave_pending->result() as $row_leave_pending) {
                                        $el_leave = $row_leave_pending->EL;
                                        $cl_leave = $row_leave_pending->CL;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $emp_code . $emp_no; ?></td>
                                            <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                            <td><?php echo $el_leave; ?></td>
                                            <td><?php echo $cl_leave; ?></td>
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
                                                //  echo $el_taken;
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
                                                //echo $cl_taken;
                                                $cl_leave_balance = $cl_leave - $cl_taken;
                                                ?>
                                                <a href="#cl_taken" data-toggle='modal' onclick="cl_taken('<?php echo $emp_no; ?>')"><?php echo $cl_taken; ?></a>
                                            </td>
                                            <td><?php echo $el_leave_balance; ?></td>
                                            <td><?php echo $cl_leave_balance; ?></td>
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
                                            <?php if ($user_role == 2) { ?>
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
                        <h3 class="modal-title">View Leave</h3>
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
                        <h3 class="modal-title">View Leave</h3>
                    </div>
                    <form role="form" id="view_cl_leave">

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade custom-width" id="leave_lop">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Leave</h3>
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
                        <h3 class="modal-title">View Leave</h3>
                    </div>
                    <form role="form" id="view_dislop_leave">

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
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#summary_table");

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

