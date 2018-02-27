<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');

if ($user_role == 2) {
	$this->db->order_by('R_Id','desc');
	$this->db->where('Status', 1);
    $q = $this->db->get('tbl_resignation');
    $count = $q->num_rows();
    $update_data = array(
        'Hr_read' => 'read'
    );
    $this->db->update('tbl_resignation', $update_data);
} if ($user_role == 6) {
	$this->db->order_by('R_Id','desc');
	$this->db->where('Status', 1);
    $q = $this->db->get('tbl_resignation');
    $count = $q->num_rows();
} if ($user_role == 1) {
    $update_data = array(
        'Manager_read' => 'read'
    );
    $this->db->where('Reporting_To', $emp_no);
    $this->db->update('tbl_resignation', $update_data);

    $this->db->where('Reporting_To', $emp_no);
    $q = $this->db->get('tbl_resignation');
    $count = $q->num_rows();
}
?>
<script>
    function reply_resignation(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Resignation/ReplyResignation') ?>",
            data: "resignation_id=" + id,
            cache: false,
            success: function (html) {
                $("#replyresignation_form").html(html);
            }
        });
    }
    function cancel_resignation(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Resignation/CancelResignation') ?>",
            data: "resignation_id=" + id,
            cache: false,
            success: function (html) {
                $("#cancelresignation_form").html(html);
            }
        });
    }
    function resignation_status(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Resignation/ViewResignation') ?>",
            data: "resignation_id=" + id,
            cache: false,
            success: function (html) {
                $("#resignation_status_form").html(html);

            }
        });
    }
    function edit_termination(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/edit_termination') ?>",
            data: "termination_id=" + id,
            cache: false,
            success: function (html) {
                $("#edittermination_form").html(html);
            }
        });
    }
    function cancel_termination(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/cancel_termination') ?>",
            data: "termination_id=" + id,
            cache: false,
            success: function (html) {
                $("#canceltermination_form").html(html);
            }
        });
    }
    function termination_status(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/ViewTermination') ?>",
            data: "R_Id=" + id,
            cache: false,
            success: function (html) {
                $("#termination_status_form").html(html);
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
                            <h2>Resignation</h2>
                        </div>
                    </div>

                    <!-- Resignation Table Format Start Here -->

                    <table class="table table-bordered datatable" id="resignation_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Type</th>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <?php if ($user_role == 2 || $user_role == 6) { ?>
                                    <th>Reporting Manager</th>
                                <?php } ?>
                                <th>Letter Date</th>
                                <th>Resignation Date</th>
                                <th>Last Working Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($count > 0) {
                                foreach ($q->Result() as $row) {
                                    $R_Id = $row->R_Id;
                                    $Type = $row->Type;
                                    $Notice_Date1 = $row->Notice_Date;
                                    $Notice_Date = date("d-m-Y", strtotime($Notice_Date1));
                                    $Resignation_Date1 = $row->Resignation_Date;
                                    $Resignation_Date = date("d-m-Y", strtotime($Resignation_Date1));
                                    $Reason = $row->Reason;
                                    $employee_id = $row->Employee_Id;
                                    $this->db->where('employee_number', $employee_id);
                                    $q_code = $this->db->get('tbl_emp_code');
                                    foreach ($q_code->result() as $row_code) {
                                        $emp_code = $row_code->employee_code;
                                    }

                                    $this->db->where('Emp_Number', $employee_id);
                                    $q_employee = $this->db->get('tbl_employee');
                                    foreach ($q_employee->result() as $row_employee) {
                                        $Emp_FirstName = $row_employee->Emp_FirstName;
                                        $Emp_Middlename = $row_employee->Emp_MiddleName;
                                        $Emp_LastName = $row_employee->Emp_LastName;
                                    }

                                    $emp_report_to_id = $row->Reporting_To;
                                    $this->db->where('Emp_Number', $emp_report_to_id);
                                    $q_emp = $this->db->get('tbl_employee');
                                    foreach ($q_emp->result() as $row_emp) {
                                        $emp_reporting_firstname = $row_emp->Emp_FirstName;
                                        $emp_reporting_lastname = $row_emp->Emp_LastName;
                                        $emp_reporting_middlename = $row_emp->Emp_MiddleName;
                                    }

                                    $Approval = $row->Approval;
                                    $hr_status = $row->HR_Status;
                                    if ($Type == "Resignation") {
                                        $LWD1 = $row->HR_FinalSettlement_Date;
                                        $LWD = date("d-m-Y", strtotime($LWD1));
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $Type; ?></td>
                                            <td><?php echo $emp_code . $employee_id; ?></td>
                                            <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                                <td> 
                                                    <?php
                                                    echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename;
                                                    ?>
                                                </td>
                                            <?php }
                                            ?>
                                            <td><?php echo $Notice_Date; ?></td>
                                            <td><?php echo $Resignation_Date; ?></td>
                                            <td><?php echo $LWD; ?></td>
                                            <td>
                                                <?php
                                                if ($user_role == 2 || $user_role == 6) {
                                                    if ($Approval == "Request") {
                                                        echo "Processing ... ";
                                                    }if ($Approval == "Yes") {
                                                        ?>
                                                        <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                            <?php
                                                            if ($hr_status == 'exit') {
                                                                echo "Exit";
                                                            } else {
                                                                echo "Approved";
                                                            }
                                                            ?>
                                                        </a>
                                                        <?php
                                                    }if ($Approval == "No") {
                                                        ?>
                                                        <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                            Not Approved
                                                        </a>
                                                        <?php
                                                    }
                                                    if ($Approval == "Cancel") {
                                                        ?>
                                                        <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                            Cancelled
                                                        </a>
                                                        <?php
                                                    }
                                                } else {
                                                    if ($Approval == "Request") {
                                                        echo "Processing";
                                                    }if ($Approval == "Yes") {
                                                        echo "Approved";
                                                    }if ($Approval == "No") {
                                                        echo "Not Approved";
                                                    }
                                                    if ($Approval == "Cancel") {
                                                        echo "Cancelled";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php if ($user_role == 1) { ?>
                                                <td>
                                                    <a data-toggle='modal' href='#reply_resignation' class="btn btn-default btn-sm btn-icon icon-left" onclick="reply_resignation(<?php echo $R_Id; ?>)">
                                                        <i class="entypo-pencil"></i>
                                                        View & Reply
                                                    </a>
                                                </td>
                                            <?php } ?>
                                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                                <td>
                                                    <a data-toggle='modal' href='#reply_resignation' class="btn-default" onclick="reply_resignation(<?php echo $R_Id; ?>)" title="Edit">
                                                        <i class="entypo-pencil"></i>
                                                    </a>
                                                    <a data-toggle='modal' href='#cancel_resignation' class="btn-danger" onclick="cancel_resignation(<?php echo $R_Id; ?>)" title="Cancel">
                                                        <i class="entypo-cancel"></i>
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    } else {
                                        $LWD1 = $row->Last_Working_Date;
                                        $LWD = date("d-m-Y", strtotime($LWD1))
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $Type; ?></td>
                                            <td><?php echo $emp_code . $employee_id; ?></td>
                                            <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_Middlename; ?></td>
                                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                                <td> 
                                                    <?php
                                                    echo $emp_reporting_firstname . " " . $emp_reporting_lastname . " " . $emp_reporting_middlename;
                                                    ?>
                                                </td>
                                            <?php }
                                            ?>
                                            <td></td>
                                            <td><?php echo $Resignation_Date; ?></td>
                                            <td><?php echo $LWD; ?></td>
                                            <td>
                                                <?php
                                                if ($user_role == 2 || $user_role == 6) {
                                                    if ($Approval == "Request") {
                                                        echo "Processing ... ";
                                                    }if ($Approval == "Yes") {
                                                        ?>
                                                        <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                              <?php
                                                            if ($hr_status == 'exit') {
                                                                echo "Exit";
                                                            } else {
                                                                echo "Approved";
                                                            }
                                                            ?>
                                                        </a>
                                                        <?php
                                                    }if ($Approval == "No") {
                                                        ?>
                                                        <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                            Not Approved
                                                        </a>
                                                        <?php
                                                    }
                                                    if ($Approval == "Cancel") {
                                                        ?>
                                                        <a data-toggle='modal' href='#resignation_status' class="btn btn-primary" onclick="resignation_status(<?php echo $R_Id; ?>)">
                                                            Cancelled
                                                        </a>
                                                        <?php
                                                    }
                                                } else {
                                                    if ($Approval == "Request") {
                                                        echo "Processing";
                                                    }if ($Approval == "Yes") {
                                                        echo "Approved";
                                                    }if ($Approval == "No") {
                                                        echo "Not Approved";
                                                    }
                                                    if ($Approval == "Cancel") {
                                                        echo "Cancelled";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php if ($user_role == 1) { ?>
                                                <td>
                                                    <a data-toggle='modal' href='#termination_status' onclick="termination_status('<?php echo $R_Id; ?>')">
                                                        Terminated
                                                    </a>
                                                </td>
                                            <?php } ?>
                                            <?php if ($user_role == 2 || $user_role == 6) { ?>
                                                <td>
                                                    <a data-toggle='modal' href='#edit_termination' class="btn-default" onclick="edit_termination(<?php echo $R_Id; ?>)" title="Edit">
                                                        <i class="entypo-pencil"></i>
                                                    </a>
                                                    <a data-toggle='modal' href='#cancel_termination' class="btn-danger" onclick="cancel_termination(<?php echo $R_Id; ?>)" title="Cancel">
                                                        <i class="entypo-cancel"></i>
                                                    </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    }
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>

                    </table>

                    <!-- Resignation Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Reply Resignation Start Here -->

        <div class="modal fade custom-width" id="reply_resignation">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Resignation</h3>
                    </div>
                    <form role="form" id="replyresignation_form" name="replyresignation_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Reply Resignation End Here -->

        <!-- Cancel Resignation Start Here -->

        <div class="modal fade custom-width" id="cancel_resignation">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Cancel Resignation</h3>
                    </div>
                    <form role="form" id="cancelresignation_form" name="cancelresignation_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Cancel Resignation End Here -->

        <!-- Resignation Status Start Here -->

        <div class="modal fade custom-width" id="resignation_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="modal-title">View Resignation</h3>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        </div>
                    </div>
                    <form role="form" id="resignation_status_form" name="resignation_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Resignation Status End Here -->

        <!-- Edit Termination Start Here -->

        <div class="modal fade custom-width" id="edit_termination">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Edit Termination</h3>
                    </div>
                    <form role="form" id="edittermination_form" name="edittermination_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Termination End Here -->

        <!-- Cancel Termination Start Here -->

        <div class="modal fade custom-width" id="cancel_termination">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Cancel Termination</h3>
                    </div>
                    <form role="form" id="canceltermination_form" name="canceltermination_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Cancel Termination End Here -->

        <!-- Termination Status Start Here -->

        <div class="modal fade custom-width" id="termination_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="modal-title">View Termination</h3>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        </div>
                    </div>
                    <form role="form" id="termination_status_form" name="termination_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Termination Status End Here -->

        <script src="<?php echo site_url('js/jspdfmin.js') ?>"></script>
        <script>
                                    var doc = new jsPDF();
                                    var specialElementHandlers = {
                                        '#editor': function (element, renderer) {
                                            return true;
                                        }
                                    };
                                    function resignation_print() {
                                        doc.fromHTML($('#resignation_print').html(), 15, 15, {
                                            'width': 170,
                                            'elementHandlers': specialElementHandlers
                                        });
                                        doc.save('resignation.pdf');
                                    }
        </script>
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
                tableContainer = $("#resignation_table");

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

