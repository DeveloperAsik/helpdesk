<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tracking
 *
 * @author asus
 */
class Tracking extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect(base_url('support/tracking/view/'));
    }

    public function view($code = null) {
        if ($code == null)
            redirect(base_url('ticket/view/open?redirect=true&msg=Please select only registered ticket code'));
        if (strlen($code) != 28)
            redirect(base_url('ticket/view/open?redirect=true&msg=Please select only registered ticket code'));

        $data['title_for_layout'] = 'Ticket tracking';
        $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_transfers'));
        $data['code'] = base64_decode($code);
        $data['view-header-title'] = 'Track your ticket';

        try {
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array(
                'fields' => array('a.*', 'c.name ticket_status'),
                'conditions' => array('code' => $data['code']),
                'joins' => array(
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
                )
                    )
            );
            if ($ticket['ticket_status'] == 'transfer') {
                $ticket_transfer = $this->Tbl_helpdesk_ticket_transfers->find('first', array(
                    'fields' => array('a.id', 'a.notes', 'b.username user_from_name', 'c.username user_to_name', 'is_received'),
                    'conditions' => array('ticket_id' => $ticket['id']),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id  = a.user_from',
                            'type' => 'left'
                        ),
                        array(
                            'table' => 'tbl_users c',
                            'conditions' => 'c.id  = a.user_to',
                            'type' => 'left'
                        )
                    )
                        )
                );
                $v = array(
                    'ticket_transfer' => $ticket_transfer
                );
                $ticket = array_merge($ticket, $v);
            }
        } catch (exception $e) {
            $ticket = null;
        }
        if ($ticket == null || $ticket == '')
            redirect(base_url('ticket/view/open?redirect=true&msg=Ticket with code ' . $data['code'] . ' cannot found at db'));

        $data['chats'] = $this->Tbl_helpdesk_ticket_chats->find('all', array('conditions' => array('a.ticket_id' => $ticket['id'])));
        $var = array(
            array(
                'keyword' => 'code',
                'value' => $data['code']
            ),
            array(
                'keyword' => 'ticket_id',
                'value' => $ticket['id']
            ),
            array(
                'keyword' => 'ticket_status',
                'value' => $ticket['ticket_status']
            )
        );
        $this->load_ajax_var($var);
        $css_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('lib/packages/jquery/jquery.tmpl.min.js'),
            static_url('lib/single/modernizr.custom.js'),
            static_url('lib/packages/dropzone/dist/dropzone.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/additional-methods.min.js'),
            static_url('templates/metronics/assets/global/plugins/select2/js/select2.full.min.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/lib/markdown.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.min.js')
        );
        $this->load_js($js_files);
        $data['ticket'] = $ticket;
        $data['files'] = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $data['code'])));
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_content() {
        ini_set('memory_limit', '1024M');
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $ticket_id = base64_decode($post['ticket_id']);
            $this->load->model(array('Tbl_helpdesk_ticket_chats', 'Tbl_users'));
            $res = $this->Tbl_helpdesk_ticket_chats->find('all', array('conditions' => array('ticket_id' => $ticket_id,'created_by !=' => 0), 'order' => array('key' => 'create_date', 'type' => 'DESC')));
            if (isset($res) && !empty($res)) {
                $arr_res = '';
                foreach ($res AS $key => $value) {
                    $user = $this->Tbl_users->find('first', array(
                        'fields' => array('a.*', 'b.img'),
                        'conditions' => array('a.id' => $value['created_by']),
                        'joins' => array(
                            array(
                                'table' => 'tbl_user_profiles b',
                                'conditions' => 'b.user_id = a.id',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    if ($value['is_support'] == 1) {
                        $by = 'Vendor[' . $user['email'] . ']';
                        if ($value['created_by'] == 1) {
                            $by = 'Superuser[' . $user['email'] . ']';
                        }elseif($value['created_by'] == 0){
                            $by = 'System auto generate';
                        }
                        $imgUser = static_url('images/avatar/avatar80_1.jpg');
                        if (is_file(static_url($user['img']))) {
                            $imgUser = static_url($user['img']);
                        }elseif($value['created_by'] == 0){
                            $by = 'System auto generate';
                        }
                    } else {
                        $by = 'User[' . $user['email'] . ']';
                        if($value['created_by'] == 0){
                            $by = 'System auto generate';
                        }
                        $imgUser = static_url('images/avatar/avatar80_5.jpg');
                        if (is_file(static_url($user['img']))) {
                            $imgUser = static_url($user['img']);
                        }
                    }
                    $style = '#F3565D';
                    if($value['reply_to'] == (int) base64_decode($this->auth_config->user_id)){
                        $style = '#F3565D';
                    }elseif($value['created_by'] == (int) base64_decode($this->auth_config->user_id)){
                        $style = '#28acb8';
                    }elseif($value['reply_to'] != (int) base64_decode($this->auth_config->user_id) && $value['created_by'] != (int) base64_decode($this->auth_config->user_id)){
                        $style = '#f5f6fa';
                    }
                    $arr_res .= '<div class="timeline-item">
                        <div class="timeline-badge">
                            <img class="timeline-badge-userpic" src="' . $imgUser . '"> </div>
                        <div class="timeline-body" style="border-left:4px solid '.$style.'">
                            <div class="timeline-body-arrow" style="border-color:transparent  '.$style.' transparent transparent"> </div>
                            <div class="timeline-body-head">
                                <div class="timeline-body-head-caption">
                                    <a href="javascript:;" class="timeline-body-title font-blue-madison">' . $by . '</a>
                                    <span class="timeline-body-time font-grey-cascade">' . idn_date($value['create_date']) . '</span>
                                </div>
                            </div>
                            <div class="timeline-body-content">
                                <span class="font-grey-cascade">' . ($value['messages']) . '</span>
                            </div>
                        </div>
                    </div>';
                }
                echo $arr_res;
            }
        }
    }

    public function insert_message() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_chats'));
            $ticket_id = base64_decode($post['ticket_id']);
            $arr_insert = array(
                'messages' => ($post['message']),
                'ticket_id' => $ticket_id,
                'ticket_code' => $post['ticket_code'],
                'is_support' => 1,
                'is_active' => 1,
                'reply_to' => $this->get_ticket_owner($ticket_id, 'vndr'),
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function get_ticket_detail() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_transfers', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_handlers','Tbl_helpdesk_ticket_problem_impacts'));
            $id = base64_decode($post['ticket_id']);
            $res = $this->Tbl_helpdesk_tickets->find('first', array(
                'fields' => array('a.*', 'c.name ticket_status', 'e.name category_name', 'f.id job_id', 'f.name job_category_name','b.problem_impact_id'),
                'conditions' => array('a.id' => $id),
                'order' => array('key' => 'a.create_date', 'type' => 'ASC'),
                'joins' => array(
                    array(
                        'table' => 'tbl_helpdesk_ticket_transactions b',
                        'conditions' => 'b.ticket_id = a.id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_helpdesk_ticket_status c',
                        'conditions' => 'c.id = b.status_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_helpdesk_support_users d',
                        'conditions' => 'd.category_id = b.category_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_helpdesk_ticket_categories e',
                        'conditions' => 'e.id = b.category_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_helpdesk_ticket_categories f',
                        'conditions' => 'f.id = b.job_id',
                        'type' => 'left'
                    )
                )
            ));

            if (isset($res) && !empty($res)) {
                if ($res['create_date']) {
                    $res['create_date'] = idn_date(strtotime($res['create_date']));
                }
                if ($res['ticket_status'] == 'transfer') {
                    $ticket_transfer = $this->Tbl_helpdesk_ticket_transfers->find('first', array(
                        'fields' => array('a.id', 'a.notes', 'b.username user_from_name', 'c.username user_to_name', 'is_received'),
                        'conditions' => array('ticket_id' => $id),
                        'joins' => array(
                            array(
                                'table' => 'tbl_users b',
                                'conditions' => 'b.id  = a.user_from',
                                'type' => 'left'
                            ),
                            array(
                                'table' => 'tbl_users c',
                                'conditions' => 'c.id  = a.user_to',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $v = array(
                        'ticket_transfer' => $ticket_transfer
                    );
                    $res = array_merge($res, $v);
                }
                $handler = $this->Tbl_helpdesk_ticket_handlers->find('first', array(
                    'fields' => array('a.*', 'b.email handler_email'),
                    'conditions' => array('ticket_id' => $id),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id = a.user_id',
                            'type' => 'left'
                        )
                    )
                        )
                );
                $r = array(
                    'handle_by' => $handler['handler_email']
                );
                $res = array_merge($res, $r);
                $chat = $this->Tbl_helpdesk_ticket_chats->find('first', array(
                    'fields' => array('a.*', 'b.username creator', 'b.email creator_email', 'c.username handler', 'c.email handler_email'),
                    'conditions' => array('a.ticket_id' => $id, 'a.is_active' => 1, 'a.created_by !=' => 0 ),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id = a.reply_to',
                            'type' => 'left'
                        ),
                        array(
                            'table' => 'tbl_users c',
                            'conditions' => 'c.id = a.created_by',
                            'type' => 'left'
                        )
                    )
                        )
                );
                $u = array(
                    'chats' => $chat
                );
                $res = array_merge($res, $u);
                $impact = $this->Tbl_helpdesk_ticket_problem_impacts->find('first', array(
                    'conditions' => array('a.is_active' => 1, 'a.id' => $res['problem_impact_id'])
                ));
                $s = array(
                    'problem_impact' => $impact['name']
                );
                $res = array_merge($res, $s);
                echo json_encode($res);
            } else {
                echo null;
            }
        }
    }

    public function get_job_desc() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_ticket_categories');
            $res = $this->Tbl_helpdesk_ticket_categories->find('all', array('conditions' => array('parent_id' => $post['job_id'])));
            if (isset($res) && !empty($res)) {
                $rr = '';
                foreach ($res AS $key => $val) {
                    $rr .= '
                    <div class="md-checkbox">
                        <input type="checkbox" data-id="' . $val['id'] . '" id="checkbox' . $val['id'] . '" class="md-check msg_job_list" name="msg_job_list[]">
                        <label for="checkbox' . $val['id'] . '">
                            <span class="inc"></span>
                            <span class="check"></span>
                            <span class="box"></span> ' . $val['name'] . ' 
                        </label>
                    </div>';
                }
                echo $rr;
            } else {
                echo 'data not found...';
            }
        }
    }

    public function close_ticket_request() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $ticket_id = base64_decode($post['ticket_id']);
            $this->load->model(array('Tbl_helpdesk_ticket_requests', 'Tbl_helpdesk_ticket_categories', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_chats'));
            $rr = '';
            if (isset($post['msg_job_list']) && !empty($post['msg_job_list'])) {
                foreach ($post['msg_job_list'] AS $key => $val) {
                    if ($val == 'on') {
                        $txt = $this->Tbl_helpdesk_ticket_categories->find('first', array('conditions' => array('id' => $key)));
                        if (!empty($rr))
                            $rr .= ', ';
                        $rr .= $txt['name'];
                    }
                }
            }
            $arr = array(
                'ticket_id' => $ticket_id,
                'job_list' => $rr,
                'message' => $post['message'],
                'is_active' => 1,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_requests->insert($arr);
            if ($res == true) {
                $this->Tbl_helpdesk_ticket_transactions->query("
                    UPDATE 
                    `tbl_helpdesk_ticket_transactions` SET `status_id` = '4' WHERE 
                    `tbl_helpdesk_ticket_transactions`.`ticket_id` = {$ticket_id};
                ", 'insert');
                $this->Tbl_helpdesk_activities->query("
                    UPDATE `tbl_helpdesk_activities` SET `solving_time_stop` = '" . date_now() . "',  `close_message` = '{$post['message']}'
                        WHERE `tbl_helpdesk_activities`.`ticket_id` = {$ticket_id} AND is_active = 1;
                ", 'update');
                $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => $ticket_id)));
                $chat = $this->Tbl_helpdesk_ticket_chats->find('first', array('conditions' => array('ticket_id' => $ticket_id), 'order' => array('key' => 'create_date', 'tipe' => 'DESC')));
                
                $arr_in_cht = array(
                    'messages' => $post['message'],
                    'ticket_id' => $ticket_id,
                    'ticket_code' => $ticket['code'],
                    'is_open' => 0,
                    'is_show' => 0,
                    'is_support' => 0,
                    'is_active' => 1,
                    'reply_to' => $this->get_ticket_owner($ticket_id, 'vndr'),
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_in_cht);
                //insert chat info from system
                $arr_insert = array(
                    'messages' => 'telah di close oleh '. ($this->auth_config->username),
                    'ticket_id' => $ticket_id,
                    'ticket_code' => $ticket['code'],
                    'is_support' => '00',
                    'is_active' => 1,
                    'reply_to' => '00',
                    'created_by' => '00',
                    'create_date' => date_now()
                );
                $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
                echo 'success';
                exit();
            }
        }
        echo 'failed';
    }

    public function success_close() {
        $data['title_for_layout'] = 'welcome';
        $data['view-header-title'] = 'View Issue_suggestion List';
        $data['content'] = 'ini kontent web';
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function insert_image_summernote($ticket_id = null,$code = null) {
        $this->load->library(array('Oreno_image_upload'));
        if (isset($_FILES) && !empty($_FILES)) {
            list($width, $height) = getimagesize($_FILES['file']['tmp_name']);
            $img_path = $this->config->item('dir.chat_file', 'path') . base64_decode($code);
            if (!is_dir($this->config->item('dir.chat_file', 'path') . base64_decode($code))) {
                mkdir($this->config->item('dir.chat_file', 'path') . base64_decode($code));
            }
            $options = array(
                'code' => base64_decode($code),
                'origin_name' => isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '',
                'img_path' => $img_path,
                'img_size_width' => array($width),
                'img_name' => array('original')
            );
            $res = $this->oreno_image_upload->do_upload_ticket_files($_FILES['file'], $options);
            if (isset($res) && !empty($res)) {
                $img_path = $this->config->item('url.chat_file', 'path') . base64_decode($code) . DS . $res['original'];
                echo $this->config->item('url.chat_file', 'path') . base64_decode($code) . DS . $res['original'];
            } else {
                echo 'failed';
            }
        }
    }

}
