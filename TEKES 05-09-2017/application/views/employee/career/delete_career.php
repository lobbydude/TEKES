
<script>
    $(document).ready(function () {
        $('#deletecareer_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_career_id: $('#delete_career_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Employee/delete_career') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletecareer_error').show();
                    }
                    if (msg == 'success') {
                        $('#deletecareer_success').show();
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
            <div id="deletecareer_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletecareer_success" class="alert alert-success" style="display:none;">Career details deleted successfully.</div>
            <div id="deletecareer_error" class="alert alert-danger" style="display:none;">Failed to delete career details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this career details?
            </div>	
        </div>

        <input type="hidden" name="delete_career_id" id="delete_career_id" value="<?php echo $career_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

