<style>
    label{
        font-weight: bold;
    }
    .note-image-dialog{
        z-index:9999999;
    }
</style>
<div class="modal fade bs-modal-lg" id="modal_re_open" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="frmReOpen" >
                <div class="modal-body">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i><?php echo $this->lang->line('global_view_detail_ticket'); ?>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" ></a>
                            </div>
                        </div>
                        <div class="portlet-body" id="menunav">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_re_open_ticket_1" data-toggle="tab">
                                        <?php echo $this->lang->line('global_content'); ?> </a>
                                </li>
                                <li>
                                    <a href="#tab_re_open_ticket_2" data-toggle="tab">
                                        <?php echo $this->lang->line('global_attach'); ?> </a>
                                </li>
                                <li id="history">
                                    <a href="#tab_re_open_ticket_3" data-toggle="tab">
                                        <?php echo $this->lang->line('global_history'); ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab_re_open_ticket_1">
                                    <div class="row">
                                        <form class="form-horizontal" role="form" id="sbmt_form_reopen">
                                            <div class="col-md-4">
                                                <div>
                                                    <label><?php echo $this->lang->line('global_ticket_code'); ?></label>
                                                    <div id="code_modal_re_open"></div>
                                                </div>
                                                <hr/>
                                                <div>
                                                    <label><?php echo $this->lang->line('global_create_date'); ?></label>
                                                    <div id="create_date_modal_re_open"></div>
                                                </div>
                                                <hr/>
                                                <div>
                                                    <label><?php echo $this->lang->line('global_ticket_status'); ?></label>
                                                    <div id="ticket_status_modal_re_open"></div>
                                                </div>
                                                <hr/>
                                                <div>
                                                    <label><?php echo $this->lang->line('global_category'); ?></label>
                                                    <div id="category_name_modal_re_open"></div>
                                                </div>
                                                <hr/>
                                                <div>
                                                    <label><?php echo $this->lang->line('global_problem_subject'); ?></label>
                                                    <div id="job_category_name_modal_re_open"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="portlet-body">
                                                    <hr/>
                                                    <div>
                                                        <label><?php echo $this->lang->line('global_handle'); ?></label>
                                                        <div id="handle_by_modal_re_open"></div>
                                                    </div>
                                                    <div>
                                                        <label><?php echo $this->lang->line('global_issue'); ?></label>
                                                        <div class="well" id="content_modal_re_open"></div>
                                                    </div>
                                                     <div>
                                                        <label><?php echo $this->lang->line('global_previous_close_message'); ?></label>
                                                        <div class="well" id="previously_solving_modal_re_open"></div>
                                                    </div>
                                                    <label><?php echo $this->lang->line('global_previous_reopen_message'); ?></label>
                                                    <div class="form-group" style="border:1px #ccc solid; border-radius:5px; padding:10px">

                                                        <textarea class="form-control" rows="3" id="message_modal_re_open" name="message_modal_re_open" placeholder="<?php echo $this->lang->line('global_why_reopen_msg'); ?>" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_re_open_ticket_2" style="min-height:300px; overflow:auto">
                                    <div class="col-md-12" >
                                        <div class="portlet-body img_attach_modal_re_open" id="img_attach_modal_re_open"></div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_re_open_ticket_3" style="height:300px; overflow:auto">
                                    <div class="col-md-12 history_chat_modal_re_open" id="history_chat_modal_re_open" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" name="ticket_id_modal_re_open" hidden />
                    <input type="text" name="ticket_code_modal_re_open" hidden />
                    <button type="submit" class="btn green" id="btn_sbmt_form_reopen"><?php echo $this->lang->line('global_submit'); ?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="file_modal_re_open" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
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