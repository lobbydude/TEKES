<script>
    $(document).ready(function () {
        $("#deleteleavecompoff_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_leavecompoff_id: $('#delete_leavecompoff_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Leaves/delete_leavecompoff') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteleavecompoff_error').show();
                    }
                    else {
                        $('#deleteleavecompoff_error').hide();
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
            <div id="deleteleavecompoff_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteleavecompoff_success" class="alert alert-success" style="display:none;">Leave Compoff details deleted successfully.</div>
            <div id="deleteleavecompoff_error" class="alert alert-danger" style="display:none;">Failed to delete Leave Compoff details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Comp off?
            </div>	
        </div>
        <input type="hidden" name="delete_leavecompoff_id" id="delete_leavecompoff_id" value="<?php echo $C_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
