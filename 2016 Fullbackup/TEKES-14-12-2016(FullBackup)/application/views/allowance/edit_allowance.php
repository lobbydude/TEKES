<?php
$this->db->where('A_Id', $A_Id);
$q = $this->db->get('tbl_allowance');
foreach ($q->result() as $row) {
    $edit_allowance_name = $row->Allowance_Name;   
    $edit_allowance_amount = $row->Allowance_Amount;
    $edit_start_date = $row->Allowance_Startdate;
    $edit_end_date = $row->Allowance_Enddate;
}
?>

<script>
    $(document).ready(function () {
        $('#editallowance_form').submit(function (e) {
            e.preventDefault();
            var formdata = {            
              edit_allowance_id: $('#edit_allowance_id').val(), 
              edit_allowance_name: $('#edit_allowance_name').val(),              
              edit_allowance_amount: $('#edit_allowance_amount').val(),
              edit_start_date: $('#edit_start_date').val(),
              edit_end_date: $('#edit_end_date').val()
            };
            $.ajax({             
                url: "<?php echo site_url('Allowance/edit_allowance') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editallowance_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#editallowance_success').show();
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
            <div id="editallowance_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editallowance_success" class="alert alert-success" style="display:none;">Allowance details updated successfully.</div>
            <div id="editallowance_error" class="alert alert-danger" style="display:none;">Failed to update allowance details.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_allowance_id" id="edit_allowance_id" value="<?php echo $A_Id; ?>">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Allowance Name</label>
                <input type="text" name="edit_allowance_name" id="edit_allowance_name" class="form-control" value="<?php echo $edit_allowance_name; ?>">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-3" class="control-label">Amount</label>
                <div class="input-group">
                    <input type="text" name="edit_allowance_amount" id="edit_allowance_amount" class="form-control" value="<?php echo $edit_allowance_amount; ?>" >
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary">Rs</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Start Date</label>
                <div class="input-group">
                    <input type="text" name="edit_start_date" id="edit_start_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_start_date; ?>">                    
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>                                     
            </div>	
        </div>        
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">End Date</label>
                <div class="input-group">
                    <input type="text" name="edit_end_date" id="edit_end_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_end_date; ?>">                    
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>                                     
            </div>	
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>