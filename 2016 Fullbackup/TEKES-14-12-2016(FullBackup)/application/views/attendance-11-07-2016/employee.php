<?php
$emp_no = $this->session->userdata('username');

$data_select = array(
    'Emp_Id' => $emp_no,
    'Status' => 1
);
$this->db->order_by('Login_Date','desc');
$this->db->where($data_select);
$q = $this->db->get('tbl_attendance');
?>
<script>
    function exit_attendance(attendance_id) {
        var formdata = {
            attendance_id: attendance_id
        };
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Attendance/Exitattendance') ?>",
            data: formdata,
            cache: false,
            success: function (msg) {
                if (msg == "success") {
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
                            <h2>Attendance</h2>
                        </div>
                    </div>

                    <!-- Attendance Table Format Start Here -->

                    <table class="table table-bordered datatable" id="attendance_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <!--<th>Shift</th>-->
                                <th>Login Date</th>
                                <th>Login Time</th>
                                <th>Logout Date</th>
                                <th>Logout Time</th>
                                <th>Total Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $A_Id = $row->A_Id;
                                $Login_Date1 = $row->Login_Date;
                                $Login_Date = date("d-m-Y", strtotime($Login_Date1));
                                $Login_Time = $row->Login_Time;

                                $Logout_Date1 = $row->Logout_Date;
                                if ($Logout_Date1 == "0000-00-00") {
                                    $Logout_Date = "";
                                    $Logout_Time = "";
                                } else {
                                    $Logout_Date = date("d-m-Y", strtotime($Logout_Date1));
                                    $Logout_Time = $row->Logout_Time;
                                }
                                  $shift_name = $row->Shift_Name;
                                  $h1 = strtotime($Login_Time);
                                  $h2 = strtotime($Logout_Time);
                                  $seconds = $h2 - $h1;
                                  $total_hours = gmdate("H:i:s", $seconds);
										
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                     <!--<td><?php// echo $shift_name; ?></td>-->
                                    <td><?php echo $Login_Date ?></td>
                                    <td><?php echo $Login_Time; ?></td>
                                    <td><?php
                                        if ($Logout_Date1 != "0000-00-00") {
                                            echo $Logout_Date;
                                        } else {
                                            $login_date_time = $Login_Date1 . $Login_Time;
                                            $twelehour = date("Y-m-d H:i:s", strtotime($login_date_time . " +14 hours"));
											
                                            if (date("Y-m-d H:i:s") < $twelehour) {
                                                ?>
                                                <a class="btn btn-danger btn-sm btn-icon icon-left" onclick="exit_attendance(<?php echo $A_Id; ?>)">
                                                    <i class="entypo-logout"></i>
                                                    Exit
                                                </a>
                                            <?php }
                                        } ?></td>
                                    <td><?php echo $Logout_Time; ?></td>
                                   <td>
                                        <?php
                                        if ($Logout_Date1 != "0000-00-00") {
                                            echo $total_hours;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Attendance Table Format End Here -->
                </div>
            </div>
        </section>


        <!-- Table Script -->
        <script type="text/javascript">
            var responsiveHelper;
            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };
            var tableContainer;

            jQuery(document).ready(function ($)
            {
                tableContainer = $("#attendance_table");

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

