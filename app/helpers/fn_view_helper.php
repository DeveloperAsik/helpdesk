<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_content_file')) {

    function get_content_file($id = null) {
        $CI = &get_instance();
        $CI->load->model('Tbl_menu_pages');
        $res = $CI->Tbl_menu_pages->find('first', array(
            'conditions' => array('id' => $id)
        ));
        $content_id = 0;
        if (isset($res) && !empty($res)) {
            $content_id = $res['content'];
        }
        $CI->load->library(array('oreno_save_to_file'));
        echo $CI->oreno_save_to_file->read($content_id);
    }

}