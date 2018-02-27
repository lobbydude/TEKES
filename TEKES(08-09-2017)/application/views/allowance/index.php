    <script>
    $(document).ready(function () {
        $('#addallowance_form').submit(function (e) {
            e.preventDefault();
            var formdata = {               
                add_allowance_name: $('#add_allowance_name').val(),                
                add_allowance_amount: $('#add_allowance_amount').val(),
                add_start_date: $('#add_start_date').val(),
                add_end_date: $('#add_end_date').val()
            };
            $.ajax({
               url: "<?php echo site_url('Allowance/add_allowance') ?>",
                type: 'post',
                data: formdata,                
                success: function (msg) {
                    if (msg.trim() == "fail") {
                        $('#add_allowance_error').show();
                    }
                    if (msg.trim() == "success") {
                        $('#add_allowance_success').show();
                        location.reload();
                    }                    
                }
            });
        });
    });
</script>

<script>
    function edit_allowance(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Allowance/Editallowance') ?>",
            data: "A_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editallowance_form").html(html);

            }
        });
    }
    
    function delete_allowance(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Allowance/Deleteallowance') ?>",
            data: "A_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteallowance_form").html(html);
            }
        });
    }
    // Year Select query
    function select_year() {
    $("form#allowance_search").submit();
   }
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Allowance</h2>                           
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_allowance').modal('show', {backdrop: 'static'});">
                                New Allowance
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                        
                        </div>   
                        
                        <!-- Select Comp off Year Design Start here---> 
                    <br />              
                    <div class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">
                            <h4>Select Year</h4>
                        </div>
                        <div class="col-md-2">                                    
                            <div class="col-md-12">  
                                <form action="" name="allowance_search" id="allowance_search">
                                <?php
                                $allowance_year = $this->input->get('allowance_year');                                
                                define('DOB_YEAR_START', 2013);
                                $current_year = date('Y');                                 
                                ?>
                                <select id="allowance_year" name="allowance_year" onchange="select_year();" class="round">
                                    <?php
                                    for ($count = $current_year; $count >= DOB_YEAR_START1; $count--) {
                                        echo "<option value='{$count}' ". ($allowance_year == $count?'selected="selected"':'') .">{$count}</option>";
                                  }                              
                                    ?>
                                </select>
                                 </form>
                            </div>                               
                        </div>                                
                    </div>
                    <br /><br /><br/>
                    <!-- Select Comp off Year Design End here---> 
                        
                        
                        
                        
                        
                        
                        
                        
                        
                                     
                    
                    <!-- Allowance Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="allowance_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Allowance Name</th>                                
                                <th>Allowance Amount</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->order_by('A_Id', 'desc');  
                            $this->db->where('Status',1);                      
                            // Search based on Allowance Year Start
                            if($allowance_year) {                                
                                $minyear = $allowance_year. "-01-01";
                                $maxyear = $allowance_year. "-12-31";
                                $this->db->where("Allowance_Startdate BETWEEN '". $minyear ."' AND '". $maxyear ."'");
                            }                            
                            $q = $this->db->get('tbl_allowance');
                            // Search based on Allowance Year End
                            $i=1; 
                            foreach ($q->Result() as $row) {
                                $allowance_id = $row->A_Id;
                                $allowance_name = $row->Allowance_Name;                                
                                $allowance_amount = $row->Allowance_Amount;
                                $allowance_startdate1 = $row->Allowance_Startdate;                                
                                $allowance_startdate = date("d-m-Y", strtotime($allowance_startdate1));
                                // Year Convert
                                $allowance_year = date("Y", strtotime($allowance_startdate1));
                                $allowance_enddate1 = $row->Allowance_Enddate;
                                $allowance_enddate = date("d-m-Y", strtotime($allowance_enddate1));
                                // Compare Current year and Past year
                                //if($current_year == $allowance_year){
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $allowance_name; ?></td>                                    
                                    <td><?php echo "Rs " .$allowance_amount;?></td>
                                    <td><?php echo $allowance_startdate;?></td>
                                    <td><?php echo $allowance_enddate;?></td>                                    
                                    <td>
                                        <a data-toggle='modal' href='#edit_allowance' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_allowance(<?php echo $allowance_id; ?>)">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_allowance' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_allowance(<?php echo $allowance_id; ?>)">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i++;                                
                               // }                   
                            }                               
                            ?>                         
                        </tbody>                 
                    </table> 
                 <!-- Allowance Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Allowance Start Here -->
        <div class="modal fade" id="add_allowance">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Allowance</h3>
                    </div>
                    <form role="form" id="addallowance_form" name="addallowance_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_allowance_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_allowance_success" class="alert alert-success" style="display:none;">Allowance details added successfully.</div>
                                    <div id="add_allowance_error" class="alert alert-danger" style="display:none;">Failed to add allowance details.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Allowance Name</label>
                                        <input type="text" name="add_allowance_name" id="add_allowance_name" class="form-control" placeholder="Allowance Name" data-validate="required" data-message-required="Please enter allowance name">
                                    </div>	
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Amount</label>
                                        <div class="input-group">
                                            <input type="text" name="add_allowance_amount" id="add_allowance_amount" class="form-control" placeholder="Amount" data-validate="required,number" data-message-required="Please enter allowance amount.">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary">Rs</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Start Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_start_date" id="add_start_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" placeholder="Start Date" data-message-required="Please start date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>                                     
                                    </div>	
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">End Date</label>
                                        <div class="input-group">
                                            <input type="text" name="add_end_date" id="add_end_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-validate="required" placeholder="End Date" data-message-required="Please end date.">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
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
         <!-- Add Allowance End Here -->
        
        <!-- Edit Allowance Start Here -->
       <div class="modal fade" id="edit_allowance">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Allowance</h3>
                    </div>
                    <form role="form" id="editallowance_form" name="editallowance_form" method="post" class="validate">
                        
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Allowance End Here -->
        
         <!-- Delete Allowance Start Here -->

        <div class="modal fade" id="delete_allowance">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Allowance</h3>
                    </div>
                    <form role="form" id="deleteallowance_form" name="deleteallowance_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Allowance  End Here -->
        
        
        <!-- Dashboard Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#allowance_table");

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