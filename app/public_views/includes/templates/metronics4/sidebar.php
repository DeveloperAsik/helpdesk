<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler"> </div>
            </li>
            <!--<li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <!--<form class="sidebar-search " method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="<?php// echo $this->lang->line('global_search'); ?>..." name="global_search" id="global_search">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit disabled"><i class="icon-magnifier"></i></a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            <!--</li>-->
            <?php $this->load->view('includes/templates/metronics4/sidebar_menu/helpdesk.php') ?>	
            <?php $this->load->view('includes/templates/metronics4/sidebar_menu/backend.php') ?>		
            <?php $this->load->view('includes/templates/metronics4/sidebar_menu/vendor.php') ?>		
        </ul>
    </div>
</div>