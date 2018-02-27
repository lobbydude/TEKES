<script>
    $(document).ready(function () {
        $("#deleteiprinfo_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_kpmaster_id: $('#delete_iprmaster_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Ipr/delete_iprmaster') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {                    
                    if (msg == 'fail') {
                        $('#delete_iprmaster_error').show();
                    }
                    else {
                        $('#delete_iprmaster_error').hide();
                        window.location.href = "<?php echo site_url('Ipr/IPR_Info') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="delete_iprmaster_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="delete_iprmaster_success" class="alert alert-success" style="display:none;">Ipr details deleted successfully.</div>
            <div id="delete_iprmaster_error" class="alert alert-danger" style="display:none;">Failed to delete Ipr details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this IPR Info detail?
            </div>	

        </div>
        <input type="hidden" name="delete_iprmaster_id" id="delete_iprmaster_id" value="<?php echo $Kp_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
