<script>
    $(document).ready(function () {
        $("#deletejobpost_Requisitions_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_jobpost_id: $('#delete_jobpost_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Recruitment/delete_jobpost') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#delete_jobpost_error').show();
                    }
                    else {
                        $('#delete_jobpost_error').hide();
                        window.location.href = "<?php echo site_url('Recruitment/Jobpost') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="delete_jobpost_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="delete_jobpost_success" class="alert alert-success" style="display:none;">Job Post details deleted successfully.</div>
            <div id="delete_jobpost_error" class="alert alert-danger" style="display:none;">Failed to delete Job Post details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this Job Post Requisitions?
            </div>	

        </div>
        <input type="hidden" name="delete_jobpost_id" id="delete_jobpost_id" value="<?php echo $JP_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>