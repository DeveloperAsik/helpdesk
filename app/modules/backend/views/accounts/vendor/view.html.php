<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_group_list'); ?></span>
                </div>
                <div class="actions actDatatables">
                    <div class="btn-group">
                        <a href="#import_user_vendor" style="font-size:10px; text-align:center" data-toggle="modal" title="Import User KSO (Vendor)" class="btn dark btn-outline sbold col-ms-2" data-value="import" data-id="import" id="opt_import">
                            <i class="fa fa-cloud-upload"></i>
                        </a>
                    </div>
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
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_reversed_1_1" data-toggle="tab"> Vendor </a>
                    </li>
                    <li>
                        <a href="#tab_reversed_1_2" data-toggle="tab"><?php echo $this->lang->line('global_vendor_user'); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_reversed_1_1">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover table-checkable" id="data_vendor">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="2%">
                                            <div class="form-group form-md-checkboxes">
                                                <div class="md-checkbox-list">
                                                    <div class="md-checkbox">
                                                        <input type="checkbox" id="select_all_vndr_" name="select_all_vndr_" class="md-check select_all_vndr_" />
                                                        <label for="select_all_vndr_">
                                                            <span></span>
                                                            <span class="check" style="left:20px;"></span>
                                                            <span class="box" style="left:14px;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="2%"> # </th>
                                        <th width="15%"><?php echo $this->lang->line('global_vendor_name'); ?></th>
                                        <th width="15%"><?php echo $this->lang->line('global_phone_number'); ?></th>
                                        <th width="15%"><?php echo $this->lang->line('global_fax'); ?></th>
                                        <th width="15%"><?php echo $this->lang->line('global_email'); ?></th>
                                        <th width="15%"><?php echo $this->lang->line('global_status'); ?></th>
                                    </tr>							
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_reversed_1_2">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover table-checkable" id="data_vendor_user">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="2%">
                                            <div class="form-group form-md-checkboxes">
                                                <div class="md-checkbox-list">
                                                    <div class="md-checkbox">
                                                        <input type="checkbox" id="select_all_usr_" name="select_all_usr_" class="md-check select_all_usr_">
                                                        <label for="select_all_usr_">
                                                            <span></span>
                                                            <span class="check" style="left:20px;"></span>
                                                            <span class="box" style="left:14px;"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                        <th width="5%"> # </th>
                                        <th width="15%">NIK</th>
                                        <th width="15%"><?php echo $this->lang->line('global_username'); ?></th>
                                        <th width="15%"><?php echo $this->lang->line('global_vendor_code'); ?></th>
                                        <th width="15%"><?php echo $this->lang->line('global_vendor_name'); ?></th>
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
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
<!-- /.modal -->
<div id="import_user_vendor" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="import_file_vendor">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Import Pengguna KSO (Vendor)</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Contoh format file (xlsx)</label>
                        <div class="col-md-9">
                            <a id="download_sample" data-filetype="xlsx" data-filename="sample_import_file_vendor" class="form-control-static"><i class="fa fa-cloud-download"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile" class="col-md-3 control-label">Import Pengguna KSO (Vendor)</label>
                        <div class="col-md-9">
                            <input type="file" name="import_file_vendor" id="import_file_vendor" />
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
<div id="modal_add_edit_vendor" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="frmVendor">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="title_frm_vendor_mdl"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:380px" data-always-visible="1" data-rail-visible1="1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Code</label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="vndr_code" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_name'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips"  data-container="body"></i>
                                    <input class="form-control" type="text" name="vndr_name" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_email'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="vndr_email" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_phone_number'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="vndr_phone" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_fax'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="vndr_fax" /> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('global_address'); ?></label>
                                <textarea class="form-control" rows="3" name="vndr_address"></textarea>
                            </div>
                            <div class="form-group">
                                <label><?php echo $this->lang->line('global_description'); ?></label>
                                <textarea class="form-control" rows="3" name="vndr_description"></textarea>
                            </div>
                            <div class="form-group" style="height:30px">
                                <label><?php echo $this->lang->line('global_aktif'); ?></label><br/>
                                <input type="checkbox" class="make-switch" data-size="small" name="status_vndr_frm"/>
                            </div><br/>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <input type="text" name="frm_vendor_id" hidden />
                    <input type="text" name="frm_vendor_user_id" hidden />
                    <button type="button" data-action="close-modal" class="btn dark btn-outline"><?php echo $this->lang->line('global_close'); ?></button>
                    <button type="submit" class="btn green"><?php echo $this->lang->line('global_save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_add_edit_vendor_user" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="frmVendorUser">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="title_frm_vendor_user_mdl"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:380px" data-always-visible="1" data-rail-visible1="1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">NIK</label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="nik" /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_username'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips"  data-container="body"></i>
                                    <input class="form-control" type="text" name="user_name" /> 
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
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_email'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                                    <input class="form-control" type="text" name="email" /> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('global_phone_number'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="phone" /> 
                                </div>
                            </div>
                            <div class="form-group" id="div_password">
                                <label class="control-label"><?php echo $this->lang->line('global_set_password'); ?></label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                    <input class="form-control" type="text" name="password" /> 
                                </div>
                            </div>
                            <div class="form-group" id="div_vendor">
                                <label>Vendor</label>
                                <select class="form-control" name="vendor_list" id="vendor_list">
                                    <option><?php echo $this->lang->line('global_select_one'); ?></option>
                                </select>
                            </div>
                            <div class="form-group" style="height:30px">
                                <label><?php echo $this->lang->line('global_status'); ?></label><br/>
                                <input type="checkbox" class="make-switch" data-size="small" name="status"/>
                            </div><br/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" name="frm_vendor_user_id" hidden />
                    <input type="text" name="frm_vendor_user_user_id" hidden />
                    <button type="button" data-action="close-modal" class="btn dark btn-outline"><?php echo $this->lang->line('global_close'); ?></button>
                    <button type="submit" class="btn green"><?php echo $this->lang->line('global_save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

