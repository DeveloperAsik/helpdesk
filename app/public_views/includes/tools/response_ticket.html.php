<div class="modal fade bs-modal-lg" id="modal_response" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" role="form" id="frmResponse">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <center><h4 class="modal-title"><?php echo $this->lang->line('global_response_take_open_ticket'); ?></h4></center>
                    <div class="col-md-12 col-sm-12" style="padding:20px">
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input">
                                <label for="form_control_1"><?php echo $this->lang->line('global_ticket_number'); ?></label>
                                <h4 id="code"></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input">
                                <label for="form_control_1"><?php echo $this->lang->line('global_ticket_create_date'); ?></label>
                                <h4 id="create_date"></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input">
                                <label for="form_control_1"><?php echo $this->lang->line('global_ticket_problem_impact'); ?></label>
                                <h4 id="impact"></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input">
                                <label for="form_control_1"><?php echo $this->lang->line('global_ticket_category'); ?></label>
                                <h4 id="category"></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-md-line-input">
                                <label for="form_control_1"><?php echo $this->lang->line('global_problem_subject'); ?></label>
                                <h4 id="job"></h4>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <div class="form-group form-md-line-input">
                                <div class="form-group" style="height:30px">
                                    <label for="form_control_1"><?php echo $this->lang->line('global_change_category'); ?></label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="change_category"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input">
                                <label for="form_control_1"><?php echo $this->lang->line('global_attachment'); ?></label>
                                <div class="img_attach" style="height:100px" id="img_attach"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input">
                                <label><?php echo $this->lang->line('global_issue'); ?></label>
                                <blockquote style="border:1px dashed #ccc; border-radius:7px">
                                    <p id="content"></p>
                                </blockquote>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label" style="border:1px #ccc solid; border-radius:5px; padding:10px">
                                <textarea class="form-control" rows="6" id="message_btn_submit_response_modal" name="message_btn_submit_response_modal" required></textarea>
                                <span class="err"></span>
                            </div>
                            <hr/>
                            <div class="form-group form-md-checkboxes">
                                <label><?php echo $this->lang->line('global_aggreement'); ?></label>
                                <div class="md-checkbox-inline">
                                    <div class="md-checkbox has-success">
                                        <input type="checkbox" name="agree" id="agree" class="md-check">
                                        <label for="agree">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> <?php echo $this->lang->line('global_aggree_response_ticket'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" name="ticket_id_btn_submit_response_modal" hidden />
                    <input type="text" name="ticket_code_btn_submit_response_modal" hidden />
                    <button type="submit" class="btn green" id="_btn_submit_response_modal" style="display:none"><?php echo $this->lang->line('global_submit'); ?></button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>