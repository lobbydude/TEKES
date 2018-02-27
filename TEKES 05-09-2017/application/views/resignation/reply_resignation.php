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
}
?>

<script>
    function show_lwd(notice_period, lwd) {
        var period = parseInt(notice_period);
        var last = lwd.split("-");
        var last_Date = new Date(last[2], last[1] - 1, last[0]);
        var newdate = new Date(last_Date);

        newdate.setDate(newdate.getDate() + period);

        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();

        var someFormattedDate = dd + '-' + mm + '-' + y;
        document.getElementById('reply_last_working_date').value = someFormattedDate;
    }

    function approval_status(approval) {
        if (approval == "Yes") {
            document.getElementById('approval_div').style.display = "block";
        } else {
            document.getElementById('approval_div').style.display = "none";
        }
    }

    $(document).ready(function () {
        $('#replyresignation_form').submit(function (e) {
            e.preventDefault();
            var approval;
            if (document.getElementById("approval_yes").checked) {
                approval = document.getElementById("approval_yes").value;
            } else {
                approval = document.getElementById("approval_no").value;
            }

            var formdata = {
                resignation_id: $('#resignation_id').val(),
                approval: approval,
                reply_notice_period: $('#reply_notice_period').val(),
                reply_last_working_date: $('#reply_last_working_date').val(),
                reply_remarks: $('#reply_remarks').val()
            };
            $.ajax({
                url: "<?php echo site_url('Resignation/reply_resignation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#replyresignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#replyresignation_success').show();
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
            <div id="replyresignation_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="replyresignation_success" class="alert alert-success" style="display:none;">Resignation status sent successfully.</div>
            <div id="replyresignation_error" class="alert alert-danger" style="display:none;">Failed to send resignation status.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" id="resignation_id" name="resignation_id" value="<?php echo $resignation_id ?>">
        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Letter Date : </label>
                <?php echo $Notice_Date; ?>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Resignation Date : </label>
                <?php echo $Resignation_Date; ?>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Notice Period : </label>
                <?php echo $Notice_Period . " Days"; ?>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Last Working Date : </label>
                <?php echo $LWD; ?>
                <input type="hidden" value="<?php echo $LWD ?>" name="lwd" id="lwd">
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
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Manager Approval</label>
                <div class="col-md-6">
                    <div class="radio">
                        <input type="radio" id="approval_yes" name="approval" onclick="approval_status('Yes')" value="Yes" <?php
                        if ($Approval == "Yes" || $Approval == "Request") {
                            echo "checked";
                        }
                        ?>>
                        <label>Yes</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="radio">
                        <input type="radio" id="approval_no" onclick="approval_status('No')" name="approval" value="No" <?php
                        if ($Approval == "No") {
                            echo "checked";
                        }
                        ?>>
                        <label>No</label>
                    </div>
                </div>
            </div>
        </div>

        <div id="approval_div">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Notice Period Extension</label>
                    <div class="input-group">
                        <input type="text" name="reply_notice_period" id="reply_notice_period" class="form-control" placeholder="Notice Period" data-validate="required,number" data-message-required="Please enter notice period." onchange="show_lwd(this.value, $('#lwd').val())" value="<?php echo $Extend_NP; ?>">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary">Days</button>
                        </span>
                    </div>
                </div>	
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="field-3" class="control-label">Last Working Date</label>
                    <input type="text" name="reply_last_working_date" id="reply_last_working_date" class="form-control" disabled="disabled" value="<?php echo $Extend_LWD; ?>" >
                </div>	
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Remarks</label>
                <input type="text" name="reply_remarks" id="reply_remarks" class="form-control" value="<?php echo $Remarks; ?>">
            </div>	
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>