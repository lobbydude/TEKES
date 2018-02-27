
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-2"></div>                           
                <div class="col-sm-2">
                    <img src="<?php echo site_url('images/drn.png'); ?>"> 
                </div>
                <div class="col-sm-5" style="margin-left:-60px;margin-top:27px">
                    <h3>DRN DEFINITE SOLUTIONS PVT LTD</h3>
                    <p>
                        No. 16, Lakshya Towers, 4th Floor, 5th Block, Koramangala<br>
                        Bangalore, Karnataka, India Pin - 560 095.<br> 
                        Tel: 080 65691240 , Email : accounts@drnds.com
                    </p>
                    <h4><b>Employee IPR for the month of June 2016</b></h4>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-3" style="margin-left:-60px;margin-top:45px">
		<?php //if ($user_role == 2 || $user_role == 6) { ?>
                    <a href="<?php //echo site_url('Payslip/Editpayslip/' . $Payslip_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                    <a data-toggle='modal' href='#' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_Payslip(<?php //echo $Payslip_Id; ?>)">
                        <i class="entypo-cancel"></i>
                        Delete
                    </a>
				<?php// } ?>
                    <a target="_blank" href="<?php //echo site_url('stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Pay slip.mrt&param1=' . $Payslip_Id) ?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-print"></i>
                        Print
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2 style="text-align: center;">Employee Performance Report</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Actuals</th>
                            <th>Efficiency </th>
                            <th>Accuracy </th>
                            <th>Punctuality </th>
                            <th>Overall Score </th>
                            <th>Process Knowledge </th>
                            <th>Final Rating </th>
                            <th>Team Work & Trainability </th>                          
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>55%</td>
                            <td>2.5</td>
                            <td>100% / 5</td>
                            <td>2 / 3</td>
                            <td>65</td>
                            <td>2</td>
                            <td>3.25</td>
                            <td>3</td>
                        </tr>
                        
                        <tr>
                            <td><a href="#"><i class="btn btn-blue">Actuals</i> 55%</a></td>
                            <td><a href="#"><i class="btn btn-red">Efficiency</i>2.5</a></td>
                            <td><a href="#"><i class="btn btn-black">Accuracy</i>100% / 5</a></td>
                            <td><a href="#"><i class="btn btn-success">Punctuality</i>2 / 3</a></td>
                            <td><a href="#"><i class="btn" style="background-color: #00FFFF">Overall Score</i>65%</a></td>
                            <td><a href="#"><i class="btn" style="background-color: #BF00FF;color:#fff">Process Knowledge</i> 2</a></td>
                            <td><a href="#"><i class="btn" style="background-color: #58FAD0;color:#000">Final Rating</i> 3.25</a></td>
                            <td><a href="#"><i class="btn btn-blue">Team Work & Trainability</i> 3</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>   
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">                                                      
                    
                    <tbody>                                
                        <tr>
                            <td><b>Name of the Employee :</b></td>
                            <td>William</td>
                            <td><b>Employee Code : </b></td>
                            <td>DRN/0195</td>                                                                                                                                </tr>
                        <tr>
                            <td><b>Month: </b></td>
                            <td>Jun 2017</td>
                            <td><b>Date of Joining :</b></td>
                            <td>24-May-2016 </td>                                                                        
                        </tr>                                                            
                    </tbody>
                </table>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Performance</th>
                    <th>Rating</th>                                
                    <th>Supporting score if any</th>
                    <th>Comments</th>                               
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Efficiency</td>
                    <td>2.5</td>
                    <td>Efficiency: 55% <br>Total Orders: 492</td>
                    <td><textarea rows="2" cols="80" placeholder="Comments"></textarea></td>                                                                        
                </tr>
                <tr>
                    <td>Accuracy</td>
                    <td>4</td>
                    <td>99.80%<br>Internal: 0<br>External: 1</td> 
                    <td><textarea rows="2" cols="80" placeholder="Comments"></textarea></td>                                                                        
                </tr>                
               <tr>
                    <td>Punctuality & Discipline</td>
                    <td>2</td>
                    <td>Present: 21<br>Leave: 4<br>LOP: 0</td> 
                    <td><textarea rows="2" cols="80" placeholder="Comments"></textarea></td>                                                                        
                </tr>
                <tr>
                    <td>Process Knowledge</td>
                    <td>3</td>
                    <td> </td> 
                    <td><textarea rows="2" cols="80" placeholder="Comments"></textarea></td>                                                                        
                </tr>
                <tr>
                    <td>Team Work & Flexibility</td>
                    <td>4</td>
                    <td>Week End Login: 2</td> 
                    <td><textarea rows="2" cols="80" placeholder="Comments"></textarea></td>                                                                        
                </tr>
                <tr>
                    <td><b>Overall Score :</b></td>
                    <td><b>17.5</b></td>
                    <td><b>Final Rating : 3.15 </b></td>
                    <td></td>
                </tr>                                                    
            </tbody>                         
        </table>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>                              
                        <tr>
                            <td><b>Comments from Supervisor : </b></td>
                            <td><textarea rows="2" cols="50" placeholder="Comments"></textarea></td>                                                                                                  
                        </tr>
                        <tr>
                            <td><b>Employee Signature :</b></td>
                            <td><b>Date</b></td>
                            <td><b>Reviewer’s Signature: </b></td>
                            <td><b>Date</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Delete Payslip Start Here -->

        <div class="modal fade" id="delete_payslip">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Payslip</h3>
                    </div>
                    <form role="form" id="deletepayslip_form" name="deletepayslip_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>
        <script>
            function delete_Payslip(id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Payslip/Deletepayslip') ?>",
                    data: "payslip_id=" + id,
                    cache: false,
                    success: function (html) {
                        $("#deletepayslip_form").html(html);
                    }
                });
            }
        </script>

        <!-- Delete Payslip End Here -->
    <?php
    //} else {
        ?>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-8">
                <!--<p>No Records Found.</p>-->
            </div>
        </div>
        <?php
    //}
//} else {
    ?>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
           <!-- <p>No Records Found.</p>-->
        </div>
    </div>
<?php //} ?>

