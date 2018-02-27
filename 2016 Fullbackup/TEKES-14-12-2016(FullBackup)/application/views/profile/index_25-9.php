<?php
$user_id = $this->session->userdata('username');
$this->db->where('Emp_Number', $user_id);
$q = $this->db->get('tbl_employee');
foreach ($q->result() as $row) {
    $firstname = $row->Emp_FirstName;
    $lastname = $row->Emp_LastName;
}

$this->db->where('employee_number', $user_id);
$q_empcode = $this->db->get('tbl_emp_code');
foreach ($q_empcode->Result() as $row_empcode) {
    $emp_code = $row_empcode->employee_code;
}

$this->db->where('Employee_Id', $user_id);
$q_career = $this->db->get('tbl_employee_career');
foreach ($q_career->Result() as $row_career) {
    $branch_id = $row_career->Branch_Id;
    $department_id = $row_career->Department_Id;
    $designation_id = $row_career->Designation_Id;
}

$this->db->where('Designation_Id', $designation_id);
$q_designation = $this->db->get('tbl_designation');
foreach ($q_designation->result() as $row_designation) {
    $designation_name = $row_designation->Designation_Name;
    $sub_dept_id = $row_designation->Client_Id;
}

$this->db->where('Subdepartment_Id', $sub_dept_id);
$q_subdept = $this->db->get('tbl_subdepartment');
foreach ($q_subdept->result() as $row_subdept) {
    $sub_dept_name = $row_subdept->Subdepartment_Name;
}
$this->db->where('Department_Id', $department_id);
$q_dept = $this->db->get('tbl_department');
foreach ($q_dept->result() as $row_dept) {
    $department_name = $row_dept->Department_Name;
}

$this->db->where('Branch_ID', $branch_id);
$q_branch = $this->db->get('tbl_branch');
foreach ($q_branch->result() as $row_branch) {
    $branch_name = $row_branch->Branch_Name;
    $company_id = $row_branch->Company_Id;
}

$this->db->where('Company_Id', $company_id);
$q_company = $this->db->get('tbl_company');
foreach ($q_company->result() as $row_company) {
    $company_name = $row_company->Company_Name;
}

$this->db->where('Employee_Id', $user_id);
$q_user = $this->db->get('tbl_user');
foreach ($q_user->result() as $row_user) {
    $user_role_id = $row_user->User_RoleId;
    $last_log = $row_user->Last_login;
    if ($last_log == "0000-00-00 00:00:00") {
        $last_login = "";
    } else {
        $last_login = date("d-m-Y", strtotime($last_log));
    }
    $user_photo = $row_user->User_Photo;

    $this->db->where('Role_Id', $user_role_id);
    $q_userrole = $this->db->get('tbl_user_role');
    foreach ($q_userrole->result() as $row_userrole) {
        $user_role = $row_userrole->Role_Name;
    }
}

$res_data1 = array(
    'Employee_Id' => $user_id,
    'Emp_read' => 'unread'
);
$this->db->where($res_data1);
$q_resignation = $this->db->get('tbl_resignation');
$resignation_count = $q_resignation->num_rows();

$leave_data1 = array(
    'Employee_Id' => $user_id,
    'Emp_read' => 'unread'
);
$this->db->where($leave_data1);
$q_leave = $this->db->get('tbl_leaves');
$leave_count = $q_leave->num_rows();

$leave_summary_data = array(
    'Emp_Id' => $user_id,
    'Status' => 1
);
$this->db->where($leave_summary_data);
$q_leave_summary = $this->db->get('tbl_leave_pending');

$leave_type_data = array(
    'Status' => 1
);
$this->db->where($leave_type_data);
$q_leave_type = $this->db->get('tbl_leavetype');

$this->db->where('Status', 1);
$q_announcement = $this->db->get('tbl_announcement');
$announcement_count = $q_announcement->num_rows();
?>

<script>
    function view_announcement(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Announcement/Viewannouncement') ?>",
            data: "A_Id=" + id,
            cache: false,
            success: function (html) {
                $("#viewannouncement_form").html(html);

            }
        });
    }
</script>
<link href="<?php echo site_url('css/announcement/site.css') ?>" rel="stylesheet" type="text/css" />
<!--<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
<script src="<?php echo site_url('js/announcement/jquery.bootstrap.newsbox.min.js') ?>" type="text/javascript"></script>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Notifications
                                </div>
                            </div>
                            <div class="panel-body">
                                <ul class="country-list">
                                    <li><a href="<?php echo site_url("Resignation"); ?>">Resignation</a><?php if ($resignation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $resignation_count; ?></span> <?php } ?></li>
                                    <li><a href="<?php echo site_url("Leaves"); ?>">Leaves</a><?php if ($leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $leave_count; ?></span> <?php } ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <!-- panel head -->
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Profile
                                    </div>
                                </div>

                                <!-- panel body -->
                                <div class="panel-body">
                                    <div class="profile_pic">
                                        <a class="profile-picture" href="#">
                                            <img class="img-responsive img-circle seemore bnd dhover" src="<?php echo site_url('user_img/' . $user_photo) ?>" usetop="true" smind="2" width="115" height="115" style="width:115px;height:115px">
                                        </a>
                                    </div>
                                    <div class="detail">
                                        <h3><?php echo $firstname . ' ' . $lastname; ?></h3>
                                        <p><strong>Company : </strong><span><?php echo $company_name; ?></span></p>
                                        <p><strong>Branch : </strong><span><?php echo $branch_name; ?></span></p>
                                        <p><strong>Department : </strong><span><?php echo $department_name; ?></span></p>
                                        <p><strong>Sub Department : </strong><span><?php echo $sub_dept_name; ?></span></p>
                                        <p><strong>Designation : </strong><span><?php echo $designation_name; ?></span></p>
                                        <p><strong>User Role : </strong><span><?php echo $user_role; ?></span></p>
                                        <p><strong>Employee Code : </strong><span><?php echo $emp_code . $user_id; ?></span></p>
                                        <p><strong>Last logged in : </strong><span><?php echo $last_login; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Announcement Current Month Start here-->
                    <div class="col-md-7" id="current_month_div">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Announcement of <?php echo date('F Y'); ?>  
                                    </div>
                                </div>                                
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <ul class="current_month" id="current_month_scroll">
                                            <?php
                                            if ($announcement_count > 0) {
                                                foreach ($q_announcement->result() as $row_announcement) {
                                                    $announcement_id = $row_announcement->A_Id;
                                                    $announcement_title = $row_announcement->Title;
                                                    $announcement_date1 = $row_announcement->Date;
                                                    $announcement_date = date("d-m-Y", strtotime($announcement_date1));
                                                    $announcement_message = $row_announcement->Message;
                                                    $current_date = date("Y-m-d");
                                                    $last_day_current_month = date('Y-m-t');
                                                    if (($announcement_date1 > $current_date) && ( $last_day_current_month >= $announcement_date1 )) {
                                                        ?>
                                                        <div class="modal-body">
                                                            <a data-toggle='modal' href='#view_announcement' onclick="view_announcement(<?php echo $announcement_id; ?>)">
                                                                <li class="news-item">                                    

                                                                    <h4 class="modal-title"><b><?php echo $announcement_date; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $announcement_title; ?></b></h4>
                                                                    <p class="readmore"><?php echo $announcement_message; ?></p>                                                              
                                                                </li>
                                                            </a>                                           

                                                        </div>                                            
                                                        <?php
                                                    }
                                                }
                                            } else {
                                                echo "No results found";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>                         
                            </div>                        
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(function () {
                            $("#current_month_scroll").bootstrapNews({
                                newsPerPage: 5,
                                autoplay: true,
                                pauseOnHover: true,
                                direction: 'up',
                                newsTickerInterval: 4000,
                                onToDo: function () {
                                }
                            });
                        });
                    </script>
                    <!-- Announcement Current Month End here-->
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Calender
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="calendar" class="datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Leave Summary
                                    </div>
                                </div>                                
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <?php
                                                    foreach ($q_leave_type->result() as $row_leave_type) {
                                                        $leave_type = $row_leave_type->Leave_Title;
                                                        ?>
                                                        <th><?php echo $leave_type ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $el_leave_taken = 0;
                                                $cl_leave_taken = 0;
                                                foreach ($q_leave_summary->result() as $row_leave_summary) {
                                                    $el_leave = $row_leave_summary->EL;
                                                    $cl_leave = $row_leave_summary->CL;
                                                    ?>
                                                    <tr>
                                                        <td>Balance</td>
                                                        <td><?php echo $el_leave; ?></td>
                                                        <td><?php echo $cl_leave; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td>Taken</td>
                                                    <td><?php echo $el_leave_taken; ?></td>
                                                    <td><?php echo $cl_leave_taken; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                              
                            </div>                        
                        </div>
                    </div>
                    
                </div>
            </div>

            <script type="text/javascript">
                $(function () {
                    $(".demo1").bootstrapNews({
                        newsPerPage: 5,
                        autoplay: true,
                        pauseOnHover: true,
                        direction: 'up',
                        newsTickerInterval: 4000,
                        onToDo: function () {
                            //console.log(this);
                        }
                    });


                });
            </script>

            <!-- View Announcement Form Start Here -->
            <div class="modal fade custom-width" id="view_announcement">
                <div class="modal-dialog" style="width:65%">
                    <div class="modal-content">

                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">View Announcement</h3>
                        </div>                                      

                        <form role="form" id="viewannouncement_form" name="viewannouncement_form" method="post" class="validate">

                        </form>                                            
                    </div>
                </div>
            </div>
            <!-- View Announcement Form END-->