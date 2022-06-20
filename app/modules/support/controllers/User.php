<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function notif_new_ticket() {
        $new_ticket = $this->get_new_tickets();
        if ($new_ticket) {
            $i = 1;
            $var_ = array(
                array(
                    'keyword' => 'new_ticket_status',
                    'value' => 1
                ),
                array(
                    'keyword' => 'new_ticket_total',
                    'value' => count($new_ticket)
                )
            );
            $this->load_ajax_var($var_);
            foreach ($new_ticket AS $key => $val) {
                $var = array(
                    array(
                        'keyword' => 'new_ticket_' . $i,
                        'value' => 'New Ticket has been Created with ID #' . $val['code']
                    )
                );
                $this->load_ajax_var($var);
                $i++;
            }
        }
    }

    public function index() {
        redirect(base_url('login'));
    }

    public function login($template_id = '') {
        $data = $this->setup_layout();
        $data['title_for_layout'] = 'welcome';
        //load js
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/additional-methods.min.js'),
            static_url('templates/metronics/assets/global/plugins/select2/js/select2.full.min.js'),
            static_url('templates/metronics/assets/global/plugins/backstretch/jquery.backstretch.min.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic_login.phtml', $data);
    }

    public function auth() {
        $this->load->library('oreno_auth');
        $post = $this->input->post(NULL, TRUE);
        if (isset($post['login']) && !empty($post['login'])) {
            $auth = $this->oreno_auth->auth($post['login']);
            $result = json_decode($auth);
            echo return_call_back('message', array('login' => $result->result->status), 'json');
        } else {
            echo 'failed';
        }
        exit();
    }

    public function dashboard() {
        $this->load->model('Tbl_helpdesk_ticket_issue_suggestions');
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $css_files = array(
            static_url('templates/metronics/assets/global/css/timeline.css')
        );
        $this->load_css($css_files);
        $data['title_for_layout'] = 'welcome to dashbohard';
        $this->notif_new_ticket();
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function logout() {
        $this->oreno_auth->destroy_session($this->_session_auth());
        $this->session->set_flashdata('success', 'Successfully logout from system!');
        redirect(base_url('support/login'));
    }

    public function get_data() {
        $this->load->model('Tbl_users');
        $res = $this->Tbl_users->find('first', array(
            'fields' => array('a.id', 'a.username', 'a.first_name', 'a.last_name', 'a.email', 'a.is_active act_status', 'b.*', 'd.name group_name'),
            'conditions' => array('a.id' => (int) base64_decode($this->auth_config->user_id)),
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
                ),
                array(
                    'table' => 'tbl_groups d',
                    'conditions' => 'd.id = c.group_id',
                    'type' => 'left'
                )
            )
        ));
        if (isset($res) && !empty($res)) {
            echo json_encode($res);
        } else {
            echo null;
        }
    }

    public function my_profile() {
        $data['title_for_layout'] = 'welcome';
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function lock_screen() {
        $this->oreno_auth->lock_screen();
        $data['title_for_layout'] = 'welcome';
        //load js
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic_lock_screen.phtml', $data);
    }

    public function un_lock_screen() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $res = $this->oreno_auth->unlock_screen($post);
            if ($res) {
                echo return_call_back('message', array('verify' => true), 'json');
            } else {
                echo return_call_back('message', array('verify' => false), 'json');
            }
        } else {
            echo return_call_back('message', array('verify' => false), 'json');
        }
        exit();
    }

    public function get_ticket_detail($id = null) {
        $this->load->model('Tbl_helpdesk_tickets');
        $res = $this->Tbl_helpdesk_tickets->find('first', array(
            'fields' => array('a.*', 'c.name ticket_status', 'e.name category_name', 'f.name job_category_name'),
            'conditions' => array('a.id' => base64_decode($id)),
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
            $activity = $this->get_ticket_activity(base64_decode($id));
            if ($activity) {
                $res['is_open'] = $activity['is_open'];
            }
            echo json_encode($res);
        } else {
            echo null;
        }
    }

    public function get_issue_suggest() {
        $this->load->model('Tbl_helpdesk_ticket_issue_suggestions');
        $res = $this->Tbl_helpdesk_ticket_issue_suggestions->find('all', array(
            'conditions' => array('a.is_active' => 1)
        ));
        if (isset($res) && !empty($res)) {
            $ar = '<option>-- select one --</option>';
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

    public function get_history() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->library('pagination');
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $total_rows = count($this->get_all_history());
            $config = array(
                'base_url' => base_backend_url('prefferences/user/get_history/'),
                'total_rows' => $total_rows,
                'per_page' => $length,
            );
            $this->pagination->initialize($config);
            $res = $this->get_all_history();
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $activities = 'User access Module : ' . $d->module . ' and Class : ' . $d->class;
                    $data['num'] = $i;
                    $data['activities'] = $activities; //optional	
                    $data['date'] = fn_date_diff($d->create_date, date_now()) . ' a go'; //optional	
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
        }
    }

    public function get_user($id = 1) {
        if ($id == 1) {
            $this->load->model('Tbl_helpdesk_office_users');
            $res = $this->Tbl_helpdesk_users->find('all', array(
                'fields' => array('a.*'),
                'conditions' => array('a.is_active' => 1)
                    )
            );
        } elseif ($id == 2) {
            $this->load->model('Tbl_helpdesk_support_users');
            $res = $this->Tbl_helpdesk_support_users->find('all', array(
                'fields' => array('a.id', 'a.nik', 'a.user_id', 'b.email'),
                'conditions' => array('a.is_active' => 1, 'support_id !=' => $this->auth_config->office_id),
                'joins' => array(
                    array(
                        'table' => 'tbl_users b',
                        'conditions' => 'b.id = a.user_id',
                        'type' => 'left'
                    )
                )
                    )
            );
        }
        if (isset($res) && !empty($res)) {
            $arr = '';
            foreach ($res AS $k => $v) {
                if ($v['user_id'] != (int) base64_decode($this->auth_config->user_id)) {
                    $arr .= '<option value="' . $v['user_id'] . '">' . $v['nik'] . '-' . $v['email'] . '</option>';
                }
            }
            echo $arr;
        } else {
            echo null;
        }
    }

    public function transfer_ticket() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_transfers', 'Tbl_user_groups', 'Tbl_helpdesk_ticket_handlers', 'Tbl_helpdesk_support_users', 'Tbl_helpdesk_ticket_transactions', 'Tbl_helpdesk_ticket_chats', 'Tbl_helpdesk_activities'));
            $user_to = 0;
            // if ($post['group'] == 2) {
            //     $user_ = $this->Tbl_helpdesk_support_users->find('first', array('conditions' => array('id' => $post['support'])));
            //     $user_to = $user_['user_id'];
            // }
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
            $res = $this->Tbl_helpdesk_ticket_transfers->insert($arr_data);
            if ($res) {
                /*
                 * Genereate new ticket
                 */
                $get_office_code = array(
                    'office_id' => $this->get_office_code_from_ticket($post['ticket_code'], 'id'),
                    'user_id' => base64_encode($parent_ticket['created_by'])
                );
                $new_ticket_code = $this->get_ticket_last_code($this->get_office_code_from_ticket($post['ticket_code']), $parent_ticket['created_by']);
                $arr = array(
                    "parent_ticket_id" => $post['ticket_id'],
                    "code" => $new_ticket_code,
                    "category" => $post['category'],
                    "job" => $post['job'],
                    "problem_impact" => $parent_ticket['problem_impact_id'],
                    "issue" => $parent_ticket['content'],
                    "issued_by" => (int) base64_decode($this->auth_config->user_id),
                );
                $this->load->library('oreno_ticket');
                $this->oreno_ticket->insert($arr, $get_office_code);
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
                    // 'response_time_start' => '',
                    // 'response_time_stop' =>'',
                    // 'solving_time_start' =>'',
                    'solving_time_stop' => date_now(),
                    'is_active' => 1
                );
                $this->Tbl_helpdesk_activities->update($arr_activity, $ticket_activity['id']);
                //insert chat info from system
                $parent_category_name = $this->Tbl_helpdesk_ticket_categories->get_name($parent_ticket['category_id']);
                $parent_job_name = $this->Tbl_helpdesk_ticket_categories->get_name($parent_ticket['job_id']);
                $child_category_name = $this->Tbl_helpdesk_ticket_categories->get_name($post['category']);
                $child_job_name = $this->Tbl_helpdesk_ticket_categories->get_name($post['job']);
                $messages = '
                    Tiket kode       : ' . $post['ticket_code'] . '  <br/>
                    Status           : Close <br/>
                    Perespon tiket   : ' . $this->auth_config->username . '<br/>
                    Kategori         : ' . $parent_category_name . '<br/>
                    Jenis pekerjaan  : ' . $parent_job_name . '<br/>
                    <br/>
                    Tiket ini telah di buat ulang menjadi :<br/>
                    Tiket kode       : ' . $new_ticket_code . '<br/>
                    Status           : Open <br/>
                    Kategori         : ' . $child_category_name . '<br/>
                    Jenis pekerjaan  : ' . $child_job_name . '<br/>
                ';
                $arr_insert = array(
                    'messages' => $messages,
                    'ticket_id' => $post['ticket_id'],
                    'ticket_code' => $post['ticket_code'],
                    'is_support' => 0,
                    'is_active' => 1,
                    'reply_to' => 0,
                    'created_by' => 0,
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_insert);

                $arr_insert_ = array(
                    'messages' => $post['note'],
                    'ticket_id' => $post['ticket_id'],
                    'ticket_code' => $post['ticket_code'],
                    'is_support' => 1,
                    'is_active' => 1,
                    'reply_to' => $this->get_ticket_owner($post['ticket_id'], 'vndr'),
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_ticket_chats->insert($arr_insert_);


                //insert file attachment
                $file_attahcment_old = $this->Tbl_helpdesk_ticket_files->find('all', array('conditions' => array('code' => $post['ticket_code'])));
                
                foreach ($file_attahcment_old AS $k => $v) {
                    $typ = array(
                        "code" => $new_ticket_code,
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

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_users', 'Tbl_user_profiles', 'Tbl_helpdesk_support_users'));
            $user_id = base64_decode($this->auth_config->user_id);
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password($post['password']));
            }
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'is_active' => $status,
            );
            $arr_res = array_merge($arr, $pass);
            $res = $this->Tbl_users->update($arr_res, $user_id);
            if ($res) {
                if (isset($post['files']['data']) && !empty($post['files']['data'])) {
                    $img_base64 = base64_decode($post['files']['data']);
                    $upload_img = $this->base64ToImage($post['id'], $img_base64);
                    $user_profile = $this->Tbl_user_profiles->find('first', array('conditions' => array('user_id' => $user_id)));
                    $arr_insert = array(
                        'img' => $upload_img
                    );
                    if ($user_profile == null) {
                        $rr = array(
                            'user_id' => $user_id,
                            'is_active' => 1,
                            'created_by' => (int) base64_decode($this->auth_config->user_id),
                            'create_date' => date_now()
                        );
                        $arr = array_merge($rr, $arr_insert);
                        $this->Tbl_user_profiles->insert($arr);
                    } else {
                        if (file_exists($this->config->item('dir.user_profile_img', 'path') . $user_profile['img'])) {
                            unlink($this->config->item('dir.user_profile_img', 'path') . $user_profile['img']);
                        }
                        $this->Tbl_user_profiles->update($arr_insert, $user_profile['id']);
                    }
                }
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

}
