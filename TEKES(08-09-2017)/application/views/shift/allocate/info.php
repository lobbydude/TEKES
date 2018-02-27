<?php
$emp_no = $this->uri->segment(3);
// Emp Number get the table
$this->db->where('Emp_Number', $emp_no);
$q_employee = $this->db->get('tbl_employee');
foreach ($q_employee->result() as $row_employee) {
    $employee_name = $row_employee->Emp_FirstName;
    $employee_name .= " " . $row_employee->Emp_LastName;
    $employee_name .= " " . $row_employee->Emp_MiddleName;
}
// Emp Code get the table
$this->db->where('employee_number', $emp_no);
$q_employee_code = $this->db->get('tbl_emp_code');
foreach ($q_employee_code->result() as $row_employee_code) {
    $employee_code = $row_employee_code->employee_code;
}
$this->db->where('Status', 1);
$select_branch = $this->db->get('tbl_branch');

$this->db->where('Status', 1);
$select_report = $this->db->get('tbl_employee');
$user_role = $this->session->userdata('user_role');
// Shift Time Details
$data_select = array(
    'Employee_Id'=>$emp_no,        
    'Status' => 1
);
$this->db->order_by('SA_Id', 'desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_shift_allocate');
?>
<script>    
    function edit_shift_allocate(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Shiftallocate/Editshift_allocate') ?>",
            data: "SA_Id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_shift_time_form").html(html);
            }
        });
    }  
    function delete_shift_allocate(id) {
        $.ajax({            
            type: "POST",
            url: "<?php echo site_url('Shiftallocate/Deleteshift_Allocate') ?>",
            data: "SA_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deleteshift_time_form").html(html);                
            }
        });
    }
</script> 
<!-- Add Shift Allocation Start here-->
<script>
    $(document).ready(function () {
        $('#addshift_timing_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_year: $('#add_year').val(),
                add_month: $('#add_month').val(),
                add_shiftid: $('#add_shiftid').val(),
                shift_emp_id: $('#shift_emp_id').val()
            };
            $.ajax({
                url: "<?php echo site_url('Shiftallocate/Add_shift_individual_emp') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    //alert(msg);
                    //die();
                    if (msg == 'fail') {
                        $('#addshift_timing_error').show();
                    }
                    if (msg == 'success') {
                        $('#addshift_timing_success').show();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>
<!-- End Shift Allocation End here-->

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">                       
                            <h2>Shift Time Details : <?php echo $employee_name . "( " . $employee_code . $emp_no . " )"; ?></h2>                                                        
                        </div>
                                                
                        <div class="panel-options">                           
                            <?php if ($user_role == 2 || $user_role == 6 || $user_role == 1) { ?>
                            <button class="btn btn-primary" type="button" onclick="jQuery('#add_shift_time').modal('show', {backdrop: 'static'});">
                                    Add Shift Time <i class="entypo-plus-circled"></i>
                                </button>
                            <?php } ?>
                        </div>
                    </div>             
                    
                    <!-- Shift Allocation Individual Emp Table Format Start Here -->
                    <table class="table table-bordered datatable" id="shift_time_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Shift Period</th>
                                <th>Date</th>
                                <th>Shift Name</th>                                
                                <?php if ($user_role == 2 || $user_role == 6 || $user_role == 1) { ?>
                                    <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $SA_Id = $row->SA_Id;
                                $shift_year = $row->Year;
                                $shift_month1 = $row->Month;
                                $shift_month = date('F', mktime(0, 0, 0, $shift_month1, 10));
                                $date1 = $row->Date;                                
                                $date = date("d-m-Y", strtotime($date1));
                                $shiftid = $row->Shift_Id;                                
                                $get_shift = array(
                                    'Shift_Id' => $shiftid,
                                    'Status' => 1
                                );
                                $this->db->where($get_shift);
                                $q_shift = $this->db->get('tbl_shift_details');
                                foreach ($q_shift->result() as $row_shift) {
                                    $Shift_Name = $row_shift->Shift_Name;
                                    $Shift_From = $row_shift->Shift_From;
                                    $Shift_To = $row_shift->Shift_To;
                                }
                                //
                                                               
                                ?> 
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $shift_month . " - " . $shift_year; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $Shift_Name . " [ " . $Shift_From . " " . $Shift_To . " ] "; ?></td>                                                                       

                                    <?php if ($user_role == 2 || $user_role == 6 || $user_role == 1) { ?>
                                        <td>
                                            <a data-toggle='modal' href='#edit_shift_time' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_shift_allocate(<?php echo $SA_Id; ?>)">
                                                <i class="entypo-pencil"></i>
                                                Edit
                                            </a>                                            
                                            <a data-toggle='modal' href='#delete_shift_time' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_shift_allocate(<?php echo $SA_Id; ?>)">
                                                <i class="entypo-cancel"></i>
                                                Delete
                                            </a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Shift Allocation Individual Emp Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Shift Time Allocation Start Here -->

        <div class="modal fade custom-width" id="add_shift_time">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add Employee Shift Time</h3>
                    </div>
                    <form role="form" id="addshift_timing_form" name="addshift_timing_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addshift_timing_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="addshift_timing_success" class="alert alert-success" style="display:none;">Shift timing details added successfully.</div>
                                    <div id="addshift_timing_error" class="alert alert-danger" style="display:none;">Failed to add shift timing details.</div>
                                </div>
                            </div>

                            <div class="row">                                
                                <div class="col-md-3">
                                    <label for="field-1" class="control-label">Select Year</label>
                                    <?php
                                    $current_year = date('Y');
                                    ?>
                                    <select id="add_year" name="add_year" class="round">
                                        <?php
                                        for ($count = $current_year; $count >= DOB_YEAR_START1; $count--) {
                                            echo "<option value='{$count}'>{$count}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="field-1" class="control-label">Select Month</label>
                                    <select class="round" id="add_month" name="add_month" <option value="">Select Shift Name</option>
                                        <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $current_month = date('m');
                                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                            
                                            ?>
                                            <option value="<?php echo $m;?>" <?php
                                            if ($current_month == $m) {
                                                echo "selected=selected";
                                            }
                                            ?>><?php echo $month; ?></option>
                                                    <?php
                                             
                                                }
                                                ?>
                                    </select>
                                </div>                                 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Shift Name</label>
                                        <select name="add_shiftid" id="add_shiftid" class="round" data-validate="required" data-message-required="Please Select Shift Name">
                                            <option value="">Select Shift Name</option>
                                            <?php
                                            $this->db->where('Status', 1);
                                            $q_shift = $this->db->get('tbl_shift_details');
                                            foreach ($q_shift->result() as $row_shift) {
                                                $Shift_Id = $row_shift->Shift_Id;
                                                $Shift_Name = $row_shift->Shift_Name;
                                                $Shift_From = $row_shift->Shift_From;
                                                $Shift_To = $row_shift->Shift_To;
                                                ?>
                                                <option value="<?php echo $Shift_Id; ?>">                                                
                                                    <?php echo $Shift_Name . " " . "(" . $Shift_From . $Shift_To . ")"; ?>                                            
                                                </option>                                            
                                                <?php
                                            }
                                            ?>                                                                                      
                                        </select>
                                    </div>	
                                </div> 
                                <div class="col-md-3">
                                    <input type="hidden" name="shift_emp_id" id="shift_emp_id" value="<?php echo $emp_no; ?>">
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
        <!--Add Shift Time Allocation End Here -->

        <!--Edit Shift Time Allocation Start Here -->

        <div class="modal fade custom-width" id="edit_shift_time">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Employee Shift Time</h3>
                    </div>
                    <form role="form" id="edit_shift_time_form" name="edit_shift_time_form" method="post" class="validate">
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Shift Time Allocation Start Here -->

        <!-- Delete Salary Start Here -->

        <div class="modal fade" id="delete_shift_time">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Employee Shift Time</h3>
                    </div>
                    <form role="form" id="deleteshift_time_form" name="deleteshift_time_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Salary End Here -->        

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
                tableContainer = $("#shift_time_table");
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