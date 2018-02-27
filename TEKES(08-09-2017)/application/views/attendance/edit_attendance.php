<?php
$this->db->where('A_Id', $att_id_in);
$q_in = $this->db->get('tbl_attendance');
foreach ($q_in->result() as $row_in) {
    $Login_Date1 = $row_in->Login_Date;
    $Login_Date = date("d-m-Y", strtotime($Login_Date1));
    $Login_Time = $row_in->Login_Time;
    $Employee_Id = $row_in->Emp_Id;
	$shitname = $row_in->Shift_Name;

    $this->db->where('Emp_Number', $Employee_Id);
    $select_emp = $this->db->get('tbl_employee');
    foreach ($select_emp->result() as $row_emp) {
        $employee_first_name = $row_emp->Emp_FirstName;
        $employee_middle_name = $row_emp->Emp_MiddleName;
        $employee_last_name = $row_emp->Emp_LastName;
    }
    
     $Logout_Date1 = $row_in->Logout_Date;
    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
    $Logout_Time = $row_in->Logout_Time;
    $Comments = $row_in->Comments;
}
?>
<script>
    $(document).ready(function () {
        $('#edit_attendance_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_att_id_in: $('#edit_att_id_in').val(),
                edit_att_login_date: $('#edit_att_login_date').val(),
                edit_att_login_time: $('#edit_att_login_time').val(),
                edit_att_logout_date: $('#edit_att_logout_date').val(),
                edit_att_logout_time: $('#edit_att_logout_time').val(),
				edit_shiftname: $('#edit_shiftname').val(),
				edit_comments: $('#edit_comments').val()
            };
            $.ajax({
                url: "<?php echo site_url('Attendance/edit_attendance') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editattendance_error').show();
                    }
                    if (msg == 'success') {
                        $('#editattendance_error').hide();
                        $('#editattendance_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editattendance_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editattendance_success" class="alert alert-success" style="display:none;">Attendance updated successfully.</div>
            <div id="editattendance_error" class="alert alert-danger" style="display:none;">Failed to update attendance.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Employee Name</label>
                <input class="form-control" name="att_employee_name" id="att_employee_name"  value="<?php echo $employee_first_name . " " . $employee_last_name . " " . $employee_middle_name; ?>" disabled="disabled"/>
            </div>
        </div>
        <input type="hidden" name="edit_att_id_in" id="edit_att_id_in" value="<?php echo $att_id_in ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Login Date</label>
                <div class="input-group">
                    <input type="text" name="edit_att_login_date" id="edit_att_login_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $Login_Date; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Login Time</label>
                <input type="text" name="edit_att_login_time" id="edit_att_login_time" class="form-control timepicker" placeholder="H:i:s" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5" value="<?php echo $Login_Time; ?>"/>
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Logout Date</label>
                <div class="input-group">
                    <input type="text" name="edit_att_logout_date" id="edit_att_logout_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $Logout_Date; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Logout Time</label>
                <input type="text" name="edit_att_logout_time" id="edit_att_logout_time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5" value="<?php echo $Logout_Time; ?>"/>
            </div>
        </div>
		<div class="col-md-2">
            <div class="form-group">
                <label for="field-2" class="control-label">Shift Name</label>
                <input type="text" name="edit_shiftname" id="edit_shiftname" class="form-control" value="<?php echo $shitname;?>">
            </div>	
        </div>
		<div class="col-md-5">
            <div class="form-group">
                <label for="field-2" class="control-label">Comments</label>
                <textarea name="edit_comments" id="edit_comments" class="form-control"><?php echo $Comments; ?></textarea>
            </div>	
        </div>
		<!--<div class="col-md-3">
            <div class="form-group">
                <label for="field-1" class="control-label">Shift Time</label>
                <select name="edit_shift_time" id="edit_shift_time" class="round" data-validate="required" data-message-required="Please Select Shift Name">                    
                    <?php
                    // Get (Retrieve the code) the the values in tables
                    //$this->db->where('SA_Id', $SA_Id);
                    /*$q = $this->db->get('tbl_shift_allocate');
                    foreach ($q->result() as $row) {
                        $edit_year = $row->Year;
                        $edit_month1 = $row->Month;
                        $edit_month = date('F', mktime(0, 0, 0, $edit_month1, 10));
                        $edit_shiftid = $row->Shift_Id;
                        $edit_date1 = $row->Date;
                        $edit_date = date("d-m-Y", strtotime($edit_date1));
                    }
                    // Display values
                    $this->db->where('Status', 1);
                    $q_shift1 = $this->db->get('tbl_shift_details');
                    foreach ($q_shift1->result() as $row_shift1) {
                        $Shift_Id = $row_shift1->Shift_Id;
                        $Shift_Name = $row_shift1->Shift_Name;
                        $Shift_From = $row_shift1->Shift_From;
                        $Shift_To = $row_shift1->Shift_To;
                        ?>
                        <option value="<?php echo $Shift_Id; ?>" <?php if($edit_shiftid==$Shift_Id){echo "selected=selected"; } ?>>                                                
                            <?php echo $Shift_Name . " " . "(" . $Shift_From . " - " . $Shift_To . ")"; ?>                                                                        
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
    <button class="btn btn-primary" type="submit" >Update</button>
    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
</div>

