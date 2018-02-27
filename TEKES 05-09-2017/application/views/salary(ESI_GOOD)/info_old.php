<?php
$emp_no = $this->uri->segment(3);
$this->db->order_by('Sal_Id', 'desc');
$data_salary = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($data_salary);
$q = $this->db->get('tbl_salary_info');

$this->db->where('Emp_Number', $emp_no);
$q_employee = $this->db->get('tbl_employee');
foreach ($q_employee->result() as $row_employee) {
    $employee_name = $row_employee->Emp_FirstName;
    $employee_name .= " " . $row_employee->Emp_LastName;
    $employee_name .= " " . $row_employee->Emp_MiddleName;
}

$this->db->where('employee_number', $emp_no);
$q_employee_code = $this->db->get('tbl_emp_code');
foreach ($q_employee_code->result() as $row_employee_code) {
    $employee_code = $row_employee_code->employee_code;
}

$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');

$this->db->where('Status', 1);
$select_report = $this->db->get('tbl_employee');

$user_role = $this->session->userdata('user_role');
?>

<script>
    function edit_Salary(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Salary/Editsalary') ?>",
            data: "salary_id=" + id,
            cache: false,
            success: function (html) {
                $("#editsalary_form").html(html);
            }
        });
    }

    function delete_Salary(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Salary/Deletesalary') ?>",
            data: "salary_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletesalary_form").html(html);
            }
        });
    }

    function view_Salary(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Salary/Viewsalary') ?>",
            data: "salary_id=" + id,
            cache: false,
            success: function (html) {
                $("#viewsalary_form").html(html);
            }
        });
    }

</script>

<script>
	$(document).ready(function () {
        $('#payslip_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                employee_list: $('#employee_list').val(),
                year_list: $('#year_list').val(),
                month_list: $('#month_list').val()
            };
            $.ajax({
                url: "<?php echo site_url('Payslip/Emppreview') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    $("#salary_table_wrapper").hide();
                    $('#employee_payslip').html(msg);
                }
            });
        });
    
        $('#addsalary_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_salary_emp_no: $('#add_salary_emp_no').val(),
                add_salary_CCTC: $('#add_salary_CCTC').val(),
                add_salary_MonthlyCTC: $('#add_salary_MonthlyCTC').val(),
                add_salary_from: $('#add_salary_from').val(),
                add_salary_to: $('#add_salary_to').val()
            };
            $.ajax({
                url: "<?php echo site_url('Salary/add_salary') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#addsalary_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#addsalary_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Salary Details : <?php echo $employee_name . "( " . $employee_code . $emp_no . " )"; ?></h2>
                        </div>

                        <div class="panel-options">
                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_salary').modal('show', {backdrop: 'static'});">
                                    Add Salary
                                    <i class="entypo-plus-circled"></i>
                                </button>
                            <?php } ?>
							  <button class="btn btn-primary btn-icon icon-left" type="button" onclick=" history.back();">
                                Back
                                <i class=" entypo-back"></i>
                            </button>
                        </div>
                    </div>
					
                        <div class="row">
                        <br /><br />
                        <div class="col-md-1"></div>
                        <form role="form" id="payslip_form" name="payslip_form" method="post" class="validate">
                            <div class="col-md-8">
                                <div class="col-md-4">
                                    <input type="hidden" name="employee_list" id="employee_list" value="<?php echo $emp_no ?>">
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    define('DOB_YEAR_START', 2000);
                                    $current_year = date('Y');
                                    ?>
                                    <select id="year_list" name="year_list" class="round">
                                        <?php
                                        for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                            echo "<option value='{$count}'>{$count}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="round" id="month_list" name="month_list">
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $current_month = date('m');
                                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                            ?>
                                            <option value="<?php echo $m; ?>" <?php if ($current_month == $m) {
                                            echo "selected=selected";
                                        } ?>><?php echo $month; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Preview</button>
                            </div>
                        </form>
                        <br /><br /> <br /><br />
                    </div>

                    <div id="employee_payslip"></div>

                    <!-- Salary Table Format Start Here -->

                    <table class="table table-bordered datatable" id="salary_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Current CTC (Rs)</th>
                                <th>Monthly CTC (Rs)</th>
                                <th>From</th>
                                <th>To</th>
                                <?php if ($user_role == 2 || $user_role == 6) { ?>
                                    <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $salary_id = $row->Sal_Id;
                                $C_CTC = number_format(($row->C_CTC), 2, '.', ',');
                                $Monthly_CTC = number_format(($row->Monthly_CTC), 2, '.', ',');
                                $from_date = $row->From_Date;
                                $from = date("d M y", strtotime($from_date));
                                $to_date = $row->To_Date;
                                if ($to_date == "0000-00-00") {
                                    $to = "";
                                } else {
                                    $to = date("d M y", strtotime($to_date));
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $C_CTC; ?></td>
                                    <td><?php echo $Monthly_CTC; ?></td>
                                    <td><?php echo $from; ?></td>
                                    <td><?php echo $to; ?></td>
                                    <?php if ($user_role == 2 || $user_role == 6) { ?>
                                        <td>
                                            <a data-toggle='modal' href='#edit_salary' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Salary(<?php echo $salary_id; ?>)">
                                                <i class="entypo-pencil"></i>
                                                Edit
                                            </a>
                                            <a data-toggle='modal' href='#view_salary' class="btn btn-primary btn-sm btn-icon icon-left" onclick="view_Salary(<?php echo $salary_id; ?>)">
                                                <i class="entypo-list"></i>
                                                View
                                            </a>
                                            <a data-toggle='modal' href='#delete_salary' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Salary(<?php echo $salary_id; ?>)">
                                                <i class="entypo-cancel"></i>
                                                Delete
                                            </a>
											 <a class="btn btn-default btn-sm btn-icon icon-left" href="<?php echo site_url('Salary/Printsalary/' . $salary_id) ?>">
                                                <i class="entypo-print"></i>
                                                Print
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

                    <!-- Salary Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Salary Start Here -->

        <div class="modal fade custom-width" id="add_salary">
            <div class="modal-dialog" style="width: 65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Salary Info</h3>
                    </div>
                    <form role="form" id="addsalary_form" name="addsalary_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addsalary_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addsalary_success" class="alert alert-success" style="display:none;">Salary details added successfully.</div>
                                    <div id="addsalary_error" class="alert alert-danger" style="display:none;">Failed to add salary details.</div>
                                </div>
                            </div>
                            <input type="hidden" name="add_salary_emp_no" id="add_salary_emp_no" value="<?php echo $emp_no; ?>"> 
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Monthly CTC</label>
                                        <div class="input-group">
                                            <input type="text" name="add_salary_MonthlyCTC" id="add_salary_MonthlyCTC" class="form-control" data-validate="required" data-message-required="Please enter monthly CTC." onchange="$('#add_salary_CCTC').val($(this).val() * 12)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">Current CTC</label>
                                        <div class="input-group">
                                            <input type="text" name="add_salary_CCTC" id="add_salary_CCTC" class="form-control" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">From</label>
                                        <div class="input-group">
                                            <input type="text" name="add_salary_from" id="add_salary_from" class="form-control datepicker"  placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="full_name">To</label>
                                        <div class="input-group">
                                            <input type="text" name="add_salary_to" id="add_salary_to" class="form-control datepicker" placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Career End Here -->

        <!-- Edit Career Start Here -->

        <div class="modal fade custom-width" id="edit_salary">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Salary</h3>
                    </div>
                    <form role="form" id="editsalary_form" name="editsalary_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Salary End Here -->

        <!-- Delete Salary Start Here -->

        <div class="modal fade" id="delete_salary">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Salary</h3>
                    </div>
                    <form role="form" id="deletesalary_form" name="deletesalary_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Salary End Here -->

        <!-- View Salary Start Here -->

        <div class="modal fade" id="view_salary">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Salary</h3>
                    </div>
                    <form role="form" id="viewsalary_form" name="viewsalary_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- View Salary End Here -->
		
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
                tableContainer = $("#salary_table");

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

