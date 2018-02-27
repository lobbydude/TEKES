
<script>
    $(document).ready(function () {
        $("#deleteallowance_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_allowance_id: $('#delete_allowance_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Allowance/delete_allowance') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteallowance_error').show();
                    }
                    else {
                        $('#deleteallowance_error').hide();
                        window.location.href = "<?php echo site_url('Allowance') ?>";
                    }
                }

            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deleteallowance_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteallowance_success" class="alert alert-success" style="display:none;">Allowance details deleted successfully.</div>
            <div id="deleteallowance_error" class="alert alert-danger" style="display:none;">Failed to delete allowance details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Allowance?
            </div>	

        </div>
        <input type="hidden" name="delete_allowance_id" id="delete_allowance_id" value="<?php echo $A_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
