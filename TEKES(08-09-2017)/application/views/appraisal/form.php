<?php
$user_id = $this->session->userdata('username');
$this->db->where('Employee_Id', $user_id);
$q_career = $this->db->get('tbl_employee_career');
foreach ($q_career->Result() as $row_career) {
    $designation_id = $row_career->Designation_Id;
}

$app_form_data = array(
    'Designation' => $designation_id,
    'Status' => 1
);
$this->db->where($app_form_data);
$q_appraisalform = $this->db->get('tbl_appraisalform');
foreach ($q_appraisalform->Result() as $row_appraisalform) {
    $appraisal_form = $row_appraisalform->File;
}
$appraisal_cycle = $this->uri->segment(3);
if ($appraisal_cycle == "apr") {
    $appraisal_month = 4;
}
if ($appraisal_cycle == "oct") {
    $appraisal_month = 10;
}
?>
<script>
    function upload_appraisal(id) {
        $("#appraisal_form_id").val(id);
    }
</script>

<!-- Upload Appraisal File image Add Start here-->
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#upload_appraisal_form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('appraisal/upload_emp_appraisalform') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    if (data == "fail") {
                        $('#upload_appraisal_success').hide();
                        $('#upload_appraisal_error').show();
                    }
                    else {
                        $('#upload_appraisal_error').hide();
                        $('#upload_appraisal_success').show();
                        window.location.reload();
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });
</script>
<!-- Upload Appraisal File image Add End here-->


<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Appraisal</h2>
                        </div>
                    </div>
                    <!-- Appraisal Output design Table Format Start Here -->
                    <table class="table table-bordered datatable" id="appraisal_table">
                        <thead>
                            <tr>
                                <th style="width: 25px;">S.No</th>
                                <th>Appraisal Period</th>
                                <th>Last Date to Upload</th>                              
                                <th>Appraisal Form Download</th> 
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $app_data = array(
                                'Year' => date('Y'),
                                'Month' => $appraisal_month,
                                'Employee_Id' => $user_id,
                                'Status' => 1
                            );
                            $this->db->where($app_data);
                            $q_app = $this->db->get('tbl_appraisal');
                            $i = 1;
                            foreach ($q_app->Result() as $row_app) {
                                $A_Id = $row_app->A_Id;
                                $year = $row_app->Year;
                                $MonthName = date('F', mktime(0, 0, 0, $appraisal_month, 10));
                                $Visible_To_Employee1 = $row_app->Visible_To_Employee;
                                $Visible_To_Employee = date("d-m-Y", strtotime($Visible_To_Employee1));
								/*$Visible_To_Manager1 = $row_app->Visible_To_Manager;
                                $Visible_To_Manager = date("d-m-Y", strtotime($Visible_To_Manager1));*/
                                
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $MonthName . " " . $year; ?></td>    
                                    <td><?php echo $Visible_To_Employee; ?></td>
									<!--<td><?php //echo $Visible_To_Manager; ?></td>-->
                                    <td>
                                        <?php
                                        if ($appraisal_form != "") {
                                            ?>
                                            <a href="<?php echo site_url('appraisal_file/' . $appraisal_form) ?>" target="_blank">
                                                <img src="<?php echo site_url('images/word.png') ?>">                        
                                            </a>      
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a data-toggle='modal' href='#upload_appraisal' class="btn btn-default btn-sm btn-icon icon-left" onclick="upload_appraisal(<?php echo $A_Id; ?>)">
                                            <i class="entypo-upload"></i>
                                            Upload
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>                             
                        </tbody>                   
                    </table> 
                    <!-- Appraisal Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Upload Appraisal Form Start Here -->
        <div class="modal fade custom-width" id="upload_appraisal">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Upload Form</h3>
                    </div>
                    <form role="form" id="upload_appraisal_form" name="upload_appraisal_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="upload_appraisal_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="upload_appraisal_success" class="alert alert-success" style="display:none;">Appraisal form uploaded successfully.</div>
                                    <div id="upload_appraisal_error" class="alert alert-danger" style="display:none;">Failed to upload appraisal details.</div>
                                </div>
                            </div>
                            <input type="hidden" name="appraisal_form_id" id="appraisal_form_id" value="">
                            <div class="row" style="margin-bottom: 10px">                           
                                <div class="col-md-3">
                                    <label class="control-label">Upload Form</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="file" placeholder="Enter Message" data-validate="required" data-message-required="Please enter Message"  name="userfile" id="userfile" class="form-control file2 inline btn btn-primary" accept="image/*" data-label="<i class='glyphicon glyphicon-file'></i> Browse"/>                                    
                                </div>
                            </div>                                                   
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Upload Appraisal Form End Here -->
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
                tableContainer = $("#appraisal_table");
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