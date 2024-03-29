<?php
$emp_no = $this->uri->segment(3);
$this->db->where('Sal_Id', $salary_id);
$q_salary = $this->db->get('tbl_salary_info');
foreach ($q_salary->result() as $row_salary) {
    $Employee_Id = $row_salary->Employee_Id;
    $C_CTC = $row_salary->C_CTC;
    $Monthly_CTC = $row_salary->Monthly_CTC;
    $from_date = $row_salary->From_Date;
    $from = date("d-m-Y", strtotime($from_date));
    $to_date = $row_salary->To_Date;
    if ($to_date == "0000-00-00") {
        $to = "";
    } else {
        $to = date("d-m-Y", strtotime($to_date));
    }
    $edit_salary_performance_bonus = $row_salary->Performance_Bonus;
    $edit_salary_comments = $row_salary->Salary_Comments;
    $edit_salary_original_AnnualCTC = $row_salary->Original_AnnualCTC;   
}
?>
<script>
    $(document).ready(function () {
        $('#editsalary_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_salary_id: $('#edit_salary_id').val(),
                edit_salary_CCTC: $('#edit_salary_CCTC').val(),
                edit_salary_MonthlyCTC: $('#edit_salary_MonthlyCTC').val(),
                edit_salary_from: $('#edit_salary_from').val(),
                edit_salary_to: $('#edit_salary_to').val(),
                edit_salary_performance_bonus: $('#edit_salary_performance_bonus').val(),
                edit_salary_comments: $('#edit_salary_comments').val(),
                edit_salary_original_AnnualCTC: $('#edit_salary_original_AnnualCTC').val()
            };
            $.ajax({
                url: "<?php echo site_url('Salary/edit_salary') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#editsalary_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#editsalary_success').show();
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
            <div id="editsalary_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editsalary_success" class="alert alert-success" style="display:none;">Salary details updated successfully.</div>
            <div id="editsalary_error" class="alert alert-danger" style="display:none;">Failed to update salary details.</div>
        </div>
    </div>
    <input type="hidden" name="edit_salary_id" id="edit_salary_id" value="<?php echo $salary_id; ?>">
    <div class="row">
        <?php
        // Performance Bonus 10% deducted in Particular Employees only        
        if ($Employee_Id == "0009" || $Employee_Id == "0011" || $Employee_Id == "0018" || $Employee_Id == "0023" || $Employee_Id == "0038" || $Employee_Id == "0058" || $Employee_Id == "0064" || $Employee_Id == "0106" || $Employee_Id == "0156") {
            ?>        	
            <div class="col-md-3">
                <div class="form-group">
                    <label for="field-3" class="control-label">Original CTC</label>                                        
                    <input type="text" name="edit_salary_original_AnnualCTC" id="edit_salary_original_AnnualCTC" class="form-control" value="<?php echo $edit_salary_original_AnnualCTC; ?>">
                </div>	
            </div>     
        <?php } ?> 
                
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">Current Annual CTC</label>
                <div class="input-group">
                    <input type="text" name="edit_salary_CCTC" id="edit_salary_CCTC" class="form-control" value="<?php echo $C_CTC; ?>" onchange="$('#edit_salary_MonthlyCTC').val($(this).val() / 12)">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">Monthly CTC</label>
                <div class="input-group">
                    <input type="text" name="edit_salary_MonthlyCTC" id="edit_salary_MonthlyCTC" class="form-control" disabled="disabled" value="<?php echo $Monthly_CTC; ?>">                    
                </div>
            </div>
        </div> 
                
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">Performance Bonus</label>
                <div class="input-group">
                    <input type="text" name="edit_salary_performance_bonus" id="edit_salary_performance_bonus" class="form-control" value="<?php echo $edit_salary_performance_bonus; ?>">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">From</label>
                <div class="input-group">
                    <input type="text" name="edit_salary_from" id="edit_salary_from" class="form-control datepicker" placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date." value="<?php echo $from; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="full_name">To</label>
                <div class="input-group">
                    <input type="text" name="edit_salary_to" id="edit_salary_to" class="form-control datepicker"  placeholder="dd-mm-yyyy" data-format="dd-mm-yyyy" data-mask="dd-mm-yyyy" data-validate="required" data-message-required="Please select date." value="<?php echo $to; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Comments</label>                                
                <textarea class="form-control" name="edit_salary_comments" id="edit_salary_comments"><?php echo $edit_salary_comments; ?></textarea>
            </div>	
        </div>
        
            
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>