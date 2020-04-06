<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <!-- global level css -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet">
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="css/404.css" rel="stylesheet">
    <!-- end of page level styles-->
    <style>

    </style>
</head>
<body>
<!-- <div class="preloader">
    <div class="loader_img ml-auto"><img src="<?php echo base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div> -->
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 m-auto">
            <div class="text-center">
                    <p><h2>Awesome!</h2></p>
                    <p>Your order has been placed successfully.</p>
                    <div class="error_img">
                        <img src="<?php echo base_url() ?>assets/img/success.png" alt="Payment Success">
                    </div>
                    <hr class="seperator">
                    <p>Your order number is : <?php echo $ref_no; ?></p>
                    <p>We will keep update your order details through SMS and Email.</p>
                    <p>For more details call Toll Free No: 1800 102 1271</p>
                    <p> <img src="<?php echo base_url() ?>assets/img/logo.png" alt="logo" width="250px" /></p>
                    
                            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="<?php echo base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- end of global js -->
<script type="text/javascript">
    //=================Preloader===========//
    $(document).on('ready', function () {
        // $('.preloader img').fadeOut();
        // $('.preloader').fadeOut();
    });
    //=================end of Preloader===========//
</script>
</body>

</html>

