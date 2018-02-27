<script>
    $(document).ready(function () {
        $("#deletevendortype_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_vendortype_id: $('#delete_vendortype_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Vendor/delete_vendortype') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#delete_vendortype_error').show();
                    }
                    else {
                        $('#delete_vendortype_error').hide();
                        window.location.href = "<?php echo site_url('Vendor') ?>";
                    }

                }

            });
        });
    });
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="delete_vendortype_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="delete_vendortype_success" class="alert alert-success" style="display:none;">Vendor Type details deleted successfully.</div>
            <div id="delete_vendortype_error" class="alert alert-danger" style="display:none;">Failed to delete Vendor Type details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this Vendor Type?
            </div>	

        </div>
        <input type="hidden" name="delete_vendortype_id" id="delete_vendortype_id" value="<?php echo $V_Id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
