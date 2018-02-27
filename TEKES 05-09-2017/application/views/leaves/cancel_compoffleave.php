<script>
    $(document).ready(function () {
        $("#cancelcompoffleave_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                cancel_leave_id: $('#cancel_leave_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Leaves/Cancel_CompOffLeave') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#cancel_compoffleave_error').show();
                    }
                     if (msg == 'success') {
                        $('#cancel_compoffleave_error').hide();
                        $('#cancel_compoffleave_success').hide();
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
            <div id="cancel_compoffleave_success" class="alert alert-success" style="display:none;">Leave canceled successfully.</div>
            <div id="cancel_compoffleave_error" class="alert alert-danger" style="display:none;">Failed to cancel the leave.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to cancel this compoff leave?
            </div>	
        </div>
        <input type="hidden" name="cancel_leave_id" id="cancel_leave_id" value="<?php echo $leave_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

