<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title> ::Lead Management::</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/favicon.ico" />

    <!-- global css -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css" />
    <!-- end of global css -->
    <!--page level css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/vendors/swiper/css/swiper.min.css">
    <link href="<?php echo base_url() ?>assets/vendors/nvd3/css/nv.d3.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/lc_switch.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css">
    <link href="<?php echo base_url() ?>assets/css/custom_css/dashboard1.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/css/custom_css/dashboard1_timeline.css" rel="stylesheet" />
    <!--end of page level css-->
</head>

<body class="skin-default">
    <div class="preloader">
        <div class="loader_img"><img src="<?php echo base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
    </div>
    <!-- header logo: style can be found in header-->
    <?php include('includes/header.php');?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('includes/aside_left.php'); ?>
        <aside class="right-side">

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Dashboard</h1>
</section>
            

            <section class="content">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-xl-3">
                        <div class="flip">
                            <div class="widget-bg-color-icon card-box front">
                                <div class="bg-icon float-left">
                                    <i class="ti-eye text-warning"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark"><b><?php echo $lead_open_count;?></b></h3>
                                    <p>Open Leads</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-bg-color-icon card-box back">
                            <div class="bg-icon float-left">
                                    <i class="ti-shopping-cart text-success"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark"><b><?php echo $lead_cancel_count;?></b></h3>
                                    <p>Cancel Leads</p>
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
                                    <h3 class="text-dark"><b><?php echo $order_total;?></b></h3>
                                    <p>Orders</p>
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
                                    <i class="ti-shopping-cart text-success"></i>
                                </div>
                                <div class="text-right">
                                    <h3><b id="widget_count3"><?php echo $sales_total;?></b></h3>
                                    <p>Sales</p>
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
                                    <i class="ti-user text-info"></i>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-dark"><b><?php echo $customer_count;?></b></h3>
                                    <p>Customers</p>
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
    <script src="<?php echo base_url() ?>assets/js/app.js" type="text/javascript"></script>
    <!-- end of global js -->

    <!-- begining of page level js -->
    <!--Sparkline Chart-->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/sparkline/jquery.flot.spline.js"></script>
    <!-- flip --->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/flip.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/lc_switch.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/dashboard1.js"></script>
    <!-- end of page level js -->


</body>

</html>