<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oreno_mail
 *
 */
class Oreno_mail {

    //put your code here
    public function __construct() {
        $CI = & get_instance();
        $CI->load->library(array('session', 'email'));
    }

    public function send($data = array(), $from = null, $to = null, $options = array(), $club_data = array()) {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $CI = & get_instance();
        $CI->load->model('Tbl_email_configs');
        $email_conf = $CI->Tbl_email_configs->find('first', array(
            'conditions' => array('is_active' => 1)
        ));
        $config = Array(
            'protocol' => $email_conf['protocol'],
            'smtp_host' => $email_conf['host'],
            'smtp_port' => $email_conf['port'],
            'smtp_user' => $email_conf['user'],
            'smtp_pass' => $email_conf['pass'],
            'mailtype' => $email_conf['mailtype'],
            'charset' => $email_conf['charset']
        );
        $CI->load->helper('email');
        if (valid_email($to) == true && $to != '' || $to != null) {
            $CI->load->library('email', $config);
            $CI->email->set_mailtype('html');
            $CI->email->set_newline("\r\n");
            //$CI->email->from($options['from_alias'], $options['from']);
            $CI->email->from($from[0], $from[1]);
            $CI->email->to($to, "\r\n");
            if (isset($options['cc']) && !empty($options['cc']) && is_array($options['cc'])) {
                foreach ($options['cc'] AS $key => $val) {
                    $CI->email->cc($val);
                }
            }
            if (isset($options['bcc']) && !empty($options['bcc']) && is_array($options['bcc'])) {
                foreach ($options['bcc'] AS $key => $val) {
                    $CI->email->bcc($val);
                }
            }
            if (isset($options['reply_to']) && !empty($options['reply_to'])) {
                $CI->email->reply_to($options['reply_to']);
            }
            $subject = '';
            if (isset($options['subject']) && !empty($options['subject'])) {
                $subject = $options['subject'];
            }
            $CI->email->subject($subject);
            $CI->email->message($CI->load->view($options['layout'], $data, true));
            $CI->email->set_mailtype("html");
            $res = $CI->email->send();
            if ($res == true) {
                return $res;
            } else {
                d($this->email->print_debugger());
            }
        } else {
            return false;
        }
    }

}
