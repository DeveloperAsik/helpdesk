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
 * Description of Officer
 *
 * @author SuperUser
 */
class Officer extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_employees'));
    }

    public function index() {
        redirect(base_backend_url('accounts/officer/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_imi');
        $data['view-header-title'] = $this->lang->line('global_header_title_imi');
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

    public function download_sample($filename, $type) {
        $this->load->library('oreno_generate_file');
        $this->oreno_generate_file->init($filename, 'kanim', $type);
    }

    public function import_file() {
        if (isset($_FILES['import_file_kanim']) && !empty($_FILES['import_file_kanim'])) {
            $path = $_FILES['import_file_kanim']['tmp_name'];
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
            }
            $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_employees', 'Tbl_helpdesk_employee_users', 'Tbl_helpdesk_branchs'));
            if (isset($arr) && !empty($arr)) {
                foreach ($arr AS $k => $v) {
                    $branch = $this->Tbl_helpdesk_branchs->find('first', array('conditions' => array('code' => $v['office_id'])));
                    $pass = array();
                    if (isset($v['password']) && !empty($v['password'])) {
                        $pass = array('password' => $this->oreno_auth->hash_password((base64_decode($v['password']))));
                    }
                    $arr_user = array(
                        'nik' => $v['nik'],
                        'username' => $v['username'],
                        'first_name' => $v['first_name'],
                        'last_name' => $v['last_name'],
                        'email' => $v['email'],
                        'status' => 3,
                        'is_active' => $v['is_active'],
                        'is_logged_in' => 0,
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $arr_user = array_merge($arr_user, $pass);
                    $user_id = $this->Tbl_users->insert_return_id($arr_user);
                    if ($user_id) {
                        $arr_user_group = array(
                            'user_id' => $user_id,
                            'group_id' => 2,
                            'is_active' => $v['is_active'],
                            'created_by' => (int) base64_decode($this->auth_config->user_id),
                            'create_date' => date_now()
                        );
                        $this->Tbl_user_groups->insert($arr_user_group);
                    }
                    $arr_insert = array(
                        'nik' => $v['nik'],
                        'name' => $v['username'],
                        'email' => $v['email'],
                        'phone_number' => $v['phone_number'],
                        'is_active' => $v['is_active'],
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $employee_id = $this->Tbl_helpdesk_employees->insert_return_id($arr_insert);
                    $arr_employee = array(
                        'employee_id' => $employee_id,
                        'user_id' => $user_id,
                        'branch_id' => $branch['id'],
                        'is_active' => $v['is_active'],
                        'created_by' => (int) base64_decode($this->auth_config->user_id),
                        'create_date' => date_now()
                    );
                    $this->Tbl_helpdesk_employee_users->insert($arr_employee);
                }
                echo 'success';
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
            $cond['table'] = $cond_count['table'] = 'Tbl_helpdesk_employees';
            $cond['conditions'] = array('e.group_id' => 2);
            $cond['fields'] = array('a.*', 'c.code branch_code', 'c.name branch_name');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('a.name' => $search);
            }
            $cond['joins'] = $cond_count['joins'] = array(
                array(
                    'table' => 'tbl_helpdesk_employee_users b',
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
                'fields' => array('a.*', 'b.branch_id', 'c.*', 'd.name branch_name'),
                'conditions' => array('a.id' => base64_decode($post['id'])),
                'joins' => array(
                    array(
                        'table' => 'tbl_helpdesk_employee_users b',
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
            $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_employees', 'Tbl_helpdesk_employee_users'));
            //check if nik, username or email is exist
            $this->load->helper('email');
            if (valid_email($post['userid'])) {
                $cond = " email LIKE '%" . $post['userid'] . "%' "; //array('field' => 'email', 'value' => $post['userid']);
            } elseif (is_numeric($post['userid'])) {
                $cond = " nik LIKE '%" . $post['userid'] . "%'"; //array('field' => 'nik', 'value' => $post['userid']);
            } else {
                $cond = " user name LIKE '%" . $post['userid'] . "%'"; //array('field' => 'username', 'value' => $post['userid']);
            }
            $user_exist = $this->Tbl_users->query("SELECT * FROM tbl_users WHERE is_active = 1 AND " . $cond);
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password(($post['password'])));
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
                $this->Tbl_helpdesk_employee_users->insert($arr_employee);
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
            $this->load->model(array('Tbl_helpdesk_employee_users', 'Tbl_users'));
            $id = base64_decode($post['id']);
            $employee_user = $this->Tbl_helpdesk_employee_users->find('first', array('conditions' => array('user_id' => $id)));
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password($post['password']));
            }
            $arr_user = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'is_active' => $status
            );
            $arr_user = array_merge($arr_user, $pass);
            $res = $this->Tbl_users->update($arr_user, $employee_user['user_id']);
            if ($res == true) {
                $arr_insert_employee = array(
                    'nik' => $post['nik'],
                    'name' => $post['username'],
                    'email' => $post['email'],
                    'phone_number' => $post['phone_number'],
                    'is_active' => $status
                );
                $this->Tbl_helpdesk_employees->update($arr_insert_employee, $employee_user['employee_id']);
                echo 'success';
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
            $res = $this->Tbl_helpdesk_employees->update($arr, $id);
            if ($res == true) {
                $this->load->model(array('Tbl_helpdesk_employee_users', 'Tbl_users'));
                $employee = $this->Tbl_helpdesk_employee_users->find('first', array('conditions' => array('employee_id' => $id)));
                if ($employee) {
                    $arr_user = array(
                        'is_active' => $status
                    );
                    $this->Tbl_users->update($arr_user, $employee['user_id']);
                }
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function delete() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_helpdesk_employee_users', 'Tbl_helpdesk_employees'));
            if (is_array($post['id'])) {
                $this->load->library('Oreno_log');
                $arr_res = false;
                foreach ($post['id'] AS $key => $val) {
                    //find at tbl_users
                    $user = $this->Tbl_users->find('first', array('conditions' => array('id' => $val)));
                    //find at Tbl_user_groups
                    $group_user = $this->Tbl_user_groups->find('first', array('conditions' => array('user_id' => $val)));
                    //find at Tbl_helpdesk_employee_users
                    $employee_user = $this->Tbl_helpdesk_employee_users->find('first', array('conditions' => array('user_id' => $group_user['user_id'])));
                    //find employee
                    $employee = $this->Tbl_helpdesk_employees->find('first', array('conditions' => array('id' => $employee_user['employee_id'])));
                    //debug(array($user,$group_user,$employee_user,$employee));
                    //create log file at destination path for tbl_user
                    $this->oreno_log->init_($user, $this->setLogPath($val, $group_user['group_id'], 'tbl_user'));
                    $arr_res = $this->Tbl_users->delete($val);
                    if ($group_user != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($group_user, $this->setLogPath($val, $group_user['group_id'], 'tbl_user_groups'));
                        $this->Tbl_user_groups->delete($group_user['id']);
                    }
                    if ($employee != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($employee, $this->setLogPath($val, $group_user['group_id'], 'tbl_helpdesk_employees'));
                        $this->Tbl_helpdesk_employees->delete($employee['id']);
                    }
                    if ($employee_user != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($employee, $this->setLogPath($val, $group_user['group_id'], 'tbl_helpdesk_employee_users'));
                        $this->Tbl_helpdesk_employee_users->delete($employee_user['id']);
                    }
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                //find at Tbl_user_groups
                $group_user = $this->Tbl_user_groups->find('first', array('conditions' => array('user_id' => $id)));
                //find at Tbl_helpdesk_employee_users
                $employee_user = $this->Tbl_helpdesk_employee_users->find('first', array('conditions' => array('user_id' => $id)));
                //find employee
                $employee = $this->Tbl_helpdesk_employees->find('first', array('conditions' => array('id' => $employee_user['employee_id'])));

                //create log file at destination path for tbl_user
                $this->oreno_log->init_($user, $this->setLogPath($val, $group_user['group_id'], 'tbl_user'));
                $res = $this->Tbl_user->delete($id);
                if ($res == true) {
                    if ($group_user != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($group_user, $this->setLogPath($val, $group_user['group_id'], 'tbl_user_groups'));
                        $this->Tbl_user_groups->delete($group_user['id']);
                    }
                    if ($employee != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($employee, $this->setLogPath($val, $group_user['group_id'], 'tbl_helpdesk_employees'));
                        $this->Tbl_helpdesk_employees->delete($employee['id']);
                    }
                    if ($employee_user != null) {
                        //create log file at destination path for tbl_user_groups
                        $this->oreno_log->init_($employee, $this->setLogPath($val, $group_user['group_id'], 'tbl_helpdesk_employee_users'));
                        $this->Tbl_helpdesk_employee_users->delete($employee_user['id']);
                    }
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

}
