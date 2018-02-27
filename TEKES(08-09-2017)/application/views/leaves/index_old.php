<?php
$emp_no = $this->session->userdata('username');

$this->db->where('employee_number', $emp_no);
$q_code = $this->db->get('tbl_emp_code');
foreach ($q_code->result() as $row_code) {
    $emp_code = $row_code->employee_code;
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
    }
}


$update_data = array(
    'Emp_read' => 'read'
);
$this->db->where('Employee_Id', $emp_no);
$this->db->update('tbl_leaves', $update_data);

$this->db->where('Employee_Id', $emp_no);
$q = $this->db->get('tbl_leaves');

$this->db->where('Status', 1);
$q_leave_type = $this->db->get('tbl_leavetype');
?>

<script>
    $(document).ready(function () {
        $('#addleave_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_leave_reporting_to: $('#add_leave_reporting_to').val(),
                add_leave_type: $('#add_leave_type').val(),
                add_leave_duration: $('#add_leave_duration').val(),
                add_leave_fromdate: $('#add_leave_fromdate').val(),
                add_leave_todate: $('#add_leave_todate').val(),
                add_leave_reason: $('#add_leave_reason').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/apply_leave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#applyleave_error').show();
                    }
                    if (msg == 'success') {
                        $('#applyleave_success').show();
                        window.location.reload();
                    }
                }
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

                    <!-- Leave Table Format Start Here -->

                    <table class="table table-bordered datatable" id="leave_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Reporting To</th>
                                <th>Type</th>
                                <th>Duration</th>
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
                                        <?php
                                        if ($Approval == "Yes") {
                                            ?>
                                            <a data-toggle='modal' href='#cancel_leave' class="btn btn-danger btn-sm btn-icon icon-left" onclick="cancel_leave(<?php echo $Leave_Id; ?>)">
                                                <i class="entypo-cancel"></i>
                                                Cancel
                                            </a>
                                        <?php }
                                        ?>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reporting To</label>
                                        <input type="text" class="form-control" value="<?php echo $emp_reporting_name . " (" . $emp_code . $emp_report_to_id . ")"; ?>" disabled="disabled">
                                        <input type="hidden" name="add_leave_reporting_to" id="add_leave_reporting_to" class="form-control" value="<?php echo $emp_report_to_id ?>" disabled="disabled">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Leave Type</label>
                                        <select name="add_leave_type" id="add_leave_type" class="round" data-validate="required">
                                            <?php
                                            foreach ($q_leave_type->result() as $row_leave_type) {
                                                $leavetype_id = $row_leave_type->L_Id;
                                                $leavetype_title = $row_leave_type->Leave_Title;
                                                ?>
                                                <option value="<?php echo $leavetype_id; ?>"><?php echo $leavetype_title; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Duration</label>
                                        <select name="add_leave_duration" id="add_leave_duration" class="round" data-validate="required" onchange="get_duration(this.value);">
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

