<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title> ::Lead Management::</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico" />

    <!-- global css -->
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/app.css" />
    <!-- end of global css -->
    <!--page level css -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/swiper/css/swiper.min.css">
    <link href="<?= base_url() ?>assets/vendors/nvd3/css/nv.d3.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/lc_switch.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/custom.css">
    <link href="<?= base_url() ?>assets/css/custom_css/dashboard1.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/custom_css/dashboard1_timeline.css" rel="stylesheet" />
    <!--end of page level css-->
</head>

<body class="skin-default">
    <div class="preloader">
        <div class="loader_img"><img src="<?= base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
    </div>
    <!-- header logo: style can be found in header-->
    <?php include('includes/header.php');?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('includes/aside_left.php'); ?>
   <?php include('includes/aside_right.php'); ?>
            

            <section class="content">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="flip">
                            <div class="widget-bg-color-icon card-box front">
                                <div class="bg-icon float-left">
                                    <i class="ti-eye text-warning"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark"><b>3752</b></h3>
                                    <p>Daily Visits</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-bg-color-icon card-box back">
                                <div class="text-center">
                                    <span id="loadspark-chart"></span>
                                    <hr>
                                    <p>Check summary</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="flip">
                            <div class="widget-bg-color-icon card-box front">
                                <div class="bg-icon float-left">
                                    <i class="ti-shopping-cart text-success"></i>
                                </div>
                                <div class="text-right">
                                    <h3><b id="widget_count3">3251</b></h3>
                                    <p>Sales status</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-bg-color-icon card-box back">
                                <div class="text-center">
                                    <span class="linechart" id="salesspark-chart"></span>
                                    <hr>
                                    <p>Check summary</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="flip">
                            <div class="widget-bg-color-icon card-box front">
                                <div class="bg-icon float-left">
                                    <i class="ti-thumb-up text-danger"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark"><b>1532</b></h3>
                                    <p>Hits</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-bg-color-icon card-box back">
                                <div class="text-center">
                                    <span id="visitsspark-chart"></span>
                                    <hr>
                                    <p>Check summary</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="flip">
                            <div class="widget-bg-color-icon card-box front">
                                <div class="bg-icon float-left">
                                    <i class="ti-user text-info"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark"><b>1252</b></h3>
                                    <p>Subscribers</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-bg-color-icon card-box back">
                                <div class="text-center">
                                    <span id="subscribers-chart"></span>
                                    <hr>
                                    <p>Check summary</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <!--rightside bar -->
                <!--  -->
                <!-- /#right -->
                <div class="background-overlay"></div>
            </section>
            <!-- /.content -->
        </aside>
        <!-- /.right-side -->
    </div>
    <!-- ./wrapper -->
    <!-- global js -->
    <div id="qn"></div>
    <script src="<?= base_url() ?>assets/js/app.js" type="text/javascript"></script>
    <!-- end of global js -->

    <!-- begining of page level js -->
    <!--Sparkline Chart-->
    <script type="text/javascript" src="<?= base_url() ?>assets/js/custom_js/sparkline/jquery.flot.spline.js"></script>
    <!-- flip --->
    <script type="text/javascript" src="<?= base_url() ?>assets/js/flip.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/lc_switch.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/dashboard1.js"></script>
    <!-- end of page level js -->


</body>

</html>