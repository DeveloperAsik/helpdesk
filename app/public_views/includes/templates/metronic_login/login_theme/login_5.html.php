<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset">
            <div class="login-bg" style="background-image:url(<?php echo static_url('templates/metronics/assets/pages/img/login/bg1.jpg') ?>)">
                <img class="login-logo" src="<?php echo static_url('templates/metronics/assets/pages/img/login/logo.png'); ?>" /> </div>
        </div>
        <div class="col-md-6 login-container bs-reset">
            <div class="login-content">
                <h1>Metronic Admin Login</h1>
                <p> Lorem ipsum dolor sit amet, coectetuer adipiscing elit sed diam nonummy et nibh euismod aliquam erat volutpat. Lorem ipsum dolor sit amet, coectetuer adipiscing. </p>
                <form action="javascript:;" class="login-form">
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="text" placeholder="Login" class="form-control login-username" id="login-username" name="username" /> </div>
                        <div class="col-xs-6">
                            <input type="password" placeholder="Password" class="form-control login-password" id="login-password" name="password" /> </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="rem-password">
                                <p>Remember Me
                                    <input type="checkbox" class="rem-checkbox" />
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-8 text-right">
                            <div class="forgot-password">
                                <a href="javascript:;">Forgot Password?</a>
                            </div>
                            <button class="btn blue" type="submit">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <div class="row bs-reset">
                    <div class="col-xs-4 bs-reset">
                        <ul class="login-social">
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-dribbble"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-8 bs-reset">
                        <div class="login-copyright text-right">
                            <p><?php echo isset($_ajax_var_configs->copyright) ? $_ajax_var_configs->copyright : '';?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>