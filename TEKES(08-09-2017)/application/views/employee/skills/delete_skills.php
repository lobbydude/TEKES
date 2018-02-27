
<script>
    $(document).ready(function () {
        $("#delete_skills_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_skills_id: $('#delete_skills_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_skills_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteskills_success').hide();
                        $('#deleteskills_error').show();
                    }
                    else {
                        $('#deleteskills_error').hide();
                        $('#deleteskills_success').show();
                        $('#delete_skills_details').modal('hide');
                        $('#edit_skill_table').load(location.href + ' #edit_skill_table tr');
						$('#edit_skill_table1').load(location.href + ' #edit_skill_table1 tr');
                    }

                }

            });
        });
    });
</script>

<script type="text/javascript">
    function deleteskillsupdate_function() {
        $('#edit_skill_table').load(location.href + ' #edit_skill_table');
    }
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteskills_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteskills_success" class="alert alert-success" style="display:none;">Sill details deleted successfully.</div>
            <div id="deleteskills_error" class="alert alert-danger" style="display:none;">Failed to delete skill details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this skills?
            </div>	

        </div>
        <input type="hidden" name="delete_skills_id" id="delete_skills_id" value="<?php echo $skills_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
