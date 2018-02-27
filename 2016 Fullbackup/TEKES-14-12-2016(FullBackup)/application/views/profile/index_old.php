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
    $sub_dept_id=$row_designation->Client_Id;
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
    $last_login = $row_user->Last_login;
    $user_photo = $row_user->User_Photo;

    $this->db->where('Role_Id', $user_role_id);
    $q_userrole = $this->db->get('tbl_user_role');
    foreach ($q_userrole->result() as $row_userrole) {
        $user_role = $row_userrole->Role_Name;
    }
}
?>
<link href="<?php echo site_url('css/announcement/site.css') ?>" rel="stylesheet" type="text/css" />
<!--<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
<script src="<?php echo site_url('js/announcement/jquery.bootstrap.newsbox.min.js') ?>" type="text/javascript"></script>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

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
                    <div class="col-md-7">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <!-- panel head -->
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Announcement
                                    </div>
                                </div>
                                <!-- panel body -->
                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <ul class="demo1">
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                            <li class="news-item">
                                                <table cellpadding="4">
                                                    <tr>
                                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim <br>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in venenatis enim... <br />
                                                            <a href="#">Read more...</a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-footer"> </div>
                            </div>                        
                        </div>
                    </div>

                </div>

                <br />


                <script type="text/javascript">
                    // Code used to add Todo Tasks
                    jQuery(document).ready(function ($)
                    {
                        var $todo_tasks = $("#todo_tasks");

                        $todo_tasks.find('input[type="text"]').on('keydown', function (ev)
                        {
                            if (ev.keyCode == 13)
                            {
                                ev.preventDefault();

                                if ($.trim($(this).val()).length)
                                {
                                    var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>' + $(this).val() + '</label></div></li>');
                                    $(this).val('');

                                    $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                                    $todo_entry.hide().slideDown('fast');
                                    replaceCheckboxes();
                                }
                            }
                        });
                    });
                </script>

                <div class="row">

                    <script src="<?php echo site_url('js/fullcalendar/fullcalendar.min.js') ?>"></script>
                    <script type="text/javascript">
                    jQuery(document).ready(function ($)
                    {
                        $("#calendar").fullCalendar({
                            header: {
                                left: '',
                                right: '',
                            },
                            firstDay: 1,
                            height: 200,
                        });
                    });


                    function getRandomInt(min, max)
                    {
                        return Math.floor(Math.random() * (max - min + 1)) + min;
                    }
                    </script>
                    <div class="col-sm-4">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Calender
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="calendar" class="calendar-widget">
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