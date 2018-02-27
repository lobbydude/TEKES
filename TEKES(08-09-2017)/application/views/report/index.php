<?php
$emp_no = $this->session->userdata('username');
$user_role = $this->session->userdata('user_role');
?>

<script>
    function show_field() {
        var title = $("#report_title_list").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Report/fetch_field') ?>",
            data: "title=" + title,
            cache: false,
            success: function (html) {
                $("#fieldlist").html(html);
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
                            <h2>Reports</h2>
                        </div>
                    </div>
                </div>
                <br /><br />
                <form role="form" id="reports_form" name="reports_form" method="post" class="validate" action="<?php echo site_url('Report/download') ?>">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="birthdate">Title</label>
                                <select name="report_title_list" id="report_title_list" class="round" data-validate="required" data-message-required="Please select title." onchange="show_field()">
                                    <option value="">Please Select</option>
                                    <?php
                                    $this->db->where('Status', 1);
                                    $select_report_title = $this->db->get('tbl_report_title');
                                    foreach ($select_report_title->result() as $row_report_title) {
                                        $T_Id = $row_report_title->T_Id;
                                        $Title = $row_report_title->Title;
                                        $Table_Name = $row_report_title->Table_Name;
                                        ?>
                                        <option value="<?php echo $T_Id ?>"><?php echo $Title; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="birthdate">Type</label>
                                <select name="report_type" id="report_type" class="round" data-validate="required" data-message-required="Please select type.">
                                    <option value="">Please Select</option>
                                    <option value="All">All Employee</option>
                                    <option value="Active">Active Employee</option>
                                    <option value="Inactive">Inactive Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="birthdate">Period From</label>
                                <div class="input-group">
                                    <input type="text" name="period_from" id="period_from" class="form-control datepicker" data-format="dd-mm-yyyy">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="entypo-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="birthdate">Period To</label>
                                <div class="input-group">
                                    <input type="text" name="period_to" id="period_to" class="form-control datepicker" data-format="dd-mm-yyyy">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="entypo-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="fieldlist" style="margin-top:20px">

                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="panel-heading info-bar" >
                            <div class="panel-title">
                                <div class="col-md-offset-12" style="float:right">
                                    <button type="submit" class="btn btn-primary">Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>