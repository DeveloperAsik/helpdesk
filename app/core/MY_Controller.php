<?php

class MY_Controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->init();
        $this->auth_user();
        $this->log_history();
        $sess = $this->_session_auth($this->config->session_name);
        if (isset($sess['is_logged_in']) && !empty($sess['is_logged_in']) && $sess != null) {
            $this->get_total_ticket();
            //optional start here
            $this->get_total_user();
            $this->get_total_office();
            $this->get_total_vendor();
            $this->get_total_ticket_category();
            $this->get_notif_ticket();
            $this->get_all_history();
        }
        //optional end here;
    }

    function init() {
        $this->lang();
        if ($_SESSION['_lang']) {
            $this->load->vars('_lang', strtolower($_SESSION['_lang']));
        }
        $this->configs();
        $this->template_configs();
        $this->load_ajax_var();
        $this->auth_config();
        /*
         * auth config
         */
        if ($this->auth_config()) {
            $this->load->vars('_var_auth_conf', $this->auth_config);
        }
        /*
         * Config
         */
        $arr = array();
        if ($this->config) {
            foreach ($this->config AS $key => $val) {
                if (isset($val) && !empty($val) && !is_array($val)) {
                    $arr[] = 'var ' . $key . ' = "' . $val . '";';
                }
            }
        }
        //set this to vars
        $ajax_var = '';
        foreach ($arr AS $key => $val) {
            if (!empty($ajax_var))
                $ajax_var .= ' ';
            $ajax_var .= $val;
        }
        $this->load->vars('_ajax_var_configs', $ajax_var);
        /*
         * Template
         */
        $arr2 = array();
        if ($this->template_configs) {
            foreach ($this->template_configs AS $key => $val) {
                if (!is_array($val)) {
                    $arr2[] = 'var ' . $key . ' = "' . $val . '";';
                }
            }
        }
        //set this to vars
        $ajax_var2 = '';
        foreach ($arr2 AS $key => $val) {
            if (!empty($ajax_var2))
                $ajax_var2 .= ' ';
            $ajax_var2 .= $val;
        }
        $this->load->vars('_var_template', $this->template_configs);
        $this->load->vars('_ajax_var_template', $ajax_var2);
        //load var for menu
        $module = $this->config->session_name;
        $sess = $this->_session_auth($module);
        if (isset($sess['is_logged_in']) && !empty($sess['is_logged_in']) && $sess['is_logged_in']) {
            $mn = $this->menu($this->get_module_id(), false, 1);
        } else {
            $mn = $this->menu($this->get_module_id(), false, 0);
        }
        if (isset($mn) && !empty($mn)) {
            $this->load->vars('_menu', $mn);
        }
    }

    public function lang() {
        $this->default_lang();
        $this->load_lang();
    }

    protected function default_lang($lang = 'indonesian') {
        $res = $this->session->userdata('_lang');
        if (!isset($res) || empty($res)) {
            $this->session->set_userdata('_lang', $lang);
            return true;
        }
    }

    protected function load_lang() {
        $lang = $this->session->userdata('_lang');
        $this->lang->load('global', $lang);
    }

    public function configs() {
        $file_conf = $this->config->config;
        $arr = array();
        if ($file_conf) {
            foreach ($file_conf AS $key => $val) {
                $arr[$key] = $val;
            }
        }
        $this->load->model(array('Tbl_configs'));
        $result = $this->Tbl_configs->find('all', array('conditions' => array('is_static' => 0, 'is_active' => 1)));
        if ($result) {
            foreach ($result AS $key => $val) {
                $arr[$val['keyword']] = $val['value'];
            }
        }
        if (isset($arr) && !empty($arr)) {
            foreach ($arr AS $key => $val) {
                $this->config->{$key} = $val;
            }
        }
    }

    protected function template_configs() {
        $base_url = '';
        if ($this->router->fetch_module() != 'helpdesk') {
            $base_url = '/' . $this->router->fetch_module() . '/';
        }
        $arr = array(
            '_module' => $this->router->fetch_module(),
            '_class' => $this->router->fetch_class(),
            '_action' => $this->router->fetch_method(),
            '_directory' => $this->_get_module_dir(),
            '_view_html' => $this->_get_module_dir() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '.html.php',
            '_view_js' => $this->_get_module_dir() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '.js.php',
            '_app_js' => 'includes/ajax/app.js.php',
            '_global_js' => 'libs/global.js.php',
            '_plugin_js' => 'includes/ajax/plugins.js.php',
            '_base_url' => $base_url
        );
        $this->template_configs = new stdClass();
        if (isset($arr) && !empty($arr)) {
            foreach ($arr AS $key => $val) {
                $this->template_configs->{$key} = $val;
            }
        }
    }

    protected function _get_module_dir() {
        $path = $this->router->fetch_directory();
        if ($path != null) {
            $first = str_replace('..', '', $path);
            $second = explode('/', $first);
            $return = array();
            if ($second) {
                foreach ($second AS $key => $val) {
                    if ($val != '' && $val != 'modules' && $val != 'controllers' && $val != $this->router->fetch_module() && $val != $this->router->fetch_class() && $val != $this->router->fetch_method()) {
                        $return[] = $val;
                    }
                }
            }
            return implode('/', $return);
        } else {
            return null;
        }
    }

    public function load_ajax_var($data = array()) {
        $arr = '';
        if ($data) {
            foreach ($data AS $key => $val) {
                if (!empty($arr))
                    $arr .= ' ';
                if (is_array($val['value'])) {
                    $arr .= 'var ' . $val['keyword'] . ' = "' . json_encode($val['value']) . '";';
                } else {
                    $arr .= 'var ' . $val['keyword'] . ' = "' . $val['value'] . '";';
                }
            }
            if (isset($arr) && !empty($arr)) {
                $this->load->vars('_load_ajax_var', $arr);
            }
        }
    }

    public function auth_config() {
        $session_name = $this->config->session_name;
        $sess = $this->_session_auth($session_name);
        if (isset($sess['group_id']) && !empty($sess['group_id'])) {
            switch ($sess['group_id']) {
                case 1:
                    $sess['global_uri'] = base_url('backend/');
                    break;
                case 2:
                    $sess['global_uri'] = base_url('');
                    break;
                case 3:
                    $sess['global_uri'] = base_url('vendor/');
                    break;
                case 4:
                    $sess['global_uri'] = base_url('monitor/');
                    break;
            }
            if (isset($sess['is_logged_in']) && !empty($sess['is_logged_in'])) {
                $arr = '';
                foreach ($sess AS $key => $val) {
                    if (!empty($arr))
                        $arr .= ' ';
                    $arr .= 'var ' . $key . ' = "' . $val . '";';
                }
                $this->load->vars('_load_auth_config_var', $sess);
                $this->load->vars('_load_auth_config_ajax_var', $arr);
                $this->auth_config = new stdClass();
                if (isset($sess) && !empty($sess)) {
                    foreach ($sess AS $key => $val) {
                        $this->auth_config->{$key} = $val;
                    }
                }
                return $this->auth_config;
            }
        }
    }

    public function auth_user() {
        $_redirect_login_data = '';
        $_redirect_login_status = false;
        $sess = $this->_session_auth($this->config->session_name);
        if (isset($sess['is_logged_in']) && !empty($sess['is_logged_in']) && $sess != null) {
            $permission = $this->get_permission();
            $lock = $this->get_lock_status();
            if ($permission == false) {
                $txt_flash = 'You didnt have access group to open this page';
                if ($this->auth_config->group_id == 1) {
                    $_redirect_login_data = 'backend/dashboard';
                    $_redirect_login_status = true;
                } elseif ($this->auth_config->group_id == 2) {
                    $_redirect_login_data = 'dashboard';
                    $_redirect_login_status = true;
                } elseif ($this->auth_config->group_id == 3) {
                    $_redirect_login_data = 'vendor/dashboard';
                    $_redirect_login_status = true;
                } elseif ($this->auth_config->group_id == 4) {
                    $_redirect_login_data = 'monitor/dashboard';
                    $_redirect_login_status = true;
                }
            }
            if ($lock == true) {
                $txt_flash = 'Your screen is locked, because inactivity for long time. please insert your password for accessing website.';
                $_redirect_login_data = 'lock-screen';
                if ($this->template_configs->_action == 'lock_screen' || $this->template_configs->_action == 'un_lock_screen') {
                    $_redirect_login_data = '';
                }
            }
            if ($this->template_configs->_action == 'logout') {
                $this->_logout();
                $_redirect_login_data = '';
            }
            if ($this->template_configs->_action == 'login') {
                if ($this->auth_config->group_id == 1) {
                    $_redirect_login_data = 'backend/dashboard';
                    $_redirect_login_status = true;
                } elseif ($this->auth_config->group_id == 2) {
                    $_redirect_login_data = 'dashboard';
                    $_redirect_login_status = true;
                } elseif ($this->auth_config->group_id == 3) {
                    $_redirect_login_data = 'vendor/dashboard';
                    $_redirect_login_status = true;
                } elseif ($this->auth_config->group_id == 4) {
                    $_redirect_login_data = 'monitor/dashboard';
                    $_redirect_login_status = true;
                }
            }
            if ($this->template_configs->_action == 'switch_lang') {
                $_redirect_login_data = '';
            }
        } else {
            if ($this->template_configs->_action != 'login') {
                $_redirect_login_data = 'login';
                $_redirect_login_status = true;
            }
            if ($this->template_configs->_action == 'check_data') {
                $_redirect_login_data = '';
                $_redirect_login_status = false;
            }
            if ($this->template_configs->_action == 'switch_lang') {
                $_redirect_login_data = '';
                $_redirect_login_status = false;
            }
            if ($this->template_configs->_action == 'get_running_text') {
                $_redirect_login_data = '';
                $_redirect_login_status = false;
            }
            if ($this->template_configs->_action == 'get_detail_running_text') {
                $_redirect_login_data = '';
                $_redirect_login_status = false;
            }
        }
        if ($_redirect_login_data != '' && $_redirect_login_status == true) {
            redirect($_redirect_login_data);
        } else {
            return true;
        }
    }

    public function log_history() {
        $session_name = $this->config->session_name;
        $sess = $this->_session_auth($session_name);
        if (isset($sess) && !empty($sess)) {
            $conf_temp = $this->template_configs;
            $conf_auth = $this->auth_config;
            $path = $this->config->item('dir.user_logs', 'path') . DS . $conf_auth->group_name . DS . $conf_auth->user_id . DS . gmdate('YmdHis', time() + 60 * 60 * 7) . '.log';
            $data = array(
                'module' => $conf_temp->_module,
                'class' => $conf_temp->_class,
                'action' => $conf_temp->_action,
                'directory' => $conf_temp->_directory,
                'ip' => get_ip(),
                'create_date' => date_now()
            );
            if (!is_dir($this->config->item('dir.user_logs', 'path') . DS . $conf_auth->group_name)) {
                mkdir($this->config->item('dir.user_logs', 'path') . DS . $conf_auth->group_name, 0775, true);
            }
            if (!is_dir($this->config->item('dir.user_logs', 'path') . $conf_auth->group_name . DS . $conf_auth->user_id)) {
                if (!mkdir($this->config->item('dir.user_logs', 'path') . $conf_auth->group_name . DS . $conf_auth->user_id, 0775, true)) {
                    die('Failed to create folders... ' . $this->config->item('dir.user_logs', 'path') . $conf_auth->group_name . DS . $conf_auth->user_id);
                }
            }
            $this->load->library('Oreno_log');
            $this->oreno_log->init_($data, $path);
        }
    }

    public function get_all_history() {
        $session_name = $this->config->session_name;
        $sess = $this->_session_auth($session_name);
        $result = array();
        if (isset($sess) && !empty($sess)) {
            $conf_auth = $this->auth_config;
            $path = $this->config->item('dir.user_logs', 'path') . $conf_auth->group_name . DS . $conf_auth->user_id;
            $this->load->library('Oreno_log');
            $result = $this->oreno_log->read_files($path);
            $data = array();
            if (isset($result) && !empty($result)) {
                foreach ($result AS $key => $value) {
                    $file = $this->oreno_log->read_file($value);
                    $data[] = json_decode($file);
                }
            }
            return $data;
        } else {
            return null;
        }
    }

    public function get_total_ticket() {
        $this->ticket = new stdClass();
        //open
        $this->ticket->open = $this->total_ticket(1);
        //progress
        $this->ticket->progress = $this->total_ticket(2);
        //progress reopen
        $this->ticket->progress_reopen = $this->total_ticket(2, 'reopen');
        //transfer
        $this->ticket->transfer = $this->total_ticket(3);
        //transfer in
        $this->ticket->transfer_in = $this->total_ticket(3, 'in');
        //transfer out
        $this->ticket->transfer_out = $this->total_ticket(3, 'out');
        //close
        $this->ticket->close = $this->total_ticket(4);
        $this->load->vars('_ajax_var_ticket', $this->ticket);
    }

    public function total_ticket($status_id, $opt = null) {
        $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_transfers', 'Tbl_helpdesk_ticket_reopen_logs'));
        $result = 0;
        if ($status_id == 1) {
            if ($this->auth_config->group_id == 1 || $this->auth_config->group_id == 3) {
                $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                    LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                    WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 1");
                $result = $res[0]['total'];
            } else {
                $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                    LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                    WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 1 AND a.created_by = " . base64_decode($this->auth_config->user_id));
                $result = $res[0]['total'];
            }
        } elseif ($status_id == 2) {
            if ($opt == null) {
                if ($this->auth_config->group_id == 1 || $this->auth_config->group_id == 3) {
                    $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                        LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                        LEFT JOIN `tbl_helpdesk_ticket_reopen_logs` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                        WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 2 AND `c`.`ticket_id` is null ");
                    $result = $res[0]['total'];
                } else {
                    $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                        LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                        WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 2 AND a.created_by = " . base64_decode($this->auth_config->user_id));
                    $result = $res[0]['total'];
                }
            } else {
                if ($opt == 'reopen') {
                    if ($this->auth_config->group_id == 1 || $this->auth_config->group_id == 3) {
                        $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                            LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                            RIGHT JOIN `tbl_helpdesk_ticket_reopen_logs` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                            WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 2");
                        $result = $res[0]['total'];
                    } else {
                        $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                            LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                            RIGHT JOIN `tbl_helpdesk_ticket_reopen_logs` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                            WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 2 AND a.created_by = " . base64_decode($this->auth_config->user_id));
                        $result = $res[0]['total'];
                    }
                }
            }
        } elseif ($status_id == 3) {
            if ($opt == null) {
                if ($this->auth_config->group_id == 1) {
                    $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                        LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                        LEFT JOIN `tbl_helpdesk_ticket_transfers` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                        WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 3");
                    $result = $res[0]['total'];
                } else {
                    $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                        LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                        LEFT JOIN `tbl_helpdesk_ticket_transfers` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                        WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 3 AND a.created_by = " . base64_decode($this->auth_config->user_id));
                    $result = $res[0]['total'];
                }
            } else {
                if ($this->auth_config->group_id == 1 || $this->auth_config->group_id == 3) {
                    if ($opt == 'in') {
                        $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                            LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                            LEFT JOIN `tbl_helpdesk_ticket_transfers` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                            WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 3 AND c.user_to = " . base64_decode($this->auth_config->user_id));
                        $result = $res[0]['total'];
                    } elseif ($opt == 'out') {
                        $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                            LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                            LEFT JOIN `tbl_helpdesk_ticket_transfers` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                            WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 3 AND c.user_from = " . base64_decode($this->auth_config->user_id));
                        $result = $res[0]['total'];
                    }
                } else {
                    $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                        LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                        LEFT JOIN `tbl_helpdesk_ticket_transfers` `c` ON `c`.`ticket_id` = `a`.`id` AND `c`.`is_active` = 1
                        WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 3 AND a.created_by = " . base64_decode($this->auth_config->user_id));
                    $result = $res[0]['total'];
                }
            }
        } elseif ($status_id == 4) {
            if ($this->auth_config->group_id == 2) {
                $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                    LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                    WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 4 AND `b`.`created_by` = " . base64_decode($this->auth_config->user_id));
            } else {
                $res = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) total FROM `tbl_helpdesk_tickets` `a`
                    LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                    WHERE `a`.`is_active` = 1  AND `b`.`status_id` = 4");
            }
            $result = $res[0]['total'];
        }

        return($result);
    }

    public function get_total_user() {
        $this->load->model('Tbl_helpdesk_employees');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $obj_cache = base64_encode('get_total_user');
        if (!$total_rows = $this->cache->get($obj_cache)) {
            $total_rows = $this->Tbl_helpdesk_employees->find('count');
            // Save into the cache for 10 minutes
            $this->cache->save($obj_cache, $total_rows, 43200);
        }
        $this->load->vars('_ajax_var_total_employee', $total_rows);
    }

    public function get_total_office() {
        $this->load->model('Tbl_helpdesk_branchs');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $obj_cache = base64_encode('get_total_office');
        if (!$total_rows = $this->cache->get($obj_cache)) {
            $total_rows = $this->Tbl_helpdesk_branchs->find('count');
            // Save into the cache for 10 minutes
            $this->cache->save($obj_cache, $total_rows, 43200);
        }
        $this->load->vars('_ajax_var_total_kanim', $total_rows);
    }

    public function get_total_vendor() {
        $this->load->model('Tbl_helpdesk_vendors');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $obj_cache = base64_encode('get_total_vendor');
        if (!$total_rows = $this->cache->get($obj_cache)) {
            $total_rows = $this->Tbl_helpdesk_vendors->find('count');
            // Save into the cache for 10 minutes
            $this->cache->save($obj_cache, $total_rows, 43200);
        }
        $this->load->vars('_ajax_var_total_vendor', $total_rows);
    }

    public function get_total_ticket_category() {
        $this->load->model('Tbl_helpdesk_ticket_categories');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $obj_cache = base64_encode('get_total_ticket_category');
        if (!$total_rows = $this->cache->get($obj_cache)) {
            $total_rows = $this->Tbl_helpdesk_ticket_categories->find('count');
            // Save into the cache for 10 minutes
            $this->cache->save($obj_cache, $total_rows, 43200);
        }
        $this->load->vars('_ajax_var_total_ticket_category', $total_rows);
    }

    public function get_notif_ticket($key = 'open') {
        $cond['table'] = 'tbl_helpdesk_tickets';
        $cond['fields'] = array('a.*', 'c.name ticket_status');
        $cond['order'] = array('key' => 'a.create_date', 'type' => 'DESC');
        $cond['conditions'] = array('c.name' => $key, 'a.is_active' => 1);
        $cond['joins'] = array(
            array(
                'table' => 'tbl_helpdesk_ticket_transactions b',
                'conditions' => 'b.ticket_id = a.id',
                'type' => 'left'
            ),
            array(
                'table' => 'tbl_helpdesk_ticket_status c',
                'conditions' => 'c.id = b.status_id',
                'type' => 'left'
            )
        );
        $res = $this->Tbl_helpdesk_tickets->find('all', $cond);
        if (isset($res) && !empty($res)) {
            $Arr_res = '';
            foreach ($res AS $key => $val) {
                $date_time = fn_date_diff($val['create_date'], date_now());
                $Arr_res .= '<li>
                    <a href="' . base_backend_url('ticket/master/detail/' . base64_encode($val['id'])) . '">
                        <small style="font-size:10px">
                            <span class="col-ms-4 time">' . $date_time . '</span>
                            <span class="col-ms-8 details">
                                <span class="label label-sm label-icon label-success">
                                    <i class="fa fa-plus"></i>
                                </span>' . $val['code'] . $key . ' Ticket : ' . substr($val['content'], 0, 100) . '
                            </span>
                        </small>
                    </a>
                </li>';
            }
            $this->load->vars('_ajax_var_notif_ticket_' . $key, $Arr_res);
        }
    }

    public function get_ticket_last_code($branch_code = 'HLP', $created_by = null) {
        $this->load->model(array('Tbl_helpdesk_tickets'));
        if ($this->auth_config) {
            $code = strtoupper(date('Y.m.d') . '.' . $branch_code);
            $ticket_self = $this->Tbl_helpdesk_tickets->query("SELECT * FROM tbl_helpdesk_tickets WHERE code LIKE '" . $code . "%' AND session_id = '" . $_SESSION['__ci_last_regenerate'] . "' AND is_active = 0 ORDER BY id DESC");
            if (isset($ticket_self) && !empty($ticket_self)) {
                $ticket_last_id = $this->Tbl_helpdesk_tickets->query("SELECT * FROM tbl_helpdesk_tickets WHERE code LIKE '" . $code . "%' ORDER BY id DESC");
                $new_code = $this->get_new_ticket_code($ticket_last_id[0]['code']);
            } else {
                $number = str_pad(1, 5, '0', STR_PAD_LEFT);
                $new_code = $code . '.' . $number;
            }
            $arr_insert = array(
                'code' => $new_code,
                'content' => '-',
                'description' => '-',
                'session_id' => $_SESSION['__ci_last_regenerate'],
                'is_active' => 0,
                'created_by' => ($created_by == null) ? (int) base64_decode($this->auth_config->user_id) : $created_by,
                'create_date' => date_now()
            );
            $this->Tbl_helpdesk_tickets->insert($arr_insert);
            return $new_code;
        }
    }

    public function get_new_ticket_code($code = null) {
        if ($code != null) {
            $new_code = explode('.', $code);
            $office_id = $new_code['3'];
            $counter = ((int) $new_code['4']);
            $number = str_pad(($counter + 1), 5, '0', STR_PAD_LEFT);
            if ($counter > 99999) {
                $number = str_pad(($counter + 1), 6, '0', STR_PAD_LEFT);
            }
            return $code = strtoupper(date('Y.m.d') . '.' . $office_id . '.' . $number);
        }
    }

    public function get_layout_theme($id = null) {
        if ($id != null) {
            $this->load->model('Tbl_layouts');
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $obj_cache = base64_encode('get_layout_theme');
            if (!$res = $this->cache->get($obj_cache)) {
                $res = $this->Tbl_layouts->find('first', array('conditions' => array('id' => $id)));
                // Save into the cache for 10 minutes
                $this->cache->save($obj_cache, $res, 43200);
            }
            return $res['name'];
        }
        return null;
    }

    public function load_js($path = array()) {
        if ($path) {
            $arr = "";
            foreach ($path AS $key => $val) {
                $arr .= '<script src="' . $val . '" type="text/javascript"></script>';
            }
        }
        $this->load->vars('_load_js', $arr);
    }

    public function load_css($path = array()) {
        $this->load->vars('_load_css', $path);
    }

    public function menu($id = null, $is_ajax = true, $is_logged_in = 0, $module_nm = '', $is_active = 1) {
        $this->load->model(array('Tbl_menus'));
        if ($module_nm == '') {
            $module_nm = $this->template_configs->_module;
        }
        $add_cond = array('a.module_id' => $id, 'a.level' => 1, 'a.is_logged_in' => $is_logged_in);
        if ($is_active == 1) {
            $add_cond = array_merge($add_cond, array('a.is_active' => 1));
        }
        $field_1 = array('a.id menu_id', 'a.name menu_text_eng', 'a.name_ina menu_text_ina', 'a.path menu_path', 'a.badge', 'b.name menu_icon', 'a.rank menu_rank', 'a.is_open', 'a.is_badge', 'a.is_logged_in', 'a.is_active', 'a.module_id menu_module_id');
        $menus = $this->Tbl_menus->find('all', array(
            'fields' => $field_1,
            'conditions' => $add_cond,
            'order' => array('key' => 'a.rank', 'type' => 'ASC'),
            'joins' => array(
                array(
                    'table' => 'tbl_icons b',
                    'conditions' => 'b.id = a.icon',
                    'type' => 'left'
                )
            )
                )
        );
        $arr_menu = array();
        if (isset($menus) && !empty($menus)) {
            foreach ($menus AS $key => $value) {
                $field_2 = array('a.id menu_id', 'a.name menu_text_eng', 'a.name_ina menu_text_ina', 'a.path menu_path', 'a.parent_id menu_parent_id', 'a.badge', 'b.name menu_icon', 'a.rank menu_rank', 'a.is_open', 'a.is_badge', 'a.is_logged_in', 'a.is_active');
                $add_cond2 = array('a.parent_id' => $value['menu_id'], 'a.level' => 2);
                if ($is_active == 1) {
                    $add_cond2 = array_merge($add_cond2, array('a.is_active' => 1));
                }
                $childmenus = $this->Tbl_menus->find('all', array(
                    'fields' => $field_2,
                    'conditions' => $add_cond2,
                    'order' => array('key' => 'a.rank', 'type' => 'ASC'),
                    'joins' => array(
                        array(
                            'table' => 'tbl_icons b',
                            'conditions' => 'b.id = a.icon',
                            'type' => 'left'
                        )
                    )
                        )
                );
                $arr_menu2 = array();
                if (isset($childmenus) && !empty($childmenus)) {
                    foreach ($childmenus AS $k => $val) {
                        $field_3 = array('a.id menu_id', 'a.name menu_text_eng', 'a.name_ina menu_text_ina', 'a.path menu_path', 'a.parent_id menu_parent_id', 'a.badge', 'b.name menu_icon', 'a.rank menu_rank', 'a.is_open', 'a.is_badge', 'a.is_logged_in', 'a.is_active');
                        $add_cond3 = array('a.parent_id' => $val['menu_id'], 'a.level' => 3);
                        if ($is_active == 1) {
                            $add_cond3 = array_merge($add_cond3, array('a.is_active' => 1));
                        }
                        $grandchildmenus = $this->Tbl_menus->find('all', array(
                            'fields' => $field_3,
                            'conditions' => $add_cond3,
                            'order' => array('key' => 'a.rank', 'type' => 'ASC'),
                            'joins' => array(
                                array(
                                    'table' => 'tbl_icons b',
                                    'conditions' => 'b.id = a.icon',
                                    'type' => 'left'
                                )
                            )
                                )
                        );
                        $mrg_val3 = array();
                        if (isset($grandchildmenus) && !empty($grandchildmenus)) {
                            foreach ($grandchildmenus AS $j => $v) {
                                switch (strtolower($_SESSION['_lang'])) {
                                    case 'english':
                                        $v['menu_text'] = $v['menu_text_eng'];
                                        break;
                                    case 'indonesian':
                                        $v['menu_text'] = $v['menu_text_ina'];
                                        break;
                                }
                                $mrg_val3[] = array_merge($v, array('menu_level' => 3));
                            }
                        }
                        switch (strtolower($_SESSION['_lang'])) {
                            case 'english':
                                $val['menu_text'] = $val['menu_text_eng'];
                                break;
                            case 'indonesian':
                                $val['menu_text'] = $val['menu_text_ina'];
                                break;
                        }
                        $mrg_val2 = array_merge(array_merge($val, array('menu_level' => 2)), array('nodes' => $mrg_val3));
                        $arr_menu2[] = $mrg_val2;
                    }
                }
                switch (strtolower($_SESSION['_lang'])) {
                    case 'english':
                        $value['menu_text'] = $value['menu_text_eng'];
                        break;
                    case 'indonesian':
                        $value['menu_text'] = $value['menu_text_ina'];
                        break;
                }
                $mrg_val = array_merge(array_merge($value, array('menu_level' => 1)), array('nodes' => $arr_menu2));
                $arr_menu[] = $mrg_val;
            }
        }
        $rrr = array();
        if (isset($arr_menu) && !empty($arr_menu)) {
            $root = array(
                'id' => 0,
                'level' => 0,
                'text' => $module_nm,
                "is_active" => 1,
                "is_logged_in" => 1,
                'a.description' => '-'
            );
            $r = array_merge($root, array('nodes' => $arr_menu));
            if ($is_ajax == true) {
                $rrr = '[' . json_encode($r) . ']';
            } else {
                $rrr = $r;
            }
        }
        if ($is_ajax == true && !is_array($rrr)) {
            echo $rrr;
        } else {
            return $rrr;
        }
    }

    public function category($is_ajax = false) {
        $this->load->model(array('Tbl_helpdesk_ticket_categories'));
        $add_cond = array('a.level' => 1);
        $menus = $this->Tbl_helpdesk_ticket_categories->find('all', array(
            'fields' => array('a.id menu_id', 'a.name menu_text', 'b.name menu_icon', 'a.rank menu_rank', 'a.is_active', 'a.description'),
            'conditions' => $add_cond,
            'order' => array('key' => 'a.rank', 'type' => 'ASC'),
            'joins' => array(
                array(
                    'table' => 'tbl_icons b',
                    'conditions' => 'b.id = a.icon',
                    'type' => 'left'
                )
            )
                )
        );
        $arr_menu = array();
        if (isset($menus) && !empty($menus)) {
            foreach ($menus AS $key => $value) {
                $childmenus = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                    'fields' => array('a.id menu_id', 'a.name menu_text', 'a.parent_id menu_parent_id', 'b.name menu_icon', 'a.rank menu_rank', 'a.is_active', 'a.description'),
                    'conditions' => array('a.parent_id' => $value['menu_id'], 'a.level' => 2),
                    'order' => array('key' => 'a.rank', 'type' => 'ASC'),
                    'joins' => array(
                        array(
                            'table' => 'tbl_icons b',
                            'conditions' => 'b.id = a.icon',
                            'type' => 'left'
                        )
                    )
                        )
                );
                $arr_menu2 = array();
                if (isset($childmenus) && !empty($childmenus)) {
                    foreach ($childmenus AS $k => $val) {
                        $grandchildmenus = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                            'fields' => array('a.id menu_id', 'a.name menu_text', 'a.parent_id menu_parent_id', 'b.name menu_icon', 'a.rank menu_rank', 'a.is_active', 'a.description'),
                            'conditions' => array('a.parent_id' => $val['menu_id'], 'a.level' => 3),
                            'order' => array('key' => 'a.rank', 'type' => 'ASC'),
                            'joins' => array(
                                array(
                                    'table' => 'tbl_icons b',
                                    'conditions' => 'b.id = a.icon',
                                    'type' => 'left'
                                )
                            )
                                )
                        );
                        $mrg_val3 = array();
                        if (isset($grandchildmenus) && !empty($grandchildmenus)) {
                            foreach ($grandchildmenus AS $j => $v) {
                                $mrg_val3[] = array_merge($v, array('menu_level' => 3));
                            }
                        }
                        $mrg_val2 = array_merge(array_merge($val, array('menu_level' => 2)), array('nodes' => $mrg_val3));
                        $arr_menu2[] = $mrg_val2;
                    }
                }
                $mrg_val = array_merge(array_merge($value, array('menu_level' => 1)), array('nodes' => $arr_menu2));
                $arr_menu[] = $mrg_val;
            }
        }
        $rrr = array();
        if (isset($arr_menu) && !empty($arr_menu)) {
            $root = array(
                'id' => 0,
                'level' => 0,
                'text' => 'Category',
                "is_active" => 1,
                'a.description' => '-'
            );
            $r = array_merge($root, array('nodes' => $arr_menu));
            if ($is_ajax == true) {
                $rrr = '[' . json_encode($r) . ']';
            } else {
                $rrr = $r;
            }
        }
        if ($is_ajax == true && !is_array($rrr)) {
            echo $rrr;
        } else {
            return $rrr;
        }
    }

    public function get_module_id() {
        $this->load->model('Tbl_modules');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $res = $this->Tbl_modules->get_id($this->template_configs->_module);
        return $res;
    }

    public function _session_auth($sess_name = null) {
        $sess = $this->session->all_userdata();
        if (isset($sess[$sess_name]) && !empty($sess[$sess_name])) {
            return $sess[$sess_name];
        } else {
            return null;
        }
    }

    public function get_lock_status() {
        $sess = $this->session->all_userdata();
        if (isset($sess[$this->config->session_name . '_lock_screen']) && !empty($sess[$this->config->session_name . '_lock_screen'])) {
            return $sess[$this->config->session_name . '_lock_screen']['status'];
        } else {
            return false;
        }
    }

    public function fnGetRedirectAuth($redirect_to = '') {
        $sess = $this->_session_auth($this->config->session_name);
        $redi = '';
        if (isset($sess) && !empty($sess)) {
            $redi = base_url($redirect_to);
            if ($sess['group_name'] == 'vendor') {
                $redi = base_url($redirect_to);
            }
        } else {
            $redi = base_url($redirect_to);
        }
        return $redi;
    }

    public function _logout() {
        session_destroy();
        //$this->session->sess_destroy('');
        //$this->oreno_auth->destroy_session($this->_session_auth(''));
    }

    protected function get_permission() {
        $this->load->model('Tbl_group_permissions');
        $arr_opt = array(
            'conditions' => array(
                'c.name' => $this->auth_config->group_name,
                'b.module' => $this->template_configs->_module,
                'b.class' => $this->template_configs->_class,
                'b.action' => $this->template_configs->_action,
                'a.is_allowed' => 1,
                'a.is_active' => 1
            ),
            'joins' => array(
                array(
                    'table' => 'tbl_permissions b',
                    'conditions' => 'b.id = a.permission_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_groups c',
                    'conditions' => 'c.id = a.group_id',
                    'type' => 'left'
                )
            )
        );
        $res = $this->Tbl_group_permissions->find('first', $arr_opt);
        if (isset($res) && !empty($res)) {
            return true;
        } else {
            return false;
        }
    }

    public function fnReshapePath($path = null, $rm = '') {
        if ($path != null) {
            $first = str_replace('..', '', $path);
            $second = explode('/', $first);
            $return = array();
            if ($second) {
                foreach ($second AS $key => $val) {
                    if (is_array($rm) == true && $val != '' && $rm[0] == 'replace' && $val != 'modules') {
                        if ($val == $rm[1]) {
                            $val = $rm[2];
                        }
                        $return[] = $val;
                    } elseif ($val != '' && $val != $rm && $val != 'modules') {
                        $return[] = $val;
                    }
                }
            }
            return implode('/', $return);
        }
    }

    public function setup_layout() {
        $data['login_layout'] = $this->config->login_layout;
        $data['layout_theme'] = $this->get_layout_theme($this->config->login_layout);
        return $data;
    }

    public function is_devices() {
        $this->load->library(array('mobile_detect'));
        if ($this->mobile_detect->isMobile() == true) {
            $devices = 'mobile';
        } elseif ($this->mobile_detect->isTablet() == true) {
            $devices = 'tablet';
        } else {
            $devices = 'desktop';
        }
        return $devices;
    }

    public function get_ticket_activity($id = null) {
        if ($id != null) {
            $this->load->model('Tbl_helpdesk_activities');
            return $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $id)));
        }
    }

    public function get_icon($id = null) {
        if ($id != null) {
            $this->load->model('Tbl_icons');
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $obj_cache = base64_encode('get_icon');
            if (!$res = $this->cache->get($obj_cache)) {
                $res = $this->Tbl_icons->find('first', array('conditions' => array('id' => (int) $id)));
                // Save into the cache for 10 minutes
                $this->cache->save($obj_cache, $res, 43200);
            }
            echo $res['name'];
        }
    }

    public function get_btn_ticket_status($name = null, $opt = null) {
        if ($name != null) {
            $res = '';
            switch ($name) {
                case 'open':
                    $res = '<span style="background-color:#5ccd18; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">' . $name . '</span>';

                    break;
                case 'progress':
                    $res = '<span style="background-color:#ffb136; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">' . $name . '</span>';
                    break;
                case 'transfer':
                    if ($opt != null) {
                        $res = '<span style="background-color:#ed6b75; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">' . $name . '</span><br/><br/><small>' . $opt . '</small>';
                    } else {
                        $res = '<span style="background-color:#ed6b75; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">' . $name . '</span>';
                    }
                    break;
                case 'close':
                    $res = '<span style="background-color:#32c5d2; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">' . $name . '</span>';
                    break;
            }
            return $res;
        }
    }

    public function get_new_tickets() {
        $this->load->model('Tbl_helpdesk_tickets');
        $res = $this->Tbl_helpdesk_tickets->query('SELECT * FROM tbl_helpdesk_tickets WHERE is_active = 1 ORDER BY create_date DESC LIMIT 0, 50');
        if ($res != null) {
            $arr = array();
            foreach ($res AS $key => $value) {
                $time_lapse = fn_date_diff_ticket($value['create_date'], date('Y-m-d H:i:s'), 'max');
                if ($time_lapse['year'] == 0) {
                    if ($time_lapse['month'] == 0) {
                        if ($time_lapse['day'] == 0) {
                            if ($time_lapse['hour'] == 0) {
                                if ($time_lapse['minute'] <= 30) {
                                    $arr[] = $value;
                                }
                            }
                        }
                    }
                }
            }
            return $arr;
        }
    }

    public function get_ticket_owner($id = null, $sender = '', $is_ajax = false) {
        if ($sender == 'emp') {
            if ($id != null) {
                $this->load->model('Tbl_helpdesk_ticket_handlers');
                $opt = array('conditions' => array('a.ticket_id' => $id));
                $res = $this->Tbl_helpdesk_ticket_handlers->find('first', $opt);
                if ($res) {
                    if ($is_ajax == false) {
                        return $res['user_id'];
                    } else {
                        echo $res['user_id'];
                    }
                }
            }
        } elseif ($sender == 'timtik') {
            if ($id != null) {
                $this->load->model('Tbl_helpdesk_ticket_handlers');
                $opt = array('conditions' => array('a.ticket_id' => $id));
                $res = $this->Tbl_helpdesk_ticket_handlers->find('first', $opt);
                if ($res) {
                    if ($is_ajax == false) {
                        return $res['user_id'];
                    } else {
                        echo $res['user_id'];
                    }
                }
            }
        } else {
            if ($id != null) {
                $this->load->model('Tbl_helpdesk_tickets');
                $opt = array(
                    'conditions' => array('a.id' => $id),
                    'fields' => array('a.id', 'a.code', 'b.id user_id', 'b.username', 'b.email'),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id = a.created_by',
                            'type' => 'left'
                        )
                    )
                );
                $res = $this->Tbl_helpdesk_tickets->find('first', $opt);
                if ($res) {
                    if ($is_ajax == false) {
                        return $res['user_id'];
                    } else {
                        echo $res['user_id'];
                    }
                }
            }
        }
    }

    public function base64ToImage($user_id, $imageData) {
        $data = 'data:image/png;base64,AAAFBfj42Pj4';
        list($type, $imageData) = explode(';', $imageData);
        list(, $extension) = explode('/', $type);
        list(, $imageData) = explode(',', $imageData);
        $fileName = $this->config->item('dir.user_profile_img', 'path') . $user_id . '.' . $extension;
        $imageData = base64_decode($imageData);
        file_put_contents($fileName, $imageData);
        return 'images/user_profile/' . $user_id . '.' . $extension;
    }

    public function setLogPath($id = null, $group_id = '', $option_path = null) {
        if ($id != null) {
            $path = $this->config->item('dir.archive_file', 'path') . DS . $option_path;
            if (!is_dir($path)) {
                mkdir($path);
            }
            if (!is_dir($path . DS . base64_encode($group_id))) {
                mkdir($path . DS . base64_encode($group_id));
            }
            $full_path = $path . DS . base64_encode($group_id) . DS . base64_encode($id) . '.log';
            return $full_path;
        }
    }

    public function get_office_code_from_ticket($code = null, $opt = 'all') {
        if ($code != null) {
            $code = explode('.', $code);
            if ($opt == 'id') {
                $this->load->model('Tbl_helpdesk_branchs');
                $r = $this->Tbl_helpdesk_branchs->find('first', array('conditions' => array('code' => $code[3])));
                return $r['id'];
            } else {
                return $code[3];
            }
        }
    }

    public function create_ticket_logs($data = array()) {
        $this->load->model(array('Tbl_helpdesk_ticket_logs'));
        if ($data) {
            $arr_ins = array(
                'ticket_id' => $data['ticket_id'],
                'action' => $data['action'],
                'is_active' => 1,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_logs->insert($arr_ins);
            return $res;
        }
    }

    public function fn_get_style_by_create_date($create_date) {
        $diff_date = fn_date_diff_ticket($create_date, date_now(), 'all');
        $sty = '<span aria-hidden="true" class="icon-check" style="color:green; height:30px"></span>';
        if ($diff_date['year'] >= 1) {
            $sty = '<span aria-hidden="true" class="icon-shield red" style="color:red; height:30px"></span>';
        } elseif ($diff_date['month'] >= 1) {
            $sty = '<span aria-hidden="true" class="icon-check orange" style="color:orange; height:30px"></span>';
        }

        return $sty;
    }

    public function fn_get_text_by_create_date($create_date) {
        $diff_date = fn_date_diff_ticket($create_date, date_now(), 'all');
        $sty = 'Tiket baru di buat';
        if ($diff_date['year'] >= 1) {
            $sty = 'Tiket sudah di buat sejak ' . $diff_date['year'] . ' tahun lalu';
        } elseif ($diff_date['month'] >= 1) {
            $sty = 'Tiket sudah di buat sejak ' . $diff_date['month'] . ' bulan lalu';
        }

        return $sty;
    }

}
