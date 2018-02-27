<script src="<?php echo site_url('js/bootstrap/bootstrap-multiselect.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#add_To').multiselect({
            includeSelectAllOption: true
        });
    });
</script>
<style>
    .multiselect-container.dropdown-menu a .checkbox input[type="checkbox"]{
        opacity: 1;
    }
    .multiselect-container.dropdown-menu{
        height: 200px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>
<script>
    $(document).ready(function () {
        $('#addmeeting_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_Title: $('#add_Title').val(),
                add_Start_Date: $('#add_Start_Date').val(),
                add_Start_Time: $('#add_Start_Time').val(),
                add_End_Date: $('#add_End_Date').val(),
                add_End_Time: $('#add_End_Time').val(),
                add_To: $('#add_To').val(),
                add_Location: $('#add_Location').val(),
                add_Message: $('#add_Message').val()
            };
            $.ajax({
                url: "<?php echo site_url('Meetings/add_meeting') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg == "fail") {
                        $('#add_meeting_error').show();
                    }
                    if (msg == "success") {
                        $('#add_meeting_success').show();
                        location.reload();
                    }
                }
            });
        });
    });
</script>

<script>

    function view_meeting(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Meetings/Viewmeeting') ?>",
            data: "M_Id=" + id,
            cache: false,
            success: function (html) {
                $("#view_meeting_data").html(html);

            }
        });
    }
    function edit_meeting(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Meetings/Editmeeting') ?>",
            data: "M_Id=" + id,
            cache: false,
            success: function (html) {
                $("#editmeeting_form").html(html);

            }
        });
    }
    function delete_meeting(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Meetings/Deletemeeting') ?>",
            data: "M_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletemeeting_form").html(html);

            }
        });
    }
    function cancel_meeting(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Meetings/Cancelmeeting') ?>",
            data: "M_Id=" + id,
            cache: false,
            success: function (html) {
                $("#cancelmeeting_form").html(html);

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
                            <h2>Meetings</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_meeting').modal('show', {backdrop: 'static'});">
                                New Meeting
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Meetings Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="meeting_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>                                
                                <th>Start Date </th>
                                <th>Start Time</th>
                                <th>End Date</th>
                                <th>End Time</th>
                                <th>Forward To</th>
                                <th>Location</th>
                                <th>Agenda</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $current_emp_no = $this->session->userdata('username');
                            $this->db->order_by('M_Id', 'desc');
                            $meetings_data = array(
                                "M_From" => $current_emp_no,
                                "Status" => 1
                            );
                            $this->db->where($meetings_data);
                            $q = $this->db->get('tbl_meetings');
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $M_Id = $row->M_Id;
                                $Title = $row->Title;
                                $Start_Date1 = $row->Start_Date;
                                $Start_Date = date("d-m-Y", strtotime($Start_Date1));
                                $Start_Time = $row->Start_Time;
                                $End_Date1 = $row->End_Date;
                                $End_Date = date("d-m-Y", strtotime($End_Date1));
                                $End_Time = $row->End_Time;
                                $Location = $row->Location;
                                $Message = $row->Message;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $Title; ?></td>
                                    <td><?php echo $Start_Date; ?></td>
                                    <td><?php echo $Start_Time; ?></td>
                                    <td><?php echo $End_Date; ?></td>
                                    <td><?php echo $End_Time; ?></td>
                                    <?php
                                    $get_meetings_to = array(
                                        "Meeting_Id" => $M_Id,
                                        "Status" => 1
                                    );
                                    $this->db->where($get_meetings_to);
                                    $q_meetings_to = $this->db->get('tbl_meetings_to');
                                    ?>
                                    <td>
                                        <ul>
                                            <?php
                                            foreach ($q_meetings_to->result() as $row_meetings_to) {
                                                $Emp_Id = $row_meetings_to->Emp_Id;

												$update_meet_data = array(
                                            'From_Read' => 'read'
                                        );
                                        $this->db->where('M_From', $current_emp_no);
                                        $this->db->update('tbl_meetings_to', $update_meet_data);
										
                                                $get_employee = array(
                                                    "Emp_Number" => $Emp_Id,
                                                    "Status" => 1
                                                );
                                                $this->db->where($get_employee);
                                                $q_employee = $this->db->get('tbl_employee');
                                                foreach ($q_employee->result() as $row_employee) {
                                                    $Emp_FirstName = $row_employee->Emp_FirstName;
                                                    $Emp_Middlename = $row_employee->Emp_MiddleName;
                                                    $Emp_LastName = $row_employee->Emp_LastName;
                                                    $get_employee_code = array(
                                                        "employee_number" => $Emp_Id,
                                                        "Status" => 1
                                                    );
                                                    $this->db->where($get_employee_code);
                                                    $q_employee_code = $this->db->get('tbl_emp_code');
                                                    foreach ($q_employee_code->result() as $row_employee_code) {
                                                        $employee_code = $row_employee_code->employee_code;
                                                    }
                                                    echo "<li>" . $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $employee_code . $Emp_Id . ")</li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td><?php echo $Location; ?></td>
                                    <td><?php echo $Message; ?></td>                                    
                                    <td>
                                        <ul class="nav navbar-right pull-right">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle btn-primary" data-toggle="dropdown">Actions<b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a data-toggle='modal' href='#view_meeting' onclick="view_meeting(<?php echo $M_Id; ?>)">
                                                            Status
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-toggle='modal' href='#edit_meeting' onclick="edit_meeting(<?php echo $M_Id; ?>)">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a data-toggle='modal' href='#delete_meeting' onclick="delete_meeting(<?php echo $M_Id; ?>)">
                                                            Delete
                                                        </a>
                                                    </li>
                                                    <?php if (date("Y-m-d") <= $Start_Date1) { ?>
                                                        <li>
                                                            <a data-toggle='modal' href='#cancel_meeting' onclick="cancel_meeting(<?php echo $M_Id; ?>)">
                                                                Cancel
                                                            </a>

                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>                         
                        </tbody>                 
                    </table> 
                </div>
            </div>
        </section>

        <!-- Add New Meetings Start Here -->
        <div class="modal fade" id="add_meeting">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Meeting</h3>
                    </div>
                    <form role="form" id="addmeeting_form" name="addmeeting_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_meeting_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_meeting_success" class="alert alert-success" style="display:none;">Meeting details added successfully.</div>
                                    <div id="add_meeting_error" class="alert alert-danger" style="display:none;">Failed to add Meeting details.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Title</label>
                                        <input type="text" name="add_Title" id="add_Title" class="form-control" placeholder="Meeting Title" data-validate="required" data-message-required="Please enter Title">
                                    </div> 	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">Start Date & Time</label>
                                        <div class="input-group">
                                            <div class="date-and-time">
                                                <input type="text" name="add_Start_Date" id="add_Start_Date" placeholder="Start Date" class="form-control datepicker" data-format="dd M yyyy" data-validate="required" data-message-required="Start date">                                               
                                                <input type="text" name="add_Start_Time" id="add_Start_Time" placeholder="Start Time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-default-time="" data-show-meridian="true" data-minute-step="5" data-second-step="5" data-validate="required" data-message-required="Start Time" />                                                
                                            </div>                                                
                                        </div>                                     
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-2" class="control-label">End Date & Time</label>
                                        <div class="input-group">
                                            <div class="date-and-time">
                                                <input type="text" name="add_End_Date" id="add_End_Date" placeholder="End Date" class="form-control datepicker" data-format="dd M yyyy" data-validate="required" data-message-required="End date">
                                                <input type="text" name="add_End_Time" id="add_End_Time" class="form-control timepicker" data-template="dropdown" data-show-seconds="true" data-default-time="" placeholder="End Time" data-show-meridian="true" data-minute-step="5" data-second-step="5" data-validate="required" data-message-required="End Time" />
                                            </div>
                                        </div>                                     
                                    </div>	
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Forward To</label>
                                        <select name="add_To[]" id="add_To" data-validate="required" data-message-required="Forward To" multiple>
                                            <?php
                                            $this->db->where('Status', 1);
                                            $q_employee = $this->db->get('tbl_employee');
                                            foreach ($q_employee->result() as $row_employee) {
                                                $Emp_Number = $row_employee->Emp_Number;
                                                $Emp_FirstName = $row_employee->Emp_FirstName;
                                                $Emp_Middlename = $row_employee->Emp_MiddleName;
                                                $Emp_LastName = $row_employee->Emp_LastName;

                                                $get_empl_code = array(
                                                    "employee_number" => $Emp_Number,
                                                    "Status" => 1
                                                );
                                                $this->db->where($get_empl_code);
                                                $q_emp_code = $this->db->get('tbl_emp_code');
                                                foreach ($q_emp_code->result() as $row_emp_code) {
                                                    $emp_code = $row_emp_code->employee_code;
                                                }
                                                ?>
                                                <option value="<?php echo $Emp_Number; ?>"><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename . "(" . $emp_code . $Emp_Number . ")" ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                         
                                    </div>	
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-1" class="control-label">Location</label>
                                        <input type="text" name="add_Location" id="add_Location" class="form-control" placeholder="Meeting Location" data-validate="required" data-message-required="Please enter Location">
                                    </div>
                                </div>                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Agenda</label>                                        
                                        <textarea class="form-control" name="add_Message" id="add_Message" placeholder="Enter Message" data-validate="required" data-message-required="Please enter Agenda" ></textarea>
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
        <!-- Add New Meetings End Here -->

        <!-- Edit Meeting form Start Here -->
        <div class="modal fade" id="edit_meeting">
            <div class="modal-dialog" style="width:60%;">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Meeting</h3>
                    </div>
                    <form role="form" id="editmeeting_form" name="editmeeting_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Meeting form End Here -->

        <!-- Delete Meeting Start Here -->
        <div class="modal fade" id="delete_meeting">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Meeting</h3>
                    </div>
                    <form role="form" id="deletemeeting_form" name="deletemeeting_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Meeting  End Here -->

        <div class="modal fade" id="view_meeting">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Meeting</h3>
                    </div>
                    <div class="modal-body" id="view_meeting_data">    

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;
            jQuery(document).ready(function ($)
            {
                tableContainer = $("#meeting_table");
                tableContainer.dataTable({
                    "sPaginationType": "bootstrap",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "bStateSave": true,
                    bAutoWidth: false,
                    fnPreDrawCallback: function () {
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