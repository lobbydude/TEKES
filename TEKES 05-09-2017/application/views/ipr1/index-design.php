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
                preview_year: $('#preview_year').val(),
                preview_month: $('#preview_month').val()
            };
            $.ajax({
                url: "<?php echo site_url('Ipr1/preview') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    $('#employee_payslip').html(msg);
                }
            });
        });
    });
function showgroupslip(){
    $("#preview_div").hide();
    $("#grouppayslip_div").show();    
}
function show_individual_payslip(){    
    $("#grouppayslip_div").hide();
    $("#preview_div").show();   
}
</script>


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                             <h2>IPR REPORT II</h2>
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
                                if ($user_role == 6 || $user_role == 1) {
                                    ?>
                                    <select name="employee_list" id="employee_list" class="select2" data-validate="required" data-message-required="Please select employee.">
                                        <option value="">Please Select Employee </option>
										<option onClick="showgroupslip()">All Employees</option>
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
                                            <option onClick="show_individual_payslip()" value="<?php echo $emp_no_list ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                                <?php
                                if ($user_role == 2) {
                                    ?>
                                    <select name="employee_list" id="employee_list" class="select2" data-validate="required" data-message-required="Please select employee.">
                                        <option value="">Please Select Employee</option>
                                        <option onClick="showgroupslip()">All Employees</option>
                                        <?php
                                        $this->db->where('Reporting_To !=', 0003);
										$this->db->group_by('Employee_Id');
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
                                                <option onClick="show_individual_payslip()" value="<?php echo $emp_career_no ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename . '( ' . $emp_code . $emp_no_list . " )"; ?></option>
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
                                <select id="preview_year" name="preview_year" class="round">
                                    <?php
                                    for ($count = $current_year; $count >= DOB_YEAR_START1; $count--) {
                                        echo "<option value='{$count}'>{$count}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="round" id="preview_month" name="preview_month">
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
                       <div class="col-md-1" id="preview_div">
                            <button type="submit" class="btn btn-primary">Preview</button>
                        </div>    
                        <div class="col-md-1" id="grouppayslip_div" style="display: none;">    
                            <a class="btn btn-primary" target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=grouppayslip.mrt') ?>">Group Payslip</a>
                        </div>
                    </form>
                    <br /><br /> <br /><br />
                    <div id="employee_payslip"></div>
                </div>
            </div>
        </section>
