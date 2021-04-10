<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Ticket Detail 
                </div>
                <div class="tools">
                    <a href="javascript:;" class="expand"> </a>
                </div>
            </div>
            <div class="portlet-body display-hide">
                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible="1" data-rail-color="blue" data-handle-color="red">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Ticket Code</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                <input class="form-control" type="text" name="code" readonly=""/> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Ticket Create Date</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                <input class="form-control" type="text" name="create_date"  readonly=""/> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Ticket Status</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                <input class="form-control" type="text" name="ticket_status"  readonly=""/> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" name="description" readonly=""></textarea>
                        </div>
                    </div>
                    <div class="col-md-8">					
                        <div class="form-group">
                            <label class="control-label">Ticket Category</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                <input class="form-control" type="text" name="category"  readonly=""/> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Ticket Job Category</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-container="body"></i>
                                <input class="form-control" type="text" name="job_category"  readonly=""/> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Issue</label>
                            <textarea class="form-control" rows="3" name="content" readonly=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($files) && !empty($files)): ?>
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Ticket Attachment 
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="expand"> </a>
                    </div>
                </div>
                <div class="portlet-body display-hide" style="overflow-y:auto">
                    <?php foreach ($files AS $key => $value): ?>
                        <div class="col-md-2" style="margin-bottom:2px">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="desc">
                                        <small style="font-size:12px" title="<?php echo $value['path']; ?>"><?php echo $value['code']; ?></small>
                                    </div>
                                </div>
                                <a class="more f_attachment" data-toggle="modal" href="#file_attach_mdl" data-path="<?php echo $value['path']; ?>"  data-id="<?php echo $value['id']; ?>" data-code="<?php echo $value['code']; ?>" href="javascript:;">
                                    View more <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-12">
        <div class="form-group">
            <textarea class="form-control message" id="message" rows="3" name="message" placeholder="Type your message to make a note for this ticket."></textarea>
        </div>
        <button type="submit" class="btn green" id="mark_as_solve">Mark As Solve</button>
    </div>
</div>
<div id="file_attach_mdl" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile image selected">
                                <div class="tile-body">
                                    <span class="file"></span>
                                </div>
                                <div class="tile-object">
                                    <div id="media"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>