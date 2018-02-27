<script>
    $(document).ready(function () {
        $('#deletearrear_payslip_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_arrear_payslip_id: $('#delete_arrear_payslip_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Payslip/delete_arrear_payslip') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#deletearrear_payslip_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#deletearrear_payslip_success').show();
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
            <div id="deletearrear_payslip_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletearrear_payslip_success" class="alert alert-success" style="display:none;">Arrear details deleted successfully.</div>
            <div id="deletearrear_payslip_error" class="alert alert-danger" style="display:none;">Failed to delete arrear details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this Arrear details?
            </div>	
        </div>
        
        <input type="hidden" name="delete_arrear_payslip_id" id="delete_arrear_payslip_id" value="<?php echo $payslip_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>