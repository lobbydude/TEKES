
<script>
    $(document).ready(function () {
        $("#delete_exp_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_exp_id: $('#delete_exp_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_experience_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteexp_success').hide();
                        $('#deleteexp_error').show();
                    }
                    else {
                        $('#deleteexp_error').hide();
                        $('#deleteexp_success').show();
                        $('#delete_exp_details').modal('hide');
                        $('#edit_exp_table').load(location.href + ' #edit_exp_table tr');
						$('#edit_exp_table1').load(location.href + ' #edit_exp_table1 tr');
                    }
                }
            });
        });
    });
</script>

<script type="text/javascript">
    function deleteexpupdate_function() {
        $('#edit_exp_table').load(location.href + ' #edit_exp_table');
    }
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteexp_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteexp_success" class="alert alert-success" style="display:none;">Experience details deleted successfully.</div>
            <div id="deleteexp_error" class="alert alert-danger" style="display:none;">Failed to delete experience details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this experience?
            </div>	

        </div>
        <input type="hidden" name="delete_exp_id" id="delete_exp_id" value="<?php echo $exp_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
