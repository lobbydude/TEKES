<?php
$this->db->where('V_Id', $V_Id);
$q = $this->db->get('tbl_Vendortype');
foreach ($q->result() as $row) {
    $edit_vendortype_name = $row->Vendor_Type;
    $edit_vendorname_name = $row->Vendor_Name;   
}
?>
<script>
    $(document).ready(function () {
        $('#editvendortype_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                edit_vendortype_id: $('#edit_vendortype_id').val(),
                edit_vendortype_name: $('#edit_vendortype_name').val(),
                edit_vendorname_name: $('#edit_vendorname_name').val()                
            };
            $.ajax({
                url: "<?php echo site_url('Vendor/edit_vendortype') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#edit_vendortype_error').show();
                    }
                    if (msg.trim() == 'success') {
                        $('#edit_vendortype_success').show();
                        window.location.reload();
                    }
                    else if (msg.trim() == 'fail' && msg != 'success') {
                        $('#edit_vendortype_server_error').html(msg);
                        $('#edit_vendortype_server_error').show();
                    }
                }
            });
        });
    });
</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="edit_vendortype_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="edit_vendortype_success" class="alert alert-success" style="display:none;">Vendor Type details updated successfully.</div>
            <div id="edit_vendortype_error" class="alert alert-danger" style="display:none;">Failed to update Vendor Type details.</div>
        </div>
    </div>
    <div class="row"> 
        <input type="hidden" name="edit_vendortype_id" id="edit_vendortype_id" value="<?php echo $V_Id;?>">        
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Vendor Type</label>
                <select id="edit_vendortype_name" name="edit_vendortype_name" class="round" data-validate="required" data-message-required="Please select vender type name">
                    <option value="<?php echo $edit_vendortype_name; ?>"><?php echo $edit_vendortype_name;?></option>                                       
                    <option value="Consultant">Consultant</option>
                    <option value="Reference">Reference</option>                                    
                </select>           
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Vendor Name</label>
                <input type="text" name="edit_vendorname_name" id="edit_vendorname_name" class="form-control" data-validate="required" value="<?php echo $edit_vendorname_name;?>" >
            </div>	
        </div>        
    </div>    
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>