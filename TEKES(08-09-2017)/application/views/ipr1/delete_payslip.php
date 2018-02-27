
<script>
    $(document).ready(function () {
        $('#deletepayslip_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_payslip_id: $('#delete_payslip_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Payslip/delete_payslip') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#deletepayslip_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#deletepayslip_success').show();
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
            <div id="deletepayslip_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletepayslip_success" class="alert alert-success" style="display:none;">Payslip details deleted successfully.</div>
            <div id="deletepayslip_error" class="alert alert-danger" style="display:none;">Failed to delete Payslip details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Payslip details?
            </div>	
        </div>
        
        <input type="hidden" name="delete_payslip_id" id="delete_payslip_id" value="<?php echo $payslip_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>