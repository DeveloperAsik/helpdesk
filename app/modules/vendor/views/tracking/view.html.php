<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="glyphicon glyphicon-search font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_track_header'); ?></span>
                </div>
                <div class="actions"><div class="chat_grup"></div></div>
            </div>
            <div class="portlet-body">
                <form method="POST" id="insert_message_chat">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa fa-file-text-o"></i><?php echo $this->lang->line('global_ticket_detail'); ?> 
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="expand"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body display-hide">
                                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="1" data-rail-color="blue" data-handle-color="red">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_code'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="Ticket Code" data-container="body"></i>
                                                    <input class="form-control" type="text" name="code" readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_create_date'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="Ticket Code" data-container="body"></i>
                                                    <input class="form-control" type="text" name="create_date"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_status'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="Ticket Code" data-container="body"></i>
                                                    <input class="form-control" type="text" name="ticket_status"  readonly=""/> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('global_ticket_problem_impact'); ?></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-info-circle tooltips" data-original-title="Ticket Code" data-container="body"></i>
                                                    <input class="form-control" type="text" name="problem_impact"  readonly=""/> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('global_issue'); ?></label>
                                                <textarea class="form-control" rows="3" name="content" readonly=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('global_description'); ?></label>
                                                <textarea class="form-control" rows="3" name="description" readonly=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-paperclip"></i><?php echo $this->lang->line('global_attachment'); ?>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="expand"> </a>
                                    </div>
                                </div>
                                <?php if (isset($files) && !empty($files)): ?>
                                    <div class="portlet-body display-hide" style="overflow-y:auto">
                                        <?php foreach ($files AS $key => $value): ?>
                                            <div class="col-md-2" style="margin-bottom:2px">
                                                <div class="dashboard-stat blue">
                                                    <img style="width:100%" src="<?php echo static_url('tickets/' . $value['path']); ?>" />
                                                    <center>
                                                        <a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="<?php echo $value['path']; ?>"  data-id="<?php echo $value['id']; ?>" data-code="<?php echo $value['code']; ?>" href="javascript:;">
                                                            <?php echo $this->lang->line('global_view_more'); ?> <i class="m-icon-swapright m-icon-white"></i>
                                                        </a>
                                                    </center>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="portlet-body">
                                        <h4>Tidak ditemukan data!!!</h4>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea required class="form-control" rows="20" style="min-height:300px" name="message" id="message" placeholder="Ketikkan pesan anda disini"></textarea>
                            </div>
                            <input type="text" name="job_id" id="job_id" hidden/>
                            <input type="text" name="ticket_id" id="ticket_id" hidden/>
                            <button type="submit" class="btn green" id="sbmt_message_chat"><?php echo $this->lang->line('global_submit'); ?></button>
                            <a class="btn red-mint" data-toggle="modal" data-id="<?php echo base64_encode($ticket['id']); ?>" href="#modal_close"><?php echo $this->lang->line('global_ticket_close_btn'); ?></a>
                            <a class="btn red" data-toggle="modal" data-id="<?php echo base64_encode($ticket['id']); ?>" href="#modal_transfer" title="Transfer"><?php echo $this->lang->line('global_transfer'); ?></a>
                        </div>
                        <div class="col-md-8" id="chatbox">
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-microphone font-green"></i>
                                        <span class="caption-subject bold font-green uppercase"> Telusur Tiket [<?php echo isset($code) ? $code : ''; ?>]</span>
                                        <span class="caption-helper"><?php echo isset($ticket['ticket_status']) ? $ticket['ticket_status'] : ''; ?></span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="timeline" style="height:50%; overflow:auto">
                                        <!-- TIMELINE ITEM -->
                                        <div class="timeline"></div>
                                        <!-- END TIMELINE ITEM -->									
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>

<div id="file_attach_mdl" class="modal">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-body">
                <div class="scroller" style="height:100%" data-always-visible="1" data-rail-visible1="1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile image selected">
                                <div class="tile-body">
                                    <span class="file"></span>
                                </div>
                                <div class="tile-object">
                                    <div id="media"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_transfer_open" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-backdrop fade" style="height: 563px;"></div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('global_transfer_notif'); ?>. <span class="ticket_code_sp"></span></h4>
            </div>
            <div class="modal-body">
                <label>
                    <p>This ticket is transfer into your user account, 
                        Please confirm and submit to change status this ticket into <b>PROGRESS</b></p>
                    <input type="checkbox" name="aggree" value="1" id="aggree"/><?php echo $this->lang->line('global_aggree_notif'); ?>
                    <span class="err"></span>
                </label>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="ticket_id_modal_transfer_open">
                <button type="submit" class="btn blue" id="opn_agreement_trans_tickt"><?php echo $this->lang->line('global_submit'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
$this->load->view('includes/tools/transfer_ticket.html.php');
$this->load->view('includes/tools/close_ticket.html.php');
