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
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->open) ? $_ajax_var_ticket->open : 0; ?></span>
                </div>
                <div class="desc"> Open <?php echo $this->lang->line('global_ticket'); ?> </div>
            </div>
            <a class="more" href="<?php echo base_url('monitor/ticket/view/open'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->progress) ? $_ajax_var_ticket->progress : 0; ?></span></div>
                <div class="desc"> Progress <?php echo $this->lang->line('global_ticket'); ?> </div>
            </div>
            <a class="more" href="<?php echo base_url('monitor/ticket/view/progress'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->transfer) ? $_ajax_var_ticket->transfer : 0; ?></span>
                </div>
                <div class="desc"> Transfer <?php echo $this->lang->line('global_ticket'); ?> </div>
            </div>
            <a class="more" href="<?php echo base_url('monitor/ticket/view/transfer'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup"><?php echo isset($_ajax_var_ticket->close) ? $_ajax_var_ticket->close : 0; ?></span></div>
                <div class="desc"> Close <?php echo $this->lang->line('global_ticket'); ?> </div>
            </div>
            <a class="more" href="<?php echo base_url('monitor/ticket/view/close'); ?>"> <?php echo $this->lang->line('global_view_more'); ?>
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Total ticket per month
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="total_ticket_per_month_legendPlaceholder">
                </div>
                <div id="total_ticket_per_month" class="chart">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Total ticket per month by status ticket  
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="total_ticket_per_month_by_status_legendPlaceholder">
                </div>
                <div id="total_ticket_per_month_by_status" class="chart">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Total Progress ticket per month
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="total_ticket_per_month_progress_legendPlaceholder">
                </div>
                <div id="total_ticket_per_month_progress" class="chart">
                </div>
            </div>
        </div>
    </div>
</div>