<?php
$q = $this->db->get('tbl_company');
foreach ($q->result() as $row) {
    $cmp_logo = $row->Comp_Logo;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="icon" href="<?php echo site_url('images/drn_logo.png') ?>" type="image/png">
        <link rel="stylesheet" href="<?php echo site_url('js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') ?>">
        <link rel="stylesheet" href="<?php echo site_url('css/font-icons/entypo/css/entypo.css') ?>">
        <link rel="stylesheet" href="<?php echo site_url('css/bootstrap.css') ?>">
        <link rel="stylesheet" href="<?php echo site_url('css/neon-core.css') ?>">
        <link rel="stylesheet" href="<?php echo site_url('css/neon-theme.css') ?>">
        <link rel="stylesheet" href="<?php echo site_url('css/neon-forms.css') ?>">
        <link rel="stylesheet" href="<?php echo site_url('css/custom.css') ?>">

        <script src="<?php echo site_url('js/jquery-1.11.0.min.js') ?>"></script>
        <script>$.noConflict();</script>

    </head>

    <body class="page-body login-page login-form-fall">


        <!-- This is needed when you send requests via Ajax -->
        <script type="text/javascript">
            var baseurl = '';
        </script>

        <div class="login-container">

            <div class="login-header login-caret">

                <div class="login-content">

                    <a href="#" class="logo" title="TEKES My Info">
                        <img src="<?php echo site_url('company_logo/' . $cmp_logo); ?>" alt="" />
                    </a>

                    <!--<p class="description">Dear user, log in to access the admin area!</p>-->

                    <!-- progress bar indicator -->
                    <div class="login-progressbar-indicator">
                        <h3>43%</h3>
                        <span>logging in...</span>
                    </div>
                </div>

            </div>

            <div class="main-content">
                <div class="container">
                    <div class="login-progressbar">
                        <div></div>
                    </div>

                    <div class="login-form">

                        <div class="login-content" >


                            <div class="form-login-error" id="login_error">
                                <h3>Invalid login</h3>
                            </div>

                            <form method="post" role="form" id="form_login" class="form_login">

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="entypo-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="entypo-key"></i>
                                        </div>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block btn-login">
                                        <i class="entypo-login"></i>
                                        Login In
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <footer class="main" style="margin-top:50px">
                        <p class="pull-left" style="color:#fff">
                            &copy; 2017 <a href="http://drnds.com" target="_blank" style="color:#fff">DRN Definite Solutions. All Rights Reserved.</a>
                        </p>
                        <!--<p class="pull-right" style="color:#fff">
                            Powered By DRN.
                        </p>-->
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="password_modal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Change New Password</h3>
                </div>
                <form role="form" id="password_form" name="password_form" method="post" class="validate">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div id="password_server_error" class="alert alert-info" style="display:none;"></div>
                                <div id="password_success" class="alert alert-success" style="display:none;">Password has been changed successfully.</div>
                                <div id="password_error" class="alert alert-danger" style="display:none;">Failed to change password.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">New Password</label>
                                    <input type="text" name="new_password" id="new_password" class="form-control" placeholder="Password" data-validate="required" data-message-required="Please enter password.">
                                    <input type="hidden" name="emp_id" id="emp_id" class="form-control" >
                                </div>	
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="superadmin_popup" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header info-bar">
                    <h3>Please Confirm</h3>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px;text-align: center">
                        <h3>
                            <a href="<?php echo site_url('Operation'); ?>" class="btn btn-default">
                                Super Admin Dashboard
                            </a>
                            <a href="<?php echo site_url('Profile'); ?>" class="btn btn-primary">
                                Personal Dashboard
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="it_popup" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header info-bar">
                    <h3>Please Confirm</h3>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px;text-align: center">
                        <h3>
                            <a href="<?php echo site_url('Operation'); ?>" class="btn btn-default">
                                IT Dashboard
                            </a>
                            <a href="<?php echo site_url('Profile'); ?>" class="btn btn-primary">
                                Personal Dashboard
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="admin_popup" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header info-bar">
                    <h3>Please Confirm</h3>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px;text-align: center">
                        <h3>
                            <a href="<?php echo site_url('Operation'); ?>" class="btn btn-default">
                                Admin Dashboard
                            </a>
                            <a href="<?php echo site_url('Profile'); ?>" class="btn btn-primary">
                                Personal Dashboard
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hr_popup" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header info-bar">
                    <h3>Please Confirm</h3>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px;text-align: center">
                        <h3>
                            <a href="<?php echo site_url('Operation'); ?>" class="btn btn-default">
                                HR Dashboard
                            </a>
                            <a href="<?php echo site_url('Profile'); ?>" class="btn btn-primary">
                                Personal Dashboard
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="manager_popup" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header info-bar">
                    <h3>Please Confirm</h3>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px;text-align: center">
                        <h3>
                            <a href="<?php echo site_url('Operation'); ?>" class="btn btn-default">
                                Manager Dashboard
                            </a>
                            <a href="<?php echo site_url('Profile'); ?>" class="btn btn-primary">
                                Personal Dashboard
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<div class="modal fade" id="supervisor_popup" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header info-bar">
                    <h3>Please Confirm</h3>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px;text-align: center">
                        <h3>
                            <a href="<?php echo site_url('Operation'); ?>" class="btn btn-default">
                                Supervisor Dashboard
                            </a>
                            <a href="<?php echo site_url('Profile'); ?>" class="btn btn-primary">
                                Personal Dashboard
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bottom scripts (common) -->
    <script src="<?php echo site_url('js/gsap/main-gsap.js') ?>"></script>
    <script src="<?php echo site_url('js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') ?>"></script>
    <script src="<?php echo site_url('js/bootstrap.js') ?>"></script>
    <script src="<?php echo site_url('js/joinable.js') ?>"></script>
    <script src="<?php echo site_url('js/resizeable.js') ?>"></script>
    <script src="<?php echo site_url('js/neon-api.js') ?>"></script>
    <script src="<?php echo site_url('js/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo site_url('js/neon-login.js') ?>"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="<?php echo site_url('js/neon-custom.js') ?>"></script>
    <script src="<?php echo site_url('js/jquery.inputmask.bundle.min.js') ?>"></script>

    <!-- Demo Settings -->
    <!--<script src="<?php echo site_url('js/neon-demo.js') ?>"></script>-->

</body>
</html>