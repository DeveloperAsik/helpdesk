<!-- BEGIN LOGIN FORM -->
<?php if (isset($login_layout) && !empty($login_layout)): ?>
    <?php $this->load->view('includes/templates/metronic_login/login_theme/login_' . $login_layout . '.html.php'); ?>
<?php endif; ?>