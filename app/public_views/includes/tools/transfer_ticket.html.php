<div class="modal fade bs-modal-lg" id="modal_transfer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="frmTransfer">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('global_ticket_transfer_title'); ?> </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_ticket_code'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_code'); ?>" data-container="body"></i>
                                    <input class="form-control form-control-solid placeholder-no-fix" type="text" name="code_transfer_ticket" readonly="" required/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_ticket_category'); ?></label>
                                <div class="input-icon right">
                                    <select class="form-control ticket_transfer_category" name="ticket_transfer_category" id="ticket_transfer_category" required>
                                        <option value=""><?php echo $this->lang->line('global_select_one'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_problem_subject'); ?> Tiket</label>
                                <div class="input-icon right">
                                    <select class="form-control ticket_transfer_job" name="ticket_transfer_job" id="ticket_transfer_job">
                                        <option value=""><?php echo $this->lang->line('global_select_one'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_note'); ?></label>
                                <textarea class="form-control form-control-solid placeholder-no-fix" rows="3" name="note_transfer_ticket" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-group" style="height:30px">
                                    <label for="form_control_1"><?php echo $this->lang->line('global_change_category'); ?></label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="change_category"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>		
                <div class="modal-footer">
                    <input type="text" name="ticket_id_transfer_ticket" hidden />
                    <button type="submit" class="btn green" id="sbmt_form_transfer"><?php echo $this->lang->line('global_submit'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>