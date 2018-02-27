<?php
$this->db->where('Skill_Id', $skills_id);
$q = $this->db->get('tbl_employee_skills');
foreach ($q->result() as $row) {
    $skill_name = $row->Skill_Name;
    $months = $row->Months;
    $training = $row->Training;
    $skill_from = $row->Skill_From;
    $from = date("d-m-Y", strtotime($skill_from));
    $skill_to = $row->Skill_To;
    $to = date("d-m-Y", strtotime($skill_to));
}
?>

<script>

    $(document).ready(function () {
        $('#edit_skills_details_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_skills_id: $('#edit_skills_id').val(),
                edit_skill_name: $('#edit_skill_name').val(),
                edit_no_of_month: $('#edit_no_of_month').val(),
                edit_training: $('#edit_training').val(),
                edit_skill_from: $('#edit_skill_from').val(),
                edit_skill_to: $('#edit_skill_to').val()

            };
            $.ajax({
                url: "<?php echo site_url('Employee/edit_skills_details') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editskills_error').show();
                    }
                    if (msg == 'success') {
                        $('#editskills_error').hide();
                        $('#editskills_success').show();
                        $('#edit_skills_details').modal('hide');
                        $('#edit_skill_table').load(location.href + ' #edit_skill_table tr');
						$('#edit_skill_table1').load(location.href + ' #edit_skill_table1 tr');
                    }
                }

            });
        });
    });

</script>
<script type="text/javascript">
    function editskillsupdate_function() {
        $('#edit_skill_table').load(location.href + ' #edit_skill_table');
    }
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editskills_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editskills_success" class="alert alert-success" style="display:none;">Skills details updated successfully.</div>
            <div id="editskills_error" class="alert alert-danger" style="display:none;">Failed to update skill details.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Skills</label>
                <input class="form-control" name="edit_skill_name" id="edit_skill_name" data-validate="required" placeholder="Skills" data-message-required="Please enter skill name." value="<?php echo $skill_name; ?>"/>
            </div>
        </div>
        <input type="hidden" name="edit_skills_id" id="edit_skills_id" value="<?php echo $skills_id; ?>">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">No of Months</label>
                <input class="form-control" name="edit_no_of_month" id="edit_no_of_month" placeholder="Months" data-validate="required,number" data-message-required="Please enter months." maxlength="2" value="<?php echo $months; ?>"/>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Training</label>
                <input class="form-control" name="edit_training" id="edit_training" placeholder="Training" data-validate="required" data-message-required="Please enter training." value="<?php echo $training; ?>"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">From</label>
                <div class="input-group">
                    <input type="text" name="edit_skill_from" id="edit_skill_from" class="form-control datepicker" data-validate="required" data-message-required="Please enter starting date." data-mask="dd-mm-yyyy" value="<?php echo $from; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">To</label>
                <div class="input-group">
                    <input type="text" name="edit_skill_to" id="edit_skill_to" class="form-control datepicker" data-validate="required" data-message-required="Please enter ending date." data-mask="dd-mm-yyyy" value="<?php echo $to; ?>">
                    <div class="input-group-addon">
                        <a href="#"><i class="entypo-calendar"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary" type="submit">Update</button>
    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
</div>

