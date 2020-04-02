<!DOCTYPE html>
<html>
<head>
   
    <meta charset="UTF-8">
    <title>Clear Admin Template </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico"/>

    <!-- global css -->
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/app.css"/>
    <!-- end of global css -->
    <!--page level css -->
  
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/custom.css">

    <!--end of page level css-->
</head>
<body class="skin-default">
<div class="preloader">
    <div class="loader_img"><img src="<?= base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
</div>
<!-- header logo: style can be found in header-->
<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="index.php" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the marginin -->
            <img src="<?= base_url() ?>assets/img/logo_white.png" alt="logo"/>
        </a>
        <!-- Header Navbar: style can be found in header-->
        <!-- Sidebar toggle button-->
        <div class="mr-auto">
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                    class="fa fa-fw ti-menu"></i>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-fw ti-email black"></i>
                        <span class="badge badge-pill badge-success">2</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages table-striped">
                        <li class="dropdown-title">New Messages</li>
                       
                        <li class="dropdown-footer"><a href="#"> View All messages</a></li>
                    </ul>

                </li>
                <!--rightside toggle-->
                <li>
                    <a href="#" class="dropdown-toggle toggle-right" data-toggle="dropdown">
                        <i class="fa fa-fw ti-view-list black"></i>
                        <span class="badge badge-pill badge-danger">9</span>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown-->
                <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle padding-user d-block" data-toggle="dropdown">
                        <img src="<?= base_url() ?>assets/img/authors/avatar1.jpg" width="35" class="rounded-circle img-fluid float-left"
                             height="35" alt="User Image">
                        <div class="riot">
                            <div>
                                Addison
                                <span><i class="fa fa-sort-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= base_url() ?>assets/img/authors/avatar1.jpg" class="rounded-circle" alt="User Image">
                            <p> Addison</p>
                        </li>
                        <!-- Menu Body -->
                        <li class="p-t-3"><a href="user_profile.html" class="dropdown-item"> <i class="fa fa-fw ti-user"></i> My Profile </a>
                        </li>
                        <li role="presentation"></li>
                        <li><a href="edit_user.html" class="dropdown-item"><i class="fa fa-fw ti-settings"></i> Account Settings </a></li>
                        <li role="presentation" class="dropdown-divider"></li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="float-left">
                                <a href="<?= site_url("home/lockscreen"); ?>">
                                    <i class="fa fa-fw ti-lock"></i>
                                    Lock
                                </a>
                            </div>
                            <div class="float-right">
                                <a href="<?= site_url("home/login"); ?>">
                                    <i class="fa fa-fw ti-shift-right"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- ./wrapper -->
<!-- global js -->
<div id="qn"></div>
<script src="<?= base_url() ?>assets/js/app.js" type="text/javascript"></script>

</body>

</html>