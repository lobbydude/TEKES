<?php
$this->db->where('Ref_Id', $ref_id);
$q = $this->db->get('tbl_employee_referencedetails');
foreach ($q->result() as $row) {
    $fullname = $row->Privious_Comp_FullName;
    $company_name = $row->Privious_Comp_Name;
    $designation = $row->Privious_Comp_Designation;
    $email = $row->Privious_Comp_Email;
    $mobile = $row->Privious_Comp_Mobile;
    $telephone = $row->Privious_Comp_Telephone;
}
?>

<script>


    $(document).ready(function () {
        $('#edit_ref_details_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_ref_id: $('#edit_ref_id').val(),
                edit_prev_cmpref_fullname: $('#edit_prev_cmpref_fullname').val(),
                edit_prev_cmpref_name: $('#edit_prev_cmpref_name').val(),
                edit_prev_cmpref_designation: $('#edit_prev_cmpref_designation').val(),
                edit_prev_cmpref_email: $('#edit_prev_cmpref_email').val(),
                edit_prev_cmpref_mobile: $('#edit_prev_cmpref_mobile').val(),
                edit_prev_cmpref_telephone: $('#edit_prev_cmpref_telephone').val()

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_ref_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editref_error').show();
                    }
                    if (msg == 'success') {
                        $('#editref_error').hide();
                        $('#editref_success').show();
                        $('#edit_ref_details').modal('hide');
                        $('#ref_table').load(location.href + ' #ref_table tr');
						$('#edit_exp_reference_table1').load(location.href + ' #edit_exp_reference_table1 tr');
                    }
                }
            });
        });
    });

</script>


<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editref_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editref_success" class="alert alert-success" style="display:none;">Reference details updated successfully.</div>
            <div id="editref_error" class="alert alert-danger" style="display:none;">Failed to update reference details.</div>
        </div>
    </div>


    <div class="row">
        <input type="hidden" name="edit_ref_id" id="edit_ref_id" value="<?php echo $ref_id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Reporting Manager Name</label>
                <input class="form-control" name="edit_prev_cmpref_fullname" id="edit_prev_cmpref_fullname" data-validate="required" data-message-required="Please enter name." value="<?php echo $fullname ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Company Name</label>
                <input class="form-control" name="edit_prev_cmpref_name" id="edit_prev_cmpref_name" placeholder="Company Name" data-validate="required" data-message-required="Please enter company name." value="<?php echo $company_name ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Designation</label>
                <input class="form-control" name="edit_prev_cmpref_designation" id="edit_prev_cmpref_designation" data-validate="required" data-message-required="Please enter designation." value="<?php echo $designation ?>" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Professional Email Id</label>
                <input class="form-control" name="edit_prev_cmpref_email" id="edit_prev_cmpref_email" data-validate="email" data-message-required="Please enter email address." value="<?php echo $email ?>"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Mobile Number</label>
                <input class="form-control" name="edit_prev_cmpref_mobile" id="edit_prev_cmpref_mobile" data-validate="required,number" data-message-required="Please enter mobile number." maxlength="15" value="<?php echo $mobile ?>"/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Telephone Number</label>
                <input class="form-control" name="edit_prev_cmpref_telephone" id="edit_prev_cmpref_telephone" data-validate="number" data-message-required="Please enter telephone number." maxlength="15" value="<?php echo $telephone ?>"/>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="submit">Update</button>
    <button class="btn btn-default" type="reset">Clear</button>
</div>


