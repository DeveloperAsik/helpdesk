<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oreno_seo
 *
 * @author arif
 */
class Oreno_seo {

    //put your code here

    public function get_name($data = null, $replace_to = '_') {
        if ($data != null) {
            $_897uiy = strtolower(trim($data));
            $_d87yhf = str_replace(' ', $replace_to, $_897uiy);
            $_8d7aui = str_replace('__', $replace_to, $_d87yhf);
            return $_8d7aui;
        }
    }

}
