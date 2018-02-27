<?php
$this->db->where('L_Id', $L_Id);
$q = $this->db->get('tbl_leave_carryforward_type');
foreach ($q->result() as $row) {
    $Start_Month = $row->Start_Month;
    $Start_Year = $row->Start_Year;
    $End_Month = $row->End_Month;
    $End_Year = $row->End_Year;
}
?>

<script>
    $(document).ready(function () {
        $('#editleavecarryforward_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_leavecarryforward_id: $('#edit_leavecarryforward_id').val(),
                edit_start_month_list: $('#edit_start_month_list').val(),
                edit_start_year_list: $('#edit_start_year_list').val(),
                edit_end_month_list: $('#edit_end_month_list').val(),
                edit_end_year_list: $('#edit_end_year_list').val()
            };
            $.ajax({
                url: "<?php echo site_url('Leaves/edit_leavecarryforward') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_leavecarryforward_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_leavecarryforward_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_leavecarryforward_error').html(msg);
                        $('#edit_leavecarryforward_success').show();
                    }
                }
            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_leavecarryforward_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_leavecarryforward_success" class="alert alert-success" style="display:none;">Leave carry forward updated successfully.</div>
            <div id="edit_leavecarryforward_error" class="alert alert-danger" style="display:none;">Failed to update leave carry forward.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_leavecarryforward_id" id="edit_leavecarryforward_id" value="<?php echo $L_Id; ?>">
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-2" class="control-label">Period Start</label>
                <select class="round" id="edit_start_month_list" name="edit_start_month_list">
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        $current_month = date('m');
                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                        ?>
                        <option value="<?php echo $m; ?>" <?php
                        if ($Start_Month == $m) {
                            echo "selected=selected";
                        }
                        ?>><?php echo $month; ?></option>
                                <?php
                            }
                            ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-1" class="control-label"></label>
                <select id="edit_start_year_list" name="edit_start_year_list" class="round">
                    <?php
                    define('DOB_YEAR_START', 2010);
                    $current_year = date('Y');
                    for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                        ?>
                        <option value="<?php echo $count; ?>" <?php
                        if ($Start_Year == $count) {
                            echo "selected=selected";
                        }
                        ?>><?php echo $count; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>	
        </div>

        <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:65%;left:45%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-1" class="control-label">Period End</label>
                <select class="round" id="edit_end_month_list" name="edit_end_month_list">
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        $current_month = date('m');
                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                        ?>
                        <option value="<?php echo $m; ?>" <?php
                        if ($End_Month == $m) {
                            echo "selected=selected";
                        }
                        ?>><?php echo $month; ?></option>
                                <?php
                            }
                            ?>
                </select>
            </div>	
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="field-1" class="control-label"></label>
                <select id="edit_end_year_list" name="edit_end_year_list" class="round">
                    <?php
                    for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                        ?>
                        <option value="<?php echo $count; ?>" <?php
                        if ($End_Year == $count) {
                            echo "selected=selected";
                        }
                        ?>><?php echo $count; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>	
        </div>
    </div>    
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>