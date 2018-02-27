
<script>
    $(document).ready(function () {
        $("#delete_family_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_family_id: $('#delete_family_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_family_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletefamily_success').hide();
                        $('#deletefamily_error').show();
                    }
                    else {
                        $('#deletefamily_error').hide();
                        $('#deletefamily_success').show();
                        $('#delete_family_details').modal('hide');
                        $('#edit_family_table').load(location.href + ' #edit_family_table tr');
						$('#edit_family_table1').load(location.href + ' #edit_family_table1 tr');
                    }

                }

            });
        });
    });
</script>

<script type="text/javascript">
    function deletefamilyupdate_function() {
        $('#edit_family_table').load(location.href + ' #edit_family_table');
    }
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deletefamily_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletefamily_success" class="alert alert-success" style="display:none;">Family details deleted successfully.</div>
            <div id="deletefamily_error" class="alert alert-danger" style="display:none;">Failed to delete family details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this member from family?
            </div>	

        </div>
        <input type="hidden" name="delete_family_id" id="delete_family_id" value="<?php echo $family_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
