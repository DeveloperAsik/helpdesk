<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_employee_list'); ?></span>
                </div>
                <div class="actions actDatatables">
                    <div class="btn-group">
                        <a style="font-size:10px; text-align:center" title="Refresh" class="btn dark btn-outline sbold col-ms-2" data-value="refresh" data-id="refresh" id="opt_refresh">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="3%"> # </th>
                                <th width="8%">NIK</th>
                                <th width="15%"><?php echo $this->lang->line('global_name'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_email'); ?></th>
                                <th width="8%"><?php echo $this->lang->line('global_phone_number'); ?></th>
                                <th width="15%"><?php echo $this->lang->line('global_branch_code'); ?></th>
                                <th width="8%"><?php echo $this->lang->line('global_branch_name'); ?></th>
                                <th width="4%"><?php echo $this->lang->line('global_status'); ?></th>
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
<div id="import_user_office" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="import_file_kanim">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Import Pengguna</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Contoh format file (xlsx)</label>
                        <div class="col-md-9">
                            <a id="download_sample" data-filetype="xlsx" data-filename="sample_import_file" class="form-control-static"><i class="fa fa-cloud-download"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile" class="col-md-3 control-label">Import Pengguna</label>
                        <div class="col-md-9">
                            <input type="file" id="import_file" name="import_file"/>
                            <p class="help-block">
                                Unggah berkas disini.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-action="close-modal" data-dismiss="modal" class="btn dark btn-outline"><?php echo $this->lang->line('global_close'); ?></button>
                    <button type="submit" class="btn green"><?php echo $this->lang->line('global_submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal_add_edit" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="add_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="title_mdl"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-4">
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
                                        <input class="form-control" type="text" name="fname" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_last_name'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="lname" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_email'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="email" /> 
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_password'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="password" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_phone_number'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="phone" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_group_user'); ?></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="group" placeholder="employee" readonly="" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo $this->lang->line('global_office_branch'); ?></label>
                                    <select class="form-control" name="branch" id="branch">
                                        <option><?php echo $this->lang->line('global_select_one'); ?></option>
                                        <?php if (isset($branchs) && !empty($branchs)): ?>
                                            <?php foreach ($branchs AS $key => $val): ?>
                                                <option value="<?php echo $val['id']; ?>"><?php echo $val['code']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group" style="height:30px">
                                    <label><?php echo $this->lang->line('global_active'); ?></label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="status_frm"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id"/>
                    <button type="button" data-action="close-modal" data-dismiss="modal" class="btn dark btn-outline"><?php echo $this->lang->line('global_close'); ?></button>
                    <button type="submit" class="btn green"><?php echo $this->lang->line('global_save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>