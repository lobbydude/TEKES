<?php
$data_select = array(
    'Status' => 1
);
$this->db->order_by('SA_Id', 'desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_shift_allocate');

// Select Year and Month query start
$username = $this->session->userdata('username');
if ($this->uri->segment(3) != "") {
    $selected_month = $this->uri->segment(3);
    $selected_year = $this->uri->segment(4);
} else {
    $selected_month = date('m');
    $selected_year = date('Y');
}
$data_select = array(
    'Month' => $selected_month,
    'Year' => $selected_year,
    'Status' => 1
);
$this->db->order_by('SA_Id', 'desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_shift_allocate');
// Select Year and Month query End
?>
<!-- Time Picker -->
<script src="<?php echo site_url('js/bootstrap-timepicker.min.js') ?>"></script>
<!-- Emp Checkbox List -->
<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#shift_emp_id').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<style>
    .multiselect-container.dropdown-menu a .checkbox input[type="checkbox"]{
        opacity: 1;
    }
    .multiselect-container.dropdown-menu{
        height: 200px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>

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
    // Edit Individual Employee Shift Time Allocation Start Here
    function edit_shift_allocate1(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Shiftallocate/Editshift_allocate1') ?>",
            data: "SA_Id=" + id,
            cache: false,
            success: function (html) {
                $("#edit_shift_time_form1").html(html);
            }
        });
    }
</script>

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
                url: "<?php echo site_url('Shiftallocate/Add_shift_timing') ?>",
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
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Employee's Shift Time</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_shift_timing').modal('show', {backdrop: 'static'});">
                                Add Shift Time Allocation
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Current Month Employee Shift time Display Start here -->
                    <div class="row">
                        <br /><br />
                        <div class="col-md-1"></div>
                        <form role="form" id="month_form" name="month_form" method="post" class="validate">
                            <div class="col-md-8">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    define('DOB_YEAR_START', 2013);
                                    $current_year = date('Y');
                                    ?>
                                    <select id="year_list" name="year_list" class="round">
                                        <?php
                                        for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                            echo "<option value='{$count}'>{$count}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="round" id="month_list" name="month_list" onchange="location = this.options[this.selectedIndex].value + '/' + $('#year_list').val();">
                                        <?php
                                        if ($this->uri->segment(3) != "") {
                                            for ($m = 1; $m <= 12; $m++) {
                                                $current_month = $this->uri->segment(3);
                                                $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                ?>
                                                <option value="<?php echo site_url('Shiftallocate/Index/' . $m); ?>" <?php
                                                if ($current_month == $m) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $month; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    for ($m = 1; $m <= 12; $m++) {
                                                        $current_month = date('m');
                                                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                                        ?>
                                                <option value="<?php echo site_url('Shiftallocate/Index/' . $m); ?>" <?php
                                                if ($current_month == $m) {
                                                    echo "selected=selected";
                                                }
                                                ?>><?php echo $month; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <br /><br /> <br /><br />
                    </div>
                    <!-- Current Month Employee Shift time Display End here -->
                    
                    <!-- Shift Table Format Start Here -->
                    <table class="table table-bordered datatable" id="shift_timing_table">
                        <thead>
                            <tr>
                                <th style="width:25px;">S.No</th>
                                <th>Shift Period</th>
                                <th>Shift Name</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Action</th>
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
                                $shiftid = $row->Shift_Id;
                                $date1 = $row->Date;
                                $date = date("d-m-Y", strtotime($date1));
                               
                                // Shift Details table get the value
                                //$this->db->where('Status', 1); one value get
                                $get_shift = array( 
                                     'Shift_Id' => $shiftid,                  
                                     'Status' => 1
                                 ); 
                                $this->db->where($get_shift);                                
                                $q_shift = $this->db->get('tbl_shift_details');
                                foreach ($q_shift->result() as $row_shift) {
                                    $Shift_Id = $row_shift->Shift_Id;
                                    $Shift_Name = $row_shift->Shift_Name;
                                    $Shift_From = $row_shift->Shift_From;
                                    $Shift_To = $row_shift->Shift_To;
                                }                             
                                ?>                             
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $shift_month . " - " . $shift_year; ?></td>
                                    <td><?php echo $Shift_Name . " [ " . $Shift_From . " " . $Shift_To . " ] "; ?></td>
                                    <td>
                                        <ul>
                                            <?php
                                                $get_shift_emp = array(
                                                    'SA_Id' => $SA_Id,
                                                    'Status' => 1
                                                );
                                                $this->db->where($get_shift_emp);
                                                $q_shift_emp = $this->db->get('tbl_shift_allocate');
                                                foreach ($q_shift_emp->result() as $row_shift_emp) {
                                                    $shift_emp_id = $row_shift_emp->Employee_Id;
                                                    
                                                    // Emp Name & Number get tbl_employee table
                                                    $this->db->where('Emp_Number', $shift_emp_id);
                                                    $q_employee = $this->db->get('tbl_employee');
                                                    foreach ($q_employee->result() as $row_employee) {
                                                        $Emp_Number = $row_employee->Emp_Number;
                                                        $Emp_Name = $row_employee->Emp_FirstName;
                                                        $Emp_Name .= " " . $row_employee->Emp_MiddleName;
                                                        $Emp_Name .= " " . $row_employee->Emp_LastName;
                                                    }
                                                    // Emp Code(DRN)
                                                    $get_empl_code = array(
                                                        "employee_number" => $shift_emp_id,
                                                        "Status" => 1
                                                    );
                                                    $this->db->where($get_empl_code);
                                                    $q_emp_code = $this->db->get('tbl_emp_code');
                                                    foreach ($q_emp_code->result() as $row_emp_code) {
                                                        $emp_code = $row_emp_code->employee_code;
                                                    }
                                                    echo "<li>" . $Emp_Name . " (" . $emp_code . " " . $Emp_Number . ")" . "</li>";
                                                }
                                            ?>
                                            </ul>
                                        </td>                                                               
                                        <td><?php echo "$date";?></td>

                                    <td>
                                        <a data-toggle='modal' href='#edit_shift_time' class="btn btn-default btn-sm btn-icon icon-left" onclick="edit_shift_allocate('<?php echo $SA_Id; ?>')">
                                            <i class="entypo-pencil"></i>
                                            Edit
                                        </a>

                                        <a data-toggle='modal' href='#delete_shift_time' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_shift_allocate('<?php echo $SA_Id; ?>')">
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
                    <!-- Shift Table Format End Here -->
                </div>
            </div>
        </section>
        
        <!-- Add Shift timing setup Start Here -->        
        <div class="modal fade custom-width" id="add_shift_timing">
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
                                    define('DOB_YEAR_START', 2013);
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
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Employee Name</label>
                                        <select name="shift_emp_id[]" id="shift_emp_id" data-validate="required" class="round" data-message-required="Employee Name" multiple>
                                            <?php
                                            $this->db->where('Status', 1);
                                            $q_employee = $this->db->get('tbl_employee');
                                            foreach ($q_employee->result() as $row_employee) {
                                                $Emp_Number = $row_employee->Emp_Number;
                                                $Emp_FirstName = $row_employee->Emp_FirstName;
                                                $Emp_Middlename = $row_employee->Emp_MiddleName;
                                                $Emp_LastName = $row_employee->Emp_LastName;

                                                $get_empl_code = array(
                                                    "employee_number" => $Emp_Number,
                                                    "Status" => 1
                                                );
                                                $this->db->where($get_empl_code);
                                                $q_emp_code = $this->db->get('tbl_emp_code');
                                                foreach ($q_emp_code->result() as $row_emp_code) {
                                                    $emp_code = $row_emp_code->employee_code;
                                                }
                                                ?>
                                                <option value="<?php echo $Emp_Number; ?>"><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $emp_code . $Emp_Number . ")" ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                         
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
        <!-- Add Shift End Here -->

        <!-- Edit Shift Start Here -->
        <div class="modal fade custom-width" id="edit_shift_time">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Employee Shift Time</h3>
                    </div>
                    <form role="form" id="edit_shift_time_form" name="edit_shift_time_form" method="post" class="validate" enctype="multipart/form-data">
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Shift End Here -->
        
        <!-- Edit Individual Employee Shift Time Allocation Start Here -->
        <div class="modal fade custom-width" id="edit_shift_time1">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Individual Employee Shift Time</h3>
                    </div>
                    <form role="form" id="edit_shift_time_form1" name="edit_shift_time_form1" method="post" class="validate" enctype="multipart/form-data">

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Individual Employee Shift Time Allocation End Here -->        

        <!-- Delete Shift Start Here -->
        <div class="modal fade" id="delete_shift_time">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Employee Shift Time</h3>
                    </div>
                    <form role="form" id="deleteshift_time_form" name="deleteshift_time_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Shift End Here -->

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
                tableContainer = $("#shift_timing_table");

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