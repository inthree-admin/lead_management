<!DOCTYPE html>
<html lang="">

<head>
   <meta charset="UTF-8">
   <title> ::Lead Management::</title>
   <meta content='width=device-width,user-scalable=no' name='viewport'>
   <link rel="shortcut icon" href="img/favicon.ico" />
   <!-- global css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/app.css" />
   <!-- end of global css -->
   <!--page level css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/iCheck/css/all.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/passtrength/passtrength.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/sweetalert2/css/sweetalert2.min.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/datatables/css/dataTables.bootstrap4.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom_css/toastr_notificatons.css">
   <link href="<?php echo base_url() ?>assets/css/custom_css/wizard.css" rel="stylesheet">
   <link href="<?php echo base_url() ?>assets/css/custom_css/runnerwizard.css" rel="stylesheet">
</head>

<body class="skin-default">
   <div class="preloader">
      <div class="loader_img"><img src="<?php echo base_url() ?>assets/img/loader.gif" alt="loading..." height="64" width="64"></div>
   </div>
   <!-- header logo: style can be found in header-->
   <?php include('includes/header.php');?>

   <div class="wrapper row-offcanvas row-offcanvas-left">
   <?php include('includes/aside_left.php'); ?>
   <?php include('includes/aside_right.php'); ?>
 
         <!--section ends-->
         <section class="content">
            <!--main content-->
            
            
            <div class="row">
               <div class="col-md-12 col-xl-12">
                  <div class="card ">
                     <div class="card-header">
                        <h3 class="card-title">
                           <i class="fa fa-fw ti-star"></i>New Lead
                        </h3>
                        <span class="float-right">
                           <i class="fa fa-fw ti-angle-up clickable"></i>
                           <i class="fa fa-fw ti-close removecard"></i>
                        </span>
                     </div>
                     <div class="card-body">
                        <form id="form-validation" action="javascript:void(0)" method="post" class="form-horizontal">
                           <h6 class="h6pnl_font"  style="margin-bottom: 15px;"><b>Customer Personal Details</b></h3>
                           <div class="form-group row">
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-firstname">
                                    First name
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter your First name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-lastname">
                                    Last name
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="val-lastname" name="lastname" class="form-control" placeholder="Enter your last name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="email">
                                    Email
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your valid email">
                                 </div>
                              </div>
                           </div>

                           <div class="form-group row">
                              <div class="col-md-4">
                                 <label class="form-control-label" for="phone">
                                    Mobile Number
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number">
                                 </div>
                              </div>
                               
                              <div class="col-md-4">
                                 <label class="form-control-label" for="phone">
                                    Alternate Number
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number">
                                 </div>
                              </div>
                           </div><br>

                           <h6 class="h6pnl_font" style="margin-bottom: 15px;"><b>Billing Details</b></h3>
                           <div class="form-group row">
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-firstname">
                                    Address1
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter your First name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-lastname">
                                    Address2
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="val-lastname" name="lastname" class="form-control" placeholder="Enter your last name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="email">
                                    Address3
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your valid email">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-firstname">
                                    State
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter your First name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-lastname">
                                    City
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="val-lastname" name="lastname" class="form-control" placeholder="Enter your last name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="email">
                                    Pin Code
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your valid email">
                                 </div>
                              </div>
                           </div><br>

                           <h6 class="h6pnl_font" style="margin-bottom: 15px;"><b>Shipping Details</b></h3>
                           <div class="form-group row">
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-firstname">
                                    Address1
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter your First name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-lastname">
                                    Address2
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="val-lastname" name="lastname" class="form-control" placeholder="Enter your last name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="email">
                                    Address3
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your valid email">
                                 </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-firstname">
                                    State
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter your First name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="val-lastname">
                                    City
                                    <span class="text-danger">*</span>
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="val-lastname" name="lastname" class="form-control" placeholder="Enter your last name">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <label class="form-control-label" for="email">
                                    Pin Code
                                 </label>
                                 <div class="input-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your valid email">
                                 </div>
                              </div>
                           </div>


                           <div class="form-group form-actions">
                              <div class="col-md-8 ml-auto">
                                 <button type="submit" class="btn btn-effect-ripple btn-primary">Submit</button>
                                 <button type="reset" class="btn btn-effect-ripple btn-default reset_btn">Reset
                                 </button>
                              </div>
                           </div>
                        </form>

                     </div>
                  </div>
               </div>
            </div>


         </section>
         <!-- /.content -->


      </aside>
      <!-- /.right-side -->
   </div>
   <!-- ./wrapper -->
   <!-- global js -->

   <!-- end of global js -->
   <script src="<?php echo base_url() ?>assets/js/app.js" type="text/javascript"></script>
   <!-- end of global js -->
   <!-- Push notify js -->
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/pnotify/js/pnotify.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/pnotify/js/pnotify.buttons.js"></script>

   <script src="<?php echo base_url() ?>assets/js/custom_js/notifications.js"></script>


   <!-- begining of page level js -->
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/bootstrap-maxlength/js/bootstrap-maxlength.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/card/jquery.card.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/iCheck/js/icheck.js"></script>
   <script src="<?php echo base_url() ?>assets/js/passtrength/passtrength.js"></script>

   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/jquery.dataTables.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/dataTables.bootstrap4.js"></script>

   <script src="<?php echo base_url() ?>assets/vendors/select2/js/select2.js" type="text/javascript"></script>
   <script src="<?php echo base_url() ?>assets/vendors/bootstrapwizard/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
   <script src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
   <script src="<?php echo base_url() ?>assets/js/custom_js/app/form_wizards.js" type="text/javascript"></script>
   <script src="<?php echo base_url() ?>assets/js/custom_js/app/runner.js" type="text/javascript"></script>

   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/user.js"></script>


   <!-- end of page level js -->
</body>

</html>