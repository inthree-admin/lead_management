 <aside class="left-side sidebar-offcanvas">
     <!-- sidebar: style can be found in sidebar-->
     <section class="sidebar">
         <div id="menu" role="navigation">
             <div class="nav_profile">
                 <div class="media profile-left">
                     <a class="float-left profile-thumb" href="javascript:void(0);">
                         <img src="<?php echo base_url(); ?>assets/img/user.jpg" class="rounded-circle" alt="User Image"></a>
                     <div class="content-profile">
                         <h4 class="media-heading"><?php echo $this->session->userdata('username'); ?></h4>
                         <ul class="icon-list">
                             <li>
                                 <a href="javascript:void(0);" title="user">
                                     <i class="fa fa-fw ti-user"></i>
                                 </a>
                             </li>
                             <li>
                                 <a href="javascript:void(0);" title="lock">
                                     <i class="fa fa-fw ti-lock"></i>
                                 </a>
                             </li>
                             <li>
                                 <a href="javascript:void(0);" title="settings">
                                     <i class="fa fa-fw ti-settings"></i>
                                 </a>
                             </li>
                             <li>
                                 <a href="<?php echo site_url("auth/logout"); ?>" title="Logout">
                                     <i class="fa fa-fw ti-shift-right"></i>
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
             <?php 

            $seg1 = $this->uri->segment(1);
 
            ?>
             <ul class="navigation">
                 <li class="<?php if($seg1=="home") echo "active"; ?>" >
                     <a href="<?php echo site_url("home"); ?>">
                         <i class="menu-icon ti-desktop"></i>
                         <span class="mm-text ">Dashboard</span>
                     </a>
                 </li>
                 <li class="<?php if($seg1=="lead") echo "active"; ?>"  >
                     <a href="<?php echo site_url("lead"); ?>">
                         <i class="menu-icon ti-briefcase"></i>
                         <span class="mm-text ">New Lead</span>
                     </a>
                 </li>

             </ul>
             <!-- / .navigation -->
         </div>
         <!-- menu -->
     </section>
     <!-- /.sidebar -->
 </aside>