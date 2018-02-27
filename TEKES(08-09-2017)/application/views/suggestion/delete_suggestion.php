
<script>
    $(document).ready(function () {
        $('#deletesuggestion_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_suggestion_id: $('#delete_suggestion_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Suggestion/delete_suggestion') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletesuggestion_error').show();
                    }
                    if (msg == 'success') {
                        $('#deletesuggestion_success').show();
                        window.location.reload();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deletesuggestion_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletesuggestion_success" class="alert alert-success" style="display:none;">Suggestion details deleted successfully.</div>
            <div id="deletesuggestion_error" class="alert alert-danger" style="display:none;">Failed to delete suggestion details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this suggestion?
            </div>	
        </div>

        <input type="hidden" name="delete_suggestion_id" id="delete_suggestion_id" value="<?php echo $suggestion_id; ?>">
        
    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

