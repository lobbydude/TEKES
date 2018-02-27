
<script>
    $(document).ready(function () {
        $('#deleteshift_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_shift_id: $('#delete_shift_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Shift/delete_shift') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteshift_error').show();
                    }
                    if (msg == 'success') {
                        $('#deleteshift_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deleteshift_server_error').html(msg);
                        $('#deleteshift_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deleteshift_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteshift_success" class="alert alert-success" style="display:none;">Shift details deleted successfully.</div>
            <div id="deleteshift_error" class="alert alert-danger" style="display:none;">Failed to delete shift details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this shift?
            </div>	
        </div>

        <input type="hidden" name="delete_shift_id" id="delete_shift_id" value="<?php echo $shift_id; ?>">
        
    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

