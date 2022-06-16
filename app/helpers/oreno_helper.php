<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('base_frontend_url')) {

    function base_frontend_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('base_frontend_url') . $link;
    }

}

if (!function_exists('base_backend_url')) {

    function base_backend_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('base_backend_url') . $link;
    }

}

if (!function_exists('base_developer_url')) {

    function base_developer_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('base_developer_url') . $link;
    }

}


if (!function_exists('base_helpdesk_url')) {

    function base_helpdesk_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('base_helpdesk_url') . $link;
    }

}

if (!function_exists('base_pos_url')) {

    function base_pos_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('base_pos_url') . $link;
    }

}

if (!function_exists('base_api_url')) {

    function base_api_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('base_api_url') . $link;
    }

}

if (!function_exists('app_url')) {

    function app_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('app_url') . $link;
    }

}

if (!function_exists('app_modules_url')) {

    function app_modules_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('app_modules_url') . $link;
    }

}

if (!function_exists('static_url')) {

    function static_url($link = '') {
        $CI = & get_instance();
        return $CI->config->item('static_url') . $link;
    }

}

if (!function_exists('global_uri')) {

    function global_uri($prefix = '', $data = array()) {
        $function = 'base_' . $prefix . '_url';
        if (function_exists($function)) {
            if (isset($data) && !empty($data)) {
                return $function($data);
            } else {
                return $function();
            }
        }
    }

}

if (!function_exists('generate_number')) {

    function generate_number($length = null) {
        $char = '0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($char) - 1);
            $string .= $char[$pos];
        }
        return $string;
    }

}


if (!function_exists('generate_code')) {

    function generate_code($length = null, $type = 'auto') {
        if ($type == 'auto') {
            $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
        } elseif ($type == 'l') {
            $char = 'abcdefghijklmnopqrstuvwxyz123456789';
        } elseif ($type == 'u') {
            $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        }
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($char) - 1);
            $string .= $char[$pos];
        }
        return $string;
    }

}

if (!function_exists('get_browser')) {

    function get_browser($length = null) {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";
//First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

// Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }
// finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
// we have no matching number just continue
        }
// see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
//we will have two since we are not using 'other' argument yet
//see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }
// check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
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

if (!function_exists('create_file')) {

    function create_file($name = '', $data = "") {
        if (!write_file($name, $data)) {
            return false;
        } else {
            return true;
        }
    }

}

if (!function_exists('date_now')) {

    function date_now() {
        return gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
    }

}

if (!function_exists('fn_date_diff')) {

    function fn_date_diff($date_1, $date_2) {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        $times = array(
            'year' => $interval->y,
            'month' => $interval->m,
            'day' => $interval->d,
            'hour' => $interval->h,
            'minute' => $interval->i,
            'second' => $interval->s
        );
        $res = '';
        foreach ($times AS $key => $val) {
            if ($key == 'year' && $val > 0) {
                $res = $val . ' year';
            }

            if ($key == 'month' && $val <= 12 && $val > 0) {
                $res = $val . ' month';
            }

            if ($key == 'day' && $val < 31 && $val > 0) {
                $res = $val . ' day';
            }

            if ($key == 'hour' && $val < 24 && $val > 0) {
                $res = $val . ' hour';
            }
            if ($res == '') {

                if ($key == 'minute' && $val < 24 && $val > 0) {
                    $res = $val . ' min';
                }

                if ($key == 'second' && $val < 24 && $val > 0) {
                    $res = $val . ' sec';
                }
            }
        }
        return $res;
    }

}

if (!function_exists('fn_date_diff_ticket')) {

    function fn_date_diff_ticket($date_1, $date_2, $type = 'min') {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        $times = array(
            'year' => $interval->y,
            'month' => $interval->m,
            'day' => $interval->d,
            'hour' => $interval->h,
            'minute' => $interval->i,
            'second' => $interval->s
        );
        // 2 hari 22 jam 23 menit 22 detik
        // 1200 menit
        if ($type == 'min') {
            return $times['minute'];
        } else {
            return $times;
        }
    }

}

if (!function_exists('date_diff_sla')) {

    function date_diff_sla($date_1, $date_2) {
        $res = fn_date_diff_ticket($date_1, $date_2, 'all');
        $last_month = date('t', strtotime($date_1));
        if ($res) {
            $tm = 0;
            foreach ($res as $key => $value) {
                if ($value != 0) {
                    switch ($key) {
                        case 'hour';
                            $tm += ((int) $value * 60);
                            break;
                        case 'day';
                            $tm += (((int) $value * 24) * 60);
                            break;
                        case 'month';
                            $tm += ((((int) $value * 24) * 60 ) * $last_month);
                            break;
                    }
                }
            }
        }
        return $tm;
    }

}

if (!function_exists('idn_date')) {

    function idn_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
        if (trim($timestamp) == '') {
            $timestamp = time();
        } elseif (!is_int($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace("/S/", "", $date_format);
        $pattern = array(
            '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
            '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
            '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
            '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
            '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
            '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
            '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
            '/November/', '/December/',
        );
        $replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
            'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember',
        );
        //gmdate('d F Y H:i:s', time() + 60 * 60 * 7);
        $date = gmdate($date_format, $timestamp + 60 * 60 * 7);
        $date = preg_replace($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }

}


if (!function_exists('month_name_list')) {

    function month_name_list($lang = 'eng') {
        if ($lang == 'eng') {
            $month = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
        } elseif ($lang == 'ind') {
            $month = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');
        } else {
            $month = array();
        }
        return $month;
    }

}

if (!function_exists('draw_calendar')) {

    function draw_calendar($month, $year) {

        // Draw table for Calendar 
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        // Draw Calendar table headings 
        $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

        //days and weeks variable for now ... 
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        // row for week one 
        $calendar .= '<tr class="calendar-row">';

        // Display "blank" days until the first of the current week 
        for ($x = 0; $x < $running_day; $x++):
            $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
            $days_in_this_week++;
        endfor;

        // Show days.... 
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
            if ($list_day == date('d') && $month == date('n')) {
                $currentday = 'currentday';
            } else {
                $currentday = '';
            }
            $calendar .= '<td class="calendar-day ' . $currentday . '">';

            // Add in the day number
            if ($list_day < date('d') && $month == date('n')) {
                $showtoday = '<strong class="overday">' . $list_day . '</strong>';
            } else {
                $showtoday = $list_day;
            }
            $calendar .= '<div class="day-number">' . $showtoday . '</div>';

            // Draw table end
            $calendar .= '</td>';
            if ($running_day == 6):
                $calendar .= '</tr>';
                if (($day_counter + 1) != $days_in_month):
                    $calendar .= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        endfor;

        // Finish the rest of the days in the week
        if ($days_in_this_week < 8):
            for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
            endfor;
        endif;

        // Draw table final row
        $calendar .= '</tr>';

        // Draw table end the table 
        $calendar .= '</table>';

        // Finally all done, return result 
        return $calendar;
    }

}

if (!function_exists('make_path')) {

    function make_path($path) {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        if (is_dir($dir)) {
            return true;
        } else {
            if (make_path($dir)) {
                if (mkdir($dir)) {
                    chmod($dir, 0777);
                    return true;
                }
            }
        }
        return false;
    }

}

if (!function_exists('replace')) {

    function replace($str, $from, $to) {
        return str_replace($from, $to, $str);
    }

}


if (!function_exists('replace_to')) {

    function replace_to($str, $to = 'ucfirst') {
        if ($to == 'ucfirst') {
            return ucfirst(strtolower(trim($str)));
        } elseif ($to == 'strtolwer') {
            return strtolower(trim($str));
        } elseif ($to == 'strtoupper') {
            return strtoupper(trim($str));
        } else {
            return trim($str);
        }
    }

}

if (!function_exists('return_call_back')) {

    function return_call_back($keyword = '', $arr_value = array(), $type = 'json') {
        if ($type == 'json' && is_array($arr_value) == true) {
            return json_encode(array($keyword => $arr_value));
        } elseif ($type == 'array' && is_array($arr_value) == true) {
            return array($keyword => $arr_value);
        } elseif ($type == 'xml' && is_array($arr_value) == true) {
            return array_to_xml(array($keyword => $arr_value));
        }
    }

}


if (!function_exists('status_callback')) {

    function status_callback($type = null, $content = array()) {
        if ($type == 'success') {
            $string = json_encode(array('success' => true, $content));
        } elseif ($type == 'error') {
            $string = json_encode(array('error' => false, $content));
        }
        return $string;
    }

}

if (!function_exists('to_rupiah')) {

    function to_rupiah($nominal) {
        $rupiah_result = "Rp " . number_format($nominal, 2, ',', '.');
        return $rupiah_result;
    }

}


if (!function_exists('ConvertZero')) {

    function ConvertZero($day) {
        if (empty($day) && $day !== '0') {
            $day = '1';
        }
        return $day;
    }
}


if (!function_exists('get_detail_date')) {

    function get_detail_date($param = null) {
        if ($param != null) {
            $str = '';
            if (isset($param['day']) && $param['day'] != 0) {
                $str .= $param['day'] . ' hari ' . '-';
            } elseif (isset($param['hour']) && $param['hour'] != 0) {
                $str .= $param['hour'] . ' jam ' . '-';
            } elseif (isset($param['minute']) && $param['minute'] != 0) {
                $str .= $param['minute'] . ' menit ' . '-';
            } elseif (isset($param['second']) && $param['second'] != 0) {
                $str .= $param['second'] . ' detik';
            }
            //1 hari - 20 jam - 30 menit - 22 detik 
            return $str;
        }
    }

}