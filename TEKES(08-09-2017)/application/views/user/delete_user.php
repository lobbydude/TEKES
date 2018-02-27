<?php
$emp_id = str_pad(($emp_no), 4, '0', STR_PAD_LEFT);
?>
<script>
    $(document).ready(function () {
        $('#deleteuser_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_emp_id: $('#delete_emp_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('User/delete_user') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteuser_error').show();
                    }
                    if (msg == 'success') {
                        $('#deleteuser_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deleteuser_server_error').html(msg);
                        $('#deleteuser_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deleteuser_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteuser_success" class="alert alert-success" style="display:none;">User details deleted successfully.</div>
            <div id="deleteuser_error" class="alert alert-danger" style="display:none;">Failed to delete user details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this user?
            </div>	
        </div>

        <input type="hidden" name="delete_emp_id" id="delete_emp_id" value="<?php echo $emp_id; ?>">
        
    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

