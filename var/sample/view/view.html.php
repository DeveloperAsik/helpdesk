<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">{view-header-title}</span>
                </div>
                <div class="actions">
                    <div class="btn-group col-md-12">
                        <a class="btn dark btn-outline sbold col-md-3" data-toggle="modal" href="#opt_add" id="opt_add">
                            Add
                        </a>
                        <a class="btn dark btn-outline sbold disabled col-md-3" data-toggle="modal" href="#opt_edit" data-value="edit" id="opt_edit" disabled="">
                            Edit
                        </a>
                        <div class="btn dark btn-outline sbold disabled col-md-3" data-toggle="modal" data-value="remove" id="opt_remove" disabled="">
                            Remove
                        </div>
                        <div class="btn dark btn-outline sbold disabled col-md-3" data-value="delete" id="opt_delete" disabled="">
                            Delete
                        </div>
                        <div class="btn dark btn-outline sbold col-md-3" data-value="refresh" id="opt_refresh">
                            Refresh
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="2%"><input type="checkbox" data-checkbox="icheckbox_minimal-grey" class="group-checkable" name="select_all"/></th>
                                <th width="5%"> # </th>
                                <th width="15%"> Name </th>
                                <th width="15%"> Status </th>
                                <th width="200"> Description </th>
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
<div class="modal fade" id="modal_add_edit" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Modal Title</h4>
			</div>
			<div class="modal-body"> Modal body goes here </div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
				<button type="button" class="btn green">Save changes</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal_add_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="add_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-action="close-modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="title_mdl"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                                        <input class="form-control" type="text" name="name" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" name="description"></textarea>
                                </div>
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
                    <button type="button" data-action="close-modal" class="btn dark btn-outline">Close</button>
                    <button type="submit" class="btn green">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>