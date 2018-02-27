<?php
$this->db->order_by('Company_Id', 'desc');
$this->db->where('Status', 1);
$q = $this->db->get('tbl_company');
$select_country = $this->db->get('tbl_countries');
?>
<script>
    function edit_Company(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Editcompany') ?>",
            data: "company_id=" + id,
            cache: false,
            success: function (html) {
                $("#editcompany_form").html(html);

            }
        });
    }

    function delete_Company(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Company/Deletecompany') ?>",
            data: "company_id=" + id,
            cache: false,
            success: function (html) {
                $("#deletecompany_form").html(html);

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
                    $("#add_company_state").html(msg);
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
                    $("#add_company_district").html(html);
                }
            });
        }
    }
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Company</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_company').modal('show', {backdrop: 'static'});">
                                New Company
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Company Table Format Start Here -->

                    <table class="table table-bordered datatable" id="company_table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Reg.No</th>
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
                                $cmp_id = $row->Company_Id;
                                $company_name = $row->Company_Name;
                                $reg_no = $row->Comp_RegistrationNo;
                                $address = $row->Comp_Address;
                                $phone = $row->Comp_Phone;
                                $email = $row->Comp_Email;
                                $web = $row->Comp_Web;
                                ?>
                                <tr>
                                    <td><?php echo $company_name; ?></td>
                                    <td><?php echo $reg_no; ?></td>
                                    <td><?php echo $address; ?></td>
                                    <td><?php echo $phone; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $web; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#edit_company' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_Company(<?php echo $cmp_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_company' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Company(<?php echo $cmp_id; ?>)">
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

                    <!-- Company Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Company Start Here -->

        <div class="modal fade custom-width" id="add_company">
            <div class="modal-dialog" style="width: 65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Company</h3>
                    </div>
                    <form role="form" id="addcompany_form" name="addcompany_form" method="post" class="validate" enctype="multipart/form-data" action="<?php echo site_url('Company/add_company') ?>">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addcompany_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addcompany_success" class="alert alert-success" style="display:none;">Company details added successfully.</div>
                                    <div id="addcompany_error" class="alert alert-danger" style="display:none;">Failed to add company details.</div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Company</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company" data-validate="required" data-message-required="Please enter company.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Company Slogan</label>
                                        <input type="text" name="company_slogan" id="company_slogan" class="form-control" placeholder="Slogan">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Company Registration No </label>
                                        <input type="text" name="company_reg_no" id="company_reg_no" class="form-control" placeholder="Reg. No">
                                    </div>	
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Address</label>
                                        <input type="text" name="company_address" id="company_address" class="form-control" placeholder="Address" data-validate="required" data-message-required="Please enter address.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-5" class="control-label">Country</label>
                                        <select name="country" id="add_company_country" class="round" onChange="showState(this);" data-validate="required" data-message-required="Please select country.">
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
                                        <select name="state" id="add_company_state" class="round" onChange="showDistrict(this);" data-validate="required" data-message-required="Please select state.">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>	
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-7" class="control-label">District</label>
                                        <select name="district" id="add_company_district" class="round" data-validate="required" data-message-required="Please select district.">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">City</label>
                                        <input type="text" name="company_city" id="company_city" class="form-control" placeholder="City" data-validate="required" data-message-required="Please enter city.">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Pincode</label>
                                        <input type="text" name="company_pincode" id="company_pincode" class="form-control" placeholder="Pincode" maxlength="6" data-validate="number">
                                    </div>	
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Tel. No</label>
                                        <input type="text" name="company_telno" id="company_telno" class="form-control" placeholder="Tel. No" maxlength="15" data-validate="number">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Fax</label>
                                        <input type="text" name="company_fax" id="company_fax" class="form-control" placeholder="Fax" >
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Email Address</label>
                                        <input type="text" name="company_email" id="company_email" class="form-control" placeholder="Email Address" data-validate="email">
                                    </div>	
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Website</label>
                                        <input type="text" name="company_website" id="company_website" class="form-control" placeholder="Website" data-validate="url"/>
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-4" class="control-label">Company Logo</label>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="userfile" accept="image/*" id="userfile">
                                                </span>
                                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
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

        <!-- Add Company End Here -->

        <!-- Edit Company Start Here -->

        <div class="modal fade custom-width" id="edit_company">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Company</h3>
                    </div>
                    <form role="form" id="editcompany_form" name="editcompany_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Company End Here -->

        <!-- Delete Company Start Here -->

        <div class="modal fade" id="delete_company">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Company</h3>
                    </div>
                    <form role="form" id="deletecompany_form" name="deletecompany_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Company End Here -->

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
                tableContainer = $("#company_table");

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