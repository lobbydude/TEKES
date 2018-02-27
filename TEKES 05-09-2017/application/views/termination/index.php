<?php
$emp_no = $this->session->userdata('username');

$this->db->where('Status', 1);
$q = $this->db->get('tbl_termination');

$this->db->where('Status', 1);
$q_emp = $this->db->get('tbl_employee');

$user_role = $this->session->userdata('user_role');
if ($user_role == 2) {
    $update_data = array(
        'HR_Read' => 'read'
    );
    $this->db->update('tbl_termination', $update_data);
    $this->db->where('Status', 1);
    $q = $this->db->get('tbl_termination');
}
if ($user_role == 1) {
    $update_data = array(
        'Manager_Read' => 'read'
    );
    $this->db->where('Reporting_To', $emp_no);
    $this->db->update('tbl_termination', $update_data);

    $get_terminate_data = array(
        'Reporting_To' => $emp_no,
        'Status' => 1
    );
    $this->db->where($get_terminate_data);
    $q = $this->db->get('tbl_termination');
}
?>
<script>
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
</script>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">
                            <h2>Termination</h2>
                        </div>
                    </div>

                    <!-- Termination Table Format Start Here -->

                    <table class="table table-bordered datatable" id="termination_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Code</th>
                                <th>Employee</th>
                                <th>Last Working Date</th>
                                <th>Terminated Date</th>
                                <th>Reporting To</th>
                                <th>Reason</th>
                                <th>Terminated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q->Result() as $row) {
                                $T_Id = $row->T_Id;
                                $Terminated_Date1 = $row->Terminated_Date;
                                $Terminated_Date = date("d-m-Y", strtotime($Terminated_Date1));

                                $Reason = $row->Reason;
                                $Reporting_no = $row->Reporting_To;
                                $Employee_Id = $row->Employee_Id;
                                $lwd_Date1 = $row->LWD_Date;
                                $lwd_Date = date("d-m-Y", strtotime($lwd_Date1));
                                $this->db->where('employee_number', $Employee_Id);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->Result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                }


                                $this->db->where('Emp_Number', $Employee_Id);
                                $q_employee = $this->db->get('tbl_employee');
                                foreach ($q_employee->result() as $row_employee) {
                                    $Emp_FirstName = $row_employee->Emp_FirstName;
                                    $Emp_MiddleName = $row_employee->Emp_MiddleName;
                                    $Emp_LastName = $row_employee->Emp_LastName;
                                }

                                $this->db->where('Emp_Number', $Reporting_no);
                                $q_employee1 = $this->db->get('tbl_employee');
                                foreach ($q_employee1->result() as $row_employee1) {
                                    $Emp_FirstName1 = $row_employee1->Emp_FirstName;
                                    $Emp_MiddleName1 = $row_employee1->Emp_MiddleName;
                                    $Emp_LastName1 = $row_employee1->Emp_LastName;
                                }

                                $Terminated_By = $row->Terminated_By;
                                $this->db->where('Emp_Number', $Terminated_By);
                                $q_employee2 = $this->db->get('tbl_employee');
                                foreach ($q_employee2->result() as $row_employee2) {
                                    $Emp_FirstName2 = $row_employee2->Emp_FirstName;
                                    $Emp_MiddleName2 = $row_employee2->Emp_MiddleName;
                                    $Emp_LastName2 = $row_employee2->Emp_LastName;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $emp_code . $Employee_Id; ?></td>
                                    <td><?php echo $Emp_FirstName . " " . $Emp_LastName . " " . $Emp_MiddleName; ?></td>
                                    <td><?php echo $lwd_Date; ?></td>
                                    <td><?php echo $Terminated_Date; ?></td>
                                    <td><?php echo $Emp_FirstName1 . " " . $Emp_LastName1 . " " . $Emp_MiddleName1; ?></td>
                                    <td><?php echo $Reason; ?></td>
                                    <td><?php echo $Emp_FirstName2 . " " . $Emp_LastName2 . " " . $Emp_MiddleName2; ?></td>
                                    <?php if ($user_role == 2 || $user_role == 6) { ?>
                                        <td>
                                            <a data-toggle='modal' href='#edit_termination' class="btn-default" onclick="edit_termination(<?php echo $T_Id; ?>)" title="Edit">
                                                <i class="entypo-pencil"></i>
                                            </a>
                                            <a data-toggle='modal' href='#cancel_termination' class="btn-danger" onclick="cancel_termination(<?php echo $T_Id; ?>)" title="Cancel">
                                                <i class="entypo-cancel"></i>
                                            </a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Termination Table Format End Here -->
                </div>
            </div>
        </section>

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
                tableContainer = $("#termination_table");
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

