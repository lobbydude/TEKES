<?php
$user_role = $this->session->userdata('user_role');
?>
<script>
    $(document).ready(function () {
        $('#emp_resetpwd_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                employee_reset_name: $('#employee_reset_name').val()
            };
            $.ajax({
                url: "<?php echo site_url('User/reset_pwd') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == "fail") {
                         $('#emp_reset_success').hide();
                        $('#emp_reset_error').show();
                        
                    } else {
                       $('#emp_reset_error').hide();
                        $('#emp_reset_newpassword').html("New password is <span style='font-size: 18px; font-weight: bold; color: red;'>" + msg + "</span>");
                        $('#employee_reset_pwd').val("");
                        $('#emp_reset_success').show();
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
                            <h2>Reset Password</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <br /><br />

                    <form role="form" id="emp_resetpwd_form" name="emp_resetpwd_form" method="post" class="validate">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-7">
                                <div id="emp_reset_success" class="alert alert-success" style="display:none;">Password updated successfully.
                                    <div id="emp_reset_newpassword" style="text-transform: none;"></div>
                                </div>
                                <div id="emp_reset_error" class="alert alert-danger" style="display:none;">Failed to update password.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <select name="employee_reset_name" id="employee_reset_name" class="round" data-validate="required" data-message-required="Please select employee.">
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
                                </div>
                           
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Reset</button>
                            </div>
                        </div>
                    </form>
                    <br /><br /> <br /><br />
                </div>
            </div>
        </section>
