<script>
    $(document).ready(function () {
        $("#deletejobtitle_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_jobtitle_id: $('#delete_jobtitle_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Recruitment/delete_jobtitle') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#delete_jobtitle_error').show();
                    }
                    else {
                        $('#delete_jobtitle_error').hide();
                        window.location.href = "<?php echo site_url('recruitment/index') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="delete_jobtitle_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="delete_jobtitle_success" class="alert alert-success" style="display:none;">Job Title details deleted successfully.</div>
            <div id="delete_jobtitle_error" class="alert alert-danger" style="display:none;">Failed to delete Job title details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this Job Title?
            </div>	

        </div>
        <input type="hidden" name="delete_jobtitle_id" id="delete_jobtitle_id" value="<?php echo $J_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
