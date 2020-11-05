<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="glyphicon glyphicon-filter"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_report_filter'); ?></span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" id="report_btn_table" autocomplete="off">
                    <div class="form-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_ticket_code'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="code" id="code"/> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="row">
                            <div class="col-md-9">
                                <button type="submit" class="btn green"><?php echo $this->lang->line('global_submit'); ?></button>
                                <button type="button" class="btn default" id="cancel"><?php echo $this->lang->line('global_cancel'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_report_ticket_title'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container tbl_result">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax" hidden>
                        <thead>
                            <tr>
                                <th width="5%"> # </th>
                                <th width="15%"><?php echo $this->lang->line('global_code'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_content'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_status'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_priority'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_category'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_date'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_action'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_active'); ?></th>
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