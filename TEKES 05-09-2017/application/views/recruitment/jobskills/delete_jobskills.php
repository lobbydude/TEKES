<script>
    $(document).ready(function () {
        $("#deletejobskills_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_jobskills_id: $('#delete_jobskills_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Jobskills/delete_jobskills') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#delete_jobskills_error').show();
                    }
                    else {
                        $('#delete_jobskills_error').hide();
                        window.location.href = "<?php echo site_url('Jobskills') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="delete_jobskills_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="delete_jobskills_success" class="alert alert-success" style="display:none;">Job Skills details deleted successfully.</div>
            <div id="delete_jobskills_error" class="alert alert-danger" style="display:none;">Failed to delete Job Skills details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this Job Skills?
            </div>	

        </div>
        <input type="hidden" name="delete_jobskills_id" id="delete_jobskills_id" value="<?php echo $S_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
