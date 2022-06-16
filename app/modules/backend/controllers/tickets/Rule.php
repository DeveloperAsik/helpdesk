<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rules
 *
 * @author SuperUser
 */
class Rule extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_ticket_rules'));
    }

    public function index() {
        redirect(base_backend_url('tickets/rule/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_rule');
        $data['view-header-title'] = $this->lang->line('global_header_title_rule');
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $this->load->model('Tbl_helpdesk_ticket_rules');
        $data['priorities'] = $this->Tbl_helpdesk_ticket_rules->find('all', array('conditions' => array('is_active' => 1)));
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
            $cond['table'] = $cond_count['table'] = 'Tbl_helpdesk_ticket_rules';
            if (isset($search) && !empty($search)) {
                $cond['or_like'] = $cond_count['or_like'] = array('a.title' => $search, 'a.response_time' => $search, 'a.solving_time' => $search, 'a.fine_result' => $search);
            }
            $cond['fields'] = array('a.*');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $total_rows = $this->Tbl_helpdesk_ticket_rules->find('count', $cond_count);
            $res = $this->Tbl_helpdesk_ticket_rules->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $rule = '';
                    if ($d['is_active'] == 1) {
                        $rule = 'checked';
                    }
                    $action_status = '<div class="form-group">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_active'] . '" data-id="' . $d['id'] . '" name="rule" ' . $rule . '/>
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
                    $data['title'] = $d['title']; //optional	
                    $data['response_time'] = $d['response_time']; //optional	
                    $data['solving_time'] = $d['solving_time']; //optional	
                    $data['fine_result'] = $d['fine_result']; //optional	
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
            $res = $this->Tbl_helpdesk_ticket_rules->find('first', array(
                'conditions' => array('id' => base64_decode($post['id']))
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
            $rule = 0;
            if ($post['active'] == 'true') {
                $rule = 1;
            }
            $arr_insert = array(
                'title' => $post['title'],
                'response_time' => $post['response_time'],
                'solving_time' => $post['solving_time'],
                'fine_result' => $post['fine_result'],
                'priority_id' => $post['priority_id'],
                'is_active' => $rule,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $result = $this->Tbl_helpdesk_ticket_rules->insert($arr_insert);
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
            $rule = 0;
            if ($post['active'] == "true") {
                $rule = 1;
            }
            $arr = array(
                'title' => $post['title'],
                'response_time' => $post['response_time'],
                'solving_time' => $post['solving_time'],
                'fine_result' => $post['fine_result'],
                'priority_id' => $post['priority_id'],
                'is_active' => $rule,
            );
            $res = $this->Tbl_helpdesk_ticket_rules->update($arr, base64_decode($post['id']));
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
            $rule = 0;
            if ($post['active'] == "true") {
                $rule = 1;
            }
            $arr = array(
                'is_active' => $rule
            );
            $res = $this->Tbl_helpdesk_ticket_rules->update($arr, $id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function delete($id_ = null) {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_helpdesk_ticket_rules->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($id_);
                $res = $this->Tbl_helpdesk_ticket_rules->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

}
