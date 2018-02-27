<?php
$current_date = date("Y-m-d");
$employee_id = $this->session->userdata('username');
$this->db->order_by('Career_Id', 'desc');
$this->db->where('Status', 1);
$get_empdata = array(
    'Status' => 1,
    'Employee_Id' => $employee_id
);
$this->db->where($get_empdata);
$q_career = $this->db->get('tbl_employee_career');
foreach ($q_career->result() as $row_career) {
    $Department_id = $row_career->Department_Id;
}
?>
<script>
    function show_intro(test_id){
       $('#introduction').show();
       $('#send_kp_id').val(test_id);
    }
</script>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">
                            <h2>Process Knowledge Test</h2>
                        </div>
                        <div class="panel-options">
                            <button class=" btn-icon icon-left" type="button" style="font-size:18px; border: 1px solid #20526B; border-radius: 6px;">
                                Time <span id="time_duration"></span>
                                <i class="entypo-clock"></i>
                            </button>
                        </div>
                    </div><br/>

                    <!-- IPR KP Master Dashboard design Table Format Start Here -->
                    <form class="form-horizontal validate" role="form" id='addresult_form' method="post" action="<?php echo site_url('Ipr/Questions') ?> ">
                        <div class="row">
                            <div class="col-lg-offset-1 col-md-8">
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label for="field-1" class="control-label">Select Test</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="add_test_name" id="add_test_name" class="round" data-validate="required" data-message-required="Please Select Test Name." aria-required="true" aria-invalid="false" onchange="show_intro($(this).val())">
                                            <option value="">Select Knowledge Test</option>
                                            <?php
                                            $this->db->where('Status', 1);
                                            $q = $this->db->get('tbl_kpmaster');
                                            foreach ($q->result() as $row) {
                                                $Test_Id = $row->Kp_Id;
                                                $department_id = $row->Department_Id;
                                                $testname = $row->Test_Name;
                                                $enable_Date = $row->Enable_Date;
                                                if ($current_date == $enable_Date && $department_id == $Department_id) {
                                                    ?>
                                                    <option value="<?php echo $Test_Id; ?>"><?php echo $testname; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none" id="introduction">
                            <div class="question">                              
                                <h3 style="margin-left:30px;">General Instructions: Please read the below instructions carefully while appearing for the online test at TEKES.</h3>
                                <ul>
                                    <li>This Test 30 Question worth 1 point each</li>
                                    <li>Read the question and click your answer to see if you are correct</li>
                                    <li>Correct? Click the "Next question" Next button Continue</li>
                                    <li>Dout means? please "try again" Previous button Continue question again</li>
                                    <li>Click Finish button to exit and your score display</li>
                                    <li>This Questions No Negative Marks</li>                                                                                
                                </ul>
                                <div style="margin-bottom: 20px">
                                    <button class='next btn btn btn-primary' style="margin-left:84%;" type='submit'>Start</button>
                                </div>
                            </div>   
                        </div>
                        <input type="hidden" name="send_kp_id" id="send_kp_id" value="">
                    </form>                      
                    <!-- IPR KP Master Table Format End Here -->
                </div>
            </div>
        </section>