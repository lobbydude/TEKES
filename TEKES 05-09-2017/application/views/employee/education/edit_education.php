<?php
$this->db->where('Emp_QualificationId', $edu_id);
$q = $this->db->get('tbl_employee_educationdetails');
foreach ($q->result() as $row) {
    $Course_Name = $row->Course_Name;
    $University = $row->University;
    $College_Name = $row->College_Name;
    $Major_Subject = $row->Major_Subject;
    $Marks = $row->Marks;
    $Year = $row->Year;
}
?>

<script>

    $(document).ready(function () {
        $('#edit_edu_details_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_edu_id: $('#edit_edu_id').val(),
                edit_qualification: $('#edit_qualification').val(),
                edit_university_name: $('#edit_university_name').val(),
                edit_college_name: $('#edit_college_name').val(),
                edit_major_subject: $('#edit_major_subject').val(),
                edit_marks: $('#edit_marks').val(),
                edit_year_of_passing: $('#edit_year_of_passing').val()

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_education_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editeducation_error').show();
                    }
                    if (msg == 'success') {
                        $('#editeducation_error').hide();
                        $('#editeducation_success').show();
                        $('#edit_edu_details').modal('hide');
                        $('#edit_education_table').load(location.href + ' #edit_education_table tr');
						$('#edit_education_table1').load(location.href + ' #edit_education_table1 tr');
                    }
                }

            });
        });
    });

</script>

<script type="text/javascript">
    function editeduupdate_function() {
        $('#edit_education_table').load(location.href + ' #edit_education_table');
    }
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editeducation_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editeducation_success" class="alert alert-success" style="display:none;">Education details updated successfully.</div>
            <div id="editeducation_error" class="alert alert-danger" style="display:none;">Failed to update education details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Qualification</label>
                <input class="form-control" name="edit_qualification" id="edit_qualification" data-validate="required" placeholder="Qualification" data-message-required="Please enter qualification." value="<?php echo $Course_Name; ?>"/>
            </div>
        </div>
        <input type="hidden" name="edit_edu_id" id="edit_edu_id" value="<?php echo $edu_id ?>">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">University</label>
                <input class="form-control" name="edit_university_name" id="edit_university_name" placeholder="University Name" data-validate="required" data-message-required="Please enter university name." value="<?php echo $University; ?>"/>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">School/College Name</label>
                <input class="form-control" name="edit_college_name" id="edit_college_name" placeholder="College Name" data-validate="required" data-message-required="Please enter college name." value="<?php echo $College_Name; ?>"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Major Subject</label>
                <input class="form-control" name="edit_major_subject" id="edit_major_subject" placeholder="Major Subject" data-validate="required" data-message-required="Please enter major subject." value="<?php echo $Major_Subject; ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">% Marks</label>
                <input class="form-control" name="edit_marks" id="edit_marks" placeholder="% Marks" data-validate="required,number" data-message-required="Please enter marks in %." value="<?php echo $Marks; ?>"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Year of Passing</label>
                <input class="form-control" name="edit_year_of_passing" id="edit_year_of_passing" placeholder="Year" data-validate="required,number" data-message-required="Please enter year of passing." maxlength="4" value="<?php echo $Year; ?>"/>
            </div>
        </div>

    </div>
</div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="submit">Update</button>
    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
</div>

