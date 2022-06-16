<style>
    pre{
        font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;
        margin-bottom: 10px;
        overflow: auto;
        width: auto;
        padding: 5px;
        background-color: #eee;
        padding-bottom: 20px;
        max-height: 600px;
    }
</style>
<div class="row">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab_a_1" data-id="1" data-toggle="tab"> Class </a>
        </li>
        <li>
            <a href="#tab_a_2" data-id="2" data-toggle="tab"> Query </a>
        </li>
        <li>
            <a href="#tab_a_3" data-id="3" data-toggle="tab"> Test </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="tab_a_1">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase">{view-header-title}</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form method="POST" id="gen_mvc">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Module</label><br/>
                                        <select class="form-control module" name="module" id="module">
                                            <option>-- select one --</option>
                                            <?php echo isset($modules) ? $modules : ''; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">class_name_ucfirst</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                            <input class="form-control" type="text" name="class_name_ucfirst" /> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">class_base_url</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                            <input class="form-control" type="text" id="class_base_url" name="class_base_url" /> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">class_path</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                            <input class="form-control" type="text" name="class_path" /> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Radio</label>
                                        <div class="col-md-9">
                                            <div class="radio-list">
                                                <label>
                                                    <div class="radio">
                                                        <span>
                                                            <input type="radio" name="exist_model" id="exist_model" value="1">
                                                        </span>
                                                    </div> Create New Model 
                                                </label>
                                                <label>
                                                    <div class="radio" >
                                                        <span class="checked">
                                                            <input type="radio" name="exist_model" id="exist_model" value="2">
                                                        </span>
                                                    </div> Select exist Model
                                                </label>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="nmodel" hidden>
                                        <label class="control-label">model_name_ucfirst</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                            <input class="form-control" type="text" name="model_name_ucfirst" /> 
                                        </div>
                                    </div>
                                    <div class="form-group" style="height:30px">
                                        <label>Active</label><br/>
                                        <input type="checkbox" class="make-switch" data-size="small" name="status"/>
                                    </div>
                                </div>
                                <div class="col-md-3"><pre><code><div id="result_generate"></div></code></pre></div>
                                <div class="col-md-6">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-id="1" data-toggle="tab"> Controller </a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-id="2" data-toggle="tab"> Model </a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> View
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="#tab_1_3" data-id="3" tabindex="-1" data-toggle="tab"> HTML </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_1_4" data-id="3" tabindex="-1" data-toggle="tab"> JS </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_1_1">
                                            <pre><code id="controller_layout"></code></pre>
                                        </div>
                                        <div class="tab-pane fade" id="tab_1_2">
                                             <pre><code id="model_layout"></code></pre>
                                        </div>
                                        <div class="tab-pane fade" id="tab_1_3">
                                             <pre><code id="view_html_layout"></code></pre>
                                        </div>
                                        <div class="tab-pane fade" id="tab_1_4">
                                            <pre><code id="view_js_layout"></code></pre>
                                        </div>
                                    </div>
                                <div class="clearfix margin-bottom-20"> </div>
                                </div>
                            </div>
                        <br/>
                        <br/>
                        <button type="submit" class="btn green">Execute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab_a_2">
            <div class="col-md-3">
                <div class="btn-group-vertical" style="width:100%">
                    <div class="btn red reset_btn" data-id="1">Reset All Admin User</div>
                    <div class="btn btn-default reset_btn" data-id="2">Reset All Vendor User</div>
                    <div class="btn btn-default reset_btn" data-id="3">Reset All Branch User</div>
                    <div class="btn btn-default reset_btn" data-id="4">Reset All Ticket</div>
                    <div class="btn btn-default reset_btn" data-id="5">Reset All active ticket open</div>
                </div>
            </div>
            <div class="col-md-9"><pre><code><div id="res_query"></div></code></pre></div>
        </div>
        <div class="tab-pane fade" id="tab_a_3">
            <form role="form" >
                <div class="col-md-6">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <div class="form-control" id="code"></div>
                            <label for="form_control_1"><?php echo $this->lang->line('global_ticket_number'); ?> </small>Auto Generate</small></label>
                        </div>
                        <div class="form-group col-md-4 ">
                            <label class="control-label">Total Ticket to create</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                <input class="form-control" type="text" name="total" /> 
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form_control_1"><?php echo $this->lang->line('global_user'); ?></label>
                            <select name="user" id="user" class="form-control edited">
                                <option value="0"><?php echo $this->lang->line('global_select_one'); ?></option>
                                <?php if (isset($users) && !empty($users)) : ?>
                                    <?php foreach ($users AS $key => $value): ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['username'] .' ('.$value['group_name'].')'; ?></option>														
                                    <?php endforeach; ?>
                                <?php endif; ?>	
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="checkbox-list">
                                <label>
                                    <input type="checkbox" name="random_create_date" id="random_create_date" value="1"> Set Random created date
                                </label>
                            </div>
                        </div>
                        <div class=" col-md-12"></div>
                        <div class="form-group col-md-6">
                            <label for="form_control_1"><?php echo $this->lang->line('global_ticket_status'); ?></label>
                            <select name="ticket_status" id="ticket_status" class="form-control edited">
                                <option value="0"><?php echo $this->lang->line('global_select_one'); ?></option>
                                <?php if (isset($ticket_status) && !empty($ticket_status)) : ?>
                                    <?php foreach ($ticket_status AS $key => $value): ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>														
                                    <?php endforeach; ?>
                                <?php endif; ?>	
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="main_category">
                            <label for="form_control_1"><?php echo $this->lang->line('global_category'); ?></label>
                            <select name="category_1" class="form-control edited first_ctg" id="first_ctg">
                                <option value="0"><?php echo $this->lang->line('global_select_one'); ?></option>
                                <?php if (isset($category) && !empty($category)) : ?>
                                    <?php foreach ($category AS $key => $value): ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>														
                                    <?php endforeach; ?>
                                <?php endif; ?>	
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="main_category">
                            <label><?php echo $this->lang->line('global_problem_subject'); ?></label>
                            <select name="category_2" class="form-control edited second_ctg" id="second_ctg">
                                <option value="0"><?php echo $this->lang->line('global_select_category_first'); ?></option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo $this->lang->line('global_ticket_problem_impact'); ?></label>
                            <select name="problem_impact" class="form-control edited" id="problem_impact">
                                <option value="0"><?php echo $this->lang->line('global_select_one'); ?></option>
                                <?php if (isset($problem_impact) && !empty($problem_impact)) : ?>
                                    <?php foreach ($problem_impact AS $key => $value): ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>														
                                    <?php endforeach; ?>
                                <?php endif; ?>	
                            </select>
                        </div>
                        <div class="form-group col-md-12"> 
                            <label><?php echo $this->lang->line('global_issue'); ?></label>
                            <textarea name="issue" style="border: 1px solid #ccc; padding:10px; border-radius:5px;" class="form-control" rows="3" placeholder="<?php echo $this->lang->line('global_issue_msg'); ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <pre><code><div id="res_query_ticket" style="min-height:300px"></div></code></pre>
                </div>			
                <div class="col-md-12">	
                    <div class="form-actions noborder">
                        <button type="button" class="btn blue" id="ticket_batch_request" ><?php echo $this->lang->line('global_submit'); ?></button>
                    </div>
                </div>				
            </form>
        </div>
    </div>
</div>