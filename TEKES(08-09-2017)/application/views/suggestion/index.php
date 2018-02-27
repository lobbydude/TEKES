<?php
$emp_id = $this->session->userdata('username');
$suggestion_data = array(
    'Emp_Id' => $emp_id,
    'Status' => 1
);
$this->db->order_by('S_Id', 'desc');
$this->db->where($suggestion_data);
$q_suggestion = $this->db->get('tbl_suggestion');
?>

<script>
    function view_suggestion(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Suggestion/Viewsuggestion') ?>",
            data: "S_Id=" + id,
            cache: false,
            success: function (html) {
                $("#viewsuggestion_form").html(html);
            }
        });
    }
function delete_suggestion(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Suggestion/Deletesuggestion') ?>",
            data: "S_Id=" + id,
            cache: false,
            success: function (html) {
                $("#deletesuggestion_form").html(html);
            }
        });
    }
    $(document).ready(function () {
        $('#addsuggestion_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                add_feedback: $('#add_feedback').val()
            };
            $.ajax({
                url: "<?php echo site_url('Suggestion/add_suggestion') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    if (msg.trim() == "fail") {
                        $('#add_suggestion_error').show();
                    }
                    if (msg.trim() == "success") {
                        $('#add_suggestion_success').show();
                        location.reload();
                    }
                }
            });
        });
    });
</script>

<div class="main-content">
    <div class="container">
        <section class="topspace blackshadow bg-white"> 
            <div class="col-md-12">
                <div class="row">
                    <div class="panel-heading info-bar" >
                        <div class="panel-title">
                            <h2>Suggestions</h2>
                        </div>
                        <div class="panel-options">
                            <button class="btn btn-primary btn-icon icon-left" type="button" onclick="jQuery('#add_suggestion').modal('show', {backdrop: 'static'});">
                                Add Suggestion
                                <i class="entypo-plus-circled"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Suggestion Table Format Start Here -->

                    <table class="table table-bordered datatable" id="suggestion_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Suggestion Date</th>
                                <th>Employee</th>
                                <th>Suggestion Feedback</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
$i = 1;
foreach ($q_suggestion->result() as $row_suggestion) {
    $suggestion_id = $row_suggestion->S_Id;
    $feedback_message = $row_suggestion->Feedback;
    $Emp_Id = $row_suggestion->Emp_Id;
    $suggestion_date1 = $row_suggestion->Date;
    $suggestion_date = date("d-m-Y", strtotime($suggestion_date1));

    $this->db->where('Emp_Number', $Emp_Id);
    $q = $this->db->get('tbl_employee');
    foreach ($q->result() as $row) {
        $firstname = $row->Emp_FirstName;
        $lastname = $row->Emp_LastName;
        $middlename = $row->Emp_MiddleName;
    }

    $get_empcode = array(
        'employee_number' => $Emp_Id,
        'Status' => 1
    );
    $this->db->where($get_empcode);
    $q_empcode = $this->db->get('tbl_emp_code');
    foreach ($q_empcode->result() as $row_empcode) {
        $empcode = $row_empcode->employee_code;
    }
    ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $suggestion_date ?></td>
                                    <td><?php echo $firstname . " " . $lastname . " " . $middlename . "( " . $empcode . $Emp_Id . " )"; ?></td>
                                    <td><?php echo $feedback_message; ?></td>
                                    <td>
                                        <a data-toggle='modal' href='#view_suggestion' class="btn btn-default btn-sm btn-icon icon-left" onclick="view_suggestion('<?php echo $suggestion_id; ?>')">
                                            <i class="entypo-pencil"></i>
                                            View
                                        </a>
  <a data-toggle='modal' href='#delete_suggestion' class="btn btn-danger btn-sm btn-icon icon-left" onclick="delete_suggestion('<?php echo $suggestion_id; ?>')">
                                            <i class="entypo-cancel"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
    <?php
    $i++;
}
?>
                        </tbody>
                    </table>
                    <!-- Suggestion Table Format End Here -->
                </div>
            </div>
        </section>

        <!-- Add Suggestion Start Here-->
        <div class="modal fade" id="add_suggestion">
            <div class="modal-dialog" style="width:55%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">New Suggestion</h3>
                    </div>
                    <form role="form" id="addsuggestion_form" name="addsuggestion_form" method="post" class="validate" enctype="multipart/form-data" >
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div id="add_suggestion_server_error" class="alert alert-info" style="display:none;"></div>
                                    <div id="add_suggestion_success" class="alert alert-success" style="display:none;">suggestion box details added successfully.</div>
                                    <div id="add_suggestion_error" class="alert alert-danger" style="display:none;">Failed to add suggestion box details.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Enter Your Suggestion</label>                                        
                                        <textarea class="form-control" name="add_feedback" id="add_feedback" placeholder="Enter your Suggestion" data-validate="required" data-message-required="Please Enter Your Suggestion" ></textarea>
                                    </div>	
                                </div>
                            </div>                         
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Suggestion End Here-->

        <!-- View Suggestion Start Here -->
        <div class="modal fade custom-width" id="view_suggestion">
            <div class="modal-dialog" style="width:50%">
                <div class="modal-content">
                    <div class="modal-header info-bar">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">View Suggestion</h3>
                    </div>                 
                    <form role="form" id="viewsuggestion_form" name="viewsuggestion_form" method="post" class="validate">

                    </form>   
                </div>
            </div>
        </div>

        <!-- View Suggestion End Here -->

  <!-- Delete Suggestion Start Here -->

        <div class="modal fade" id="delete_suggestion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Delete Suggestion</h3>
                    </div>
                    <form role="form" id="deletesuggestion_form" name="deletesuggestion_form" method="post" class="validate">

                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Suggestion End Here -->

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
                tableContainer = $("#suggestion_table");

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

