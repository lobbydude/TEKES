<?php
$emp_no = $this->session->userdata('username');

$this->db->where('Status', 1);
$q = $this->db->get('tbl_termination');

$this->db->where('Status', 1);
$q_emp = $this->db->get('tbl_employee');

$user_role = $this->session->userdata('user_role');
if ($user_role == 2) {
    $update_data = array(
        'HR_Read' => 'read'
    );
    $this->db->update('tbl_termination', $update_data);
	 $this->db->where('Status', 1);
    $q = $this->db->get('tbl_termination');
}
else if ($user_role == 1) {
    $update_data = array(
        'Manager_Read' => 'read'
    );
    $this->db->where('Reporting_To',$emp_no);
    $this->db->update('tbl_termination', $update_data);
	$get_terminate_data = array(
        'Reporting_To' => $emp_no,
        'Status' => 1
    );
    $this->db->where($get_terminate_data);
    $q = $this->db->get('tbl_termination');
}
?>

<script>
    $(document).ready(function () {
        $('#addtermination_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_termination_employee: $('#add_termination_employee').val(),
                add_termination_date: $('#add_termination_date').val(),
                add_termination_reporting_to: $('#add_termination_reporting_to').val(),
                add_termination_reason: $('#add_termination_reason').val()
            };
            $.ajax({
                url: "<?php echo site_url('Termination/add_termination') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addtermination_error').show();
                    }
                    if (msg == 'success') {
                        $('#addtermination_success').show();
                        window.location.reload();
                    }
                }

            });
        });
    });

    function fetch_reporting(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Profile/fetch_reporting') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#add_termination_reporting_to").html(html);
            }
        });
    }
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">
                            <h2>Termination</h2>
                        </div>
<!--                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_termination').modal('show', {backdrop: 'static'});">
                                Add New Termination
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>-->
                    </div>

                    <!-- Resignation Table Format Start Here -->

                    <table class="table table-bordered datatable" id="termination_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Code</th>
                                <th>Employee</th>
                                <th>Last Working Date</th>
                                <th>Terminated Date</th>
                                <th>Reporting To</th>
                                <th>Reason</th>
                                <th>Terminated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {

                                $T_Id = $row->T_Id;
                                $Terminated_Date1 = $row->Terminated_Date;
                                $Terminated_Date = date("d-m-Y", strtotime($Terminated_Date1));

                                $Reason = $row->Reason;
                                $Reporting_no = $row->Reporting_To;
                                $Employee_Id = $row->Employee_Id;
                                $lwd_Date1 = $row->LWD_Date;
                                $lwd_Date = date("d-m-Y", strtotime($lwd_Date1));
                                $this->db->where('employee_number', $Employee_Id);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->Result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                }


                                $this->db->where('Emp_Number', $Employee_Id);
                                $q_employee = $this->db->get('tbl_employee');
                                foreach ($q_employee->result() as $row_employee) {
                                    $Emp_FirstName = $row_employee->Emp_FirstName;
                                    $Emp_MiddleName = $row_employee->Emp_MiddleName;
                                    $Emp_LastName = $row_employee->Emp_LastName;
                                }

                                $this->db->where('Emp_Number', $Reporting_no);
                                $q_employee1 = $this->db->get('tbl_employee');
                                foreach ($q_employee1->result() as $row_employee1) {
                                    $Emp_FirstName1 = $row_employee1->Emp_FirstName;
                                    $Emp_MiddleName1 = $row_employee1->Emp_MiddleName;
                                    $Emp_LastName1 = $row_employee1->Emp_LastName;
                                }

                                $Terminated_By = $row->Terminated_By;
                                $this->db->where('Emp_Number', $Terminated_By);
                                $q_employee2 = $this->db->get('tbl_employee');
                                foreach ($q_employee2->result() as $row_employee2) {
                                    $Emp_FirstName2 = $row_employee2->Emp_FirstName;
                                    $Emp_MiddleName2 = $row_employee2->Emp_MiddleName;
                                    $Emp_LastName2 = $row_employee2->Emp_LastName;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $emp_code . $Employee_Id; ?></td>
                                    <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_MiddleName; ?></td>
                                    <td><?php echo $lwd_Date; ?></td>
                                    <td><?php echo $Terminated_Date; ?></td>
                                    <td><?php echo $Emp_FirstName1 . " " . $Emp_LastName1 . " " . $Emp_MiddleName1; ?></td>
                                    <td><?php echo $Reason; ?></td>
                                    <td><?php echo $Emp_FirstName2 . " " . $Emp_LastName2 . " " . $Emp_MiddleName2; ?></td>
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

        <!-- Add Termination Start Here -->

        <div class="modal fade custom-width" id="add_termination">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Termination</h3>
                    </div>
                    <form role="form" id="addtermination_form" name="addtermination_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addrtermination_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addtermination_success" class="alert alert-success" style="display:none;">Termination sent successfully.</div>
                                    <div id="addtermination_error" class="alert alert-danger" style="display:none;">Failed to send termination.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Employee</label>
                                        <select name="add_termination_employee" id="add_termination_employee" class="round" data-validate="required" data-message-required="Please select employee name." onchange="fetch_reporting(this.value)">
                                            <option value="">Please Select</option>
                                            <?php
                                            foreach ($q_emp->result() as $row_emp) {
                                                $emp_firstname = $row_emp->Emp_FirstName;
                                                $emp_middlename = $row_emp->Emp_MiddleName;
                                                $emp_lastname = $row_emp->Emp_LastName;
                                                $emp_no = $row_emp->Emp_Number;
                                                $this->db->where('employee_number', $emp_no);
                                                $q_code = $this->db->get('tbl_emp_code');
                                                foreach ($q_code->Result() as $row_code) {
                                                    $emp_code = $row_code->employee_code;
                                                }
                                                ?>
                                                <option value="<?php echo $emp_no; ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '- ' . $emp_code . $emp_no; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Termination Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_termination_date" id="add_termination_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select termination date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reporting To</label>
                                        <select name="add_termination_reporting_to" id="add_termination_reporting_to" class="round" data-validate="required" data-message-required="Please select reporting manager.">
                                            <option value="">Please Select</option>
                                        </select>
<!--                                        <input type="text" class="form-control" value="<?php echo $emp_reporting_name . " (" . $emp_code . $emp_report_to_id . ")"; ?>" disabled="disabled">
                                        <input type="hidden" name="add_termination_reporting_to" id="add_termination_reporting_to" class="form-control" value="<?php echo $emp_report_to_id ?>" disabled="disabled">-->
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Reason</label>
                                        <textarea name="add_termination_reason" id="add_termination_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter reason."></textarea>
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

        <!-- Add Termination End Here -->


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
                tableContainer = $("#termination_table");

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

