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
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/datatables/css/dataTables.bootstrap4.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom_css/datatables_custom.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/sweetalert2/css/sweetalert2.min.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom_css/sweet_alert2.css">
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
            <div class="col-lg-12">
               <div class="card ">
                  <div class="card-header">
                     <h3 class="card-title">
                        <i class="ti-layout-grid3"></i> Delivery Proof
                     </h3>
                     <span class="float-right">
                        <i class="fa fa-fw ti-angle-up clickable"></i>
                        <i class="fa fa-fw ti-close removecard"></i>
                     </span>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">

                      
                        <table class="table table-striped table-bordered table-hover" id="tbl_list" style="width:100%">
                           <thead style="text-align: center;">
                              <tr>
                                 <th>Reference</th>
                                 <th>Order Id#</th> 
                                 <th>Delivery Date</th> 
                                 <th>Delivery Proof</th>
                                 <th>Invoice Proof</th>
                                 <th>Address Proof</th>
                                 <th>Sign Proof</th>
                              </tr>
                           </thead>
                           <tbody  style="text-align: center;">


                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>

        

      </section>
       <div id="center_modal" class="modal fade animated position_modal" role="dialog" style="display: none;" aria-hidden="true">
         <div class="modal-dialog  modal-lg">
            <div class="modal-content">

               <div class="modal-body">
                  <img id="lrg_proof" src="<?php  echo base_url() .'assets/img/no_image.png'; ?>" class="img-thumbnail" alt="">
               </div>

            </div>
         </div>
      </div>
      </aside>
      <!-- /.right-side -->
   </div>
   <!-- ./wrapper -->
   <script src="<?php echo base_url() ?>assets/js/app.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/sweetalert.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/lead.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/jquery.dataTables.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/dataTables.bootstrap4.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script>
      "use strict";
      $(document).ready(function() {

         proofList();
      });

      function proofList() {
         $('#tbl_list').DataTable().destroy();
         var table = $('#tbl_list').DataTable({
            "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL + "proof/delivery_proof_list",
            "responsive": true,
            "order": [
               [5, "desc"]
            ],
            "columns": [ 
            {
                "data": "reference",
                "width": "15%"
            },
            {
                "data": "orderid",
                "width": "10%"
            }, 
            {
                "data": "created_at",
                "width": "10%"
            },
            {
                "data": "delivery_proof",
                "width": "5%"
            },
            {
                "data": "invoice_proof",
                "width": "5%"
            },

            {
                "data": "address_proof",
                "width": "5%"
            },
            {
                "data": "sign_proof",
                "width": "5%"
            },


        ],
             
            "columnDefs": [{
               "targets": [0,1,2,3,4,5,6],
               "orderable": true
            }],

         });

      }

      
 function showImage(src) {
         $('#lrg_proof').attr('src', src);
         $('#center_modal').modal('show');
      }
      
   </script>
</body>

</html>