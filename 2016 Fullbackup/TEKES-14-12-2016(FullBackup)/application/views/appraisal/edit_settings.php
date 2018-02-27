<?php
$user_role = $this->session->userdata('user_role');
$this->db->where('A_Id', $A_Id);
$q = $this->db->get('tbl_appraisal');
foreach ($q->result() as $row) {
    $edit_Year = $row->Year;
    $edit_Month = $row->Month;
    $edit_Visible_From_Manager1 = $row->Visible_From_Manager;
    $edit_Visible_From_Manager = date("d-m-Y", strtotime($edit_Visible_From_Manager1));
    $edit_Visible_To_Manager1 = $row->Visible_To_Manager;
    $edit_Visible_To_Manager = date("d-m-Y", strtotime($edit_Visible_To_Manager1));
    $edit_Visible_From_Employee1 = $row->Visible_From_Employee;
    $edit_Visible_From_Employee = date("d-m-Y", strtotime($edit_Visible_From_Employee1));
    $edit_Visible_To_Employee1 = $row->Visible_To_Employee;
    $edit_Visible_To_Employee = date("d-m-Y", strtotime($edit_Visible_To_Employee1));
    $edit_settings_empno = $row->Employee_Id;
    $edit_Employee_File = $row->Employee_File;
    $edit_Manager_File = $row->Manager_File;        
}
?>
<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#edit_settings_empno').multiselect({
            includeSelectAllOption: true
        });
    });
</script>

<!-- Edit Settings Appraisal Permission Start here-->
<!--<script type="text/javascript">
    $(document).ready(function (e) {
        $("#editsettings_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({                  
                url: "<?php //echo site_url('Appraisal/edit_settings') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {                                          
                    if (data == "fail") {
                        $('#editsettings_error').show();
                    }
                    else {
                        $('#editsettings_error').hide();
                        $('#editsettings_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>-->


<script>
    $(document).ready(function () {
        $('#editsettings_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_settings_id: $('#edit_settings_id').val(), // Jquery single variable created
                edit_Visible_From_Manager: $('#edit_Visible_From_Manager').val(),
                edit_Visible_To_Manager: $('#edit_Visible_To_Manager').val(),
                edit_Visible_From_Employee: $('#edit_Visible_From_Employee').val(),
                edit_Visible_To_Employee: $('#edit_Visible_To_Employee').val()
                //edit_settings_empno: $('#edit_settings_empno').val()
            };
            $.ajax({               
                url: "<?php echo site_url('appraisal/edit_settings') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {                    
                    if (msg == 'fail') {
                        $('#editsettings_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#editsettings_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#editsettings_server_error').html(msg);
                        $('#editsettings_server_error').show();
                    }
                }
            });
        });
    });
</script>

<!-- Edit Settings Appraisal Permission End here-->

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editsettings_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editsettings_success" class="alert alert-success" style="display:none;">Edit Appraisal details updated successfully.</div>
            <div id="editsettings_error" class="alert alert-danger" style="display:none;">Failed to update Appraisal details.</div>
        </div>
    </div>
    
    <div class="row">                
        <input type="hidden" name="edit_settings_id" id="edit_settings_id" value="<?php echo $A_Id; ?>">
                
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Visible From(M)</label>
                <div class="input-group">
                    <input type="text" name="edit_Visible_From_Manager" id="edit_Visible_From_Manager" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_Visible_From_Manager;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>	
        </div>
        <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:13%;left:50%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Visible To(M)</label>
                <div class="input-group">
                    <input type="text" name="edit_Visible_To_Manager" id="edit_Visible_To_Manager" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_Visible_To_Manager;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>	
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Visible From(Emp)</label>
                <div class="input-group">
                    <input type="text" name="edit_Visible_From_Employee" id="edit_Visible_From_Employee" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_Visible_From_Employee;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>	
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Visible To(Emp)</label>
                <div class="input-group">
                    <input type="text" name="edit_Visible_To_Employee" id="edit_Visible_To_Employee" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_Visible_To_Employee;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>	
        </div>
        
        <div class="col-md-5">
            <div class="form-group">
                <label for="field-1" class="control-label col-md-12">Employee Name(EDIT)</label>
                <select name="edit_settings_empno[]" id="edit_settings_empno" multiple>
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
                        ?>
                        <option value="<?php echo $Employee_Number; ?>"><?php echo $Employee_FirstName . " " . $Employee_LastName . " " . $Employee_Middlename . "(" . $emp_code . $Employee_Number . ")" ?></option>
                        <?php                        
                    }
                    ?>
                </select>                                         
            </div>	
        </div>
    </div>
    <!-- Edit(Update) Appraisal Form Design Start-->

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>