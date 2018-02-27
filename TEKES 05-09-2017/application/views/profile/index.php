<?php
$user_id = $this->session->userdata('username');
$user_role_id = $this->session->userdata('user_role');
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

/* Announcement Notification Start Here */
$this->db->where('Status', 1);
$q_announcement = $this->db->get('tbl_announcement');
$announcement_count = $q_announcement->num_rows();
/* Announcement Notification End Here */

/* Meetings Notification Start Here */
$meeting_data1 = array(
    'Emp_Id' => $user_id,
    'Emp_Read' => 'unread'
);
$this->db->where($meeting_data1);
$q_meeting = $this->db->get('tbl_meetings_to');
$meetings_count = $q_meeting->num_rows();
/* Meetings Notification End Here */
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
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
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
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="<?php //echo site_url('App/exe.php')                     ?>" target="_blank" style="background-color:#1f5069;color:#fff" title="Titlelogy Inhouse">Titlelogy Inhouse</a></h3>
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

                    <div class="col-sm-4">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    NOTIFICATION
                                </div>
                            </div>                          

                            <div class="panel-body">                        
                                <ul class="country-list">                                    
                                    <li><a href="<?php echo site_url("Leaves"); ?>"><i class="entypo-sound"></i><b> Leaves </b></a><?php if ($leave_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $leave_count; ?></span> <?php } ?></li>
                                    <li><a href="<?php echo site_url("Meetings/employee"); ?>"><i class="entypo-calendar"></i><b> Meetings </b></a><?php if ($meetings_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $meetings_count; ?></span> <?php } ?></li>
									<li><a href="<?php echo site_url("Resignation"); ?>"><i class="entypo-vcard"></i><b> Resignation </b></a><?php if ($resignation_count > 0) { ?><span class="badge badge-secondary chat-notifications-badge"><?php echo $resignation_count; ?></span> <?php } ?></li>
                                    <?php
                                    $app_data_april = array(
                                        'Employee_Id' => $user_id,
                                        'Year' => date('Y'),
                                        'Month' => 4,
                                        'Status' => 1
                                    );
                                    $this->db->where($app_data_april);
                                    $q_app_april = $this->db->get('tbl_appraisal');
                                    $app_count_april = $q_app_april->num_rows();

                                    $app_data_oct = array(
                                        'Employee_Id' => $user_id,
                                        'Year' => date('Y'),
                                        'Month' => 10,
                                        'Status' => 1
                                    );
                                    $this->db->where($app_data_oct);
                                    $q_app_oct = $this->db->get('tbl_appraisal');
                                    $app_count_oct = $q_app_oct->num_rows();
                                    if ($app_count_april > 0) {
                                        foreach ($q_app_april->result() as $row_app_april) {
                                            $Visible_From_Employee_april = $row_app_april->Visible_From_Employee;
                                            $Visible_To_Employee_april = $row_app_april->Visible_To_Employee;
                                        }
                                        $current_date_april = date('Y-m-d');
                                        if ($Visible_From_Employee_april <= $current_date_april || $current_date_april >= $Visible_To_Employee_april) {
                                            ?>
                                            <li><a href="<?php echo site_url("appraisal/frm/apr"); ?>"><i class="entypo-trophy"></i><b> Appraisal (April Cycle)</b></a><span class="badge badge-secondary chat-notifications-badge">1</span></li>
                                            <?php
                                        }
                                    } else if ($app_count_oct > 0) {
                                        foreach ($q_app_oct->result() as $row_app_oct) {
                                            $Visible_From_Employee_oct = $row_app_oct->Visible_From_Employee;
                                            $Visible_To_Employee_oct = $row_app_oct->Visible_To_Employee;
                                        }
                                        $current_date_oct = date('Y-m-d');
										if((strtotime($Visible_From_Employee_oct) <= strtotime($current_date_oct)) && (strtotime($current_date_oct) <= strtotime($Visible_To_Employee_oct))){
                                            ?>
                                            <li><a href="<?php echo site_url("appraisal/frm/oct"); ?>"><i class="entypo-trophy"></i><b><?php echo $Visible_To_Employee_oct;?> Appraisal (October Cycle)</b></a><span class="badge badge-secondary chat-notifications-badge">1</span></li>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <li><a href="#">&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <?php } ?>
                                    <li><a href="#">&nbsp;&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <li><a href="#">&nbsp;&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <li><a href="#">&nbsp;&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                </ul>
                            </div>                            
                        </div>
                    </div>

                    <!-- Announcement Current Month Start here-->
                    <div class="col-md-4" id="current_month_div">
                        <div data-collapsed="0" class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">Announcement of <?php echo date('F Y'); ?> </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="current_month_scroll">
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
//                                                    if (($announcement_date1 >= $current_date) && ( $last_day_current_month >= $announcement_date1 )) {
                                                    if (($announcement_date1 >= $current_date)) {
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
                            </div>
                            <div class="panel-footer"> </div>
                        </div>
                    </div>
                    <!-- Announcement Current Month End here-->
                </div>
                <script type="text/javascript">
                    $(function () {
                        $(".suggestion_box_scroll").bootstrapNews({
                            newsPerPage: 5,
                            autoplay: true,
                            pauseOnHover: true,
                            direction: 'up',
                            newsTickerInterval: 4000,
                            onToDo: function () {
                                //console.log(this);
                            }
                        });
                        $(".current_month_scroll").bootstrapNews({
                            newsPerPage: 3,
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

            <?php
            if ($user_role_id == 1) {
                $ninteenth = date('23-M-Y');
                $today = date('d-M-Y');
                if ($ninteenth == $today) {
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#attendance_update').modal('show', {backdrop: 'static'});
                        });
                    </script>
                    <?php
                }
            }
            ?>

            <div class="modal fade" id="attendance_update" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header info-bar">
                            <h3 class="modal-title">Attendance Alert</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="text-transform: none">Request you to share attendance and allowance input for the month of <b><?php echo date('F Y'); ?></b> to process the salary.</p>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>