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
        'Reporting_To' => $user_id,
        'Manager_read' => 'unread'
    );
    $this->db->where($leave_data1);
    $q_leave = $this->db->get('tbl_leaves');
    $leave_count = $q_leave->num_rows();
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

/* Termination Notification Start Here */
if ($user_role_id == 1) {
    $termination_data1 = array(
        'Reporting_To' => $user_id,
        'Manager_Read' => 'unread'
    );
    $this->db->where($termination_data1);
    $q_termination1 = $this->db->get('tbl_termination');
    $termination_count = $q_termination1->num_rows();
}

if ($user_role_id == 2 || $user_role_id == 6) {
    $termination_data2 = array(
        'HR_Read' => 'unread'
    );
    $this->db->where($termination_data2);
    $q_termination2 = $this->db->get('tbl_termination');
    $termination_count = $q_termination2->num_rows();
}
/* Termination Notification End Here */

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

/* Announcement Notification Start Here */
$this->db->where('Status', 1);
$q_announcement = $this->db->get('tbl_announcement');
$announcement_count = $q_announcement->num_rows();
/* Announcement Notification End Here */

/* Suggestion Notification Start Here */
if ($user_role_id == 2 || $user_role_id == 6) {
    $suggestion_data = array(
        'Status' => 1
    );
    $this->db->order_by('S_Id', 'desc');
    $this->db->where($suggestion_data);
    $q_suggestion = $this->db->get('tbl_suggestion');
} else {
    $emp_id = $this->session->userdata('username');
    $suggestion_data = array(
        'Emp_Id' => $emp_id,
        'Status' => 1
    );
    $this->db->order_by('S_Id', 'desc');
    $this->db->where($suggestion_data);
    $q_suggestion = $this->db->get('tbl_suggestion');
}
/* Suggestion Notification End Here */
?>

<script>
    $(document).ready(function () {
        $('#addsuggestion_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_feedback: $('#add_feedback').val()
            };
            $.ajax({
                url: "<?php echo site_url('Suggestion/add_suggestion') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "fail") {
                        $('#add_suggestion_error').show();
                    }
                    if (msg.trim() == "success") {
                        $('#add_suggestion_success').show();
                        location.reload();
                    }
                }
            });
        });
    });
</script>


<script>
    function view_suggestion(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Suggestion/Viewsuggestion') ?>",
            data: "S_Id=" + id,
            cache: false,
            success: function (html) {
                $("#viewsuggestion_form").html(html);
            }
        });
    }
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
                    <div class="col-sm-4">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    DRN APPS
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="tile-title tile-gray">
                                                <div class="icon">
                                                    <a href="<?php echo site_url('App/exe.php') ?>" target="_blank" title="Titlelogy Inhouse"><img src="images/drn.png" width="70" height="70" title="Titlelogy Inhouse"></a>
                                                </div>
                                                <div class="title center">
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="<?php //echo site_url('App/exe.php')       ?>" target="_blank" style="background-color:#1f5069;color:#fff" title="Titlelogy Inhouse">Titlelogy Inhouse</a></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="tile-title tile-gray">
                                                <div class="icon">
                                                    <a href="http://192.168.12.33/Taxplorer/" target="_blank" title="Taxplorer"><img src="images/taxplorer.png" width="70" height="70"></a>
                                                </div>
                                                <div class="title center tile-blue" >
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="http://192.168.12.33/Taxplorer/" target="_blank" style="background-color:#1f5069;color:#fff" title="Taxplorer">Taxplorer</a></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
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
                    if ($user_role_id == 1 || $user_role_id == 2 || $user_role_id == 6) {
                        ?>
                        <div class="col-sm-4">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        NOTIFICATION
                                    </div>
                                </div>                          

                                <div class="panel-body">                        
                                    <ul class="country-list">
                                        <li><a href="<?php echo site_url("Resignation/employee"); ?>"><i class="entypo-vcard"></i><b> Resignation </b></a><?php if ($resignation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $resignation_count; ?></span><?php } ?></li>
                                        <li><a href="<?php echo site_url("Leaves/employee"); ?>"><i class="entypo-sound"></i><b> Leaves </b></a><?php if ($leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $leave_count; ?></span><?php } ?></li>
                                        <li><a href="<?php echo site_url("Employee/Confirmation"); ?>"><i class="entypo-suitcase"></i><b> Confirmation </b></a><?php if ($confirmation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $confirmation_count; ?></span><?php } ?></li>
                                        <li><a href="<?php echo site_url("Termination"); ?>"><i class="entypo-block"></i><b> Termination </b></a><?php if ($termination_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $termination_count; ?></span><?php } ?></li>
                                        <li><a href="<?php echo site_url("Meetings"); ?>"><i class="entypo-calendar"></i><b> Meetings </b></a><?php if ($meeting_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $meeting_count; ?></span><?php } ?></li>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
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
</div>
<div class="row">
                        <div class="col-md-6" id="emp_current_month_announcement">
                            <div class="sorted ui-sortable">
                                <div data-collapsed="0" class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            SUGGESTION BOX
                                        </div>
                                        <div class="panel-options" style="margin-top: 6px">
                                            <button class="btn btn-white btn-icon icon-left" type="button" onclick="jQuery('#add_suggestion').modal('show', {backdrop: 'static'});">
                                                Add New
                                                <i class="entypo-plus-circled"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-sm-12">
                                            <ul class="current_month" id="suggestion_box_scroll">
                                                <?php
                                                foreach ($q_suggestion->result() as $row_suggestion) {
                                                    $suggestion_id = $row_suggestion->S_Id;
                                                    $feedback_message = $row_suggestion->Feedback;
                                                    $Emp_Id = $row_suggestion->Emp_Id;
                                                    $suggestion_date1 = $row_suggestion->Date;
                                                    $suggestion_date = date("d-m-Y", strtotime($suggestion_date1));

                                                    $this->db->where('Emp_Number', $Emp_Id);
                                                    $q = $this->db->get('tbl_employee');
                                                    foreach ($q->result() as $row) {
                                                        $firstname = $row->Emp_FirstName;
                                                        $lastname = $row->Emp_LastName;
                                                        $middlename = $row->Emp_MiddleName;
                                                    }

                                                    $get_empcode = array(
                                                        'employee_number' => $Emp_Id,
                                                        'Status' => 1
                                                    );
                                                    $this->db->where($get_empcode);
                                                    $q_empcode = $this->db->get('tbl_emp_code');
                                                    foreach ($q_empcode->result() as $row_empcode) {
                                                        $empcode = $row_empcode->employee_code;
                                                    }
                                                    ?>
                                                    <li class="news-item">
                                                        <table cellpadding="4">
                                                            <tr>
                                                                <td>
                                                                    <div class="modal-body">
                                                                        <a data-toggle='modal' href='#view_suggestion' onclick="view_suggestion(<?php echo $suggestion_id; ?>)">
                                                                            <h4 class="modal-title"><b><?php echo $suggestion_date . "  |  " . $firstname . " " . $lastname . " " . $middlename . "( " . $empcode . $Emp_Id . " )"; ?></h4>
                                                                            <p class="readmore"><b><?php echo $feedback_message; ?></p> 
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <?php
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
                                $("#suggestion_box_scroll").bootstrapNews({
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
                    <?php } ?>
                    <!-- Announcement Notification Design Start Here-->

                    <!-- Announcement Current Month Start here-->
                    <div class="col-md-6" id="current_month_div">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title" style="text-transform:uppercase">
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
                                                        <li class="news-item">
                                                            <table cellpadding="4">
                                                                <tr>
                                                                    <td>
                                                                        <div class="modal-body">
                                                                            <a data-toggle='modal' href='#view_announcement' onclick="view_announcement(<?php echo $announcement_id; ?>)">
                                                                                <h4 class="modal-title"><b><?php echo $announcement_date; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $announcement_title; ?></b></h4>
                                                                                <p class="readmore"><?php echo $announcement_message; ?></p>
                                                                            </a>
                                                                        </div>
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
                    <div class="col-md-6" id="current_year_div" style="display:none;">
                        <div class="sorted ui-sortable">
                            <div data-collapsed="0" class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title" style="text-transform:uppercase">
                                        Announcement of Year 2015 
                                    </div>
                                </div>                                
                                <div class="panel-body">
                                    <div class="col-sm-12">
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
                                                                        <div class="modal-body">
                                                                            <a data-toggle='modal' href='#view_announcement' onclick="view_announcement(<?php echo $announcement_id_current; ?>)">
                                                                                <h4 class="modal-title"><b><?php echo $announcement_date2_current; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $announcement_title_current; ?></b></h4>
                                                                                <p class="readmore"><?php echo $announcement_message_current; ?></p>  
                                                                            </a>
                                                                        </div>
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

                <!-- View Suggestion Start Here -->
                <div class="modal fade custom-width" id="view_suggestion">
                    <div class="modal-dialog" style="width:50%">
                        <div class="modal-content">
                            <div class="modal-header info-bar">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3 class="modal-title">View Suggestion</h3>
                            </div>                 
                            <form role="form" id="viewsuggestion_form" name="viewsuggestion_form" method="post" class="validate">

                            </form>   
                        </div>
                    </div>
                </div>

                <!-- View Suggestion End Here -->

                <!-- Add Suggestion Start Here-->
                <div class="modal fade" id="add_suggestion">
                    <div class="modal-dialog" style="width:55%">
                        <div class="modal-content">
                            <div class="modal-header info-bar">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3 class="modal-title">New Suggestion</h3>
                            </div>
                            <form role="form" id="addsuggestion_form" name="addsuggestion_form" method="post" class="validate" enctype="multipart/form-data" >
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="add_suggestion_server_error" class="alert alert-info" style="display:none;"></div>
                                            <div id="add_suggestion_success" class="alert alert-success" style="display:none;">suggestion box details added successfully.</div>
                                            <div id="add_suggestion_error" class="alert alert-danger" style="display:none;">Failed to add suggestion box details.</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="field-3" class="control-label">Enter Your Suggestion</label>                                        
                                                <textarea class="form-control" name="add_feedback" id="add_feedback" placeholder="Enter your Suggestion" data-validate="required" data-message-required="Please Enter Your Suggestion" ></textarea>
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
                <!-- Add Suggestion End Here-->