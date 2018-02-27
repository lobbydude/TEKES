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
?>

<?php
// Announcement Notification query Enable Start here
$get_data = array(
   
    "Status" => 1,
);
$this->db->where($get_data);
$q_announcement = $this->db->get('tbl_announcement');

// Announcement Notification query Disable/Enable start here
$get_data_year = array(
    "Status" => 1,
);
$this->db->where($get_data_year);
$q_announcement1 = $this->db->get('tbl_announcement');
?>
<!-- Suggestion box message fetch in DB start-->



<!-- View Popup window Upcoming Announcement Start here-->
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

    // Announcement Hide/show function Start here
    function announcement_current_year() {
        $('#current_year_announcement').css({"display": "none"});
        $('#current_month_announcement').css({"display": "block"});
    }
    function announcement_current_month() {
        $('#current_month_announcement').css({"display": "none"});
        $('#current_year_announcement').css({"display": "block"});
    }
    // Announcement Hide/show function End here
</script>
<!-- View Popup window Upcoming Announcement End here-->

<link href="<?php echo site_url('css/announcement/site.css') ?>" rel="stylesheet" type="text/css" />
<!--<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
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
                                                    <h3 style="background-color:#1f5069;color:#fff"><a href="<?php //echo site_url('App/exe.php') ?>" target="_blank" style="background-color:#1f5069;color:#fff" title="Titlelogy Inhouse">Titlelogy Inhouse</a></h3>
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
                                    <li><a href="#">Resignation</a><span class="badge badge-secondary chat-notifications-badge"></span></li>
                                    <li><a href="#">Leaves</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <li><a href="#">Confirmation</a><span class="badge badge-info"></span></li>
                                    <li><a href="#">Termination</a><span class="badge badge-secondary chat-notifications-badge"></span></li>
                                    <li><a href="#">Meetings</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <li><a href="#">&nbsp;&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <li><a href="#">&nbsp;&nbsp;</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                                                       
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
                                    <li><a href="#">Daily Attendance</a><span class="badge badge-secondary chat-notifications-badge"></span></li>
                                    <li><a href="#">Import Attendance</a><span class="badge badge-success chat-notifications-badge"></span></li>
                                    <li><a href="#">Monthly Attendance</a><span class="badge badge-info"></span></li>
                                    <li><a href="#">Muster Rolls</a><span class="badge badge-info"></span></li>
                                    <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                    <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                    <li><a href="#">&nbsp;</a><span class="badge badge-info"></span></li>
                                </ul> 
                            </div>

                        </div>
                    </div>                   

                </div>

                <div class="row">                  
                    <!-- Suggestion Box Notification Design Start Here-->

                    <!-- Suggestion Box Design Start here-->
                    


                    <!-- Calender Start here-->
                    <div class="col-md-6" id="emp_current_month_announcement">
                            <div class="sorted ui-sortable">
                                <div data-collapsed="0" class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-title" style="text-transform: uppercase;">
                                            ANNOUNCEMENT OF <?php echo date('F Y'); ?>  
                                        </div>
                                    </div>                                
                                    <div class="panel-body">
                                        <div class="col-sm-12">
                                            <ul class="current_month" id="current_month_scroll">
                                                <?php
                                                foreach ($q_announcement->result() as $row_announcement) {
                                                    $announcement_id = $row_announcement->A_Id;
                                                    $announcement_title = $row_announcement->Title;
                                                    $announcement_date1 = $row_announcement->Date;
                                                    $announcement_date = date("d-m-Y", strtotime($announcement_date1));
                                                    $announcement_message = $row_announcement->Message;
                                                    ?>
                                                    <div class="modal-body">
                                                        <a data-toggle='modal' href='#view_announcement' onclick="view_announcement(<?php echo $announcement_id; ?>)">
                                                            <li class="news-item">                                    

                                                                <h5 class="modal-title"><b><?php echo $announcement_date; ?> &nbsp;&nbsp; | &nbsp;&nbsp; <?php echo $announcement_title; ?></b></h5>
                                                                <p class="readmore"><?php echo $announcement_message; ?></p>                                                              
                                                            </li>
                                                        </a>                                           

                                                    </div>                                            
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
                    <!-- Calender End here-->
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    <script type="text/javascript">
                        $(function () {
                            $("#suggestion_box_scroll").bootstrapNews({
                                newsPerPage: 7,
                                autoplay: true,
                                pauseOnHover: true,
                                direction: 'up',
                                newsTickerInterval: 4000,
                                onToDo: function () {
                                }
                            });
                        });
                    </script>
                    <!-- Suggestion Box Design End here-->
                </div>

                <!-- View Suggestion box Form Start Here -->
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

                <!-- View Suggestion box Form END-->


                <!-- Suggestion box Design Start here-->
                <div class="modal fade" id="add_suggestion">
                    <div class="modal-dialog" style="width:55%">
                        <div class="modal-content">
                            <div class="modal-header info-bar">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h3 class="modal-title">New Suggestion Box</h3>
                            </div>
                            <form role="form" id="addsuggestion_form" name="addsuggestion_form" method="post" class="validate" enctype="multipart/form-data" >
                                <div class="modal-body">
                                    <!-- Add Suggestion box Validation Message Start Here -->
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div id="add_suggestion_server_error" class="alert alert-info" style="display:none;"></div>
                                            <div id="add_suggestion_success" class="alert alert-success" style="display:none;">suggestion box details added successfully.</div>
                                            <div id="add_suggestion_error" class="alert alert-danger" style="display:none;">Failed to add suggestion box details.</div>
                                        </div>
                                    </div>
                                    <!-- Add Suggestion box Validation Message End Here -->

                                    <!-- Add Suggestion box form Field Name start-->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="field-3" class="control-label">Enter Your Suggestion</label>                                        
                                                <textarea class="form-control" name="add_feedback" id="add_feedback" placeholder="Enter your Suggestion" data-validate="required" data-message-required="Please Enter Your Suggestion" ></textarea>
                                            </div>	
                                        </div>
                                    </div>                         

                                </div>
                                <!-- Add Suggestion box form Field Name End-->

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Suggestion box Design End here-->
                
                
                <!-- View Announcement Form Start Here -->
        <div class="modal fade custom-width" id="view_announcement">
            <div class="modal-dialog" style="width:60%">
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