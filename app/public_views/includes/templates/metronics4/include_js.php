<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/respond.min.js'); ?>"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/excanvas.min.js'); ?>"></script> 
<![endif]-->
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/jquery-migrate.min.js'); ?>" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/jquery-ui/jquery-ui.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/jquery.blockui.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/jquery.cokie.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/uniform/jquery.uniform.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<?php echo isset($_load_js) ? $_load_js : ''; ?>
<!-- BEGIN AJAX GLOBAL VARIABLE -->
<?php if (isset($_ajax_var_ticket) && !empty($_ajax_var_ticket)):; ?>
    <?php foreach ($_ajax_var_ticket AS $key => $val): ?>
        <?php echo '<script> var ' . $key . '_total = ' . $val . '</script>'; ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php
if (isset($_ticket_push) && !empty($_ticket_push)):
    $echo = '<script> ';
    $echo .= 'var ticket_push_' . ' = ' . $_ticket_push . ';';
    $echo .= '</script>';
    echo $echo;
endif;
?>
<?php if (isset($_lang) && !empty($_lang)): ?>
    <?php
    $echo = '<script> ';
    $echo .= 'var _lang' . ' = "' . $_lang . '";';
    $echo .= '</script>';
    echo $echo;
    ?>
<?php endif; ?>
<?php if (isset($_var_total_ticket_per_month) && !empty($_var_total_ticket_per_month)): ?>
    <?php
    $echo = '<script> ';
    $echo .= 'var _total_ticket_per_month' . ' = ' . $_var_total_ticket_per_month . ';';
    $echo .= '</script>';
    echo $echo;
    ?>
<?php endif; ?>
<?php echo isset($_ajax_var_configs) ? '<script>' . $_ajax_var_configs . '</script>' : ''; ?>
<?php echo isset($_ajax_var_template) ? '<script>' . $_ajax_var_template . '</script>' : ''; ?>
<?php echo isset($_load_ajax_var) ? '<script>' . $_load_ajax_var . '</script>' : ''; ?>
<?php echo isset($_load_auth_config_ajax_var) ? '<script>' . $_load_auth_config_ajax_var . '</script>' : ''; ?>
<?php isset($_var_template->_app_js) ? $this->load->view($_var_template->_app_js) : ''; ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo static_url('lib/single/base64.js') ?>" type="text/javascript"></script>
<script src="<?php echo static_url('lib/packages/jquery-validate/1.19.0/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo static_url('templates/metronics/assets/pages/scripts/ui-blockui.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/bootbox/bootbox.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap-toastr/toastr.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/pages/scripts/components-bootstrap-switch.min.js') ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo static_url('templates/metronics/assets/global/scripts/metronic.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/admin/layout4/scripts/layout.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/admin/layout4/scripts/demo.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/admin/pages/scripts/index3.js'); ?>" type="text/javascript"></script>
<script src="<?php echo static_url('templates/metronics/assets/admin/pages/scripts/tasks.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
    });
</script>
<script id="imageTemplate" type="text/x-jquery-tmpl"> 
    <div class="imageholder" style="width:200px;float:left">
        <figure>
            <img src="${filePath}" alt="${fileName}" />
            <figcaption>
                ${fileName} <br/>
                <span>Original Size: ${fileOriSize} KB</span><br/>
                <span>Upload Size: ${fileUploadSize} KB</span>                                                
            </figcaption>
        </figure>
    </div>
</script>
<?php isset($_var_template->_global_js) ? $this->load->view($_var_template->_global_js) : ''; ?>
<?php isset($_var_template->_view_js) ? $this->load->view($_var_template->_view_js) : ''; ?>
<!-- END JAVASCRIPTS -->