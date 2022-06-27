<style>
    #file_attach_mdl{
        z-index:99999;
    }
    #modal_detail{
        z-index:99999;
    }
</style>
<div class="row">
    <div class="col-md-12" id="def" hidden>
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-bordered table-checkable" id="default">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="5%"> # </th>	
                                <th width="5%">Info</th>
                                <th width="10%"><?php echo $this->lang->line('global_ticket_code'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_issue'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('global_category'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('global_problem_subject'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_office_branch'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('global_status'); ?></th>
                                <th width="10%"><?php echo $this->lang->line('global_create_date'); ?></th>
                                <!-- <th width="15%"><?php echo $this->lang->line('global_solving_issue'); ?></th> -->
                                <th width="15%"><?php echo $this->lang->line('global_action'); ?></th>
                            </tr>							
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
    <div class="col-md-12" id="trf" hidden>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Ticket Transfer
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""></a>
                </div>
            </div>
            <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1" data-toggle="tab"><?php echo $this->lang->line('global_transfer'); ?> <span class="trf"></span></a>
                    </li>
                    <li>
                        <a href="#tab_1_2" data-toggle="tab"><?php echo $this->lang->line('global_ticket_transfer_in'); ?> <span class="trf_in"></span></a>
                    </li>
                    <li>
                        <a href="#tab_1_3" data-toggle="tab"><?php echo $this->lang->line('global_ticket_transfer_out'); ?> <span class="trf_out"></span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_1_1"> 
                        <!-- Begin: life time stats -->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?></span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-bordered table-checkable" id="transfer">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th width="5%"> # </th>	
                                                <th width="5%">Info</th>
                                                <th width="10%"><?php echo $this->lang->line('global_ticket_code'); ?></th>
                                                <th width="15%"><?php echo $this->lang->line('global_issue'); ?></th>
                                                <th width="10%"><?php echo $this->lang->line('global_category'); ?></th>
                                                <th width="10%"><?php echo $this->lang->line('global_problem_subject'); ?></th>
                                                <th width="15%"><?php echo $this->lang->line('global_office_branch'); ?></th>
                                                <th width="10%"><?php echo $this->lang->line('global_status'); ?></th>
                                                <th width="10%"><?php echo $this->lang->line('global_create_date'); ?></th>
                                                <!-- <th width="15%"><?php echo $this->lang->line('global_solving_issue'); ?></th> -->
                                                <th width="15%"><?php echo $this->lang->line('global_action'); ?></th>
                                            </tr>							
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="tab-pane fade " id="tab_1_2"> 
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?></span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-bordered table-checkable" id="transfer_in">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th width="5%"> # </th>	
                                                <th width="5%">Info</th>
                                                <th width="10%"><?php echo $this->lang->line('global_ticket_code'); ?> </th>
                                                <th width="15%"><?php echo $this->lang->line('global_issue'); ?> </th>
                                                <th width="10%"><?php echo $this->lang->line('global_category'); ?></th>
                                                <th width="10%"> <?php echo $this->lang->line('global_problem_subject'); ?>  </th>
                                                <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?> </th>
                                                <th width="10%"><?php echo $this->lang->line('global_status'); ?></th>
                                                <th width="10%"><?php echo $this->lang->line('global_create_date'); ?></th>
                                                <!-- <th width="15%"> <?php echo $this->lang->line('global_solving_issue'); ?> </th> -->
                                                <th width="15%"><?php echo $this->lang->line('global_action'); ?></th>
                                            </tr>							
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>

                    <div class="tab-pane fade " id="tab_1_3"> 
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?></span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-bordered table-checkable" id="transfer_out">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th width="5%"> # </th>	
                                                <th width="5%">Info</th>
                                                <th width="10%"><?php echo $this->lang->line('global_ticket_code'); ?> </th>
                                                <th width="15%"><?php echo $this->lang->line('global_issue'); ?> </th>
                                                <th width="10%"><?php echo $this->lang->line('global_category'); ?></th>
                                                <th width="10%"> <?php echo $this->lang->line('global_problem_subject'); ?>  </th>
                                                <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?> </th>
                                                <th width="10%"><?php echo $this->lang->line('global_status'); ?></th>
                                                <th width="10%"><?php echo $this->lang->line('global_create_date'); ?></th>
                                                <!-- <th width="15%"> <?php echo $this->lang->line('global_solving_issue'); ?> </th> -->
                                                <th width="15%"><?php echo $this->lang->line('global_action'); ?></th>
                                            </tr>							
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="prog" hidden>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-hourglass-half"></i><?php echo $this->lang->line('global_ticket_progress'); ?> 
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""></a>
                </div>
            </div>
            <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tabsss_1_1" data-toggle="tab"><?php echo $this->lang->line('global_progress'); ?> <span class="prog_t"></span></a>
                    </li>
                    <li>
                        <a href="#tabsss_1_2" data-toggle="tab"><?php echo $this->lang->line('global_progress_reopen'); ?><span class="global_reopen"></span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tabsss_1_1"> 
                        <!-- Begin: life time stats -->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-list-alt font-dark"></i>
                                    <span class="caption-subject font-dark bold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?> Progress</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-bordered table-checkable" id="prog_def">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th width="5%"> # </th>
                                                <th width="5%">Info</th>
                                                <th width="10%"> <?php echo $this->lang->line('global_no_ticket'); ?> </th>
                                                <th width="15%"> <?php echo $this->lang->line('global_issue'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_category'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_problem_subject'); ?> </th>
                                                <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_create_date'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_status'); ?> </th>
                                                <!-- <th width="15%"> <?php echo $this->lang->line('global_solving_issue'); ?> </th> -->
                                                <th width="15%"> <?php echo $this->lang->line('global_action'); ?></th>
                                            </tr>                           
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End: life time stats -->
                    </div>
                    <div class="tab-pane fade" id="tabsss_1_2"> 
                        <!-- Begin: life time stats -->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-list-alt font-dark"></i>
                                    <span class="caption-subject font-dark bold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?> Re-Open</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-bordered table-checkable" id="prog_reopen">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th width="5%"> # </th>
                                                <th width="5%">Info</th>
                                                <th width="10%"> <?php echo $this->lang->line('global_no_ticket'); ?> </th>
                                                <th width="15%"> <?php echo $this->lang->line('global_issue'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_category'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_problem_subject'); ?> </th>
                                                <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_create_date'); ?> </th>
                                                <th width="10%"> <?php echo $this->lang->line('global_status'); ?> </th>
                                                <!-- <th width="15%"> <?php echo $this->lang->line('global_solving_issue'); ?> </th> -->
                                                <th width="15%"> <?php echo $this->lang->line('global_action'); ?></th>
                                            </tr>                               
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- End: life time stats -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('includes/tools/detail_ticket.html.php');
