
<script>
    $(document).ready(function () {
        $('#deletebranch_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_branch_id: $('#delete_branch_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/delete_branch') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletebranch_error').show();
                    }
                    if (msg == 'success') {
                        $('#deletebranch_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deletebranch_server_error').html(msg);
                        $('#deletebranch_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deletebranch_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletebranch_success" class="alert alert-success" style="display:none;">Branch details deleted successfully.</div>
            <div id="deletebranch_error" class="alert alert-danger" style="display:none;">Failed to delete branch details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this branch?
            </div>	
        </div>

        <input type="hidden" name="delete_branch_id" id="delete_branch_id" value="<?php echo $branch_id; ?>">

    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

