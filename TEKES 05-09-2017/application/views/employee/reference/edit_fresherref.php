<?php
$this->db->where('Fresher_RefId', $resherref_id);
$q = $this->db->get('tbl_employee_fresherref');
foreach ($q->result() as $row) {
    $name = $row->Name;
    $relationship = $row->Relationship;
    $occupation = $row->Occupation;
    $mobile = $row->Mobile_Number;
    $email = $row->Email_Id;
}
?>

<script>


    $(document).ready(function () {
        $('#edit_fresherref_details_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_fresherref_id: $('#edit_fresherref_id').val(),
                edit_reference_person_name: $('#edit_reference_person_name').val(),
                edit_reference_person_relation: $('#edit_reference_person_relation').val(),
                edit_reference_person_occupation: $('#edit_reference_person_occupation').val(),
                edit_reference_person_mobile: $('#edit_reference_person_mobile').val(),
                edit_reference_person_email: $('#edit_reference_person_email').val()

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_fresherref_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editfresherref_error').show();
                    }
                    if (msg == 'success') {
                        $('#editfresherref_error').hide();
                        $('#editfresherref_success').show();
                        $('#edit_fresherref_details').modal('hide');
                        $('#fresherref_table').load(location.href + ' #fresherref_table tr');
						 $('#edit_fresher_reference_table1').load(location.href + ' #edit_fresher_reference_table1 tr');
                    }
                }
            });
        });
    });

</script>


<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editfresherref_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editfresherref_success" class="alert alert-success" style="display:none;">Reference details updated successfully.</div>
            <div id="editfresherref_error" class="alert alert-danger" style="display:none;">Failed to update reference details.</div>
        </div>
    </div>


    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Reference Person Name</label>
                <input class="form-control" name="edit_reference_person_name" id="edit_reference_person_name" data-validate="required" data-message-required="Please enter name." value="<?php echo $name ?>"/>
            </div>
        </div>
        <input type="hidden" name="edit_fresherref_id" id="edit_fresherref_id" value="<?php echo $resherref_id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Relationship</label>
                <input class="form-control" name="edit_reference_person_relation" id="edit_reference_person_relation" data-validate="required" data-message-required="Please enter relationship." value="<?php echo $relationship ?>" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Occupation</label>
                <input class="form-control" name="edit_reference_person_occupation" id="edit_reference_person_occupation" data-validate="required" data-message-required="Please enter occupation." value="<?php echo $occupation ?>" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Mobile Number</label>
                <input class="form-control" name="edit_reference_person_mobile" id="edit_reference_person_mobile" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15" value="<?php echo $mobile ?>"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Email Id</label>
                <input class="form-control" name="edit_reference_person_email" id="edit_reference_person_email" data-validate="email" data-message-required="Please enter email address." value="<?php echo $email; ?>"/>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="submit">Update</button>
    <button class="btn btn-default" type="reset">Clear</button>
</div>


