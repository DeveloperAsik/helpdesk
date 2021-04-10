<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo static_url('lib/css/fonts.googleapis.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/plugins/uniform/css/uniform.default.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<link href="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap-toastr/toastr.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') ?>" rel="stylesheet" type="text/css">

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS
<link href="<?php //echo static_url('templates/metronics/assets/global/plugins/icheck/skins/all.css')   ?>" rel="stylesheet" type="text/css" /> -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo static_url('templates/metronics/assets/global/css/components-rounded.min.css') ?>" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/global/css/plugins.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="<?php echo static_url('templates/metronics/assets/layouts/layout/css/layout-2.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo static_url('templates/metronics/assets/layouts/layout/css/themes/light3.min.css') ?>" rel="stylesheet" type="text/css" id="style_color" />
<link href="<?php echo static_url('templates/metronics/assets/layouts/layout/css/custom.min.css') ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo static_url('templates/metronics/assets/global/plugins/jquery-notific8/jquery.notific8.min.css') ?>"/>
<!-- END THEME LAYOUT STYLES -->
<?php
$arr = '';
if (isset($_load_css) && !empty($_load_css)) {
    foreach ($_load_css AS $key => $val) {
        $arr .= '<link href="' . $val . '" rel="stylesheet" type="text/css" />';
    }
}
echo isset($arr) ? $arr : '';
?>
<style>
    th{
        text-align:center
    }
    .table{
        text-align:center
    }
    .dataTables_filter{
        float:right;
    }
    #upload{
        visibility:hidden;
        opacity:0;
        position:absolute;
    }
    #droparea{
        width:100%;
        min-height:220px;
        border:7px dashed #ccc;
        border-radius:10px;
        vertical-align:baseline;
        margin:0 auto;
        text-align:center;
        text-shadow:1px 1px 0 #fff;
    }
    #droparea p{
        margin:7px 0;
    }
    #droparea .dropareainner{
        margin-top:35px;
    }
    #droparea .dropfiletext{
        font-size:18px;
        font-weight:bold;
        color:#555;
    }
    #droparea .uploadbtn{
        border:1px solid #ccc;
        background-color:#f4f4f4;
        padding:2px 5px;
        margin-bottom:5px;
        border-radius:25px;
        cursor:pointer;
        font-weight:bold;
        color:#777;
    }
    #droparea .uploadbtn:hover{
        border-color:#777;
        color:#555;
    }
    #droparea.hover{
        border-color:#777;
        background-color:#fff;
    }
    .dz-preview{
        width:20%; float:left;
    }
    .dz-error-message{
        display:none;
    }
    .dz-success-mark{
        display:none;
    }
    .dz-error-mark{
        display:none;
    }


    .style_no_1{
         background-color:#fff;
    }
    .style_no_2{
         background-color:#ff3300;
         color:#fff;
    }
    .style_no_3{
         background-color:#ff9900;
         color:#fff;
    }
    /* .style_no_4{
         background-color:#ccff00;
         color:#666;
    }
    .style_no_5{
         background-color:#66ff00;
         color:#fff;
    } */
</style>