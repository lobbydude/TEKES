<?php
$this->db->where('R_Id', $resignation_id);
$q = $this->db->get('tbl_resignation');
foreach ($q->result() as $row) {
    $Notice_Date1 = $row->Notice_Date;
    $Notice_Date = date("d-m-Y", strtotime($Notice_Date1));

    $Resignation_Date1 = $row->Resignation_Date;
    $Resignation_Date = date("d-m-Y", strtotime($Resignation_Date1));

    $Reason = $row->Reason;
    $employee_id = $row->Employee_Id;

    $this->db->where('employee_number', $employee_id);
    $q_code = $this->db->get('tbl_emp_code');
    foreach ($q_code->result() as $row_code) {
        $emp_code = $row_code->employee_code;
    }


    $this->db->where('Emp_Number', $employee_id);
    $q_employee = $this->db->get('tbl_employee');
    foreach ($q_employee->result() as $row_employee) {
        $Emp_FirstName = $row_employee->Emp_FirstName;
        $Emp_Middlename = $row_employee->Emp_MiddleName;
        $Emp_LastName = $row_employee->Emp_LastName;
    }

    $Notice_Period = $row->Notice_Period;
    $LWD1 = $row->Last_Working_Date;
    $LWD = date("d-m-Y", strtotime($LWD1));

    $Extend_NP = $row->Extend_NP;
    $Extend_LWD1 = $row->Extend_LWD;
    if ($Extend_LWD1 == "" || $Extend_LWD1 == "0000-00-00") {
        $Extend_LWD = "";
    } else {
        $Extend_LWD = date("d-m-Y", strtotime($Extend_LWD1));
    }
    $Remarks = $row->Remarks;
    $Approval = $row->Approval;

    $emp_report_to_id = $row->Reporting_To;
    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_firstname = $row_emp->Emp_FirstName;
        $emp_reporting_lastname = $row_emp->Emp_LastName;
        $emp_reporting_middlename = $row_emp->Emp_MiddleName;
    }

    $Short_NP = $row->Short_NP;
    $Short_LWD1 = $row->Short_LWD;

    if ($Short_LWD1 == "" || $Short_LWD1 == "0000-00-00") {
        $Short_LWD = "";
    } else {
        $Short_LWD = date("d-m-Y", strtotime($Short_LWD1));
    }

    $HR_Reason = $row->HR_Reason;
    $HR_Final_Date1 = $row->HR_FinalSettlement_Date;
    if ($HR_Final_Date1 == "" || $HR_Final_Date1 == "0000-00-00") {
        $HR_Final_Date = "";
    } else {
        $HR_Final_Date = date("d-m-Y", strtotime($HR_Final_Date1));
    }
    $HR_Remarks = $row->HR_Remarks;
    $exit_by = $row->exit_by;
}
?>

<script>
    $(document).ready(function () {
        $('#resignation_status_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                resignation_id: $('#resignation_id').val(),
                employee_id: $('#employee_id').val(),
                hr_reason: $('#hr_reason').val(),
                final_settlement: $('#final_settlement').val(),
                hr_remarks: $('#hr_remarks').val(),
                short_notice_period: $('#short_notice_period').val(),
                exit_by: $('#exit_by').val()

            };
            $.ajax({
                url: "<?php echo site_url('Resignation/exit_resignation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#exitresignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#exitresignation_success').show();
                        window.location.reload();
                    }

                }

            });
        });
    });

    function short_noticeperiod(lwd, resigned_date, actual_notice_period) {
        var startnewdate = resigned_date.split("-").reverse().join("-");
        var endnewdate = lwd.split("-").reverse().join("-");
        var start = new Date(startnewdate);
        var end = new Date(endnewdate);
        var diff = new Date(end - start);
        var days = diff / 1000 / 60 / 60 / 24;
        if (actual_notice_period > days) {
            var shortnoticedays = actual_notice_period - days;
            document.getElementById('short_notice_period').value = shortnoticedays;
        } else {
            document.getElementById('short_notice_period').value = "";
        }
    }
</script>
<div class="modal-body">
    <input type="hidden" name="resignation_id" id="resignation_id" value="<?php echo $resignation_id; ?>">
    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id; ?>">
    <div class="row">
        <?php
        $user_role = $this->session->userdata('user_role');
        if ($user_role == 2 || $user_role == 6) {
            ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Employee Code : </label>
                    <?php echo $emp_code . $employee_id ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-3" class="control-label">Employee Name : </label>
                    <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?>
                </div>
            </div>
        <?php } ?>


        <div class="col-md-5">
            <div class="form-group">
                <label for="field-3" class="control-label">Reporting Manager : </label>
                <?php echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename . "(" . $emp_code . $emp_report_to_id . ")"; ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Letter Date : </label>
                <?php echo $Notice_Date; ?>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Resignation Date : </label>
                <?php echo $Resignation_Date; ?>
            </div>	
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Notice Period : </label>
                <?php echo $Notice_Period . " Days"; ?>
            </div>	
        </div>
        <input type="hidden" name="resignation_date" id="resignation_date" value="<?php echo $Resignation_Date; ?>">
        <input type="hidden" name="actual_notice_period" id="actual_notice_period" value="<?php echo $Notice_Period; ?>">

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Last Working Date : </label>
                <?php echo $LWD; ?>
            </div>	
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="field-3" class="control-label">Reason : </label>
                <?php echo $Reason; ?>
            </div>	
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Manager Status : </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Manager Approval : </label>
                <?php
                if ($Approval == "Request") {
                    echo "Processing ... ";
                }if ($Approval == "Yes") {
                    ?>
                    Approved
                    <?php
                }if ($Approval == "No") {
                    ?>
                    Not Approved
                    <?php
                }
                if ($Approval == "Cancel") {
                    ?>
                    Cancelled
                    <?php
                }
                ?>

            </div>
        </div>

        <?php
        if ($Approval == "Yes") {
            ?>            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-3" class="control-label">Notice Period Extension : </label>
                    <?php echo $Extend_NP . " Days"; ?>
                </div>	
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-3" class="control-label">Last Working Date : </label>
                    <?php echo $Extend_LWD; ?>
                </div>	
            </div>

        <?php } ?>
        <div class="col-md-7">
            <div class="form-group">
                <label for="field-3" class="control-label">Remarks : </label>
                <?php echo $Remarks; ?>
            </div>	
        </div>
    </div>

    <?php if ($user_role == 2 || $user_role==6) { ?>
        <div class="row">
            <div class="col-md-12">
                <h3>HR Status : </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Reason : </label>
                    <select id="hr_reason" name="hr_reason" class="round" data-validate="required" data-message-required="Please select reason.">
                        <option value="<?php echo $HR_Reason; ?>"><?php echo $HR_Reason; ?></option>
                        <option value="Better Salary">Better Salary</option>
                        <option value="Career Change">Career Change</option>
                        <option value="Better Opportunity">Better Opportunity</option>
                        <option value="Personal Reason">Personal Reason</option>
                        <option value="Family Issue">Family Issue</option>
                        <option value="Health Issue">Health Issue</option>
                        <option value="Further Education">Further Education</option>
                        <option value="Retirement">Retirement</option>
                        <option value="Termination - Absconding">Termination - Absconding</option>
                        <option value="Termination - Absentee">Termination - Absentee</option>
                        <option value="Termination - Disciplinary Issue">Termination - Disciplinary Issue</option>
						<option value="Termination - Performance Issue">Termination - Performance Issue</option>
                        <option value="Contract End">Contract End</option>
                        <option value="Project End">Project End</option>
                        <option value="Lay Off">Lay Off</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="final_lwd" id="final_lwd" value="<?php echo $HR_Final_Date; ?>">

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Full & Final Settlement/LWD: </label>
                    <div class="input-group">
                        <input type="text" name="final_settlement" id="final_settlement" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please select date." value="<?php echo $HR_Final_Date; ?>" onchange="short_noticeperiod(this.value, $('#resignation_date').val(), $('#actual_notice_period').val())">
                        <div class="input-group-addon">
                            <a href="#"><i class="entypo-calendar"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Short Notice Days : </label>
                    <div class="input-group">
                        <input type="text" name="short_notice_period" id="short_notice_period" class="form-control" placeholder="Notice Period" value="<?php echo $Short_NP; ?>" >
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary">Days</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Exit Feedback: </label>
                    <textarea type="text" name="hr_remarks" id="hr_remarks" class="form-control"><?php echo $HR_Remarks; ?></textarea>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Exit By : </label>
                    <input type="text" name="exit_by" id="exit_by" class="form-control" value="<?php echo $exit_by; ?>">
                </div>
            </div>

        </div>
    <?php } ?>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">Close</button>
</div>
<!-- Print option query Start here-->
<script>
    function resignation_print(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
 }
 </script>
<!-- Print option query End here-->
<!-- Letter Print the Table format-->
 
 <div id="resignation_print" style="display: none;">    

<h2 align="center"> Resignation</h2>
<p align="right">Letter Date : <?php echo $Notice_Date; ?></p>
<p align="right">Resignation Date : <?php echo $Resignation_Date; ?></p>  
  
<p>Emp.Name :  <?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></p>
<p>Emp.Code :  <?php echo $emp_code . $employee_id ?></p>
<p>Notice Period : <?php echo $Notice_Period . " Days"; ?></p>
<p>Last Working Date : <?php echo $LWD; ?></p>
<p>Reporting Manager : <?php echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename . "(" . $emp_code . $emp_report_to_id . ")"; ?>
</p>
<p>Subject : <b>Resignation Letter</b></p>

<p>Dear Sir,</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Reason; ?> </p><br/>
       
<h4><b>Manager Status</b></h4>
<p>Manager Approval :  Approved </p>
<p>Notice Period Extension : <?php echo $Extend_NP . " Days"; ?></p>
<p>Last Working Date : <?php echo $Extend_LWD; ?></p>
<p>Manager Remarks  : <?php echo $Remarks; ?></p><br/>

<h4><b>HR Status</b></h4>
<p>Reason : <?php echo $HR_Reason; ?></p>
<p>Full & Final Settlement : <?php echo $HR_Final_Date; ?></p>
<p>Short Notice Days : <?php echo $Short_NP . " Days"; ?></p>
<p>HR Exit Feedback  : <?php echo $HR_Remarks; ?></p>
<p>Exit By : <?php echo $exit_by; ?></p>
   
</div>
 