<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Issue_suggestion
 *
 * @author root
 */
class Issue_suggestion extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_ticket_issue_suggestions'));
    }

    public function index() {
        redirect(base_url('support/issue_suggestion/view/'));
    }

    public function view() {
        $data['title_for_layout'] = 'welcome';
        $data['view-header-title'] = 'View Issue_suggestion List';
        $data['content'] = 'ini kontent web';
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
            $cond['table'] = 'Tbl_helpdesk_ticket_issue_suggestions';
            if (isset($search) && !empty($search)) {
                $cond['like'] = array('a.name', $search);
                $cond['or_like'] = array('a.is_active', $search);
                $cond_count = $cond['or_like'];
            }
            $cond['fields'] = array('a.*');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $total_rows = $this->Tbl_helpdesk_ticket_issue_suggestions->find('count', $cond_count);
            $res = $this->Tbl_helpdesk_ticket_issue_suggestions->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-Issue_suggestion">
                        <div class="col-md-9" style="height:30px">
                            <input type="checkbox" class="make-switch" data-size="small" data-value="' . $d['is_active'] . '" data-id="' . $d['id'] . '" name="status" ' . $status . '/>
                        </div>
                    </div>';
                    $data['rowcheck'] = '<input type="checkbox" class="select_tr" name="select_tr[' . $d['id'] . ']" data-id="' . $d['id'] . '" />';
                    $data['num'] = $i;
                    $data['value_eng'] = $d['value_eng']; //optional
                    $data['value_ina'] = $d['value_ina']; //optional	
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

    public function get_data($id = null) {
        $res = $this->Tbl_helpdesk_ticket_issue_suggestions->find('first', array(
            'conditions' => array('id' => $id)
        ));
        if (isset($res) && !empty($res)) {
            echo json_encode($res);
        } else {
            echo null;
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
                'value_eng' => $post['value_eng'],
                'value_ina' => $post['value_ina'],
                'description' => $post['description'],
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $result = $this->Tbl_helpdesk_ticket_issue_suggestions->insert($arr_insert);
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
                'value_eng' => $post['value_eng'],
                'value_ina' => $post['value_ina'],
                'description' => $post['description'],
                'is_active' => $status,
            );
            $res = $this->Tbl_helpdesk_ticket_issue_suggestions->update($arr, base64_decode($post['id']));
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
            $res = $this->Tbl_helpdesk_ticket_issue_suggestions->update($arr, $id);
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
            $res = $this->Tbl_helpdesk_ticket_issue_suggestions->delete($id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

}
