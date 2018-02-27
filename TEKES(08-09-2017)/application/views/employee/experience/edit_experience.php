<?php
$this->db->where('Privious_Comp_ExpId', $exp_id);
$q = $this->db->get('tbl_employee_expdetails');
foreach ($q->result() as $row) {
    $Previouscompany = $row->Previouscompany;
    $Privious_Comp_Location = $row->Privious_Comp_Location;
    $Privious_Comp_Designation = $row->Privious_Comp_Designation;
    $Privious_Comp_Joineddate = $row->Privious_Comp_Joineddate;
    $doj = date("d-m-Y", strtotime($Privious_Comp_Joineddate));
    $Privious_Comp_LeavedDate = $row->Privious_Comp_LeavedDate;
    $dor = date("d-m-Y", strtotime($Privious_Comp_LeavedDate));
    $Privious_Comp_ExpType = $row->Privious_Comp_ExpType;
    $Privious_Comp_ReasonforLeaving = $row->Privious_Comp_ReasonforLeaving;
    $Privious_Comp_Gross_Salray = $row->Privious_Comp_Gross_Salray;
}
?>

<script>

    $(document).ready(function () {
        $('#edit_exp_details_form').submit(function (e) {
            e.preventDefault();

            var relevant_exp;
            if (document.getElementById("edit_relevant_exp").checked) {
                relevant_exp = document.getElementById("edit_relevant_exp").value;
            } else {
                relevant_exp = document.getElementById("edit_non_relevant_exp").value;
            }
            var formdata = {
                edit_exp_id: $('#edit_exp_id').val(),
                edit_prev_company_name: $('#edit_prev_company_name').val(),
                edit_prev_company_location: $('#edit_prev_company_location').val(),
                edit_prev_designation: $('#edit_prev_designation').val(),
                edit_prev_date_joined: $('#edit_prev_date_joined').val(),
                edit_prev_date_relieved: $('#edit_prev_date_relieved').val(),
                relevant_exp: relevant_exp,
                edit_prev_reason_relieving: $('#edit_prev_reason_relieving').val(),
                edit_prev_salary: $('#edit_prev_salary').val()

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_experience_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editexp_error').show();
                    }
                    if (msg == 'success') {
                        $('#editexp_error').hide();
                        $('#editexp_success').show();
                        $('#edit_exp_details').modal('hide');
                        $('#edit_exp_table').load(location.href + ' #edit_exp_table tr');
						 $('#edit_exp_table1').load(location.href + ' #edit_exp_table1 tr');

                    }
                }

            });
        });
    });

</script>
<script type="text/javascript">
    function editexpupdate_function() {
        $('#edit_exp_table').load(location.href + ' #edit_exp_table');
    }
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editexp_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editexp_success" class="alert alert-success" style="display:none;">Experience details updated successfully.</div>
            <div id="editexp_error" class="alert alert-danger" style="display:none;">Failed to update experience details.</div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Company Name</label>
                <input class="form-control" name="edit_prev_company_name" id="edit_prev_company_name" placeholder="Company Name" data-validate="required" data-message-required="Please enter company name."  value="<?php echo $Previouscompany; ?>"/>
            </div>
        </div>
        <input type="hidden" value="<?php echo $exp_id; ?>" name="edit_exp_id" id="edit_exp_id">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Location</label>
                <input class="form-control" name="edit_prev_company_location" id="edit_prev_company_location" data-validate="required" data-message-required="Please enter location." value="<?php echo $Privious_Comp_Location; ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Designation</label>
                <input class="form-control" name="edit_prev_designation" id="edit_prev_designation" data-validate="required" data-message-required="Please enter designation." value="<?php echo $Privious_Comp_Designation; ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Date of Joined</label>
                <div class="input-group">
                    <input type="text" name="edit_prev_date_joined" id="edit_prev_date_joined" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date of joined." value="<?php echo $doj; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Date of Relieved</label>
                <div class="input-group">
                    <input type="text" name="edit_prev_date_relieved" id="edit_prev_date_relieved" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date of relieved." value="<?php echo $dor; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label">Type</label>
                </div>
                <input type="radio" id="edit_relevant_exp" name="relevant" value="relevant" <?php
                if ($Privious_Comp_ExpType == "relevant") {
                    echo "checked";
                }
                ?>>
                <label>Relevant Experience</label>
                <input type="radio" id="edit_non_relevant_exp" name="relevant" value="non-relevant" <?php
                if ($Privious_Comp_ExpType == "non-relevant") {
                    echo "checked";
                }
                ?>>
                <label>Non-Relevant Experience</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Reason for Relieving</label>
                <input type="text" class="form-control" name="edit_prev_reason_relieving" id="edit_prev_reason_relieving" data-validate="required" data-message-required="Please enter reason for relieving." value="<?php echo $Privious_Comp_ReasonforLeaving; ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Salary</label>
                <input class="form-control" name="edit_prev_salary" id="edit_prev_salary" data-validate="required" data-message-required="Please enter salary." value="<?php echo $Privious_Comp_Gross_Salray; ?>"/>
            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="submit" name="edit_exp_button" id="family_button">Update</button>
    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
</div>

