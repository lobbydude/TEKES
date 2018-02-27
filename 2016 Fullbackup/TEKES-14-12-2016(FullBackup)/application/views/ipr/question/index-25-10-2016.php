<?php
$this->db->order_by('Kp_Id', 'desc');
$this->db->where('Status', 1);
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
// Duration Date Check 
date_default_timezone_set("Asia/Kolkata");
$current_time = date('H:i:s');
if ( (strtotime($duration_time) >= strtotime($current_time)) ) {
    echo "$test";
}
?>
<style>
.cont,.question{height: 200px; margin-left: 40px;}
.result-logo{margin-left: 42%;margin-top:1.6%;}
.result-logo1{margin-left: 55%;}
.result-container{margin-left: 40%;margin-top:1%; color:#684B68;}
.logout{padding-top:100px;}
.next{margin-left:200px;}
.answer{color:green;font-weight: 300;font-size: larger;}
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
                                Time <?php echo "$duration_time";?> Mintes
                                <i class="entypo-clock"></i>
                            </button>
                        </div>
                    </div><br/>

                    <!-- IPR KP Master Dashboard design Table Format Start Here -->
                    <form class="form-horizontal" role="form" id='login' method="post" action="<?php echo "Result/result";?> ">
                        <?php
                        /*$res = mysql_query("select * from questions where category_id=$category ORDER BY RAND()") or die(mysql_error());
                        $rows = mysql_num_rows($res);
                        $i = 1;*/
                        // My code start
                        $this->db->order_by('Q_Id', 'asdesc');
                        $this->db->where('Status', 1);
                        $que = $this->db->get('tbl_kpquestions');
                        $i = 0;
                        foreach ($que->result() as $row_question) {
                            $q_id = $row_question->Q_Id;
                            $Kp_Id = $row_question->Kp_Id;
                            $question = $row_question->Question;
                            $Option1 = $row_question->Option1;
                            $Option2 = $row_question->Option2;
                            $Option3 = $row_question->Option3;
                            $Option4 = $row_question->Option4;
                            $Answer = $row_question->Answer;                             
                        // My code End and Design Start
                            ?>
                            <?php if ($i == 1) { ?>                         
                                
                                <div class="question">                              
                                    <b>Instruction: How to Test question and Answer</b>
                                    <ul>
                                        <li>This Test 30 Question worth 1 point each</li>
                                        <li>Read the question and click your answer to see if you are correct</li>
                                        <li>Correct? Click the "Next question" Next button Continue</li>
                                        <li>Incorrect? please "try again" Previous button Continue question again</li>
                                        <li>Click Finish button to exit and your score display</li>
                                        <li>This Questions No Native Marks</li>                                                                                
                                    </ul> 
                                    <button id='<?php echo $i; ?>' class='next btn btn btn-primary' type='button'>Start</button>
                                </div>                        
                                <?php } elseif ($i == 2) { ?>
                                <div id='question<?php echo $i; ?>' class="cont">                                                             
                                    <p class='questions' id="qname<?php echo $i; ?>"> <?php echo $i ?>.<?php echo $question; ?></p>
                                    <input type="radio" style="margin-right:8px;" value="1" id='radio1_<?php echo $q_id;?>' name='<?php echo $q_id; ?>'/><?php echo $Option1; ?>
                                    <br/>
                                    <input type="radio" style="margin-right:8px;" value="2" id='radio1_<?php echo $q_id;?>' name='<?php echo $q_id; ?>'/><?php echo $Option2; ?>
                                    <br/>
                                    <input type="radio" style="margin-right:8px;" value="3" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option3; ?>
                                    <br/>
                                    <input type="radio" style="margin-right:8px;" value="4" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option4; ?>
                                    <br/>
                                    <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/>                                                                      
                                    <br/>
                                    <button id='<?php echo $i; ?>' class='next btn btn btn-primary' type='button'>Next</button>
                                </div>
                                
                               <?php } elseif ($i < 1 || $i < 30) { ?>
                                <?php //} elseif ($i == 3) { ?>                          
                                <div id='question<?php echo $i; ?>' class='cont'>
                                    <p class='questions' id="qname<?php echo $i; ?>"><?php echo $i ?>.<?php echo $question; ?></p>
                                    <input type="radio" style="margin-right:8px;" value="1" id='radio1_<?php echo $q_id;?>' name='<?php echo $q_id; ?>'/><?php echo $Option1; ?>
                                    <br/>
                                    <input type="radio" style="margin-right:8px;" value="2" id='radio1_<?php echo $q_id;?>' name='<?php echo $q_id; ?>'/><?php echo $Option2; ?>
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
                                
                                <?php } elseif ($i == 4) { ?>
                                <div id='question<?php echo $i; ?>' class='cont'>
                                    <p class='questions' id="qname<?php echo $i; ?>"><?php echo $i ?>.<?php $question; ?></p>
                                    <input type="radio" value="1" id='radio1_<?php echo $q_id;?>' name='<?php echo $q_id; ?>'/><?php echo $Option1; ?>
                                    <br/>
                                    <input type="radio" value="2" id='radio1_<?php echo $q_id;?>' name='<?php echo $q_id; ?>'/><?php echo $Option2; ?>
                                    <br/>
                                    <input type="radio" value="3" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option3; ?>
                                    <br/>
                                    <input type="radio" value="4" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/><?php echo $Option4; ?>
                                    <br/>
                                    <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $q_id; ?>' name='<?php echo $q_id; ?>'/>                                                                      
                                    <br/>
                                    <button id='<?php echo $i; ?>' class='previous btn btn btn-primary' type='button'>Previous</button>                    
                                    <button id='<?php echo $i; ?>' class='next btn btn btn-primary' type='button' >Next</button>
                                </div>                                
                                <?php } elseif ($i < 5 || $i < $q_id) { ?>
                                <div id='question<?php echo $i; ?>' class='cont'>
                                    <p class='questions' id="qname<?php echo $i; ?>"><?php echo $i ?>.<?php $question; ?></p>
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
                                    <button id='<?php echo $i; ?>' class='next btn btn btn-primary' type='submit'>Finish</button>
                                </div>
                               
                            <?php
                            } $i++;
                        }
                        ?>
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