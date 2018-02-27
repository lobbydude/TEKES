<?php
$uri = $this->uri->segment(3);

$user_role = $this->session->userdata('user_role');

$this->db->where('Status', 1);
$q_emp = $this->db->get('tbl_employee');
?>


<script>
    function delete_Employee(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Deleteemployee') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#deleteemployee_form").html(html);

            }
        });
    }
</script>

<script>
    
    function add_termination(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/add_termination') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#addtermination_form").html(html);
            }
        });
    }

    function fetch_reporting(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Profile/fetch_reporting') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#add_termination_reporting_to").html(html);
            }
        });
    }
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Employee</h2>
                        </div>
                        <?php if ($user_role == 2) { ?>
                            <div class="panel-options">

                                <ul class="navbar-left" style="margin-right:5px;padding-left: 0px">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-icon icon-left" data-toggle="dropdown"> 
                                            <i class="entypo-users"></i>
                                            Employee Status
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('Employee/Index') ?>">
                                                    Active Employees
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Employee/Index/Inactive') ?>">
                                                    Inactive Employees
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('Employee/Index/All') ?>">
                                                    All Employees
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <ul class="navbar-left" style="margin-right:5px;padding-left: 0px">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-icon icon-left" data-toggle="dropdown"> 
                                            <i class="entypo-user-add"></i>
                                            Employee Type
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('Employee/AddEmployee') ?>">
                                                    DRN Employee
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Contract Employee
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Consultant Employee
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>

                                <a data-toggle='modal' href='#import_employee' style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                    Import
                                    <i class="entypo-upload"></i>
                                </a>
                                <a href="<?php echo site_url('Employee/export_allemployee') ?>" style="margin-top:0px" class="btn btn-primary btn-icon icon-left">
                                    Export
                                    <i class="entypo-export"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Employee Table Format Start Here -->

                    <table class="table table-bordered datatable" id="table-1">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Sub Process</th>
                                <th>Designation</th>
                                <th>Vintage</th>
                                <th>Mode</th>
                                <th>Mobile Number</th>
                                <th>Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($user_role == 2) {
                                if ($uri == "") {
                                    $status = 1;
                                    $this->db->order_by('Employee_Id', 'desc');
                                    $this->db->where('Status', $status);
                                    $q = $this->db->get('tbl_employee');
                                } else {
                                    if ($uri == "Inactive") {
                                        $status = 0;
                                        $this->db->order_by('Employee_Id', 'desc');
                                        $this->db->where('Status', $status);
                                        $q = $this->db->get('tbl_employee');
                                    }if ($uri == "All") {
                                        $this->db->order_by('Employee_Id', 'desc');
                                        $q = $this->db->get('tbl_employee');
                                    }
                                }
                                $i = 1;
                                foreach ($q->Result() as $row) {
                                    $emp_id = $row->Employee_Id;
                                    $emp_no = $row->Emp_Number;

                                    $this->db->where('Employee_Id', $emp_no);
                                    $q_user = $this->db->get('tbl_user');
                                    foreach ($q_user->result() as $row_user) {
                                        $User_Photo = $row_user->User_Photo;
                                    }

                                    $this->db->where('employee_number', $emp_no);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->Result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }

                                    $emp_firstname = $row->Emp_FirstName;
                                    $emp_middlename = $row->Emp_MiddleName;
                                    $emp_lastname = $row->Emp_LastName;

                                    $this->db->where('Employee_Id', $emp_no);
                                    $q_career = $this->db->get('tbl_employee_career');
                                    foreach ($q_career->Result() as $row_career) {
                                        $branch_id = $row_career->Branch_Id;
                                        $department_id = $row_career->Department_Id;
                                        $designation_id = $row_career->Designation_Id;
                                    }


                                    $this->db->where('Designation_Id', $designation_id);
                                    $q_designation = $this->db->get('tbl_designation');
                                    foreach ($q_designation->Result() as $row_designation) {
                                        $designation_name = $row_designation->Designation_Name;
                                        $client_id = $row_designation->Client_Id;
                                    }

                                    $this->db->where('Subdepartment_Id', $client_id);
                                    $q_subdept = $this->db->get('tbl_subdepartment');
                                    foreach ($q_subdept->Result() as $row_subdept) {
                                        $subdept_name = $row_subdept->Subdepartment_Name;
                                    }

                                    $this->db->where('Department_Id', $department_id);
                                    $q_dept = $this->db->get('tbl_department');
                                    foreach ($q_dept->result() as $row_dept) {
                                        $department_name = $row_dept->Department_Name;
                                    }

                                    $contact = $row->Emp_Contact;

                                    $Emp_Doj = $row->Emp_Doj;
                                    $doj = date("Y-m-d", strtotime($Emp_Doj));
                                    $interval = date_diff(date_create(), date_create($doj));
                                    $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                    $no_days = $interval->format("%a");

                                    $emp_mode = $row->Emp_Mode;

                                    $no_days_Y = floor($no_days / 365);
                                    $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                    $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $emp_code . $emp_no; ?></td>
                                        <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                        <td><?php echo $department_name; ?></td>
                                        <td><?php echo $subdept_name; ?></td>
                                        <td><?php echo $designation_name; ?></td>
                                        <td><?php echo $no_days_Y . " Years, " . $no_days_M . " Months, <br>" . $no_days_D . " Days"; ?></td>
                                        <td>
                                            <?php
                                            if ($emp_mode == "Probation") {
                                                echo "Probationary";
                                            } elseif ($emp_mode == "Confirmed") {
                                                echo "Permanent";
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $contact; ?></td>
                                        <td><img src="<?php echo site_url('user_img/' . $User_Photo); ?>" style="width:80px;height:80px"></td>
                                        <td>
                                            <ul class="nav navbar-right pull-right">
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown">Actions<b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>">
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a data-toggle='modal' href='#delete_employee' onclick="delete_Employee(<?php echo $emp_id; ?>)">
                                                                Delete
                                                            </a>
                                                        </li>
                                                        <li>
                                                           <a data-toggle='modal' href='#add_termination' onclick="add_termination('<?php echo $emp_no; ?>')">
                                                                Termination
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo site_url('Employee/Career/' . $emp_no) ?>">
                                                                Career History
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>

                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }if ($user_role == 1) {
                                $report_id = $this->session->userdata('username');
                                $data_report = array(
                                    'Reporting_To' => $report_id,
                                    'Status' => 1
                                );
                                $this->db->where($data_report);
                                $q_emp_report = $this->db->get('tbl_employee_career');
                                $j = 1;
                                foreach ($q_emp_report->Result() as $row_emp_report) {
                                    $employee_id = $row_emp_report->Employee_Id;
                                    $this->db->order_by('Employee_Id', 'desc');
                                    $data_emp = array(
                                        'Emp_Number' => $employee_id,
                                        'Status' => 1
                                    );
                                    $this->db->where($data_emp);
                                    $q = $this->db->get('tbl_employee');

                                    foreach ($q->Result() as $row) {
                                        $emp_id = $row->Employee_Id;
                                        $emp_no = $row->Emp_Number;

                                        $this->db->where('Employee_Id', $emp_no);
                                        $q_user = $this->db->get('tbl_user');
                                        foreach ($q_user->result() as $row_user) {
                                            $User_Photo = $row_user->User_Photo;
                                        }

                                        $this->db->where('employee_number', $emp_no);
                                        $q_code = $this->db->get('tbl_emp_code');
                                        foreach ($q_code->Result() as $row_code) {
                                            $emp_code = $row_code->employee_code;
                                        }

                                        $emp_firstname = $row->Emp_FirstName;
                                        $emp_middlename = $row->Emp_MiddleName;
                                        $emp_lastname = $row->Emp_LastName;

                                        $this->db->where('Employee_Id', $emp_no);
                                        $q_career = $this->db->get('tbl_employee_career');
                                        foreach ($q_career->Result() as $row_career) {
                                            $branch_id = $row_career->Branch_Id;
                                            $department_id = $row_career->Department_Id;
                                            $designation_id = $row_career->Designation_Id;
                                        }

                                        $this->db->where('Designation_Id', $designation_id);
                                        $q_designation = $this->db->get('tbl_designation');
                                        foreach ($q_designation->Result() as $row_designation) {
                                            $designation_name = $row_designation->Designation_Name;
                                            $client_id = $row_designation->Client_Id;
                                        }

                                        $this->db->where('Subdepartment_Id', $client_id);
                                        $q_subdept = $this->db->get('tbl_subdepartment');
                                        foreach ($q_subdept->Result() as $row_subdept) {
                                            $subdept_name = $row_subdept->Subdepartment_Name;
                                        }

                                        $this->db->where('Department_Id', $department_id);
                                        $q_dept = $this->db->get('tbl_department');
                                        foreach ($q_dept->result() as $row_dept) {
                                            $department_name = $row_dept->Department_Name;
                                        }

                                        $contact = $row->Emp_Contact;
                                        $emp_mode = $row->Emp_Mode;
                                        $Emp_Doj = $row->Emp_Doj;
                                        $doj = date("Y-m-d", strtotime($Emp_Doj));
                                        $interval = date_diff(date_create(), date_create($doj));
                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                        $no_days = $interval->format("%a");

                                        $no_days_Y = floor($no_days / 365);
                                        $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                        $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                        ?>
                                        <tr>
                                            <td><?php echo $j; ?></td>
                                            <td><?php echo $emp_code . $emp_no; ?></td>
                                            <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                            <td><?php echo $department_name; ?></td>
                                            <td><?php echo $subdept_name; ?></td>
                                            <td><?php echo $designation_name; ?></td>
                                            <td><?php echo $no_days_Y . " Years, " . $no_days_M . " Months, <br>" . $no_days_D . " Days"; ?></td>
                                            <td><?php
                                                if ($emp_mode == "Probation") {
                                                    echo "Probationary";
                                                } elseif ($emp_mode == "Confirmed") {
                                                    echo "Permanent";
                                                } else {
                                                    echo "";
                                                }
                                                ?></td>
                                            <td><?php echo $contact; ?></td>
                                            <td><img src="<?php echo site_url('user_img/' . $User_Photo); ?>" style="width:80px;height:80px"></td>
                                            <td>
                                                <ul class="nav navbar-right pull-right">
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown">Actions<b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>">
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo site_url('Employee/Career/' . $emp_no) ?>">
                                                                    Career History
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-toggle='modal' href='#add_termination' onclick="add_termination('<?php echo $emp_no; ?>')">
                                                                    Termination
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php
                                        $j++;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Employee Table Format End Here -->
                </div>
            </div>
        </section>



        <!-- Import Employee Start Here -->

        <div class="modal fade" id="import_employee" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content" id="import_div">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Import Employee Data</h3>
                    </div>
                    <form role="form" id="importemployee_form" name="importemployee_form" method="post" class="validate" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="importemployee_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="importemployee_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                    <div id="importemployee_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">File Upload</label>
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="file" name="import_file" id="import_file" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
                                    </div>	
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="Import">Import</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <div class="modal-content" id="export_div" style="display:none">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Export Employee Data</h3>
                    </div>
                    <form role="form" id="exportemployee_form" name="exportemployee_form" method="post" class="validate" action="<?php echo site_url('Employee/export_employee') ?>">
                        <div class="modal-body">
                            <button type="submit" class="btn btn-primary" name="Export" style="margin-left:35%;margin-bottom: 4%;width:30%">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Employee End Here -->


        <!-- Delete Employee Start Here -->

        <div class="modal fade" id="delete_employee">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Company</h3>
                    </div>
                    <form role="form" id="deleteemployee_form" name="deleteemployee_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Employee End Here -->

        <!-- Add Termination Start Here -->

        <div class="modal fade custom-width" id="add_termination">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Termination</h3>
                    </div>
                    <form role="form" id="addtermination_form" name="addtermination_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Add Termination End Here -->

        <script type="text/javascript">
            $(document).ready(function (e) {
                $("#importemployee_form").on('submit', (function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "<?php echo site_url('Employee/import_employee') ?>",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data)
                        {
                            if (data == "fail") {
                                $('#importemployee_error').show();
                            }

                            if (data == "success") {
                                $('#importemployee_success').show();
                                $('#import_div').hide();
                                $('#export_div').show();
                                // $('#import_employee').hide();
                                // $('#export_employee').modal('show', {backdrop: 'static'});
                            }
                        },
                        error: function ()
                        {

                        }
                    });
                }));
            });

        </script>

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
                tableContainer = $("#table-1");

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

