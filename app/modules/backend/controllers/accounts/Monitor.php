<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Immigration
 *
 * @author SuperUser
 */
class Monitor extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_employee_monitors'));
    }

    public function index() {
        redirect(base_backend_url('accounts/monitor/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_monitor');
        $data['view-header-title'] = $this->lang->line('global_header_title_monitor');
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $this->load->model('Tbl_helpdesk_branchs');
        $data['branchs'] = $this->Tbl_helpdesk_branchs->find('list', array('order' => array('key' => 'name', 'type' => 'ASC')));
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
            $cond['table'] = $cond_count['table'] = 'tbl_helpdesk_employees';
            $cond['conditions'] = array('e.group_id' => 4);
            $cond['fields'] = array('a.*', 'c.code branch_code', 'c.name branch_name');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('a.name' => $search);
            }
            $cond['joins'] = $cond_count['joins'] = array(
                array(
                    'table' => 'tbl_helpdesk_employee_monitors b',
                    'conditions' => 'b.employee_id = a.id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_helpdesk_branchs c',
                    'conditions' => 'c.id = b.branch_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_users d',
                    'conditions' => 'd.id = b.user_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_user_groups e',
                    'conditions' => 'e.user_id = b.user_id',
                    'type' => 'left'
                )
            );
            $total_rows = $this->Tbl_helpdesk_employees->find('count', $cond_count);
            $res = $this->Tbl_helpdesk_employees->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-employee">
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
                    $data['nik'] = $d['nik'];
                    $data['name'] = $d['name']; //optional	
                    $data['email'] = $d['email']; //optional
                    $data['phone_number'] = $d['phone_number']; //optional
                    $data['branch_code'] = $d['branch_code']; //optional
                    $data['branch_name'] = $d['branch_name']; //optional
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
            $res = $this->Tbl_helpdesk_employees->find('first', array(
                'fields' => array('a.id AS employee_id','a.nik AS employee_nik','a.name AS employee_name','a.email AS employee_email','a.phone_number AS employee_phone_number', 'b.branch_id', 'b.user_id', 'c.*', 'd.name branch_name'),
                'conditions' => array('a.id' => base64_decode($post['id'])),
                'joins' => array(
                    array(
                        'table' => 'tbl_helpdesk_employee_monitors b',
                        'conditions' => 'b.employee_id = a.id',
                        'type' => 'LEFT'
                    ),
                    array(
                        'table' => 'tbl_users c',
                        'conditions' => 'c.id = b.user_id',
                        'type' => 'LEFT'
                    ),
                    array(
                        'table' => 'tbl_helpdesk_branchs d',
                        'conditions' => 'd.id = b.branch_id',
                        'type' => 'LEFT'
                    )
                )
                    )
            );
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
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_employee_monitors', 'Tbl_helpdesk_employees'));
            $arr_user = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'password' => $this->oreno_auth->hash_password($post['password']),
                'status' => 3,
                'is_active' => $status,
                'is_logged_in' => 0,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $user_id = $this->Tbl_users->insert_return_id($arr_user);
            if ($user_id) {
                $arr_user_group = array(
                    'user_id' => $user_id,
                    'group_id' => $post['group'],
                    'is_active' => $status,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_user_groups->insert($arr_user_group);
            }
            $arr_insert = array(
                'nik' => $post['nik'],
                'name' => $post['username'],
                'email' => $post['email'],
                'phone_number' => $post['phone_number'],
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $employee_id = $this->Tbl_helpdesk_employees->insert_return_id($arr_insert);
            if ($employee_id) {
                $arr_employee = array(
                    'employee_id' => $employee_id,
                    'user_id' => $user_id,
                    'branch_id' => $post['branch'],
                    'is_active' => $status,
                    'created_by' => (int) base64_decode($this->auth_config->user_id),
                    'create_date' => date_now()
                );
                $this->Tbl_helpdesk_employee_monitors->insert($arr_employee);
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
            if ($post['active'] == "true") {
                $status = 1;
            }
            $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_employee_monitors', 'Tbl_helpdesk_employees'));
            $user_id = $post['user_id'];
            $arr_user = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'password' => $this->oreno_auth->hash_password($post['password']),
                'status' => 3,
                'is_active' => $status
            );
            $this->Tbl_users->update($arr_user, $user_id);
            $employee_monitor = $this->Tbl_helpdesk_employee_monitors->find('first', array('conditions' => array('user_id' => $user_id)));
            $arr_update = array(
                'nik' => $post['nik'],
                'name' => $post['username'],
                'phone_number' => $post['phone_number'],
                'is_active' => $status
            );
            $this->Tbl_helpdesk_employees->update($arr_update, $employee_monitor['employee_id']);
            $arr_employee = array(
                'employee_id' => $employee_monitor['employee_id'],
                'user_id' => $user_id,
                'branch_id' => $post['branch'],
                'is_active' => $status
            );
            $res = $this->Tbl_helpdesk_employee_monitors->update($arr_employee, $employee_monitor['id']);
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
            $res = $this->Tbl_helpdesk_employee_monitors->update($arr, $id);
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
                    $arr_res = $this->Tbl_helpdesk_employee_monitors->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_helpdesk_employee_monitors->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

}
