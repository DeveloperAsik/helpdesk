<div class="page-body">
    <img class="page-lock-img" src="<?php echo static_url('templates/metronics/assets/pages/media/profile/profile.jpg') ?>" alt="">
    <div class="page-lock-info">
        <h1><?php echo isset($_load_auth_config_var['username']) ? $_load_auth_config_var['username'] : ''; ?></h1>
       <!--  <span class="email"> <?php echo isset($_load_auth_config_var['email']) ? $_load_auth_config_var['email'] : ''; ?> </span> -->
        <span class="locked" style="color: red"> Layar Terkunci </span>
        <form class="form-inline" class="unlock_screen" id="unlock_screen">
            <div class="input-group input-medium">
                <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
                <input type="text" name="id" value="<?php echo isset($_load_auth_config_var['user_id']) ? $_load_auth_config_var['user_id'] : ''; ?>" hidden/>
                <input type="text" name="email" value="<?php echo isset($_load_auth_config_var['email']) ? $_load_auth_config_var['email'] : ''; ?>" hidden/>
                <span class="input-group-btn">
                    <button type="submit" class="btn green icn-only ulsc">
                        <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </span>
            </div>
            <!-- /input-group -->
            <div class="relogin">
                <a style="color:#000" href="<?php echo base_backend_url('logout'); ?>"><u> Bukan <?php echo isset($_load_auth_config_var['username']) ? $_load_auth_config_var['username'] : ''; ?> ? </u></a>
            </div>
        </form>
    </div>
</div>
