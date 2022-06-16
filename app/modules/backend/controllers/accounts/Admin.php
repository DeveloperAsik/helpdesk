<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author SuperUser
 */
class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_users', 'Tbl_helpdesk_users'));
    }

    public function index() {
        redirect(base_backend_url('accounts/admin/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_admin');
        $data['view-header-title'] = $this->lang->line('global_header_title_admin');
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_list() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $search = trim($post['search']['value']);
            $cond_count = array();
            $cond['table'] = $cond_count['table'] = 'Tbl_users';
            if (isset($search) && !empty($search)) {
                $cond['like'] = $cond_count['like'] = array('a.name' => $search);
            }
            $cond['conditions'] = $cond_count['conditions'] = array('c.group_id' => 1);
            $cond['fields'] = array('a.*', 'b.*', 'd.name group_name');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $cond['joins'] = $cond_count['joins'] = array(
                array(
                    'table' => 'tbl_users b',
                    'conditions' => 'a.user_id = b.id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_user_groups c',
                    'conditions' => 'a.user_id = c.id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_groups d',
                    'conditions' => 'd.id = c.group_id',
                    'type' => 'left'
                )
            );
            $total_rows = $this->Tbl_helpdesk_users->find('count', $cond_count);
            $res = $this->Tbl_helpdesk_users->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-group">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_active'] . '" data-id="' . $d['id'] . '" name="status" ' . $status . '/>
                        </div>
                    </div>';
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
                    $data['num'] = $i;
                    $data['nik'] = $d['nik']; //optional
                    $data['username'] = $d['username']; //optional	
                    $data['first_name'] = $d['first_name']; //optional	
                    $data['last_name'] = $d['last_name']; //optional	
                    $data['email'] = $d['email']; //optional	
                    $data['group_name'] = $d['group_name']; //optional	
                    $data['active'] = $action_status; //optional	
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
            $res = $this->Tbl_users->find('first', array(
                'fields' => array('a.*', 'b.nik', 'd.name group_name'),
                'conditions' => array('a.id' => base64_decode($post['id'])),
                'joins' => array(
                    array(
                        'table' => 'tbl_helpdesk_users b',
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
    }

    public function insert() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_user_groups', 'Tbl_helpdesk_users'));
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password(base64_decode($post['password'])));
            }
            $arr_user = array(
                'nik' => $post['nik'],
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'status' => 3,
                'is_active' => $status,
                'is_logged_in' => 0,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $arr_user = array_merge($arr_user, $pass);
            $user_id = $this->Tbl_users->insert_return_id($arr_user);
            if ($user_id) {
                $arr_user_group = array(
                    'user_id' => $user_id,
                    'group_id' => 1,
                    'is_active' => $status,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $res = $this->Tbl_user_groups->insert($arr_user_group);
                if ($res) {
                    $arr_timtik = array(
                        'nik' => $post['nik'],
                        'name' => $post['username'],
                        'email' => $post['email'],
                        'user_id' => $user_id,
                        'is_active' => $status,
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_users->insert($arr_timtik);
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        } else {
            echo 'failed';
        }
    }

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_users');
            $user_id = base64_decode($post['id']);
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password(base64_decode($post['password'])));
            }
            $arr = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'is_active' => $status,
            );
            $arr = array_merge($arr, $pass);
            $res = $this->Tbl_users->update($arr, $user_id);
            if ($res == true) {
                $timtik = $this->Tbl_helpdesk_users->find('first', array('conditions' => array('user_id' => $user_id)));
                $arr_timtik = array(
                    'nik' => $post['nik'],
                    'name' => $post['username'],
                    'email' => $post['email'],
                    'user_id' => $user_id,
                    'is_active' => $status
                );
                $this->Tbl_helpdesk_users->update($arr_timtik, $timtik['id']);
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
            $res = $this->Tbl_users->update($arr, $id);
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
            $this->load->library('Oreno_log');
            $this->load->model(array('Tbl_user_groups', 'Tbl_helpdesk_users'));
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    //find at tbl_users
                    $user = $this->Tbl_users->find('first', array('conditions' => array('id' => $val)));
                    //find at Tbl_user_groups
                    $group_user = $this->Tbl_user_groups->find('first', array('conditions' => array('user_id' => $val)));
                    //find at tbl_helpdesk_users
                    $timtik_user = $this->Tbl_helpdesk_users->find('first', array('conditions' => array('user_id' => $val)));

                    //create log file at destination path for tbl_user
                    $this->oreno_log->init_($user, $this->setLogPath($val, $group_user['group_id'], 'tbl_user'));
                    $arr_res = $this->Tbl_users->delete($val);
                    if ($group_user != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($group_user, $this->setLogPath($val, $group_user['group_id'], 'tbl_user_groups'));
                        $this->Tbl_user_groups->delete($group_user['id']);
                    }
                    if ($timtik_user != null) {
                        //create log file at destination path for tbl_helpdesk_users
                        $this->oreno_log->init_($timtik_user, $this->setLogPath($val, $group_user['group_id'], 'tbl_helpdesk_users'));
                        $this->Tbl_helpdesk_users->delete($timtik_user['id']);
                    }
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                //find at tbl_users
                $user = $this->Tbl_users->find('first', array('conditions' => array('id' => $id)));
                //find at Tbl_user_groups
                $group_user = $this->Tbl_user_groups->find('first', array('conditions' => array('user_id' => $id)));
                //find at tbl_helpdesk_users
                $timtik_user = $this->Tbl_helpdesk_users->find('first', array('conditions' => array('user_id' => $id)));

                //create log file at destination path for tbl_user
                $this->oreno_log->init_($user, $this->setLogPath($id, $group_user['group_id'], 'tbl_user'));
                $res = $this->Tbl_users->delete($id);
                if ($group_user != null) {
                    //create log file at destination path for tbl_user_groups
                    $this->oreno_log->init_($group_user, $this->setLogPath($id, $group_user['group_id'], 'tbl_user_groups'));
                    $this->Tbl_user_groups->delete($group_user['id']);
                }
                if ($timtik_user != null) {
                    //create log file at destination path for tbl_helpdesk_users
                    $this->oreno_log->init_($timtik_user, $this->setLogPath($id, $group_user['group_id'], 'tbl_helpdesk_users'));
                    $this->Tbl_helpdesk_users->delete($timtik_user['id']);
                }
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

}
