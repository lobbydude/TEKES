<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');
if ($user_role == 2) {
    $update_data = array(
        'Hr_read' => 'read'
    );
    $this->db->update('tbl_attendance_mark', $update_data);
}
?>

<script>
    function reply_compoffleaves(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/ReplyCompOffLeave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                $("#replycompoffleave_form").html(html);
            }
        });
    }
      function cancel_compoffleave(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Leaves/CancelCompOffLeave') ?>",
            data: "leave_id=" + id,
            cache: false,
            success: function (html) {
                $("#cancelcompoffleave_form").html(html);
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
                            <h2>Comp Off Leaves</h2>
                        </div>
                    </div>

                    <!-- Leave Table Format Start Here -->

                    <table class="table table-bordered datatable" id="emp_compoffleave_table">
                        <thead>
                            <tr class="replace-inputs">
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if ($user_role == 2 || $user_role == 6) { ?>
                                    <th></th>
                                <?php } ?>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <?php if ($user_role == 2) { ?>
                                    <th>Reporting Manager</th>
                                <?php } ?>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Apply Date</th>                                
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th style="width:201px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($user_role == 2 || $user_role == 6) {
                                $this->db->order_by('A_M_Id', 'desc');
                                $get_data = array(
                                    'Type' => 'Comp Off',
                                    'Status' => 1
                                );
                                $this->db->where($get_data);
                                $q = $this->db->get('tbl_attendance_mark');
                                $count = $q->num_rows();
                                if ($count > 0) {
                                    foreach ($q->Result() as $row) {
                                        $Leave_Id = $row->A_M_Id;
                                        $employee_id = $row->Emp_Id;
                                        $this->db->where('employee_number', $employee_id);
                                        $q_code = $this->db->get('tbl_emp_code');
                                        foreach ($q_code->result() as $row_code) {
                                            $emp_code = $row_code->employee_code;
                                        }

                                        $get_empdata = array(
                                            'Emp_Number' => $employee_id,
                                            'Status' => 1
                                        );

                                        $this->db->where($get_empdata);
                                        $q_employee = $this->db->get('tbl_employee');
                                        foreach ($q_employee->result() as $row_employee) {
                                            $Emp_FirstName = $row_employee->Emp_FirstName;
                                            $Emp_Middlename = $row_employee->Emp_MiddleName;
                                            $Emp_LastName = $row_employee->Emp_LastName;
                                        }

                                        // $emp_report_to_id = $row->Reporting_To;
                                        $this->db->order_by('Career_Id', 'asc');
                                        $this->db->where('Employee_Id', $employee_id);
                                        $this->db->limit(1);
                                        $q_career = $this->db->get('tbl_employee_career');
                                        foreach ($q_career->result() as $row_career) {
                                            $emp_report_to_id = $row_career->Reporting_To;
                                        }
                                        $this->db->where('Emp_Number', $emp_report_to_id);
                                        $q_emp = $this->db->get('tbl_employee');
                                        foreach ($q_emp->result() as $row_emp) {
                                            $emp_reporting_firstname = $row_emp->Emp_FirstName;
                                            $emp_reporting_lastname = $row_emp->Emp_LastName;
                                            $emp_reporting_middlename = $row_emp->Emp_MiddleName;
                                        }

                                        $Leave_Title = $row->Type;
                                        $Leave_Duration = "Full Day";
                                        $Apply_Date1 = $row->Inserted_Date;
                                        $Apply_Date = date("d-M-Y", strtotime($Apply_Date1));
                                        $Leave_From1 = $row->Date;
                                        $Leave_From = date("d-M-Y", strtotime($Leave_From1));

                                        $Leave_To1 = $row->Date;
                                        $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                                        $Leave_To = date("d-M-Y", strtotime($Leave_To1));
                                        $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                        $No_days = $interval->format("%a");
                                        $Reason = $row->Reason;
                                        $Approval = $row->Approval;
                                        $status = $row->Status;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $emp_code . $employee_id; ?></td>
                                            <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                            <?php if ($user_role == 2) { ?>
                                                <td> 
                                                    <?php
                                                    echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename;
                                                    ?>
                                                </td>
                                            <?php }
                                            ?>
                                            <td><?php echo $Leave_Title; ?></td>
                                            <td><?php echo $Leave_Duration; ?></td>
                                            <td><?php echo $Apply_Date; ?></td>
                                            <td><?php echo $Leave_From; ?></td>
                                            <td><?php echo $Leave_To; ?></td>
                                            <td><?php echo $No_days; ?></td>
                                            <td><?php echo $Reason; ?></td>
                                            <td>
                                                <?php
                                                if ($Approval == "Request") {
                                                    echo "Processing...";
                                                }if ($Approval == "Yes") {
                                                    echo "Approved";
                                                }if ($Approval == "No") {
                                                    echo "Not Approved";
                                                }
                                                if ($Approval == "Cancel") {
                                                    echo "Cancelled";
                                                }
                                                ?>
                                            </td>
                                            <td style="width:201px">
                                                <a data-toggle='modal' href='#reply_compoffleaves' class="btn btn-default btn-sm btn-icon icon-left" onclick="reply_compoffleaves(<?php echo $Leave_Id; ?>)">
                                                    <i class="entypo-pencil"></i>
                                                    View & Reply
                                                </a>
                                                <a data-toggle='modal' href='#cancel_compoffleave' class="btn btn-danger btn-sm btn-icon icon-left" onclick="cancel_compoffleave(<?php echo $Leave_Id; ?>)">
                                                    <i class="entypo-cancel"></i>
                                                    Cancel
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            } else if ($user_role == 1) {
                                $this->db->order_by('A_M_Id', 'desc');
                                $get_data = array(
                                    'Type' => 'Comp Off',
                                    'Status' => 1
                                );
                                $this->db->where($get_data);
                                $q = $this->db->get('tbl_attendance_mark');
                                foreach ($q->Result() as $row) {
                                    $Leave_Id = $row->A_M_Id;
                                    $employee_id = $row->Emp_Id;
                                    $this->db->where('employee_number', $employee_id);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }
                                    $get_empdata = array(
                                        'Emp_Number' => $employee_id,
                                        'Status' => 1
                                    );

                                    $this->db->where($get_empdata);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                    }

                                    $this->db->order_by('Career_Id', 'asc');
                                    $this->db->where('Employee_Id', $employee_id);
                                    $this->db->limit(1);
                                    $q_career = $this->db->get('tbl_employee_career');
                                    foreach ($q_career->result() as $row_career) {
                                        $emp_report_to_id = $row_career->Reporting_To;
                                    }
                                    $this->db->where('Emp_Number', $emp_report_to_id);
                                    $q_emp = $this->db->get('tbl_employee');
                                    foreach ($q_emp->result() as $row_emp) {
                                        $emp_reporting_firstname = $row_emp->Emp_FirstName;
                                        $emp_reporting_lastname = $row_emp->Emp_LastName;
                                        $emp_reporting_middlename = $row_emp->Emp_MiddleName;
                                    }

                                    $Leave_Title = $row->Type;
                                    $Leave_Duration = "Full Day";
                                    $Apply_Date1 = $row->Inserted_Date;
                                    $Apply_Date = date("d-M-Y", strtotime($Apply_Date1));
                                    $Leave_From1 = $row->Date;
                                    $Leave_From = date("d-M-Y", strtotime($Leave_From1));
                                    $Leave_To1 = $row->Date;
                                    $Leave_To_include = date('Y-m-d', strtotime($Leave_To1 . "+1 days"));
                                    $Leave_To = date("d-M-Y", strtotime($Leave_To1));
                                    $interval = date_diff(date_create($Leave_To_include), date_create($Leave_From1));
                                    $No_days = $interval->format("%a");
                                    $Reason = $row->Remarks;
                                    $Approval = $row->Approval;
                                    $status = $row->Status;
                                    if ($emp_no == $emp_report_to_id) {
                                        $update_data = array(
                                            'Manager_read' => 'read'
                                        );
                                        $this->db->where('A_M_Id', $Leave_Id);
                                        $this->db->update('tbl_attendance_mark', $update_data);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $emp_code . $employee_id; ?></td>
                                            <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                            <td><?php echo $Leave_Title; ?></td>
                                            <td><?php echo $Leave_Duration; ?></td>
                                            <td><?php echo $Apply_Date; ?></td>
                                            <td><?php echo $Leave_From; ?></td>
                                            <td><?php echo $Leave_To; ?></td>
                                            <td><?php echo $No_days; ?></td>
                                            <td><?php echo $Reason; ?></td>
                                            <td>
                                                <?php
                                                if ($Approval == "Request") {
                                                    echo "Processing...";
                                                }if ($Approval == "Yes") {
                                                    echo "Approved";
                                                }if ($Approval == "No") {
                                                    echo "Not Approved";
                                                }
                                                if ($Approval == "Cancel") {
                                                    echo "Canceled";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a data-toggle='modal' href='#reply_compoffleaves' class="btn btn-default btn-sm btn-icon icon-left" onclick="reply_compoffleaves(<?php echo $Leave_Id; ?>)">
                                                    <i class="entypo-pencil"></i>
                                                    View & Reply
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
                            ?>
                        </tbody>

                    </table>

                    <!-- Leave Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Reply Leave Start Here -->

        <div class="modal fade custom-width" id="reply_compoffleaves">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Leave</h3>
                    </div>
                    <form role="form" id="replycompoffleave_form" name="replycompoffleave_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Add Leave End Here -->

        <!-- Leave Cancel Start Here -->

        <div class="modal fade" id="cancel_compoffleave">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Cancel Leave</h3>
                    </div>                                                    
                    <form role="form" id="cancelcompoffleave_form" name="cancelcompoffleave_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Leave Cancel End Here -->

        <!-- Table Script -->
        <script type="text/javascript">
            jQuery(document).ready(function ($)
            {
                var table = $("#emp_compoffleave_table").dataTable({
                    "sPaginationType": "bootstrap",
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "bStateSave": true
                });

                table.columnFilter({
                    "sPlaceHolder": "head:after"
                });
            });
        </script>


