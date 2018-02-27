<?php
$user_id = $this->session->userdata('username');
$user_role_id = $this->session->userdata('user_role');

/* Resignation Notification Start Here */
if ($user_role_id == 1) {
    $res_data1 = array(
        'Reporting_To' => $user_id,
        'Manager_read' => 'unread'
    );
    $this->db->where($res_data1);
    $q_resignation = $this->db->get('tbl_resignation');
    $resignation_count = $q_resignation->num_rows();
}
if ($user_role_id == 2 || $user_role_id == 6) {
    $res_data2 = array(
        'Hr_read' => 'unread'
    );
    $this->db->where($res_data2);
    $q_resignation = $this->db->get('tbl_resignation');
    $resignation_count = $q_resignation->num_rows();
}

/* Resignation Notification End Here */

/* Leave Notification Start Here */
if ($user_role_id == 1) {
    $leave_data1 = array(
        'Status' => 1,
        'Manager_read' => 'unread'
    );
    $this->db->order_by('L_Id', 'desc');
    $this->db->where($leave_data1);
    $q_leave = $this->db->get('tbl_leaves');
    $leave_count = 0;
    foreach ($q_leave->Result() as $row_leave) {
        $Leave_Id = $row_leave->L_Id;
        $employee_id = $row_leave->Employee_Id;
        $this->db->order_by('Career_Id', 'asc');
        $this->db->where('Employee_Id', $employee_id);
        $this->db->limit(1);
        $q_career = $this->db->get('tbl_employee_career');
        foreach ($q_career->result() as $row_career) {
            $emp_report_to_id = $row_career->Reporting_To;
        }

        if ($user_id == $emp_report_to_id) {
            $leave_count = $leave_count + 1;
        }
    }
}
if ($user_role_id == 2 || $user_role_id == 6) {
    $leave_data2 = array(
        'Hr_read' => 'unread'
    );
    $this->db->where($leave_data2);
    $q_leave = $this->db->get('tbl_leaves');
    $leave_count = $q_leave->num_rows();
}
/* Leave Notification End Here */


/* Comp Off Notification Start Here */
if ($user_role_id == 1) {
    $comp_off_leave_data1 = array(
        'Type' => 'Comp Off',
        'Status' => 1,
        'Manager_read' => 'unread'
    );
    $this->db->order_by('A_M_Id', 'desc');
    $this->db->where($comp_off_leave_data1);
    $q_comp_off_leave = $this->db->get('tbl_attendance_mark');
    $comp_off_leave_count = 0;
    foreach ($q_comp_off_leave->Result() as $row_comp_off_leave) {
        $comp_off_Leave_Id = $row_comp_off_leave->A_M_Id;
        $comp_off_employee_id = $row_comp_off_leave->Emp_Id;
        $this->db->order_by('Career_Id', 'asc');
        $this->db->where('Employee_Id', $comp_off_employee_id);
        $this->db->limit(1);
        $q_comp_off_career = $this->db->get('tbl_employee_career');
        foreach ($q_comp_off_career->result() as $row_comp_off_career) {
            $comp_off_emp_report_to_id = $row_comp_off_career->Reporting_To;
        }

        if ($user_id == $comp_off_emp_report_to_id) {
            $comp_off_leave_count = $comp_off_leave_count + 1;
        }
    }
}
if ($user_role_id == 2 || $user_role_id == 6) {
    $comp_off_leave_data2 = array(
        'Hr_read' => 'unread'
    );
    $this->db->where($comp_off_leave_data2);
    $q_comp_off_leave = $this->db->get('tbl_attendance_mark');
    $comp_off_leave_count = $q_comp_off_leave->num_rows();
}
/* Comp Off Notification End Here */

/* Meetings Notification Start Here */
if ($user_role_id == 1 || $user_role_id == 2 || $user_role_id == 6) {
    $meeting_data1 = array(
        'M_From' => $user_id,
        'From_Read' => 'unread'
    );
    $this->db->where($meeting_data1);
    $q_meeting = $this->db->get('tbl_meetings_to');
    $meeting_count = $q_meeting->num_rows();
}
/* Meetings Notification End Here */

/* Confirmation Notification Start Here */
if ($user_role_id == 1 || $user_role_id == 2 || $user_role_id == 6) {
    $current_date = date('Y-m-d');
    $data_confirmation = array(
        'Emp_Confirmationdate' => $current_date,
        'Status' => 1
    );
    $this->db->where($data_confirmation);
    $q_confirmation = $this->db->get('tbl_employee');
    $confirmation_count = $q_confirmation->num_rows();
}
/* Confirmation Notification End Here */

/* Suggestion Notification Start Here */
if ($user_role_id == 2 || $user_role_id == 6) {
    $suggestion_data = array(
        'HR_Read' => 'unread',
        'Status' => 1
    );
    $this->db->where($suggestion_data);
    $q_suggestion = $this->db->get('tbl_suggestion');
    $suggestion_count = $q_suggestion->num_rows();
}
/* Suggestion Notification End Here */

/* Announcement Notification Start Here */
$this->db->where('Status', 1);
$q_announcement = $this->db->get('tbl_announcement');
$announcement_count = $q_announcement->num_rows();
/* Announcement Notification End Here */
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
    function hide_current_year() {
        $('#current_year_div').css({"display": "none"});
        $('#current_month_div').css({"display": "block"});
    }
    function hide_current_month() {
        $('#current_month_div').css({"display": "none"});
        $('#current_year_div').css({"display": "block"});
    }
</script>
<link href="<?php echo site_url('css/announcement/site.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo site_url('js/announcement/jquery.bootstrap.newsbox.min.js') ?>" type="text/javascript"></script>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    DRN APPS
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6" style="padding-left:0px;padding-right:0px">
                                            <div class="tile-title tile-gray">
                                                <div class="icon">
                                                    <a href="<?php echo site_url('App/exe.php') ?>" target="_blank" title="Titlelogy Inhouse"><img src="images/drn.png" width="70" height="70" title="Titlelogy Inhouse"></a>
                                                </div>
                                                <div class="title center">
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="<?php //echo site_url('App/exe.php')                           ?>" target="_blank" style="background-color:#1f5069;color:#fff" title="Titlelogy Inhouse">Titlelogy Inhouse</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-right:0px"> 
                                            <div class="tile-title tile-gray">
                                                <div class="icon">
                                                    <a href="http://192.168.12.33/tagatick/" target="_blank" title="Tagatick"><img src="images/tagatick.png" width="70" height="70"></a>
                                                </div>
                                                <div class="title center">
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="http://192.168.12.33/tagatick/" target="_blank" style="background-color:#1f5069;color:#fff" title="Tagatick">Tagatick</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6" style="padding-left:0px;padding-right:0px">
                                            <div class="tile-title tile-gray">
                                                <div class="icon">
                                                    <a href="http://192.168.12.33/Taxplorer/" target="_blank" title="Taxplorer"><img src="images/taxplorer.png" width="70" height="70"></a>
                                                </div>
                                                <div class="title center tile-blue" >
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="http://192.168.12.33/Taxplorer/" target="_blank" style="background-color:#1f5069;color:#fff" title="Taxplorer">Taxplorer</a></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6" style="padding-right:0px">
                                            <div class="tile-title tile-gray">
                                                <div class="icon">
                                                    <a href="http://www.titlelogy.com" target="_blank" title="Titlelogy"><img src="images/titlelogy.png" width="70" height="70"  title="Titlelogy"></a>
                                                </div>
                                                <div class="title center">
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="http://www.titlelogy.com" target="_blank" style="background-color:#1f5069;color:#fff" title="Titlelogy">Titlelogy</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($user_role_id == 1 || $user_role_id == 2 || $user_role_id == 6 ) {
                        ?>
                        <div class="col-sm-3">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        NOTIFICATION
                                    </div>
                                </div>                          

                                <div class="panel-body">  
                                    <?php
                                    if ($user_role_id == 2 || $user_role_id == 6) {
                                        ?>
                                        <ul class="country-list">                                            
                                            <li><a href="<?php echo site_url("Leaves/employee"); ?>"><i class="entypo-sound"></i><b> Leaves </b></a><?php if ($leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $leave_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Leaves/compoff"); ?>"><i class="entypo-bell"></i><b> Comp Off </b></a><?php if ($comp_off_leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $comp_off_leave_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Employee/Confirmation"); ?>"><i class="entypo-suitcase"></i><b> Confirmation </b></a><?php if ($confirmation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $confirmation_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Meetings"); ?>"><i class="entypo-calendar"></i><b> Meetings </b></a><?php if ($meeting_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $meeting_count; ?></span><?php } ?></li>
											<li><a href="<?php echo site_url("Resignation/employee"); ?>"><i class="entypo-vcard"></i><b> Resignation </b></a><?php if ($resignation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $resignation_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Suggestion/Employee"); ?>"><i class="entypo-shareable"></i><b> Suggestion </b></a><?php if ($suggestion_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $suggestion_count; ?></span><?php } ?></li>
                                            <?php
                                            $current_month = date('m');
                                            if ($current_month == 3 || $current_month == 4 || $current_month == 5 || $current_month == 6) {
                                                ?>
                                                <li><a href="<?php echo site_url("appraisal/april"); ?>"><i class="entypo-trophy"></i><b> Appraisal (April Cycle)</b></a><span class="badge badge-secondary chat-notifications-badge">1</span></li>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($current_month == 9 || $current_month == 10 || $current_month == 11) {
                                                ?>
                                                <li><a href="<?php echo site_url("appraisal/october"); ?>"><i class="entypo-trophy"></i><b> Appraisal (October Cycle)</b></a><span class="badge badge-secondary chat-notifications-badge">1</span></li>
                                                <?php
                                            }
                                            ?>
                                                
                                        </ul>
                                    <?php } ?>
                                    <?php
                                    if ($user_role_id == 1) {
                                        ?>
                                        <ul class="country-list">
                                            <li><a href="<?php echo site_url("Resignation/employee"); ?>"><i class="entypo-vcard"></i><b> Resignation </b></a><?php if ($resignation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $resignation_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Leaves/employee"); ?>"><i class="entypo-sound"></i><b> Leaves </b></a><?php if ($leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $leave_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Leaves/compoff"); ?>"><i class="entypo-bell"></i><b> Comp Off </b></a><?php if ($comp_off_leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $comp_off_leave_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Employee/Confirmation"); ?>"><i class="entypo-suitcase"></i><b> Confirmation </b></a><?php if ($confirmation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $confirmation_count; ?></span><?php } ?></li>
                                            <li><a href="<?php echo site_url("Meetings"); ?>"><i class="entypo-calendar"></i><b> Meetings </b></a><?php if ($meeting_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $meeting_count; ?></span><?php } ?></li>
                                            <?php
                                            $current_month = date('m');
                                            if ($current_month == 3 || $current_month == 4 || $current_month == 5 || $current_month == 6) {
                                                ?>
                                                <li><a href="<?php echo site_url("appraisal/april"); ?>"><i class="entypo-trophy"></i><b> Appraisal (April Cycle)</b></a><span class="badge badge-secondary chat-notifications-badge">1</span></li>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($current_month == 9 || $current_month == 10 || $current_month == 11) {
                                                ?>
                                                <li><a href="<?php echo site_url("appraisal/october"); ?>"><i class="entypo-trophy"></i><b> Appraisal (October Cycle)</b></a><span class="badge badge-secondary chat-notifications-badge">1</span></li>
                                                <?php
                                            }
                                            ?>											
                                            <li><a href="<?php echo site_url("appraisal/permission"); ?>"><i class="entypo-upload"></i><b> Appraisal Manager Upload File</b></a></li>                                                                                            									
                                            <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>											
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    if ($user_role_id == 1 || $user_role_id == 2 || $user_role_id == 6 || $user_role_id == 7) {
                        ?>
                        <div class="col-sm-3">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        ATTENDANCE
                                    </div>
                                </div>                          
                                <div class="panel-body">                                
                                    <ul class="country-list">                                    
                                        <li><a href="<?php echo site_url('Attendance') ?>"><i class = "entypo-folder"></i><b> Daily Movements </b></a><span class="badge badge-secondary chat-notifications-badge"></span></li>
                                        <li><a href="<?php echo site_url('Attendance/Monthly') ?>"><i  class="entypo-archive"></i><b> Monthly Movements </b></a><span class="badge badge-info"></span></li>
                                        <li><a href="<?php echo site_url('Attendance/MonthTimesheet') ?>"><i  class="entypo-network"></i><b> Muster Rolls </b></a><span class="badge badge-info"></span></li>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                    </ul> 
                                </div>
                            </div>
                        </div>    
                    <?php } ?>
                    <!-- Announcement Notification Design Start Here-->

                    <!-- Announcement Current Month Start here-->
                    <div class="col-md-3" id="current_month_div">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title" style="text-transform:uppercase">
                                        Announcement of <?php echo date('F Y'); ?>  
                                    </div>
                                </div>                                
                                <div class="panel-body">
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
                                                if (($announcement_date1 >= $current_date) && ( $last_day_current_month >= $announcement_date1 )) {
                                                    ?>
                                                    <li class="news-item">
                                                        <table cellpadding="4">
                                                            <tr>
                                                                <td>
                                                                    <a data-toggle='modal' href='#view_announcement' onclick="view_announcement(<?php echo $announcement_id; ?>)">
                                                                        <h4 class="modal-title"><b><?php echo $announcement_date; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $announcement_title; ?></b></h4>
                                                                        <p class="readmore"><?php echo $announcement_message; ?></p>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            echo "No results found";
                                        }
                                        ?>
                                    </ul>
                                </div>  
                                <?php if ($user_role_id == 2 || $user_role_id == 6) {
                                    ?>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary" type="button" onclick="hide_current_month()"><?php echo date("Y"); ?></button>
                                    </div>
                                <?php } ?>
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

                    <!-- Announcement Current Year Start here-->
                    <div class="col-md-3" id="current_year_div" style="display:none;">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title" style="text-transform:uppercase">
                                        Announcement of Year 2016 
                                    </div>
                                </div>                                
                                <div class="panel-body">
                                    <ul class="current_month" id="current_year_scroll">
                                        <?php
                                        if ($announcement_count > 0) {
                                            foreach ($q_announcement->result() as $row_announcement_current) {
                                                $announcement_id_current = $row_announcement_current->A_Id;
                                                $announcement_title_current = $row_announcement_current->Title;
                                                $announcement_date_current = $row_announcement_current->Date;
                                                $announcement_date2_current = date("d-m-Y", strtotime($announcement_date_current));
                                                $announcement_message_current = $row_announcement_current->Message;
                                                $announcement_year_current = date("Y", strtotime($announcement_date_current));
                                                $current_year = date("Y");
                                                $last_day_current_month = date('Y-m-t');
                                                if ($current_year == $announcement_year_current) {
                                                    ?>
                                                    <li class="news-item">
                                                        <table cellpadding="4">
                                                            <tr>
                                                                <td>
                                                                    <a data-toggle='modal' href='#view_announcement' onclick="view_announcement(<?php echo $announcement_id_current; ?>)">
                                                                        <h4 class="modal-title"><b><?php echo $announcement_date2_current; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $announcement_title_current; ?></b></h4>
                                                                        <p class="readmore"><?php echo $announcement_message_current; ?></p>  
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            echo "No results found";
                                        }
                                        ?>
                                    </ul>
                                </div>                              

                                <div class="panel-footer">
                                    <button data-dismiss="modal" class="btn btn-primary" type="button" onclick="hide_current_year()"><?php echo date('F Y'); ?></button>
                                </div>
                            </div>                        
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(function () {
                            $("#current_year_scroll").bootstrapNews({
                                newsPerPage: 5, autoplay: true,
                                pauseOnHover: true,
                                direction: 'up',
                                newsTickerInterval: 4000,
                                onToDo: function () {
                                }
                            });
                        });
                    </script>
                </div>

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