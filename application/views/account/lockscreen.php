<!DOCTYPE html>
<html>

<head>
    <title>:: Lockscreen ::</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico"/>
    <!-- Bootstrap -->
    <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet">
    <!-- styles -->
    <!--page level css -->
    <link href="<?= base_url() ?>assets/css/lockscreen.css" rel="stylesheet">
    <!--end page level css-->
</head>
<body>
<div class="preloader">
    <div class="loader_img"><img src="<?= base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
<div class="top">
    <div class="colors"></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-10 col-lg-6 col-sm-8 m-auto">
            <div class="lockscreen-container">
                <div id="output"></div>
                <img src="<?= base_url() ?>assets/img/logo_white.png" alt="Logo">
                <div class="form-box">
                    <div class="avatar"></div>
                    <form action="#" method="post">
                        <div class="form">
                            <div class="row">
                                <div class="col-12 text-center d-sm-none d-md-none d-lg-none d-xl-none">
                                <h4 class="user-name">Addision</h4>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="d-none d-sm-block" value="Addison" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="user" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <button class="btn login" id="index" type="submit">
                                <img src="<?= base_url() ?>assets/img/pages/arrow-right.png" alt="Go" width="30" height="30">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="<?= base_url() ?>assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/popper.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<!-- end of global js -->
<!-- page css -->
<script src="<?= base_url() ?>assets/js/lockscreen.js"></script>
<!-- end of page css -->
</body>

</html>