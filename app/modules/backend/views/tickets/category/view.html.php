<style>
    .treeview .list-group-item{cursor:pointer}.treeview span.indent{margin-left:10px;margin-right:10px}.treeview span.icon{width:12px;margin-right:5px}.treeview .node-disabled{color:silver;cursor:not-allowed}.node-treeview12{}.node-treeview12:not(.node-disabled):hover{background-color:#F5F5F5;} 
</style>
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_category_list'); ?></span>
                </div>
                <div class="actions actDatatables" style="display:none">
                    <div class="btn-group">
                        <a style="font-size:10px; text-align:center" title="Insert new" class="btn dark btn-outline sbold col-ms-2" data-toggle="modal" data-id="add" href="#modal_add_edit" id="opt_add">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        <a style="font-size:10px; text-align:center; display:none" title="Update exist" class="btn dark btn-outline sbold col-ms-2" data-toggle="modal" data-id="edit" href="#modal_add_edit" id="opt_edit">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a style="font-size:10px; text-align:center; display:none" title="Delete" class="btn dark btn-outline sbold col-ms-2" data-value="delete" data-id="delete" id="opt_delete">
                            <i class="fa fa-trash"></i>
                        </a>
                        <a style="font-size:10px; text-align:center" title="Refresh" class="btn dark btn-outline sbold col-ms-2" data-value="refresh" data-id="refresh" id="opt_refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="portlet blue box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Menu </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="tree_" class="tree-frm treeview"> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
<!-- /.modal -->
<div id="modal_add_edit" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="add_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="title_mdl"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Parent Name</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="parent_name" readonly/> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_name'); ?> (ENG)</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="name" /> 
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_name'); ?> (INA)</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="name_ina" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('global_icon'); ?></label>
                                    <select class="form-control" name="icon" id="icon">
                                        <option>-- select one --</option>
                                        <?php if (isset($icons) && !empty($icons)): ?>
                                            <?php foreach ($icons AS $key => $val): ?>
                                                <option value="<?php echo $val['id']; ?>"><i class="fa <?php echo $val['name']; ?>"></i><?php echo $val['name']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>	
                            </div>
                            <div class="col-md-7">							
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('global_description'); ?></label>
                                    <textarea class="form-control" rows="3" name="description"></textarea>
                                </div>
                                <div class="form-group" style="height:30px">
                                    <label><?php echo $this->lang->line('global_active'); ?></label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="status"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" name="id" hidden />
                    <input type="text" name="parent_id" hidden />
                    <input type="text" name="module_id" hidden />
                    <input type="text" name="level" hidden />
                    <button type="button" data-action="close-modal" class="btn dark btn-outline"><?php echo $this->lang->line('global_close'); ?></button>
                    <button type="submit" class="btn green" id="submit_add_edit"><?php echo $this->lang->line('global_submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>