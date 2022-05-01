

    <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">
                <a href="<?php echo base_url(); ?>Dashboard" class="">
                    <img src="<?= base_url(); ?>images/profile/<?= $full['message']; ?>" alt="logo" width="230" class="md">
                    <img src="<?= base_url(); ?>images/profile/<?= $half['message']; ?>" alt="logo" height="57" width="70" class="sm">
                </a>

            </div>

            <div class="clearfix"></div><br/>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <ul class="nav side-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>Dashboard"><em class="fa fa-home"></em> Dashboard </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>slider"><em class="fa fa-sliders"></em> Slider </a>
                        </li>
                        <?php if(is_city_mode_enabled() == 1){ ?>
                        <li>
                            <a href="<?php echo base_url(); ?>city"><em class="fa fa-building-o"></em> City </a>
                        </li>
                        <?php }?>                        
                        <li>
                            <a href="<?php echo base_url(); ?>category"><em class="fa fa-list"></em> Category </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>radio_station"><em class="fa fa-microphone"></em> Radio Station </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>radio_station_report"><em class="fa fa-file"></em> User Reported Station </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>send_notifications"><em class="fa fa-bullhorn"></em> Send Notifications </a>
                        </li>
                        <li><a><em class="fa fa-cog"></em> Setting <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="<?php echo base_url(); ?>system_configurations">System Configurations</a></li>
                                <li><a href="<?php echo base_url(); ?>notification_settings">Notification Settings</a></li>
                                <li><a href="<?php echo base_url(); ?>about_us">About Us</a></li>
                                <li><a href="<?php echo base_url(); ?>privacy_policy">Privacy Policy</a></li>
                                <li><a href="<?php echo base_url(); ?>terms_conditions">Terms Conditions</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
            <!-- /sidebar menu -->

        </div>
    </div>

    <!-- top navigation -->
    <div class="top_nav">
        <div class="nav_menu">
            <nav>
                <div class="nav toggle">
                    <a id="menu_toggle"><em class="fa fa-bars"></em></a>
                </div>

                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a href="javascript:void(0)" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo base_url(); ?>images/user.png" alt="image">Admin &nbsp;
                            <span class=" fa fa-angle-down"></span>
                        </a>                    
                        <ul class="dropdown-menu dropdown-usermenu pull-right">    
                            <li><a href="<?php echo base_url(); ?>profile"><em class="fa fa-user pull-right"></em>Profile</a></li>
                            <li><a href="<?php echo base_url(); ?>resetpassword"><em class="fa fa-key pull-right"></em>Reset Password</a></li>                    
                            <li><a href="<?php echo base_url(); ?>logout"><em class="fa fa-sign-out pull-right"></em> Log Out</a></li>
                        </ul>
                    </li>
                </ul>

            </nav>
        </div>
    </div>
    <!-- /top navigation -->