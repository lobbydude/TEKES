<?php
$this->db->where('Kp_Id', $Kp_Id);
$q = $this->db->get('tbl_kpmaster');
foreach ($q->result() as $row) {
    $edit_kpmaster_enable_date1 = $row->Enable_Date;
    $edit_kpmaster_enable_date = date("d-m-Y", strtotime($edit_kpmaster_enable_date1));
}
?>
<!-- Upload Ipr  File image Edit Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#editiprmaster_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('Ipr/edit_iprmaster') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#edit_iprinfo_error').show();
                    }
                    else {
                        $('#edit_iprinfo_error').hide();
                        $('#edit_iprinfo_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>

<!-- Upload Ipr File Edit image End here-->

<div class="modal-body">
    <div class="row">
        <div class="col-md-10"> 
            <div id="edit_iprinfo_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_iprinfo_success" class="alert alert-success" style="display:none;">Ipr details updated successfully.</div>
            <div id="edit_iprinfo_error" class="alert alert-danger" style="display:none;">Failed to update Ipr details.</div>
        </div>
    </div>
    <div class="row">   
        <input type="hidden" name="edit_kpmaster_id" id="edit_kpmaster_id" value="<?php echo $Kp_Id; ?>">       

       
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-2" class="control-label">Import Date</label>
                    <div class="input-group">
                        <input type="text" name="edit_kpmaster_enable_date" id="edit_kpmaster_enable_date" class="form-control datepicker" data-format="dd-mm-yyyy" value="<?php echo $edit_kpmaster_enable_date; ?>">
                        <div class="input-group-addon">
                            <a href="#"><i class="entypo-calendar"></i></a>
                        </div>
                    </div>                                     
                </div>	
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="field-4" class="control-label">Import File</label>
                    <a class="file-input-wrapper btn form-control file2 inline btn btn-primary"><i class="glyphicon glyphicon-file"></i> Browse
                        <input type="file" id="iprquestionfile_edit_file" name="iprquestionfile_edit_file" data-label="&lt;i class='glyphicon glyphicon-file'&gt;&lt;/i&gt; Browse" class="form-control file2 inline btn btn-primary" style="left: 47.6667px; top: -0.25px;">
                    </a>
                </div>
            </div>
        

    </div>
    <!-- Edit(Update) Ipr Form Design Start-->

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>