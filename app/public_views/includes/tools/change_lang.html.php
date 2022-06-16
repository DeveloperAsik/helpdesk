<?php
$res = $this->session->userdata('_lang');
if (isset($res) && !empty($res)) {
    if ($res == "english") {
        $bhs = "Language";
        $lng = "English";
        $val = '<option value="english">English</option><option value="indonesian">Indonesian</option>';
    } elseif ($res == "indonesian") {
        $bhs = "Bahasa";
        $lng = "Indonesia";
        $val = '<option value="indonesian">Indonesia</option><option value="english">Inggris</option>';
    }
} else {
    $val = '<option value="english">English</option><option value="indonesian">Bahasa Indonesia</option>';
}
?>
<p>
<center>
    <input type="checkbox" name="bahasa" class="make-switch" data-size="small" data-on-text="&nbsp;English&nbsp;" data-off-text="&nbsp;Indonesian&nbsp;" />
</center>
</p>