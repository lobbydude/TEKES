<?php
$username = $this->session->userdata('username');
$app_data_april = array(
    'Year' => date('Y'),
    'Month' => 4,
    'Status' => 1
);
$this->db->where($app_data_april);
$q_app_april = $this->db->get('tbl_appraisal');
$app_count_april = $q_app_april->num_rows();
if ($app_count_april > 0) {
    foreach ($q_app_april->result() as $row_app_april) {
        $Visible_From_Manager_april = $row_app_april->Visible_From_Manager;
        $Visible_To_Manager_april = $row_app_april->Visible_To_Manager;
    }
    $current_date_april = date('Y-m-d');
    if ($Visible_From_Manager_april <= $current_date_april || $current_date_april >= $Visible_To_Manager_april) {
        ?>
        <div class="main-content">
            <div class="container">
                <section class="topspace blackshadow bg-white"> 
                    <div class="col-md-12">
                        <div class="row">
                            <div class="panel-heading info-bar" >
                                <div class="panel-title">
                                    <h2>Employees - April Month Cycle</h2>
                                </div>
                                <div class="panel-options">
                                    <a class="btn btn-primary btn-icon icon-left" href="<?php echo site_url('appraisal/permission') ?>" style="margin-top:0px">
                                        Settings
                                        <i class="entypo-cog"></i>
                                    </a>
                                    <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#appraisal_settings').modal('show', {backdrop: 'static'});">
                                        Download
                                        <i class="entypo-plus-circled"></i>
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered datatable" id="april_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Employee Id</th>
                                        <th>Name</th>
                                        <th>DOJ</th>
                                        <th>Department</th>
                                        <th>Sub Process</th>
                                        <th>Designation</th>
                                        <th>Vintage</th>
                                        <th>Mode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->db->order_by('Employee_Id', 'desc');
                                    $this->db->where('Status', 1);
                                    $q = $this->db->get('tbl_employee');
                                    $i = 1;
                                    foreach ($q->Result() as $row) {
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
                                        $this->db->where('Employee_Id', $emp_no);
                                        $q_career = $this->db->get('tbl_employee_career');
                                        foreach ($q_career->Result() as $row_career) {
                                            $branch_id = $row_career->Branch_Id;
                                            $department_id = $row_career->Department_Id;
                                            $designation_id = $row_career->Designation_Id;
                                            $reporting_id = $row_career->Reporting_To;
                                        }
                                        $this->db->where('Designation_Id', $designation_id);
                                        $q_designation = $this->db->get('tbl_designation');
                                        foreach ($q_designation->Result() as $row_designation) {
                                            $designation_name = $row_designation->Designation_Name;
                                            $client_id = $row_designation->Client_Id;
                                        }
                                        $this->db->where('Subdepartment_Id', $client_id);
                                        $q_subdept = $this->db->get('tbl_subdepartment');
                                        foreach ($q_subdept->Result() as $row_subdept) {
                                            $subdept_name = $row_subdept->Subdepartment_Name;
                                        }
                                        $this->db->where('Department_Id', $department_id);
                                        $q_dept = $this->db->get('tbl_department');
                                        foreach ($q_dept->result() as $row_dept) {
                                            $department_name = $row_dept->Department_Name;
                                        }
                                        $status = $row->Status;
                                        $Emp_Doj = $row->Emp_Doj;
                                        $doj = date("Y-m-d", strtotime($Emp_Doj));
                                        $doj_no = date("Y-m-d", strtotime($Emp_Doj . "+1 days"));
                                        $interval = date_diff(date_create(), date_create($doj_no));
                                        $subtotal_experience = $interval->format("%Y Year,<br> %M Months, <br>%d Days");
                                        $no_days = $interval->format("%a");
                                        $no_days_Y = floor($no_days / 365);
                                        $no_days_M = floor(($no_days - (floor($no_days / 365) * 365)) / 30);
                                        $no_days_D = $no_days - (($no_days_Y * 365) + ($no_days_M * 30));
                                        $emp_mode = $row->Emp_Mode;
                                        $doj_date = explode("-", $Emp_Doj);
                                        $doj_year = $doj_date[0];
                                        $doj_month = $doj_date[1];
                                        $current_year = date('Y');
                                        if ($reporting_id == $username) {
                                            if ($doj_month < 6 && $current_year > $doj_year) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><a href="<?php echo site_url('Employee/Editemployee/' . $emp_no) ?>"><?php echo $emp_code . $emp_no; ?></a></td>
                                                    <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                                    <td><?php echo date("d-M-Y", strtotime($Emp_Doj)); ?></td>
                                                    <td><?php echo $department_name; ?></td>
                                                    <td><?php echo $subdept_name; ?></td>
                                                    <td><?php echo $designation_name; ?></td>
                                                    <td>
                                                        <?php
                                                        echo $no_days_Y . " Years, " . $no_days_M . " Months, <br>" . $no_days_D . " Days";
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($emp_mode == "Probation") {
                                                            echo "Probationary";
                                                        } elseif ($emp_mode == "Confirmed") {
                                                            echo "Permanent";
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?>
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
                        </div>
                    </div>
                </section>

                <script type="text/javascript">
                    var responsiveHelper;
                    var breakpointDefinition = {
                        tablet: 1024,
                        phone: 480
                    };
                    var tableContainer;
                    jQuery(document).ready(function ($)
                    {
                        tableContainer = $("#april_table");
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
                <?php
            }
        } else {
            redirect('Operation');
        }
        ?>