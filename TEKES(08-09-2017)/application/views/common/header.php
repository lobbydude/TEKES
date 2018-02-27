<?php
$this->db->where('id', 1);
$q_empcode = $this->db->get('tbl_emp_code');
foreach ($q_empcode->result() as $row_empcode) {
    $emp_code = $row_empcode->employee_code;
    $start_number = $row_empcode->employee_number;
}

$user_id = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');

$this->db->where('Employee_Id', $user_id);
$q_user = $this->db->get('tbl_user');
foreach ($q_user->result() as $row_user) {
    $password_updated = $row_user->Password_Updated;
}

//$password_updated = $this->session->userdata('password_updated');

$this->db->where('Emp_Number', $user_id);
$q = $this->db->get('tbl_employee');
foreach ($q->result() as $row) {
    $name = $row->Emp_FirstName;
    $name .= " " . $row->Emp_LastName;
    $name .= " " . $row->Emp_MiddleName;
}

$this->db->where('Reporting_To', $user_id);
$q_career = $this->db->get('tbl_employee_career');
$count_career = $q_career->num_rows();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="<?php echo site_url('images/drn_logo.png') ?>" type="image/png">
        <title><?php echo $title; ?> : Dashboard</title>

        <?php
        $this->load->view('common/head.php');
        ?>

    </head>
    <body class="page-body">

        <div class="page-container horizontal-menu">
            <header class="navbar navbar-fixed-top"><!-- set fixed position by adding class "navbar-fixed-top" -->
                <div class="navbar-inner">

                    <div class="navbar-brand">
                        <a href="<?php echo site_url('Profile') ?>">
                            <img alt="" src="<?php echo site_url('images/logo@2x.png') ?>">
                        </a>
                    </div>
                    <!-- main menu -->

                    <ul class="navbar-nav">

                        <li class="<?php
                        if ($this->uri->segment(1) == "Employee" || $this->uri->segment(1) == "Resignation" || $this->uri->segment(1) == "Salary" || $this->uri->segment(1) == "Leaves" || $this->uri->segment(1) == "Attendance") {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo site_url('Employee/Editemployee'); ?>">
                                <i class="entypo-user"></i>
                                <span class="title">My Profile</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="<?php echo site_url('Attendance/Employee') ?>">
                                        <span class="title">Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('Payslip/Employee') ?>">
                                        <span class="title">Salary</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('Leaves') ?>">
                                        <span class="title">Leaves</span>
                                    </a>
                                </li>

                                <li class="<?php
                                if ($this->uri->segment(1) == "Resignation") {
                                    echo "active";
                                }
                                ?>">
                                    <a href="<?php echo site_url('Resignation') ?>">
                                        <span class="title">Resignation</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="<?php
                        if ($this->uri->segment(1) == "Meetings") {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo site_url('Meetings/employee'); ?>">
                                <i class="entypo-users"></i>
                                <span class="title">Meetings</span>
                            </a>
                        </li>
						<li class="<?php
                        if ($this->uri->segment(3) == "Ipr") {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo site_url('Ipr/Question') ?>">
                                <i class="entypo-arrows-ccw"></i>

                                <span class="title">Process Knowledge</span>
                            </a>
                        </li>
                        <li class="<?php
                        if ($this->uri->segment(1) == "Suggestion") {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo site_url('Suggestion') ?>">
                                <i class="entypo-shareable"></i>

                                <span class="title">Suggestion</span>
                            </a>
                        </li>					
						
                    </ul>


                    <!-- notifications and other links -->
                    <ul class="nav navbar-right pull-right">
                        <li>
                            <a href="<?php echo site_url('Operation'); ?> ">
                                <?php
                                if ($user_role == 1) {
                                    echo "Manager Dashboard";
                                }if ($user_role == 2) {
                                    echo "HR Dashboard";
                                }
                                if ($user_role == 4) {
                                    echo "Admin Dashboard";
                                }if ($user_role == 5) {
                                    echo "IT Dashboard";
                                }
                                if ($user_role == 6) {
                                    echo "Super Admin Dashboard";
                                }
								if ($user_role == 7) {
                                    echo "Supervisor Dashboard";
                                }
                                ?> 
                            </a>
                        </li>
                        <li class="sep"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $name; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a data-toggle='modal' href='#change_password'>Change Password</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo site_url('Profile/Logout'); ?> ">
                                Log Out <i class="entypo-logout right"></i>
                            </a>
                        </li>



                        <!-- mobile only -->
                        <li class="visible-xs">	

                            <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                            <div class="horizontal-mobile-menu visible-xs">
                                <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                                    <i class="entypo-menu"></i>
                                </a>
                            </div>

                        </li>

                    </ul>

                </div>

            </header>

            <div class="modal fade" id="change_password">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header info-bar">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Change Password</h3>
                        </div>
                        <form role="form" id="changepassword_form" name="changepassword_form" method="post" class="validate">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="changepassword_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="changepassword_success" class="alert alert-success" style="display:none;">Password changed successfully.</div>
                                        <div id="changepassword_error" class="alert alert-danger" style="display:none;">Failed to change password.</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Current Password</label>
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" data-validate="required" data-message-required="Please enter current password.">
                                        </div>	
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">New Password </label>
                                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" data-validate="required" data-message-required="Please enter new password.">
                                        </div>	
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="password_update" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header info-bar">
                            <h3 class="modal-title">Change Password</h3>
                        </div>
                        <form role="form" id="password_update_form" name="password_update_form" method="post" class="validate">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-10">
                                        <div id="changepwd_server_error" class="alert alert-info" style="display:none;"></div>
                                        <div id="changepwd_invalid" class="alert alert-info" style="display:none;">Current Password is wrong.</div>
                                        <div id="changepwd_success" class="alert alert-success" style="display:none;">Password changed successfully.</div>
                                        <div id="changepwd_error" class="alert alert-danger" style="display:none;">Failed to change password.</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Current Password</label>
                                            <input type="password" name="curr_password" id="curr_password" class="form-control" placeholder="Current Password" data-validate="required" data-message-required="Please enter current password.">
                                        </div>	
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">New Password </label>
                                            <input type="password" name="ne_password" id="ne_password" class="form-control" placeholder="New Password" data-validate="required" data-message-required="Please enter new password.">
                                        </div>	
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $('#changepassword_form').submit(function (e) {
                        e.preventDefault();
                        var formdata = {
                            current_password: $('#current_password').val(),
                            new_password: $('#new_password').val()
                        };
                        $.ajax({
                            url: "<?php echo site_url('Profile/change_password') ?>",
                            type: 'post',
                            data: formdata,
                            success: function (msg) {
                                if (msg == 'fail') {
                                    $('#changepassword_error').show();
                                }
                                if (msg == 'success') {
                                    $('#changepassword_success').show();
                                    window.location.reload();
                                }
                                if (msg == 'invalid') {
                                    $('#changepassword_invalid').show();
                                }

                            }

                        });
                    });

                    $('#password_update_form').submit(function (e) {
                        e.preventDefault();
                        var formdata = {
                            current_password: $('#curr_password').val(),
                            new_password: $('#ne_password').val()
                        };
                        $.ajax({
                            url: "<?php echo site_url('Profile/change_password') ?>",
                            type: 'post',
                            data: formdata,
                            success: function (msg) {
                                if (msg == 'fail') {
                                    $('#changepwd_error').show();
                                }
                                if (msg == 'success') {
                                    $('#changepwd_success').show();
                                    window.location.reload();
                                }
                                if (msg == 'invalid') {
                                    $('#changepwd_invalid').show();
                                }

                            }

                        });
                    });

                });

            </script>

            <?php
            if ($password_updated == "No") {
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#password_update').modal('show', {backdrop: 'static'});
                    });
                </script>

            <?php } ?>