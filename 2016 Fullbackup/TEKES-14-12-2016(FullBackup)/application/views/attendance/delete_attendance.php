
<script>
    $(document).ready(function () {
        $("#delete_attendance_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_att_id_in: $('#delete_att_id_in').val()
            };

            $.ajax({
                url: "<?php echo site_url('Attendance/delete_attendance') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deleteattendance_success').hide();
                        $('#deleteattendance_error').show();
                    }
                    else {
                        $('#deleteattendance_error').hide();
                        $('#deleteattendance_success').show();
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
            <div id="deleteattendance_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deleteattendance_success" class="alert alert-success" style="display:none;">Attendance deleted successfully.</div>
            <div id="deleteattendance_error" class="alert alert-danger" style="display:none;">Failed to delete attendance.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this employee attendance?
            </div>	

        </div>
        <input type="hidden" name="delete_att_id_in" id="delete_att_id_in" value="<?php echo $att_id_in; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
