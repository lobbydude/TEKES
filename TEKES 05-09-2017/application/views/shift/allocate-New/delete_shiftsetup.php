<script>
    $(document).ready(function () {
        $("#deleteshift_time_form").submit(function (e) {
            e.preventDefault(e);
            var formdata = {
                delete_shift_time_id: $('#delete_shift_time_id').val()
            };
            $.ajax({                
                url: "<?php echo site_url('Shiftallocate/delete_shiftallocate') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#delete_shift_time_error').show();
                    }
                    else {
                        $('#delete_shift_time_error').hide();
                        window.location.href = "<?php echo site_url('Shiftallocate') ?>";                        
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="delete_shift_time_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="delete_shift_time_success" class="alert alert-success" style="display:none;">Shift time details deleted successfully.</div>
            <div id="delete_shift_time_error" class="alert alert-danger" style="display:none;">Failed to Shift Time details.</div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete employee shift time?
            </div>	
        </div>
        <input type="hidden" name="delete_shift_time_id" id="delete_shift_time_id" value="<?php echo $SA_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>