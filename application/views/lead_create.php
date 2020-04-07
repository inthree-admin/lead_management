<!DOCTYPE html>
<html lang="">

<head>
   <meta charset="UTF-8">
   <title> ::Lead Management:: </title>
   <meta content='width=device-width,user-scalable=no' name='viewport'>
   <link rel="shortcut icon" href="img/favicon.ico" />
   <!-- global css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/app.css" />

   <!-- end of global css -->
   <!--page level css -->
   <link href="<?php echo base_url() ?>assets/css/prettycheckable/css/prettyCheckable.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/iCheck/css/all.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/sweetalert2/css/sweetalert2.min.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom_css/sweet_alert2.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom_css/radio_checkbox.css">
   <style type="text/css">
      .plist_error {
         border-color: #ff0000;
      }
   </style>
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
                     <form id="form-validation" name="form-validation" enctype="multipart/form-data" action="javascript:void(0);" method="post" class="form-horizontal">
                        <input type="hidden" name="prod_price" id="prod_price">
                        <h6 class="h6pnl_font" style="margin-bottom: 15px;"><b>Customer Personal Details</b></h6>
                        <div class="form-group row">
                           <div class="col-md-4">
                              <label class="form-control-label" for="cust_name">
                                 Name
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="cust_name" name="cust_name" class="form-control" placeholder="Enter customer name">
                              </div>
                           </div>

                           <div class="col-md-4">
                              <label class="form-control-label" for="email">
                                 Email
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="email" name="email" class="form-control" placeholder="Enter customer email">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label class="form-control-label" for="mobile">
                                 Mobile Number
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter customer phone number">
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-4">
                              <label class="form-control-label" for="billing_address">
                                 Billing Address
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="billing_address" name="billing_address" class="form-control bill" placeholder="Door No / Apartment Name / Street">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label class="form-control-label" for="billing_city">
                                 City
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="billing_city" name="billing_city" class="form-control bill" placeholder="Billing City">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label class="form-control-label" for="billing_pincode">
                                 Pin Code
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="billing_pincode" name="billing_pincode" class="form-control bill" placeholder="Billing pincode" required>
                              </div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-4">
                              <label class="form-control-label" for="billing_contact_no">
                                 Contact Number
                              </label>
                              <div class="input-group">
                                 <input type="text" id="billing_contact_no" name="billing_contact_no" class="form-control bill" placeholder="Billing Contact Number">
                              </div>
                           </div>

                        </div><br>

                        <h6 class="h6pnl_font" style="margin-bottom: 15px;"><b>Shipping Details</b></h6>
                        <label class="padding7" for="terms" style="margin-bottom: 5px;">
                           <input type="checkbox" class="custom_icheck icheckbox_minimal-blue" id="chk_copy_address" onclick="is_check(this);">&nbsp;&nbsp;<label for="chk_copy_address">Same as billing details</label>
                        </label>
                        <div class="form-group row">
                           <div class="col-md-4">
                              <label class="form-control-label" for="shipping_address">
                                 Shipping Address
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="shipping_address" name="shipping_address" class="form-control" placeholder="Door No / Apartment Name / Street">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label class="form-control-label" for="shipping_city">
                                 City
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="shipping_city" name="shipping_city" class="form-control" placeholder="Shipping City">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label class="form-control-label" for="shipping_pincode">
                                 Pin Codes
                                 <span class="text-danger">*</span>
                              </label>
                              <div class="input-group">
                                 <input type="text" id="shipping_pincode" name="shipping_pincode" class="form-control" placeholder="Shipping Pincode">
                              </div>
                           </div>
                        </div>

                        <div class="form-group row">
                           <div class="col-md-4">
                              <label class="form-control-label" for="shipping_contact_no">
                                 Contact Number
                              </label>
                              <div class="input-group">
                                 <input type="text" id="shipping_contact_no" name="shipping_contact_no" class="form-control" placeholder="Shipping Contact Number">
                              </div>
                           </div>
                        </div><br>

                        <h6 class="h6pnl_font" style="margin-bottom: 15px;"><b>Payment & Product Details</b></h6>
                     

                        <div class="form-group has-pretty-child">
                           <label class="test_radio">Payment Type <span class="text-danger">*</span></label>                         
                           <div class="clearfix prettyradio labelright margin-right blue">
                              <input type="radio" class="" value="1" id="prepaid" name="payment_type" checked="checked" style="display: none;">
                              <a href="javascript:void(0);" onclick="choosePaymode(this);" class='checked' id='prepaid_a'></a>
                              <label for="prepaid">Prepaid</label></div>
                           <div class="clearfix prettyradio labelright  blue">
                              <input type="radio" class="" value="2" id="cod" name="payment_type" style="display: none;">
                              <a href="javascript:void(0);" onclick="choosePaymode(this);" id='cod_a'></a>
                              <label for="cod">COD</label></div>
                        </div>




                        <div class="form-group row">
                           <div class="col-md-9">
                              <div class="table-responsive product_list">
                                 <table class=" table table-striped table-bordered" id="plist" style="cursor: pointer;">
                                    <thead>
                                       <tr>
                                          <th width="2%">S.no</th>
                                          <th width="50%">Product</th>
                                          <th width="20%">Qty</th>
                                          <th width="20%">Total</th>
                                          <th width="8%"> </th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>1</td>
                                          <td>
                                             <select tabindex="1" class="form-control" id="inp_product" name="product[]" class="form-control has-error" onchange="appendRow();" required>
                                                <option value="">-Select-</option>
                                             </select>
                                          </td>
                                          <td><input class="form-control" type="number" value="1" onchange="totalCalc();" onkeyup="totalCalc();" max="10000" min="1" name="quantity[]" required></td>
                                          <td style="text-align: right;">00.00</td>
                                          <td> <a href="javascript:void(0);" onclick="deleteRow(this);" class="btn btn-danger btn-xs delrow"><i class="fa fa-trash"></i></a></td>
                                       </tr>

                                    </tbody>
                                 </table>




                              </div>
                           </div>
                        </div>




                        <div class="form-group row">

                           <div class="col-3">

                           </div>
                           <div class="col-sm-3">

                           </div>
                           <div class="col-sm-3">
                              <div class="alert alert-info  m-t-10" style="font-weight: bold;font-size: 20px;">
                                 Total : <i class="fa fa-inr"></i> <span id='total_amount'>00.00</span>
                              </div>
                           </div>
                           <div class="col-sm-3">

                           </div>

                        </div>

                        <div class="form-group form-actions">
                           <div class="col-md-8 ml-auto">
                              <button type="submit" class="btn btn-effect-ripple btn-primary" id="btn_submit">Submit</button>
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
   <script src="<?php echo base_url() ?>assets/js/app.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/sweetalert.js"></script>
   <script src="<?php echo base_url() ?>assets/vendors/select2/js/select2.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/iCheck/js/icheck.js"></script>
   <script src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/lead.js"></script>
   <script lang="javascript" type="text/javascript">
      $(document).ready(function() {
         $('select').on('change', function() {
            var prod_price = $(this).find(':selected').attr('data-price');
            $('#prod_price').val(prod_price);
         });

      });

      function choosePaymode(e) {
         $('#prepaid').prop('checked', '');
         $('#cod').prop('checked', '');
         $('#prepaid_a').attr('class', '');
         $('#cod_a').attr('class', '');
         if ($(e).attr('id') == 'prepaid_a') {
            $(e).attr('class', 'checked');
            $('#prepaid').prop('checked', 'checked');
         }
         if ($(e).attr('id') == 'cod_a') {
            $(e).attr('class', 'checked');
            $('#cod').prop('checked', 'checked');
         }
      }
   </script>
</body>

</html>