<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password | Clear Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico"/>
    <!-- Bootstrap -->
    <!-- global level css -->
    <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>assets/css/themify-icons/css/themify-icons.css" rel="stylesheet" type="text/css"/>
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="<?= base_url() ?>assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet"/>
    <link href="<?= base_url() ?>assets/css/forgot_password.css" rel="stylesheet">
    <!-- end of page level styles-->
</head>

<body>
<div class="preloader">
    <div class="loader_img"><img src="<?= base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-10 col-sm-6 m-auto  box animated fadeInUp">
            <div class="text-center"><img src="<?= base_url() ?>assets/img/logo_white.png" alt="Clear logo"></div>
            <h3 class="text-center h3pnl_font">Forgot Password
            </h3>
            <p class="text-center enter_email">
                Enter your Registered email
            </p>
            <p class="text-center check_email hidden">
                Check your email for Reset link
                <br><br>
                <u><a href="javascript:void(0)" class="reset-link">Resend the link</a></u>
            </p>
            <form action="<?= site_url("home/forgotpass"); ?>" class="forgot_Form text-center" method="POST" id="forgot_password">
                <div class="form-group">
                    <input type="email" class="form-control email" name="email" id="email" placeholder="Email">
                </div>
                <button type="submit" value="Reset Your Password" class="btn submit-btn">
                    Retrieve Password
                </button>
            </form>
        </div>
    </div>
</div>
<!-- page level js -->

<script src="<?= base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/custom_js/forgot_password.js" type="text/javascript"></script>
<!-- end of page level js -->
</body>

</html>
