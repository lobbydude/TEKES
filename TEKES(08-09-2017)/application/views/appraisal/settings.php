<?php
$user_role = $this->session->userdata('user_role');
?>
<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#appraisal_empno').multiselect({
            includeSelectAllOption: true
        });
    });

    $(document).ready(function () {
        $('#manager_appraisalsettings_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                appraisal_role: $("#appraisal_role").val(),
                appraisal_year: $('#appraisal_year').val(),
                appraisal_month: $('#appraisal_month').val(),
                appraisal_from: $('#appraisal_from').val(),
                appraisal_to: $('#appraisal_to').val(),
                appraisal_empno: $('#appraisal_empno').val()
            };
            $.ajax({
                url: "<?php echo site_url('appraisal/manager_appraisal_settings') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#manager_appraisalsettings_success').hide();
                        $('#manager_appraisalsettings_error').show();
                    }
                    if (msg == 'success') {
                        $('#manager_appraisalsettings_error').hide();
                        $('#manager_appraisalsettings_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>
<style>
    .multiselect-container.dropdown-menu a .checkbox input[type="checkbox"]{
        opacity: 1;
    }
    .multiselect-container.dropdown-menu {
        height: 200px;
        margin-left: 30px;
        margin-top: -15px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    .btn-default.dropdown-toggle{
        margin-left: 15px;
        text-align: left;
    }
    .btn .caret{
        margin-left: 145px;
    }
</style>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Appraisal</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#manager_appraisal_settings').modal('show', {backdrop: 'static'});">
                                Settings
                                <i class="entypo-cog"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Appraisal Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="appraisal_table">
                        <thead>
                            <tr>
                                <th style="width: 25px;">S.No</th>
                                <th>Period</th> 
                                <th>Reporting Manager</th>
                                <th>Visible From (M)</th>
                                <th>Visible To (M)</th>
                                <th>Employee</th>
                                <th>Visible From (E)</th>
                                <th>Visible To (E)</th>
                                <th>File (E)</th>
                                <th>File (M)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('A_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_appraisal');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $A_Id = $row->A_Id;
                                $Year = $row->Year;
                                $Month = $row->Month;
                                $MonthName = date('F', mktime(0, 0, 0, $Month, 10));
                                $Visible_From_Manager1 = $row->Visible_From_Manager;
                                $Visible_From_Manager = date("d-M-Y", strtotime($Visible_From_Manager1));
                                $Visible_To_Manager1 = $row->Visible_To_Manager;
                                $Visible_To_Manager = date("d-M-Y", strtotime($Visible_To_Manager1));
                                $Visible_From_Employee1 = $row->Visible_From_Employee;
                                if ($Visible_From_Employee1 == "0000-00-00") {
                                    $Visible_From_Employee = "";
                                } else {
                                    $Visible_From_Employee = date("d-M-Y", strtotime($Visible_From_Employee1));
                                }
                                $Visible_To_Employee1 = $row->Visible_To_Employee;
                                if ($Visible_To_Employee1 == "0000-00-00") {
                                    $Visible_To_Employee = "";
                                } else {
                                    $Visible_To_Employee = date("d-M-Y", strtotime($Visible_To_Employee1));
                                }
                                $Employee_File = $row->Employee_File;
                                $Manager_File = $row->Manager_File;
                                $Employee_Id = $row->Employee_Id;
                                $this->db->where('Employee_Id', $Employee_Id);
                                $q_career = $this->db->get('tbl_employee_career');
                                $count_career = $q_career->num_rows();
                                if ($count_career > 0) {
                                    foreach ($q_career->Result() as $row_career) {
                                        $reporting_id = $row_career->Reporting_To;
                                    }

                                    $this->db->where('Emp_Number', $reporting_id);
                                    $q_reporting = $this->db->get('tbl_employee');
                                    foreach ($q_reporting->Result() as $row_reporting) {
                                        $reporting_firstname = $row_reporting->Emp_FirstName;
                                        $reporting_middlename = $row_reporting->Emp_MiddleName;
                                        $reporting_lastname = $row_reporting->Emp_LastName;
                                    }
                                }
                                $this->db->where('Emp_Number', $Employee_Id);
                                $q_emp = $this->db->get('tbl_employee');
                                foreach ($q_emp->result() as $row_emp) {
                                    $Employee_Name = $row_emp->Emp_FirstName;
                                    $Employee_Name .= " " . $row_emp->Emp_MiddleName;
                                    $Employee_Name .= " " . $row_emp->Emp_LastName;
                                    $get_emp_code = array(
                                        "employee_number" => $Employee_Id,
                                        "Status" => 1
                                    );
                                    $this->db->where($get_emp_code);
                                    $q_employee_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_employee_code->result() as $row_employee_code) {
                                        $employee_code = $row_employee_code->employee_code;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $MonthName . " " . $Year; ?></td>       
                                        <?php
                                        if ($count_career > 0) {
                                            ?>
                                            <td><?php echo $reporting_firstname . " " . $reporting_lastname . " " . $reporting_middlename; ?></td>										
                                        <?php } else { ?>
                                            <td></td>
                                        <?php } ?>
                                        <td><?php echo $Visible_From_Manager; ?></td>
                                        <td><?php echo $Visible_To_Manager; ?></td>
                                        <td><?php echo $Employee_Name . " (" . $employee_code . $Employee_Id . ")"; ?></td>
                                        <td><?php echo $Visible_From_Employee; ?></td>
                                        <td><?php echo $Visible_To_Employee; ?></td>
                                        <td>
                                            <?php if ($Employee_File != "") { ?>
                                                <a href="<?php echo site_url('appraisal_file/employee/' . $Employee_File) ?>" target="_blank">
                                                    <i class="entypo-download"></i>                     
                                                </a>       
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($Manager_File != "") { ?>
                                                <a href="<?php echo site_url('appraisal_file/manager/' . $Manager_File) ?>" target="_blank">
                                                    <i class="entypo-download"></i>                                  
                                                </a> 
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>                             
                        </tbody>                   
                    </table> 
                    <!-- Appraisal Table Format End Here -->
                </div>
            </div>
        </section>
        <!-- Add Settings Start Here -->
        <div class="modal fade custom-width" id="manager_appraisal_settings">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Visibility Settings</h3>
                    </div>
                    <form role="form" id="manager_appraisalsettings_form" name="manager_appraisalsettings_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="manager_appraisalsettings_success" class="alert alert-success" style="display:none;">Appraisal configuration updated successfully.</div>
                                    <div id="manager_appraisalsettings_error" class="alert alert-danger" style="display:none;">Failed to update settings.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label col-md-12">Appraisal Cycle</label>
                                        <div class="input-group col-md-5">
                                            <?php
                                            define('DOB_YEAR_START', 2013);
                                            $current_year1 = date('Y');
                                            ?>
                                            <select id="appraisal_year" name="appraisal_year" class="round">
                                                <?php
                                                for ($count = $current_year1; $count >= DOB_YEAR_START1; $count--) {
                                                    echo "<option value='{$count}'>{$count}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="input-group col-md-7">
                                            <select class="round" id="appraisal_month" name="appraisal_month" <option value="">Select Shift Name</option>
                                                <?php
                                                for ($m = 1; $m <= 12; $m++) {
                                                    $current_month = date('m');
                                                    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                    ?>
                                                    <option value="<?php echo $m; ?>" <?php
                                                    if ($current_month == $m) {
                                                        echo "selected=selected";
                                                    }
                                                    ?>><?php echo $month; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($user_role == 2 || $user_role == 6) { ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Role</label>
                                            <select class="round" name="appraisal_role" id="appraisal_role">
                                                <option value="Manager">Manager</option>
                                                <option value="Employee">Employee</option>
                                            </select>
                                        </div>	
                                    </div>
                                <?php }if ($user_role == 1) { ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Role</label>
                                            <select class="round" name="appraisal_role" id="appraisal_role">
                                                <option value="Employee">Employee</option>
                                            </select>
                                        </div>	
                                    </div>
                                <?php }
                                ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Visible From</label>
                                        <div class="input-group">
                                            <input type="text" name="appraisal_from" id="appraisal_from" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select resignation date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>
                                <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:13%;left:50%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Visible To</label>
                                        <div class="input-group">
                                            <input type="text" name="appraisal_to" id="appraisal_to" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select resignation date." data-mask="dd-mm-yyyy" data-validate="required">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label col-md-12">Employee Name</label>
                                        <select name="appraisal_empno[]" id="appraisal_empno" data-validate="required" class="round" data-message-required="Employee Name" multiple>
                                            <?php
                                            $this->db->where('Status', 1);
                                            $q_employee = $this->db->get('tbl_employee');
                                            foreach ($q_employee->result() as $row_employee) {
                                                $Employee_Number = $row_employee->Emp_Number;
                                                $Employee_FirstName = $row_employee->Emp_FirstName;
                                                $Employee_Middlename = $row_employee->Emp_MiddleName;
                                                $Employee_LastName = $row_employee->Emp_LastName;
                                                $get_empl_code = array(
                                                    "employee_number" => $Employee_Number,
                                                    "Status" => 1
                                                );
                                                $this->db->where($get_empl_code);
                                                $q_emp_code = $this->db->get('tbl_emp_code');
                                                foreach ($q_emp_code->result() as $row_emp_code) {
                                                    $emp_code = $row_emp_code->employee_code;
                                                }
                                                
                                                $Employee_Doj = $row_employee->Emp_Doj;
                                                $empdoj = date("Y-m-d", strtotime($Employee_Doj));
                                                $empdoj_no = date("Y-m-d", strtotime($Employee_Doj . "+1 days"));
                                                $empinterval = date_diff(date_create(), date_create($empdoj_no));
                                                $empsubtotal_experience = $empinterval->format("%Y Year,<br> %M Months, <br>%d Days");
                                                $empno_days = $empinterval->format("%a");
                                                $empno_days_Y = floor($empno_days / 365);
                                                $empno_days_M = floor(($empno_days - (floor($empno_days / 365) * 365)) / 30);
                                                $empno_days_D = $empno_days - (($empno_days_Y * 365) + ($empno_days_M * 30));
                                                $empdoj_date = explode("-", $Employee_Doj);
                                                $empdoj_year = $empdoj_date[0];
                                                $empdoj_month = $empdoj_date[1];
                                                $current_year2 = date('Y');
                                                //if ($empdoj_month < 6 && $current_year2 > $empdoj_year) {
                                                    ?>
                                                    <option value="<?php echo $Employee_Number; ?>"><?php echo $Employee_FirstName . " " . $Employee_LastName . " " . $Employee_Middlename . "(" . $emp_code . $Employee_Number . ")" ?></option>
                                                    <?php
                                                //}
                                            }
                                            ?>
                                          
                                        </select>                                         
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
        <!-- Add Settings End Here -->
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
                tableContainer = $("#appraisal_table");

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