<?php
$this->db->where('SA_Id', $SA_Id);
$q = $this->db->get('tbl_shift_allocate');
foreach ($q->result() as $row) {
    $edit_year = $row->Year;
    $edit_month1 = $row->Month;
    $edit_month = date('F', mktime(0, 0, 0, $edit_month1, 10));
    $edit_shiftid = $row->Shift_Id;
    $edit_date1 = $row->Date;
    $edit_date = date("d-m-Y", strtotime($edit_date1));
}
?>
<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#edit_shift_emp_id').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<style>
    .multiselect-container.dropdown-menu a .checkbox input[type="checkbox"]{
        opacity: 1;
    }
    .multiselect-container.dropdown-menu{
        height: 200px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit_shift_time_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_shift_allo_id: $('#edit_shift_allo_id').val(),
                edit_year: $('#edit_year').val(),
                edit_month: $('#edit_month').val(),
                edit_shiftid: $('#edit_shiftid').val(),
                edit_shift_emp_id: $('#edit_shift_emp_id').val(),
                edit_date: $('#edit_date').val()
            };
            $.ajax({
                url: "<?php echo site_url('Shiftallocate/edit_shift_allocate') ?>",
                type: "POST",
                data: formdata,
                success: function (data)
                {                   
                    if (data == "fail") {
                        $('#editshift_error').show();
                    }
                    else {
                        $('#editshift_error').hide();
                        $('#editshift_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editshift_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editshift_success" class="alert alert-success" style="display:none;">Shift time details updated successfully.</div>
            <div id="editshift_error" class="alert alert-danger" style="display:none;">Failed to update shift details.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="edit_shift_allo_id" id="edit_shift_allo_id" value="<?php echo $SA_Id;?>">

        <div class="col-md-3">
            <label for="field-1" class="control-label">Select Year</label>
            <?php
            define('DOB_YEAR_START', 2013);
            $current_year = date('Y');
            ?>
            <select id="edit_year" name="edit_year" class="round" disabled="disabled">
                <option value="<?php echo $edit_year; ?>"><?php echo $edit_year; ?></option>
                <?php
                for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                    echo "<option value='{$count}'>{$count}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="field-1" class="control-label">Select Month</label>
            <select class="round" id="edit_month" disabled="disabled" name="edit_month" <option value="">Select Shift Name</option>
                <option value="<?php echo $edit_month1; ?>"><?php echo $edit_month; ?></option>
                <?php
                for ($m = 1; $m <= 12; $m++) {
                    $current_month = date('m');
                    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                    ?>
                    <option value="<?php echo $m; ?>" <?php
                    if ($current_month == $m) {
                        //echo "selected=selected";
                    }
                    ?>><?php echo $month; ?></option>
                            <?php
                        }
                        ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Date</label>
                <div class="input-group">
                    <input type="text" name="edit_date" id="edit_date" disabled="disabled" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_date;?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>                                     
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Shift Name</label>
                <select name="edit_shiftid" id="edit_shiftid" class="round" data-validate="required" data-message-required="Please Select Shift Name">                    
                    <?php
                    $this->db->where('Status', 1);
                    $q_shift1 = $this->db->get('tbl_shift_details');
                    foreach ($q_shift1->result() as $row_shift1) {
                        $Shift_Id = $row_shift1->Shift_Id;
                        $Shift_Name = $row_shift1->Shift_Name;
                        $Shift_From = $row_shift1->Shift_From;
                        $Shift_To = $row_shift1->Shift_To;
                        ?>
                        <option value="<?php echo $Shift_Id; ?>" <?php if($edit_shiftid==$Shift_Id){echo "selected=selected"; } ?>>                                                
                            <?php echo $Shift_Name . " " . "(" . $Shift_From . $Shift_To . ")"; ?>                                                                        
                        </option>                                            
                        <?php
                    }
                    ?>                                                                                      
                </select>
            </div>	
        </div>
        
        
        
        <!--<div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Employee Name</label>
                <select name="edit_shift_emp_id[]" id="edit_shift_emp_id" multiple="multiple">
                    <?php
                    /*$this->db->where('Status', 1);
                    $q_employee = $this->db->get('tbl_employee');
                    foreach ($q_employee->result() as $row_employee) {
                        $Emp_Number = $row_employee->Emp_Number;
                        $Emp_FirstName = $row_employee->Emp_FirstName;
                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                        $Emp_LastName = $row_employee->Emp_LastName;

                        $get_empl_code = array(
                            "employee_number" => $Emp_Number,
                            "Status" => 1
                        );
                        $this->db->where($get_empl_code);
                        $q_emp_code = $this->db->get('tbl_emp_code');
                        foreach ($q_emp_code->result() as $row_emp_code) {
                            $emp_code = $row_emp_code->employee_code;
                        }
                        $get_emp = array(
                            "SA_Id" => $SA_Id,
                            "Status" => 1
                        );
                        $this->db->where($get_emp);
                        $q_emp = $this->db->get('tbl_shift_allocate');*/
                        ?>                       
                        <option value="<?php //echo $Emp_Number; ?>"
                        <?php
                       /* foreach ($q_emp->result() as $row_emp) {
                            $shit_emp = $row_emp->Employee_Id;
                            if ($shit_emp == $Emp_Number) {
                                echo "selected=selected";
                            }
                        }
                        ?>>
                            <?php //echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $emp_code . $Emp_Number . ")" ?>
                        </option>
                        <?php
                    }*/
                    ?>
                </select>                                         
            </div>	
        </div>-->
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>