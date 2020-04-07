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
                        <i class="ti-layout-grid3"></i> Lead List
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
                                 <th>Receipt No</th>
                                 <th>Customer</th>
                                 <th>Phone</th>
                                 <th>Payment Link</th>
                                 <th>Payment Status</th>
                                 <th>Order Amount</th>
                                 <th>Created On</th>
                                 <th>Status</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                               

                           </tbody>
                        </table>
                     </div>
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
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/lead.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/jquery.dataTables.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/dataTables.bootstrap4.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script>
      "use strict";
      $(document).ready(function() {  
           
         leadList();
      });
      function leadList(){ 
          $('#tbl_list').DataTable().destroy();
          var table = $('#tbl_list').DataTable({
            "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+"lead/lead_list",
            "responsive": true,
            "order": [[ 7, "desc" ]],
            "columns": [
               { "width": "10%" },
               { "width": "30%" },
               { "width": "10%" },
               { "width": "2%" },
               { "width": "2%" },
               { "width": "5%" },
               { "width": "30%" },
               { "width": "2%" },
               { "width": "8%" },
            ],

         });
 
      }
      function cancelLead(lead_id){
          swal({
            title: "",
            text: "Are you sure want to cancel this order?",
            type: "info",
            confirmButtonClass: 'btn btn-info',
            confirmButtonText: 'Yes', 
            showCancelButton: true,
            cancelButtonColor: '#ff6666',
            cancelButtonText: 'No',
            cancelButtonClass: 'btn btn-danger'
         }).then(function (conrifm) {
         if(conrifm['value'] == true){
               $.ajax({
               type: "POST", 
               url: BASE_URL+"/lead/change_status",
               data: {
                  lead_id : lead_id,
                  status  : 2,
               }, 
               cache: false,
               timeout: 800000,
               success: function (data) { 
                  var result = JSON.parse(data);
                  if(result['success']){
                        swal({
                        title: "Success",
                        text:  result['msg'],
                        type: "success",
                        confirmButtonColor: "#66cc99"
                    }).then(function() {
                         leadList();
                    });
                  }
               },
               error: function (e) {     
               }
           });
         }            
           
        });
      }
   </script>
</body>

</html>