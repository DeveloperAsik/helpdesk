<?php

require_once DOCUMENT_ROOT . '/var/static/lib/packages/phpspreadsheet/vendor/autoload.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Description of Vendor
 *
 * @author SuperUser
 */
class Vendor extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_vendors'));
    }

    public function index() {
        redirect(base_backend_url('accounts/vendor/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_vendor');
        $data['view-header-title'] = $this->lang->line('global_header_title_vendor');
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $data['category'] = $this->Tbl_helpdesk_ticket_categories->find('all', array('conditions' => array('is_active' => 1, 'level' => 1)));
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function download_sample($filename, $type) {
        $this->load->library('oreno_generate_file');
        $this->oreno_generate_file->init($filename, 'vendor', $type);
    }

    public function import_file() {
        if (isset($_FILES['import_file_vendor']) && !empty($_FILES['import_file_vendor'])) {
            $path = $_FILES['import_file_vendor']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }
            $data = array();
            foreach ($rows AS $key => $value) {
                if ($key > 5) {
                    $data[] = $value;
                }
            }
            if ($data) {
                $arr = array();
                foreach ($data AS $k => $val) {
                    $arr[] = array(
                        'nik' => $val[2],
                        'username' => $val[3],
                        'first_name' => $val[4],
                        'last_name' => $val[5],
                        'email' => $val[6],
                        'password' => $val[7],
                        'phone_number' => $val[8],
                        'office_id' => $val[9],
                        'group_id' => $val[10],
                        'is_active' => ($val[11] == 'AKTIF') ? 1 : 0
                    );
                }
                $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_vendors', 'Tbl_helpdesk_vendor_users', 'Tbl_helpdesk_vendors'));
                if (isset($arr) && !empty($arr)) {
                    foreach ($arr AS $k => $val) {
                        $office = $this->Tbl_helpdesk_vendors->find('first', array('conditions' => array('code' => $val['office_id'])));
                        $pass = array();
                        if (isset($val['password']) & !empty($val['password'])) {
                            $pass = $this->oreno_auth->hash_password(base64_decode($val['password']));
                        }
                        $arr_user = array(
                            'nik' => $val['nik'],
                            'username' => $val['username'],
                            'first_name' => $val['first_name'],
                            'last_name' => $val['last_name'],
                            'email' => $val['email'],
                            'status' => 3,
                            'is_active' => $val['is_active'],
                            'is_logged_in' => 0,
                            'created_by' => (int) base64_decode($this->auth_config->user_id),
                            'create_date' => date_now()
                        );
                        $arr_user = array_merge($arr_user, array('password' => $pass));
                        $user_id = $this->Tbl_users->insert_return_id($arr_user);
                        if ($user_id) {
                            $arr_user_group = array(
                                'user_id' => $user_id,
                                'group_id' => $val['group_id'],
                                'is_active' => $val['is_active'],
                                'created_by' => (int) base64_decode($this->auth_config->user_id),
                                'create_date' => date_now()
                            );
                            $this->Tbl_user_groups->insert($arr_user_group);
                        }
                        $arr_insert = array(
                            'nik' => $val['nik'],
                            'name' => $val['username'],
                            'phone_number' => $val['phone_number'],
                            'vendor_id' => $office['id'],
                            'user_id' => $user_id,
                            'contract_id' => 1,
                            'category_id' => 1,
                            'is_active' => $val['is_active'],
                            'created_by' => (int) base64_decode($this->auth_config->user_id),
                            'create_date' => date_now()
                        );
                        $this->Tbl_helpdesk_vendor_users->insert($arr_insert);
                    }
                    echo 'success';
                }
            }
        }
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
            $cond['table'] = $cond_count['table'] = 'Tbl_helpdesk_vendors';
            $cond['fields'] = array('a.*');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('a.module' => $search, 'a.class' => $search, 'a.action' => $search);
            }
            $total_rows = $this->Tbl_helpdesk_vendors->find('count', $cond_count);
            $res = $this->Tbl_helpdesk_vendors->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-vendor">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_active'] . '" data-id="' . $d['id'] . '" name="status_vndr" ' . $status . '/>
                        </div>
                    </div>';
                    $data['rowcheck'] = '
                    <div class="form-group form-md-checkboxes">
                        <div class="md-checkbox-list">
                            <div class="md-checkbox">
                                <input type="checkbox" id="select_tr_vndr_' . $d['id'] . '" class="md-check select_tr_vndr_" name="select_tr_vndr_[' . $d['id'] . ']" data-id="' . $d['id'] . '" />
                                <label for="select_tr_vndr_' . $d['id'] . '">
                                    <span></span>
                                    <span class="check" style="left:20px;"></span>
                                    <span class="box" style="left:14px;"></span>
                                </label>
                            </div>
                        </div>
                    </div>';
                    $data['num'] = $i;
                    $data['name'] = $d['name']; //optional
                    $data['phone_number'] = $d['phone_number']; //optional
                    $data['fax'] = $d['fax']; //optional	
                    $data['email'] = $d['email']; //optional
                    $data['active'] = $action_status; //optional	
                    $data['description'] = $d['description']; //optional
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

    public function get_vendor_user_list() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_vendor_users');
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $search = trim($post['search']['value']);
            $cond_count = array();
            $cond['table'] = $cond_count['table'] = 'Tbl_helpdesk_vendors';
            $cond['fields'] = array('a.*', 'b.code vendor_code', 'b.name vendor_name', 'c.username', 'c.first_name', 'c.last_name', 'c.email', 'e.name group_name');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $cond['joins'] = $cond_count['joins'] = array(
                array(
                    'table' => 'tbl_helpdesk_vendors b',
                    'conditions' => 'b.id = a.vendor_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_users c',
                    'conditions' => 'c.id = a.user_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_user_groups d',
                    'conditions' => 'd.user_id = a.user_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_groups e',
                    'conditions' => 'e.id = d.group_id',
                    'type' => 'left'
                )
            );
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('b.code' => $search, 'b.name' => $search, 'c.username' => $search, 'c.first_name' => $search, 'c.last_name' => $search, 'c.email' => $search);
            }
            $total_rows = $this->Tbl_helpdesk_vendor_users->find('count', $cond_count);
            $res = $this->Tbl_helpdesk_vendor_users->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-vendor">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_active'] . '" data-id="' . $d['id'] . '" name="status" ' . $status . '/>
                        </div>
                    </div>';
                    $data['rowcheck'] = '
                    <div class="form-group form-md-checkboxes">
                        <div class="md-checkbox-list">
                            <div class="md-checkbox">
                                <input type="checkbox" id="select_tr_usr_' . $d['id'] . '" class="md-check select_tr_usr_" name="select_tr_usr_[' . $d['id'] . ']" data-id="' . $d['id'] . '" />
                                <label for="select_tr_usr_' . $d['id'] . '">
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
                    $data['vendor_code'] = $d['vendor_code']; //optional
                    $data['vendor_name'] = $d['vendor_name']; //optional
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
            $this->load->model('Tbl_helpdesk_vendors');
            $res = $this->Tbl_helpdesk_vendors->find('first', array('conditions' => array('a.id' => base64_decode($post['vndr_id']))));
            if (isset($res) && !empty($res)) {
                echo json_encode($res);
            } else {
                echo null;
            }
        }
    }

    public function get_data_vendor_user() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_vendor_users');
            $res = $this->Tbl_helpdesk_vendor_users->find('first', array(
                'fields' => array('a.*', 'b.code vendor_code', 'b.name vendor_name', 'c.id user_id', 'c.username', 'c.first_name', 'c.last_name', 'c.email', 'e.name group_name'),
                'conditions' => array('a.id' => base64_decode($post['vndr_user_id'])),
                'joins' => array(
                    array(
                        'table' => 'tbl_helpdesk_vendors b',
                        'conditions' => 'b.id = a.vendor_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_users c',
                        'conditions' => 'c.id = a.user_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_user_groups d',
                        'conditions' => 'd.user_id = a.user_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_groups e',
                        'conditions' => 'e.id = d.group_id',
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
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $arr_insert = array(
                'class' => $post['class'],
                'action' => $post['action'],
                'description' => $post['description'],
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $result = $this->Tbl_helpdesk_vendors->insert($arr_insert);
            if ($result == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed3';
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
                'class' => $post['class'],
                'action' => $post['action'],
                'description' => $post['description'],
                'is_active' => $status,
            );
            $res = $this->Tbl_helpdesk_vendors->update($arr, base64_decode($post['id']));
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
    }

    public function update_status($id_ = null) {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $id = base64_decode($id_);
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'is_active' => $status
            );
            $res = $this->Tbl_helpdesk_vendor_users->update($arr, $id);
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
                    $arr_res = $this->Tbl_helpdesk_vendors->delete($val);
                    $this->tbl_users->delete();
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_helpdesk_vendors->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function delete_user() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_vendor_users');
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_helpdesk_vendor_users->delete($val);
                    $this->tbl_users->delete();
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_helpdesk_vendor_users->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function insert_user() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $category_id = 0;
            $contract_id = 1;
            $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_vendors', 'Tbl_helpdesk_vendor_users'));
            $pass = array();
            if (isset($post['password']) & !empty($post['password'])) {
                $pass = $this->oreno_auth->hash_password(base64_decode($post['password']));
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
            $arr_user = array_merge($arr_user, array('password' => $pass));
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
                'phone_number' => $post['phone'],
                'vendor_id' => $post['vendor'],
                'user_id' => $user_id,
                'contract_id' => $contract_id,
                'category_id' => $category_id,
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_vendor_users->insert($arr_insert);
            if ($res) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
    }

    public function update_user() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password(base64_decode($post['password'])));
            }
            $this->load->model(array('Tbl_users', 'Tbl_helpdesk_vendor_users'));
            $arr_user = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'is_active' => $status,
            );
            $arr_user = array_merge($arr_user, $pass);
            $res = $this->Tbl_users->update($arr_user, base64_decode($post['user_id']));
            if ($res) {
                $arr_insert = array(
                    'nik' => $post['nik'],
                    'name' => $post['username'],
                    'phone_number' => $post['phone']
                );
                $this->Tbl_helpdesk_vendor_users->update_by($arr_insert, base64_decode($post['id']), 'user_id');
                echo 'success';
            }
        } else {
            echo 'failed';
        }
    }

    public function get_vendors() {
        $res = $this->Tbl_helpdesk_vendors->find('all', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'name', 'type' => 'ASC')));
        if (isset($res) && !empty($res)) {
            $arr = '<option>-- select one --</option>';
            foreach ($res AS $k => $v) {
                $arr .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
            }
            echo $arr;
        } else {
            echo null;
        }
    }

    public function get_category() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_categories'));
            $id = base64_decode($post['id']);
            $result = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                'conditions' => array('is_active' => 1, 'parent_id' => $id)
                    )
            );
            if (isset($result) && !empty($result)) {
                $arr = '<option>' . $this->lang->line('global_select_one') . '</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
                echo $arr;
            } else {
                echo '';
            }
        }
    }

    public function assign_category_user() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_vendor_users');
            $arr_insert = array('category_id' => $post['job']);
            $res = $this->Tbl_helpdesk_vendor_users->update($arr_insert, base64_decode($post['id']));
            if ($res) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function update_status_vendor($id_ = null) {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $id = base64_decode($id_);
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'is_active' => $status
            );
            $res = $this->Tbl_helpdesk_vendors->update($arr, $id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function insert_vendor() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $this->load->model('Tbl_helpdesk_vendors');
            $arr_insert = array(
                'code' => $post['code'],
                'name' => $post['name'],
                'address' => $post['address'],
                'phone_number' => $post['phone'],
                'email' => $post['email'],
                'fax' => $post['fax'],
                'description' => $post['description'],
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_vendors->insert($arr_insert);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function update_vendor() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model('Tbl_helpdesk_vendors');
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $id = base64_decode($post['id']);
            $arr_update = array(
                'code' => $post['code'],
                'name' => $post['name'],
                'address' => $post['address'],
                'phone_number' => $post['phone'],
                'email' => $post['email'],
                'fax' => $post['fax'],
                'description' => $post['description'],
                'is_active' => $status
            );
            $res = $this->Tbl_helpdesk_vendors->update($arr_update, $id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

}
