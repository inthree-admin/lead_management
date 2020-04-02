<!DOCTYPE html>
<html>
<head>
    <title>Reset Password | Clear Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- end of bootstrap -->
    <!--page level css -->
    <link href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet"/>
    <link href="css/login.css" rel="stylesheet">
    <!--end page level css-->
</head>

<body id="sign-in">
<div class="preloader">
    <div class="loader_img"><img src="img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-sm-8 col-10 m-auto login-form">
                <h2 class="text-center">
                    <img src="img/pages/clear_black.png" alt="Logo">
                </h2>
                <div class="row">
                    <div class="col-xl-12">
                        <h4 class="text-center marginTB">Reset Password</h4>
                    </div>
                    <div class="col-xl-12">
                        <form action="login.html" id="authentication" method="post" class="reset_validator">
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="password"
                                           name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="confirm-password"
                                           name="password_confirm" placeholder="Confirm Password">
                                </div>
                            <div class="col-12 text-center">
                            <div class="form-group">
                                <input type="submit" value="Reset Password" class="btn btn-primary center-block"/>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/popper.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<!-- end of global js -->
<!-- page level js -->
<script src="vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/custom_js/reset_password.js"></script>
<!-- end of page level js -->
</body>

</html>
