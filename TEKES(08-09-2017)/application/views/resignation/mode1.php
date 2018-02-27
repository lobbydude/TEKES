<?php
$emp_no = $this->uri->segment(3);
$user_role = $this->session->userdata('user_role');
$this->db->where('employee_number', $emp_no);
$q_code = $this->db->get('tbl_emp_code');
foreach ($q_code->result() as $row_code) {
    $emp_code = $row_code->employee_code;
}
$emp_get_data = array(
    'Emp_Number' => $emp_no,
    'Status' => 1
);
$this->db->where($emp_get_data);
$q_employee = $this->db->get('tbl_employee');
$count_employee=$q_employee->num_rows();
foreach ($q_employee->result() as $row_employee) {
    $employee_name = $row_employee->Emp_FirstName;
    $employee_name .= " " . $row_employee->Emp_LastName;
    $employee_name .= " " . $row_employee->Emp_MiddleName;
}
$this->db->where('Employee_Id', $emp_no);
$this->db->limit(1);
$emp_q_career = $this->db->get('tbl_employee_career');
foreach ($emp_q_career->result() as $emp_row_career) {
    $emp_designation_id = $emp_row_career->Designation_Id;
    $emp_report_to_id = $emp_row_career->Reporting_To;
    $this->db->where('Designation_Id', $emp_designation_id);
    $q_desig = $this->db->get('tbl_designation');
    foreach ($q_desig->result() as $row_desig) {
        $emp_notice_period = $row_desig->Notice_Period;
    }
    $this->db->where('Emp_Number', $emp_report_to_id);
    $q_emp = $this->db->get('tbl_employee');
    foreach ($q_emp->result() as $row_emp) {
        $emp_reporting_name = $row_emp->Emp_FirstName;
        $emp_reporting_name .= " " . $row_emp->Emp_LastName;
        $emp_reporting_name .= " " . $row_emp->Emp_MiddleName;
    }
}
$this->db->order_by('R_Id', 'desc');
$resignation_get_data = array(
    'Employee_Id' => $emp_no,
    'Status' => 1
);
$this->db->where($resignation_get_data);
$q = $this->db->get('tbl_resignation');
if($count_employee==1){
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
    function add_termination(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Termination/add_termination') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                $("#add_termination_div").html(html);
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
    function change_res_type(type) {
        if (type == "Termination") {
            $("#resignation_div").hide();
            $("#termination_div").show();
        }
        else {
            $("#termination_div").hide();
            $("#resignation_div").show();
        }
    }
</script>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Resignation : <?php echo $employee_name . "( " . $emp_code . $emp_no . " )" ?></h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="history.back();">
                                Back
                                <i class=" entypo-back"></i>
                            </button>
                            <a class="btn btn-primary btn-icon icon-left" data-toggle='modal' href='#add_termination' onclick="add_termination('<?php echo $emp_no; ?>')" style="margin-top:0px">
                                  Add Resignation
                                <i class="entypo-plus-circled"></i>
                             </a>
                        </div>
                    </div>
                    <!-- Resignation Table Format Start Here -->
                    <table class="table table-bordered datatable" id="resignation_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
								<th>Type</th>
                                <th>Letter Date</th>
                                <th>Resignation Date</th>
                                <th>Notice Period</th>
                                <th>Last Working Date</th>
                                <th>Status</th>
                                <?php if ($user_role == 2 || $user_role == 6) { ?>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
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
                                $Notice_Period = $row->Notice_Period;
                                $LWD1 = $row->HR_FinalSettlement_Date;
                                $LWD = date("d-m-Y", strtotime($LWD1));
                                $Approval = $row->Approval;
                                $status = $row->Status;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
									<td><?php echo $Type; ?></td>
                                    <td><?php echo $Notice_Date; ?></td>
                                    <td><?php echo $Resignation_Date; ?></td>
                                    <td><?php echo $Notice_Period . " Days"; ?></td>
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
                                                    if ($status == 0) {
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
                                                    Canceled
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
                                $i++;
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
                                <a href="#" class="btn btn-primary" onclick="resignation_print('resignation_print')"><i class="entypo-print"></i>Print</a>
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
        <!-- Add Resignation Start Here -->
        <div class="modal fade custom-width" id="add_termination">
            <div class="modal-dialog" style="width:65%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Resignation</h3>
                    </div>
                    <form role="form" id="addtermination_form" name="addtermination_form" method="post" class="validate">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="addresignation_success" class="alert alert-success" style="display:none;">Resignation sent successfully.</div>
                                    <div id="addresignation_error" class="alert alert-danger" style="display:none;">Failed to send resignation.</div>
                                    <div id="addtermination_success" class="alert alert-success" style="display:none;">Termination sent successfully.</div>
                                    <div id="addtermination_error" class="alert alert-danger" style="display:none;">Failed to send termination.</div>
                                </div>
                            </div>
                            <div id="add_termination_div"></div>
                            <div class="row" style="margin-top: 10px;margin-bottom: 20px">
                                <div class="col-md-4">
                                    <label class="control-label" for="full_name">Type</label>
                                    <select class="round" name="add_res_type" id="add_res_type" onChange="change_res_type(this.value);">
                                        <option value="Termination">Termination</option>
                                        <option value="Resignation">Resignation</option>
                                    </select>
                                </div>
                                <div class="loading" style="display:none;width:69px;height:89px;position:absolute;top:13%;left:50%;"><img src="<?php echo site_url('images/loader-1.gif') ?>" width="64" height="64" /><br>Loading..</div>
                                <div id="termination_div">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Last Working Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_termination_lwd" id="add_termination_lwd" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select last working date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Termination Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_termination_date" id="add_termination_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select termination date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Reason</label>
                                            <div class="input-group">
                                                <textarea name="add_termination_reason" id="add_termination_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter reason."></textarea>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Terminated By</label>
                                            <div class="input-group">
                                                <input type="text" name="add_termination_by" id="add_termination_by" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter terminated by.">
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                                <div id="resignation_div" style="display: none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Letter Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_notice_date" id="add_notice_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select notice date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Resignation Date</label>
                                            <div class="input-group">
                                                <input type="text" name="add_resignation_date" id="add_resignation_date" class="form-control datepicker" data-format="dd-mm-yyyy" data-message-required="Please select resignation date." data-mask="dd-mm-yyyy" data-validate="required">
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="entypo-calendar"></i></a>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Reason</label>
                                            <textarea name="add_reason" id="add_reason" class="form-control" placeholder="Reason" data-validate="required" data-message-required="Please enter grade."></textarea>
                                        </div>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="addtermination_button">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Resignation End Here -->
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
<?php }else{
    redirect("Employee");
} ?>