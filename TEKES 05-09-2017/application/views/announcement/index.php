
<script>
    function edit_announcement(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Announcement/Editannouncement') ?>",
            data: "A_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editannouncement_form").html(html);
            }
        });
    }

    function delete_announcement(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Announcement/Deleteannouncement') ?>",
            data: "A_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteannouncement_form").html(html);

            }
        });
    }

</script>

<!-- Upload Announcement File image Add Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#addannouncement_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('Announcement/add_announcement') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#addannouncement_error').show();
                    }
                    else {
                        $('#addannouncement_error').hide();
                        $('#addannouncement_success').show();
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
<!-- Upload Announcement File image Add End here-->


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Announcement</h2>
                        </div>

                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_announcement').modal('show', {backdrop: 'static'});">
                                New Announcement
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Announcement Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="announcement_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Announcement Date</th>
                                <th>Message</th>
                                <th>Files</th>                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('A_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_announcement');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $A_Id = $row->A_Id;
                                $title = $row->Title;
                                $date1 = $row->Date;
                                $date = date("d-m-Y", strtotime($date1));
                                $message = $row->Message;
                                $userfile = $row->File;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $message; ?></td> 
                                    <td><?php
                            $ext = pathinfo($userfile, PATHINFO_EXTENSION);
                            if ($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'JPG') {
                                    ?>
                                            <a href="<?php echo site_url('announcement_image/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('announcement_image/' . $userfile) ?>" width="48" height="48">                        
                                            </a>
                                            <?php
                                        } elseif ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlsm' || $ext == 'csv') {
                                            ?>
                                            <a href="<?php echo site_url('announcement_image/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/excel.png') ?>">                        
                                            </a>                     
                                            <?php
                                        } elseif ($ext == 'ppt') {
                                            ?>
                                            <a href="<?php echo site_url('announcement_image/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/pdf.png') ?>">                        
                                            </a>
                                            <?php
                                        } elseif ($ext == 'pdf') {
                                            ?>
                                            <a href="<?php echo site_url('announcement_image/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/pdf.png') ?>">                        
                                            </a>
        <?php
    } elseif ($ext == 'doc' || $ext == 'docx') {
        ?>
                                            <a href="<?php echo site_url('announcement_image/' . $userfile) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/word.png') ?>">                        
                                            </a>                                       
    <?php }
    ?></td>

                                    <td>
                                        <a data-toggle='modal' href='#edit_announcement' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_announcement(<?php echo $A_Id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_announcement' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_announcement(<?php echo $A_Id; ?>)">
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
                    <!-- Announcement Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add New Announcement Start Here -->
        <div class="modal fade custom-width" id="add_announcement">
            <div class="modal-dialog" style="width: 65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Announcement</h3>
                    </div>
                    <form role="form" id="addannouncement_form" name="addannouncement_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_announcement_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_announcement_success" class="alert alert-success" style="display:none;">Announcement details added successfully.</div>
                                    <div id="add_announcement_error" class="alert alert-danger" style="display:none;">Failed to add announcement details.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Title</label>
                                        <input type="text" name="add_announcement_title" id="add_announcement_title" class="form-control" placeholder="Title" data-validate="required" data-message-required="Please enter title">
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Announcement Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_announcement_date" id="add_announcement_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" data-message-required="Please enter date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>                                     
                                    </div>	
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Message</label>                                        
                                        <textarea class="form-control" name="add_announcement_message" id="add_announcement_message" placeholder="Enter Message" data-validate="required" data-message-required="Please enter Message" ></textarea>
                                    </div>	
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Files</label>
                                    <input type="file" name="userfile" id="userfile" class="form-control file2 inline btn btn-primary" accept="image/*" data-label="<i class='glyphicon glyphicon-file'></i> Browse"/>
                                </div>        
                            </div>                                                  
                            <br>                            

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add New Announcement End Here -->

        <!-- Edit Announcement Start Here -->

        <div class="modal fade custom-width" id="edit_announcement">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Announcement</h3>
                    </div>
                    <form role="form" id="editannouncement_form" name="editannouncement_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Announcement End Here -->

        <!-- Delete Announcement Start Here -->

        <div class="modal fade" id="delete_announcement">

            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Announcement</h3>
                    </div>
                    <form role="form" id="deleteannouncement_form" name="deleteannouncement_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Announcement End Here -->




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
                tableContainer = $("#announcement_table");

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