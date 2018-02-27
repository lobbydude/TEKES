
<script>
    $(document).ready(function () {
        $("#deleteannouncement_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_announcement_id: $('#delete_announcement_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Announcement/delete_announcement') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteannouncement_error').show();
                    }
                    else {
                        $('#deleteannouncement_error').hide();
                        window.location.href = "<?php echo site_url('announcement/index') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteannouncement_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteannouncement_success" class="alert alert-success" style="display:none;">announcement details deleted successfully.</div>
            <div id="deleteannouncement_error" class="alert alert-danger" style="display:none;">Failed to delete announcement details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this Announcement?
            </div>	

        </div>
        <input type="hidden" name="delete_announcement_id" id="delete_announcement_id" value="<?php echo $A_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
