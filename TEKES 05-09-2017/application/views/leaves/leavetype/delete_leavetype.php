<script>
    $(document).ready(function () {
        $("#deleteleavetype_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_leavetype_id: $('#delete_leavetype_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Leaves/delete_leavetype') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteleavetype_error').show();
                    }
                    else {
                        $('#deleteleavetype_error').hide();
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
            <div id="deleteleavetype_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteleavetype_success" class="alert alert-success" style="display:none;">Leave type details deleted successfully.</div>
            <div id="deleteleavetype_error" class="alert alert-danger" style="display:none;">Failed to delete Leave type details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Leave Type?
            </div>	
        </div>
        <input type="hidden" name="delete_leavetype_id" id="delete_leavetype_id" value="<?php echo $L_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
