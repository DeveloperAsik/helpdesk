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
                <form method="POST" id="add_edit">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa fa-file-text-o"></i></i><?php echo $this->lang->line('global_ticket_detail'); ?> 
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="expand"> </a>
                                    </div>
                                </div>
                                <div class="portlet-body display-hide">
                                    <?php $this->load->view('includes/tools/detail_ticket_portlet.html.php'); ?>
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
                                                    <img style="width:100%" src="<?php echo static_url('tickets/'.$value['path']); ?>" />
                                                    <center>
                                                        <a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="<?php echo $value['path']; ?>"  data-id="<?php echo $value['id']; ?>" data-code="<?php echo $value['code']; ?>" href="javascript:;">
                                                           <?php echo $this->lang->line('global_view_more'); ?><i class="m-icon-swapright m-icon-white"></i>
                                                        </a>
                                                    </center>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="portlet-body">
                                        <h4>No data found!!!</h4>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="message" id="message" placeholder="Ketikkan pesan anda disini"></textarea>
                            </div>
                            <input type="text" name="ticket_id" id="ticket_id" value="<?php echo isset($ticket['id']) ? $ticket['id'] : ''; ?>" hidden/>
                            <a class="btn green" id="sbmt_message"><?php echo $this->lang->line('global_submit'); ?></a>
                            <a class="btn red" id="re_open" style="display:none" title="re Open this ticket" data-toggle="modal" href="#modal_re_open" data-id="<?php echo isset($ticket['id']) ? $ticket['id'] : ''; ?>"> <i class="fa fa-folder-open-o"></i><?php echo $this->lang->line('global_reopen'); ?></a>	
                            <a class="btn red-mint" id="close_ticket" ><?php echo $this->lang->line('global_ticket_close_btn'); ?></a>
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
<!-- /.modal -->
<div class="modal fade bs-modal-lg" id="modal_solve" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Are your sure to mark this ticket as 'Solve/Close' ?</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn green">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $this->load->view('includes/tools/reopen_ticket.html.php'); ?>
<?php $this->load->view('includes/tools/transfer_ticket.html.php'); ?>