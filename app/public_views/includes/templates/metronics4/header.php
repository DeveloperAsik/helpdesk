<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>dashboard">
                <h4 style="margin-top:12px">HELPDESK IMIGRASI</h4>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->

        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
            <form class="search-form" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" id="global_search" placeholder="Search..." name="global_search">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                    </span>
                </div>
            </form>
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide"></li>
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile"> <?php echo isset($_load_auth_config_var['email']) ? $_load_auth_config_var['email'] : ''; ?> </span>
                            <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                            <img alt="" class="img-circle" src="<?php echo (isset($_load_auth_config_var['img'])) ? static_url($_load_auth_config_var['img']) : static_url('templates/metronics/assets/layouts/layout/img/avatar3_small.jpg'); ?>"/>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <center><?php $this->load->view('includes/tools/change_lang.html.php'); ?></center>
                            </li>
                            <li>
                                <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>my-profile">
                                    <i class="icon-user"></i> <?php echo $this->lang->line('global_profile_title'); ?> 
                                </a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>lock-screen">
                                    <i class="icon-lock"></i> <?php echo $this->lang->line('global_lockscreen_sidebar'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo isset($_var_auth_conf->global_uri) ? $_var_auth_conf->global_uri : base_url(); ?>logout">
                                    <i class="icon-logout"></i> <?php echo $this->lang->line('global_logout'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>