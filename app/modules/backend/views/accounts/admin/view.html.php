<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_admin_list'); ?></span>
                </div>
                <div class="actions actDatatables">
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
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="dttbl_admin">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="2%">
                                    <div class="form-group form-md-checkboxes">
                                        <div class="md-checkbox-list">
                                            <div class="md-checkbox">
                                                <input type="checkbox" id="select_all" name="select_all" class="md-check">
                                                <label for="select_all">
                                                    <span></span>
                                                    <span class="check" style="left:20px;"></span>
                                                    <span class="box" style="left:14px;"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th width="5%"> # </th>
                                <th width="15%"> NIK </th>
                                <th width="15%"><?php echo $this->lang->line('global_username'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_first_name'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_last_name'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_email'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_group_name'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_status'); ?></th>
                            </tr>							
                        </thead>
                        <tbody></tbody>
                    </table>
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
            <form method="POST" id="add_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="title_mdl"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">NIK</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="nik" required=""/> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_username'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="username" required=""/> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_first_name'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="first_name" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_last_name'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="last_name" /> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">							
                                <div class="form-group" id="pswd_frm">
                                    <label class="control-label"><?php echo $this->lang->line('global_password'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="password"/> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_email'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="email" /> 
                                    </div>
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
                    <button type="button" data-action="close-modal" class="btn dark btn-outline"><?php echo $this->lang->line('global_close'); ?></button>
                    <button type="submit" class="btn green"><?php echo $this->lang->line('global_save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>