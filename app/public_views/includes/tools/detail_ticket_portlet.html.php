<div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible="1" data-rail-color="blue" data-handle-color="red">
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('global_ticket_code'); ?></label>
            <div class="input-icon right">
                <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_code'); ?>" data-container="body"></i>
                <input class="form-control" type="text" name="code" readonly=""/> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('global_ticket_create_date'); ?></label>
            <div class="input-icon right">
                <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_create_date'); ?>" data-container="body"></i>
                <input class="form-control" type="text" name="create_date"  readonly=""/> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('global_ticket_status'); ?></label>
            <div class="input-icon right">
                <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                <input class="form-control" type="text" name="ticket_status"  readonly=""/> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('global_ticket_problem_impact'); ?></label>
            <div class="input-icon right">
                <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_problem_impact'); ?>" data-container="body"></i>
                <input class="form-control problem_impact" type="text" name="problem_impact"  readonly=""/> 
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('global_category'); ?></label>
            <div class="input-icon right">
                <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                <input class="form-control" type="text" name="category_name"  readonly=""/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo $this->lang->line('global_problem_subject'); ?></label>
            <div class="input-icon right">
                <i class="fa fa-info-circle tooltips" data-original-title="<?php echo $this->lang->line('global_ticket_status'); ?>" data-container="body"></i>
                <input class="form-control" type="text" name="job_category"  readonly=""/>
            </div>
        </div>
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