<!-- /.modal -->
<div class="modal fade" id="modal_close" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="frmClose">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?php echo $this->lang->line('global_close'); ?> Tiket</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-md-checkboxes">
                        <label><?php echo $this->lang->line('global_job_list'); ?></label>
                        <div class="md-checkbox-inline" id="job_list_"></div>
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('global_note'); ?><span class="required"> * </span></label>
                        <textarea class="form-control" rows="3" name="msg_close_ticket" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ticket_id_close_ticket" />
                    <button type="submit" class="btn green" id="finish_solving_ticket">Submit</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>