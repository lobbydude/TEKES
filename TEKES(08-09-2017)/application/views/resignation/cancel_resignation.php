<script>
    $(document).ready(function () {
        $('#cancelresignation_form').submit(function (e) {
            e.preventDefault();
          
            var formdata = {
                resignation_id: $('#resignation_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Resignation/cancel_resignation') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#cancelresignation_error').show();
                    }
                    if (msg == 'success') {
                        $('#cancelresignation_success').show();
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
            <div id="cancelresignation_success" class="alert alert-success" style="display:none;">Resignation was cancelled successfully.</div>
            <div id="cancelresignation_error" class="alert alert-danger" style="display:none;">Failed to cancel resignation.</div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" id="resignation_id" name="resignation_id" value="<?php echo $resignation_id ?>">
        <p>Are you sure want to cancel your resignation?</p>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Send</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>