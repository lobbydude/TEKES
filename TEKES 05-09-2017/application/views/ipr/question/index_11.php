<?php
function seconds_from_time($time) { 
    list($h, $m, $s) = explode(':', $time); 
    return ($h * 3600) + ($m * 60) + $s; 
} 
?>
<link rel="stylesheet" href="<?php echo site_url('js/quiz/font-awesome.min.css') ?>">
<script src="<?php echo site_url('js/quiz/jquery.validate.min.js') ?>"></script>
<script src="<?php echo site_url('js/quiz/bootstrap.min.js') ?>"></script>
<style>
    .cont,.question{min-height: 200px; margin-left: 30px;}
    .result-logo{margin-left: 42%;margin-top:1.6%;}
    .result-logo1{margin-left: 55%;}
    .result-container{margin-left: 40%;margin-top:1%; color:#684B68;}
    .logout{padding-top:100px;}
    .previous{margin-left:35%;}
    .next, .res{margin-left:50%;}
    .answer{color:green; font-weight: 300;font-size: larger;}
    .result{height: 452px;}
</style>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <?php
                    $Kp_id = $this->input->post('send_kp_id');
                    $employee_id = $this->session->userdata('username');
                    $inserted_id = $this->session->userdata('user_id');
                    $get_empdata = array(
                        'Kp_Id' => $Kp_id,
                        'Employee_Id' => $employee_id,
                        'Status' => 1
                    );
                    $this->db->where($get_empdata);
                    $q_emp = $this->db->get('tbl_kpemployee');
                    $count_emp = $q_emp->num_rows();

                    if ($count_emp == 0) {
                        //echo "<script>alert('hi')</script>";
                        $insert_employee = array(
                            'Kp_Id' => $Kp_id,
                            'Employee_Id' => $employee_id,
                            'Inserted_Date' => date('Y-m-d H:i:s'),
                            'Inserted_By' => $inserted_id,
                            'Status' => 1
                        );
                        $q_employee=$this->db->insert('tbl_kpemployee', $insert_employee);

                        $this->db->order_by('Kp_Id', 'desc');
                        $get_kpdata = array(
                            'Kp_Id' => $Kp_id,
                            'Status' => 1
                        );
                        $this->db->where($get_kpdata);
                        $q = $this->db->get('tbl_kpmaster');
                        foreach ($q->result() as $row) {
                            $testname = $row->Test_Name;
                            $duration_time = $row->Duration_Time;
                            
                        }
                        ?>                 
                        <!--Countdown Timer Start here-->                
                        <div class="panel-heading info-bar">
                            <div class="panel-title">
                                <h2>
                                    <?php echo $testname;                                 
                                ?></h2>
                            </div>
                    <script>                           
                           <?php $testing = seconds_from_time("$duration_time");?>
                            var seconds = <?php echo $testing; ?>;                             
                            function secondPassed() {                          
                            var hours   = Math.floor(seconds / 3600);
                            var minutes = Math.floor((seconds - (hours * 3600)) / 60);
                            var remainingSeconds = seconds - (hours * 3600) - (minutes * 60);
                            
                            if (hours < 10) {
                                hours = "0" + hours;
                            }
                            if (remainingSeconds < 10) {
                                remainingSeconds = "0" + remainingSeconds; 
                            }
                            document.getElementById('countdown').innerHTML = hours + ":" + minutes + ":" + remainingSeconds;
                            if (seconds == 0) {
                                clearInterval(countdownTimer);
                                document.getElementById('countdown').innerHTML = "Timeout";
                                } else {
                                seconds--;
                            }
                        }
                        var countdownTimer = setInterval('secondPassed()', 1000);
                    </script>
                            <div class="panel-options">
                                <button class=" btn-icon icon-left" type="button" style="font-size:18px; border: 1px solid #20526B; border-radius: 6px;">
                                    Time <span id="countdown"> <?php echo "$duration_time"; ?> </span> Minutes
                                    <i class="entypo-clock"></i>
                                </button>
                            </div>
                        </div><br/>

                        <!-- IPR KP Master Dashboard design Table Format Start Here -->
                        <form class="form-horizontal" role="form" id='addresult_form' method="post" action="<?php echo site_url('Ipr/Result') ?> ">
                            <input type="hidden" name="Kp_Id" id="Kp_Id" value="<?php echo $Kp_id; ?>">
                            <?php
                            // My code start
                            $this->db->order_by('Q_Id', 'desc');
                            $get_kpquestion_data = array(
                                'Kp_Id' => $Kp_id,
                                'Status' => 1
                            );
                            $this->db->where($get_kpquestion_data);
                            $que = $this->db->get('tbl_kpquestions');
                            $count_rows = $que->num_rows();
                            $i = 1;
                            foreach ($que->result() as $row_question) {
                                $q_id = $row_question->Q_Id;
                                $Kp_Id = $row_question->Kp_Id;
                                $question = $row_question->Question;
                                $Option1 = $row_question->Option1;
                                $Option2 = $row_question->Option2;
                                $Option3 = $row_question->Option3;
                                $Option4 = $row_question->Option4;
                                $Answer = $row_question->Answer;
                                if ($i == 1) {
                                    ?>
                                    <div id='question<?php echo $i; ?>' class="cont">                                                             
                                        <p class='questions' id="qname<?php echo $i; ?>"> <?php echo $i ?>. <?php echo $question; ?></p>
                                        <input type="radio" style="margin-right:8px;" value="1" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option1; ?>
                                        <br/>
                                        <input type="radio" style="margin-right:8px;" value="2" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option2; ?>
                                        <br/>
                                        <input type="radio" style="margin-right:8px;" value="3" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option3; ?>
                                        <br/>
                                        <input type="radio" style="margin-right:8px;" value="4" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option4; ?>
                                        <br/>
                                        <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/>                                                                      
                                        <br/>
                                        <button id='<?php echo $i; ?>' class='next btn btn btn-primary' type='button'>Next</button>
                                    </div>
                                <?php } elseif ($i < 1 || $i < $count_rows) { ?>
                                    <div id='question<?php echo $i; ?>' class='cont'>
                                        <p class='questions' id="qname<?php echo $i; ?>"><?php echo $i ?>. <?php echo $question; ?></p>
                                        <input type="radio" style="margin-right:8px;" value="1" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option1; ?>
                                        <br/>
                                        <input type="radio" style="margin-right:8px;" value="2" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option2; ?>
                                        <br/>
                                        <input type="radio" style="margin-right:8px;" value="3" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option3; ?>
                                        <br/>
                                        <input type="radio" style="margin-right:8px;" value="4" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option4; ?>
                                        <br/>
                                        <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/>                                                                      
                                        <br/>
                                        <button id='<?php echo $i; ?>' class='previous btn btn btn-primary' type='button'>Previous</button>                    
                                        <button id='<?php echo $i; ?>' class='next btn btn btn-primary' type='button' >Next</button>
                                    </div>
                                <?php } elseif ($i == $count_rows) { ?>
                                    <div id='question<?php echo $i; ?>' class='cont'>
                                        <p class='questions' id="qname<?php echo $i; ?>"><?php echo $i ?>. <?php echo $question; ?></p>
                                        <input type="radio" value="1" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option1; ?>
                                        <br/>
                                        <input type="radio" value="2" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option2; ?>
                                        <br/>
                                        <input type="radio" value="3" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option3; ?>
                                        <br/>
                                        <input type="radio" value="4" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option4; ?>
                                        <br/>
                                        <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/>                                                                      
                                        <br/>
                                        <button id='<?php echo $i; ?>' class='previous btn btn btn-primary' type='button'>Previous</button>                    
                                        <button id='<?php echo $i; ?>' class='res btn btn-primary' type='submit'>Finish</button>
                                    </div>                                
                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </form>                      
                        <?php
                    } else {
                        ?>
                        <div class="panel-heading info-bar">
                            <div class="panel-title">
                                <h2>General Question</h2>
                            </div>
                        </div><br/>
                        <div class="row"> 
                            <div class="col-md-10"> 
                                <div style="margin-left: 1%">
                                    <p>You have already attended this test.</p>
                                </div> 
                            </div>
                        </div>    
                        <?php
                    }
                    ?>
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