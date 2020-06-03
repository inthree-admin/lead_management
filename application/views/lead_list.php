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
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/jquerydaterangepicker/css/daterangepicker.min.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/datepicker.css">
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
            <div class="col-md-12">
               <div class="card mrgn_top">
                  <div class="card-header txt_padding">
                     <h3 class="card-title">
                        <i class="fa fa-fw ti-pencil"></i> Lead List
                     </h3>
                     <span class="float-right d-none d-sm-block fnt_size txt_font">
                        <i class="fa fa-fw ti-angle-up clickable"></i>
                        <i class="fa fa-fw ti-close removecard"></i>
                     </span>
                  </div>
                  <?php
                  $today      = date('Y-m-d');
                  $datetime   = new DateTime($today);
                  $datetime->modify('-1 day');
                  $from_date   = $datetime->format('Y-m-d');
                  $to_date     = $today;

                  ?>
                  <div class="card-body">
                     <form id="search_form" method="get">
                        <div class="row">

                           <div class="col-3">
                              <div class="form-group">

                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-fw ti-calendar"></i>
                                    </div>
                                    <input class="form-control" id="from_date" size="40" placeholder="From date" value="<?php echo $from_date; ?>">
                                 </div>
                                 <!-- /.input group -->
                              </div>
                           </div>
                           <div class="col-3">
                              <div class="form-group">

                                 <div class="input-group">
                                    <div class="input-group-addon">
                                       <i class="fa fa-fw ti-calendar"></i>
                                    </div>
                                    <input class="form-control" id="to_date" size="40" placeholder="To date" value="<?php echo $to_date; ?>">
                                 </div>
                                 <!-- /.input group -->
                              </div>
                           </div>
                           <div class="col-5">

                              <button type="button" class="btn btn-effect-ripple btn-primary" onclick="leadList();">
                                 Search
                              </button>
                              <!-- <button type="reset" class="btn btn-effect-ripple btn-default reset_btn">Reset
                              </button> -->

                           </div>
                        </div>

                        <div class="form-group form-actions">

                        </div>
                     </form>
                  </div>
               </div>
            </div>

         </div> <br>


         <div class="row">
            <div class="col-lg-12">
               <div class="card ">
                   
                  <div class="card-body">
                     <div class="table-responsive">
                        <?php if ($role = $this->session->userdata('lm_role') == 1) { ?>
                           <div class="btn-group" style="float:right;margin-right:15px;">
                              <button type="button" class="toggle-vis btn btn-default" onclick="downloadReport();"> <span class="ti-download"></span> Download CSV </button>
                           </div>
                        <?php } ?>

                        <table class="table table-striped table-bordered table-hover" id="tbl_list" style="width:100%">
                           <thead style="text-align: center;">
                              <tr>
                                 <th>Order #</th>
                                 <th>Customer</th>
                                 <th>Phone</th>
                                 <th>Cust ID</th>
                                 <th>Amount</th>
                                 <th>Created On</th>
                                 <th>Created By</th>
                                 <th>Status</th>
                                 <?php if ($this->session->userdata('lm_role') == 1) echo '<th>Action</th>'; ?>
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
   <script src="<?php echo base_url() ?>assets/vendors/moment/js/moment.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/sweetalert.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/lead.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/jquery.dataTables.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/datatables/js/dataTables.bootstrap4.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/sweetalert2/js/sweetalert2.min.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/vendors/jquerydaterangepicker/js/jquery.daterangepicker.min.js"></script>
   <script src="<?php echo base_url() ?>assets/vendors/datedropper/datedropper.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.datetimepicker.js"></script>

   <script>
      "use strict";
      $(document).ready(function() {

         leadList();
      });

      // For search box
      $('#from_date').dateRangePicker({
         singleDate: true,
         showShortcuts: false,
         singleMonth: true,
         getValue: function() {
            $(this).val("");
         }
      });

      $('#to_date').dateRangePicker({
         singleDate: true,
         showShortcuts: false,
         singleMonth: true,
         getValue: function() {
            $(this).val("");
         }
      });

      //end

      function leadList() {
         $('#tbl_list').DataTable().destroy();
         var table = $('#tbl_list').DataTable({
            "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
            "processing": true,
            "serverSide": true,
            "ajax": {
               "url": BASE_URL + "lead/lead_list",
               "data": {
                  "from_date": $('#from_date').val(),
                  "to_date": $('#to_date').val(),

               }
            },
            "responsive": true,
            "order": [
               [5, "desc"]
            ],
            "columns": [{
                  "width": "8%"
               },
               {
                  "width": "10%"
               },
               {
                  "width": "10%"
               },
               {
                  "width": "10%"
               },
               {
                  "width": "12%"
               },
               {
                  "width": "14%"
               },
               {
                  "width": "12%"
               },
               {
                  "width": "12%"
               },
               <?php if ($this->session->userdata('lm_role') == 1) { ?> {
                     "width": "12%"
                  },
               <?php } ?>
            ],
            "columnDefs": [{
               "targets": [0, 1, 2, 3, 4, 5, 6],
               "orderable": true
            }],

         });

      }

      function cancelLead(lead_id) {
         swal({
            title: '<span style="color:red;font-size:20px;">Are you sure, want to cancel this order? <br>Please enter the Reason<b>',
            input: 'text', 
            inputPlacehokder: 'Reason',
            confirmButtonClass: 'btn btn-info',
            confirmButtonText: 'Yes',
            showCancelButton: true,
            cancelButtonColor: '#ff6666',
            cancelButtonText: 'No',
            cancelButtonClass: 'btn btn-danger',
            inputValidator: function(value) {
               return new Promise(function(resolve, reject) {
                  if (value) {
                     resolve();
                     $.ajax({
                        type: "POST",
                        url: BASE_URL + "/lead/approve_lead",
                        data: {
                           lead_id: lead_id,
                           status: 3,
                           reason: value,
                        },
                        cache: false,
                        timeout: 800000,
                        success: function(data) {
                           var result = JSON.parse(data);
                           if (result['success']) {
                              swal({
                                 title: "Success",
                                 text: result['msg'],
                                 type: "success",
                                 confirmButtonColor: "#66cc99"
                              }).then(function() {
                                 leadList();
                              });
                           } else {
                              swal({
                                 title: "Failed",
                                 text: result['msg'],
                                 type: "error",
                                 confirmButtonColor: "#66cc99"
                              }).then(function() {
                                 leadList();
                              });
                           }
                        },
                        error: function(e) {}
                     });
                  } else {
                     alert('Please enter the reason');
                     cancelLead(lead_id) 
                   //  reject();
                     
                     
                  }
               });
            }
         })
      }

      function approveLead(lead_id) {
         swal({
            title: "",
            text: "Are you sure want to approve this order?",
            type: "info",
            confirmButtonClass: 'btn btn-info',
            confirmButtonText: 'Yes',
            showCancelButton: true,
            cancelButtonColor: '#ff6666',
            cancelButtonText: 'No',
            cancelButtonClass: 'btn btn-danger'
         }).then(function(conrifm) {
            if (conrifm['value'] == true) {
               $.ajax({
                  type: "POST",
                  url: BASE_URL + "/lead/approve_lead",
                  data: {
                     lead_id: lead_id,
                     status: 2,
                  },
                  cache: false,
                  timeout: 800000,
                  success: function(data) {
                     var result = JSON.parse(data);
                     if (result['success']) {
                        swal({
                           title: "Success",
                           text: result['msg'],
                           type: "success",
                           confirmButtonColor: "#66cc99"
                        }).then(function() {
                           leadList();
                        });
                     } else {
                        swal({
                           title: "Failed",
                           text: result['msg'],
                           type: "error",
                           confirmButtonColor: "#66cc99"
                        }).then(function() {
                           leadList();
                        });
                     }
                  },
                  error: function(e) {}
               });
            }

         });
      }

      function downloadReport() {
         let q = $('.dataTables_filter').find('input').val().trim(); 
         let url = BASE_URL + 'lead/download?q=' + q+'&from_date='+$('#from_date').val()+'&to_date='+$('#to_date').val();
         window.open(url);
      }
   </script>
</body>

</html>