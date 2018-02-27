
<script>
    $(document).ready(function () {
        $('#deletesubdepartment_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_subdepartment_id: $('#delete_subdepartment_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/delete_subdepartment') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletesubdepartment_error').show();
                    }
                    if (msg == 'success') {
                        $('#deletesubdepartment_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deletesubdepartment_server_error').html(msg);
                        $('#deletesubdepartment_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deletesubdepartment_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletesubdepartment_success" class="alert alert-success" style="display:none;">Sub Department details deleted successfully.</div>
            <div id="deletesubdepartment_error" class="alert alert-danger" style="display:none;">Failed to delete sub department details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this client?
            </div>	
        </div>

        <input type="hidden" name="delete_subdepartment_id" id="delete_subdepartment_id" value="<?php echo $subdepartment_id; ?>">
        
    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

