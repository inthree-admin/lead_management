<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Blank </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico"/>
    <!-- global css -->

    <link type="text/css" href="<?php echo base_url(); ?>assets/css/app.css" rel="stylesheet"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">

    <!-- end of global css -->
</head>

<body class="skin-default">
<div class="preloader">
    <div class="loader_img"><img src="<?php echo base_url(); ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
<!-- header logo: style can be found in header-->

<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">
                <div class="nav_profile">
                    <div class="media profile-left">
                        <a class="float-left profile-thumb" href="#">
                            <img src="<?= base_url(); ?>assets/img/authors/avatar1.jpg" class="rounded-circle" alt="User Image"></a>
                        <div class="content-profile">
                            <h4 class="media-heading">Addison</h4>
                            <ul class="icon-list">
                                <li>
                                    <a href="users.html" title="user">
                                        <i class="fa fa-fw ti-user"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url("home/lockscreen"); ?>" title="lock">
                                        <i class="fa fa-fw ti-lock"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="edit_user.html" title="settings">
                                        <i class="fa fa-fw ti-settings"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= site_url("home/login"); ?>" title="Login">
                                        <i class="fa fa-fw ti-shift-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                 <ul class="navigation">
                    <li class="active" id="active">
                        <a href="<?= site_url(); ?>">
                            <i class="menu-icon ti-desktop"></i>
                            <span class="mm-text ">Dashboard 1</span>
                        </a>
                    </li>

                    <li class="menu-dropdown">
                        <a href="javascript:void(0)">
                            <i class="menu-icon ti-face-smile"></i>
                            <span>Extra Pages</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?= site_url("home/pages"); ?>">
                                    <i class="fa fa-fw ti-file"></i> Blank
                                </a>
                            </li>
                            
                        </ul>
                    </li>

                </ul>
                <!-- / .navigation --> </div>
            <!-- menu --> </section>
        <!-- /.sidebar --> </aside>

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
