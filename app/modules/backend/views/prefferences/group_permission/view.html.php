<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">{view-header-title}</span>
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
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
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
                                <th width="15%"> Group </th>
                                <th width="15%"> Class </th>
                                <th width="15%"> Method </th>
                                <th width="15%"> Is Allowed </th>
                                <th width="15%"> Is Public </th>
                                <th width="15%"> Status </th>
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

<div class="modal fade in" id="modal_add_edit">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="add_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btn-close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Group Permission</h4>
                </div>
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Module</label><br/>
                                    <select class="form-control module" name="module" id="module">
                                        <option>-- select one --</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Group</label><br/>
                                    <select class="form-control group" name="group" id="group">
                                        <option>-- select one --</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Class</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="class" id="class"/> 
                                    </div>
                                </div>
                                <div class="form-group" id="method_choice">
                                    <label class="control-label">Method</label>
                                    <div class="col-md-12">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                <div class="radio" id="uniform-method_exist">
                                                    <span><input type="radio" class="method_exist" name="method_exist" id="method_exist" value="1" ></span>
                                                </div> Method Exist
                                            </label>
                                            <label class="radio-inline">
                                                <div class="radio" id="uniform-method_new">
                                                    <span class="checked"><input type="radio" class="method_exist" name="method_exist" id="method_new" value="0"></span>
                                                </div> Add New
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" hidden id="frmMltSlctMethod">
                                    <label class="control-label">Method</label><br/>
                                    <div class="col-md-12">
                                        <select multiple="multiple" class="multi-select" id="method" name="method[]"></select>
                                    </div>									
                                </div>
                                <div class="form-group" hidden id="frmMethodSelected">
                                    <label class="control-label">Method</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                        <input class="form-control" type="text" name="method2" id="method2" /> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" name="description"></textarea>
                                </div>
                                <div class="form-group" style="height:30px;">
                                    <label>Allowed</label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="allowed"/>
                                </div><br/>
                                <div class="form-group" style="height:30px;">
                                    <label>Public</label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="ispublic"/>
                                </div><br/>
                                <div class="form-group" style="height:30px">
                                    <label>Active</label><br/>
                                    <input type="checkbox" class="make-switch" data-size="small" name="status"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" name="id" hidden />
                    <input type="text" name="permission_id" hidden />
                    <button type="button" class="btn dark btn-outline btn-close" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn green">Save changes</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
