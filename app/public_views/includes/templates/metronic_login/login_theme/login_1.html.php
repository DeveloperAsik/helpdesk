<!--BEGIN LOGO -->
<!-- <div class="logo">
    <img style="width:10%"  src="<?php echo static_url('images\logo\logo-imigrasi.png') ?>" alt="" /> 
</div> -->
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <div class="logo">
    <img style="width:40%"  src="<?php echo static_url('images\logo\logo-imigrasi.png') ?>" alt="" />
    <h3 class="uppercase" style="color:#555"><b>Helpdesk Imigrasi<b></h3> 
    </div>
    <!-- <h3 class="uppercase" style="color:#555"><b>Helpdesk Imigrasi<b></h3> -->
        <!-- <br> -->
    <form class="login-form" method="post">
        <div class="form-group">
            <div class="input-icon" >
                <i class="fa fa-user" style="color: #666666"></i>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="<?php echo $this->lang->line('global_username'); ?>" name="username"/>
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-lock" style="color: #666666"></i>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="<?php echo $this->lang->line('global_password'); ?>" name="password"/> 
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase"><?php echo $this->lang->line('global_login'); ?></button>
        </div>        
    </form> 
</div>
<footer id="footer">
    <div class="text-center padder clearfix">
        <p>
            <small style="color: #fff"><?php echo isset($_ajax_var_configs->login_footer_note) ? $_ajax_var_configs->login_footer_note : ''; ?></small>
        </p>
    </div>
</footer>
<?php echo isset($_ajax_var_configs->copyright) ? $_ajax_var_configs->copyright : ''; ?> </div>