
<script>
    $(document).ready(function () {
        $("#deleteemployee_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_employee_id: $('#delete_employee_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_employee') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteemployee_error').show();
                    }
                    else {
                        $('#deleteemployee_error').hide();
                        window.location.href = "<?php echo site_url('Employee') ?>";
                    }

                }

            });
        });
    });
</script>


<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deleteemployee_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteemployee_success" class="alert alert-success" style="display:none;">Employee details deleted successfully.</div>
            <div id="deleteemployee_error" class="alert alert-danger" style="display:none;">Failed to delete employee details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this employee?
            </div>	

        </div>
        <input type="hidden" name="delete_employee_id" id="delete_employee_id" value="<?php echo $emp_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
