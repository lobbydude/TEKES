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

    function add_termination(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/add_termination') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#add_termination_div").html(html);
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
    function resignation_status(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Resignation/ViewResignation') ?>",
            data: "resignation_id=" + id,
            cache: false,
            success: function (html) {
                $("#resignation_status_form").html(html);

            }
        });
    }

    function termination_status(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/ViewTermination') ?>",
            data: "R_Id=" + id,
            cache: false,
            success: function (html) {
                $("#termination_status_form").html(html);
            }
        });
    }

    function change_res_type(type) {
        if (type == "Termination") {
            $("#resignation_div").hide();
            $("#termination_div").show();
        }
        else {
            $("#termination_div").hide();
            $("#resignation_div").show();
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
                            <h2>Employee</h2>
                        </div>
                        <?php if ($user_role == 2 || $user_role == 6) { ?>
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

                                <ul class="navbar-left" style="margin-right:5px;padding-left: 0px">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-icon icon-left" data-toggle="dropdown"> 
                                            <i class="entypo-upload"></i>
                                            Import
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a data-toggle='modal' href='#import_employee'>
                                                    Employee Info
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle='modal' href='#import_accountinfo'>
                                                    Account Info
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <a href="<?php echo site_url('Employee/export_allemployee') ?>" class="btn btn-primary btn-icon icon-left" style="margin-top:0px">
                                    <i class="entypo-download"></i>
                                    Export
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
                                <th>Employee Name</th>
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
                            if ($user_role == 2 || $user_role == 6) {
                                if ($uri == "") {
                                    $this->db->order_by('Employee_Id', 'desc');
                                    $this->db->where('Status', 1);
                                    $q = $this->db->get('tbl_employee');
                                } else {
                                    if ($uri == "Inactive") {
                                        $this->db->order_by('Employee_Id', 'desc');
                                        $this->db->where('Status', 0);
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
                                    $status = $row->Status;
                                    $Emp_Doj = $row->Emp_Doj;
                                    if ($status == 1) {
                                        $doj = date("Y-m-d", strtotime($Emp_Doj));
                                        $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                                        $interval = date_diff(date_create(), date_create($doj_no));
                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                        $no_days = $interval->format("%a");
                                        $no_days_Y = floor($no_days / 365);
                                        $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                        $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                    } else {
                                        $Resignation_Id = $row->Emp_Resigned_Id;
                                        $this->db->where('R_Id', $Resignation_Id);
                                        $q_resignation = $this->db->get('tbl_resignation');
                                        foreach ($q_resignation->result() as $row_resignation) {
                                            $Resignation_Type = $row_resignation->Type;
                                            $last_working_day = $row_resignation->Last_Working_Date;
                                        }

                                        $doj = date("Y-m-d", strtotime($Emp_Doj));
                                        $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                                        $interval = date_diff(date_create($last_working_day), date_create($doj_no));
                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                        $no_days = $interval->format("%a");
                                        $no_days_Y = floor($no_days / 365);
                                        $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                        $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                    }
                                    $emp_mode = $row->Emp_Mode;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><a href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>"><?php echo $emp_code . $emp_no; ?></a></td>
                                        <td><a style="text-decoration: underline;" href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>"><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></a></td>
                                        <td><?php echo $department_name; ?></td>
                                        <td><?php echo $subdept_name; ?></td>
                                        <td><?php echo $designation_name; ?></td>
                                        <td>
                                            <?php
                                            echo $no_days_Y . " Years, " . $no_days_M . " Months, <br>" . $no_days_D . " Days";
                                            ?>
                                        </td>
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
                                                    <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown" style="width:95px">Actions<b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <?php if ($status == 1) { ?>
                                                            <li>
                                                                <a href="<?php echo site_url('Shiftallocate/Info/' . $emp_no) ?>">
                                                                    Shift Time
                                                                </a>
                                                            </li>                                                                                                                                                                                    
                                                            <li>
                                                                <a href="<?php echo site_url('Leaves/Mode/' . $emp_no) ?>">
                                                                    Leaves info
                                                                </a>
                                                            </li>
															<li>
                                                            <a href="<?php echo site_url('Salary/Info/' . $emp_no) ?>">
                                                                Salary Info
                                                            </a>
                                                        </li>
                                                            <?php
                                                        } else {
                                                            if ($Resignation_Type == "Resignation") {
                                                                ?>
                                                                <li>
                                                                    <a data-toggle='modal' href='#resignation_status' onclick="resignation_status(<?php echo $Resignation_Id; ?>)">
                                                                        Resigned
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <li>
                                                                    <a data-toggle='modal' href='#termination_status' onclick="termination_status('<?php echo $Resignation_Id; ?>')">
                                                                        Terminated
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo site_url('Leaves/Mode/' . $emp_no) ?>">
                                                                    Leaves
                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>                                                            
                                                        <li>
                                                            <a href="<?php echo site_url('Resignation/Mode/' . $emp_no) ?>">
                                                                Resignation
                                                            </a>
                                                        </li>                                                                                                                
                                                        <li>
                                                            <a target="_blank" href="<?php echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=offerletter.mrt&param1=' . $emp_no); ?>">
                                                                Offer Letter
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
                            }
                            if ($user_role == 4 || $user_role == 5 || $user_role == 7) {
                                if ($uri == "") {
                                    $this->db->order_by('Employee_Id', 'desc');
                                    $this->db->where('Status', 1);
                                    $q = $this->db->get('tbl_employee');
                                } else {
                                    if ($uri == "Inactive") {
                                        $this->db->order_by('Employee_Id', 'desc');
                                        $this->db->where('Status', 0);
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
                                    $status = $row->Status;
                                    $Emp_Doj = $row->Emp_Doj;
                                    if ($status == 1) {
                                        $doj = date("Y-m-d", strtotime($Emp_Doj));
                                        $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                                        $interval = date_diff(date_create(), date_create($doj_no));
                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                        $no_days = $interval->format("%a");
                                        $no_days_Y = floor($no_days / 365);
                                        $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                        $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                    } else {
                                        $emp_resigned_status = $row->Emp_Resigned_Status;
                                        $Resignation_Id = $row->Emp_Resigned_Id;
                                        if ($emp_resigned_status == "Terminated") {
                                            $this->db->where('Employee_Id', $emp_no);
                                            $q_termination = $this->db->get('tbl_termination');
                                            foreach ($q_termination->result() as $row_termination) {
                                                $last_working_day = $row_termination->LWD_Date;
                                            }
                                        } else {
                                            $this->db->where('Employee_Id', $emp_no);
                                            $q_resignation = $this->db->get('tbl_resignation');
                                            foreach ($q_resignation->result() as $row_resignation) {
                                                $last_working_day = $row_resignation->Last_Working_Date;
                                            }
                                        }
                                        $doj = date("Y-m-d", strtotime($Emp_Doj));
                                        $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                                        $interval = date_diff(date_create($last_working_day), date_create($doj_no));
                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                        $no_days = $interval->format("%a");
                                        $no_days_Y = floor($no_days / 365);
                                        $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                        $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                    }
                                    $emp_mode = $row->Emp_Mode;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $emp_code . $emp_no; ?></td>
                                        <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                        <td><?php echo $department_name; ?></td>
                                        <td><?php echo $subdept_name; ?></td>
                                        <td><?php echo $designation_name; ?></td>
                                        <td><?php echo $no_days_Y . " Years, " . $no_days_M . " Months, <br>" . $no_days_D . " Days";
                                    ?></td>
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
                                                    <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown" style="width:95px">Actions<b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>">
                                                                View
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
                            }
                            if ($user_role == 1) {
                                $report_id = $this->session->userdata('username');
                                $this->db->group_by('Employee_Id');
                                $data_report = array(
                                    'Reporting_To' => $report_id,
                                    'Status' => 1
                                );
                                $this->db->where($data_report);
                                $q_emp_report = $this->db->get('tbl_employee_career');
                                $j = 1;
                                foreach ($q_emp_report->Result() as $row_emp_report) {
                                    $employee_id = $row_emp_report->Employee_Id;
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
                                        $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                                        $interval = date_diff(date_create(), date_create($doj_no));
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
                                                        <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown" style="width:95px">Actions<b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>">
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo site_url('Shiftallocate/Info/' . $emp_no) ?>">
                                                                Shift time
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo site_url('Leaves/Mode/' . $emp_no) ?>">
                                                                    Leaves
                                                                </a>
                                                            </li>                                                            
                                                            <li>
                                                                <a href="<?php echo site_url('Employee/Career/' . $emp_no) ?>">
                                                                    Career History
                                                                </a>
                                                            </li>
															
                                                            <li>
                                                                <a href="<?php echo site_url('Resignation/Mode/' . $emp_no) ?>">
                                                                    Resignation
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

        <!-- Import Account Info Start Here -->

        <div class="modal fade" id="import_accountinfo" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content" id="import_div">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Import Account Data</h3>
                    </div>
                    <form role="form" id="importaccountinfo_form" name="importaccountinfo_form" method="post" class="validate" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="importaccountinfo_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="importaccountinfo_success" class="alert alert-success" style="display:none;">Data imported successfully.</div>
                                    <div id="importaccountinfo_error" class="alert alert-danger" style="display:none;">Failed to data import.</div>
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
                                        <input type="file" name="import_accountinfofile" id="import_accountinfofile" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" data-validate="required" data-message-required="Please select file.">
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
            </div>
        </div>

        <!-- Import Account Info End Here -->

        <!-- Add Termination Start Here -->

        <div class="modal fade custom-width" id="add_termination">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Resignation</h3>
                    </div>
                    <form role="form" id="addtermination_form" name="addtermination_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addresignation_success" class="alert alert-success" style="display:none;">Resignation sent successfully.</div>
                                    <div id="addresignation_error" class="alert alert-danger" style="display:none;">Failed to send resignation.</div>
                                    <div id="addtermination_success" class="alert alert-success" style="display:none;">Termination sent successfully.</div>
                                    <div id="addtermination_error" class="alert alert-danger" style="display:none;">Failed to send termination.</div>
                                </div>
                            </div>
                            <div id="add_termination_div"></div>
                            <div class="row" style="margin-top: 10px;margin-bottom: 20px">
                                <div class="col-md-4">
                                    <label class="control-label" for="full_name">Type</label>
                                    <select class="round" name="add_res_type" id="add_res_type" onChange="change_res_type(this.value);">
                                        <option value="Termination">Termination</option>
                                        <option value="Resignation">Resignation</option>
                                    </select>
                                </div>
                                <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:13%;left:50%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
                                <div id="termination_div">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Last Working Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_termination_lwd" id="add_termination_lwd" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select last working date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Termination Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_termination_date" id="add_termination_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select termination date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Reason</label>
                                            <div class="input-group">
                                                <textarea name="add_termination_reason" id="add_termination_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter reason."></textarea>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Terminated By</label>
                                            <div class="input-group">
                                                <input type="text" name="add_termination_by" id="add_termination_by" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter terminated by.">
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                                <div id="resignation_div" style="display: none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Letter Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_notice_date" id="add_notice_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select notice date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Resignation Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_resignation_date" id="add_resignation_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select resignation date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Reason</label>
                                            <textarea name="add_reason" id="add_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter grade."></textarea>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="addtermination_button">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
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
                            if (data.trim() == "fail") {
                                $('#importemployee_error').show();
                            }

                            if (data.trim() == "success") {
                                $('#importemployee_success').show();
                                $('#import_div').hide();
                                $('#export_div').show();
                            }
                        },
                        error: function ()
                        {
                        }
                    });
                }));
                $("#importaccountinfo_form").on('submit', (function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "<?php echo site_url('Employee/import_accountinfo') ?>",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data)
                        {
                            if (data.trim() == "fail") {
                                $('#importaccountinfo_error').show();
                                window.location.reload();
                            }

                            if (data.trim() == "success") {
                                $('#importaccountinfo_success').show();
                            }
                        },
                        error: function ()
                        {
                        }
                    });
                }));
            });

        </script>

        <!-- Resignation Status Start Here -->

        <div class="modal fade custom-width" id="resignation_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="modal-title">View Resignation</h3>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary" onclick="resignation_print('resignation_print')"><i class="entypo-print"></i>Print</a>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="location.reload();">&times;</button>
                            </div>
                        </div>
                    </div>
                    <form role="form" id="resignation_status_form" name="resignation_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Resignation Status End Here -->

        <!-- Resignation Status Start Here -->

        <div class="modal fade custom-width" id="termination_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="modal-title">View Termination</h3>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary" onclick="termination_print('termination_print')"><i class="entypo-print"></i>Print</a>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="location.reload();">&times;</button>
                            </div>
                        </div>
                    </div>
                    <form role="form" id="termination_status_form" name="termination_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Termination Status End Here -->

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

