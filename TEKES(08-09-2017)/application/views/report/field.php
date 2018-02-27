<?php
$get_data = array(
    'Title_Id' => $title_id,
    'Status' => 1
);
$this->db->where($get_data);
$q = $this->db->get('tbl_report_field');
$count = $q->num_rows();
?>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/select/multi-select.css') ?>" />
<script src="<?php echo site_url('css/select/jquery.multi-select.js') ?>"></script>
<script src="<?php echo site_url('css/select/application.js') ?>"></script>
<div class="col-md-6">
    <div class="form-group">
        <label class="control-label" for="birthdate">Field</label>
        <select id="field_list" class="multiselect" name="field_list[]" multiple>
            <option selected="selected" disabled="disabled">Employee Name</option>
                <?php
                if ($count > 0) {
                    $i = 1;
                    foreach ($q->result() as $row) {
                        $F_Id = $row->F_Id;
                        $Field = $row->Field;
                        ?>
                    <option value="<?php echo $F_Id; ?>" ><?php echo $Field; ?></option>
                    <?php
                    $i++;
                }
            }
            ?>
        </select>
    </div>
</div>