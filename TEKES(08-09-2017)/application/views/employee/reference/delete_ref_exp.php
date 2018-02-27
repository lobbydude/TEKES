
<script>
    $(document).ready(function () {
        $("#delete_ref_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_ref_id: $('#delete_ref_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_ref_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteref_success').hide();
                        $('#deleteref_error').show();
                    }
                    else {
                        $('#deleteref_error').hide();
                        $('#deleteref_success').show();
                        $('#delete_ref_details').modal('hide');
                        $('#ref_table').load(location.href + ' #ref_table tr');
						$('#edit_exp_reference_table1').load(location.href + ' #edit_exp_reference_table1 tr');
                    }

                }

            });
        });
    });
</script>


<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteref_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteref_success" class="alert alert-success" style="display:none;">Reference details deleted successfully.</div>
            <div id="deleteref_error" class="alert alert-danger" style="display:none;">Failed to delete reference details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this reference?
            </div>	

        </div>
        <input type="hidden" name="delete_ref_id" id="delete_ref_id" value="<?php echo $ref_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
