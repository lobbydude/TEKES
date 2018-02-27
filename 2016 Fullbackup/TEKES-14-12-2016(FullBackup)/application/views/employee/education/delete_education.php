
<script>
    $(document).ready(function () {
        $("#delete_edu_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_edu_id: $('#delete_edu_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_education_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteedu_success').hide();
                        $('#deleteedu_error').show();
                    }
                    else {
                        $('#deleteedu_error').hide();
                        $('#deleteedu_success').show();
                        $('#delete_edu_details').modal('hide');
                        $('#edit_education_table').load(location.href + ' #edit_education_table tr');
						$('#edit_education_table1').load(location.href + ' #edit_education_table1 tr');
                    }

                }

            });
        });
    });
</script>

<script type="text/javascript">
    function deleteeduupdate_function() {
        $('#edit_education_table').load(location.href + ' #edit_education_table');
    }
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteedu_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteedu_success" class="alert alert-success" style="display:none;">Education details deleted successfully.</div>
            <div id="deleteedu_error" class="alert alert-danger" style="display:none;">Failed to delete education details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this education?
            </div>	

        </div>
        <input type="hidden" name="delete_edu_id" id="delete_edu_id" value="<?php echo $edu_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
