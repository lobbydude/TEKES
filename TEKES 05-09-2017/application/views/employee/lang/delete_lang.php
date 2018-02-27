
<script>
    $(document).ready(function () {
        $("#delete_lang_details_form").submit(function (e) {
            e.preventDefault();
            var formdata = {
                delete_lang_id: $('#delete_lang_id').val()
            };

            $.ajax({
                url: "<?php echo site_url('Employee/delete_lang_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#deletelang_success').hide();
                        $('#deletelang_error').show();
                    }
                    else {
                        $('#deletelang_error').hide();
                        $('#deletelang_success').show();
                        $('#delete_lang_details').modal('hide');
                        $('#edit_lang_table').load(location.href + ' #edit_lang_table tr');
						$('#edit_lang_table1').load(location.href + ' #edit_lang_table1 tr');
                    }

                }

            });
        });
    });
</script>

<script type="text/javascript">
    function deletelangupdate_function() {
        $('#edit_lang_table').load(location.href + ' #edit_lang_table');
    }
</script>

<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="deletelang_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="deletelang_success" class="alert alert-success" style="display:none;">Language details deleted successfully.</div>
            <div id="deletelang_error" class="alert alert-danger" style="display:none;">Failed to delete language details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                Are you sure want to delete this language?
            </div>	

        </div>
        <input type="hidden" name="delete_lang_id" id="delete_lang_id" value="<?php echo $lang_id; ?>">
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
