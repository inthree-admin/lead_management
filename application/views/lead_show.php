<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> ::Lead Management:: </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="img/favicon.ico" />

    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/app.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css">

    <!--end page level css-->
</head>
<script>
    var BASE_URL = "<?php echo base_url() ?>";
</script>

<body class="skin-default">
    <div class="preloader">
        <div class="loader_img"><img src="<?php echo base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
    </div>
    <!-- header logo: style can be found in header-->
    <?php include('includes/header.php'); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('includes/aside_left.php'); ?>
        <?php include('includes/aside_right.php'); ?>

        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content p-l-r-15" id="invoice-stmt">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-fw ti-credit-card"></i> Lead Details
                    </h3>
                    <span class="float-right">
                        <i class="fa fa-fw ti-angle-up clickable"></i>
                        <i class="fa fa-fw ti-close removecard"></i>
                    </span>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-12 col-lg-6 col-xl-6 invoice_bg"> 
                            <address> 
                                <br /><strong>Customer name:</strong> <?php echo (isset($lead_info['lead']['cust_name'])) ? ucfirst($lead_info['lead']['cust_name']) : ''; ?>
                                <br /><strong>Created on   :</strong> <?php echo (isset($lead_info['lead']['created_on'])) ? ucfirst($lead_info['lead']['created_on']) : ''; ?>
                                
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 col-lg-6 col-xl-6 invoice_bg text-right">
                            <div class="float-right"> 
                                <address> 
                                    <br /> <strong>Payment Type:</strong> <?php echo (isset($lead_info['lead']['payment_type'])) ? ucfirst($lead_info['lead']['payment_type']) : ''; ?>
                                    <br /> <strong>Payment Staus:</strong> <?php echo (isset($lead_info['lead']['payment_status'])) ? ucfirst($lead_info['lead']['payment_status']) : ''; ?>
                                </address>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-12 col-lg-6 col-xl-6 invoice_bg">

                            <h5 class="h4pnl_font"><strong>Billing Details:</strong></h5>
                            <address>

                                <br /> <?php echo (isset($lead_info['lead']['billing_address'])) ? ucfirst($lead_info['lead']['billing_address']) : ''; ?>
                                <br /> <?php echo (isset($lead_info['lead']['billing_city'])) ? ucfirst($lead_info['lead']['billing_city']) : ''; ?>
                                <br /> <?php echo (isset($lead_info['lead']['billing_pincode'])) ? ucfirst($lead_info['lead']['billing_pincode']) : ''; ?>
                                <br /> <strong>Phone:</strong> <?php echo (isset($lead_info['lead']['cust_phone'])) ? ucfirst($lead_info['lead']['cust_phone']) : ''; ?>
                                <br /> <strong>Mail Id:</strong> <?php echo (isset($lead_info['lead']['cust_email'])) ? ucfirst($lead_info['lead']['cust_email']) : ''; ?>
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12 col-lg-6 col-xl-6 invoice_bg text-right">
                            <div class="float-right">

                                <h5 class="h4pnl_font"><strong>Shipping Details:</strong></h5>
                                <address>

                                    <br /> <?php echo (isset($lead_info['lead']['shipping_address'])) ? ucfirst($lead_info['lead']['shipping_address']) : ''; ?>
                                    <br /> <?php echo (isset($lead_info['lead']['shipping_city'])) ? ucfirst($lead_info['lead']['shipping_city']) : ''; ?>
                                    <br /> <?php echo (isset($lead_info['lead']['shipping_pincode'])) ? ucfirst($lead_info['lead']['shipping_pincode']) : ''; ?>
                                    <br /> <strong>Phone:</strong> <?php echo (isset($lead_info['lead']['cust_phone'])) ? ucfirst($lead_info['lead']['cust_phone']) : ''; ?>
                                    <br /> <strong>Mail Id:</strong> <?php echo (isset($lead_info['lead']['cust_email'])) ? ucfirst($lead_info['lead']['cust_email']) : ''; ?>
                                </address>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed" id="customtable">
                                <thead>
                                    <tr class="bg-primary">
                                        <th><strong>S.no</strong></th>
                                        <th><strong>Product name</strong></th>
                                        <th class="text-center">Unit price</th>
                                        <th class="text-center"><strong>Quantity</strong></th>
                                        <th class="text-right"> <strong>Total</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($lead_info['lead_item']) and count($lead_info['lead_item']) > 0) {
                                        foreach ($lead_info['lead_item'] as $key => $item) {
                                            echo   '<tr> 
                                                    <td> ' . ($key + 1) . ' </td>
                                                    <td>' . $item['item_name'] . '</td>
                                                    <td class="text-center">' . $item['item_unit_price'] . '</td> 
                                                    <td class="text-center">' . $item['item_qty'] . '</td> 
                                                    <td class="text-right">' . $item['item_price'] . '</td>
                                                   </tr>';
                                        }
                                    } else {
                                        echo "<tr class='text-center'><td  colspan='5'> No item found</td></tr>";
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="emptyrow">
                                            <i class="livicon" data-name="barcode" data-size="60" data-loop="true"></i>
                                        </td>
                                        <td class="emptyrow text-center"></td>
                                        <td class="emptyrow text-center"></td>
                                        <td class="emptyrow text-right">
                                            <strong>
                                                Total:
                                            </strong>
                                        </td>
                                        <td class="highrow text-right">
                                            <i class="fa fa-inr"></i> <strong><?php echo (isset($lead_info['lead']['order_total'])) ? ucfirst($lead_info['lead']['order_total']) : '00.00'; ?></strong>
                                        </td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <!--rightside bar -->
            </div>
            <div class="background-overlay"></div>
        </section>
        <!-- /.content -->
        </aside>
        <!-- /.right-side -->
    </div>
    <!-- /.right-side -->
    <!-- ./wrapper -->
    <!-- global js -->
    <script src="<?php echo base_url() ?>assets/js/app.js" type="text/javascript"></script>
    <!-- end of global js -->
    <!-- page level js -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/invoice.js"></script>
    <!-- end of page level js -->
</body>

</html>