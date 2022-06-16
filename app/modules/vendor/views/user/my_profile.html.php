<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase"><?php echo $this->lang->line('global_profile_title'); ?></span>
                </div>
            </div>
            <form class="form-horizontal" id="add_edit" role="form">
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="form-group " id="img_profile">
                            <label class="control-label col-md-3"> <?php echo $this->lang->line('global_img_upload'); ?></label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                    <div>
                                        <span class="btn red btn-outline btn-file">
                                            <!-- <span class="fileinput-new"> Select image </span> 
                                            <span class="fileinput-exists"> Change </span> -->
                                            <input type="file" name="photo" id="photo"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?php echo $this->lang->line('global_remove'); ?></a>
                                    </div>
                                </div>
                                <!-- <div class="clearfix margin-top-10">
                                    <span class="label label-success">NOTE!</span> Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead. 
                                </div> -->
                            </div>
                        </div>
                        <div class="form-group" style="height:30px">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_active'); ?></label>
                            <div class="col-md-9">
                                <input type="checkbox" class="make-switch" data-size="small" name="status"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_username'); ?></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="username" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_first_name'); ?></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="first_name" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_last_name'); ?></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="last_name" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_email_address'); ?></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" name="email" placeholder="Email Address"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_group'); ?></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="group_name" placeholder="Enter text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_password'); ?></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $this->lang->line('global_repassword'); ?></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" name="id" />
                            <button type="submit" class="btn green"><?php echo $this->lang->line('global_submit'); ?></button>
                            <button type="button" class="btn default"><?php echo $this->lang->line('global_cancel'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
