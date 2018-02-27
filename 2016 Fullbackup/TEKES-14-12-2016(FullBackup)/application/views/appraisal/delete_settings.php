
<script>
    $(document).ready(function () {
        $("#deletesettings_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_settings_id: $('#delete_settings_id').val()
            };
            
            $.ajax({
                url: "<?php echo site_url('appraisal/delete_settings') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletesettings_error').show();
                    }
                    else {
                        $('#deletesettings_error').hide();
                       window.location.href = "<?php echo site_url('appraisal/permission') ?>";
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deletesettings_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletesettings_success" class="alert alert-success" style="display:none;">Appraisal details deleted successfully.</div>
            <div id="deletesettings_error" class="alert alert-danger" style="display:none;">Failed to delete appraisal details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Appraisal person?
            </div>	
        </div>
        <input type="hidden" name="delete_settings_id" id="delete_settings_id" value="<?php echo $A_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
