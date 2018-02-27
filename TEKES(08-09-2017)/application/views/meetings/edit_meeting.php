<?php
$this->db->where('M_Id', $M_Id);
$q = $this->db->get('tbl_meetings');
foreach ($q->result() as $row) {
    $edit_Title = $row->Title;
    $edit_Start_Date1 = $row->Start_Date;
    $edit_Start_Date = date("d-m-Y", strtotime($edit_Start_Date1));
    $edit_Start_Time = $row->Start_Time;
    $edit_End_Date1 = $row->End_Date;
    $edit_End_Date = date("d-m-Y", strtotime($edit_End_Date1));
    $edit_End_Time = $row->End_Time;
    $edit_Location = $row->Location;
    $edit_Message = $row->Message;
}
?>
<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#edit_To').multiselect({
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
<script>
    $(document).ready(function () {
        $('#editmeeting_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_meeting_id: $('#edit_meeting_id').val(), // Jquery single variable created
                edit_Title: $('#edit_Title').val(),
                edit_Start_Date: $('#edit_Start_Date').val(),
                edit_Start_Time: $('#edit_Start_Time').val(),
                edit_End_Date: $('#edit_End_Date').val(),
                edit_End_Time: $('#edit_End_Time').val(),
                edit_To: $('#edit_To').val(),
                edit_Location: $('#edit_Location').val(),
                edit_Message: $('#edit_Message').val()
            };
            $.ajax({
                url: "<?php echo site_url('Meetings/edit_meeting') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_meeting_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_meeting_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_meeting_server_error').html(msg);
                        $('#edit_meeting_server_error').show();
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_meeting_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_meeting_success" class="alert alert-success" style="display:none;">Meeting details added successfully.</div>
            <div id="edit_meeting_error" class="alert alert-danger" style="display:none;">Failed to add Meeting details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="hidden" name="edit_meeting_id" id="edit_meeting_id" value="<?php echo $M_Id; ?>">
            <div class="form-group">
                <label for="field-1" class="control-label">Title</label>
                <input type="text" name="edit_Title" id="edit_Title" class="form-control" data-validate="required" value="<?php echo $edit_Title; ?>">
            </div>	
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Start Date & Time</label>
                <div class="input-group">
                    <div class="date-and-time">
                        <input type="text" name="edit_Start_Date" id="edit_Start_Date" class="form-control datepicker" data-format="dd MM yyyy" value="<?php echo $edit_Start_Date; ?>">
                        <input type="text" name="edit_Start_Time" id="edit_Start_Time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5" data-second-step="5"  value="<?php echo $edit_Start_Time; ?>"/>
                    </div>                                                
                </div>                                     
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">End Date & Time</label>
                <div class="input-group">
                    <div class="date-and-time">
                        <input type="text" name="edit_End_Date" id="edit_End_Date" placeholder="End Date" class="form-control datepicker" data-format="dd MM yyyy" value="<?php echo $edit_End_Date; ?>">
                        <input type="text" name="edit_End_Time" id="edit_End_Time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-show-meridian="true" data-minute-step="5" data-second-step="5"  value="<?php echo $edit_End_Time; ?>"/>
                    </div>
                </div>                                     
            </div>	
        </div>
    </div>
    <div class="row">                            
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Forward To</label>
                <select name="edit_To[]" id="edit_To" multiple="multiple">                                             
                    <?php
                    $this->db->where('Status', 1);
                    $q_employee = $this->db->get('tbl_employee');
                    foreach ($q_employee->result() as $row_employee) {
                        $Emp_Number = $row_employee->Emp_Number;
                        $Emp_FirstName = $row_employee->Emp_FirstName;
                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                        $Emp_LastName = $row_employee->Emp_LastName;
                        $get_employee_code = array(
                            "employee_number" => $Emp_Number,
                            "Status" => 1
                        );
                        $this->db->where($get_employee_code);
                        $q_employee_code = $this->db->get('tbl_emp_code');
                        foreach ($q_employee_code->result() as $row_employee_code) {
                            $employee_code = $row_employee_code->employee_code;
                        }
                        $get_meetings_to = array(
                            "Meeting_Id" => $M_Id,
                            "Status" => 1
                        );
                        $this->db->where($get_meetings_to);
                        $q_meetings_to = $this->db->get('tbl_meetings_to');
                        ?>
                        <option value="<?php echo $Emp_Number; ?>" <?php
                        foreach ($q_meetings_to->result() as $row_meetings_to) {
                            $meeting_to_emp_id = $row_meetings_to->Emp_Id;
                            if ($meeting_to_emp_id == $Emp_Number) {
                                echo "selected=selected";
                            }
                        }
                        ?>><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $employee_code . $Emp_Number . ")" ?></option>
                                <?php
                            }
                            ?>      
                </select>
            </div>	
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Location</label>
                <input type="text" name="edit_Location" id="edit_Location" class="form-control" placeholder="Meeting Location" data-validate="required" data-message-required="Please enter Location" value="<?php echo $edit_Location; ?>">
            </div>	
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Agenda</label>                                        
                <textarea class="form-control" name="edit_Message" id="edit_Message" data-validate="required" data-message-required="Please enter Agenda" > <?php echo $edit_Message; ?></textarea>
            </div>	
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

