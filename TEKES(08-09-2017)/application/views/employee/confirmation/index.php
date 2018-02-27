<?php
if ($this->uri->segment(3) != "" && $this->uri->segment(4) != "") {
    $select_month = $this->uri->segment(3);
    $select_year = $this->uri->segment(4);
    $data_confirmation = array(
        'Status' => 1
    );
    $this->db->where($data_confirmation);
    $q_confirmation = $this->db->get('tbl_employee');
    $confirmation_count = $q_confirmation->num_rows();
} else {
    $current_date = date('Y-m-d');
    $data_confirmation = array(
        'Emp_Confirmationdate' => $current_date,
        'Status' => 1
    );
    $this->db->where($data_confirmation);
    $q_confirmation = $this->db->get('tbl_employee');
    $confirmation_count = $q_confirmation->num_rows();
    $cur_date = date("d-M-Y", strtotime($current_date));
}
$user_role = $this->session->userdata('user_role');
?>

<script>
    function emp_confirmation(emp_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Employee/Markconfirmation') ?>",
            data: "emp_id=" + emp_id,
            cache: false,
            success: function (html) {
                if (html == "success") {
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
                            <h2>Confirmation on <?php
                                if ($this->uri->segment(3) != "" && $this->uri->segment(4) != "") {
                                    $monthName = date("F", mktime(0, 0, 0, $select_month, 10));
                                    echo $monthName . " " . $select_year;
                                } else {
                                    echo $cur_date;
                                }
                                ?></h2>
                        </div>

                        <div class="panel-options">
                            <div class="row">

                                <div class="col-md-6">
                                    <?php
                                    define('DOB_YEAR_START', 2000);
                                    $current_year = date('Y');
                                    ?>
                                    <select id="year_list" name="year_list" class="round" onchange="$('#change_timesheet').submit();">
                                        <?php
                                        if ($this->uri->segment(4) != "") {
                                            $cur_year = $this->uri->segment(4);
                                            ?>
                                            <option value="<?php echo $cur_year ?>" selected="selected"><?php echo $cur_year; ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $current_year; ?>" selected="selected"><?php echo $current_year; ?></option>
                                            <?php
                                        }
                                        for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                            echo "<option value='{$count}'>{$count}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="round" id="month_list" name="month_list" onchange="location = this.options[this.selectedIndex].value + '/' + $('#year_list').val();">
                                        <?php
                                        if ($this->uri->segment(3) != "") {
                                            $cur_month = $this->uri->segment(3);
                                            $cur_month_name = date("F", mktime(0, 0, 0, $cur_month, 10));
                                            ?>
                                            <option value="<?php echo $cur_month ?>" selected="selected"><?php echo $cur_month_name; ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo date('m') ?>" selected="selected"><?php echo date('M') ?></option>
                                            <?php
                                        }
                                        for ($m = 1; $m <= 12; $m++) {
                                            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                            ?>
                                            <option value="<?php echo site_url('Employee/Confirmation/' . $m); ?>"><?php echo $month; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Confirmation Table Format Start Here -->
                    <div id="confirmation_div">
                        <table class="table table-bordered datatable" id="confirmation_table">
                            <thead>
                                <tr>
                                    <th>Employee_Id</th>
                                    <th>Employee_Name</th>
                                    <th>Confirmation Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($confirmation_count > 0) {
                                    if (($this->uri->segment(3) != "") && ($this->uri->segment(4) != "")) {
                                        foreach ($q_confirmation->Result() as $row_confirmation) {
                                            $emp_id = $row_confirmation->Employee_Id;
                                            $emp_no = $row_confirmation->Emp_Number;

                                            $this->db->where('employee_number', $emp_no);
                                            $q_code = $this->db->get('tbl_emp_code');
                                            foreach ($q_code->Result() as $row_code) {
                                                $emp_code = $row_code->employee_code;
                                            }

                                            $emp_firstname = $row_confirmation->Emp_FirstName;
                                            $emp_lastname = $row_confirmation->Emp_LastName;
                                            $emp_middlename = $row_confirmation->Emp_MiddleName;
                                            $emp_mode = $row_confirmation->Emp_Mode;
                                            $conf_date = $row_confirmation->Emp_Confirmationdate;
                                            $confirmation_month = date("m", strtotime($conf_date));
                                            $confirmation_year = date("Y", strtotime($conf_date));
                                            if (($confirmation_month == $select_month) && ($confirmation_year == $select_year)) {
                                                $confirmation_date = date("d-M-Y", strtotime($conf_date));
                                                ?>
                                                <tr>
                                                    <td><?php echo $emp_code . $emp_no; ?></td>
                                                    <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                                    <td><?php echo $confirmation_date; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($emp_mode == "Probation") {
                                                            ?>
                                                            <a class="btn btn-primary" onclick="emp_confirmation(<?php echo $emp_id; ?>)">Probationary</a>
                                                            <?php
                                                        } elseif ($emp_mode == "Confirmed") {
                                                            echo "<b>Permanent</b>";
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    } else {
                                        foreach ($q_confirmation->Result() as $row_confirmation) {
                                            $emp_id = $row_confirmation->Emp_Number;

                                            $this->db->where('employee_number', $emp_id);
                                            $q_code = $this->db->get('tbl_emp_code');
                                            foreach ($q_code->Result() as $row_code) {
                                                $emp_code = $row_code->employee_code;
                                            }

                                            $emp_firstname = $row_confirmation->Emp_FirstName;
                                            $emp_lastname = $row_confirmation->Emp_LastName;
                                            $emp_middlename = $row_confirmation->Emp_MiddleName;

                                            $conf_date = $row_confirmation->Emp_Confirmationdate;
                                            $confirmation_date = date("d-M-Y", strtotime($conf_date));
  $emp_mode = $row_confirmation->Emp_Mode;
                                            ?>
                                            <tr>
                                                <td><?php echo $emp_code . $emp_id; ?></td>
                                                <td><?php echo $emp_firstname . " " . $emp_lastname . " " . $emp_middlename; ?></td>
                                                <td><?php echo $confirmation_date; ?></td>
<td>
                                                    <?php
                                                    if ($emp_mode == "Probation") {
                                                        ?>
                                                        <a class="btn btn-primary" onclick="emp_confirmation('<?php echo $emp_id; ?>')">Probationary</a>
                                                        <?php
                                                    } elseif ($emp_mode == "Confirmed") {
                                                        echo "<b>Permanent</b>";
                                                    } else {
                                                        echo "";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Confirmation Table Format End Here -->
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
                tableContainer = $("#confirmation_table");

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

