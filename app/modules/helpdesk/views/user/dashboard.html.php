<style>
    #history_dttable_length{
        display:none;
    }

    #history_dttable_filter{
        display:none;
    }

    #history_dttable_info{
        display:none;
    }

    #history_dttable_paginate{
        display:none;
    }
</style>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat grey">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                </div>
                <br>
                <br>
                <div class="desc"> <?php echo $this->lang->line('global_create_ticket'); ?> </div>
            </div>
            <a class="more" href="<?php echo base_url('ticket/create'); ?>"> <?php echo $this->lang->line('global_open_form'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue" style="background-color: #5ccd18">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->open) ? $_ajax_var_ticket->open : 0; ?></span>
                </div>
                <div class="desc"> <?php echo $this->lang->line('global_ticket_open'); ?> </div>
            </div>
            <a style="background-color: #5ccd18" class="more" href="<?php echo base_url('ticket/view/open'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red" style="background-color: #ffb136">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->progress) ? $_ajax_var_ticket->progress : 0; ?></span></div>
                <div class="desc"> <?php echo $this->lang->line('global_ticket_progress'); ?> </div>
            </div>
            <a style="background-color: #ffb136" class="more" href="<?php echo base_url('ticket/view/progress'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->close) ? $_ajax_var_ticket->close : 0; ?></span></div>
                <div class="desc"> <?php echo $this->lang->line('global_ticket_close'); ?> </div>
            </div>
            <a class="more" href="<?php echo base_url('ticket/view/close'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="portlet light tasks-widget bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="glyphicon glyphicon-comment"></i>
                    <span class="caption-subject font-dark bold uppercase">
                        <?php echo $this->lang->line('global_current_ticket'); ?></span>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable" id="ticket_dttable">
                    <thead>
                        <tr role="row" class="heading">
                            <th width="2%">#</th>
                            <th width="15%"><?php echo $this->lang->line('global_no_ticket'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('global_issue'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('global_category'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('global_problem_subject'); ?></th>
                            <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('global_create_date'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('global_status'); ?></th>
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
<?php 
$this->load->view('includes/tools/detail_ticket.html.php'); 
$this->load->view('includes/tools/reopen_ticket.html.php'); 
?>
