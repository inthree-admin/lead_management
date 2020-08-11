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
   <style>
      @media screen and (max-width: 767px)
      {
         .page-link{padding: 0.5rem 0.20rem !important;font-size: 12px;}
      }
   </style>
</head>
<script>
   var BASE_URL = "<?php echo base_url() ?>";
</script>

<?php
$today      = date('Y-m-d');
$datetime   = new DateTime($today);
$datetime->modify('-1 day');
$from_date   = $datetime->format('Y-m-d');
$to_date     = $today;

?>

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
                        <i class="fa fa-fw ti-search"></i> Search Lead
                     </h3>
                     <span class="float-right d-none d-sm-block fnt_size txt_font">
                        <i class="fa fa-fw ti-angle-up clickable"></i>
                        <i class="fa fa-fw ti-close removecard"></i>
                     </span>
                  </div>
                  <div class="card-body">
                     <form id="search_form" method="get">
                        <div class="form-group row">
                           <div class="col-md-3">
                              <label class="form-control-label text-info"> Status</label>
                              <div class="input-group">
                                 <select class="form-control" id="fltr_status" name="fltr_status">
                                    <option value="0" selected>All</option>
                                    <option value="1">Waiting For Approval</option>
                                    <option value="2">Approved</option>
                                    <option value="3">Cancelled</option>
                                    <option value="4">Delivered</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <label class="form-control-label text-info"> Created From</label>
                              <div class="input-group">
                                 <div class="input-group-addon">
                                    <i class="fa fa-fw ti-calendar"></i>
                                 </div>
                                 <input class="form-control" id="from_date" size="40" placeholder="From date" value="<?php echo $from_date; ?>">
                              </div>
                           </div>

                           <div class="col-md-3">
                              <label class="form-control-label text-info"> Created To</label>
                              <div class="input-group">
                                 <div class="input-group-addon">
                                    <i class="fa fa-fw ti-calendar"></i>
                                 </div>
                                 <input class="form-control" id="to_date" size="40" placeholder="To date" value="<?php echo $to_date; ?>">
                              </div>
                           </div>

                           <div class="col-md-3" style="margin-top: 28px;">
                              <button type="button" class="btn btn-effect-ripple btn-primary" onclick="leadList();">
                                 Search
                              </button>

                           </div>
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
                           <div class="btn-group" style="float:right;margin-right:0px;">
                              <a href="javascript:void(0);" onclick="downloadReport();"><img src="<?php echo base_url() ?>assets/img/icon-download.png" style="float:right;" title="Download CSV"></a>
                           </div>
                        <?php } ?>

                        <table class="table table-striped table-bordered table-hover" id="tbl_list" style="width:100%">
                           <thead style="text-align: center;">
                              <tr>
                                 <th>Order #</th>
                                 <th>Customer</th>
                                 <th>Phone</th>
                                 <th>LMP</th>
                                 <th>Branch</th>
                                 <th>Amount</th>
                                 <th>Created On</th>
                                 <th>Created By</th>
                                 <th>Approved On</th>
                                 <th>Delivered On</th>
                                 <th>Order Status</th>
                                 <?php if ($this->session->userdata('lm_role') == 1) echo '<th >Bulk Approve <input type="checkbox" class="iCheck-helper multiapprovechkbox" onchange="checkAppAll(this);">  </th><th>Action</th>'; ?>
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

<div id="multipleApproveModal" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="$('.multiapprovechkbox').prop('checked',false);">&times;</button>
        <h4 class="modal-title">Order List</h4>
      </div>
      <div class="modal-body">
        
        <table class="table table-striped table-bordered table-hover" id="tbl_pendingAprroveList" style="width:100%">
                           <thead style="text-align: center;">
                              <tr>
                                 <th><input type="checkbox" id="chkbox_select_all" value="deva" onchange="selectAll(this);" ></th>
                                 <th>Order #</th>  
                                 <th>Branch</th> 
                                 <th>LMP</th>
                              </tr>
                           </thead>
                           <tbody>


                           </tbody>
                        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn_bulk_approve" onclick="multipleApprove();">Approve</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.multiapprovechkbox').prop('checked',false);">Close</button>
        
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
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/jquery.blockUI.js"></script>


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
         var fltr_status = $('#fltr_status').val();
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
                  "fltr_status": fltr_status,
               }
            },
            "responsive": true,
            "order": [
               [0, "desc"]
            ],
            // "columns": [{
            //       "width": "8%"
            //    },
            //    {
            //       "width": "10%"
            //    },
            //    {
            //       "width": "10%"
            //    },
            //    {
            //       "width": "10%"
            //    },
            //    {
            //       "width": "10%"
            //    },
            //    {
            //       "width": "12%"
            //    },
            //    {
            //       "width": "14%"
            //    },
            //    {
            //       "width": "12%"
            //    },
            //    {
            //       "width": "12%"
            //    },
            //    <?php if ($this->session->userdata('lm_role') == 1) { ?> {
            //          "width": "12%"
            //       },
            //    <?php } ?>
            // ],
            "columnDefs": [{
                  "targets": 11, 
                  "className": "text-center", 
               },
               {
                  "targets": 12,  
                  "className": "text-center", 
               },
               {
                  "orderable": false,
                  "targets": [9, 10, 11, 12]
               }
            ],


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
         });
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

         /*swal({
            title: 'Select Outage Tier',
            input: 'select',
            inputOptions: {
               '1': 'Tier 1',
               '2': 'Tier 2',
               '3': 'Tier 3'
            },
            inputPlaceholder: 'required',
            showCancelButton: true,
            inputValidator: function(value) {
               return new Promise(function(resolve, reject) {
                  if (value !== '') {
                     resolve();
                  } else {
                     reject('You need to select a Tier');
                  }
               });
            }
         }).then(function(result) {
            swal({
               type: 'success',
               html: 'You selected: ' + result.value
            });
         });*/


      }


      function assignLMP(lead_id) {
         swal({
            title: '<span style="color:red;font-size:20px;">Please select the LMP to approve<b>',
            input: 'select',
            inputPlaceholder: 'select',
            inputOptions: {
               '145': 'Monisha  (bb_Monish)',
               '159': 'Agalya (bb_Agalya)',
               '163': 'Vikash (bb_vikash)'
            },
            inputPlacehokder: 'lmp',
            confirmButtonClass: 'btn btn-info',
            confirmButtonText: 'Approve',
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
                           lmp_id: value,
                           status: 2
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
                     alert('Please select the LMP to approve');
                     assignLMP(lead_id)
                  }
               });
            }
         });
      }

      function downloadReport() {
         let q = $('.dataTables_filter').find('input').val().trim();
         let url = BASE_URL + 'lead/download?q=' + q + '&from_date=' + $('#from_date').val() + '&to_date=' + $('#to_date').val() + '&fltr_status=' + $('#fltr_status').val();
         window.open(url);
      }

      function checkAppAll(e){    

              $('.btn_bulk_approve').prop('disabled',false);
            if($(e).prop('checked')){
               showPendingApproveList()
               $('#multipleApproveModal').modal('show');
            }  else{
                
                $('#multipleApproveModal').modal('hide');
            }   
         
      }

      function showPendingApproveList(){
         $('#tbl_pendingAprroveList').DataTable().destroy();
         $('#chkbox_select_all').prop('checked',false);
         lead_id_with_lmp = [];
         selectedOrder = [];
         var table = $('#tbl_pendingAprroveList').DataTable({ 
            "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": true,
            "ajax": {
               "url": BASE_URL + "lead/waiting_for_approval_list",
               "data": {
                  "from_date": $('#from_date').val(),
                  "to_date": $('#to_date').val(),
                   "fltr_status": 1,
               }
            },

            "responsive": true,
              
            "columnDefs": [
            
               {
                  "targets": [0,1,2,3], 
                  "className": "text-center", 
               },
               {
                  "orderable": false,
                  "targets": [0,1,2,3]
               }
            ],


         });


      }

      function multipleApprove(){
         if(selectedOrder.length == 0) {
            alert('Please select the lead');
            return false;  
         }
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
                  $('.btn_bulk_approve').prop('disabled',true);
                  var arr_orders = [];
                  arr_orders = getUnique(selectedOrder);

                  $.blockUI({message:'Please wait...', css: {
                                border: 'none',
                                padding: '15px',
                               backgroundColor: '#000',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                opacity: .5,
                                color: '#fff',
                                'z-index':3000
                                 }
                  });


                  $.ajax({
                        type: "POST",
                        url: BASE_URL + "/lead/bulk_approve",
                        data: {
                           lead_ids: arr_orders.join(), 
                           lead_ids_with_lmp: lead_id_with_lmp.join(), 
                           status: 2
                        },
                        cache: false,
                        timeout: 800000,
                        success: function(data) {
                         var result = JSON.parse(data); 
                          $.unblockUI();
                            showPendingApproveList();
                           $('.btn_bulk_approve').prop('disabled',false);
                           leadList(); 
                             swal({
                           title: "Success",
                           text: result.length +' Lead approved successfully',
                           type: "success",
                           confirmButtonColor: "#66cc99"
                        }).then(function() { 
                          
                        }); 
                            
                        },
                        error: function(e) {}
                     });
               

            }

         });
      }
      
      var lead_id_with_lmp = [];
      function validateMultiapprove(e){
         $($(e).closest('tr').find('.sel_lmp option')).each(function(){
             var removevalue = $(e).closest('tr').find('.multi_chkbx').val()+':'+this.value;
              lead_id_with_lmp = jQuery.grep(lead_id_with_lmp, function(value) { 
                   return value != removevalue;
             }); 
         });
         if($(e).val() == '') {
            $(e).closest('tr').find('.multi_chkbx').prop('checked',false);
            $(e).closest('tr').find('.multi_chkbx').prop('disabled',true);
             removeOrder( $(e).closest('tr').find('.multi_chkbx').val()); 
         }
         else{
             $(e).closest('tr').find('.multi_chkbx').prop('checked',true);
             $(e).closest('tr').find('.multi_chkbx').prop('disabled',false);
              selectedOrder.push(  $(e).closest('tr').find('.multi_chkbx').val()); 
              lead_id_with_lmp.push($(e).closest('tr').find('.multi_chkbx').val()+':'+$(e).val());
         } 
         console.log(lead_id_with_lmp);
      }

      var selectedOrder = [];
      function selectAll(e){       
         if($(e).prop('checked')){
            $('#tbl_pendingAprroveList').find('.multi_chkbx').prop('checked',true);
            $.each($('.multi_chkbx'), function( index, value ) {
               
               if($(this).prop('disabled') === false)  
                  selectedOrder.push($(this).val());                
               else 
                  $(this).prop('checked',false);               
              });
         } 
         else {
            $('#tbl_pendingAprroveList').find('.multi_chkbx').prop('checked',false);
              $.each($('.multi_chkbx'), function( index, value ) {
                 removeOrder($(this).val());
              });
             
         }

         console.log(selectedOrder);
      }
      function removeOrder(t){
         selectedOrder = jQuery.grep(selectedOrder, function(value) { 
         return value != t;
         });
      }

      $(document).on('click', '.page-link',function(){  
         var count = 0;
         $.each($('.multi_chkbx'), function( index, value ) {
             if($(this).prop('checked')) count++;
         });
         if(count == 10)  $('#chkbox_select_all').prop('checked',true);
         else  $('#chkbox_select_all').prop('checked',false);
      });
      
      function pushOrder(e){
         
         if($(e).prop('checked'))  selectedOrder.push($(e).val());
         else removeOrder($(e).val());
          console.log(selectedOrder);
      }
      
    function getUnique(array){
        var uniqueArray = [];
        
        // Loop through array values
        for( var i=0; i < array.length; i++){
            if(uniqueArray.indexOf(array[i]) === -1) {
                uniqueArray.push(array[i]);
            }
        }
        return uniqueArray;
    }
   </script>
</body>

</html>