
<script>
    $(document).ready(function () {
        $("#delete_fresherref_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_fresherref_id: $('#delete_fresherref_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_fresherref_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletefresherref_success').hide();
                        $('#deletefresherref_error').show();
                    }
                    else {
                        $('#deletefresherref_error').hide();
                        $('#deletefresherref_success').show();
                        $('#delete_fresherref_details').modal('hide');
                        $('#fresherref_table').load(location.href + ' #fresherref_table tr');
						$('#edit_fresher_reference_table1').load(location.href + ' #edit_fresher_reference_table1 tr');
                    }

                }

            });
        });
    });
</script>


<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deletefresherref_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletefresherref_success" class="alert alert-success" style="display:none;">Reference details deleted successfully.</div>
            <div id="deletefresherref_error" class="alert alert-danger" style="display:none;">Failed to delete reference details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this reference?
            </div>	

        </div>
        <input type="hidden" name="delete_fresherref_id" id="delete_fresherref_id" value="<?php echo $resherref_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
