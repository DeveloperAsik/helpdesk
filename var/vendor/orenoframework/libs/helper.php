<?php

if (!function_exists('debug')) {
  function debug($text) {
  	$time = microtime();
  	$time = explode(' ', $time);
  	$time = $time[1] + $time[0];
  	$start = $time;

    $trace = debug_backtrace();
    echo "<pre><strong>file: " . $trace[0]['file'] . ", line: " . $trace[0]['line'] . "</strong><br/><hr/>";
    var_dump($text);

  	$time = microtime();
  	$time = explode(' ', $time);
  	$time = $time[1] + $time[0];
  	$finish = $time;
  	$total_time = round(($finish - $start), 4);
  	echo '<br/>Page generated in '.$total_time.' seconds.';
      die;
  }
}

if (!function_exists('divide_domain')) {
  function divide_domain(){
  	$domain = $_SERVER['HTTP_HOST'];
  	$dmn = explode('.',$_SERVER['HTTP_HOST']);
    if(count($dmn) == 2){
        define('subdomain', false);
        $domain_name = $dmn[0];
        $domain_type = $dmn[1];
    }elseif(count($dmn) == 3){
        define('subdomain', true);
        define('subdomain_name', $dmn[0]);
        $subdomain_name = $dmn[0];
        $domain_name = $dmn[1];
        $domain_type = $dmn[2];
    }elseif(count($dmn) == 4){
        define('subdomain', false);
        $domain_name = $dmn[1] . $dmn[2] . $dmn[3] . $dmn[4];
    }elseif(count($dmn) == 5){
        define('subdomain', true);
        define('subdomain_name', $dmn[0]);
        $subdomain_name = $dmn[0];
        $domain_name = $dmn[1] . $dmn[2] . $dmn[3] . $dmn[4];
    }
  }
}

if (!function_exists('get_ip')) {
  function get_ip() {
      foreach (array('HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR', 'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED') as $key) {
          if (array_key_exists($key, $_SERVER) === true) {
              foreach (explode(',', $_SERVER[$key]) as $ip) {
                  if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                      return $ip;
                  }
              }
          }
      }
  }
}

if (!function_exists('verify_php')) {
  function verify_php(){
      $version = (float)phpversion();
      return $version;
  }
}
