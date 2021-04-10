<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oreno_pos
 *
 */
class Oreno_pos {

    //put your code here
    public function __construct() {
        $CI = & get_instance();
        $CI->load->library(array('session'));
    }
	
	public function init_pos($options = array()){
		if($options){
			$result = $this->generate_session($options);
			if($result){
				return $result;
			}
		}
	}
	
	public function find($type = 'all', $options = array()){
		switch($type){
			case 'all':
				$session = $this->get_session($options['conditions']['transaction_id']);
				
			break;
			case 'first':
			break;
		}
	}
	
	protected function get_session($session_id = null){
		$sess = $this->session->all_userdata();
        if (isset($sess[$this->config->session_pos . $session_id]) && !empty($sess[$this->config->session_pos . $session_id])) {
            return $sess[$this->config->session_pos . $session_id];
        } else {
            return null;
        }
	}
	
	protected function generate_session($options = array()){
		$result['product'] = array(
			'sku' => '',
			'options' => array(
				'color'=>'',
				'size'=>'',
				'gender'=>'',
				'category_1'=>'',
				'category_2'=>'',
				'category_3'=>''
			),
			'photos' => '',
			'qty'=> '',
			'price' => ''
		);
		$result['session_pos'] = array(
			$options['conditions']['transaction_id'] => array(
				'datetime'=>'',
				'ip'=>'',
				'browser' =>'',
				'cashier_id' => '',
				'total_payment' => '',
				'return_payment' => '',
				'note' => ''
			)
		);
	}
}
?>