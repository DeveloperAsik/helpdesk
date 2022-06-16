<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Curl
 *
 * @author user
 */
class Curl {

    //put your code here

    public function __construct() {
        $CI = & get_instance();
        $this->salt = $CI->config->item('salt', 'settings');
        $this->session_id = $CI->config->item('session_name', 'settings') . $CI->config->item('website_id', 'settings');
        $this->api_id = $CI->config->item('api_id', 'settings');
        $this->api_password = $CI->config->item('api_password', 'settings');
    }

    public function find($url = '', $find_type = '', $query_type = '', $return_format = 'xml', $options = array()) {
        $params = [
            'type' => 'auth',
            'api_id' => $this->api_id,
            'api_pass' => $this->api_password,
            'find_type' => $find_type,
            'query_type' => $query_type,
            'return_format' => $return_format,
            'options' => json_encode($options)
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'app/' . $query_type);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // execute!
        $response = curl_exec($ch);
        // close the connection, release resources used
        curl_close($ch);
        // do anything you want with your response
        return $response;
    }

    public function request($url = '', $return_format = 'xml', $options = array()) {
        $params = [
            'type' => 'auth',
            'api_id' => $this->api_id,
            'api_pass' => $this->api_password,
            'return_format' => $return_format,
            'options' => json_encode($options)
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // execute!
        $response = curl_exec($ch);
        // close the connection, release resources used
        curl_close($ch);
        // do anything you want with your response
        //d($response);
        return $response;
    }

    public function insert($url = '', $mode = 'default', $table_name = '', $value = array()) {
        $params = [
            'type' => 'auth',
            'api_id' => $this->api_id,
            'api_pass' => $this->api_password,
            'table_name' => $table_name,
            'mode' => $mode,
            'value' => json_encode($value)
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '/app/insert');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // execute!
        $response = curl_exec($ch);
        // close the connection, release resources used
        curl_close($ch);
        // do anything you want with your response
        return $response;
    }

    public function request_with_return($url = '', $api_url = '', $return_format = 'xml', $options = array()) {
        $res = $this->request($url . $api_url, $return_format, $options);
        if ($return_format == 'xml') {
            if (isset($res) && $res != 'empty-data') {
                $xml = simplexml_load_string(preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $res));
                $json = json_encode($xml);
                $array_data = json_decode($json, TRUE);
            } else {
                $array_data = array();
            }
            $val = '-';
            extract($array_data);
            $arr_key = array_keys($array_data['val']);
            if (!is_numeric($arr_key[0])) {
                return array($val);
            } else {
                if (isset($val) && !empty($val) && is_array($val)) {
                    return $val;
                } else {
                    return $array_data;
                }
            }
        } elseif ($return_format == 'json') {
            $array_data = json_decode($res, TRUE);
            return $array_data;
        }
    }

    public function rudr_instagram_api_curl_connect($api_url) {
        $connection_c = curl_init(); // initializing
        curl_setopt($connection_c, CURLOPT_URL, $api_url); // API URL to connect
        curl_setopt($connection_c, CURLOPT_RETURNTRANSFER, 1); // return the result, do not print
        curl_setopt($connection_c, CURLOPT_TIMEOUT, 20);
        $json_return = curl_exec($connection_c); // connect and get json data
        curl_close($connection_c); // close connection
        return json_decode($json_return); // decode and return
    }

}
