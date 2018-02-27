<script>
    function edit_appraisal(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('appraisal/Editappraisal') ?>",
            data: "AP_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editappraisal_form").html(html);
            }
        });
    }
    
    function delete_appraisal(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('appraisal/Deleteappraisal') ?>",
            data: "AP_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteappraisal_form").html(html);

            }
        });
    }
</script>
<!-- Upload Appraisal File image Add Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#addappraisal_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('appraisal/add_appraisal') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#addappraisal_error').show();
                    }
                    else {
                        $('#addappraisal_error').hide();
                        $('#addappraisal_success').show();
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
<!-- Upload Appraisal File image Add End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Appraisal</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_appraisal').modal('show', {backdrop: 'static'});">
                                New Appraisal
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Appraisal Output design Table Format Start Here -->

                    <table class="table table-bordered datatable" id="appraisal_table">
                        <thead>
                            <tr>
                                <th style="width: 25px;">S.No</th>
                                <th>Designation</th>                              
                                <th>Appraisal Form</th>                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('AP_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_appraisalform');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $AP_Id = $row->AP_Id;
                                $designation_id = $row->Designation;
                                $this->db->where('Designation_Id', $designation_id);
                                $q_design = $this->db->get('tbl_designation');
                                foreach ($q_design->Result() as $row_design) {
                                    $design_name = $row_design->Designation_Name;
                                    $design_role = $row_design->Role;
                                }
                                $userfile = $row->File;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $design_name . " ($design_role)"; ?></td>                                 
                                    <td><?php
                                        $ext = pathinfo($userfile, PATHINFO_EXTENSION);
                                        if ($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'JPG') {
                                            ?>
                                            <a href="<?php echo site_url('appraisal_file/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('appraisal_file/' . $userfile) ?>" width="48" height="48">                        
                                            </a>
                                            <?php
                                        } elseif ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlsm' || $ext == 'csv') {
                                            ?>
                                            <a href="<?php echo site_url('appraisal_file/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/excel.png') ?>">                        
                                            </a>                     
                                            <?php
                                        } elseif ($ext == 'ppt') {
                                            ?>
                                            <a href="<?php echo site_url('appraisal_file/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/pdf.png') ?>">                        
                                            </a>
                                            <?php
                                        } elseif ($ext == 'pdf') {
                                            ?>
                                            <a href="<?php echo site_url('appraisal_file/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/pdf.png') ?>">                        
                                            </a>
                                            <?php
                                        } elseif ($ext == 'doc' || $ext == 'docx') {
                                            ?>
                                            <a href="<?php echo site_url('appraisal_file/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/word.png') ?>">                        
                                            </a>                                       
                                        <?php }
                                        ?></td>

                                    <td>
                                        <a data-toggle='modal' href='#edit_appraisal' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_appraisal(<?php echo $AP_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_appraisal' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_appraisal(<?php echo $AP_Id; ?>)">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>                            

                        </tbody>                   

                    </table> 
                    <!-- Appraisal Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add New Appraisal Start Here -->
        <div class="modal fade custom-width" id="add_appraisal">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Appraisal</h3>
                    </div>
                    <form role="form" id="addappraisal_form" name="addappraisal_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_appraisal_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_appraisal_success" class="alert alert-success" style="display:none;">Appraisal details added successfully.</div>
                                    <div id="add_appraisal_error" class="alert alert-danger" style="display:none;">Failed to add appraisal details.</div>
                                </div>
                            </div>

                            <div class="row">                           
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Designation</label>
                                        <select name="add_designation" id="add_designation" class="round" data-validate="required" data-message-required="Please Select Designation">
                                            <option value="">Select Designation</option>
                                            <?php
                                            $this->db->order_by('Designation_Id', 'desc');
                                            $this->db->group_by('Designation_Name');
                                            $this->db->where('Status', 1);
                                            $q_designation = $this->db->get('tbl_designation');
                                            foreach ($q_designation->Result() as $row_designation) {
                                                $designation_name = $row_designation->Designation_Name;
                                                $designation_id = $row_designation->Designation_Id;
                                                $role = $row_designation->Role;
                                                ?>
                                                <option value="<?php echo $designation_id; ?>"><?php echo $designation_name . " ($role)"; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Appraisal Form</label>
                                    <input type="file" name="userfile" id="userfile" class="form-control file2 inline btn btn-primary" accept="image/*" data-label="<i class='glyphicon glyphicon-file'></i> Browse"/>                                    
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
        <!-- Add New Appraisal End Here -->

        <!-- Edit Appraisal Start Here -->

        <div class="modal fade custom-width" id="edit_appraisal">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Appraisal</h3>
                    </div>
                    <form role="form" id="editappraisal_form" name="editappraisal_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Appraisal End Here -->

        <!-- Delete Appraisal Start Here -->

        <div class="modal fade" id="delete_appraisal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Appraisal</h3>
                    </div>
                    <form role="form" id="deleteappraisal_form" name="deleteappraisal_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Appraisal End Here -->


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
                tableContainer = $("#appraisal_table");

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