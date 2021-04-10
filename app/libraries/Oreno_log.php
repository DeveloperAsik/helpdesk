<?php

class Oreno_log {

    public function init_($data = array(), $path = '') {
        $this->run(json_encode($data), $path);
    }

    public function run($data = array(), $path = '') {
        $CI = & get_instance();
        $CI->load->helper('file');
        if (!write_file($path, $data)) {
            return false;
        } else {
            return true;
        }
    }

    public function read_file($path = '') {
        $string = read_file($path);
        return $string;
    }

    public function read_files($path = '') {
        $files = get_filenames($path);
        arsort($files);
        $fin_file = array_slice($files, 0, 10);
        $string = array();
        if ($files) {
            foreach ($fin_file AS $key => $val) {
                $string[] = $path . DS . $val;
            }
        }
        return $string;
    }

    public function create_path($dir_name = '', $real_path = '') {
        if (!is_dir($real_path)) {
            mkdir($real_path);
        }
        if (!is_dir($real_path . DS . $dir_name)) {
            mkdir($real_path . DS . $dir_name);
        }
    }

}
