<script>
    function edit_iprmaster(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Ipr/Editiprmaster') ?>",
            data: "Kp_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editiprmaster_form").html(html);
            }
        });
    }
    function delete_iprmaster(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Ipr/Deleteiprmaster') ?>",
            data: "Kp_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteiprinfo_form").html(html);

            }
        });
    }
</script>
<!-- Upload IPR Master Import question Add Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#addiprinfo_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({                
                url: "<?php echo site_url('Ipr/add_iprinfo') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {                   
                    if (data == "fail") {
                        $('#add_iprinfo_success').hide();
                        $('#add_iprinfo_error').show();
                    }
                    if (data.trim() == "success") {
                        $('#add_iprinfo_error').hide();
                        $('#add_iprinfo_success').show();
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

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">
                            <h2>IPR Information</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_kpmaster').modal('show', {backdrop: 'static'});">
                                New IPR Info
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <table class="table table-bordered datatable" id="iprmaster_table">
                        <thead>
                            <tr>
                                <th>S.No</th>                                
                                <th>Import Date</th>                             
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('Kp_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_iprmaster');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $Kp_Id = $row->Kp_Id;                               
                                $Enable_Date1 = $row->Enable_Date;
                                $Enable_Date = date("d-m-Y", strtotime($Enable_Date1));                                                                
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>                                    
                                    <td><?php echo $Enable_Date; ?></td>                              
                                    <td>
                                        <a data-toggle='modal' href='#edit_iprmaster' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_iprmaster(<?php echo $Kp_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>
                                        <a data-toggle='modal' href='#delete_iprmaster' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_iprmaster(<?php echo $Kp_Id; ?>)">
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
                    <!-- IPR KP Master Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add New IPR KP Master Start Here -->
        <div class="modal fade custom-width" id="add_kpmaster">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add IPR Information</h3>
                    </div>
                    <form role="form" id="addiprinfo_form" name="addiprinfo_form" method="post" class="validate" enctype="multipart/form-data">
                        <div class="modal-body">                            
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_iprinfo_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_iprinfo_success" class="alert alert-success" style="display:none;">Ipr Information details added successfully.</div>
                                    <div id="add_iprinfo_error" class="alert alert-danger" style="display:none;">Failed to add Ipr information details.</div>
                                </div>
                            </div>                       
                            <div class="row">                               
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Import Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_kpmaster_enable_date" id="add_kpmaster_enable_date" placeholder="Enable Date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>                                     
                                    </div>	
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Import File</label>
                                    <div class="form-group">
                                        <input type="file" name="iprquestionfile" id="iprquestionfile" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">                                    
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-4">
                                    <label class="control-label">Import Excel Format</label>
                                    <div class="form-group">
                                        <a href="<?php echo site_url('images/import_iprInformation_file.csv')?>"><img src="<?php echo site_url('images/excel.png')?>">
                                        </a>
                                    </div>
                                </div>
                            </div>                              
                            <div class="row">                                                              
                                        
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
        <!-- Add New IPR KP Master End Here -->

        <!-- Edit IPR KP Master Star Here -->
        <div class="modal fade custom-width" id="edit_iprmaster">
            <div class="modal-dialog" style="width:45%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit IPR Information</h3>
                    </div>
                    <form role="form" id="editiprmaster_form" name="editiprmaster_form" method="post" class="validate" enctype="multipart/form-data">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit IPR KP Master End Here -->

        <!-- Delete IPR Start Here -->

        <div class="modal fade" id="delete_iprmaster">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete IPR Information</h3>
                    </div>
                    <form role="form" id="deleteiprinfo_form" name="deleteiprinfo_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete IPR End Here -->

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
                tableContainer = $("#iprmaster_table");

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