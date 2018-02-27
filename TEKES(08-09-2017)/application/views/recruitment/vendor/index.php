<script>
    function edit_vendortype(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Vendor/Editvendortype') ?>",
            data: "V_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editvendortype_form").html(html);
            }
        });
    }    
    function delete_vendortype(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Vendor/Deletevendortype') ?>",
            data: "V_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletevendortype_form").html(html);
            }
        });
    }       
</script>
<!-- Add New Vendor Type Start here-->
<script type="text/javascript">  
    $(document).ready(function () {
        $('#addvendortype_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_vendortype_name: $('#add_vendortype_name').val(),
                add_vendorname: $('#add_vendorname').val()                
            };
            $.ajax({               
                url: "<?php echo site_url('Vendor/add_vendortype') ?>",				
                type: 'post',
                data: formdata,
                success: function (msg) {                    
                    if (msg == 'fail') {
                        $('#add_vendortype_error').show();
                    }
                    if (msg == 'success') { 
                        $('#add_vendortype_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });    
</script>
<!-- Add New Vendor Type End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Vendor Type</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_vendortype').modal('show', {backdrop: 'static'});">
                                New Vendor Type
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!--Vendor Type Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="vendortype_table">
                        <thead>
                            <tr>
                                <th style="width: 25px;">S.No</th>
                                <th>Vendor Type</th>                              
                                <th>Vendor Name</th>                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('V_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_Vendortype');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $V_Id = $row->V_Id;                               
                                $vendor_type = $row->Vendor_Type;
                                $vendor_name = $row->Vendor_Name;                                                            
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $vendor_type; ?></td>                                 
                                    <td><?php echo $vendor_name; ?></td>                                                                       
                                    <td>
                                        <a data-toggle='modal' href='#edit_vendortype' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_vendortype(<?php echo $V_Id;?>)">                                                                                                                                      
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>
                                        <a data-toggle='modal' href='#delete_vendortype' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_vendortype(<?php echo $V_Id; ?>)">
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
                    <!--Vendor Type Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add New Vendor Type Start Here -->
        <div class="modal fade custom-width" id="add_vendortype">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Vendor Type</h3>
                    </div>
                    <form role="form" id="addvendortype_form" name="addvendortype_form" method="post" class="validate" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_vendortype_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_vendortype_success" class="alert alert-success" style="display:none;">Vendor Type details added successfully.</div>
                                    <div id="add_vendortype_error" class="alert alert-danger" style="display:none;">Failed to add Vendor Type details.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Vendor Type</label>
                                        <select name="add_vendortype_name" id="add_vendortype_name" class="round" data-validate="required" data-message-required="Please Select Vendor type">
                                            <option value="Any Type">Any Type</option>
                                            <option value="Consultant">Consultant</option>
                                            <option value="Reference">Reference</option>                                    
                                        </select>
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Vendor Name</label>
                                        <input type="text" name="add_vendorname" id="add_vendorname" class="form-control" placeholder="Vendor Name" data-validate="required" data-message-required="Please Enter Vendor Name">
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
        <!-- Add New Vendor Type End Here -->

        <!-- Edit Vendor Type Start Here -->
        <div class="modal fade custom-width" id="edit_vendortype">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Vendor Type</h3>
                    </div>
                    <form role="form" id="editvendortype_form" name="editvendortype_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Vendor Type End Here -->

        <!-- Delete Vendor Type Start Here -->
        <div class="modal fade" id="delete_vendortype">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Vendor Type</h3>
                    </div>
                    <form role="form" id="deletevendortype_form" name="deletevendortype_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Vendor Type End Here -->

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
                tableContainer = $("#vendortype_table");

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