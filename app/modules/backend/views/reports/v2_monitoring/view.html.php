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
    <div class="portlet box purple">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title="">
                </a>
                <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="#tab_2_1" data-toggle="tab"> Data </a>
                </li>
                <li>
                    <a href="#tab_2_2" data-toggle="tab"> Grafik </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab_2_1">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase">{view-header-title}</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered table-hover table-checkable" id="ticket_dttable">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th width="5%"> # </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_ticket_code'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_issue'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_category'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_priority'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_job_category'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_create_date'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_status'); ?> </th>
                                                    <th width="15%"> <?php echo $this->lang->line('global_solving_issue'); ?> </th>
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
                <div class="tab-pane fade" id="tab_2_2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>Total tiket terbanyak per-kanim (<?php echo date('Y'); ?>)
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="total_ticket_per_kanim_legendPlaceholder">
                                    </div>
                                    <div id="total_ticket_per_kanim" class="chart">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>Total keselurahn tiket perbulan (<?php echo date('Y'); ?>)
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
                                    <div id="total_ticket_per_month_by_user_legendPlaceholder">
                                    </div>
                                    <div id="total_ticket_per_month_by_user" class="chart">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>