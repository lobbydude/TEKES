<?php
$Kp_id = 1;
$this->db->order_by('Kp_Id', 'desc');
$this->db->where('Status', 1);
$this->db->where('Kp_Id', 1);
$q = $this->db->get('tbl_kpmaster');
foreach ($q->result() as $row) {
    $department_id = $row->Department_Id;
    $testname = $row->Test_Name;
    $enable_Date1 = $row->Enable_Date;
    //Date format converted Y-m-D to D-m-Y converted
    $enable_Date = date("d-m-Y", strtotime($enable_Date1));
    $duration_time1 = $row->Duration_Time;
    $duration_time = date("h:m:s", strtotime($duration_time1));
}
// Duration Date Check here
//if (($current_date >= $enable_date) && ( $department_id >= $announcement_date1 )) {
date_default_timezone_set("Asia/Kolkata"); 
$current_date = date("Y-m-d");
$emp_id = $this->session->userdata('username');
$this->db->order_by('Career_Id', 'asdesc');
$this->db->where('Status', 1);
//$this->db->where('Kp_Id', 1);
$qcareer = $this->db->get('tbl_employee_career');
foreach ($qcareer->result() as $row_career) {
    $Department_id= $row_career->Department_Id;
    $Employee_Id = $row_career->Employee_Id;
}
?>
<style>
    .cont,.question{min-height: 200px; margin-left: 30px;}
    .result-logo{margin-left: 42%;margin-top:1.6%;}
    .result-logo1{margin-left: 55%;}
    .result-container{margin-left: 40%;margin-top:1%; color:#684B68;}
    .logout{padding-top:100px;}
    .next{margin-left:200px;}
    .answer{color:green; font-weight: 300;font-size: larger;}
    .result{height: 452px;}
</style>

<link rel="stylesheet" href="<?php echo site_url('js/quiz/jquery.validate.min.js') ?>">
<link rel="stylesheet" href="<?php echo site_url('js/quiz/font-awesome.min.css') ?>">
<script src="<?php echo site_url('js/quiz/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('js/quiz/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('js/quiz/bootstrap.min.js') ?>"></script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">
                            <h2>General Question</h2>
                        </div>
                        <div class="panel-options">
                            <button class=" btn-icon icon-left" type="button" style="font-size:18px; border: 1px solid #20526B; border-radius: 6px;">
                                Time <?php echo "$duration_time"; ?> Mintes
                                <i class="entypo-clock"></i>
                            </button>
                        </div>
                    </div><br/>

                    <!-- IPR KP Master Dashboard design Table Format Start Here -->
                    <form class="form-horizontal" role="form" id='addresult_form' method="post" action="<?php echo site_url('Ipr/Questions') ?> ">
                        <div class="row">
                            <div class="col-md-10">
                                <div id="addshift_timing_server_error" class="alert alert-info" style="display:none;"></div>
                                <div id="addshift_timing_success" class="alert alert-success" style="display:none;">Shift timing details added successfully.</div>
                                <div id="addshift_timing_error" class="alert alert-danger" style="display:none;">Failed to add shift timing details.</div>
                            </div>
                        </div>

                        <div class="question">                              
                            <h3 style="margin-left:-22px;">General Instructions: Please read the below instructions carefully while appearing for the online test at TEKES.</h3>
                            <ul>
                                <li>This Test 30 Question worth 1 point each</li>
                                <li>Read the question and click your answer to see if you are correct</li>
                                <li>Correct? Click the "Next question" Next button Continue</li>
                                <li>Incorrect? please "try again" Previous button Continue question again</li>
                                <li>Click Finish button to exit and your score display</li>
                                <li>This Questions No Negative Marks</li>                                                                                
                            </ul>
                            <div class="form-group" style="width:50%;">
                                <label for="field-1" class="control-label">Test Name</label>
                                <select name="add_leavetype_leavetype" id="add_leavetype_leavetype" class="round" data-validate="required" data-message-required="Please Select Leave type." aria-required="true" aria-invalid="false">
                                    <option value="Any Type">Any Type</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>                                    
                                </select>
                            </div> 
                                                    
                            
                            <div style="margin-bottom: 20px">
                                <button class='next btn btn btn-primary' style="margin-left:84%;" type='submit'>Start</button>
                            </div>
                        </div>                        
                    </form>                      
                    <!-- IPR KP Master Table Format End Here -->
                </div>
            </div>
        </section>
        <script>
            $('.cont').addClass('hide');
            count = $('.questions').length;
            $('#question' + 1).removeClass('hide');

            $(document).on('click', '.next', function () {
                last = parseInt($(this).attr('id'));
                nex = last + 1;
                $('#question' + last).addClass('hide');

                $('#question' + nex).removeClass('hide');
            });

            $(document).on('click', '.previous', function () {
                last = parseInt($(this).attr('id'));
                pre = last - 1;
                $('#question' + last).addClass('hide');

                $('#question' + pre).removeClass('hide');
            });
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
                tableContainer = $("#iprmaster_table");

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