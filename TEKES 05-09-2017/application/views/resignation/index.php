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

$this->db->where('Employee_Id', $emp_no);
$q = $this->db->get('tbl_resignation');

$update_data = array(
    'Emp_read' => 'read'
);
$this->db->where('Employee_Id', $emp_no);
$this->db->update('tbl_resignation', $update_data);
?>

<script>
    $(document).ready(function () {
        $('#addresignation_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                emp_no:$("#add_emp_no").val(),
                notice_date: $('#add_notice_date').val(),
                resignation_date: $('#add_resignation_date').val(),
                reporting_to: $('#add_reporting_to').val(),
                reason: $('#add_reason').val(),
                notice_period: $('#add_notice_period').val()
            };
            $.ajax({
                url: "<?php echo site_url('Resignation/add_resignation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addresignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#addresignation_success').show();
                        window.location.reload();
                    }

                }

            });
        });
    });

</script>

<script>

    function resignation_status(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Resignation/ViewResignation') ?>",
            data: "resignation_id=" + id,
            cache: false,
            success: function (html) {
                $("#resignation_status_form").html(html);

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
                            <h2>Resignation</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_resignation').modal('show', {backdrop: 'static'});">
                                Apply Resignation
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Resignation Table Format Start Here -->

                    <table class="table table-bordered datatable" id="resignation_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Reporting To</th>
                                <th>Notice Date</th>
                                <th>Resignation Date</th>
                                <th>Reason</th>
                                <th>Notice Period</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {

                                $R_Id = $row->R_Id;
                                $Notice_Date1 = $row->Notice_Date;
                                $Notice_Date = date("d-m-Y", strtotime($Notice_Date1));

                                $Resignation_Date1 = $row->Resignation_Date;
                                $Resignation_Date = date("d-m-Y", strtotime($Resignation_Date1));

                                $Reason = $row->Reason;
                                $Reporting_no = $row->Reporting_To;

                                $this->db->where('Emp_Number', $Reporting_no);
                                $q_employee = $this->db->get('tbl_employee');
                                foreach ($q_employee->result() as $row_employee) {
                                    $Emp_FirstName = $row_employee->Emp_FirstName;
                                    $Emp_Middlename = $row_employee->Emp_MiddleName;
                                    $Emp_LastName = $row_employee->Emp_LastName;
                                }

                                $this->db->where('Employee_Id', $emp_no);
                                $q_career = $this->db->get('tbl_employee_career');
                                foreach ($q_career->Result() as $row_career) {
                                    $designation_id = $row_career->Designation_Id;
                                }

                                $this->db->where('Designation_Id', $designation_id);
                                $q_designation = $this->db->get('tbl_designation');
                                foreach ($q_designation->result() as $row_designation) {
                                    $Notice_Period = $row_designation->Notice_Period;
                                }
                                $Approval = $row->Approval;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                    <td><?php echo $Notice_Date; ?></td>
                                    <td><?php echo $Resignation_Date; ?></td>
                                    <td><?php echo $Reason; ?></td>
                                    <td><?php echo $Notice_Period . " Days"; ?></td>
                                    <td>
                                        <?php
                                        if ($Approval == "Request") {
                                            echo "Processing ... ";
                                        }if ($Approval == "Yes") {
                                            ?>
                                            <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                Approved
                                            </a>
                                            <?php
                                        }if ($Approval == "No") {
                                            ?>
                                            <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                Not Approved
                                            </a>
                                            <?php
                                        }
                                        if ($Approval == "Cancel") {
                                            ?>
                                            <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                Cancelled
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>

                    </table>

                    <!-- Resignation Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Resignation Start Here -->

        <div class="modal fade custom-width" id="add_resignation">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Apply Resignation</h3>
                    </div>
                    <form role="form" id="addresignation_form" name="addresignation_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addresignation_success" class="alert alert-success" style="display:none;">Your Resignation sent successfully.</div>
                                    <div id="addresignation_error" class="alert alert-danger" style="display:none;">Failed to send resignation.</div>
                                </div>
                            </div>
                            <input type="hidden" name="add_emp_no" id="add_emp_no" value="<?php echo $emp_no; ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Letter Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_notice_date" id="add_notice_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select notice date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Resignation Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_resignation_date" id="add_resignation_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select resignation date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:13%;left:50%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reporting To</label>
                                        <input type="text" class="form-control" value="<?php echo $emp_reporting_name . " (" . $emp_code . $emp_report_to_id . ")"; ?>" disabled="disabled">
                                        <input type="hidden" name="add_reporting_to" id="add_reporting_to" class="form-control" value="<?php echo $emp_report_to_id ?>" disabled="disabled">
                                    </div>	
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reason</label>
                                        <textarea name="add_reason" id="add_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter grade."></textarea>
                                    </div>	
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Notice Period</label>
                                        <div class="input-group">
                                            <input type="text" name="add_notice_period" id="add_notice_period" class="form-control" placeholder="Notice Period" data-validate="required,number" data-message-required="Please enter notice period." value="<?php echo $emp_notice_period; ?>" disabled="disabled">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary">Days</button>
                                            </span>
                                        </div>
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

        <!-- Add Resignation End Here -->


        <!-- Resignation Status Start Here -->

        <div class="modal fade custom-width" id="resignation_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Resignation</h3>
                    </div>
                    <form role="form" id="resignation_status_form" name="resignation_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Resignation Status End Here -->


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
                tableContainer = $("#resignation_table");

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

