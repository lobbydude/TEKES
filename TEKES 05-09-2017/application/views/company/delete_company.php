
<script>
    $(document).ready(function () {
        $("#deletecompany_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_company_id: $('#delete_company_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Company/delete_company') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletecompany_error').show();
                    }
                    else {
                        $('#deletecompany_error').hide();
                        window.location.href = "<?php echo site_url('Company/Index') ?>";
                    }

                }

            });
        });
    });
</script>


<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deletecompany_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletecompany_success" class="alert alert-success" style="display:none;">Company details deleted successfully.</div>
            <div id="deletecompany_error" class="alert alert-danger" style="display:none;">Failed to delete company details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this company?
            </div>	

        </div>
        <input type="hidden" name="delete_company_id" id="delete_company_id" value="<?php echo $company_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
