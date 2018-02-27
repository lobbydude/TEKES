<?php
$emp_id = $this->session->userdata('username');
?>
<script>
    function meetings_status(id, status) {
        var formdata = {
            M_Id: id,
            Status: status
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Meetings/Statusmeeting') ?>",
            data: formdata,
            cache: false,
            success: function (msg) {
                if (msg == 'success') {
                    window.location.reload();
                }
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

                    </div>
                    <table class="table table-bordered datatable" id="emp_meeting_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Reporting To</th>
                                <th>Title</th>                                
                                <th>Start Date</th>
                                <th>Start Time</th>
                                <th>End Date</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Agenda</th>
                                <th>Status</th>
                                <th>Actions</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $meetings_to_data = array(
                                'Emp_Id' => $emp_id,
                                'Status' => 1
                            );
                            $this->db->where($meetings_to_data);
                            $q_meetings_to = $this->db->get('tbl_meetings_to');
                            $i = 1;
                            foreach ($q_meetings_to->result() as $row_meetings_to) {
                                $Mee_Id = $row_meetings_to->M_Id;
                                $Meetings_Id = $row_meetings_to->Meeting_Id;
                                $Meeting_Status = $row_meetings_to->Meeting_Status;

                                $meetings_data = array(
                                    'M_Id' => $Meetings_Id,
                                    'Status' => 1
                                );
                                $this->db->where($meetings_data);
                                $q_meetings = $this->db->get('tbl_meetings');
                                foreach ($q_meetings->result() as $row_meetings) {
                                    $Title = $row_meetings->Title;
                                    $Start_Date1 = $row_meetings->Start_Date;
                                    $Start_Date = date("d-m-Y", strtotime($Start_Date1));
                                    $Start_Time = $row_meetings->Start_Time;
                                    $End_Date1 = $row_meetings->End_Date;
                                    $End_Date = date("d-m-Y", strtotime($End_Date1));
                                    $End_Time = $row_meetings->End_Time;
                                    $Location = $row_meetings->Location;
                                    $Message = $row_meetings->Message;


                                    $from_emp_id = $row_meetings->M_From;
                                    $this->db->where('Emp_Number', $from_emp_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $firstname = $row_employee->Emp_FirstName;
                                        $lastname = $row_employee->Emp_LastName;
                                        $middlename = $row_employee->Emp_MiddleName;
                                    }

                                    $this->db->where('employee_number', $from_emp_id);
                                    $q_empcode = $this->db->get('tbl_emp_code');
                                    foreach ($q_empcode->Result() as $row_empcode) {
                                        $emp_code = $row_empcode->employee_code;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $firstname . $lastname . $middlename . "(" . $emp_code . $from_emp_id . ")"; ?></td>
                                        <td><?php echo $Title; ?></td>
                                        <td><?php echo $Start_Date; ?></td>
                                        <td><?php echo $Start_Time; ?></td>
                                        <td><?php echo $End_Date; ?></td>
                                        <td><?php echo $End_Time; ?></td>
                                        <td><?php echo $Location; ?></td>
                                        <td><?php echo $Message; ?></td>   
                                        <td><?php echo $Meeting_Status; ?></td>
                                        <td>                                      
                                            <a href='#' class="btn btn-default btn-sm btn-icon icon-left" onclick="meetings_status(<?php echo $Mee_Id; ?>, 'Accepted')">
                                                <i class="entypo-pencil"></i>
                                                Accept
                                            </a>                                            
                                            <a href='#' class="btn btn-danger btn-sm btn-icon icon-left" onclick="meetings_status(<?php echo $Mee_Id; ?>, 'Declined')">
                                                <i class="entypo-cancel"></i>
                                                Decline
                                            </a>                                           
                                        </td>                                      
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>                         
                        </tbody>                 
                    </table> 
                </div>
            </div>
        </section>

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
                tableContainer = $("#emp_meeting_table");
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