<script>
    function edit_jobskills(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Jobskills/Editjobskills') ?>",
            data: "S_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editjobskills_form").html(html);
            }
        });
    }    
    function delete_jobskills(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Jobskills/Deletejobskills') ?>",
            data: "S_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletejobskills_form").html(html);
            }
        });
    }
</script>
<!-- Add New Job Skills Start here-->
<script type="text/javascript">  
    $(document).ready(function () {
        $('#addjobskills_form').submit(function (e) {
            e.preventDefault();
            var formdata = {                
                add_jobskills_jobtitle: $('#add_jobskills_jobtitle').val(),               
                add_jobskills_name: $('#add_jobskills_name').val()
            };
            $.ajax({               
                url: "<?php echo site_url('Jobskills/add_jobskills') ?>",				
                type: 'post',
                data: formdata,
                success: function (msg) {                    
                    if (msg == 'fail') {
                        $('#add_jobskills_error').show();
                    }
                    if (msg == 'success') {
                        $('#add_jobskills_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });    
</script>
<!-- Add New Job Skills End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Job Skills</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_jobskills').modal('show', {backdrop: 'static'});">
                                New JobSkills
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>                    
                    <!--Job Skills Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="jobskills_table">
                        <thead>
                            <tr>
                                <th style="width: 25px;">S.No</th>                                
                                <th>Job Title</th>                                
                                <th>Skills</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('S_Id', 'desc');
                            $this->db->where('Status', 1);
                            $q = $this->db->get('tbl_jobskills');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $S_Id = $row->S_Id;                                
                                $jobtitle_id = $row->Jobtitle;                               
                                $jobskills_name = $row->Jobskills;                                
                                // Designation Name get the value
                                $this->db->where('Designation_Id', $jobtitle_id);
                                $q_design = $this->db->get('tbl_designation');
                                foreach ($q_design->Result() as $row_design) {
                                    $jobtitle_name = $row_design->Designation_Name;                                    
                                }                                
                                //
                                
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td> 
                                    
                                    <td><?php echo $jobtitle_name; ?></td>                                    
                                    <td><?php echo $jobskills_name; ?></td>                                    
                                    <td>
                                        <a data-toggle='modal' href='#edit_jobskills' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_jobskills(<?php echo $S_Id;?>)">                                                                                                                                      
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_jobskills' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_jobskills(<?php echo $S_Id; ?>)">
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
                    <!--Job Skills Table Format End Here -->
                </div>
            </div>
        </section>
        
        <!-- Add New Job Skills Start Here -->
        <div class="modal fade custom-width" id="add_jobskills">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Jobtitle</h3>
                    </div>
                    <form role="form" id="addjobskills_form" name="addjobskills_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_jobskills_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_jobskills_success" class="alert alert-success" style="display:none;">Job Skills details added successfully.</div>
                                    <div id="add_jobskills_error" class="alert alert-danger" style="display:none;">Failed to add Jobskills details.</div>
                                </div>
                            </div>

                            <div class="row">                                
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Job Title</label>
                                        <select name="add_jobskills_jobtitle" id="add_jobskills_jobtitle" class="select2 round" data-validate="required" data-message-required="Please Select jobtitle">
                                            <option value="">Select Jobtitle</option>
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
                                                <option value="<?php echo $designation_id; ?>"><?php echo $designation_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>	
                                </div>
                                
                                
                                <!--<div class="col-md-5">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Job Title</label>
                                        <select name="add_jobskills_jobtitle" id="add_jobskills_jobtitle" class="round" data-validate="required" data-message-required="Please Select jobtitle">
                                            <option value="">Select Jobtitle</option>                                            
                                            <?php
                                            /*$this->db->where('Status', 1);
                                            $q_jobtitle = $this->db->get('tbl_jobtitle');
                                            foreach ($q_jobtitle->result() as $row_jobtitle) {
                                                $jobtitle_name_id = $row_jobtitle->J_Id;
                                                $jobtitle_name = $row_jobtitle->Jobtitle;
                                                // Destination Name get the value
                                                    $this->db->where('Designation_Id', $jobtitle_name);
                                                    $q_dest = $this->db->get('tbl_designation');
                                                    foreach ($q_dest->result() as $row_dest) {
                                                        $jobtitle_name1 = $row_dest->Designation_Name;                                    
                                                    }                                                
                                                ?>
                                                <option value="<?php echo $jobtitle_name_id ?>"><?php echo $jobtitle_name1; ?></option>
                                                <?php
                                            }*/
                                            ?>    
                                                
                                                
                                        </select>
                                    </div>	
                                </div>-->
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Job Skills</label>                                        
                                        <textarea class="form-control tagsinput" name="add_jobskills_name" id="add_jobskills_name" placeholder="Job Skills Name" data-validate="required" data-message-required="Please enter job skills"></textarea>                                        
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
        <!-- Add New Job Skills End Here -->

        <!-- Edit Job Skills Start Here -->
        <div class="modal fade custom-width" id="edit_jobskills">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Job Skills</h3>
                    </div>
                    <form role="form" id="editjobskills_form" name="editjobskills_form" method="post" class="validate">
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Job Skills End Here -->

        <!-- Delete Job Skills Start Here -->
        <div class="modal fade" id="delete_jobskills">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Job Skills</h3>
                    </div>
                    <form role="form" id="deletejobskills_form" name="deletejobskills_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Job Skills End Here -->

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
                tableContainer = $("#jobskills_table");

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