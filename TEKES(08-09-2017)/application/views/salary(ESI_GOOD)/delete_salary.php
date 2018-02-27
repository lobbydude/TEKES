
<script>
    $(document).ready(function () {
        $('#deletesalary_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_salary_id: $('#delete_salary_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Salary/delete_salary') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == 'fail') {
                        $('#deletesalary_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#deletesalary_success').show();
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
            <div id="deletesalary_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletesalary_success" class="alert alert-success" style="display:none;">Salary details deleted successfully.</div>
            <div id="deletesalary_error" class="alert alert-danger" style="display:none;">Failed to delete salary details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                Are you sure want to delete this salary details?
            </div>	
        </div>

        <input type="hidden" name="delete_salary_id" id="delete_salary_id" value="<?php echo $salary_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

