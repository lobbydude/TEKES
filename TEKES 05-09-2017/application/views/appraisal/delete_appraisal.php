
<script>
    $(document).ready(function () {
        $("#deleteappraisal_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_appraisal_id: $('#delete_appraisal_id').val()
            };
            
            $.ajax({
                url: "<?php echo site_url('appraisal/delete_appraisal') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteappraisal_error').show();
                    }
                    else {
                        $('#deleteappraisal_error').hide();
                        window.location.href = "<?php echo site_url('appraisal/index') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteappraisal_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteappraisal_success" class="alert alert-success" style="display:none;">Appraisal details deleted successfully.</div>
            <div id="deleteappraisal_error" class="alert alert-danger" style="display:none;">Failed to delete appraisal details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Appraisal?
            </div>	
        </div>
        <input type="hidden" name="delete_appraisal_id" id="delete_appraisal_id" value="<?php echo $AP_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
