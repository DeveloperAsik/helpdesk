<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="glyphicon glyphicon-filter font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"><?php echo $this->lang->line('global_report_filter'); ?></span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" id="report_btn_table" autocomplete="off">
                    <div class="col-md-6">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $this->lang->line('global_start_date'); ?></label>
                                <div class="col-sm-2">
                                    <input class="form-control" type="text" name="from" id="from" style="width: 130px"/>
                                </div>

                                <label class="col-sm-3 control-label" style="margin-left: 10%;"><?php echo $this->lang->line('global_end_date'); ?>
                                </label>
                                <div class="col-sm-2">
                                    <input class="form-control" type="text" name="to" id="to" style="width:130px"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo $this->lang->line('global_report_status'); ?></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="ticket_status" id="ticket_status">
                                        <option value="0">-- Pilih Semua --</option>
                                        <?php if (isset($status) && !empty($status)): ?>
                                            <?php foreach ($status AS $key => $val): ?>
                                                <option value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo $this->lang->line('global_report_categories'); ?></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="ticket_category" id="ticket_category">
                                        <option value="0">-- Pilih Semua --</option>
                                        <?php if (isset($category) && !empty($category)): ?>
                                            <?php foreach ($category AS $key => $val): ?>
                                                <option value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo $this->lang->line('global_problem_subject'); ?></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="problem_subject" id="problem_subject">
                                        <option value="0">-- Pilih Semua --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><?php echo $this->lang->line('global_submit'); ?></button>
                                <button id="cancel" type="button" class="btn default"><?php echo $this->lang->line('global_cancel'); ?></button>
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
                    <i class="glyphicon glyphicon-file font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"><?php echo $this->lang->line('global_report_category_title'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container tbl_result" >
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax" hidden>
                        <thead>
                            
                            <tr>
                                <th width="5%"> # </th>
                                <th width="12%"> <?php echo $this->lang->line('global_code'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_category'); ?> </th>
                                <th width="15%"> <?php echo $this->lang->line('global_problem_subject'); ?>  </th>
                                <th width="12%"> <?php echo $this->lang->line('global_priority'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_issue'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_status'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_response_message'); ?> </th> 
                                <th width="12%"> <?php echo $this->lang->line('global_employee'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_closing_message'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_office_branch'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_ticket_reporter'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_contact'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_create_date'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_create_time'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_response_date'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_response_time'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_solving_date'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_solving_time'); ?> </th>
                                <th width="12%"> <?php echo $this->lang->line('global_response_total'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_solving_total'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_job_list'); ?></th>
                                <th width="15%"> <?php echo $this->lang->line('global_re_open'); ?></th>
                                <th width="12%"> <?php echo $this->lang->line('global_active'); ?> </th>
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