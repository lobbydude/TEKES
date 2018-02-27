
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
                    $("#edit_company_state").html(msg);
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
                    $("#edit_company_district").html(html);
                }
            });
        }
    }

</script>

<?php
$this->db->where('Company_Id', $company_id);
$q = $this->db->get('tbl_company');
foreach ($q->result() as $row) {
    $cmp_name = $row->Company_Name;
    $cmp_slogan = $row->Comp_slogan;
    $cmp_regno = $row->Comp_RegistrationNo;
    $cmp_address = $row->Comp_Address;
    $cmp_country = $row->Comp_Country;

    $this->db->where('countryID', $cmp_country);
    $select_country = $this->db->get('tbl_countries');
    foreach ($select_country->result() as $row_ctry) {
        $country_name = $row_ctry->countryName;
    }

    $cmp_state = $row->Comp_State;
    $this->db->where('stateID', $cmp_state);
    $select_state = $this->db->get('tbl_states');
    foreach ($select_state->result() as $row_st) {
        $state_name = $row_st->stateName;
    }


    $cmp_district = $row->Comp_District;
    $this->db->where('districtID', $cmp_district);
    $select_district = $this->db->get('tbl_districts');
    foreach ($select_district->result() as $row_dt) {
        $district_name = $row_dt->districtName;
    }

    $cmp_city = $row->Comp_City;
    $cmp_pincode = $row->Comp_Pincode;
    $cmp_phone = $row->Comp_Phone;
    $cmp_fax = $row->Comp_Fax;
    $cmp_email = $row->Comp_Email;
    $cmp_web = $row->Comp_Web;
    $cmp_logo = $row->Comp_Logo;
}
$this->db->where('countryID !=', $cmp_country);
$select_country_exp = $this->db->get('tbl_countries');
?>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("#editcompany_form").on('submit', (function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo site_url('Company/edit_company') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#editcompany_success').hide();
                        $('#editcompany_error').show();
                    }
                    if (data == "success") {
                        $('#editcompany_error').hide();
                        $('#editcompany_success').show();
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


<div class="modal-body">

    <div class="row">
        <div class="col-md-10">
            <div id="editcompany_server_error" class="alert alert-info" style="display:none;"></div>
            <div id="editcompany_success" class="alert alert-success" style="display:none;">Company details updated successfully.</div>
            <div id="editcompany_error" class="alert alert-danger" style="display:none;">Failed to update company details.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-1" class="control-label">Company</label>
                <input type="text" name="edit_company_name" id="edit_company_name" class="form-control" data-validate="required" data-message-required="Please enter company." value="<?php echo $cmp_name; ?>">
            </div>	
        </div>

        <input type="hidden" name="edit_company_id" id="edit_company_id" value="<?php echo $company_id; ?>">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-2" class="control-label">Company Slogan</label>
                <input type="text" name="edit_company_slogan" id="edit_company_slogan" class="form-control" placeholder="Slogan" value="<?php echo $cmp_slogan; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Company Registration No </label>
                <input type="text" name="edit_company_reg_no" id="edit_company_reg_no" class="form-control" placeholder="Reg. No" value="<?php echo $cmp_regno; ?>">
            </div>	
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Address</label>
                <input type="text" name="edit_company_address" id="edit_company_address" class="form-control" placeholder="Address" data-validate="required" data-message-required="Please enter address." value="<?php echo $cmp_address; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-5" class="control-label">Country</label>
                <select name="edit_company_country" id="edit_company_country" class="round" onChange="showState(this);" data-validate="required" data-message-required="Please select country.">
                    <option value="<?php echo $cmp_country ?>"><?php echo $country_name; ?></option>
                    <?php foreach ($select_country_exp->result() as $rs) { ?>
                        <option value="<?php echo $rs->countryID; ?>"><?php echo $rs->countryName; ?></option>
                    <?php } ?>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-6" class="control-label">State</label>
                <select name="edit_company_state" id="edit_company_state" class="round" onChange="showDistrict(this);" data-validate="required" data-message-required="Please select state.">
                    <option value="<?php echo $cmp_state; ?>"><?php echo $state_name ?></option>
                </select>
            </div>	
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-7" class="control-label">District</label>
                <select name="edit_company_district" id="edit_company_district" class="round" data-validate="required" data-message-required="Please select district.">
                    <option value="<?php echo $cmp_district; ?>"><?php echo $district_name; ?></option>
                </select>
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">City</label>
                <input type="text" name="edit_company_city" id="edit_company_city" class="form-control" data-validate="required" data-message-required="Please enter city." value="<?php echo $cmp_city; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Pincode</label>
                <input type="text" name="edit_company_pincode" id="edit_company_pincode" class="form-control" data-validate="number,maxlength[6]" maxlength="6" value="<?php echo $cmp_pincode; ?>">
            </div>	
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Tel. No</label>
                <input type="text" name="edit_company_telno" id="edit_company_telno" class="form-control" data-validate="number" maxlength="15" value="<?php echo $cmp_phone; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Fax</label>
                <input type="text" name="edit_company_fax" id="edit_company_fax" class="form-control" value="<?php echo $cmp_fax; ?>">
            </div>	
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-3" class="control-label">Email Address</label>
                <input type="text" name="edit_company_email" id="edit_company_email" class="form-control" data-validate="email" value="<?php echo $cmp_email; ?>">
            </div>	
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Website</label>
                <input type="text" name="edit_company_website" id="edit_company_website" class="form-control" data-validate="required,url" data-message-required="Please enter website url." value="<?php echo $cmp_web; ?>"/>
            </div>	
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="field-4" class="control-label">Company Logo</label>
                <div style="max-width: 200px; max-height: 150px;float:right" class="fileinput-preview fileinput-exists thumbnail">
                    <img src="<?php echo site_url('company_logo/' . $cmp_logo); ?>" style="max-width: 200px; max-height: 95px;">
                </div>
                <a class="file-input-wrapper btn form-control file2 inline btn btn-primary"><i class="glyphicon glyphicon-file"></i> Browse
                    <input type="file" id="edit_userfile" name="edit_userfile" data-label="&lt;i class='glyphicon glyphicon-file'&gt;&lt;/i&gt; Browse" class="form-control file2 inline btn btn-primary" style="left: 47.6667px; top: -0.25px;">
                </a>
            </div>	
        </div>

    </div>


</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
