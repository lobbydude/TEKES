
<script>
    $(document).ready(function () {
        $('#deleteholiday_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_holiday_id: $('#delete_holiday_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Holidays/delete_holiday') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteholiday_error').show();
                    }
                    if (msg == 'success') {
                        $('#deleteholiday_success').show();
                        window.location.reload();
                    }
                    else if (msg != 'fail' && msg != 'success') {
                        $('#deleteholiday_server_error').html(msg);
                        $('#deleteholiday_server_error').show();
                    }
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="deleteholiday_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteholiday_success" class="alert alert-success" style="display:none;">Holiday details deleted successfully.</div>
            <div id="deleteholiday_error" class="alert alert-danger" style="display:none;">Failed to delete holiday details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this holiday?
            </div>	
        </div>
        <input type="hidden" name="delete_holiday_id" id="delete_holiday_id" value="<?php echo $holiday_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>

