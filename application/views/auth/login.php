<!DOCTYPE html>
<html>

<head>
    <title>::Lead Management Login::</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url() ?>assets/img/favicon.ico" />

    <!-- Bootstrap -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.css" rel="stylesheet">
    <!-- end of bootstrap -->

    <!--page level css -->
    <link type="text/css" href="<?php echo base_url() ?>assets/css/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/vendors/iCheck/css/all.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/login.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>assets/vendors/toastr/css/toastr_notificatons.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendors/toastr/css/toastr.min.css" rel="stylesheet" />
    <!--end page level css-->

</head>

<body id="sign-in">

    <div class="preloader">
        <div class="loader_img"><img src="<?php echo base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-10 col-sm-8 m-auto login-form">

                <h2 class="text-center logo_h2">
                    <img src="<?php echo base_url() ?>assets/img/logo.png" alt="Logo" width="250px;">
                </h2>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="login" id="authentication" method="post" class="login_validator">
                                <div class="form-group">
                                    <label for="username" class="sr-only"> E-mail</label>
                                    <input type="text" class="form-control  " id="username" name="username" placeholder="username">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group checkbox">
                                    <label for="remember">
                                        <input type="checkbox" name="remember" id="remember">&nbsp; Remember Me
                                    </label>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="signin" id="signin" value="Sign In" class="btn btn-primary btn-block" />
                                </div>
                                <a href="javascript:void(0);" id="forgot" class="forgot"> Forgot Password ? </a>

                                <span class="float-right sign-up">New ? <a href="javascript:void(0);">Sign Up</a></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- global js -->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/popper.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- end of global js -->

    <!-- page level js -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/iCheck/js/icheck.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/login.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/toastr/js/toastr.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendors/toastr/js/toastr_notifications.js"></script>
    <!-- end of page level js -->

    <?php
    if (validation_errors()) echo  validation_errors();
    if (isset($msg)) { ?>
        <script>
            Command: toastr["error"]("<?php echo $msg; ?>", "Warning!")
        </script>
    <?php } ?>

</body>

</html>