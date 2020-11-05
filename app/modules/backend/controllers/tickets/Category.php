<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author SuperUser
 */
class Category extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_ticket_categories', 'Tbl_icons'));
    }

    public function index() {
        redirect(base_backend_url('tickets/category/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_category');
        $data['view-header-title'] = $this->lang->line('global_header_title_category');
        $data['icons'] = $this->Tbl_icons->find('all', array('conditions' => array('is_active' => 1)));
        $css_files = array(
            static_url('lib/packages/bootstrap/treeview/dist/bootstrap-treeview.min.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('lib/packages/bootstrap/treeview/dist/bootstrap-treeview.min.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_data() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $res = $this->Tbl_helpdesk_ticket_categories->find('first', array(
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
            $arr_insert = '';
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            switch ($post['level']) {
                case 0:
                    $level = 1;
                    break;
                case 1:
                    $level = 2;
                    break;
                case 2:
                    $level = 3;
                    break;
            }
            $rank = 1;
            //before insert check it first rank with same params is exist then plus 1
            $exist = $this->Tbl_helpdesk_ticket_categories->find('all', array('conditions' => array(
                    'level' => $level,
                    'parent_id' => $post['parent_id']
                )
                    )
            );
            if (isset($exist) && !empty($exist)) {
                $rank = count($exist) + 1;
            }
            $arr_insert = array(
                'name' => $post['name'],
                'name_ina' => $post['name_ina'],
                'rank' => $rank,
                'level' => $level,
                'icon' => $post['icon'],
                'is_active' => $status,
                'description' => $post['description'],
                'parent_id' => $post['parent_id'],
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_helpdesk_ticket_categories->insert($arr_insert);
            if ($res == true) {
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
            $logged = 0;
            if ($post['logged'] == "true") {
                $logged = 1;
            }
            $arr_update = array(
                'name' => $post['name'],
                'name_ina' => $post['name_ina'],
                'rank' => 0,
                'level' => $post['level'],
                'icon' => $post['icon'],
                'is_active' => $status,
                'description' => $post['description'],
                'parent_id' => $post['parent_id']
            );
            $res = $this->Tbl_helpdesk_ticket_categories->update($arr_update, base64_decode($post['id']));
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
            $res = $this->Tbl_helpdesk_ticket_categories->update($arr, $id);
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
                    $arr_res = $this->Tbl_helpdesk_ticket_categories->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_helpdesk_ticket_categories->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function get_category() {
        $categories = $this->category();
        if (isset($categories) && !empty($categories)) {
            $first_arr = array();
            if (isset($categories['nodes']) && !empty($categories['nodes'])) {
                $second_arr = array();
                foreach ($categories['nodes'] AS $values) {
                    $third_arr = array();
                    $parent_id = 0;
                    $parent_name = '';
                    if (isset($values['nodes']) && !empty($values['nodes'])) {
                        foreach ($values['nodes'] AS $val) {
                            $fourth_arr = array();
                            if (isset($val['nodes']) && !empty($val['nodes'])) {
                                foreach ($val['nodes'] AS $v) {
                                    $fourth_arr[] = array(
                                        'text' => $v['menu_text'],
                                        's_text' => $v['menu_text'],
                                        'micon' => isset($v['menu_icon']) ? $v['menu_icon'] : '#',
                                        'level' => $v['menu_level'],
                                        'parent_id' => (int) $v['menu_parent_id'],
                                        'parent_name' => $this->Tbl_helpdesk_ticket_categories->get_name($v['menu_parent_id']),
                                        'is_active' => $v['is_active'],
                                        'id' => (int) $v['menu_id']
                                    );
                                }
                            }
                            $parent_id_ = $val['menu_parent_id'];
                            $parent_name_ = $this->Tbl_helpdesk_ticket_categories->get_name($val['menu_parent_id']);
                            $sts_act2 = ' <small style="color:#24abf2">(active)</small>';
                            if ($val['is_active'] == 0) {
                                $sts_act2 = ' <small style="color:#c14b4f">(deactivated)</small>';
                            }
                            $third_arr[] = array(
                                'text' => $val['menu_text'] . $sts_act2,
                                's_text' => $val['menu_text'],
                                'micon' => isset($val['menu_icon']) ? $val['menu_icon'] : '#',
                                'level' => $val['menu_level'],
                                'parent_id' => (int) $parent_id_,
                                'parent_name' => isset($parent_name_) ? $parent_name_ : '',
                                'id' => (int) $val['menu_id'],
                                'is_active' => $val['is_active'],
                                'nodes' => $fourth_arr
                            );
                        }
                    }
                    if (isset($values['menu_parent_id']) && $values['menu_parent_id'] != 0) {
                        $parent_id = $values['menu_parent_id'];
                        $parent_name = $this->Tbl_helpdesk_ticket_categories->get_name($values['menu_parent_id']);
                    }
                    $sts_act3 = ' <small style="color:#24abf2">(active)</small>';
                    if ($values['is_active'] == 0) {
                        $sts_act3 = ' <small style="color:#c14b4f">(deactivated)</small>';
                    }
                    $second_arr[] = array(
                        'text' => $values['menu_text'] . $sts_act3,
                        's_text' => $values['menu_text'],
                        'micon' => isset($values['menu_icon']) ? $values['menu_icon'] : '#',
                        'level' => $values['menu_level'],
                        'id' => (int) $values['menu_id'],
                        'parent_id' => $parent_id,
                        'parent_name' => isset($parent_name) ? $parent_name : '-',
                        'is_active' => $values['is_active'],
                        'nodes' => $third_arr
                    );
                }
                $sts_act = ' <small style="color:#24abf2">(active)</small>';
                if ($categories['is_active'] == 0) {
                    $sts_act = ' <small style="color:#c14b4f">(deactivated)</small>';
                }
                $first_arr = array(
                    'text' => $categories['text'] . $sts_act,
                    's_text' => $categories['text'],
                    'micon' => '-',
                    'level' => $categories['level'],
                    'id' => (int) $categories['id'],
                    'parent_id' => 0,
                    'parent_name' => '-',
                    'is_active' => $categories['is_active'],
                    'nodes' => $second_arr
                );
            }
            if ($first_arr != null) {
                echo '[' . json_encode($first_arr) . ']';
            }
        } else {
            echo '[{ 
                "text" : "Ticket Category" ,
                "icon": "",
                "level" : "0",
                "id": "0",
                "parent_id": "0",
                "parent_name": "-",
                "is_active": 1,
            }]';
        }
    }

}
