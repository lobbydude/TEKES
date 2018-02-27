<?php
$employee_id = $this->session->userdata('username');
$Kp_Id = $_POST['Kp_Id'];
$right_answer = 0;
$wrong_answer = 0;
$unanswered = 0;

$keys = array_keys($_POST);
$order = join(",", $keys);

$response = mysql_query("select Q_Id,Answer from tbl_kpquestions where Q_Id IN($order) ORDER BY FIELD(Q_Id,$order)") or die(mysql_error());
while ($result = mysql_fetch_array($response)) {
    if ($result['Answer'] == $_POST[$result['Q_Id']]) {
        $right_answer++;
    } else if ($_POST[$result['Q_Id']] == 5) {
        $unanswered++;
    } else {
        $wrong_answer++;
    }
}
mysql_query("update tbl_kpemployee set Score='$right_answer',Wrong_Ans='$wrong_answer',Unanswer='$unanswered' where Employee_Id='$employee_id' AND Kp_Id='$Kp_Id'");
?>
<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar">
                        <div class="panel-title">
                            <h2>General Question</h2>
                        </div>
                    </div><br/>

                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div style="margin-left: 1%">
                                <h4>Total no. of right answers : <span class="answer"><?php echo $right_answer; ?></span></h4>
                                <h4>Total no. of wrong answers : <span class="answer"><?php echo $wrong_answer; ?></span></h4>
                                <h4>Total no. of Unanswered Questions : <span class="answer"><?php echo $unanswered; ?></span></h4>                   
                            </div> 
                        </div>
                    </div>    
                </div>
            </div>
        </section>
    </div>
</div>
     