<?php
$this->db->where('R_Id', $termination_id);
$q = $this->db->get('tbl_resignation');
foreach ($q->result() as $row) {
    $employee_id = $row->Employee_Id;
}
?>
<script>
    $(document).ready(function () {
        $('#canceltermination_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                termination_id: $('#termination_id').val(),
                employee_id: $('#employee_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Termination/CancelTermination') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#canceltermination_success').hide();
                        $('#canceltermination_error').show();
                    }
                    if (msg == 'success') {
                        $('#canceltermination_error').hide();
                        $('#canceltermination_success').show();
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
            <div id="canceltermination_success" class="alert alert-success" style="display:none;">Termination was canceled successfully.</div>
            <div id="canceltermination_error" class="alert alert-danger" style="display:none;">Failed to cancel termination.</div>
        </div>
    </div>
    <input type="hidden" name="termination_id" id="termination_id" value="<?php echo $termination_id; ?>">
    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id; ?>">
    <div class="row">
        <p>Are you sure want to cancel this termination?</p>
    </div>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Yes</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
