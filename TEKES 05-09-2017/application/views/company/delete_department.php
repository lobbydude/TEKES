
<script>
    $(document).ready(function () {
        $('#deletedepartment_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_department_id: $('#delete_department_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/delete_department') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletedepartment_error').show();
                    }
                    if (msg == 'success') {
                        $('#deletedepartment_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deletedepartment_server_error').html(msg);
                        $('#deletedepartment_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deletedepartment_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletedepartment_success" class="alert alert-success" style="display:none;">Department details deleted successfully.</div>
            <div id="deletedepartment_error" class="alert alert-danger" style="display:none;">Failed to delete department details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this department?
            </div>	
        </div>

        <input type="hidden" name="delete_department_id" id="delete_department_id" value="<?php echo $department_id; ?>">
        
    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

