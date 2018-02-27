<?php
$this->db->where('Shift_Id', $shift_id);
$q = $this->db->get('tbl_shift_details');
foreach ($q->result() as $row) {
    $shift_name = $row->Shift_Name;
    $shift_from = $row->Shift_From;
    $shift_to = $row->Shift_To;
}
?>

<script src="<?php echo site_url('js/bootstrap-timepicker.min.js') ?>"></script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editshift_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editshift_success" class="alert alert-success" style="display:none;">Shift details updated successfully.</div>
            <div id="editshift_error" class="alert alert-danger" style="display:none;">Failed to update shift details.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" name="edit_shift_id" id="edit_shift_id" value="<?php echo $shift_id; ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Shift Name</label>
                <input type="text" name="edit_shift_name" id="edit_shift_name" class="form-control" placeholder="Shift Name" data-validate="required" data-message-required="Please enter shift name." value="<?php echo $shift_name; ?>">
            </div>	
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="field-3" class="control-label">From</label>
                <div class="input-group minimal">
                    <div class="input-group-addon">
                        <i class="entypo-clock"></i>
                    </div>
                    <input type="text" name="edit_shift_from" id="edit_shift_from" class="form-control timepicker" data-validate="required" data-message-required="Please enter time." value="<?php echo $shift_from; ?>"/>
                </div>
            </div>	
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="field-3" class="control-label">To</label>
                <div class="input-group minimal">
                    <div class="input-group-addon">
                        <i class="entypo-clock"></i>
                    </div>
                    <input type="text" name="edit_shift_to" id="edit_shift_to" class="form-control timepicker" data-validate="required" data-message-required="Please enter time." value="<?php echo $shift_to; ?>"/>
                </div>
            </div>	
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


<script type="text/javascript">
    $(document).ready(function (e) {
        $("#editshift_form").on('submit', (function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo site_url('Shift/edit_shift') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
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
        }));
    });
</script>