<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ticket
 *
 * @author asus
 */
class Ticket extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->get_all_history();
        $this->load->model(array('Tbl_helpdesk_tickets'));
    }

    public function index() {
        redirect(base_url('vendor/ticket/view/'));
    }

    public function view($keyword = 'open') {
        $data['title_for_layout'] = 'welcome';
        $data['view-header-title'] = 'View Open Ticket List';
        $data['content'] = 'ini kontent web';
        $var = array(
            array(
                'keyword' => 'key',
                'value' => $keyword
            ),
            array(
                'keyword' => 'office_id',
                'value' => isset($this->auth_config->office_id) ? $this->auth_config->office_id : ''
            )
        );
        $this->load_ajax_var($var);
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $css_files = array(
            static_url('templates/metronics/assets/global/css/timeline.css'),
            static_url('templates/metronics/assets/global/css/todo.css'),
        );
        $this->load_css($css_files);
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_list($key = null) {
        ini_set('memory_limit', '1024M');
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_imigration_branchs', 'Tbl_helpdesk_ticket_requests', 'Tbl_helpdesk_ticket_reopen_logs'));
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $search = trim($post['search']['value']);
            $conditions_search = $joins = $fld = '';
            if (isset($key) && !empty($key)) {
                if ($key == 'transfer') {
                    $fld = ',`j`.`notes`,`j`.`user_from`,`j`.`user_to`';
                    $conditions_search = " AND `c`.`name` LIKE '%{$key}%' ";
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_transfers` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'transfer_in') {
                    $fld = ',`j`.`notes`,`j`.`user_from`,`j`.`user_to`';
                    $conditions_search = " AND `c`.`name` LIKE '%transfer%' AND j.user_to = " . (int) base64_decode($this->auth_config->user_id);
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_transfers` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'transfer_out') {
                    $fld = ',`j`.`notes`,`j`.`user_from`,`j`.`user_to`';
                    $conditions_search = " AND `c`.`name` LIKE '%transfer%' AND j.user_from = " . (int) base64_decode($this->auth_config->user_id);
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_transfers` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'progress') {
                    $fld = ', `j`.`id` `reopen_id` ,`j`.`message`';
                    $conditions_search = " AND `c`.`name` LIKE '%progress%' AND `j`.`id` IS NULL";
                    $joins = 'LEFT JOIN `tbl_helpdesk_ticket_reopen_logs` `j` ON `j`.`ticket_id` = `a`.`id` AND `j`.`is_active` = 1';
                } elseif ($key == 'progress_reopen') {
                    $fld = ', `j`.`id` `reopen_id` ,`j`.`message`';
                    $conditions_search = " AND `c`.`name` LIKE '%progress%'";
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
                `c`.`name` `ticket_status`,`c`.`rank`, `d`.`response_time_start`, `d`.`response_time_stop`, `d`.`transfer_time_start`, `d`.`transfer_time_stop`, `d`.`solving_time_start`, `d`.`solving_time_stop`, `d`.`is_open`,
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
                LEFT JOIN `tbl_helpdesk_imigration_branchs` `i` ON `i`.`id` = `b`.`branch_id`
                $joins
                WHERE `a`.`is_active` = 1 $conditions_search
                $cond_search_opt
                ORDER BY `c`.`rank` ASC, `a`.`create_date` DESC 
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
                    $branch_code = $this->Tbl_helpdesk_imigration_branchs->get_code($d['branch_id']);
                    if ($this->auth_config->group_id == 1) {
                        $branch_code = 'Tim TIK';
                    }
                    $data['num'] = $i;
                    $data['code'] = $d['code']; //optional
                    $data['content'] = substr($d['content'], 0, 80); //optional 
                    $data['category_name'] = $d['category_name']; //optional
                    $data['job_category_name'] = $d['job_category_name']; //optional
                    $data['branch_name'] = $d['branch_name']; //optional
                    $data['create'] = idn_date($d['create_date']); //optional 
                    $data['create_def'] = $this->fn_get_style_by_create_date($d['create_date']); //optional
                    $data['create_def_text'] = $this->fn_get_text_by_create_date($d['create_date']); //optional
                    $status = $this->get_btn_ticket_status($d['ticket_status']); //optional	
                    if (isset($d['reopen_id']) && $d['reopen_id'] != NULL) {
                        $status = '<span style="background-color:#508fda; padding:5px; font-weight:bold; color:#fff; cursor:context-menu">Reopen</span>';
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
                        if ($key == 'transfer_in' || $key == 'transfer_out') {
                            if ($desc_ticket) {
                                $arr_ticket_transfer = 'transfer to <b>' . $desc_ticket['username'] . '<b/>';
                            }
                        }
                        $status = $this->get_btn_ticket_status($d['ticket_status'], $arr_ticket_transfer);
                    }
                    $data['status'] = $status;
                    if ($d['ticket_status'] == 'close' || $d['ticket_status'] == 'progress') {
                        $data['close_message'] = isset($solving_issue[0]['message']) ? $solving_issue[0]['message'] : '#'; //optional 
                    } else {
                        $data['close_message'] = '-';
                    }
                    $dsbl = $dsbl2 = '';
                    $dsbl_response = 'modal_response';
                    if ($d['is_open'] == 1) {
                        $dsbl = ' disabled=""';
                        $dsbl_response = '';
                    }
                    $action = '';
                    if ($d['ticket_status'] == 'open') {
                        $action = '
                            <a class="btn red btn-outline bold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a>                 
                            <a class="btn red btn-outline bold" data-toggle="modal" href="#' . $dsbl_response . '" title="Respon" data-id="' . base64_encode($d['ticket_id']) . '"' . $dsbl . '> <i class="fa fa-pencil-square-o"></i> </a>
                        ';
                    } elseif ($d['ticket_status'] == 'progress') {
                        if ((int) base64_decode($this->auth_config->user_id) == $d['response_by']) {
                            $action = '
                                <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a>                    
                                <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_transfer" title="Transfer" data-id="' . base64_encode($d['ticket_id']) . '"><i class="fa fa-mail-forward"></i></a>
                                <a id="' . $d['id'] . '" class="btn red btn-outline sbold" data-toggle="modal" href="' . base_url('vendor/tracking/view/' . base64_encode($d['code'])) . '" title="Telusur" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-tripadvisor"></i> </a>
                            ';
                        } else {
                            $action = '<a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a> ';
                        }
                    } elseif ($d['ticket_status'] == 'transfer') {
                        if ($key == 'transfer_in') {
                            $action = '
                        <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a>
                        <a id="' . $d['id'] . '" class="btn red btn-outline sbold" data-toggle="modal" href="' . base_url('vendor/tracking/view/' . base64_encode($d['code'])) . '" title="Tracking" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-tripadvisor"></i> </a>
                        ';
                        } elseif ($key == 'transfer_out') {
                            $action = ' <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a>';
                        } else {
                            $action = ' <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a>';
                        }
                    } elseif ($d['ticket_status'] == 'close') {
                        $action = ' <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . base64_encode($d['ticket_id']) . '"> <i class="fa fa-search-plus"></i> </a>';
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
            $sess = $this->_session_auth($this->config->session_name);
            $arr_insert = array(
                'code' => $post['code'],
                'content' => $post['issue'],
                'description' => '-',
                'is_active' => 1,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $ticket_id = $this->Tbl_helpdesk_tickets->insert_return_id($arr_insert);
            if ($ticket_id) {
                $this->load->model(array('Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_rules', 'Tbl_helpdesk_activities'));
                $rule_id = $this->Tbl_helpdesk_ticket_rules->find('first', array('conditions' => array('id' => (int) $post['priority'])));
                $res = false;
                $arr_trans = array(
                    'ticket_id' => (int) $ticket_id,
                    'category_id' => (int) $post['category'],
                    'job_id' => (int) $post['job'],
                    'status_id' => 1,
                    'branch_id' => (int) $sess['office_id'],
                    'priority_id' => (int) $post['priority'],
                    'rule_id' => $rule_id['id'],
                    'is_active' => 1,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $res = $this->Tbl_helpdesk_ticket_transactions->insert($arr_trans);
                $arr_activity = array(
                    'ticket_id' => $ticket_id,
                    'response_time_start' => date_now(),
                    'response_time_stop' => '0000-00-00 00:00:00',
                    'transfer_time_start' => '0000-00-00 00:00:00',
                    'transfer_time_stop' => '0000-00-00 00:00:00',
                    'solving_time_start' => '0000-00-00 00:00:00',
                    'solving_time_stop' => '0000-00-00 00:00:00',
                    'is_open' => 0,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $res = $this->Tbl_helpdesk_activities->insert($arr_activity);
                if ($res == true) {
                    echo 'success';
                }
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
            $id = base64_decode($post['id']);
            $res = $this->Tbl_helpdesk_tickets->remove($id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function delete() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $id = base64_decode($post['is']);
            $res = $this->Tbl_helpdesk_tickets->delete($id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function tracking() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_transactions'));
            $ticket_id = base64_decode($post['ticket_id']);
            $arr_insert = array(
                'messages' => $post['message'],
                'ticket_id' => $ticket_id,
                'ticket_code' => $post['ticket_code'],
                'is_vendor' => 1,
                'is_active' => 1,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
            if ($res == true) {
                $arr_ticket = array(
                    'status_id' => 2
                );
                $this->Tbl_helpdesk_ticket_transactions->update_by($arr_ticket, $ticket_id, 'ticket_id');
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
            if (isset($post['id']) && !empty($post['id'])) {
                $ticket_id = base64_decode($post['id']);
            } else {
                $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => base64_decode($post['ticket_code']))));
                $ticket_id = ($ticket['id']);
            }
            $res = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
            if ($res == null) {
                echo 'true';
            } else {
                $max_ticket = 7;
                $sum_ticket = (fn_date_diff_ticket($res['open_time'], date_now(), 'all'));
                if (($res['is_open'] == 1) && ($sum_ticket['minute'] <= $max_ticket)) {
                    echo 'true';
                } else {
                    $res = $this->Tbl_helpdesk_activities->update(array('open_time' => '0000-00-00 00:00:00', 'is_open' => 0), $res['id']);
                    echo 'false';
                }
            }
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

    public function set_open() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_activities');
            $ticket_act = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => base64_decode($post['ticket_id']))));
            $res = $this->Tbl_helpdesk_activities->update(array('open_time' => date_now(), 'is_open' => 1), $ticket_act['id']);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function set_close() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post['ticket_id']) && !empty($post['ticket_id'])) {
            $this->load->model('Tbl_helpdesk_activities');
            $ticket_id = base64_decode($post['ticket_id']);
            $tick = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
            $res = $this->Tbl_helpdesk_activities->update(array('open_time' => '0000-00-00 00:00:00', 'is_open' => 0), $tick['id']);
            if (isset($res) && !empty($res)) {
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
                        'handle_by' => $handler['handler_email']
                    );
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
                        $branch = $this->Tbl_helpdesk_imigration_branchs->find('first', array('conditions' => array('a.id' => $result['branch_id'])));
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
                    $as = array('history_chat' => $new_chat);
                    $result = array_merge($result, $as);
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
                    // debug($this->db->last_query());
                    $new_history = array();
                    if (isset($history) && !empty($history)) {
                        foreach ($history AS $key => $val) {
                            $val['create_date'] = idn_date($val['create_date']);

                            $new_history[$key] = $val;
                        }
                    }
                    $u = array('history_ticket' => $new_history);

                    $result = array_merge($result, $u);
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
                exit();
            }
        } elseif ($key == 'response') {
            $post = $this->input->post(NULL, TRUE);
            if (isset($post) && !empty($post)) {
                $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_handlers', 'Tbl_users', 'Tbl_helpdesk_ticket_problem_impacts', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_chats'));
                $id = base64_decode($post['ticket_id']);
                $result = $this->Tbl_helpdesk_tickets->query("SELECT
                    a.*, 
                    b.ticket_id,b.category_id,b.job_id,b.problem_impact_id, 
                    c.name ticket_status
                    FROM tbl_helpdesk_tickets a
                    LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id
                    LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id
                    WHERE a.id = {$id}
                ")[0];
                // $result = array();

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
            }
            echo json_encode($result);
            exit();
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

    public function response_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            //set ticket status into progress
            $this->load->model(array('Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_activities'));
            $ticket = $this->Tbl_helpdesk_tickets->find('first', array('conditions' => array('code' => $post['ticket_code'])));

            $ticket_status = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket['id'], 'is_active' => 1)));
            //insert chat from user
            $arr_insert = array(
                'messages' => $post['message'],
                'ticket_id' => $ticket['id'],
                'ticket_code' => $ticket['code'],
                'is_vendor' => 1,
                'is_active' => 1,
                'reply_to' => $this->get_ticket_owner($ticket['id'], 'vndr'),
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
            if ($res == true) {
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
                        'ticket_code' => $post['ticket_code'],
                        'is_vendor' => 0,
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
                        'ticket_code' => $post['ticket_code'],
                        'is_vendor' => 0,
                        'is_active' => 1,
                        'reply_to' => 0,
                        'created_by' => 0,
                        'create_date' => date_now()
                    );
                    $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
                }
                $this->Tbl_helpdesk_ticket_transactions->update($arr_ticket, $trs['id']);
                $arr_activity = array(
                    'response_time_stop' => date_now(),
                    'solving_time_start' => date_now(),
                    'is_open' => 0,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $res = $this->Tbl_helpdesk_activities->update($arr_activity, $ticket_status['id']);
                if ($res == true) {
                    $arr_handler_ticket = array(
                        'ticket_id' => $ticket['id'],
                        'user_id' => (int) base64_decode($this->auth_config->user_id),
                        'group_id' => (int) ($this->auth_config->group_id),
                        'is_active' => 1,
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_handlers->insert($arr_handler_ticket);
                    echo 'success';
                }
            } else {
                echo 'failed';
            }
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

                echo 'success';
            } else {
                echo 'failed';
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
                            }else{
                                echo 'true';
                            }
                        }
                    }
                }
            }
        }
        echo 'true';
    }

}
