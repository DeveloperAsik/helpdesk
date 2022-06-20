<?php

class Ticket extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_tickets'));
    }

    public function index() {
        redirect(base_url('ticket/create'));
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
                        exit();
                    } else {
                        echo 'failed';
                        exit();
                    }
                } else {
                    echo 'failed';
                    exit();
                }
            }
        }
    }

    public function create() {
        $this->load->model(array('Tbl_helpdesk_ticket_categories', 'Tbl_helpdesk_branchs', 'Tbl_helpdesk_ticket_problem_impacts'));
        $data['title_for_layout'] = 'welcome';
        //load ajax var
        $office_code = isset($this->auth_config->office_code) ? $this->auth_config->office_code : '';
        $var = array(
            array(
                'keyword' => 'code',
                'value' => $this->get_ticket_last_code($office_code)
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
                $arr = '<option value="">' . $this->lang->line('global_select_one') . '</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
                echo $arr;
                exit();
            } else {
                echo null;
                exit();
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
            exit();
        } else {
            echo '';
            exit();
        }
    }

    public function view($keyword = '') {
        $get = $this->input->get();
        if (isset($get['redirect']) && !empty($get['redirect']) && $get['redirect'] == true) {
            $this->session->set_flashdata('message', $get['msg']);
        }
        $data['title_for_layout'] = 'welcome';
        $data['view-header-title'] = 'View Ticket List';
        //load ajax var
        $var = array(
            array(
                'keyword' => 'key',
                'value' => $keyword
            )
        );
        $this->load_ajax_var($var);
        $css_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.css'),
            static_url('templates/metronics/assets/global/css/timeline.css'),
            static_url('templates/metronics/assets/global/css/todo.css'),
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
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
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.min.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_list($key = null) {
        ini_set('memory_limit', '1024M');
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_reopen_logs', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_requests'));
            $user = (int) base64_decode($this->auth_config->user_id);
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $search = trim($post['search']['value']);
            $cond_count = array();
            $conditions_search = '';
            if (isset($key) && !empty($key)) {
                $cond_count['like'] = array('c.name' => $key);
                $conditions_search = " AND `c`.`name` LIKE '%{$key}%' ";
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
                `b`.`ticket_id`, `b`.`category_id`, `b`.`job_id`, `b`.`status_id`,`b`.`branch_id`,`b`.`priority_id`, `b`.`rule_id` , `b`.`problem_impact_id`,  
                `c`.`name` `ticket_status`, `d`.`response_time_start`, `d`.`response_time_stop`, `d`.`transfer_time_start`, `d`.`transfer_time_stop`, `d`.`solving_time_start`, `d`.`solving_time_stop`, `d`.`is_open`,
                `e`.`name_ina` `category_name`,
                `f`.`name` `job_category_name`, 
                `g`.`user_id` `response_by`,
                `h`.`name` `priority_name`,
                `i`.`name` `branch_name`
                FROM `tbl_helpdesk_tickets` `a`
                LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id` AND `b`.`is_active` = 1
                LEFT JOIN `tbl_helpdesk_ticket_status` `c` ON `c`.`id` = `b`.`status_id`
                LEFT JOIN `tbl_helpdesk_activities` `d` ON `d`.`ticket_id` = `a`.`id` AND `d`.`is_active` = 1
                LEFT JOIN `tbl_helpdesk_ticket_categories` `e` ON `e`.`id` = `b`.`category_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `f` ON `f`.`id` = `b`.`job_id`
                LEFT JOIN `tbl_helpdesk_ticket_handlers` `g` ON `g`.`ticket_id` = `a`.`id`
                LEFT JOIN `tbl_helpdesk_ticket_priorities` `h` ON `h`.`id` = `b`.`priority_id`
                LEFT JOIN `tbl_helpdesk_branchs` `i` ON `i`.`id` = `b`.`branch_id`
                WHERE `a`.`is_active` = 1 AND `a`.`issued_by` = $user $conditions_search
                $cond_search_opt
                ORDER BY `a`.`create_date` DESC
                LIMIT $start, $length
            ";
            $query_total = "
                SELECT `a`.`id`
                FROM `tbl_helpdesk_tickets` `a`
                LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id` AND `b`.`is_active` = 1
                LEFT JOIN `tbl_helpdesk_ticket_status` `c` ON `c`.`id` = `b`.`status_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `e` ON `e`.`id` = `b`.`category_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `f` ON `f`.`id` = `b`.`job_id`
                LEFT JOIN `tbl_helpdesk_ticket_priorities` `h` ON `h`.`id` = `b`.`priority_id`
                WHERE `a`.`is_active` = 1 AND `a`.`created_by` = $user $conditions_search
                $cond_search_opt 
            ";
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $kyname = '_total_row_cache_name_' . $key;
            $obj_cache = $this->config->$kyname;
            if (!$total_rows = $this->cache->get($obj_cache)) {
                $total_rows = count($this->Tbl_helpdesk_tickets->query($query_total));
                // Save into the cache for 10 minutes
                $this->cache->save($obj_cache, $total_rows, 600);
            }
            $res = $this->Tbl_helpdesk_tickets->query($query);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $solving_issue = $this->Tbl_helpdesk_ticket_requests->query("SELECT message FROM tbl_helpdesk_ticket_requests WHERE create_date IN (SELECT max(create_date) FROM tbl_helpdesk_ticket_requests WHERE ticket_id =  " . $d['id'].")");
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-group">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_active'] . '" data-id="' . $d['id'] . '" name="status" ' . $status . '/>
                        </div>
                    </div>';
                    $data['num'] = $i;
                    $data['code'] = $d['code']; //optional	
                    $data['content'] = substr($d['content'], 0, 100); //optional
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
                        if ($desc_ticket) {
                            $arr_ticket_transfer = 'transfer to <b>' . $desc_ticket['username'] . '<b/>';
                        }
                        $status = $this->get_btn_ticket_status($d['ticket_status'], $arr_ticket_transfer);
                    }
                    $data['status'] = $status;
                    $data['category_name'] = $d['category_name']; //optional
                    $data['job_category_name'] = $d['job_category_name']; //optional
                    $data['branch_name'] = $d['branch_name']; //optional
                    $data['active'] = $action_status; //optional	
                    $data['create'] = idn_date(strtotime($d['create_date'])); //optional
                    if ($d['ticket_status'] == 'close' || $d['ticket_status'] == 'progress') {
                        $data['close_message'] = isset($solving_issue[0]['message']) ? $solving_issue[0]['message'] : '#'; //optional 
                    } else {
                        $data['close_message'] = '-';
                    }
                    //$data['description'] = $d['description']; //optional
                    if ($d['ticket_status'] == 'open') {
                        $data['action'] = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail"  data-type="employee" title="Detail" data-id="' . $d['id'] . '"> <i class="fa fa-search-plus"></i> </a>					
                        ';
                    } elseif ($d['ticket_status'] == 'progress') {
                        $data['action'] = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail" title="Detail" data-id="' . $d['id'] . '"> <i class="fa fa-search-plus"></i> </a>					
                            <a class="btn red btn-outline sbold" href="' . base_url('ticket/tracking/' . base64_encode($d['code'])) . '" title="Telusur" data-id="' . $d['id'] . '"> <i class="fa fa-tripadvisor"></i> </a>
                        ';
                    } elseif ($d['ticket_status'] == 'close_request') {
                        $data['action'] = '
                           <a class="btn red btn-outline sbold" data-toggle="modal" href="' . base_url('ticket/tracking/' . base64_encode($d['code'])) . '" data-id="' . $d['id'] . '"> <i class="fa fa-tripadvisor"></i> </a>
                        ';
                    } elseif ($d['ticket_status'] == 'close') {
                        $data['action'] = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail"  data-type="employee" title="Detail" data-id="' . $d['id'] . '"> <i class="fa fa-search-plus"></i> </a>					
                            <a class="btn red btn-outline sbold" title="Re-open" data-toggle="modal" href="#modal_re_open" data-id="' . $d['id'] . '"> <i class="fa fa-folder-open-o"></i> </a>					
                        ';
                    } elseif ($d['ticket_status'] == 'transfer') {
                        $data['action'] = '
                            <a class="btn red btn-outline sbold" data-toggle="modal" href="#modal_detail"  data-type="employee" data-id="' . $d['id'] . '"> <i class="fa fa-search-plus"></i> </a>					
                        ';
                    }
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
            exit();
        } else {
            echo json_encode(array());
            exit();
        }
    }

    public function insert() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->library('oreno_ticket');
            $sess = $this->_session_auth($this->config->session_name);
            $this->load->model('Tbl_helpdesk_tickets');
            $check = $this->Tbl_helpdesk_tickets->find('first', array(
                'conditions' => array('code' => $post['code'], 'is_active' => 1)
                    )
            );
            if ($check == null) {
                $res = $this->oreno_ticket->insert($post, $sess);
                if ($res == true) {
                    echo 'success';
                    exit();
                } else {
                    echo 'failed';
                    exit();
                }
            } else {
                $post['code'] = $this->get_new_ticket_code($post['code']);
                $check = $this->Tbl_helpdesk_tickets->find('first', array(
                    'conditions' => array('code' => $post['code'], 'is_active' => 1)
                        )
                );
                if ($check == null) {
                    $res = $this->oreno_ticket->insert($post, $sess);
                    if ($res == true) {
                        echo 'success';
                        exit();
                    } else {
                        echo 'failed';
                        exit();
                    }
                }
            }
        }
    }

    public function tracking($code = null) {
        if ($code == null)
            redirect(base_url('ticket/view/open?redirect=true&msg=Please select only registered ticket code'));
        if (strlen($code) != 28)
            redirect(base_url('ticket/view/open?redirect=true&msg=Please select only registered ticket code'));
        $data['title_for_layout'] = '';
        $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_files'));
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
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.min.js')
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
            $res = $this->Tbl_helpdesk_ticket_chats->find('all', array('conditions' => array('ticket_id' => $ticket_id,'created_by !=' => 0), 'order' => array('key' => 'create_date', 'type' => 'DESC')));
            if (isset($res) && !empty($res)) {
                $arr_res = '';
                foreach ($res AS $key => $value) {
                    $user = $this->Tbl_users->find('first', array(
                        'fields' => array('a.*', 'b.img','c.group_id'),
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
                        }elseif ($value['created_by'] != 1 && $user['group_id'] == 1) {
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
                    $style = '#F3565D';
                    if ($value['reply_to'] == (int) base64_decode($this->auth_config->user_id)) {
                        $style = '#F3565D';
                    } elseif ($value['created_by'] == (int) base64_decode($this->auth_config->user_id)) {
                        $style = '#28acb8';
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
                                <span class="font-grey-cascade">' . ($value['messages']) . '</span>
                            </div>
                        </div>
                    </div>';
                }
                echo $arr_res;
                exit();
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
                'is_support' => 0,
                'is_active' => 1,
                'reply_to' => $this->get_ticket_owner($ticket_id,'timtik'),
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);
            if ($res == true) {
                echo 'success';
                exit();
            } else {
                echo 'failed';
                exit();
            }
        }
    }

    public function get_ticket_detail() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_requests', 'Tbl_helpdesk_branchs'));
            $id = base64_decode($post['id']);
            $res = $this->Tbl_helpdesk_tickets->find('first', array(
                'fields' => array('a.*', 'b.branch_id', 'b.priority_id', 'b.category_id', 'b.job_id', 'c.name ticket_status', 'd.name category_name', 'e.name job_category_name', 'b.problem_impact_id'),
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
                        'table' => 'tbl_helpdesk_ticket_categories d',
                        'conditions' => 'd.id = b.category_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_helpdesk_ticket_categories e',
                        'conditions' => 'e.id = b.job_id',
                        'type' => 'left'
                    )
                )
            ));
            if (isset($res) && !empty($res)) {
                $this->load->model(array('Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_branchs', 'Tbl_helpdesk_ticket_transfers', 'Tbl_helpdesk_ticket_chats','Tbl_users','Tbl_helpdesk_ticket_problem_impacts','Tbl_helpdesk_ticket_transactions'));
                $handle_by = $this->Tbl_helpdesk_ticket_handlers->find('first', array(
                    'fields' => array('a.*', 'b.email', 'b.username'),
                    'conditions' => array('ticket_id' => $id),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id = a.user_id',
                            'type' => 'left'
                        )
                    )
                ));
                $r = array(
                    'handle_by' => isset($handle_by) ? $handle_by['username'] . ' (' . $handle_by['email'] . ')' : null );
                $res = array_merge($res, $r);
                if ($res['ticket_status'] == 'open') {
                    $prev_problem = $this->Tbl_helpdesk_ticket_requests->find('first', array('conditions' => array()));
                }
                if ($res['create_date']) {
                    $res['create_date'] = idn_date(strtotime($res['create_date']));
                }
                $create_by = $this->Tbl_users->find('first', array('conditions' => array('id' => $res['created_by'])));
                $rs = array(
                    'create_by_name' => $create_by['username'] . ' (' . $create_by['email'] . ')'
                );
                $res = array_merge($res, $rs);
                $impact = $this->Tbl_helpdesk_ticket_problem_impacts->find('first', array(
                    'conditions' => array('a.is_active' => 1, 'a.id' => $res['problem_impact_id'])
                ));
                $s = array(
                    'problem_impact' => $impact['name_ina']
                );
                $res = array_merge($res, $s);
                $category = $this->Tbl_helpdesk_ticket_categories->find('first', array(
                    'conditions' => array('a.id' => $res['category_id'])
                ));
                $c = array(
                    'category_name' => $category['name_ina']
                );
                $res = array_merge($res, $c);
                $sub_category = $this->Tbl_helpdesk_ticket_categories->find('first', array(
                    'conditions' => array('a.id' => $res['job_id'])
                ));
                $sc = array(
                    'sub_category' => $sub_category['name']
                );
                $res = array_merge($res, $sc);
                $files = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('a.code' => $res['code'])));
                $t = array(
                    'files' => $files
                );
                $res = array_merge($res, $t);
                $branch = $this->Tbl_helpdesk_branchs->find('first', array('conditions' => array('a.id' => $res['branch_id'])));
                $b = array(
                    'branch' => $branch
                );
                $res = array_merge($res, $b);
                $ticket_transfer = $this->Tbl_helpdesk_ticket_transfers->find('first', array(
                    'fields' => array('a.*', 'b.username To_user', 'b.email To_email', 'c.username From_user', 'c.email From_email'),
                    'conditions' => array('a.ticket_id' => $id, 'a.is_active' => 1),
                    'joins' => array(
                        array(
                            'table' => 'tbl_users b',
                            'conditions' => 'b.id = a.user_to',
                            'type' => 'LEFT'
                        ),
                        array(
                            'table' => 'tbl_users c',
                            'conditions' => 'c.id = a.user_from',
                            'type' => 'LEFT'
                        )
                    )
                        )
                );
                $c = array(
                    'transfer' => $ticket_transfer
                );
                $res = array_merge($res, $c);
                $z2 = array('issued_by_name' => '-');
                if($res['issued_by'] !=0){
                    $issued_by = $this->Tbl_users->find('first', array('conditions' => array('id' => $res['issued_by'])));
                    
                    $z2 = array('issued_by_name' => $issued_by['username']);
                } 
                $res = array_merge($res, $z2);
                $chat = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('ticket_id' => $id,'a.created_by !=' => 0),
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
                    if(isset($chat) && !empty($chat)){
                        foreach($chat AS $key => $val)  {
                            $val['create_date'] = idn_date($val['create_date']);
                            $new_chat[$key] = $val; 
                        }
                    }
                    $as = array('history_chat' => $new_chat);
                    $res = array_merge($res, $as);
                    $history = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('a.ticket_id' => $id,'a.created_by' => 0),
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
                    if(isset($history) && !empty($history)){
                        foreach($history AS $key => $val)  {
                             $val['create_date'] = idn_date($val['create_date']);

                            $new_history[$key] = $val; 
                        }
                    }
                    $z = array('history_ticket' => $new_history);
                    $res = array_merge($res, $z);
                if ($res['ticket_status'] == 'close') {
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
                    $res = array_merge($res, $v);
                }
                echo json_encode($res);
                exit();
            } else {
                echo null;
                exit();
            }
        } else {
            echo null;
            exit();
        }
    }

    public function close_status() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_requests'));
            $ticket_id = base64_decode($post['ticket_id']);
            $res = $this->Tbl_helpdesk_ticket_transactions->query("UPDATE `tbl_helpdesk_ticket_transactions` SET `status_id` = '4' WHERE `tbl_helpdesk_ticket_transactions`.`ticket_id` = {$ticket_id};", 'update'); //($arr_transc, 'ticket_id', $post['ticket_id']);
            if ($res == true) {
                $msg = 'User kanim ' . $this->auth_config->email . ' close tiket pada ' . idn_date(date_now());
                $ticket_act = $this->Tbl_helpdesk_activities->find('last', array('conditions' => array('ticket_id' => $ticket_id)));
                $arr_act = array(
                    'solving_time_stop' => date_now(),
                    'close_message' => $msg
                );
                $this->Tbl_helpdesk_activities->update($arr_act, $ticket_act['id']);
                $old_cht = $this->Tbl_helpdesk_ticket_chats->find('last', array('conditions' => array('ticket_id' => $ticket_id)));
                $arr_in_cht = array(
                    'messages' => $msg,
                    'ticket_id' => $old_cht['ticket_id'],
                    'ticket_code' => $old_cht['ticket_code'],
                    'is_open' => $old_cht['is_open'],
                    'is_show' => $old_cht['is_show'],
                    'is_support' => $old_cht['is_support'],
                    'is_active' => $old_cht['is_active'],
                    'reply_to' => $old_cht['reply_to'],
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_in_cht);
                $arr_in_cht = array(
                    'messages' => 'telah di close oleh ' . $this->auth_config->username,
                    'ticket_id' => $old_cht['ticket_id'],
                    'ticket_code' => $old_cht['ticket_code'],
                    'is_open' => $old_cht['is_open'],
                    'is_show' => 0,
                    'is_support' => 0,
                    'is_active' => $old_cht['is_active'],
                    'reply_to' => 0,
                    'created_by' => 0,
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_in_cht);
                $arr = array(
                    'ticket_id' => $old_cht['ticket_id'],
                    'job_list' => '',
                    'message' => $msg,
                    'is_active' => $old_cht['is_active'],
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_requests->insert($arr);
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function reopen() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_activities', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_ticket_reopen_logs'));
            $ticket_id = (int) base64_decode($post['ticket_id']);
            $res = $this->Tbl_helpdesk_ticket_transactions->query("UPDATE `tbl_helpdesk_ticket_transactions` SET `status_id` = '2' WHERE `tbl_helpdesk_ticket_transactions`.`ticket_id` = {$ticket_id};", 'update'); //($arr_transc, 'ticket_id', $post['ticket_id']);
            if ($res == true) {
                //create new time for reopen ticket
                $handler = $this->Tbl_helpdesk_ticket_handlers->find('first', array('condition' => array('ticket_id' => $ticket_id, 'is_active' => 1)));
                $old_time = $this->Tbl_helpdesk_activities->find('first', array('conditions' => array('ticket_id' => $ticket_id)));
                $arr_time = array(
                    'ticket_id' => $ticket_id,
                    'response_time_start' => $old_time['response_time_start'],
                    'response_time_stop' => $old_time['response_time_stop'],
                    'transfer_time_start' => $old_time['transfer_time_start'],
                    'transfer_time_stop' => $old_time['transfer_time_stop'],
                    'solving_time_start' => date_now(),
                    'solving_time_stop' => '0000-00-00 00:00:00',
                    'open_time' => $old_time['open_time'],
                    'close_message' => $old_time['close_message'],
                    'is_open ' => $old_time['is_open'],
                    'is_active' => 1,
                    'created_by  ' => $old_time['created_by'],
                    'create_date' => $old_time['create_date']
                );
                $res2 = $this->Tbl_helpdesk_activities->insert($arr_time);
                if ($res2) {
                    $arr_act = array(
                        'is_active' => 0
                    );
                    $this->Tbl_helpdesk_activities->update($arr_act, $old_time['id']);
                    $arr_ins_reopen = array(
                        'message' => $post['message'],
                        'ticket_id' => $ticket_id,
                        'handle_by' => $handler['user_id'],
                        'is_active' => 1,
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_reopen_logs->insert($arr_ins_reopen);
                    $old_cht = $this->Tbl_helpdesk_ticket_chats->find('last', array('conditions' => array('ticket_id' => $ticket_id)));
                    $arr_in_cht = array(
                        'messages' => $post['message'],
                        'ticket_id' => $old_cht['ticket_id'],
                        'ticket_code' => $old_cht['ticket_code'],
                        'is_open' => $old_cht['is_open'],
                        'is_show' => $old_cht['is_show'],
                        'is_support' => $old_cht['is_support'],
                        'is_active' => $old_cht['is_active'],
                        'reply_to' => $this->get_ticket_owner($ticket_id),
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_chats->insert($arr_in_cht);
                    $arr_in_cht = array(
                        'messages' => 'telah di re-open oleh '. ($this->auth_config->username),
                        'ticket_id' => $old_cht['ticket_id'],
                        'ticket_code' => $old_cht['ticket_code'],
                        'is_open' => $old_cht['is_open'],
                        'is_show' => 0,
                        'is_support' => 0,
                        'is_active' => $old_cht['is_active'],
                        'reply_to' => 0,
                        'created_by' => 0,
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_ticket_chats->insert($arr_in_cht);
                    echo 'success';
                    exit();
                }
            } else {
                echo 'failed';
                exit();
            }
        } else {
            echo 'failed';
            exit();
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
                exit();
            } else {
                echo 'failed';
                exit();
            }
        }
    }

}
