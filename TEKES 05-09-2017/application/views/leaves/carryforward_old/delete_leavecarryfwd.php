<script>
    $(document).ready(function () {
        $("#deleteleavecarryforward_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_leavecarryfwd_id: $('#delete_leavecarryfwd_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Leaves/delete_leavecarryforward') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteleavecarryfwd_error').show();
                    }
                    else {
                        $('#deleteleavecarryfwd_error').hide();
                        $('#deleteleavecarryfwd_success').show();
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
            <div id="deleteleavecarryfwd_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteleavecarryfwd_success" class="alert alert-success" style="display:none;">Leave Carry Forward deleted successfully.</div>
            <div id="deleteleavecarryfwd_error" class="alert alert-danger" style="display:none;">Failed to delete Leave carry forward.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Leave Carry Forward?
            </div>	
        </div>
        <input type="hidden" name="delete_leavecarryfwd_id" id="delete_leavecarryfwd_id" value="<?php echo $L_Id; ?>">
    </div>
</div>
<div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:65%;left:45%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
