<!-- /.modal -->
<div class="modal fade bs-modal-lg" id="modal_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" id="frmDetail">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i><?php echo $this->lang->line('global_view_detail_ticket'); ?>

                            </div>
                            <div class="tools">
                                <span style="margin-right:20px;" class="modal-title"></span>
                                <a href="javascript:;" class="collapse" data-original-title="" title=""></a>
                            </div>
                        </div>
                        <div class="portlet-body" id="menunav">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_detail_ticket_1" data-toggle="tab">
                                        <?php echo $this->lang->line('global_content'); ?> </a>
                                </li>
                                <li>
                                    <a href="#tab_detail_ticket_2" data-toggle="tab">
                                        <?php echo $this->lang->line('global_attach'); ?> </a>
                                </li>
                                <li id="history">
                                    <a href="#tab_detail_ticket_3" data-toggle="tab">
                                        <?php echo $this->lang->line('global_history'); ?> </a>
                                </li>
                                <li id="history_ticket">
                                    <a href="#tab_detail_ticket_4" data-toggle="tab">
                                        <?php echo $this->lang->line('global_history_ticket'); ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab_detail_ticket_1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_code'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_code'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="code_modal_detail_ticket" readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_create_date'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_create_date'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="create_date_modal_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_status'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="ticket_status_modal_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_create_by'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_create_by'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="create_by_name_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_recreate_by'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_create_by'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="recreate_by_name_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_category'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="category_name_modal_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_problem_subject'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="job_category_name_modal_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_problem_impact'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_problem_impact'); ?>" data-container="body"></i>
                                                    <input class="form-control problem_impact" type="text" name="problem_impact_modal_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_office_branch'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                                                    <input class="form-control" type="text" name="branch_name_modal_detail_ticket"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('global_content'); ?></label>
                                                <textarea class="form-control" rows="3" name="content_modal_detail_ticket" readonly=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_detail_ticket_2"style="min-height:300px; overflow:auto">
                                    <div class="col-md-12" >
                                        <div class="portlet-body img_attach" id="img_attach"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_detail_ticket_3"style="height:300px; overflow:auto">
                                    <div class="col-md-12 history_chat" id="history_chat" style="width: 60%; padding-left: 30px;"></div>
                                </div>
                                <div class="tab-pane fade" id="tab_detail_ticket_4"style="height:300px; overflow:auto">
                                    <div class="col-md-12 history_ticket" id="history_ticket" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('includes/tools/img_view.html.php'); ?>