
<script>
    $(document).ready(function () {
        $('#deletedesignation_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_designation_id: $('#delete_designation_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/delete_designation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletedesignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#deletedesignation_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deletedesignation_server_error').html(msg);
                        $('#deletedesignation_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deletedesignation_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletedesignation_success" class="alert alert-success" style="display:none;">Designation details deleted successfully.</div>
            <div id="deletedesignation_error" class="alert alert-danger" style="display:none;">Failed to delete designation details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this designation?
            </div>	
        </div>
        <input type="hidden" name="delete_designation_id" id="delete_designation_id" value="<?php echo $designation_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

