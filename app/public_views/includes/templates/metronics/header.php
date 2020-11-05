<div class="page-header navbar navbar-fixed-top" style="background-color:#192850">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <p style="float:left; margin: 5px 0; width:80%; font-size:25px; text-align:center">
                <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>dashboard">
                    <!--<img style="width:20%" src="<?php //echo static_url('images\logo\logo-imigrasi.png') ?>" alt="logo" />-->
                    <span style="color:#fff">HELPDESK</span>
                </a>
            </p>
            <div style="float:right; margin: 11px 0; width:20%; color:#000" class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">
                        <img alt="" class="img-circle" src="<?php echo (isset($_load_auth_config_var['img'])) ? static_url($_load_auth_config_var['img']) : static_url('templates/metronics/assets/layouts/layout/img/avatar3_small.jpg'); ?>" />
                        <span class="username username-hide-on-mobile"> <?php echo isset($_load_auth_config_var['email']) ? $_load_auth_config_var['email'] : ''; ?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <?php $this->load->view('includes/tools/change_lang.html.php'); ?>
                        </li>
                        <li>
                            <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>my-profile">
                                <i class="icon-user"></i> <?php echo $this->lang->line('global_profile_title'); ?> 
                            </a>
                        </li>
                        <!-- <li class="divider"> </li> -->
                        <!-- <li>
                            <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>lock-screen">
                                <i class="icon-lock"></i> <?php echo $this->lang->line('global_lockscreen_sidebar'); ?>
                            </a>
                        </li> -->
                        <li>
                            <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>logout">
                                <i class="icon-logout"></i> <?php echo $this->lang->line('global_logout'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
