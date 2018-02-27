<style>
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        src: local('Lato Regular'), local('Lato-Regular'), url(<?php echo site_url('fonts/lato/1YwB1sO8YE1Lyjf12WNiUA.woff2')?>) format('woff2');
    }
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        src: local('Lato Bold'), local('Lato-Bold'), url(<?php echo site_url('fonts/lato/H2DMvhDLycM56KNuAtbJYA.woff2')?> format('woff2');
    }
</style>
<link rel="stylesheet" href="<?php echo site_url('js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('css/font-icons/entypo/css/entypo.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('css/neon-core.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('css/neon-theme.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('css/neon-forms.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('css/custom.css') ?>">

<script src="<?php echo site_url('js/jquery-1.11.0.min.js') ?>"></script>
<script>$.noConflict();</script>

<script src="<?php // echo site_url('js/bootstrap.min.js') ?>"></script>

<script src="<?php echo site_url('js/jquery-ui/js/jquery-1.9.1.js') ?>"></script>
<script src="<?php echo site_url('js/jquery-ui/js/jquery.min.js') ?>"></script>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo site_url('js/jvectormap/jquery-jvectormap-1.2.2.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('js/rickshaw/rickshaw.min.css') ?>">

<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo site_url('js/datatables/responsive/css/datatables.responsive.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('js/select2/select2-bootstrap.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('js/select2/select2.css') ?>">

<!-- Bottom scripts (common) -->
<script src="<?php echo site_url('js/gsap/main-gsap.js') ?>"></script>
<script src="<?php echo site_url('js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') ?>"></script>
<script src="<?php echo site_url('js/bootstrap.js') ?>"></script>
<script src="<?php echo site_url('js/joinable.js') ?>"></script>
<script src="<?php echo site_url('js/resizeable.js') ?>"></script>
<script src="<?php echo site_url('js/neon-api.js') ?>"></script>
<script src="<?php echo site_url('js/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>"></script>

<!-- Table Script Start Here -->
<script src="<?php echo site_url('js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo site_url('js/dataTables.bootstrap.js') ?>"></script>
<script src="<?php echo site_url('js/datatables/jquery.dataTables.columnFilter.js') ?>"></script>
<script src="<?php echo site_url('js/datatables/lodash.min.js') ?>"></script>
<script src="<?php echo site_url('js/datatables/responsive/js/datatables.responsive.js') ?>"></script>
<!-- Table Script End Here -->

<!-- JavaScripts initializations and stuff -->
<script src="<?php echo site_url('js/neon-custom.js') ?>"></script>

<!-- Dropdown Script Start Here -->

<link rel="stylesheet" href="<?php echo site_url('js/selectboxit/jquery.selectBoxIt.css') ?>">
<script src="<?php echo site_url('js/select2/select2.min.js') ?>"></script>

<!-- Validation Start Here -->
<script src="<?php echo site_url('js/jquery.validate.min.js') ?>"></script>

<!-- form wizard -->
<script src="<?php echo site_url('js/jquery.bootstrap.wizard.min.js') ?>"></script>
<script src="<?php echo site_url('js/jquery.inputmask.bundle.min.js') ?>"></script>
<script src="<?php echo site_url('js/selectboxit/jquery.selectBoxIt.min.js') ?>"></script>

<!-- Checkbox design Start here -->
<script src="<?php echo site_url('js/bootstrap-switch.min.js') ?>"></script>

<!-- Demo Settings -->
<script src="<?php echo site_url('js/neon-demo.js') ?>"></script>
<script src="<?php // echo site_url('js/custom.js') ?>"></script>

<!-- Browse file style -->
<script src="<?php echo site_url('js/fileinput.js') ?>"></script>

<!-- Date Picker -->
<link rel="stylesheet" href="<?php echo site_url('js/daterangepicker/daterangepicker-bs3.css') ?>">
<script src="<?php echo site_url('js/bootstrap-datepicker.js') ?>"></script>

 <script src="<?php echo site_url('js/bootstrap-timepicker.min.js') ?>"></script>

<script>
$(document).ready(function(){
    $(document).ajaxStart(function(){
        $(".loading").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $(".loading").css("display", "none");
    });
});
</script>
