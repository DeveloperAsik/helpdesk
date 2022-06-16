<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group_user
 *
 * @author SuperUser
 */
class Group_user extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_user_groups'));
    }

    public function index() {
        redirect(base_backend_url('prefferences/group_user/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_group_user');
        $data['view-header-title'] = $this->lang->line('global_header_title_group_user');
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
            $cond['table'] = 'Tbl_user_groups';
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('a.name' => $search);
            }
            $cond['fields'] = array('a.*', 'b.username', 'b.email', 'c.name group_name');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $cond['joins'] = $cond_count['joins'] = array(
                array(
                    'table' => 'tbl_users b',
                    'conditions' => 'b.id = a.user_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_groups c',
                    'conditions' => 'c.id = a.group_id',
                    'type' => 'left'
                )
            );
            $total_rows = $this->Tbl_user_groups->find('count', $cond_count);
            $res = $this->Tbl_user_groups->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-group_user">
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
                    $data['username'] = $d['username']; //optional
                    $data['email'] = $d['email']; //optional	
                    $data['group'] = $d['group_name']; //optional	
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
            $res = $this->Tbl_user_groups->find('first', array(
                'fields' => array('a.*', 'b.username', 'b.email', 'c.name group_name'),
                'conditions' => array('a.id' => base64_decode($post['id'])),
                'joins' => array(
                    array(
                        'table' => 'tbl_users b',
                        'conditions' => 'b.id = a.user_id',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_groups c',
                        'conditions' => 'c.id = a.group_id',
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
                'user_id' => $post['user'],
                'group_id' => $post['group'],
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $result = $this->Tbl_user_groups->insert($arr_insert);
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
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'name' => $post['name'],
                'description' => $post['description'],
                'is_active' => $status,
            );
            $res = $this->Tbl_user_groups->update($arr, base64_decode($post['id']));
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
            $res = $this->Tbl_user_groups->update($arr, $id);
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
                    $arr_res = $this->Tbl_user_groups->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_user_groups->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function get_group() {
        $this->load->model(array('Tbl_groups'));
        $res = $this->Tbl_groups->find('list', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'name', 'type' => 'ASC')));
        if (isset($res) && !empty($res)) {
            $arr = '<option>'.$this->lang->line('global_select_one').'</option>';
            foreach ($res AS $k => $v) {
                $arr .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
            }
            echo $arr;
        } else {
            echo null;
        }
    }

    public function get_user() {
        $this->load->model(array('Tbl_users'));
        $res = $this->Tbl_users->find('all', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'email', 'type' => 'ASC')));
        if (isset($res) && !empty($res)) {
            $arr = '<option>'.$this->lang->line('global_select_one').'</option>';
            foreach ($res AS $k => $v) {
                $arr .= '<option value="' . $v['id'] . '">' . $v['email'] . '</option>';
            }
            echo $arr;
        } else {
            echo null;
        }
    }

}
