<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Blank | Clear Admin Template </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico" />
    <link type="text/css" href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">
</head>

<body class="skin-default">

    <?php $this->load->view('includes/header'); ?>
    <?php $this->load->view('includes/aside_right'); ?>
    <?php $this->load->view('includes/aside_left'); ?>

    <div class="preloader">
        <div class="loader_img"><img src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
    </div>

    <div>

    </div>


    <script src="<?= base_url() ?>assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/custom_js/sparkline/jquery.flot.spline.js"></script>
    <!-- flip --->
    <script type="text/javascript" src="<?= base_url() ?>assets/js/flip.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/lc_switch.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/dashboard1.js"></script>
    <!-- end of page level js -->

</body>

</html>