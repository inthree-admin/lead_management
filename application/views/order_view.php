<!DOCTYPE html>
<html lang="">

<head>
   <meta charset="UTF-8">
   <title> Order History </title>
   <meta content='width=device-width,user-scalable=no' name='viewport'>
   <link rel="shortcut icon" href="img/favicon.ico" />
   <!-- global css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/app.css" />

   <!-- end of global css -->
   <!--page level css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/datatables/css/dataTables.bootstrap4.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom_css/datatables_custom.css">
</head>
<script>
   var BASE_URL = "<?php echo base_url() ?>";
</script>
<?php $proof = base_url() . 'assets/img/no_image.png'; ?>
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




      <section class="content p-l-r-15" id="invoice-stmt">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">
                  <i class="fa fa-fw ti-credit-card"></i> Lead Details
               </h3>
               <span class="float-right">
                  <a href="<?php echo site_url("lead/list"); ?>" title="Back"><i class="fa fa-fw fa-lg fa-arrow-circle-left"></i></a>
               </span>
            </div>
            <div class="card-body">
               <div class="col-lg-12">


                  <?php if ($history_tran) { //echo "<pre>";print_r($history_tran);
                  ?>
                     <div class="box-body table-responsive">
                        <table id="inventory3" class="table table-bordered table-striped ">
                           <?php
                           foreach ($history_tran as $row) {
                              $tran_status = $row['tran_status'];
                              $received_date = $row['received_date'];
                              $assigned_at = $row['assigned_at'];

                              if ($row['delivery_status'] == 1) {
                                 if ($row['qty_received'] ==  $row['qty_returned']) {
                                    $status = "Returned";
                                 } else {
                                    if ($history_tran[0]['order_type'] == 1) {
                                       $status = "Delivered";
                                    } else if ($history_tran[0]['order_type'] == 3) {
                                       //$status="Delivered";
                                       $status = "Delivered / Pickup Completed - RTO Initiated";
                                    }

                                    if (count($is_avail_rto_his) > 0) {

                                       if ($is_avail_rto_his[0]['return_at'] != '') {
                                          $status = "Delivered / Pickup Completed - RTO Delivered";
                                       }
                                       if ($is_avail_rto_his[0]['reached_at'] != '') {
                                          $pick_del_qty_count = 0;
                                          $pick_del_ret_qty_count = 0;
                                          foreach ($is_avail_rto_his as $is_avail_rto) {
                                             $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                             $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                          }
                                          if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                             $status = "Delivered / Pickup Completed - RTO Acknowledged";
                                          }
                                       }
                                    }
                                 }
                              } else if ($row['delivery_status'] == 2) {
                                 if ($row['qty_received'] ==  $row['qty_returned']) {
                                    $status = "Returned";
                                 } else {
                                    $status = "Un-Delivered";
                                    if ($row['order_type'] == 1) {
                                       if (count($is_avail_rto_his) > 0) {
                                          $status = "Un-Delivered / RTO Initiated";
                                          $undel_flag = 1;

                                          if ($is_avail_rto_his[0]['return_at'] != '') {
                                             $status = "Un-Delivered / RTO Delivered";
                                          }
                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             $pick_del_qty_count = 0;
                                             $pick_del_ret_qty_count = 0;
                                             foreach ($is_avail_rto_his as $is_avail_rto) {
                                                $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                             }
                                             if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                $status = "Un-Delivered / RTO Acknowledged";
                                             }
                                          }
                                       }
                                    }
                                    if ($row['order_type'] == 2) {
                                       if ($row['tran_status'] == 2) {
                                          $status = "Waiting for pickup";
                                       } else if ($row['tran_status'] == 3) {
                                          $status = "Pickup Complete";
                                       }
                                    }

                                    if ($row['order_type'] == 3) {
                                       if ($row['tran_status'] == 2) {
                                          $status = "Un-Delivered / Pickup Cancelled";

                                          if (count($is_avail_rto_his) > 0) {
                                             $status = "Un-Delivered / Pickup Cancelled - RTO Initiated";
                                             $undel_flag = 1;

                                             if ($is_avail_rto_his[0]['return_at'] != '') {
                                                $status = "Un-Delivered / Pickup Cancelled  - RTO Delivered";
                                             }
                                             if ($is_avail_rto_his[0]['reached_at'] != '') {
                                                $pick_del_qty_count = 0;
                                                $pick_del_ret_qty_count = 0;
                                                foreach ($is_avail_rto_his as $is_avail_rto) {
                                                   $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                   $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                                }
                                                if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                   $status = "Un-Delivered / Pickup Cancelled - RTO Acknowledged";
                                                }
                                             }
                                          }
                                       } else if ($row['tran_status'] == 3) {
                                          $status = "Pickup Complete";
                                       }
                                    }
                                 }
                              } else if ($row['delivery_status'] == 3) {
                                 if ($row['qty_received'] ==  $row['qty_returned']) {
                                    $status = "Returned";
                                 } else {
                                    $status = "Partial Delivered";
                                    if ($row['order_type'] == 1) {
                                       if (count($is_avail_rto_his) > 0) {
                                          $status = "Partial Delivered / RTO Initiated";
                                          // $partial_flag=1;

                                          if ($is_avail_rto_his[0]['return_at'] != '') {
                                             $status = "Partial Delivered / RTO Delivered";
                                          }
                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             $pick_del_qty_count = 0;
                                             $pick_del_ret_qty_count = 0;
                                             foreach ($is_avail_rto_his as $is_avail_rto) {
                                                $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                             }
                                             if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                $status = "Partial Delivered / RTO Acknowledged";
                                             }
                                          }
                                       }
                                    }
                                 }
                              } else if ($row['delivery_status'] == 4) {

                                 if ($row['qty_received'] ==  $row['qty_returned']) {
                                    //$status="RTO Initiated";
                                    $status = "Pending RTO";

                                    if ($row['order_type'] == 1) {
                                       if ($open_order_ack_deny) {
                                          $status = "RTO Initiated";

                                          if (count($is_avail_rto_his) > 0) {
                                             $status = "RTO Initiated";

                                             if ($is_avail_rto_his[0]['return_at'] != '') {
                                                $status = "RTO Delivered";
                                             }
                                             if ($is_avail_rto_his[0]['reached_at'] != '') {
                                                $pick_del_qty_count = 0;
                                                $pick_del_ret_qty_count = 0;
                                                foreach ($is_avail_rto_his as $is_avail_rto) {
                                                   $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                   $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                                }
                                                if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                   $status = "RTO Acknowledged";
                                                }
                                             }
                                          }
                                       } else {
                                          $status = "Deny / RTO Initiated";

                                          if (count($is_avail_rto_his) > 0) {
                                             $status = "Deny / RTO Initiated";


                                             if ($max_is_avail_rto_his['return_at'] != '') {
                                                $status = "Deny / RTO Delivered";
                                             }
                                             //echo '<pre>';
                                             //print_r($is_avail_rto_his); exit;
                                             if ($is_avail_rto_his[0]['reached_at'] != '') {
                                                $pick_del_qty_count = 0;
                                                $pick_del_ret_qty_count = 0;
                                                foreach ($is_avail_rto_his as $is_avail_rto) {
                                                   $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                   $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                                }
                                                if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                   $status = "Deny / RTO Acknowledged";
                                                }
                                             }
                                          }
                                       }
                                    }
                                    if ($row['order_type'] == 3) {
                                       if ($open_order_ack_deny) {
                                          $status = "RTO Initiated / Pickup Cancelled";

                                          if ($is_avail_rto_his[0]['return_at'] != '') {
                                             $status = "RTO Delivered / Pickup Cancelled";
                                          }
                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             $pick_del_qty_count = 0;
                                             $pick_del_ret_qty_count = 0;
                                             foreach ($is_avail_rto_his as $is_avail_rto) {
                                                $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                             }
                                             if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                $status = "RTO Acknowledged / Pickup Cancelled";
                                             }
                                          }
                                       } else {
                                          $status = "Deny-RTO Initiated / Pickup Cancelled";

                                          if ($max_is_avail_rto_his['return_at'] != '') {
                                             $status = "Deny-RTO Delivered / Pickup Cancelled";
                                          }

                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             $pick_del_qty_count = 0;
                                             $pick_del_ret_qty_count = 0;
                                             foreach ($is_avail_rto_his as $is_avail_rto) {
                                                $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                             }
                                             if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                $status = "Deny-RTO Acknowledged / Pickup Cancelled";
                                             }
                                          }
                                       }
                                    }
                                 } else {
                                    $status = "Moved to RTO";
                                    if ($row['order_type'] == 1) {
                                       if ($open_order_ack_deny) {
                                          $status = "RTO Initiated";

                                          if (count($is_avail_rto_his) > 0) {
                                             $status = "RTO Initiated";

                                             if ($is_avail_rto_his[0]['return_at'] != '') {
                                                $status = "RTO Delivered";
                                             }
                                             if ($is_avail_rto_his[0]['reached_at'] != '') {
                                                $pick_del_qty_count = 0;
                                                $pick_del_ret_qty_count = 0;
                                                foreach ($is_avail_rto_his as $is_avail_rto) {
                                                   $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                   $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                                }
                                                if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                   $status = "RTO Acknowledged";
                                                }
                                             }
                                          }
                                       } else {
                                          $status = "Deny / RTO Initiated";

                                          if (count($is_avail_rto_his) > 0) {
                                             $status = "Deny / RTO Initiated";


                                             if ($max_is_avail_rto_his['return_at'] != '') {
                                                $status = "Deny / RTO Delivered";
                                             }
                                             //echo '<pre>';
                                             //print_r($is_avail_rto_his); exit;
                                             if ($is_avail_rto_his[0]['reached_at'] != '') {
                                                $pick_del_qty_count = 0;
                                                $pick_del_ret_qty_count = 0;
                                                foreach ($is_avail_rto_his as $is_avail_rto) {
                                                   $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                   $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                                }
                                                if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                   $status = "Deny / RTO Acknowledged";
                                                }
                                             }
                                          }
                                       }
                                    }
                                    if ($row['order_type'] == 3) {
                                       if ($open_order_ack_deny) {
                                          $status = "RTO Initiated / Pickup Cancelled";

                                          if ($is_avail_rto_his[0]['return_at'] != '') {
                                             $status = "RTO Delivered / Pickup Cancelled";
                                          }
                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             $pick_del_qty_count = 0;
                                             $pick_del_ret_qty_count = 0;
                                             foreach ($is_avail_rto_his as $is_avail_rto) {
                                                $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                             }
                                             if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                $status = "RTO Acknowledged / Pickup Cancelled";
                                             }
                                          }
                                       } else {
                                          $status = "Deny-RTO Initiated / Pickup Cancelled";

                                          if ($max_is_avail_rto_his['return_at'] != '') {
                                             $status = "Deny-RTO Delivered / Pickup Cancelled";
                                          }

                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             $pick_del_qty_count = 0;
                                             $pick_del_ret_qty_count = 0;
                                             foreach ($is_avail_rto_his as $is_avail_rto) {
                                                $pick_del_qty_count = $is_avail_rto['qty'] + $pick_del_qty_count;
                                                $pick_del_ret_qty_count =   $is_avail_rto['reached_qty'] + $pick_del_ret_qty_count;
                                             }
                                             if ($pick_del_ret_qty_count == $pick_del_qty_count) {
                                                $status = "Deny-RTO Acknowledged / Pickup Cancelled";
                                             }
                                          }
                                       }
                                    }
                                 }

                                 if ($row['order_type'] == 2) {
                                    if (count($is_avail_rto_his) > 0) {
                                       if ($row['tran_status'] == 2) {
                                          $status = "Waiting for pickup";
                                       } else if ($row['tran_status'] == 3) {
                                          $status = "Pickup Complete";
                                       } else if ($row['tran_status'] == 4) {
                                          $pickup_complete_flag = 1;
                                          $status = "Pickup Completed / RTO Initiated";

                                          if ($is_avail_rto_his[0]['return_at'] != '') {
                                             $status = "Pickup Completed / RTO Delivered";
                                          }
                                          if ($is_avail_rto_his[0]['reached_at'] != '') {
                                             if ($is_avail_rto_his[0]['reached_qty'] == $is_avail_rto_his[0]['qty']) {
                                                $status = "Pickup Completed / RTO Acknowledged";
                                             }
                                          }                               // echo '<pre>';
                                          //print_r($rtohistory); exit;
                                       }
                                    } else {
                                       if ($row['delivery_status'] == 4) {
                                          $status = "Pickup Failed";
                                       }
                                    }


                                    if ($row['delivery_status'] == 4 && $row['tran_status'] == 1) {
                                       $status = "Pickup Denied";
                                    }
                                 }
                              } else {
                                 if (($row['qty'] - $row['qty_hold']) == 0) {
                                    $status = "Hold";
                                 } else if ($assigned_at != "00-00-0000" && $assigned_at != "") {
                                    if ($row['qty_received'] ==  $row['qty_returned']) {
                                       $status = "Returned";
                                    } else {


                                       if ($row['order_type'] == 2) {
                                          $status = 'Waiting for pickup';
                                          if ($row['tran_status'] == 2) {
                                             $status = "Waiting for pickup";
                                          } else if ($row['tran_status'] == 3) {
                                             $status = "Pickup Complete";
                                          } else if ($row['tran_status'] == 4) {
                                             $pickup_complete_flag = 1;
                                             $status = "Pickup Completed / RTO Initiated";
                                             /*for multiple rto insert*/
                                             if (count($is_avail_rto_his) == 1) {
                                                if ($is_avail_rto_his[0]['return_at'] != '') {
                                                   $status = "Pickup Completed / RTO Delivered";
                                                }
                                                if ($is_avail_rto_his[0]['reached_at'] != '') {
                                                   if ($is_avail_rto_his[0]['reached_qty'] == $is_avail_rto_his[0]['qty']) {
                                                      $status = "Pickup Completed / RTO Acknowledged";
                                                   }
                                                }
                                             } else {
                                                if (isset($max_is_avail_rto_his)) {
                                                   if ($max_is_avail_rto_his['return_at'] != '') {
                                                      $status = "Pickup Completed / RTO Delivered";
                                                   }
                                                   if ($max_is_avail_rto_his['reached_at'] != '') {
                                                      if ($max_is_avail_rto_his['reached_qty'] == $max_is_avail_rto_his['qty']) {
                                                         $status = "Pickup Completed / RTO Acknowledged";
                                                      }
                                                   }
                                                }
                                             }
                                             /*for multiple rto insert*/
                                             // echo '<pre>';
                                             //print_r($rtohistory); exit;
                                          }
                                          if ($row['delivery_status'] == 4 && $row['tran_status'] == 4) {
                                             $status = "Pickup Failed";
                                          } else if ($row['delivery_status'] == 4 && $row['tran_status'] == 1) {
                                             $status = "Pickup Denied";
                                          }
                                       } else {
                                          $status = "Waiting for Delivery";
                                       }
                                    }
                                 } else if ($row['received_at'] != "00-00-0000" && $row['received_at'] != "") {
                                    if ($row['qty_received'] ==  $row['qty_returned']) {
                                       $status = "Returned";
                                    } else
                                       $status = "Received by LMP";
                                 } else {
                                    $status = "Open";
                                 }
                              }
                              if ($getHoldStatus['hold_status'] > 0) {
                                 $status = "Hold";
                              }
                              $delstatus = $row['delivery_status'];

                           ?>
                              <tbody>
                                 <?php //echo $tat_exceed; 
                                 ?>
                                 <?php
                                 if ($row['tran_status'] == '7') {
                                    $status = 'Returned';
                                 }
                                 ?>
                              <tbody>
                                 <tr>
                                    <th>Reference</th>
                                    <td><?= $row['reference']; ?></td>
                                    <th colspan="2">Order #</th>
                                    <td><?= $row['orderid']; ?></td>
                                 </tr>
                                 <tr>
                                    <th>Shipment #</th>
                                    <td><?= $row['shipmentid']; ?></td>
                                    <th colspan="2">Status</th>
                                    <th>
                                       <font color="Green"><b><?php echo $status; ?></b></font>
                                    </th>
                                 </tr>
                                 <tr>
                                    <th>Customer Name</th>
                                    <td><?= $row['customer_name']; ?></td>
                                    <?php if ($row['care_of_name']) { ?><th>Care of</th>
                                       <td><?= $row['care_of_name']; ?></td> <?php } ?>
                                 </tr>
                                 <tr>
                                    <th>Mobile</th>
                                    <td><?= $row['customer_contact_number']; ?></td>
                                 </tr>
                                 <!--<tr><th>Customer Name</th><td><?= $row['customer_name']; ?></td><th>Mobile</th><td><?= $row['customer_contact_number']; ?></td></tr>-->
                              </tbody>
                              <tbody>
                                 <tr>
                                    <th colspan="2">Billing
                                    </th>
                                    <th colspan="3">Shipping
                                    </th>
                                 </tr>
                                 <tr>
                                    <td colspan="2">
                                       <?= $row['billing_address']; ?>
                                    </td>
                                    <td colspan=3 style="text-align: left;">
                                       <?= $row['shipping_address']; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="2">
                                       <?= $row['billing_city']; ?> - <?= $row['billing_pincode']; ?>
                                    </td>
                                    <td colspan=3 style="text-align: left;">
                                       <?= $row['shipping_city']; ?> - <?= $row['shipping_pincode']; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td colspan="2">
                                       <?= $row['billing_telephone']; ?>
                                    </td>
                                    <td colspan=3 style="text-align: left;">
                                       <?= $row['shipping_telephone']; ?>
                                    </td>
                                 </tr>
                                 <?php if ($row['verified_mobile']) { ?>
                                    <tr>
                                       <td colspan="2">
                                          <?= $row['verified_mobile']; ?><img src="<?= base_url() ?>assets/images/ok.png">
                                          <font color='green'><b>Verified</b></font>
                                       </td>

                                    </tr>
                                 <?php } ?>
                              </tbody>
                              <tbody>
                                 <tr>
                                    <th colspan="2">Order Shipped to
                                       <?= $row['firm_name'] . '(' . ($loginname = $row['employee_code']) . ')'; ?>
                                    </th>
                                    <td style="text-align: left;">
                                       <?= $row['created_at']; ?>
                                    </td>
                                    <?php if ($history_tran[0]['order_type'] != 2) { ?>
                                       <th>Payment Mode
                                       </th>
                                       <td style="text-align: left;">
                                          <?= $row['payment_mode']; ?>
                                       </td>

                                    <?php } ?>
                                 </tr>
                                 <tr>
                                    <th>Delivery To</th>
                                    <td style="text-align: left;">
                                       <?php if ($row['delivery_to'] == 1) echo "Branch";
                                       else echo "Customer";
                                       ?>
                                    </td>
                                    <?php if ($history_tran[0]['delivery_to'] == 1) { ?>
                                       <th> Branch Name</th>
                                       <td style="text-align: left;">
                                          <?php if ($row['client_branch_code'] != '')
                                             echo $row['client_branch_name'];
                                          else echo "";
                                          ?>
                                       </td>
                                    <?php } ?>
                                 </tr>
                                 <?php if ($row['received_at'] != "00-00-0000") { ?>
                                    <tr>
                                       <th>Order Received
                                       </th>
                                       <td style="text-align: left;">
                                          <?= $row['received_at']; ?>
                                       </td>

                                    </tr>
                                 <?php } ?>
                                 <?php if ($row['assigned_at'] != "00-00-0000") { ?>
                                    <tr>
                                       <th>Order Assigned
                                       </th>
                                       <td style="text-align: left;">
                                          <?= $row['assigned_at']; ?>
                                       </td>
                                    </tr>
                                 <?php } ?>
                                 <?php if ($row['deliver_boy_name']) { ?>
                                    <tr>
                                       <th>Runner
                                       </th>
                                       <td style="text-align: left;">
                                          <?= $row['deliver_boy_name']; ?>
                                       </td>
                                    </tr>
                                 <?php } ?>
                              </tbody>

                           <?php } ?>
                        </table>
                     </div>

                  <?php } ?>
                  <!-- Product  -->
                  <?php if (!empty($prdthistory) && (!empty($history_tran))) {
                     //  print_r($prdthistory);
                  ?>
                     <div class="box-body table-responsive">
                        <p></p>
                        <h2 class="card-title">
                           <font color="blue"><b>Product Details</b></font>
                        </h2>
                        <p></p>


                        <table id="inventory1" class="table table-bordered table-striped ">
                           <thead>
                              <tr>
                                 <th>SKU
                                 </th>
                                 <th>Product
                                 </th>
                                 <th>Unit Cost
                                 </th>
                                 <th>Qty
                                 </th>
                                 <th>Received
                                 </th>
                                 <th>Delivered
                                 </th>
                                 <th>Good
                                 </th>
                                 <th>Bad
                                 </th>
                                 <th>Returned
                                 </th>
                                 <th>Hold by BB
                                 </th>
                                 <th>Missing
                                 </th>

                              </tr>
                           </thead>
                           <?php
                           //echo "<pre>";print_r($prdthistory);die;
                           foreach ($prdthistory as $row) {
                           ?>
                              <tbody>
                                 <tr>
                                    <td style="text-align: left;">
                                       <?= $row['sku']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['name']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['price']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?php
                                       if ($row['qty_hold'] > 0) {
                                          echo $row['qty'];
                                       } else {
                                          echo $row['qty'];
                                       }

                                       ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?php
                                       if ($tran_status != 0) {
                                          if ($row['qty_hold'] > 0) {
                                             echo $row['qty_received'] - $row['qty_hold'];
                                          } else {
                                             echo $row['qty_received'];
                                          }
                                       } else {
                                          echo $row['qty_received'];
                                       }
                                       ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['qty_delivered']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?php
                                       if ($tran_status != 0) {
                                          if ($row['qty_hold'] > 0) {
                                             echo ($row['qty_received'] - $row['qty_damaged']);
                                             //-$row['qty_hold']
                                          } else {
                                             echo ($row['qty_received'] - $row['qty_damaged']);
                                          }
                                       } else {
                                          echo ($row['qty_received'] - $row['qty_damaged']);
                                       }
                                       ?>

                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['qty_damaged']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['qty_returned']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['qty_hold']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                       <?= $row['qty_missing']; ?>
                                    </td>

                                 </tr>
                              </tbody>
                           <?php } ?>
                        </table>
                     </div>
                  <?php } ?>
                  <!--Delivery   -->
                  <?php if ($delhistory && (!empty($history_tran))) { ?>
                     <div class="box-body table-responsive">
                        <p>
                           <h2 class="card-title">
                              <font color="blue"><b>Delivery Details</b></font>
                           </h2>
                           <p></p>


                           <table id="inventory2" class="table table-bordered table-striped ">
                              <thead>
                                 <tr>
                                    <th>Customer
                                    </th>
                                    <th>Address
                                    </th>
                                    <th>Pincode
                                    </th>
                                    <th>Date
                                    </th>
                                    <th>Status
                                    </th>
                                    <!--
                           <th>Reason
                           </th>-->

                                    <th>Attempt</th>
                                    <th>Delivery Proof</th>
                                    <th>Invoice Proof</th>
                                    <th>Address Proof</th>
                                    <th>Sign Proof</th>
                                 </tr>
                              </thead>
                              <?php
                              $reason = 0;
                              //echo "<pre>";print_r($prdthistory);die;
                              foreach ($delhistory as $row) {
                                 $status = $row['delivery_status'];
                                 $attempt = $row['attempt'];
                                 if ($status == 1)
                                    $state = "Delivered";
                                 else if ($status == 2)
                                    $state = "Undelivered";
                                 else if ($status == 3) {
                                    $state = "Partial Delivery";
                                    $reason = $row['reason'];
                                 } else
                                    $state = "-";
                              ?>
                                 <tbody>
                                    <tr>
                                       <td style="text-align: left;">
                                          <?= $row['customer']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['address']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['pincode']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['created_at']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?php echo $state; ?>
                                       </td>

                                       <!--
                           <td style="text-align: left;">
                              <?php if ($reason) { ?>
                              <?php echo $reason; ?>
                              <?php } ?>
                           </td>-->
                                       <td style="text-align:center;">
                                          <?php if ($attempt) { ?>
                                             <?php echo $attempt; ?>
                                          <?php } ?>
                                       </td>
                                       <?php
                                       
                                       $delivery_proof = (!empty($row['delivery_proof'])) ? $row['delivery_proof'] : $proof;
                                       $invoice_proof = (!empty($row['invoice_proof'])) ? $row['invoice_proof'] : $proof;
                                       $address_proof = (!empty($row['address_proof'])) ? $row['address_proof'] : $proof;
                                       $sign_proof = (!empty($row['sign_proof'])) ? $row['sign_proof'] : $proof;

                                       ?>
                                       <td><img src="<?php echo $delivery_proof; ?>" class="img-thumbnail" alt="Cinque Terre" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);"></td>
                                       <td><img src="<?php echo $invoice_proof; ?>" class="img-thumbnail" alt="Cinque Terre" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);"></td>
                                       <td><img src="<?php echo $address_proof; ?>" class="img-thumbnail" alt="Cinque Terre" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);"></td>
                                       <td><img src="<?php echo $sign_proof; ?>" class="img-thumbnail" alt="Cinque Terre" style="width: 50px;height: 50px;cursor: pointer;" onclick="showImage(this.src);"></td>
                                    </tr>
                                    <!--For Pickup and delivery only start-->
                                    <?php if ($history_tran[0]['order_type'] == 3) { ?>
                                       <!--
					   <tr>
                           <th>SKU
                           </th>
                           <th>SKU Name
                           </th>
                           <th>SKU - Price
                           </th>
                           <th>SKU - Qty
                           </th>
                           <th>Amount
                           </th>
                           <th>Imei number
                           </th>
                        </tr>
                        <tr>
                           <td style="text-align: left;">
                              <?= $row['customer']; ?>
                           </td>
                           <td style="text-align: left;">
                              <?= $row['address']; ?>
                           </td>
                           <td style="text-align: left;">
                              <?= $row['pincode']; ?>
                           </td>
                           <td style="text-align: left;">
                              <?= $row['created_at']; ?>
                           </td>
                           <td style="text-align: left;">
                              <?php echo $state; ?>
                           </td>
                           <td style="text-align: left;">
                              <?php if ($reason) { ?>
                              <?php echo $reason; ?>
                              <?php } ?>
                           </td>
                           <td style="text-align:center;">
                              <?php if ($attempt) { ?>
                              <?php echo $attempt; ?>
                              <?php } ?>
                           </td>
                        </tr>
						-->

                                    <?php } ?>
                                 </tbody>
                              <?php } ?>
                           </table>
                     </div>

                  <?php } ?>
                  <!--Undelivery   -->
                  <?php if ($undelhistory && (!empty($history_tran))) { ?>
                     <div class="box-body table-responsive">
                        <p>
                           <h2 class="card-title">
                              <font color="blue"><b>Undelivered Attempt Details</b></font>
                           </h2>
                           <p></p>

                           <table id="inventory2" class="table table-bordered table-striped ">
                              <thead>
                                 <tr>
                                    <th>Reason
                                    </th>
                                    <th>Comment
                                    </th>
                                    <th>Date
                                    </th>
                                 </tr>
                              </thead>
                              <?php foreach ($undelhistory as $row) {  ?>
                                 <tbody>
                                    <tr>
                                       <td style="text-align: left;">
                                          <?= $row['reason']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['remarks']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['created_at']; ?>
                                       </td>
                                    </tr>
                                 </tbody>
                              <?php } ?>
                           </table>
                     </div>
                  <?php  } ?>
                  <!-- Runner    -->
                  <?php
                  /*print_r($runnerhistory);die;*/
                  $runrs = count($runnerhistory);
                  if ($runnerhistory && (!empty($history_tran)) && ($runrs > 1)) { ?>
                     <div class="box-body table-responsive">
                        <p>
                           <h2 class="card-title">
                              <font color="blue"><b>Runners Details</b></font>
                           </h2>
                           <p></p>

                           <table id="inventory6" class="table table-bordered table-striped ">
                              <thead>
                                 <tr>
                                    <th>Runner #
                                    </th>
                                    <th>Runner Name
                                    </th>
                                 </tr>
                              </thead>
                              <?php
                              $cnt = 0;
                              foreach ($runnerhistory as $row) {
                                 $cnt++;
                              ?>
                                 <tbody>
                                    <tr>
                                       <td style="text-align: left;">Runner
                                          <?php echo $cnt; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['deliver_boy_name']; ?>
                                       </td>
                                    </tr>
                                 </tbody>
                              <?php } ?>
                           </table>
                     </div>
                  <?php  } ?>
                  <!-- Order History Comments   -->
                  <?php if (!empty($fullhistory)) { ?>
                     <div class="box-body table-responsive">

                        <p>
                           <h2 class="card-title">
                              <font color="blue"><b>Order History</b></font>
                           </h2>
                           <p></p>

                           <table id="inventory2" class="table table-bordered table-striped ">
                              <thead>
                                 <tr>
                                    <th>Info
                                    </th>
                                    <th>Comment
                                    </th>
                                    <th>Logged Date
                                    </th>
                                 </tr>
                              </thead>
                              <?php
                              // echo "<pre>";print_r($fullhistory);die;
                              foreach ($fullhistory as $row) {
                              ?>
                                 <tbody>
                                    <tr>
                                       <!-- <td style="text-align: left;"><?= $row['id']; ?></td>
                           <td style="text-align: left;"><?= $row['parent_id']; ?></td>-->
                                       <td style="text-align: left;">
                                          <?= $row['info']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= $row['comment']; ?>
                                       </td>
                                       <td style="text-align: left;">
                                          <?= date('d-m-Y h:i:s', strtotime($row['created_at'])); ?>
                                       </td>
                                       <!--<td style="text-align: left;"><?= $row['created_by']; ?></td>
                              <td style="text-align: left;"><?= $row['updated_at']; ?></td>
                              <td style="text-align: left;"><?= $row['updated_by']; ?></td>-->
                                    </tr>
                                 </tbody>
                              <?php } ?>
                           </table>
                     </div>
                  <?php } ?>

               </div>

            </div>
         </div>
      </section>

      <div id="center_modal" class="modal fade animated position_modal" role="dialog" style="display: none;" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">

               <div class="modal-body">
                  <img id="lrg_proof" src="<?php echo $proof; ?>" class="img-thumbnail" alt="">
               </div>

            </div>
         </div>
      </div>




      <!-- /.content -->
      <!-- </aside>-->
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
   <script type="text/javascript">
      function showImage(src) {
         $('#lrg_proof').attr('src', src);
         $('#center_modal').modal('show');
      }
   </script>
</body>

</html>