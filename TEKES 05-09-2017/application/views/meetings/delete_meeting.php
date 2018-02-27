<script>
    $(document).ready(function () {
        $("#deletemeeting_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_meeting_id: $('#delete_meeting_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Meetings/delete_meeting') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletemeeting_error').show();
                    }
                    else {
                        $('#deletemeeting_error').hide();
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
            <div id="deletemeeting_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletemeeting_success" class="alert alert-success" style="display:none;">Meeting details deleted successfully.</div>
            <div id="deletemeeting_error" class="alert alert-danger" style="display:none;">Failed to delete Meeting details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="form-group">
                Are you sure want to delete this Meeting?
            </div>	

        </div>
        <input type="hidden" name="delete_meeting_id" id="delete_meeting_id" value="<?php echo $M_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
