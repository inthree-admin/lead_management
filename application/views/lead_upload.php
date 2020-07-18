<!DOCTYPE html>
<html lang="">

<head>
   <meta charset="UTF-8">
   <title> ::Lead Management:: </title>
   <meta content='width=device-width,user-scalable=no' name='viewport'>
   <link rel="shortcut icon" href="assets/img/favicon.ico" />
   <!-- global css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/app.css" />
   <!-- end of global css -->

   <!--page level css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/custom.css" />

   <style>
      .fileUpload {
         position: relative;
         overflow: hidden;
         margin: 10px;
         float: right;
      }

      .fileUpload input.upload {
         position: absolute;
         top: 0;
         right: 0;
         margin: 0;
         padding: 0;
         font-size: 20px;
         cursor: pointer;
         opacity: 0;
         filter: alpha(opacity=0);
      }
   </style>

</head>
<script>
   var BASE_URL = "<?php echo base_url() ?>";
   var SITE_URL = "<?php echo site_url(); ?>";
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
         <!--main content-->
         <div class="row">

            <div class="col-md-12">
               <div class="card mrgn_top">
                  <div class="card-header txt_padding">
                     <h3 class="card-title">
                        <i class="fa fa-fw ti-file"></i> Bulk Upload Leads
                     </h3>
                     <span class="float-right d-none d-sm-block fnt_size txt_font">
                        <i class="fa fa-fw ti-angle-up clickable"></i>
                        <i class="fa fa-fw ti-close removecard"></i>
                     </span>
                  </div>
                  <div class="card-body">
                     <div class="row" style="margin-left:20px; margin-top:10px;">

                        <div class="fileUpload btn btn-primary">
                           <span><i class="fa fa-folder-open"></i> Browse to import</span>
                           <input type="file" class="upload" name="upload" id="upload" accept=".xls,.xlsx" />

                        </div>
                        <a href="<?php echo base_url(); ?>assets/excel/lead_bulk_upload_sample.xlsx"><img src="<?php echo base_url(); ?>assets/img/icon-download.png" style="float:right; margin-top: 15px; margin-left:10px;" title="Download Sample XL"></a>

                     </div>
                     <div class="col-sm-6">
                        <div class="alert alert-info small m-t-10">
                           * Allows only .xls and .xlsx<br>
                           * Download the sample file by clicking the green download icon.<br>
                           * Uploading file format should match with the sample file format.<br>
                           * Leads imported only if the file has zero error.<br>
                        </div>
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
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/common.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.ajaxfileupload.js"></script>
   <script src="<?php echo base_url(); ?>/assets/js/bootbox.js"></script>
   <script type="text/javascript" src="<?php echo base_url() ?>assets/js/custom_js/app/lead_upload.js"></script>

</body>

</html>