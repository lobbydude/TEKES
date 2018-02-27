<?php
$emp_no = $this->session->userdata('username');
?>
<script>
    $(document).ready(function () {
        $('#payslip_form').submit(function (e) {
            e.preventDefault();
            var formdata = {
                employee_list:$('#employee_list').val(),
                year_list: $('#year_list').val(),
                month_list: $('#month_list').val()
            };
            $.ajax({
                url: "<?php echo site_url('Ipr1/Emp_Iprpreview') ?>",
                type: 'post',
                data: formdata,
                success: function (msg) {
                    $('#employee_payslip').html(msg);
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
                            <h2>IPR Employee View Download</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <br /><br />
                    <div class="col-md-1"></div>
                    <form role="form" id="payslip_form" name="payslip_form" method="post" class="validate">
                        <div class="col-md-8">
                            <div class="col-md-4">
                                <input type="hidden" name="employee_list" id="employee_list" value="<?php echo $emp_no ?>">
                            </div>
                            <div class="col-md-3">
                                <?php
                                define('DOB_YEAR_START', 2000);
                                $current_year = date('Y');
                                ?>
                                <select id="year_list" name="year_list" class="round">
                                    <?php
                                    for ($count = $current_year; $count >= DOB_YEAR_START; $count--) {
                                        echo "<option value='{$count}'>{$count}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="round" id="month_list" name="month_list">
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                         $current_month = date('m');
                                        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
                                        ?>
                                       <option value="<?php echo $m; ?>" <?php if($current_month==$m){echo "selected=selected";}?>><?php echo $month; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Preview</button>
                        </div>
                    </form>
                    <br /><br /> <br /><br />
                    <div id="employee_payslip"></div>
                </div>
            </div>
        </section>
