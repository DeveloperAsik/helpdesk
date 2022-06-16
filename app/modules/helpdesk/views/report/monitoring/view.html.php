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
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Total keseluruhan tiket perbulan (<?php echo date('Y'); ?>)
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
                    <i class="fa fa-gift"></i>Jumlah tiket perbulan berdasarkan status tiket (<?php echo date('Y'); ?>) 
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
                    <i class="fa fa-gift"></i>Jumlah tiket progress yang diambil (<?php echo date('Y'); ?>) 
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