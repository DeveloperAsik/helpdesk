<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-layers font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"><?php echo $this->lang->line('global_ticket_create'); ?></span>
                </div>
                <div class="portlet-body form">
                    <form id="frmCreateTicket" role="form" style="padding-top:40px">
                        <div class="col-md-12">
                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <div class="form-control" id="code"></div>
                                    <label for="form_control_1"><?php echo $this->lang->line('global_ticket_number'); ?></label>
                                </div>
                                <div class="form-group col-md-4 form-md-line-input form-md-floating-label has-info" id="main_category">
                                    <select name="category_1" class="form-control edited first_ctg" id="category_1" required>
                                        <option value=""><?php echo $this->lang->line('global_select_one'); ?></option>
                                        <?php if (isset($category) && !empty($category)) : ?>
                                            <?php foreach ($category AS $key => $value): ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['txt']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>	
                                    </select>
                                    <label for="form_control_1"><?php echo $this->lang->line('global_category'); ?></label>
                                </div>
                                <div class=" col-md-1"></div>
                                <div class="form-group col-md-4 form-md-line-input form-md-floating-label has-info" id="sub_category">
                                    <select name="category_2" class="form-control edited second_ctg" id="category_2" required>
                                        <option value=""><?php echo $this->lang->line('global_select_category_first'); ?></option>
                                    </select>
                                    <label><?php echo $this->lang->line('global_problem_subject'); ?></label>
                                </div>
                                <div class="form-group col-md-4 form-md-line-input form-md-floating-label has-info">
                                    <select name="problem_impact" class="form-control edited" id="problem_impact" required>
                                        <option value=""><?php echo $this->lang->line('global_select_one'); ?></option>
                                        <?php if (isset($problem_impact) && !empty($problem_impact)) : ?>
                                            <?php foreach ($problem_impact AS $key => $value): ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['txt']; ?></option>														
                                            <?php endforeach; ?>
                                        <?php endif; ?>	
                                    </select>
                                    <label><?php echo $this->lang->line('global_ticket_problem_impact'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input">
                                <textarea name="issue" style="border: 1px solid #ccc; padding:10px; border-radius:5px;" class="form-control" rows="3" required placeholder="<?php echo $this->lang->line('global_issue_msg'); ?>"></textarea>
                                <label><?php echo $this->lang->line('global_issue'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- drop area -->
                            <div id="droparea" style="overflow: auto;">
                                <div class="dropareainner">
                                    <p class="dropfiletext"><?php echo $this->lang->line('global_drop_file_here'); ?></p>
                                    <p id="err"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">	
                            <div class="form-actions noborder">
                                <button type="submit" class="btn blue" id="issue_ticket" ><?php echo $this->lang->line('global_submit'); ?></button>
                            </div>
                        </div>						
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>		