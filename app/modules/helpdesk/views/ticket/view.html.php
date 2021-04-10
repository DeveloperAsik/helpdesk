<style>
    #file_attach_mdl{
        z-index:99999999
    }
</style>
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-list-alt font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_ticket_list'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                        <thead>
                            <tr role="row" class="heading">
                                <!-- <th width="2%">
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
                                </th> -->
                                <th width="5%"> # </th>
                                <th width="15%"> <?php echo $this->lang->line('global_no_ticket'); ?> </th>
                                <th width="15%"> <?php echo $this->lang->line('global_issue'); ?> </th>
                                <th width="15%"> <?php echo $this->lang->line('global_category'); ?> </th>
                                <th width="15%"> <?php echo $this->lang->line('global_problem_subject'); ?>  </th>
                                <th width="15%"> <?php echo $this->lang->line('global_office_branch'); ?></th>
                                <th width="15%"> <?php echo $this->lang->line('global_create_date'); ?> </th>
                                <th width="15%"> <?php echo $this->lang->line('global_status'); ?> </th>
                               <!--  <th width="15%"> <?php echo $this->lang->line('global_solving_issue'); ?> </th> -->
                                <th width="15%"> <?php echo $this->lang->line('global_action'); ?></th>
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
                                    <label class="control-label">Code</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                                        <input class="form-control" type="text" name="name" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Title</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-info-circle tooltips" data-original-title="Email address" data-container="body"></i>
                                        <input class="form-control" type="text" name="name" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control" rows="3" name="description"></textarea>
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

<?php
$this->load->view('includes/tools/detail_ticket.html.php');
$this->load->view('includes/tools/reopen_ticket.html.php');
