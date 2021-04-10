<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect(base_url('login'));
    }

    public function login($template_id = '') {
        $data = $this->setup_layout();
        $data['title_for_layout'] = 'welcome to login page Helpdesk';
        //load ajax var
        $var = array(
            array(
                'keyword' => 'group_id',
                'value' => isset($this->auth_config) ? $this->auth_config->group_id : '0'
            )
        );
        $this->load_ajax_var($var);
        //load js
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/additional-methods.min.js'),
            static_url('templates/metronics/assets/global/plugins/backstretch/jquery.backstretch.min.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic_login.phtml', $data);
    }

    public function check_data() {
        $this->load->library('oreno_auth');
        $post = $this->input->post(NULL, TRUE);
        if (isset($post['login']) && !empty($post['login'])) {
            $auth = $this->oreno_auth->auth($post['login']);
            $result = json_decode($auth);
            if ($result->result->status == "success") {
                echo return_call_back('message', array('login' => $result->result->status, 'group' => $result->result->group), 'json');
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
        exit();
    }

    public function switch_lang() {
        $request_language = $this->input->post(NULL, TRUE);
        if (isset($request_language['bahasa']) && !empty($request_language['bahasa'])) {
            $session_language = $this->session->userdata('_lang');
            if ($request_language['bahasa'] != $session_language) {
                //unset($_SESSION['_lang']);
                $_SESSION['_lang'] = strtolower($request_language['bahasa']);
                echo 'success';
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('failed_change_lang'));
            echo 'failed';
        }
    }
	
    public function logout() {
        $this->_logout();
        redirect(base_url('login'));
    }

    public function get_running_text() {
        $this->load->model('Tbl_helpdesk_login_notifications');
        $res = $this->Tbl_helpdesk_login_notifications->find('all', array('conditions' => array('is_active' => 1)));
        $arr_val = '';
        if ($res != null) {
            foreach ($res AS $key => $val) {
                $clr = isset($val['color']) ? $val['color'] : 'blue';
                $arr_val .= '
                <a class="btn ' . $clr . ' btn-outline sbold" data-toggle="modal" href="#modal_hot_news" title="Detail" data-id="' . base64_encode($val['id']) . '">' . $val['content_summary'] . ' </a>';
            }
        }
        echo $arr_val;
    }

    public function get_detail_running_text() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_login_notifications');
            $res = $this->Tbl_helpdesk_login_notifications->find('first', array('conditions' => array('id' => base64_decode($post['id']))));
            if ($res != null) {
                echo json_encode($res);
            } else {
                echo json_encode(null);
            }
        }
    }

    public function ticket_push() {
        $this->user_id = base64_decode($this->auth_config->user_id);
        $this->group_id = base64_decode($this->auth_config->group_id);
        $this->load->model(array('Tbl_helpdesk_ticket_chats'));
        $ticket_chats = $this->Tbl_helpdesk_ticket_chats->find('all', array('conditions' => array('is_show' => 0, 'reply_to' => $this->user_id), 'order' => array('key' => 'create_date', 'type' => 'DESC')));
        $ticket_push = array();
        if ($ticket_chats) {
            foreach ($ticket_chats AS $key => $value) {
                if ($value != null && $value['is_show'] == 0) {
                    $ticket_push[] = 'Ticket with code ' . $value['ticket_code'] . ' already had a reply from user ' . $value['messages'];
                    $arr_update = array(
                        'is_show' => 1
                    );
                    $this->Tbl_helpdesk_ticket_chats->update($arr_update, $value['id']);
                }
            }
        }
        echo json_encode(array('ticket_push' => $ticket_push));
    }
}
