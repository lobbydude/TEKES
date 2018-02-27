<?php
$this->db->order_by('Branch_ID', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_branch');

$this->db->where('Status', 1);
$select_company = $this->db->get('tbl_company');

$select_country = $this->db->get('tbl_countries');
?>


<script>
    function edit_Branch(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Editbranch') ?>",
            data: "branch_id=" + id,
            cache: false,
            success: function (html) {
                $("#editbranch_form").html(html);
            }
        });
    }

    function delete_Branch(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Deletebranch') ?>",
            data: "branch_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletebranch_form").html(html);
            }
        });
    }

</script>

<script>

    function showState(sel) {
        var country_id = sel.options[sel.selectedIndex].value;
        $(".district_new").html("");
        if (country_id.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('Profile/fetch_state') ?>",
                data: "country_id=" + country_id,
                cache: false,
                success: function (msg) {
                    $("#add_branch_state").html(msg);
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
                    $("#add_branch_district").html(html);
                }
            });
        }
    }

</script>

<script>
    $(document).ready(function () {
        $('#addbranch_form').submit(function (e) {
            e.preventDefault();
            
            var formdata = {
                company_name: $('#company_name').val(),
                branch_name: $('#branch_name').val(),
                branch_code: $('#branch_code').val(),
                branch_address: $('#branch_address').val(),
                country: $('#add_branch_country').val(),
                state: $('#add_branch_state').val(),
                district: $('#add_branch_district').val(),
                branch_city: $('#branch_city').val(),
                branch_pincode: $('#branch_pincode').val(),
                branch_telno: $('#branch_telno').val(),
                branch_fax: $('#branch_fax').val(),
                branch_email: $('#branch_email').val(),
                branch_website: $('#branch_website').val()
            };
            $.ajax({
                url: "<?php echo site_url('Company/add_branch') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == 'fail') {
                        $('#addbranch_error').show();
                    }
                    if (msg == 'success') {
                        $('#addbranch_success').show();
                        window.location.reload();
                    }
                    
                }

            });
        });
    });

</script>


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Branch</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_branch').modal('show', {backdrop: 'static'});">
                                New Branch
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Branch Table Format Start Here -->

                    <table class="table table-bordered datatable" id="branch_table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Branch</th>
                                <th>Branch Code</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email Address</th>
                                <th>Website</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($q->Result() as $row) {
                                $branch_id = $row->Branch_ID;
                                $branch_name = $row->Branch_Name;
                                $company_id = $row->Company_Id;

                                $this->db->where('Company_Id', $company_id);
                                $q_cmp = $this->db->get('tbl_company');
                                foreach ($q_cmp->result() as $row_cmp) {
                                    $company_name = $row_cmp->Company_Name;
                                }
                                $branch_code = $row->Branch_Code;
                                $address = $row->Branch_Address;
                                $phone = $row->Branch_Phone;
                                $email = $row->Branch_Email;
                                $web = $row->Branch_Web;
                                ?>
                                <tr>
                                   
                                    <td><?php echo $company_name; ?></td>
                                     <td><?php echo $branch_name; ?></td>
                                    <td><?php echo $branch_code; ?></td>
                                    <td><?php echo $address; ?></td>
                                    <td><?php echo $phone; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $web; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_branch' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Branch(<?php echo $branch_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_branch' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Branch(<?php echo $branch_id; ?>)">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>

                    </table>

                    <!-- Branch Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Branch Start Here -->

        <div class="modal fade custom-width" id="add_branch">
            <div class="modal-dialog" style="width: 65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Branch</h3>
                    </div>
                    <form role="form" id="addbranch_form" name="addbranch_form" method="post" class="validate">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addbranch_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addbranch_success" class="alert alert-success" style="display:none;">Branch details added successfully.</div>
                                    <div id="addbranch_error" class="alert alert-danger" style="display:none;">Failed to add branch details.</div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Company</label>
                                        <select name="company_name" id="company_name" class="round" data-validate="required" data-message-required="Please select company.">
                                            <?php foreach ($select_company->result() as $row_company) { ?>
                                                <option value="<?php echo $row_company->Company_Id; ?>"><?php echo $row_company->Company_Name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Branch</label>
                                        <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Branch" data-validate="required" data-message-required="Please enter branch.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Branch Code </label>
                                        <input type="text" name="branch_code" id="branch_code" class="form-control" placeholder="Branch Code">
                                    </div>	
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Address</label>
                                        <input type="text" name="branch_address" id="branch_address" class="form-control" placeholder="Address" data-validate="required" data-message-required="Please enter address.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-5" class="control-label">Country</label>
                                        <select name="add_branch_country" id="add_branch_country" class="round" onChange="showState(this);" data-validate="required" data-message-required="Please select country.">
                                            <option value="">Select Country</option>
                                            <?php foreach ($select_country->result() as $rs) { ?>
                                                <option value="<?php echo $rs->countryID; ?>"><?php echo $rs->countryName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-6" class="control-label">State</label>
                                            <select name="add_branch_state" id="add_branch_state" class="round" onChange="showDistrict(this);" data-validate="required" data-message-required="Please select state.">
                                                <option value="">Select State</option>
                                            </select>
                                    </div>	
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-7" class="control-label">District</label>
                                            <select name="add_branch_district" id="add_branch_district" class="round" data-validate="required" data-message-required="Please select district.">
                                                <option value="">Select District</option>
                                            </select>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">City</label>
                                        <input type="text" name="branch_city" id="branch_city" class="form-control" placeholder="City" data-validate="required" data-message-required="Please enter city.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Pincode</label>
                                        <input type="text" name="branch_pincode" id="branch_pincode" class="form-control" placeholder="Pincode" data-validate="number,maxlength[6]" maxlength="6">
                                    </div>	
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Tel. No</label>
                                        <input type="text" name="branch_telno" id="branch_telno" class="form-control" placeholder="Tel. No" data-validate="number" maxlength="15">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Fax</label>
                                        <input type="text" name="branch_fax" id="branch_fax" class="form-control" placeholder="Fax">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Email Address</label>
                                        <input type="text" name="branch_email" id="branch_email" class="form-control" placeholder="Email Address" data-validate="email">
                                    </div>	
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Website</label>
                                        <input type="text" name="branch_website" id="branch_website" class="form-control" placeholder="Website" data-validate="url"/>
                                    </div>	
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Branch End Here -->

        <!-- Edit Branch Start Here -->

        <div class="modal fade custom-width" id="edit_branch">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Branch</h3>
                    </div>
                    <form role="form" id="editbranch_form" name="editbranch_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Branch End Here -->

        <!-- Delete Branch Start Here -->

        <div class="modal fade" id="delete_branch">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Branch</h3>
                    </div>
                    <form role="form" id="deletebranch_form" name="deletebranch_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Branch End Here -->

        <!-- Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#branch_table");

                tableContainer.dataTable({
                    "sPaginationType": "bootstrap",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "bStateSave": true,
                    // Responsive Settings
                    bAutoWidth: false,
                    fnPreDrawCallback: function () {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper) {
                            responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
                        }
                    },
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        responsiveHelper.createExpandIcon(nRow);
                    },
                    fnDrawCallback: function (oSettings) {
                        responsiveHelper.respond();
                    }
                });

                $(".dataTables_wrapper select").select2({
                    minimumResultsForSearch: -1
                });
            });
        </script>

