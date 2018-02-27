<?php
$this->db->where('Status', 1);
$q_emp = $this->db->get('tbl_employee');
?>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Employee</h2>
                        </div>
                    </div>

                    <!-- Employee Table Format Start Here -->

                    <table class="table table-bordered datatable" id="table-1">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Id</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($q_emp->Result() as $row) {
                                $emp_id = $row->Employee_Id;
                                $emp_no = $row->Emp_Number;

                                $this->db->where('employee_number', $emp_no);
                                $q_code = $this->db->get('tbl_emp_code');
                                foreach ($q_code->Result() as $row_code) {
                                    $emp_code = $row_code->employee_code;
                                }

                                $emp_firstname = $row->Emp_FirstName;
                                $emp_middlename = $row->Emp_MiddleName;
                                $emp_lastname = $row->Emp_LastName;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $emp_code . $emp_no; ?></td>
                                    <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                    <td> 
                                        <?php
                                        $this->db->group_by('Employee_Id');
                                        $this->db->where('Employee_Id', $emp_no);
                                        $q_ack = $this->db->get('tbl_employee_acknowledgment');
                                        $count_Ack = $q_ack->num_rows();
                                        if ($count_Ack > 0) {
                                            foreach ($q_ack->Result() as $row_ack) {
                                                $status = $row_ack->Acknowledgement;
                                            }
                                        } else {
                                            $status = "No";
                                        }
                                        echo $status;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Employee Table Format End Here -->
                </div>
            </div>
        </section>


        <script type="text/javascript">
            $(document).ready(function (e) {
                $("#importemployee_form").on('submit', (function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "<?php echo site_url('Employee/import_employee') ?>",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data)
                        {
                            if (data == "fail") {
                                $('#importemployee_error').show();
                            }

                            if (data == "success") {
                                $('#importemployee_success').show();
                                $('#import_div').hide();
                                $('#export_div').show();
                                // $('#import_employee').hide();
                                // $('#export_employee').modal('show', {backdrop: 'static'});
                            }
                        },
                        error: function ()
                        {
                        }
                    });
                }));
            });

        </script>

        <!-- Resignation Status Start Here -->

        <div class="modal fade custom-width" id="resignation_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Resignation</h3>
                    </div>
                    <form role="form" id="resignation_status_form" name="resignation_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Resignation Status End Here -->

        <!-- Resignation Status Start Here -->

        <div class="modal fade custom-width" id="termination_status">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Termination</h3>
                    </div>
                    <form role="form" id="termination_status_form" name="termination_status_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Termination Status End Here -->


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
                tableContainer = $("#table-1");

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

