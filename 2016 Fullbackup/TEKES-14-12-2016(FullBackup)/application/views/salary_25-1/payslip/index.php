<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');
?>

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
                url: "<?php echo site_url('Salary/preview') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    $('#employee_payslip').html(msg);
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
                            <h2>Payslip</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#import_payslip').modal('show', {backdrop: 'static'});">
                                Import Payslip
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <br /><br />
                    <div class="col-md-1"></div>
                    <form role="form" id="payslip_form" name="payslip_form" method="post" class="validate">
                        <div class="col-md-8">
                            <div class="col-md-6">
                                <?php
                                if ($user_role == 6) {
                                    ?>
                                    <select name="employee_list" id="employee_list" class="round" data-validate="required" data-message-required="Please select employee.">
                                        <option value="">Please Select</option>
                                        <?php
                                        $this->db->where('Status', 1);
                                        $select_emp = $this->db->get('tbl_employee');
                                        foreach ($select_emp->result() as $row_emp) {
                                            $emp_no_list = $row_emp->Emp_Number;
                                            $emp_firstname = $row_emp->Emp_FirstName;
                                            $emp_middlename = $row_emp->Emp_MiddleName;
                                            $emp_lastname = $row_emp->Emp_LastName;

                                            $this->db->where('employee_number', $emp_no_list);
                                            $q_empcode = $this->db->get('tbl_emp_code');
                                            foreach ($q_empcode->result() as $row_empcode) {
                                                $emp_code = $row_empcode->employee_code;
                                                $start_number = $row_empcode->employee_number;
                                                $emp_id = str_pad(($start_number), 4, '0', STR_PAD_LEFT);
                                            }
                                            ?>
                                            <option value="<?php echo $emp_no_list ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                                <?php
                                if ($user_role == 2) {
                                    ?>
                                    <select name="employee_list" id="employee_list" class="round" data-validate="required" data-message-required="Please select employee.">
                                        <option value="">Please Select</option>
                                        <?php
                                        $this->db->where('Reporting_To !=', 0003);
                                        $select_emp_career = $this->db->get('tbl_employee_career');
                                        foreach ($select_emp_career->result() as $row_emp_career) {
                                            $emp_career_no = $row_emp_career->Employee_Id;

                                            $get_emp_data = array(
                                                'Emp_Number' => $emp_career_no,
                                                'Status' => 1
                                            );
                                            $this->db->where($get_emp_data);
                                            $select_emp = $this->db->get('tbl_employee');
                                            foreach ($select_emp->result() as $row_emp) {
                                                $emp_no_list = $row_emp->Emp_Number;
                                                $emp_firstname = $row_emp->Emp_FirstName;
                                                $emp_middlename = $row_emp->Emp_MiddleName;
                                                $emp_lastname = $row_emp->Emp_LastName;

                                                $this->db->where('employee_number', $emp_no_list);
                                                $q_empcode = $this->db->get('tbl_emp_code');
                                                foreach ($q_empcode->result() as $row_empcode) {
                                                    $emp_code = $row_empcode->employee_code;
                                                    $start_number = $row_empcode->employee_number;
                                                    $emp_id = str_pad(($start_number), 4, '0', STR_PAD_LEFT);
                                                }
                                                ?>
                                                <option value="<?php echo $emp_career_no ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                <?php } ?>

                            </div>
                            <div class="col-md-3">
                                <?php
                                define('DOB_YEAR_START', 2000);
                                $current_year = date('Y');
                                ?>
                                <select id="year_list" name="year_list" class="round" onchange="$('#change_timesheet').submit();">
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
                                        $current_month=date('m');
                                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                        ?>
                                        <option value="<?php echo $m; ?>" <?php if($current_month==$m){echo "selected=selected";}?>><?php echo $month; ?></option>
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
                    <div id="employee_payslip"></div>
                </div>
            </div>
        </section>

        <!-- Import Payslip Start Here -->

        <div class="modal fade" id="import_payslip" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Import Payslip</h3>
                    </div>
                    <form role="form" id="importpayslip_form" name="importpayslip_form" method="post" class="validate" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="importpayslip_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="importpayslip_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                    <div id="importpayslip_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">File Upload</label>
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="file" name="import_payslipfile" id="import_payslipfile" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
                                    </div>	
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="Import">Import</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Import Payslip End Here -->

        <script type="text/javascript">
            $(document).ready(function (e) {
                $("#importpayslip_form").on('submit', (function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "<?php echo site_url('Salary/import_payslip') ?>",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data)
                        {
                            if (data.trim() == "fail") {
                                $('#importpayslip_error').show();
                            }

                            if (data.trim() == "success") {
                                $('#importpayslip_success').show();
                                window.location.reload();
                            }
                        },
                        error: function ()
                        {

                        }
                    });
                }));
            });

        </script>