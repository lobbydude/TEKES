<script>
    $(document).ready(function () {
        $("#cancelmeeting_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                cancel_meeting_id: $('#cancel_meeting_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Meetings/cancel_meeting') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#cancelmeeting_error').show();
                    }
                    else {
                        $('#cancelmeeting_error').hide();
                        window.location.href = "<?php echo site_url('Meetings') ?>";
                    }
                }

            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="cancelmeeting_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="cancelmeeting_success" class="alert alert-success" style="display:none;">Meeting details Cancel successfully.</div>
            <div id="cancelmeeting_error" class="alert alert-danger" style="display:none;">Failed to Cancel Meeting details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to Cancel this Meeting?
            </div>	
        </div>
        <input type="hidden" name="cancel_meeting_id" id="cancel_meeting_id" value="<?php echo $M_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
