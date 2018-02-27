<script>
    function showState(sel) {
        var country_id = sel.options[sel.selectedIndex].value;
        if (country_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_state') ?>",
                data: "country_id=" + country_id,
                cache: false,
                success: function (msg) {
                    $("#edit_branch_state").html(msg);
                }
            });
        }
    }

    function showDistrict(sel) {
        var state_id = sel.options[sel.selectedIndex].value;
        if (state_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_district') ?>",
                data: "state_id=" + state_id,
                cache: false,
                success: function (html) {
                    $("#edit_branch_district").html(html);
                }
            });
        }
    }

</script>

<?php
$this->db->where('Branch_ID', $branch_id);
$q = $this->db->get('tbl_branch');
foreach ($q->result() as $row) {
    $branch_name = $row->Branch_Name;
    $branch_code = $row->Branch_Code;
    $branch_address = $row->Branch_Address;
    $branch_country = $row->Branch_Country;

    $this->db->where('countryID', $branch_country);
    $select_country = $this->db->get('tbl_countries');
    foreach ($select_country->result() as $row_ctry) {
        $country_name = $row_ctry->countryName;
    }

    $branch_state = $row->Branch_State;
    $this->db->where('stateID', $branch_state);
    $select_state = $this->db->get('tbl_states');
    foreach ($select_state->result() as $row_st) {
        $state_name = $row_st->stateName;
    }


    $branch_district = $row->Branch_District;
    $this->db->where('districtID', $branch_district);
    $select_district = $this->db->get('tbl_districts');
    foreach ($select_district->result() as $row_dt) {
        $district_name = $row_dt->districtName;
    }

    $branch_city = $row->Branch_City;
    $branch_pincode = $row->Branch_Pincode;
    $branch_phone = $row->Branch_Phone;
    $branch_fax = $row->Branch_Fax;
    $branch_email = $row->Branch_Email;
    $branch_web = $row->Branch_Web;
    $company_id = $row->Company_Id;

    $this->db->where('Company_Id', $company_id);
    $select_company = $this->db->get('tbl_company');
    foreach ($select_company->result() as $row_company) {
        $company_name = $row_company->Company_Name;
    }
}

$this->db->where('Company_Id !=', $company_id);
$select_company_exp = $this->db->get('tbl_company');

$this->db->where('countryID !=', $branch_country);
$select_country_exp = $this->db->get('tbl_countries');
?>

<script>
    $(document).ready(function () {
        $('#editbranch_form').submit(function (e) {
            e.preventDefault();

            var formdata = {
                edit_branch_id: $('#edit_branch_id').val(),
                edit_company_name: $('#edit_company_name').val(),
                edit_branch_name: $('#edit_branch_name').val(),
                edit_branch_code: $('#edit_branch_code').val(),
                edit_branch_address: $('#edit_branch_address').val(),
                country: $('#edit_branch_country').val(),
                state: $('#edit_branch_state').val(),
                district: $('#edit_branch_district').val(),
                edit_branch_city: $('#edit_branch_city').val(),
                edit_branch_pincode: $('#edit_branch_pincode').val(),
                edit_branch_telno: $('#edit_branch_telno').val(),
                edit_branch_fax: $('#edit_branch_fax').val(),
                edit_branch_email: $('#edit_branch_email').val(),
                edit_branch_website: $('#edit_branch_website').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/edit_branch') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#editbranch_error').show();
                    }
                    if (msg == 'success') {
                        $('#editbranch_success').show();
                        window.location.reload();
                    }
                   
                }

            });
        });
    });

</script>

<div class="modal-body">
    <div class="row">
        <div class="col-md-10">
            <div id="editbranch_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editbranch_success" class="alert alert-success" style="display:none;">Branch details updated successfully.</div>
            <div id="editbranch_error" class="alert alert-danger" style="display:none;">Failed to update branch details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Company</label>
                <select name="edit_company_name" id="edit_company_name" class="round" data-validate="required" data-message-required="Please select company.">
                    <option value="<?php echo $company_id; ?>"><?php echo $company_name; ?></option>
                </select>
            </div>	
        </div>

        <input type="hidden" name="edit_branch_id" id="edit_branch_id" value="<?php echo $branch_id; ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Branch</label>
                <input type="text" name="edit_branch_name" id="edit_branch_name" class="form-control" placeholder="Branch" data-validate="required" data-message-required="Please enter branch." value="<?php echo $branch_name; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Branch Code</label>
                <input type="text" name="edit_branch_code" id="edit_branch_code" class="form-control" placeholder="Branch Code" value="<?php echo $branch_code; ?>">
            </div>	
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Address</label>
                <input type="text" name="edit_branch_address" id="edit_branch_address" class="form-control" placeholder="Address" data-validate="required" data-message-required="Please enter address." value="<?php echo $branch_address; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-5" class="control-label">Country</label>
                <select name="edit_branch_country" id="edit_branch_country" onChange="showState(this);" class="round" onChange="showState(this);" data-validate="required" data-message-required="Please select country.">
                    <option value="<?php echo $branch_country ?>"><?php echo $country_name; ?></option>
                    <?php foreach ($select_country_exp->result() as $rs) { ?>
                        <option value="<?php echo $rs->countryID; ?>"><?php echo $rs->countryName; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-6" class="control-label">State</label>
                <select name="edit_branch_state" id="edit_branch_state" class="round" onChange="showDistrict(this);" data-validate="required" data-message-required="Please select state.">
                    <option value="<?php echo $branch_state; ?>"><?php echo $state_name ?></option>
                </select>
            </div>	
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-7" class="control-label">District</label>
                <select name="edit_branch_district" id="edit_branch_district" class="round" data-validate="required" data-message-required="Please select district.">
                    <option value="<?php echo $branch_district; ?>"><?php echo $district_name; ?></option>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">City</label>
                <input type="text" name="edit_branch_city" id="edit_branch_city" class="form-control" data-validate="required" data-message-required="Please enter city." value="<?php echo $branch_city; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Pincode</label>
                <input type="text" name="edit_branch_pincode" id="edit_branch_pincode" class="form-control" data-validate="number,maxlength[6]" maxlength="6" value="<?php echo $branch_pincode; ?>">
            </div>	
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Tel. No</label>
                <input type="text" name="edit_branch_telno" id="edit_branch_telno" class="form-control" data-validate="number" maxlength="15" value="<?php echo $branch_phone; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Fax</label>
                <input type="text" name="edit_branch_fax" id="edit_branch_fax" class="form-control" value="<?php echo $branch_fax; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Email Address</label>
                <input type="text" name="edit_branch_email" id="edit_branch_email" class="form-control" data-validate="email" data-message-required="Please enter valid email address." value="<?php echo $branch_email; ?>">
            </div>	
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Website</label>
                <input type="text" name="edit_branch_website" id="edit_branch_website" class="form-control" data-validate="url" data-message-required="Please enter website url." value="<?php echo $branch_web; ?>"/>
            </div>	
        </div>

    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

