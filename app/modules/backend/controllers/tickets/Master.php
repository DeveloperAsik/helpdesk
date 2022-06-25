<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Master
 *
 * @author SuperUser
 */
class Master extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_tickets'));
    }

    public function index() {
        redirect(base_backend_url('tickets/master/view/'));
    }

    public function view($key = 'open') {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_master');
        $data['view-header-title'] = $this->lang->line('global_header_title_master');
        $var = array(
            array(
                'keyword' => 'key',
                'value' => $key
            )
        );
        $this->load_ajax_var($var);
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $css_files = array(
            static_url('templates/metronics/assets/global/css/timeline.css'),
            static_url('templates/metronics/assets/global/css/todo.css'),
        );
        $this->load_css($css_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_list($key = null) {
        ini_set('memory_limit', '2048M');
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_branchs', 'Tbl_helpdesk_ticket_priorities', 'Tbl_helpdesk_ticket_requests', 'Tbl_helpdesk_ticket_reopen_logs'));
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $search = trim($post['search']['value']);
            $conditions_search = $fld = $joins = '';
            if (isset($key) && !empty($key)) {
                if ($key == 'transfer') {
                    $fld = ',`j`.`notes`,`j`.`user_from`,`j`.`user_to`';
                    if ($this->auth_config->group_id == 1) {
                        $conditions_search = " AND `c`.`name` LIKE '%{$key}%' ";
                    } else {
                        $conditions_search = " AND `c`.`name` LIKE '%{$key}%' AND j.user_to != " . (int) base64_decode($this->auth_config->user_id) . " AND j.user_from != " . (int) base64_decode($this->auth_config->user_id);
                    }
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_transfers` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'transfer_in') {
                    $fld = ',`j`.`notes`,`j`.`user_from`,`j`.`user_to`';
                    $conditions_search = " AND `c`.`name` LIKE '%transfer%' AND j.user_to = " . (int) base64_decode($this->auth_config->user_id);
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_transfers` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'transfer_out') {
                    $fld = ',`j`.`notes`,`j`.`user_from`,`j`.`user_to`';
                    $conditions_search = " AND `c`.`name` LIKE '%transfer%' AND j.user_from = " . (int) base64_decode($this->auth_config->user_id);
                    $joins = 'RIGHT JOIN `tbl_helpdesk_ticket_transfers` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'progress') {
                    $fld = ', `j`.`id` `reopen_id` ,`j`.`message`';
                    $conditions_search = " AND `c`.`name` LIKE '%progress%' AND `j`.`id` IS NULL ";
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_reopen_logs` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'progress_reopen') {
                    $fld = ', `j`.`id` `reopen_id` ,`j`.`message`';
                    $conditions_search = " AND `c`.`name` LIKE '%progress%' ";
                    $joins = 'RIGHT JOIN `tbl_helpdesk_ticket_reopen_logs` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } else {
                    $conditions_search = " AND `c`.`name` LIKE '%{$key}%' ";
                }
            }
            $cond_search_opt = '';
            if (isset($search) && !empty($search)) {
                $cond_search_opt = " 
                AND (  
                    `a`.`create_date` LIKE '%$search%' OR 
                    `a`.`code` LIKE '%$search%' OR 
                    `a`.`content` LIKE '%$search%' OR 
                    `c`.`name` LIKE '%$search%' OR 
                    `e`.`name` LIKE '%$search%' OR 
                    `f`.`name` LIKE '%$search%' OR 
                    `h`.`name` LIKE '%$search%'                 
                )
                ";
            }
            $query = "
                SELECT 
                `a`.*,
                `b`.`ticket_id`, `b`.`category_id`,`b`.`job_id`,`b`.`status_id`,`b`.`branch_id`,`b`.`priority_id`,`b`.`rule_id`,`b`.`problem_impact_id`,
                `c`.`name` `ticket_status`, `c`.`rank`, `d`.`response_time_start`, `d`.`response_time_stop`, `d`.`transfer_time_start`, `d`.`transfer_time_stop`, `d`.`solving_time_start`, `d`.`solving_time_stop`, `d`.`is_open`,
                `e`.`name_ina` `category_name`,
                `f`.`name` `job_category_name`, 
                `g`.`user_id` `response_by`,
                `h`.`name` `priority_name`,
                `i`.`name` `branch_name`
                $fld
                FROM `tbl_helpdesk_tickets` `a`
                LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                LEFT JOIN `tbl_helpdesk_ticket_status` `c` ON `c`.`id` = `b`.`status_id`
                LEFT JOIN `tbl_helpdesk_activities` `d` ON `d`.`ticket_id` = `a`.`id` AND `d`.`is_active` = 1
                LEFT JOIN `tbl_helpdesk_ticket_categories` `e` ON `e`.`id` = `b`.`category_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `f` ON `f`.`id` = `b`.`job_id`
                LEFT JOIN `tbl_helpdesk_ticket_handlers` `g` ON `g`.`ticket_id` = `a`.`id`
                LEFT JOIN `tbl_helpdesk_ticket_priorities` `h` ON `h`.`id` = `b`.`priority_id`
                LEFT JOIN `tbl_helpdesk_branchs` `i` ON `i`.`id` = `b`.`branch_id`
                $joins 
                WHERE `a`.`is_active` = 1 $conditions_search $cond_search_opt 
                LIMIT $start, $length
            ";
            $query_total = "
                SELECT `a`.`id` 
                FROM `tbl_helpdesk_tickets` `a`
                LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                LEFT JOIN `tbl_helpdesk_ticket_status` `c` ON `c`.`id` = `b`.`status_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `e` ON `e`.`id` = `b`.`category_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `f` ON `f`.`id` = `b`.`job_id`
                LEFT JOIN `tbl_helpdesk_ticket_priorities` `h` ON `h`.`id` = `b`.`priority_id`
                $joins 
                WHERE `a`.`is_active` = 1 $conditions_search
                $cond_search_opt
            ";
            $total_rows = count($this->Tbl_helpdesk_tickets->query($query_total));
            $res = $this->Tbl_helpdesk_tickets->query($query);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $solving_issue = $this->Tbl_helpdesk_ticket_requests->query("SELECT message FROM tbl_helpdesk_ticket_requests WHERE create_date IN (SELECT max(create_date) FROM tbl_helpdesk_ticket_requests WHERE ticket_id =  " . $d['id'] . ")");
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $branch_code = $this->Tbl_helpdesk_branchs->get_code($d['branch_id']);
                    if ($this->auth_config->group_id == 1) {
                        $branch_code = 'Tim TIK';
                    }
                    $data['rowcheck'] = '
                    <div class="form-group form-md-checkboxes">
                        <div class="md-checkbox-list">
                            <div class="md-checkbox">
                                <input type="checkbox" id="select_tr' . $d['id'] . '" class="md-check select_tr" name="select_tr[' . $d['id'] . ']" data-id="' . $d['id'] . '" />
                                <label for="select_tr' . $d['id'] . '">
                                        <span></span>
                                        <span class="check" style="left:20px;"></span>
                                        <span class="box" style="left:14px;"></span>
                                </label>
                            </div>
                        </div>
                    </div>';
                    $priority = '';
                    if ($d['priority_id']) {
                        $list_ticket_priorities = $this->Tbl_helpdesk_ticket_priorities->find('list', array('conditions' => array('a.is_active' => 1)));
                        foreach ($list_ticket_priorities AS $k => $value) {
                            $ds = '';
                            $st = 'title="Set this ticket priority into ' . $value['name'] . '"';
                            if ($d['priority_id'] == $value['id']) {
                                $ds = ' disabled="disabled"';
                                $st = '';
                            }
                            $priority .= '<button type="button" data-ticket="' . base64_encode($d['id']) . '" data-id="' . $value['id'] . '" data-name="' . $value['name'] . '" class="btn btn-default set_priority"' . $ds . $st . '>' . $value['name'] . '</button>';
                        }
                    }
                    $prio = '<div class="btn-group-vertical margin-right-10">' . $priority . '</div>';
                    $data['num'] = $i;
                    $data['code'] = $d['code']; //optional
                    $data['branch_code'] = $branch_code; //optional	
                    $data['content'] = substr($d['content'], 0, 80); //optional	
                    $ticket_reopen = $this->Tbl_helpdesk_ticket_reopen_logs->find('first', array('conditions' => array('is_active' => 1, 'ticket_id' => $d['id'])));
                    $status = $this->get_btn_ticket_status($d['ticket_status']); //optional	
                    if ($d['ticket_status'] == 'progress') {
                        $ticket_reopen = $this->Tbl_helpdesk_ticket_reopen_logs->find('first', array(
                            'conditions' => array(
                                'a.is_active' => 1,
                                'a.ticket_id' => $d['id']
                            ),
                            'joins' => array(
                                array(
                                    'table' => 'tbl_helpdesk_ticket_transactions b',
                                    'conditions' => 'b.ticket_id = a.ticket_id',
                                    'type' => 'left'
                                )
                            )
                                )
                        );
                        if (isset($ticket_reopen) && !empty($ticket_reopen)) {
                            $status = '<span style="background-color:#508fda; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">Reopen</span>';
                        } else {
                            $status = $this->get_btn_ticket_status($d['ticket_status']); //optional	
                        }
                    } elseif ($d['ticket_status'] == 'transfer') {
                        $desc_ticket = $this->Tbl_helpdesk_ticket_transfers->find('first', array(
                            'conditions' => array('ticket_id' => $d['id']),
                            'joins' => array(
                                array(
                                    'table' => 'tbl_users b',
                                    'conditions' => 'b.id = a.user_to',
                                    'type' => 'left'
                                )
                            )
                                )
                        );
                        $arr_ticket_transfer = '';
                        if ($key == 'transfer_in' || $key == 'transfer_out' || $key == 'transfer') {
                            if ($desc_ticket) {
                                $arr_ticket_transfer = 'transfer to <b>' . $desc_ticket['username'] . '<b/>';
                            }
                        }
                        $status = $this->get_btn_ticket_status($d['ticket_status'], $arr_ticket_transfer);
                    }
                    $data['status'] = $status;
                    $data['category_name'] = $d['category_name']; //optional
                    $data['priority_name'] = $prio;
                    $data['job_category_name'] = $d['job_category_name']; //optional
                    $data['branch_name'] = $d['branch_name']; //optional
                    $data['create'] = idn_date($d['create_date']); //optional
                    $data['create_def'] = $this->fn_get_style_by_create_date($d['create_date']); //optional
                    $data['create_def_text'] = $this->fn_get_text_by_create_date($d['create_date']); //optional
                    if ($d['ticket_status'] == 'close' || $d['ticket_status'] == 'progress') {
                        $data['close_message'] = isset($solving_issue[0]['message']) ? $solving_issue[0]['message'] : '#'; //optional 
                    } else {
                        $data['close_message'] = '-';
                    }
                    $data['description'] = $d['description']; //optional
                    $dsbl = $dsbl2 = '';
                    $dsbl_response = 'modal_response';
                    if ($d['is_open'] == 1) {
                        $dsbl = ' disabled=""';
                        $dsbl_response = '';
                    }
                    if ($d['ticket_status'] == 'open') {
                        $action = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-search-plus"></i> </a>					
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#' . $dsbl_response . '" title="Response" data-id="' . base64_encode($d['id']) . '"' . $dsbl . '> <i class="fa fa-pencil-square-o"></i> </a>
                        ';
                    } elseif ($d['ticket_status'] == 'progress') {
                        if ((int) base64_decode($this->auth_config->user_id) == $d['response_by']) {// || $this->auth_config->group_id == 1) {
                            $action = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-search-plus"></i> </a>					
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_transfer" title="Transfer" data-id="' . base64_encode($d['id']) . '"><i class="fa fa-mail-forward"></i></a>
                            <a id="' . $d['id'] . '" class="btn red btn-outline sbold" data-toggle="modal" href="' . base_backend_url('tickets/master/tracking/' . base64_encode($d['code'])) . '" title="Tracking" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-tripadvisor"></i> </a>    
                        ';
                        } elseif ((int) base64_decode($this->auth_config->user_id) == $d['created_by']) {
                            $action = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-search-plus"></i> </a>                    
                            <a id="' . $d['id'] . '" class="btn red btn-outline sbold" data-toggle="modal" href="' . base_backend_url('tickets/master/tracking/' . base64_encode($d['code'])) . '" title="Tracking" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-tripadvisor"></i> </a>    
                        ';
                        } else {
                            $action = '<a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-search-plus"></i> </a>';
                        }
                    } elseif ($d['ticket_status'] == 'transfer') {
                        if ($key == 'transfer_in') {
                            $action = '<a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"><i class="fa fa-search-plus"></i> </a>
                                <a id="' . $d['id'] . '" class="btn red btn-outline sbold" data-toggle="modal" href="' . base_backend_url('tickets/master/tracking/' . base64_encode($d['code'])) . '" title="Tracking" data-id="' . base64_encode($d['id']) . '"><i class="fa fa-tripadvisor"></i> </a>';
                        } else {
                            $action = '<a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-search-plus"></i> </a>';
                        }
                    } elseif ($d['ticket_status'] == 'close') {
                        $action = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-search-plus"></i> </a>					
                            <a class="btn red btn-outline sbold" title="re Open this ticket" data-toggle="modal" href="#modal_re_open" data-id="' . base64_encode($d['id']) . '"> <i class="fa fa-folder-open-o"></i> </a>';
                    }
                    $data['action'] = $action;
                    $arr[] = $data;
                    $i++;
                }
            }
            $output = array(
                'draw' => $draw,
                'recordsTotal' => $total_rows,
                'recordsFiltered' => $total_rows,
                'data' => $arr,
            );
            //output to json format
            echo json_encode($output);
        } else {
            echo json_encode(array());
        }
    }

    public function get_data() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_chats'));
            $id = base64_decode($post['ticket_id']);
            $result = $this->Tbl_helpdesk_tickets->find('first', array(
                'fields' => array('a.*', 'b.status_id', 'b.category_id', 'b.job_id', 'c.name ticket_status'),
                'conditions' => array('a.id' => $id),
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
            ));
            if (isset($result) && !empty($result)) {
                $files = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $result['code'])));
                $t = array(
                    'files' => $files
                );
                $result = array_merge($result, $t);
                $chat = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                    'fields' => array('a.*', 'b.username', 'b.email user_email'),
                    'conditions' => array('ticket_id' => $id),
                    'order' => array('key' => 'a.create_date', 'type' => 'DESC'),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id = a.created_by',
                            'type' => 'left'
                        )
                    )
                        )
                );
                $u = array('chats' => $chat);
                $result = array_merge($result, $u);
                if ($result['ticket_status'] == 'close') {
                    $chat_last = $this->Tbl_helpdesk_ticket_chats->find('last', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('ticket_id' => $id),
                        'order' => array('key' => 'a.create_date', 'type' => 'DESC'),
                        'joins' => array(
                            array(
                                'table' => 'tbl_users b',
                                'conditions' => 'b.id = a.created_by',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $v = array('last_chats' => $chat_last);
                    $result = array_merge($result, $v);
                }
                $category_id = $result['category_id'];
                $job_id = $result['job_id'];
                //get first category selected
                $category = $this->Tbl_helpdesk_tickets->query("
                    SELECT * FROM tbl_helpdesk_ticket_categories a
                    WHERE a.id = {$category_id}
                ");
                $result = array_merge($result, array('category' => isset($category[0]) ? $category[0] : ''));
                //get job selected 
                $job = $this->Tbl_helpdesk_tickets->query("
                    SELECT * FROM tbl_helpdesk_ticket_categories a
                    WHERE a.id = {$job_id}
                ");
                $result = array_merge($result, array('job' => isset($job[0]) ? $job[0] : ''));
                echo json_encode($result);
            } else {
                echo null;
            }
        }
    }

    public function insert() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->library('oreno_ticket');
            $sess = $this->_session_auth($this->config->session_name);
            $res = $this->oreno_ticket->insert($post, $sess);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'name' => $post['name'],
                'description' => $post['description'],
                'is_active' => $status,
            );
            $res = $this->Tbl_helpdesk_tickets->update($arr, base64_decode($post['id']));
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
    }

    public function update_status() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $id = base64_decode($post['id']);
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'is_active' => $status
            );
            $res = $this->Tbl_helpdesk_tickets->update($arr, $id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function remove() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_helpdesk_tickets->remove($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_helpdesk_tickets->remove($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function delete() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_helpdesk_tickets->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_helpdesk_tickets->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function get_ticket_detail($key = 'detail') {
        if ($key == 'detail') {
            $post = $this->input->post(NULL, TRUE);
            if (isset($post) && !empty($post)) {
                $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_handlers', 'Tbl_users', 'Tbl_helpdesk_ticket_problem_impacts', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_chats'));
                $id = base64_decode($post['ticket_id']);
                $res = $this->Tbl_helpdesk_tickets->query("SELECT
                    a.*, 
                    b.*, 
                    c.name ticket_status
                    FROM tbl_helpdesk_tickets a
                    LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id
                    LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id
                    WHERE a.id = {$id}
                ");
                $result = array();
                if ($res != null) {
                    $result = $res[0];
                    if ($result['create_date']) {
                        $result['create_date'] = idn_date(strtotime($result['create_date']));
                    }
                    $category_id = $result['category_id'];
                    $job_id = $result['job_id'];
                    //get first category selected
                    $category = $this->Tbl_helpdesk_tickets->query("
                        SELECT * FROM tbl_helpdesk_ticket_categories a
                        WHERE a.id = {$category_id}
                    ");
                    $result = array_merge($result, array('category' => isset($category[0]) ? $category[0] : ''));
                    //get job selected 
                    $job = $this->Tbl_helpdesk_tickets->query("
                        SELECT * FROM tbl_helpdesk_ticket_categories a
                        WHERE a.id = {$job_id}
                    ");
                    $result = array_merge($result, array('job' => isset($job[0]) ? $job[0] : ''));
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
                        'handle_by' => 'un-handle'
                    );
                    if ($handler != null) {
                        $r = array(
                            'handle_by' => $handler['handler_email']
                        );
                    }
                    $result = array_merge($result, $r);
                    $create_by = $this->Tbl_users->find('first', array('conditions' => array('id' => $result['created_by'])));
                    $rs = array(
                        'create_by_name' => $create_by['username'] . ' (' . $create_by['email'] . ')'
                    );
                    $result = array_merge($result, $rs);
                    $rc = array('recreate_by' => '-');
                    if ($result['issued_by'] != 0) {
                        $recreate_by = $this->Tbl_users->find('first', array('conditions' => array('id' => $result['issued_by'])));
                        $rc = array(
                            'recreate_by' => $recreate_by['username']
                        );
                    }
                    $result = array_merge($result, $rc);
                    $impact = $this->Tbl_helpdesk_ticket_problem_impacts->find('first', array(
                        'conditions' => array('a.is_active' => 1, 'a.id' => $result['problem_impact_id'])
                    ));
                    $s = array(
                        'problem_impact' => isset($impact['name_ina']) ? $impact['name_ina'] : ''
                    );
                    $result = array_merge($result, $s);
                    $files = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $result['code'])));
                    $t = array(
                        'files' => $files
                    );
                    $result = array_merge($result, $t);
                    if ($result['branch_id'] && $result['branch_id'] != 0) {
                        $branch = $this->Tbl_helpdesk_branchs->find('first', array('conditions' => array('a.id' => $result['branch_id'])));
                        $b = array(
                            'branch' => $branch
                        );
                        $result = array_merge($result, isset($b) ? $b : '');
                    }
                    $chat = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('ticket_id' => $id, 'a.created_by !=' => 0),
                        'order' => array('key' => 'a.create_date', 'type' => 'DESC'),
                        'joins' => array(
                            array(
                                'table' => 'tbl_users b',
                                'conditions' => 'b.id = a.created_by',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $new_chat = array();
                    if (isset($chat) && !empty($chat)) {
                        foreach ($chat AS $key => $val) {
                            $val['create_date'] = idn_date($val['create_date']);
                            $new_chat[$key] = $val;
                        }
                    }
                    $u = array('history_chat' => $new_chat);
                    $result = array_merge($result, $u);
                    $history = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('a.ticket_id' => $id, 'a.created_by' => 0),
                        'order' => array('key' => 'a.create_date', 'type' => 'ASC'),
                        'joins' => array(
                            array(
                                'table' => 'tbl_users b',
                                'conditions' => 'b.id = a.created_by',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $new_history = array();
                    if (isset($history) && !empty($history)) {
                        foreach ($history AS $key => $val) {
                            $val['create_time'] = date('H:i', strtotime($val['create_date']));
                            $val['create_date'] = date('d/m/Y', strtotime($val['create_date']));

                            $new_history[$key] = $val;
                        }
                    }
                    $z = array('history_ticket' => $new_history);
                    $result = array_merge($result, $z);
                    if ($result['ticket_status'] == 'transfer') {
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
                        $v = array('ticket_transfer' => $ticket_transfer);
                        $result = array_merge($result, $v);
                    }
                    if ($result['ticket_status'] == 'close') {
                        $chat_last = $this->Tbl_helpdesk_ticket_chats->find('last', array(
                            'fields' => array('a.*', 'b.username', 'b.email user_email'),
                            'conditions' => array('ticket_id' => $id),
                            'order' => array('key' => 'a.create_date', 'type' => 'DESC'),
                            'joins' => array(
                                array(
                                    'table' => 'tbl_users b',
                                    'conditions' => 'b.id = a.created_by',
                                    'type' => 'left'
                                )
                            )
                                )
                        );
                        $v = array('last_chats' => $chat_last);
                        $result = array_merge($result, $v);
                    }
                }
                echo json_encode($result);
            }
        } elseif ($key == 'response') {
            $post = $this->input->post(NULL, TRUE);
            if (isset($post) && !empty($post)) {
                $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_handlers', 'Tbl_users', 'Tbl_helpdesk_ticket_problem_impacts', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_chats'));
                $id = base64_decode($post['ticket_id']);
                $res = $this->Tbl_helpdesk_tickets->query("SELECT
                    a.*, 
                    b.ticket_id,b.category_id,b.job_id,b.problem_impact_id,  
                    c.name ticket_status
                    FROM tbl_helpdesk_tickets a
                    LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id
                    LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id
                    WHERE a.id = {$id}
                ");
                $result = $res[0];
                if ($result['create_date']) {
                    $result['create_date'] = date('d-m-Y H:i:s', strtotime($result['create_date']));
                }
                $category_id = $result['category_id'];
                $job_id = $result['job_id'];
                //get first category selected
                $category = $this->Tbl_helpdesk_tickets->query("
                        SELECT * FROM tbl_helpdesk_ticket_categories a
                        WHERE a.id = {$category_id}
                    ");
                $result = array_merge($result, array('category' => isset($category[0]) ? $category[0] : ''));
                //get job selected 
                $job = $this->Tbl_helpdesk_tickets->query("
                        SELECT * FROM tbl_helpdesk_ticket_categories a
                        WHERE a.id = {$job_id}
                    ");
                $result = array_merge($result, array('job' => isset($job[0]) ? $job[0] : ''));
                $Impacts = $this->Tbl_helpdesk_ticket_problem_impacts->find('first', array(
                    'conditions' => array('a.is_active' => 1, 'a.id' => $result['problem_impact_id'])
                ));
                $impact = '';
                if (isset($Impacts) && !empty($Impacts)) {
                    if ($_SESSION['_lang'] == 'indonesian') {
                        $impact = $Impacts['name_ina'];
                    } else {
                        $impact = $Impacts['name'];
                    }
                }
                $s = array(
                    'problem_impact' => $impact
                );
                $result = array_merge($result, $s);
                $files = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $result['code'])));
                $t = array(
                    'files' => $files
                );
                $result = array_merge($result, $t);
            }
            echo json_encode($result);
        }
    }

    public function get_issue_suggest() {
        $this->load->model('Tbl_helpdesk_ticket_issue_suggestions');
        $res = $this->Tbl_helpdesk_ticket_issue_suggestions->find('all', array(
            'conditions' => array('a.is_active' => 1)
        ));
        if (isset($res) && !empty($res)) {
            $ar = '<option>' . $this->lang->line('global_select_one') . '</option>';
            foreach ($res AS $key => $val) {
                $txt = '';
                if ($_SESSION['_lang']) {
                    if ($_SESSION['_lang'] == 'english') {
                        $txt = $val['value_eng'];
                    } elseif ($_SESSION['_lang'] == 'indonesian') {
                        $txt = $val['value_ina'];
                    }
                }
                $ar .= '<option value="' . $txt . '">' . $txt . '</option>';
            }
            echo ($ar);
        } else {
            echo null;
        }
    }

    public function set_open() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_activities');
            $res = $this->Tbl_helpdesk_activities->update_by(array('open_time' => date_now(), 'is_open' => 1), base64_decode($post['ticket_id']), 'ticket_id');
            if (isset($res) && !empty($res)) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function check_ticket_timeout() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_activities');
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => base64_decode($post['ticket_code']))));
            $res = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket['id'])));
            if ($res == null) {
                echo 'true';
            } else {
                $max_ticket = 7;
                $sum_ticket = (int) (fn_date_diff_ticket($res['open_time'], date_now()));
                if (($res['is_open'] == 1) && ($sum_ticket <= $max_ticket)) {
                    echo 'true';
                } else {
                    $res = $this->Tbl_helpdesk_activities->update(array('open_time' => '0000-00-00 00:00:00', 'is_open' => 0), $res['id']);
                    echo 'false';
                }
            }
        }
    }

    public function set_close() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_activities');
            $ticket_id = base64_decode($post['ticket_id']);
            $tick = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
            if ($tick != null) {
                $res = $this->Tbl_helpdesk_activities->update(array('open_time' => '0000-00-00 00:00:00', 'is_open' => 0), $tick['id']);
                if (isset($res) && !empty($res)) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                echo 'failed';
            }
        }
    }

    public function tracking($code = null) {
        if ($code == null)
            redirect(base_backend_url('tickets/master/view/open?redirect=true&msg=Please select only registered ticket code'));
        if (strlen($code) != 28)
            redirect(base_backend_url('tickets/master/view/open?redirect=true&msg=Please select only registered ticket code'));

        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_master_tracking');
        $data['view-header-title'] = $this->lang->line('global_header_title_master_tracking');
        $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_files'));
        $data['code'] = base64_decode($code);
        try {
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array(
                'fields' => array('a.*', 'c.name ticket_status', 'd.username ticket_create_by'),
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
                    ),
                    array(
                        'table' => 'tbl_users d',
                        'conditions' => 'd.id = a.created_by',
                        'type' => 'left'
                    )
                )
                    )
            );
        } catch (exception $e) {
            $ticket = null;
        }
        if ($ticket == null || $ticket == '')
            redirect(base_url('tickets/master/view/open?redirect=true&msg=Ticket with code ' . $data['code'] . ' cannot found at db'));
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
            ),
            array(
                'keyword' => 'ticket_creator_id',
                'value' => $ticket['created_by']
            ),
            array(
                'keyword' => 'ticket_creator',
                'value' => $ticket['ticket_create_by']
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
            "http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js",
            static_url('lib/single/modernizr.custom.js'),
            static_url('lib/packages/dropzone/dist/dropzone.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/additional-methods.min.js'),
            static_url('templates/metronics/assets/global/plugins/select2/js/select2.full.min.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/lib/markdown.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.min.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js'),
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')
        );
        $this->load_js($js_files);
        $data['ticket'] = $ticket;
        $data['files'] = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $data['code'])));
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_content() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $ticket_id = base64_decode($post['ticket_id']);
            $this->load->model(array('Tbl_helpdesk_ticket_chats', 'Tbl_users'));
            $res = $this->Tbl_helpdesk_ticket_chats->find('all', array('conditions' => array('ticket_id' => $ticket_id, 'created_by !=' => 0), 'order' => array('key' => 'create_date', 'type' => 'DESC')));
            if (isset($res) && !empty($res)) {
                $arr_res = '';
                foreach ($res AS $key => $value) {
                    $user = $this->Tbl_users->find('first', array(
                        'fields' => array('a.*', 'b.img', 'c.group_id'),
                        'conditions' => array('a.id' => $value['created_by']),
                        'joins' => array(
                            array(
                                'table' => 'tbl_user_profiles b',
                                'conditions' => 'b.user_id = a.id',
                                'type' => 'left'
                            ),
                            array(
                                'table' => 'tbl_user_groups c',
                                'conditions' => 'c.user_id = a.id',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    if ($value['is_support'] == 1) {
                        $by = 'Vendor[' . $user['email'] . ']';
                        if ($value['created_by'] == 1) {
                            $by = 'Superuser[' . $user['email'] . ']';
                        } elseif ($user['group_id'] == 1 && $value['created_by'] != 1) {
                            $by = 'Timtik[' . $user['email'] . ']';
                        }
                        $imgUser = static_url('images/avatar/avatar80_1.jpg');
                        if (is_file(static_url($user['img']))) {
                            $imgUser = static_url($user['img']);
                        }
                    } else {
                        $by = 'User[' . $user['email'] . ']';
                        $imgUser = static_url('images/avatar/avatar80_5.jpg');
                        if (is_file(static_url($user['img']))) {
                            $imgUser = static_url($user['img']);
                        }
                    }
                    if ($value['reply_to'] == (int) base64_decode($this->auth_config->user_id)) {
                        $style = '#F3565D';
                    } elseif ($value['created_by'] == (int) base64_decode($this->auth_config->user_id)) {
                        $style = '#28acb8';
                    } elseif ($value['reply_to'] != (int) base64_decode($this->auth_config->user_id) && $value['created_by'] != (int) base64_decode($this->auth_config->user_id)) {
                        $style = '#f5f6fa';
                    }

                    $arr_res .= '<div class="timeline-item">
                        <div class="timeline-badge">
                            <img class="timeline-badge-userpic" src="' . $imgUser . '"> </div>
                        <div class="timeline-body" style="border-left:4px solid ' . $style . '">
                            <div class="timeline-body-arrow" style="border-color:transparent  ' . $style . ' transparent transparent"> </div>
                            <div class="timeline-body-head">
                                <div class="timeline-body-head-caption">
                                    <a href="javascript:;" class="timeline-body-title font-blue-madison">' . $by . '</a>
                                    <span class="timeline-body-time font-grey-cascade">' . idn_date($value['create_date']) . '</span>
                                </div>
                            </div>
                            <div class="timeline-body-content">
                                <span class="font-grey-cascade">' . $value['messages'] . '</span>
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
                'messages' => $post['message'],
                'ticket_id' => $ticket_id,
                'ticket_code' => $post['ticket_code'],
                'is_support' => 1,
                'is_active' => 1,
                'reply_to' => $this->get_ticket_owner($ticket_id),
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

    public function create() {
        $this->load->model(array('Tbl_helpdesk_ticket_categories', 'Tbl_helpdesk_branchs', 'Tbl_helpdesk_ticket_problem_impacts'));
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_master_ticket_create');
        //load ajax var
        $var = array(
            array(
                'keyword' => 'code',
                'value' => $this->get_ticket_last_code()
            )
        );
        $this->load_ajax_var($var);
        //load js
        $js_files = array(
            "http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js",
            static_url('lib/single/modernizr.custom.js'),
            static_url('lib/packages/dropzone/dist/dropzone.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/additional-methods.min.js'),
            static_url('templates/metronics/assets/global/plugins/select2/js/select2.full.min.js'),
            static_url('templates/metronics/assets/global/plugins/backstretch/jquery.backstretch.min.js')
        );
        $this->load_js($js_files);
        switch (strtolower($_SESSION['_lang'])) {
            case 'english':
                $fields_ctg_ticket = array('a.id', 'a.name txt');
                $fields_problem = array('a.id', 'a.name txt');
                break;

            case 'indonesian':
                $fields_ctg_ticket = array('a.id', 'a.name_ina txt');
                $fields_problem = array('a.id', 'a.name_ina txt');
                break;
        }
        $data['branch'] = $this->Tbl_helpdesk_branchs->find('all', array('conditions' => array('is_active' => 1)));
        $data['problem_impact'] = $this->Tbl_helpdesk_ticket_problem_impacts->find('all', array('fields' => $fields_problem, 'conditions' => array('is_active' => 1)));
        $data['category'] = $this->Tbl_helpdesk_ticket_categories->find('all', array('fields' => $fields_ctg_ticket, 'conditions' => array('is_active' => 1, 'level' => 1)));
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function action($key = '', $code = null) {
        $this->load->library(array('Oreno_image_upload'));
        if ($key == 'upload') {
            if (isset($_FILES) && !empty($_FILES)) {
                list($width, $height) = getimagesize($_FILES['file']['tmp_name']);
                $options = array(
                    'code' => base64_decode($code),
                    'origin_name' => isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '',
                    'img_path' => $this->config->item('dir.ticket_file', 'path'),
                    'img_size_width' => array($width),
                    'img_name' => array('original')
                );
                $res = $this->oreno_image_upload->do_upload_ticket_files($_FILES['file'], $options);
                if (isset($res) && !empty($res)) {
                    $this->load->model('Tbl_helpdesk_ticket_files');
                    $arr_insert = array(
                        'code' => base64_decode($code),
                        'path' => $res['original'],
                        'description' => '-',
                        'is_active' => 1,
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $result = $this->Tbl_helpdesk_ticket_files->insert($arr_insert);
                    if ($result) {
                        echo 'success';
                    } else {
                        echo 'failed';
                    }
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function get_category($id = null, $opt = '') {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_categories'));
            $id = base64_decode($post['id']);
            $result = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                'conditions' => array('is_active' => 1, 'parent_id' => $id)
                    )
            );
            if (isset($result) && !empty($result)) {
                $arr = '<option value="">-- select one --</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
                echo $arr;
            } else {
                echo '';
            }
        } elseif ($opt == 'job') {
            $this->load->model(array('Tbl_helpdesk_ticket_categories'));
            $result = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                'conditions' => array('is_active' => 1, 'parent_id' => $id)
                    )
            );
            if (isset($result) && !empty($result)) {
                $arr = '<option value="">-- select one --</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
                echo $arr;
            } else {
                echo '';
            }
        } else {
            $this->load->model(array('Tbl_helpdesk_ticket_categories'));
            if ($id == null) {
                $result = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                    'conditions' => array('is_active' => 1, 'level' => 1)
                        )
                );
                if (isset($result) && !empty($result)) {
                    $arr = '<select id="response_ticket_change_category" name="response_ticket_change_category" class="form-control edited response_ticket_change_category"><option value="">-- select one --</option>';
                    foreach ($result AS $key => $value) {
                        $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                    }
                    $arr .= '</select>';
                    echo $arr;
                } else {
                    echo '';
                }
            }
        }
    }

    public function get_support($id = null) {
        $this->load->model('Tbl_helpdesk_ticket_supports');
        $result = $this->Tbl_helpdesk_ticket_supports->find('first', array(
            'fields' => array('a.*', 'b.name support_name'),
            'conditions' => array('category_id' => $id),
            'group' => array('a.id'),
            'joins' => array(
                array(
                    'table' => 'tbl_helpdesk_supports b',
                    'conditions' => 'b.id = a.support_id',
                    'type' => 'left'
                )
            )
        ));
        if (isset($result) && !empty($result)) {
            echo '<option value="' . $result['support_id'] . '">' . $result['support_name'] . '</option>';
        } else {
            echo '';
        }
    }

    public function detail($id_ = null) {
        if ($id_ != null) {
            $data['title_for_layout'] = $this->lang->line('global_title_for_layout_master_ticket_detail');
            $data['view-header-title'] = $this->lang->line('global_header_title_master_ticket_detail');
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_files'));
            $id = base64_decode($id_);
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => $id)));
            //load ajax var
            $var = array(
                array(
                    'keyword' => 'id',
                    'value' => $ticket['id']
                )
            );
            $this->load_ajax_var($var);
            $data['files'] = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $id)));
            $this->parser->parse('layouts/pages/metronic.phtml', $data);
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
                echo 'data not found';
            }
        }
    }

    public function close_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $ticket_id = base64_decode(base64_decode($post['ticket_id']));
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_requests', 'Tbl_helpdesk_ticket_categories', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_transactions'));
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => $ticket_id)));
            $ticket_transaction = $this->Tbl_helpdesk_ticket_transactions->find('first', array('conditions' => array('is_active' => 1, 'ticket_id' => $ticket_id)));
            $arr_trans = array(
                'status_id' => 4
            );
            $res = $this->Tbl_helpdesk_ticket_transactions->update($arr_trans, $ticket_transaction['id']);
            if ($res) {
                $job_list = '';
                if (isset($post['msg_job_list']) && !empty($post['msg_job_list'])) {
                    foreach ($post['msg_job_list'] AS $key => $val) {
                        if ($val == 'on') {
                            $txt = $this->Tbl_helpdesk_ticket_categories->find('first', array('conditions' => array('id' => $key)));
                            if (!empty($job_list))
                                $job_list .= ', ';
                            $job_list .= $txt['name'];
                        }
                    }
                }
                $arr_ticket_request = array(
                    'ticket_id' => $ticket_id,
                    'job_list' => $job_list,
                    'message' => $post['message'],
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_requests->insert($arr_ticket_request);
                $ticket_activitiy = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('is_active' => 1, 'ticket_id' => $ticket_id)));
                $arr_update_act = array(
                    'solving_time_stop' => date_now(),
                    'close_message' => $post['message']
                );
                $this->Tbl_helpdesk_activities->update($arr_update_act, $ticket_activitiy['id']);
                $chat = $this->Tbl_helpdesk_ticket_chats->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
                if ($chat == NULL) {
                    $this->load->model('Tbl_helpdesk_ticket_handlers');
                    $handler = $this->Tbl_helpdesk_ticket_handlers->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
                    $arr_chat_end = array(
                        'messages' => $post['message'],
                        'ticket_id' => $ticket_id,
                        'ticket_code' => $ticket['code'],
                        'is_open' => 0,
                        'is_show' => 0,
                        'is_support' => 1,
                        'is_active' => 1,
                        'reply_to' => $handler['user_id'],
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_chats->insert($arr_chat_end);
                } else {
                    $arr_chat_end = array(
                        'messages' => $post['message'],
                        'ticket_id' => $ticket_id,
                        'ticket_code' => $chat['ticket_code'],
                        'is_open' => $chat['is_open'],
                        'is_show' => $chat['is_show'],
                        'is_support' => $chat['is_support'],
                        'is_active' => $chat['is_active'],
                        'reply_to' => $chat['reply_to'],
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_chats->insert($arr_chat_end);

                    $arr_chat_end = array(
                        'messages' => 'telah di close oleh ' . ($this->auth_config->username),
                        'ticket_id' => $ticket_id,
                        'ticket_code' => $chat['ticket_code'],
                        'is_open' => $chat['is_open'],
                        'is_show' => $chat['is_show'],
                        'is_support' => 0,
                        'is_active' => $chat['is_active'],
                        'reply_to' => 0,
                        'created_by' => 0,
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_chats->insert($arr_chat_end);
                }
                echo 'success';
            }
        } else {
            echo 'failed';
        }
    }

    public function check_ticket_open() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_activities');
            $res = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => base64_decode($post['id']))));
            if ($res['is_open'] == 1) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

    public function mark_as_solve() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_handlers'));
            $id = base64_decode($post['ticket_id']);
            $msg = $post['message'];
            $arr = array(
                'response_time_stop' => date('Y-m-d H:i:s'),
                'solving_time_start' => date('Y-m-d H:i:s'),
                'solving_time_stop' => date('Y-m-d H:i:s'),
                'close_message' => $msg
            );
            $res = $this->Tbl_helpdesk_activities->update_by($arr, $id, 'ticket_id');
            if ($res) {
                $arr = array(
                    'status_id' => 5
                );
                $this->Tbl_helpdesk_ticket_transactions->update($arr, $id);
                $arr_ = array(
                    'ticket_id' => $id,
                    'user_id' => (int) base64_decode($this->auth_config->user_id),
                    'group_id' => (int) $this->auth_config->group_id,
                    'ticket_status' => 5,
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_handlers->insert($arr_);
                $rr_in = array(
                    'ticket_id' => $id,
                    'action' => 'close ticket',
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->create_ticket_logs($rr_in);
                echo 'successfully close this ticket.';
            } else {
                echo 'failed close this ticket.';
            }
        }
    }

    public function insert_image_summernote($code = null) {
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
                echo $this->config->item('url.chat_file', 'path') . base64_decode($code) . DS . $res['original'];
            } else {
                echo 'failed';
            }
        }
    }

    public function set_priority() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_ticket_transactions');
            $arr = array(
                'priority_id' => $post['v']
            );
            $res = $this->Tbl_helpdesk_ticket_transactions->update($arr, base64_decode($post['id']));
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function reopen() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_ticket_reopen_logs', 'Tbl_helpdesk_tickets'));
            $ticket_id = base64_decode($post['ticket_id']);
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array('condition' => array('id' => $ticket_id)));
            $ticket_transaction = $this->Tbl_helpdesk_ticket_transactions->find('first', array('conditions' => array('is_active' => 1, 'ticket_id' => $ticket_id)));
            $arr_transaction = array(
                'status_id' => 2
            );
            $res = $this->Tbl_helpdesk_ticket_transactions->update($arr_transaction, $ticket_transaction['id']);
            if ($res) {
                //create new time for reopen ticket\
                $old_ticket_activity = $this->Tbl_helpdesk_activities->find('last', array('conditions' => array('ticket_id' => $ticket_id), array('order' => array('key' => 'a.create_date', 'type' => 'DESC'))));
                $arr_ticket_activity = array(
                    'ticket_id' => $ticket_id,
                    'response_time_start' => $old_ticket_activity['response_time_start'],
                    'response_time_stop' => $old_ticket_activity['response_time_stop'],
                    'transfer_time_start' => $old_ticket_activity['transfer_time_start'],
                    'transfer_time_stop' => $old_ticket_activity['transfer_time_stop'],
                    'solving_time_start' => date_now(),
                    'solving_time_stop' => '0000-00-00 00:00:00',
                    'open_time' => '0000-00-00 00:00:00',
                    'is_open ' => 0,
                    'is_active' => 1,
                    'created_by  ' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_activities->insert($arr_ticket_activity);
                //update old activity to is_active = 0
                $arr_old_ticket_activity = array('is_active' => 0);
                $this->Tbl_helpdesk_activities->update($arr_old_ticket_activity, $old_ticket_activity['id']);
                //insert reopen log
                $handler = $this->Tbl_helpdesk_ticket_handlers->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
                $old_reopen_ticket = $this->Tbl_helpdesk_ticket_reopen_logs->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
                if ($old_reopen_ticket != null) {
                    //update old repoen log to is_active = 0
                    $arr_ins_reopen_old = array(
                        'is_active' => 0
                    );
                    $this->Tbl_helpdesk_ticket_reopen_logs->update($arr_ins_reopen_old, $old_reopen_ticket['id']);
                }
                $arr_ins_reopen = array(
                    'message' => $post['message'],
                    'ticket_id' => $ticket_id,
                    'handle_by' => $handler['user_id'],
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_reopen_logs->insert($arr_ins_reopen);
                $arr_ticket_chat = array(
                    'messages' => $post['message'],
                    'ticket_id' => $ticket_id,
                    'ticket_code' => $ticket['code'],
                    'is_open' => 0,
                    'is_show' => 0,
                    'is_support' => 1,
                    'is_active' => 1,
                    'reply_to' => $handler['user_id'],
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_ticket_chat);
                $rr_in = array(
                    'ticket_id' => $ticket_id,
                    'action' => 'reopen ticket',
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->create_ticket_logs($rr_in);
                echo 'success';
            }
        } else {
            echo 'failed';
        }
    }

    public function agreement_to_take_over_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $id = base64_decode($post['ticket_id']);
            $this->load->model(array('Tbl_helpdesk_ticket_transfers', 'Tbl_helpdesk_ticket_transactions'));
            $ticket_transfer = $this->Tbl_helpdesk_ticket_transfers->find('first', array(
                'conditions' => array(
                    'ticket_id' => $id,
                    'user_to' => (int) base64_decode($this->auth_config->user_id),
                    'is_active' => 1,
                    'is_received' => 0
                )
            ));
            if (isset($ticket_transfer) && !empty($ticket_transfer)) {
                $arr_ticket_trf = array(
                    'is_received' => 1,
                    'is_active' => 0
                );
                $this->Tbl_helpdesk_ticket_transfers->update($arr_ticket_trf, $ticket_transfer['id']);
                $ticket_trans = $this->Tbl_helpdesk_ticket_transactions->find('first', array(
                    'conditions' => array(
                        'is_active' => 1,
                        'ticket_id' => $id
                    )
                ));
                $arr_ticket_trans = array(
                    'status_id' => 2
                );
                $this->Tbl_helpdesk_ticket_transactions->update($arr_ticket_trans, $ticket_trans['id']);
                $rr_in = array(
                    'ticket_id' => $id,
                    'action' => 'take over ticket',
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->create_ticket_logs($rr_in);
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function response_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            //set ticket status into progress
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_activities'));
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => $post['ticket_code'])));
            $ticket_status = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket['id'])));
            /*
             * update ticket transaction for update ticket status to progress
             */
            $ticket_transaction = $this->Tbl_helpdesk_ticket_transactions->find('first', array('conditions' => array('is_active' => 1, 'ticket_id' => $ticket['id'])));
            if (isset($post['new_ticket_category']) && !empty($post['new_ticket_category'])) {
                $arr_ticket = array(
                    'category_id' => $post['new_ticket_category'],
                    'job_id' => $post['new_ticket_job'],
                    'status_id' => 2 //progress ticket status
                );
                $this->Tbl_helpdesk_ticket_transactions->update($arr_ticket, $ticket_transaction['id']);
            } else {
                $arr_ticket = array(
                    'status_id' => 2 //progress ticket status
                );
                $this->Tbl_helpdesk_ticket_transactions->update($arr_ticket, $ticket_transaction['id']);
            }
            /*
             * update ticket activities for update response time stop and solving time start
             */
            $arr_activity = array(
                'response_time_stop' => date_now(),
                'solving_time_start' => date_now(),
                'is_open' => 0,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $result = $this->Tbl_helpdesk_activities->update($arr_activity, $ticket_status['id']);
            if ($result == true) {
                $trs = $this->Tbl_helpdesk_ticket_transactions->find('first', array('conditions' => array('ticket_id' => $ticket['id'])));
                if (isset($post['new_ticket_category']) && !empty($post['new_ticket_category'])) {
                    $arr_ticket = array(
                        'category_id' => $post['new_ticket_category'],
                        'job_id' => $post['new_ticket_job'],
                        'status_id' => 2
                    );
                    $new_category_name = $this->Tbl_helpdesk_ticket_categories->get_name($post['new_ticket_category']);
                    $new_job_name = $this->Tbl_helpdesk_ticket_categories->get_name($post['new_ticket_job']);
                    //insert chat info from system
                    $arr_insert = array(
                        'messages' => 'telah di response oleh ' . ($this->auth_config->username) . ' dan merubah kategori yang sesuai dengan kategori ' . $new_category_name . ' dan jenis pekerjaan menjadi ' . $new_job_name,
                        'ticket_id' => $ticket['id'],
                        'ticket_code' => $ticket['code'],
                        'is_support' => 0,
                        'is_active' => 1,
                        'reply_to' => 0,
                        'created_by' => 0,
                        'create_date' => date_now()
                    );
                    $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
                } else {
                    $arr_ticket = array(
                        'status_id' => 2
                    );
                    //insert chat info from system
                    $arr_insert = array(
                        'messages' => 'telah di respon oleh ' . ($this->auth_config->username),
                        'ticket_id' => $ticket['id'],
                        'ticket_code' => $ticket['code'],
                        'is_support' => 0,
                        'is_active' => 1,
                        'reply_to' => 0,
                        'created_by' => 0,
                        'create_date' => date_now()
                    );
                    $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
                }
                $this->Tbl_helpdesk_ticket_transactions->update($arr_ticket, $trs['id']);
                //insert ticket handler by user active
                $arr_handler_ticket = array(
                    'ticket_id' => $ticket['id'],
                    'user_id' => (int) base64_decode($this->auth_config->user_id),
                    'group_id' => (int) ($this->auth_config->group_id),
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_handlers->insert($arr_handler_ticket);
                //insert message from user (ticket handler into chat)
                $arr_chat_msg2 = array(
                    'messages' => $post['message'],
                    'ticket_id' => $ticket['id'],
                    'ticket_code' => $ticket['code'],
                    'is_support' => 1,
                    'is_active' => 1,
                    'reply_to' => $ticket['created_by'],
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_chat_msg2);
                $rr_in = array(
                    'ticket_id' => $ticket['id'],
                    'action' => 'response ticket',
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->create_ticket_logs($rr_in);
            }
        }
    }

    public function transfer_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_branchs', 'Tbl_helpdesk_ticket_transfers', 'Tbl_user_groups', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_support_users', 'Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_files'));
            $user_to = 0;
            $parent_ticket = $this->Tbl_helpdesk_tickets->query("SELECT
                    a.*, 
                    b.*, 
                    c.name ticket_status
                    FROM tbl_helpdesk_tickets a
                    LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id
                    LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id
                    WHERE a.id = {$post['ticket_id']}
                ")[0];
            /*
             * Query insert into ticket transfer
             */
            $arr_data = array(
                'parent_ticket_id' => $post['ticket_id'],
                'parent_ticket_code' => $post['ticket_code'],
                'notes' => $post['note'],
                'user_from' => (int) base64_decode($this->auth_config->user_id),
                'user_to' => $user_to,
                'is_active' => 1,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            // $res = true;
            $res = $this->Tbl_helpdesk_ticket_transfers->insert($arr_data);
            if ($res) {
                /*
                 * Genereate new ticket
                 */
                $get_office_code = $this->get_office_code_from_ticket($post['ticket_code']);
                $imi_branchs = $this->Tbl_helpdesk_branchs->find('first', array('conditions' => array('code' => $get_office_code)));
                $new_ticket_code = $this->get_ticket_last_code($get_office_code);
                $arr = array(
                    "parent_ticket_id" => $post['ticket_id'],
                    "code" => $new_ticket_code,
                    "category" => $post['category'],
                    "job" => $post['job'],
                    "problem_impact" => $parent_ticket['problem_impact_id'],
                    "issue" => $parent_ticket['content'],
                    "issued_by" => (int) base64_decode($this->auth_config->user_id),
                    "created_by" => $parent_ticket['created_by']
                );
                $this->load->library('oreno_ticket');
                //$sess = $this->_session_auth($this->config->session_name);
                $sess = array('created_by' => $parent_ticket['created_by'], 'office_id' => $imi_branchs['id'], 'user_id' => base64_encode($parent_ticket['created_by']));
                $this->oreno_ticket->insert($arr, $sess);
                $new_ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => $new_ticket_code)));
                /*
                 * Query for get and update ticket handler
                 */
                $ticket_handler = $this->Tbl_helpdesk_ticket_handlers->find('first', array('conditions' => array('is_active' => 1, 'ticket_id' => $new_ticket['id'])));
                $group_user = $this->Tbl_user_groups->find('first', array('conditions' => array('user_id' => $user_to)));
                $arr_updt = array(
                    'user_id' => $user_to,
                    'group_id' => $group_user['group_id']
                );
                $this->Tbl_helpdesk_ticket_handlers->update($arr_updt, $ticket_handler['id']);
                /*
                 * Query for get and update ticket transaction
                 */
                //get parent ticket chat history
                $parent_ticket_chats = $this->Tbl_helpdesk_ticket_chats->find('last', array('conditions' => array('ticket_id' => $post['ticket_id']), 'order' => array('key' => 'create_date', 'keyword' => 'DESC')));
                $arr_insert = array(
                    'messages' => $post['note'],
                    'ticket_id' => $new_ticket['id'],
                    'ticket_code' => $new_ticket['code'],
                    'is_support' => 1,
                    'is_active' => 1,
                    'reply_to' => $parent_ticket_chats['reply_to'],
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
                //set to close status for parent ticket
                $ticket_trans = $this->Tbl_helpdesk_ticket_transactions->find('first', array('conditions' => array('ticket_id' => $post['ticket_id'])));
                $arr_trans = array(
                    'status_id' => 4
                );
                $this->Tbl_helpdesk_ticket_transactions->update($arr_trans, $ticket_trans['id']);
                $ticket_activity = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $post['ticket_id'])));
                $arr_activity = array(
                    'solving_time_stop' => date_now(),
                    'is_active' => 1
                );
                $this->Tbl_helpdesk_activities->update($arr_activity, $ticket_activity['id']);
                //insert chat info from system
                // $message_for_parent_id = 'close and create new ticket as extends from ' . $post['ticket_code'] .' and create new ticket ' . $new_ticket['code'];
                $parent_category_name = $this->Tbl_helpdesk_ticket_categories->get_name($parent_ticket['category_id']);
                $parent_job_name = $this->Tbl_helpdesk_ticket_categories->get_name($parent_ticket['job_id']);
                $child_category_name = $this->Tbl_helpdesk_ticket_categories->get_name($post['category']);
                $child_job_name = $this->Tbl_helpdesk_ticket_categories->get_name($post['job']);
                $message_for_parent_id = '
                    Tiket kode       : ' . $post['ticket_code'] . '  <br/>
                    Status           : Close <br/>
                    Perespon tiket   : ' . $this->auth_config->username . '<br/>
                    Kategori         : ' . $parent_category_name . '<br/>
                    Jenis pekerjaan  : ' . $parent_job_name . '<br/>
                    <br/>
                    Tiket ini telah di buat ulang menjadi :<br/>
                    Tiket kode       : ' . $new_ticket['code'] . '<br/>
                    Status           : Open <br/>
                    Kategori         : ' . $child_category_name . '<br/>
                    Jenis pekerjaan  : ' . $child_job_name . '<br/>
                ';
                $message_for_new_id = 'create new ticket and extend from ' . $post['ticket_code'] . ' to new ticket ' . $new_ticket['code'];
                //insert to chat by system
                $rr = array(
                    'messages' => $message_for_parent_id,
                    'ticket_id' => $post['ticket_id'],
                    'ticket_code' => $post['ticket_code'],
                    'is_open' => 0,
                    'is_show' => 0,
                    'is_support' => 0,
                    'is_active' => 1,
                    'reply_to' => 0,
                    'created_by' => 0,
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($rr);
                //insert message user to chat 
                $rr_ = array(
                    'messages' => $post['note'],
                    'ticket_id' => $post['ticket_id'],
                    'ticket_code' => $post['ticket_code'],
                    'is_open' => 0,
                    'is_show' => 0,
                    'is_support' => 1,
                    'is_active' => 1,
                    'reply_to' => $this->get_ticket_owner($post['ticket_id'], 1),
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($rr_);
                //insert to chat
                $rr2 = array(
                    'messages' => $message_for_new_id,
                    'ticket_id' => $new_ticket['id'],
                    'ticket_code' => $new_ticket['code'],
                    'is_open' => 0,
                    'is_show' => 0,
                    'is_support' => 0,
                    'is_active' => 1,
                    'reply_to' => 0,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($rr2);
                //insert log into parent log
                $rr_in = array(
                    'ticket_id' => $post['ticket_id'],
                    'ticket_code' => $post['ticket_code'],
                    'action' => $message_for_parent_id,
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->create_ticket_logs($rr_in);
                //insert log into new ticket
                $rr_in = array(
                    'ticket_id' => $new_ticket['id'],
                    'ticket_code' => $new_ticket['code'],
                    'action' => $message_for_new_id,
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->create_ticket_logs($rr_in);

                //insert file attachment
                $file_attahcment_old = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('code' => $post['ticket_code'])));

                foreach ($file_attahcment_old AS $k => $v) {
                    $typ = array(
                        "code" => $new_ticket['code'],
                        "path" => $v['path'],
                        "description" => $v['description'],
                        "is_active" => $v['is_active'],
                        "created_by" => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_files->insert($typ);
                }
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function check_status_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_activities');
            $res = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => base64_decode($post['id']))));
            if ($res['is_open'] == 0) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    public function check_total_transfer_ticket($ticket_id = null) {
        if ($ticket_id != null) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_transfers'));
            $ticket_1 = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => base64_decode($ticket_id))));
            if (isset($ticket_1) && !empty($ticket_1)) {
                $ticket_trf_1 = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('parent_ticket_id' => $ticket_1['parent_ticket_id'])));
                if (isset($ticket_trf_1) && !empty($ticket_trf_1)) {
                    $ticket_trf_2 = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => $ticket_trf_1['parent_ticket_id'])));
                    if (isset($ticket_trf_2) && !empty($ticket_trf_2)) {
                        $ticket_trf_3 = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => $ticket_trf_2['parent_ticket_id'])));
                        if (isset($ticket_trf_3) && !empty($ticket_trf_3)) {
                            $ticket_trf_4 = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('id' => $ticket_trf_3['parent_ticket_id'])));
                            if (isset($ticket_trf_4) && !empty($ticket_trf_4)) {
                                echo 'false';
                                exit();
                            }
                        }
                    }
                }
            }
        }
        echo 'true';
    }

}
