<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group_permission
 *
 * @author SuperUser
 */
class Group_permission extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_group_permissions', 'Tbl_permissions', 'Tbl_method_masters', 'Tbl_modules'));
    }

    public function index() {
        redirect(base_backend_url('settings/group_permission/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_group_permission');
        $data['view-header-title'] = $this->lang->line('global_header_title_group_permission');
        $css_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css'),
            static_url('templates/metronics/assets/global/plugins/jquery-multi-select/css/multi-select.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js')
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
            $cond['table'] = $cond_count['table'] = 'Tbl_group_permissions';
            $cond['fields'] = array('a.*', 'b.name group_name', 'c.class', 'c.action');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $cond['joins'] = $cond_count['joins'] = array(
                array(
                    'table' => 'tbl_groups b',
                    'conditions' => 'b.id = a.group_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_permissions c',
                    'conditions' => 'c.id = a.permission_id',
                    'type' => 'left'
                )
            );
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('b.name' => $search, 'c.class' => $search, 'c.action' => $search, 'a.is_active' => $search);
            }
            $total_rows = $this->Tbl_group_permissions->find('count', $cond_count);
            $res = $this->Tbl_group_permissions->find('all', $cond);
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
                    $allowed = '';
                    if ($d['is_allowed'] == 1) {
                        $allowed = 'checked';
                    }
                    $allowed_status = '<div class="form-group">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_allowed'] . '" data-id="' . $d['id'] . '" name="allowed" ' . $allowed . '/>
                        </div>
                    </div>';
                    $public = '';
                    if ($d['is_public'] == 1) {
                        $public = 'checked';
                    }
                    $public_status = '<div class="form-group">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_public'] . '" data-id="' . $d['id'] . '" name="public" ' . $public . '/>
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
                    $data['group_name'] = $d['group_name']; //optional	
                    $data['class'] = $d['class']; //optional	
                    $data['action'] = $d['action']; //optional	
                    $data['allowed'] = $allowed_status; //optional	
                    $data['public'] = $public_status; //optional	
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
            $res = $this->Tbl_group_permissions->find('first', array(
                'fields' => array('a.*', 'b.name group_name', 'c.module', 'c.class', 'c.action', 'c.description'),
                'conditions' => array('a.id' => base64_decode($post['id'])),
                'joins' => array(
                    array(
                        'table' => 'tbl_groups b',
                        'conditions' => 'b.id = a.group_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_permissions c',
                        'conditions' => 'c.id = a.permission_id',
                        'type' => 'left'
                    )
                )
            ));
            if (isset($res) && !empty($res)) {
                $module_id = array('module_id' => 0);
                if ($res['module']) {
                    $module_id = array('module_id' => $this->Tbl_modules->get_id($res['module']));
                }
                $result = array_merge($module_id, $res);
                echo json_encode($result);
            } else {
                echo null;
            }
        }
    }

    public function insert() {
        $result = false;
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $status = 0;
            if ($post['is_active'] == 'true') {
                $status = 1;
            }
            $public = 0;
            if ($post['is_public'] == 'true') {
                $public = 1;
            }
            $allowed = 0;
            if ($post['is_allowed'] == 'true') {
                $allowed = 1;
            }
            //check permision is exist or no
            $module = $this->Tbl_modules->get_name($post['module_']);
            if (is_array($post['method_'])) {
                foreach ($post['method_'] AS $key => $val) {
                    $permission_ = $this->Tbl_permissions->find('first', array('class' => $post['class_'], 'action' => $val));
                    if ($permission_ != null || $permission_ != '') {
                        $action = $this->Tbl_method_masters->get_name($val);
                        $arr_permission = array(
                            "module" => $module,
                            "class" => $post['class_'],
                            "action" => $action,
                            "description" => $post["description"],
                            "is_active" => $status,
                            "created_by" => (int) base64_decode($this->auth_config->user_id),
                            "create_date" => date_now()
                        );
                        $permission_id = $this->Tbl_permissions->insert_return_id($arr_permission);
                        if ($permission_id) {
                            $arr_insert = array(
                                'group_id' => $post['group_'],
                                'permission_id' => $permission_id,
                                'is_allowed' => $allowed,
                                'is_public' => $public,
                                'is_active' => $status,
                                'created_by' => (int) base64_decode($this->auth_config->user_id),
                                'create_date' => date_now()
                            );
                            $result = $this->Tbl_group_permissions->insert($arr_insert);
                        }
                    }
                }
            } else {
                $arr_permission = array(
                    "module" => $module,
                    "class" => $post['class_'],
                    "action" => $post['method_'],
                    "description" => $post["description"],
                    "is_active" => $status,
                    "created_by" => (int) base64_decode($this->auth_config->user_id),
                    "create_date" => date_now()
                );
                $permission_id = $this->Tbl_permissions->insert_return_id($arr_permission);
                if ($permission_id) {
                    $arr_insert = array(
                        'group_id' => $post['group_'],
                        'permission_id' => $permission_id,
                        'is_allowed' => $allowed,
                        'is_public' => $public,
                        'is_active' => $status,
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $result = $this->Tbl_group_permissions->insert($arr_insert);
                }
            }
            if ($result == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
    }

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $status = 0;
            if ($post['is_active'] == "true") {
                $status = 1;
            }
            $allowed = 0;
            if ($post['is_allowed'] == 'true') {
                $allowed = 1;
            }
            $public = 0;
            if ($post['is_public'] == 'true') {
                $public = 1;
            }
            $arr_group_permission = array(
                'group_id' => $post['group_'],
                'is_allowed' => $allowed,
                'is_public' => $public,
                'is_active' => $status
            );
            $res = $this->Tbl_group_permissions->update($arr_group_permission, base64_decode($post['id']));
            if ($res == true) {
                $arr_permission = array(
                    'module' => $this->Tbl_modules->get_name($post['module_']),
                    'class' => $post['class_'],
                    'action' => $post['method_'],
                    'description' => $post['description']
                );
                $this->Tbl_permissions->update($arr_permission, base64_decode($post['permission_id']));
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
            $res = $this->Tbl_group_permissions->update($arr, $id);
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
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_group_permissions->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_group_permissions->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
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
            echo $arr;
        } else {
            echo null;
        }
    }

    public function get_group() {
        $this->load->model(array('Tbl_groups'));
        $res = $this->Tbl_groups->find('list', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'name', 'type' => 'ASC')));
        if (isset($res) && !empty($res)) {
            $arr = '';
            foreach ($res AS $k => $v) {
                $arr .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
            }
            echo $arr;
        } else {
            echo null;
        }
    }

    public function get_method($val = null) {
        $this->load->model(array('Tbl_method_masters'));
        $res = $this->Tbl_method_masters->find('all', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'is_mandatory', 'type' => 'DESC')));
        if (isset($res) && !empty($res)) {
            $arr = '';
            foreach ($res AS $k => $v) {
                $mandatory = ' style="color:#850000" title="Optional controller method"';
                if ($v['is_mandatory'] == 1) {
                    $mandatory = ' style="color:green" title="Basic controller method"';
                }
                $arr .= '<option' . $mandatory . ' value="' . $v['id'] . '">' . $v['name'] . '</option>';
            }
            echo $arr;
        } else {
            echo null;
        }
    }

}
