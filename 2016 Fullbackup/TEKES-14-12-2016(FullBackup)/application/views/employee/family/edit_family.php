<?php
$this->db->where('Family_Id', $family_id);
$q = $this->db->get('tbl_employee_family');
foreach ($q->result() as $row) {
    $name = $row->Name;
    $age = $row->Age;
    $family_dateofbirth = $row->DOB;
    $dob = date("d-m-Y", strtotime($family_dateofbirth));
    $relationship = $row->Relationship;
    $gender = $row->Gender;
    $occupation = $row->Occupation;
}
?>

<script>
    function getAge(DOB) {
        var d = new Date();
        var bits = DOB.split('-')
        d.setHours(0, 0, 0, 0); //normalise
        d.setFullYear(bits[2])
        d.setMonth(bits[1] - 1)
        d.setDate(bits[0])
        var now = new Date();
        now.setHours(0, 0, 0, 0); //normalise
        var years = now.getFullYear() - d.getFullYear();
        d.setFullYear(now.getFullYear())
        var diff = now.getTime() - d.getTime()
        if (diff < 0)
            years--;
        document.getElementById('edit_family_member_age').value = years;
    }

    $(document).ready(function () {
        $('#edit_family_details_form').submit(function (e) {
            e.preventDefault();
            var gender;
            if (document.getElementById("edit_relation_male_gender").checked) {
                gender = document.getElementById("edit_relation_male_gender").value;
            } else {
                gender = document.getElementById("edit_relation_female_gender").value;
            }
            var formdata = {
                edit_family_id: $('#edit_family_id').val(),
                edit_family_member_name: $('#edit_family_member_name').val(),
                edit_family_member_dob: $('#edit_family_member_dob').val(),
                edit_family_member_age: $('#edit_family_member_age').val(),
                edit_family_member_relationship: $('#edit_family_member_relationship').val(),
                edit_family_member_gender: gender,
                edit_family_member_occupation: $('#edit_family_member_occupation').val()

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_family_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editfamily_error').show();
                    }
                    if (msg == 'success') {
                        $('#editfamily_error').hide();
                        $('#editfamily_success').show();
                        $('#edit_family_details').modal('hide');
                        $('#edit_family_table').load(location.href + ' #edit_family_table tr');
                    $('#edit_family_table1').load(location.href + ' #edit_family_table1 tr');
					}
                }
            });
        });
    });

</script>


<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editfamily_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editfamily_success" class="alert alert-success" style="display:none;">Family details updated successfully.</div>
            <div id="editfamily_error" class="alert alert-danger" style="display:none;">Failed to update family details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Name</label>
                <input class="form-control" name="family_member_name" id="edit_family_member_name" data-validate="required" data-message-required="Please enter name."  value="<?php echo $name; ?>"/>
            </div>
        </div>
        <input type="hidden" name="edit_family_id" id="edit_family_id" value="<?php echo $family_id ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Date of Birth</label>
                <div class="input-group">
                    <input type="text" name="family_member_dob" id="edit_family_member_dob" class="form-control datepicker" data-format="dd-mm-yyyy" onchange="getAge(this.value)" value="<?php echo $dob; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Age</label>
                <input class="form-control" name="family_member_age" id="edit_family_member_age" data-validate="number" maxlength="2" disabled="disabled" value="<?php echo $age; ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Relationship</label>
                <input class="form-control" name="family_member_relationship" id="edit_family_member_relationship" data-validate="required" data-message-required="Please enter relation." value="<?php echo $relationship; ?>"/>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <div class="col-md-12">
                    <label for="gender" class="control-label">Gender</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" value="male" name="relation_gender" id="edit_relation_male_gender" <?php
                    if ($gender == "male") {
                        echo 'checked';
                    }
                    ?>>
                    <label>Male</label>
                </div>
                <div class="col-md-6">
                    <input type="radio" value="female" name="relation_gender" id="edit_relation_female_gender" <?php
                    if ($gender == "female") {
                        echo 'checked';
                    }
                    ?>>
                    <label>Female</label>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">Occupation</label>
                <input class="form-control" name="edit_family_member_occupation" id="edit_family_member_occupation" value="<?php echo $occupation; ?>"/>
            </div>
        </div>


    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="submit" name="family_button" id="family_button">Update</button>
    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
</div>

