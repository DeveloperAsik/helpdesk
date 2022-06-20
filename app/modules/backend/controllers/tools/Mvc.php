<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mvc
 *
 * @author signet
 */
class Mvc extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_layout_controllers', 'Tbl_layout_models', 'Tbl_layout_views'));
    }

    public function index() {
        redirect(base_backend_url('tools/mvc/generate'));
    }

    public function generate() {
        $data['title_for_layout'] = 'welcome';
        $data['view-header-title'] = 'View MVC Generate tool';
        $data['content'] = 'ini kontent web';
        $data['modules'] = $this->get_module();
        $css_files = array(
            static_url('templates/metronics/assets/global/plugins/typeahead/typeahead.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/typeahead/handlebars.min.js'),
            static_url('templates/metronics/assets/global/plugins/typeahead/typeahead.bundle.min.js')
        );
        $this->load_js($js_files);
        $this->load->model(array('Tbl_helpdesk_ticket_status', 'Tbl_users', 'Tbl_helpdesk_branchs', 'Tbl_helpdesk_ticket_problem_impacts', 'Tbl_helpdesk_ticket_categories'));
        $data['branch'] = $this->Tbl_helpdesk_branchs->find('all', array('conditions' => array('is_active' => 1)));
        $data['problem_impact'] = $this->Tbl_helpdesk_ticket_problem_impacts->find('all', array('conditions' => array('is_active' => 1)));
        $data['category'] = $this->Tbl_helpdesk_ticket_categories->find('all', array('conditions' => array('is_active' => 1, 'level' => 1)));
        $data['ticket_status'] = $this->Tbl_helpdesk_ticket_status->find('list', array('conditions' => array('is_active' => 1)));
        $data['users'] = $this->Tbl_users->find('all', array(
            'fields' => array('a.*','c.name group_name'),
            'conditions' => array('a.is_active' => 1),
            'order' => array('key' => 'c.level', 'type' => 'ASC'),
            'joins' => array(
                array(
                    'table' => 'tbl_user_groups b',
                    'conditions' => 'b.user_id = a.id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_groups c',
                    'conditions' => 'c.id = b.group_id',
                    'type' => 'left'
                )
            )
                )
        );
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_data() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            switch (base64_decode($post['id'])) {
                case 1:
                    $res = $this->Tbl_layout_controllers->find('first', array('conditions' => array('is_active' => 1)));
                    break;
                case 2:
                    $res = $this->Tbl_layout_models->find('first', array('conditions' => array('is_active' => 1)));
                    break;
                case 3:
                    $res = $this->Tbl_layout_views->find('first', array('conditions' => array('is_active' => 1)));
                    break;
            }
            if (isset($res) && !empty($res)) {
                if (isset($res['script']) && !empty($res['script'])) {
                    $res['script'] = htmlspecialchars($res['script']);
                } else if (isset($res['view_html']) && !empty($res['view_html'])) {
                    $res['view_html'] = htmlspecialchars($res['view_html']);
                } else if (isset($res['view_js']) && !empty($res['view_js'])) {
                    $res['view_js'] = '&lt;script&gt;' . ($res['view_js']) . '&lt;/script&gt;';
                }
                echo json_encode($res);
            } else {
                echo null;
            }
        }
    }

    public function get_category($id = null) {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_categories'));
            $id = base64_decode($post['id']);
            $result = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                'conditions' => array('is_active' => 1, 'parent_id' => $id)
                    )
            );
            if (isset($result) && !empty($result)) {
                $arr = '<option value="0">-- select one --</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
                echo $arr;
            } else {
                echo '';
            }
        }
    }

    public function get_module() {
        $this->load->model(array('Tbl_modules'));
        $res = $this->Tbl_modules->find('list', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'name', 'type' => 'ASC')));
        if (isset($res) && !empty($res)) {
            $arr = '';
            foreach ($res AS $k => $v) {
                $arr .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
            }
            return $arr;
        } else {
            return null;
        }
    }

    public function insert() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $res = '#collect parameter data... <br/>';
            $modules = $post['module'];
            $res .= '#module name [' . $modules . ']<br/>';
            $class_name_ucfirst = $post['class_name_ucfirst'];
            $res .= '#Class name [' . $class_name_ucfirst . ']<br/>';
            $class_base_url = $post['class_base_url'];
            $res .= '#using base_url => [' . $class_base_url . ']<br/>';
            $class_path = $post['class_path'];
            $model_name_ucfirst = isset($post['model_name_ucfirst']) ? $post['model_name_ucfirst'] : '-';
            //generate controller first
            //set app path
            $app_apth = $this->config->item('dir.app_modules', 'path');

            $res .= '#init app path [' . $app_apth . ']<br/>';
            //check controller path
            $class_path_full = $app_apth . DS . $modules . DS . 'controllers';
            $res .= '#define controller path [' . $class_path_full . ']<br/>';
            $extract_class_path = explode('/', $class_path);
            $last_class_path = count($extract_class_path) - 1;
            unset($extract_class_path[$last_class_path]);
            $opath_class = $class_path_full . DS . $extract_class_path[0];

            $res .= '#create directory for controller with path => [' . $opath_class . ']<br/>';
            if (!is_dir($opath_class)) {
                mkdir($opath_class, 0, true);
            }
            $sub_module = $extract_class_path[0];
            $this->load->helper('file');
            //get controller layout
            $controller = $this->Tbl_layout_controllers->find('first', array('conditions' => array('is_active' => 1)));
            $res .= '#fetch controller script layout...<br/>';
            $controller_data = $controller['script'];
            $controller_data = str_replace('[class_name_ucfirst]', $class_name_ucfirst, $controller_data);
            $controller_data = str_replace('[model_name_ucfirst]', $model_name_ucfirst, $controller_data);
            $controller_data = str_replace('[class_base_url]', $class_base_url, $controller_data);
            $controller_data = str_replace('[class_path]', implode('/', $extract_class_path) . '/', $controller_data);
            //write actual file
            $res .= '#define controller path and file name ' . $class_path_full . DS . $sub_module . DS . $class_name_ucfirst . '.php' . '<br/>';
            write_file($class_path_full . DS . $sub_module . DS . $class_name_ucfirst . '.php', $controller_data);
            //get model layout          
            if ($post['model_exist'] == 1) {
                if ($model_name_ucfirst != '-' || $model_name_ucfirst == '') {
                    $res .= '#Model name founded...<br/>';
                    $res .= '#fetch model script layout...<br/>';
                    $model = $this->Tbl_layout_models->find('first', array('conditions' => array('is_active' => 1)));
                    $model_data = $model['script'];
                    $model_data = str_replace('[model_name_ucfirst]', $model_name_ucfirst, $model_data);
                    $res .= '#set actual model into path and file name ' . $app_apth . DS . 'model' . DS . $model_name_ucfirst . '.php' . '<br/>';
                    write_file($app_apth . DS . 'model' . DS . $model_name_ucfirst . '.php', $model_data);
                }
            }
            $res .= '#finishing process, make view html and view js...<br/>';
            //check view html and js path            
            $view_path_full = $app_apth . DS . $modules . DS . 'views';
            $res .= '#defining view path ' . $view_path_full . '<br/>';
            $extract_view_path = $o_view_path = explode('/', $class_path);
            $last_view_path = count($extract_view_path) - 1;
            unset($extract_view_path[$last_view_path]);

            $opath_view = $view_path_full . DS . implode(DS, $extract_view_path);
            $fl_nm_view = $o_view_path[$last_view_path];
            if (!is_dir($opath_view)) {
                mkdir($opath_view, 0, true);
            }

            $res .= '#fetch views script layout...<br/>';
            //get view layout
            $view = $this->Tbl_layout_views->find('first', array('conditions' => array('is_active' => 1)));
            $view_html_data = $view['view_html'];
            $view_js_data = '<script>' . $view['view_js'];
            $view_js_data = str_replace('[class_name_ucfirst]', $class_name_ucfirst, $view_js_data);
            $view_js_data = str_replace('[model_name_ucfirst]', $model_name_ucfirst, $view_js_data);
            $view_js_data = str_replace('[class_base_url]', $class_base_url, $view_js_data);
            $view_js_data = str_replace('[class_path]', implode('/', $extract_class_path) . '/', $view_js_data);
            $res .= '#assign parameter value...<br/>';
            $view_html_data = str_replace('[model_name_ucfirst]', $model_name_ucfirst, $view_html_data);
            //write actual file
            $res .= '#set actual view html into path and file name ' . strtolower($view_path_full . DS . $sub_module . DS . $class_name_ucfirst . DS . $fl_nm_view) . '.html.php' . '<br/>';
            write_file(strtolower($view_path_full . DS . $sub_module . DS . $class_name_ucfirst . DS . $fl_nm_view) . '.html.php', $view_html_data);
            //write actual file
            $res .= '#set actual view js into path and file name ' . strtolower($view_path_full . DS . $sub_module . DS . $class_name_ucfirst . DS . $fl_nm_view) . '.js.php' . '<br/>';
            write_file(strtolower($view_path_full . DS . $sub_module . DS . $class_name_ucfirst . DS . $fl_nm_view) . '.js.php', $view_js_data . '</script>');
            $res .= 'generate complete!!!';
            echo $res;
        }
    }

    public function insert_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if ($post['total']) {
                $code = '';
                $arr = array();
                $this->load->model('Tbl_helpdesk_tickets');
                $kd = strtoupper(date('Y.m.d') . '.' . 'TEST');
                $last_ticket = $this->Tbl_helpdesk_tickets->query("SELECT * FROM tbl_helpdesk_tickets WHERE is_active = 1 AND code LIKE '$kd%' ORDER BY id DESC");
                $no = 1;
                if ($last_ticket != null) {
                    $a = explode('.', $last_ticket[0]['code']);
                    $no = (int) $a[4] + 1;
                }
                $total = $post['total'] + ($no - 1);
                for ($i = $no; $i <= $total; $i++) {
                    $number = str_pad(($i), 5, '0', STR_PAD_LEFT);
                    $code = strtoupper(date('Y.m.d') . '.' . 'TEST' . '.' . $number);
                    $arr[] = array(
                        "code" => $code,
                        "category" => $post['category'],
                        "job" => $post['job'],
                        "problem_impact" => $post['problem_impact'],
                        "ticket_status" => $post['ticket_status'],
                        "issue" => $post['issue'] . ' no : ' . $i
                    );
                }
                echo 'Insert new ticket into db : <br/>';
                foreach ($arr AS $key => $value) {
                    if ($post['is_random_date'] == 1) {
                        $value['create_date'] = date('Y-' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . '-' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . ' ' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . ':' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . ':00');
                    }
                    if ($value['create_date'] == '0000-00-00 00:00:00') {
                        $value['create_date'] = date('Y-' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . '-' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . ' ' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . ':' . str_pad(generate_number(1), 2, '0', STR_PAD_LEFT) . ':00');
                    }
                    $value['user_id'] = (int) $post['user'];
                    $this->do_insert_ticket($value);
                    echo "Successfully create new ticket with code " . $value['code'] . '<br/><hr/>';
                }
                echo '<hr/>' . "Finish create " . $post['total'] . '<hr/>';
            }
        }
    }

    protected function do_insert_ticket($post = array()) {
        if ($post) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_rules', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_requests', 'Tbl_helpdesk_ticket_chats'));
            $create_date = $post['create_date'];
            $arr_insert = array(
                'code' => $post['code'],
                'content' => $post['issue'],
                'description' => '-',
                'issued_by' => $post['user_id'],
                'is_active' => 1,
                'created_by' => 1,
                'create_date' => isset($create_date) ? $create_date : date_now()
            );
            $ticket_id = $this->Tbl_helpdesk_tickets->insert_return_id($arr_insert);
            if ($ticket_id) {
                $priority = 1;
                $impact = $post['problem_impact'];
                if ($post['problem_impact'] == 0) {
                    $impact = 1;
                }
                if ($post['problem_impact'] == 2) {
                    $priority = 2;
                }
                $rule_id = $this->Tbl_helpdesk_ticket_rules->find('first', array('conditions' => array('id' => (int) $priority)));
                $res = false;
                $arr_trans = array(
                    'ticket_id' => (int) $ticket_id,
                    'category_id' => (int) $post['category'],
                    'job_id' => (int) $post['job'],
                    'status_id' => $post['ticket_status'],
                    'branch_id' => 1,
                    'problem_impact_id' => $impact,
                    'priority_id' => $priority,
                    'rule_id' => $rule_id['id'],
                    'is_active' => 1,
                    'created_by' => 1,
                    'create_date' => isset($create_date) ? $create_date : date_now()
                );
                $this->Tbl_helpdesk_ticket_transactions->insert($arr_trans);
                $response_time_start = date('Y-m-d H:i:s');
                $response_time_stop = '0000-00-00 00:00:00';
                $transfer_time_start = '0000-00-00 00:00:00';
                $transfer_time_stop = '0000-00-00 00:00:00';
                $solving_time_start = '0000-00-00 00:00:00';
                $solving_time_stop = '0000-00-00 00:00:00';
                if ($post['ticket_status'] == 2) {
                    $response_time_stop = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                    $solving_time_start = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                }
                if ($post['ticket_status'] == 3) {
                    $response_time_stop = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                    $solving_time_start = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                    $transfer_time_start = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                    $transfer_time_stop = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                }
                if ($post['ticket_status'] == 5) {
                    $response_time_stop = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                    $solving_time_start = date('Y-m-d H:i:s', strtotime('+5 minutes'));
                    $solving_time_stop = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                }
                $arr_activity = array(
                    'ticket_id' => $ticket_id,
                    'response_time_start' => $response_time_start, //'0000-00-00 00:00:00',
                    'response_time_stop' => $response_time_stop,
                    'transfer_time_start' => $transfer_time_start,
                    'transfer_time_stop' => $transfer_time_stop,
                    'solving_time_start' => $solving_time_start,
                    'solving_time_stop' => $solving_time_stop,
                    'is_open' => 0,
                    'is_active' => 1,
                    'created_by' => 1,
                    'create_date' => isset($create_date) ? $create_date : date_now()
                );
                $this->Tbl_helpdesk_activities->insert($arr_activity);
                $arr_img = array(
                    'code' => $post['code'],
                    'path' => 'reserved_images/sample.jpg',
                    'description' => '-',
                    'created_by' => 1,
                    'create_date' => isset($create_date) ? $create_date : date_now()
                );
                $this->Tbl_helpdesk_ticket_files->insert($arr_img);
                if ($post['ticket_status'] != 1) {
                    $rr_handler = array(
                        'ticket_id' => $ticket_id,
                        'user_id' => 1,
                        'group_id' => 1,
                        'is_active' => 1,
                        'created_by' => 1,
                        'create_date' => isset($create_date) ? $create_date : date_now()
                    );
                    $this->Tbl_helpdesk_ticket_handlers->insert($rr_handler);
                    $arr_insert = array(
                        'messages' => 'ticket testing',
                        'ticket_id' => $ticket_id,
                        'ticket_code' => $post['code'],
                        'is_support' => 1,
                        'is_active' => 1,
                        'reply_to' => 1,
                        'created_by' => $post['user_id'],
                        'create_date' => isset($create_date) ? $create_date : date_now()
                    );
                    $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);

                    if ($post['ticket_status'] == 5) {
                        $arr = array(
                            'ticket_id' => $ticket_id,
                            'job_list' => '-',
                            'message' => 'auto close from auto generate test',
                            'is_active' => 1,
                            'created_by' => 1,
                            'create_date' => isset($create_date) ? $create_date : date_now()
                        );
                        $this->Tbl_helpdesk_ticket_requests->insert($arr);
                        $this->Tbl_helpdesk_ticket_transactions->query("UPDATE `tbl_helpdesk_ticket_transactions` SET `status_id` = '5' WHERE `tbl_helpdesk_ticket_transactions`.`ticket_id` = {$ticket_id};", 'update'); //($arr_transc, 'ticket_id', $post['ticket_id']);
                        $this->Tbl_helpdesk_activities->query("UPDATE `tbl_helpdesk_activities` SET `solving_time_stop` = '" . date_now() . "' WHERE `tbl_helpdesk_activities`.`id` = {$ticket_id};", 'update');
                    }
                }
                return true;
            }
        }
    }

    public function reset() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            switch ($post['id']) {
                case 1 :
                    $this->reset_user('admin');
                    break;
                case 2 :
                    $this->reset_user('support');
                    break;
                case 3 :
                    $this->reset_user('branch');
                    break;
                case 4 :
                    $this->reset_ticket();
                    break;
                case 5 :
                    $this->reset_open_ticket();
                    break;
            }
        }
    }

    protected function reset_user($param = null) {
        if ($param != null) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_support_users', 'Tbl_users', 'Tbl_helpdesk_employee_users'));
            $str = '#Preparing data...<br/>';
            switch ($param) {
                case 'admin':
                    $str .= '#Select field from table db_helpdesk ...<br/>';
                    $str .= '#Truncate tbl_helpdesk_users; <br/>';
                    $query = "TRUNCATE `tbl_helpdesk_users`";
                    $this->Tbl_helpdesk_tickets->query($query, 'update');
                    $str .= '#Successfully reset tbl_helpdesk_users...';
                    break;
                case 'support':
                    $str .= '#Select field from table db_helpdesk ...<br/>';
                    $str .= '#Truncate tbl_helpdesk_support_users; <br/>';
                    $query = "TRUNCATE `tbl_helpdesk_support_users`";
                    $this->Tbl_helpdesk_support_users->query($query, 'update');
                    $str .= '#Successfully reset tbl_helpdesk_support_users...';
                    break;
                case 'branch':
                    $employee = $this->Tbl_helpdesk_employee_users->find('all');
                    if ($employee) {
                        $user_id = array();
                        foreach ($employee AS $key => $value) {
                            $user_id[] = $value['user_id'];
                        }
                        $this->db->truncate('tbl_helpdesk_employees');
                        $this->db->truncate('tbl_helpdesk_employee_users');
                        foreach ($user_id AS $k => $v) {
                            $this->Tbl_users->query("DELETE FROM `tbl_users` WHERE `tbl_users`.`id` = " . $v);
                        }
                    }
                    $str .= '#Select field from table db_helpdesk ...<br/>';
                    $str .= '#Truncate tbl_helpdesk_employee_users; <br/>';
                    $query = "TRUNCATE `tbl_helpdesk_employee_users`";
                    $this->Tbl_helpdesk_employee_users->query($query, 'update');
                    $str .= '#Successfully reset tbl_helpdesk_employee_users...';
                    break;
            }
            echo $str;
        }
    }

    protected function reset_ticket() {
        $this->load->model(array('Tbl_helpdesk_tickets'));
        $str = '#Preparing data...<br/>';
        $str .= '#Select field from table db_helpdesk ...<br/>';
        $str .= '#Truncate tbl_helpdesk_activities; <br/>';
        $str .= '#Truncate tbl_helpdesk_logs; <br/>';
        $str .= '#Truncate tbl_helpdesk_tickets; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_chats; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_files; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_handlers; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_transactions; <br/>';
        $str .= '#Truncate tbl_hepldesk_ticket_numbers; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_reopen_logs; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_requests; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_transfers; <br/>';
        $str .= '#Truncate tbl_helpdesk_ticket_logs; <br/>';

        $this->db->truncate('tbl_helpdesk_activities');
        $this->db->truncate('tbl_helpdesk_logs');
        $this->db->truncate('tbl_helpdesk_tickets');
        $this->db->truncate('tbl_helpdesk_ticket_chats');
        $this->db->truncate('tbl_helpdesk_ticket_files');
        $this->db->truncate('tbl_helpdesk_ticket_handlers');
        $this->db->truncate('tbl_helpdesk_ticket_transactions');
        $this->db->truncate('tbl_hepldesk_ticket_numbers');
        $this->db->truncate('tbl_helpdesk_ticket_reopen_logs');
        $this->db->truncate('tbl_helpdesk_ticket_requests');
        $this->db->truncate('tbl_helpdesk_ticket_transfers');
        $this->db->truncate('tbl_helpdesk_ticket_logs');

        $str .= '#Successfully reset tbl_helpdesk_activities, tbl_helpdesk_logs, tbl_helpdesk_tickets, tbl_helpdesk_ticket_chats, tbl_helpdesk_ticket_files, tbl_helpdesk_ticket_handlers, tbl_helpdesk_ticket_transactions, tbl_hepldesk_ticket_numbers, tbl_helpdesk_ticket_reopen_logs, tbl_helpdesk_ticket_requests, tbl_helpdesk_ticket_logs...';
        echo $str;
    }

    public function reset_open_ticket() {
        $this->load->model(array('Tbl_helpdesk_activities'));
        $str = '#Preparing data...<br/>';
        $str .= '#reset open id = 0 field from table db_helpdesk ...<br/>';
        $res = $this->Tbl_helpdesk_activities->find('all', array('or' => array('open_time !=' => '0000-00-00 00:00:00', 'is_open' => 1)));
        if ($res) {
            foreach ($res AS $key => $val) {
                $this->Tbl_helpdesk_activities->query("UPDATE `tbl_helpdesk_activities` SET `open_time` = '0000-00-00 00:00:00', `is_open` = '0' WHERE id = " . $val['id'], 'update');
                $str .= '#Successfully reset Tbl_helpdesk_activities... is_open to 0';
                echo $str;
            }
        }
    }

    public function reset_db() {
        $this->load->dbutil();

        $prefs = array(
            'format' => 'zip',
            'filename' => 'db_helpdesk.sql'
        );

        $backup = $this->dbutil->backup($prefs);

        $db_name = 'db_helpdesk' . date("Y-m-d-H-i-s") . '.zip'; // file name
        $save = DBPATH . 'backup/' . $db_name; // dir name backup output destination

        $this->load->helper('file');
        write_file($save, $backup);


        $db_path = DBPATH . 'db_helpdesk.sql';
        $file = read_file($db_path);
        $this->load->model('Tbl_configs');
        //do something
        $table_ = $this->Tbl_configs->query("SELECT table_name FROM information_schema.tables where table_schema='db_helpdesk';");
        if ($table_) {
            $tbl_nam = '';
            foreach ($table_ AS $key => $val) {
                if (!empty($tbl_nam))
                    $tbl_nam .= ', ';
                $tbl_nam .= "`" . $val['table_name'] . "`";
            }
            $this->db->query('DROP TABLE ' . $tbl_nam . ';');
        }
        $this->db->query($file);

        echo $file;
    }

}
