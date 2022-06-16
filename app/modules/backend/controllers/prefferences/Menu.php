<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author SuperUser
 */
class Menu extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_menus'));
    }

    public function index() {
        redirect(base_backend_url('settings/menu/view/'));
    }

    public function view() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_menu');
        $data['view-header-title'] = $this->lang->line('global_header_title_menu');
        $this->load->model(array('Tbl_icons', 'Tbl_modules'));
        $data['modules'] = $this->Tbl_modules->find('list', array('conditions' => array('is_active' => 1), 'order' => array('key' => 'id', 'type' => 'ASC')));
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
            $id = base64_decode($post['id']);
            $res = $this->Tbl_menus->find('first', array(
                'conditions' => array('a.id' => ($id)),
                'fields' => array('a.*', 'b.id AS icon_id', 'b.name AS icon_name', 'c.name module_name'),
                'joins' => array(
                    array(
                        'table' => 'tbl_icons b',
                        'conditions' => 'b.id = a.icon',
                        'type' => 'left'
                    ),
                    array(
                        'table' => 'tbl_modules c',
                        'conditions' => 'c.id = a.module_id',
                        'type' => 'left'
                    )
                )
                    )
            );
            if (isset($res) && !empty($res)) {
                if ($res['parent_id'] != '0') {
                    $prnt_nm = $this->Tbl_menus->get_name($res['parent_id']);
                    $res = array_merge($res, array('parent_name' => $prnt_nm));
                }
                echo json_encode($res);
            } else {
                echo null;
            }
        }
    }

    public function get_all_data() {
        $res = $this->Tbl_menus->find('first', array(
            'conditions' => array('tbl_menus.active' => q),
            'fields' => array('tbl_menus.*', 'tbl_icons.id AS icon_id', 'tbl_icons.name AS icon_name'),
            'joins' => array(
                array(
                    'table' => 'tbl_icons',
                    'conditions' => 'tbl_icons.id = tbl_menus.icon_id',
                    'type' => 'left'
                )
            )
                )
        );
        $p = explode('/', $res['path']);
        $module = $p[0];
        $path = $this->fnReshapePath($res['path'], array('replace', $p[0], ''));
        if (isset($res) && !empty($res)) {
            $arr = array(
                'id' => $res['id'],
                'name' => $res['name'],
                'module' => $module,
                'path' => $path,
                'icon' => $res['icon_name'],
                'icon_img' => '<i id="icon_img" class="fa fa-fw ' . $res['icon_name'] . ' fa-3x"></i>'
            );
            echo json_encode($arr);
        } else {
            echo null;
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
            $logged = 0;
            if ($post['logged'] == 'true') {
                $logged = 1;
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
            //before insert check it first rank with same params is exist then plus 1
            $exist = $this->Tbl_menus->find('all', array('conditions' => array(
                    'level' => $level,
                    'module_id' => $post['module'],
                    'parent_id' => $post['parent_id']
                )
                    )
            );
            $rank = count($exist) + 1;
            if (isset($post['rank']) && !empty($post['rank'])) {
                $rank = $post['rank'];
            }
            $arr_insert = array(
                'name' => $post['name'],
                'name_ina' => $post['name_ina'],
                'path' => $post['path'],
                'rank' => $rank,
                'level' => $level,
                'icon' => $post['icon'],
                'module_id' => $post['module'],
                'is_logged_in' => $logged,
                'is_active' => $status,
                'description' => $post['description'],
                'parent_id' => $post['parent_id'],
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $res = $this->Tbl_menus->insert($arr_insert);
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
                'path' => $post['path'],
                'rank' => $post['rank'],
                'level' => $post['level'],
                'icon' => $post['icon'],
                'module_id' => $post['module'],
                'is_logged_in' => $logged,
                'is_active' => $status,
                'description' => $post['description'],
                'parent_id' => $post['parent_id']
            );
            $res = $this->Tbl_menus->update($arr_update, base64_decode($post['id']));
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        } else {
            echo 'failed';
        }
    }

    public function remove() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_menus->remove($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_menus->remove($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function delete() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_menus->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
                $id = base64_decode($post['id']);
                $res = $this->Tbl_menus->delete($id);
                if ($res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            }
        }
    }

    public function get_controller_prefixs($id = null) {
        if ($id != null) {
            $this->load->model('Tbl_modules');
            $res = $this->Tbl_modules->find('first', array('conditions' => array('id' => $id)));
            echo json_encode($res);
        } else {
            echo null;
        }
    }

    public function get_icon($id = null) {
        if ($id != null) {
            $this->load->model('Tbl_icons');
            $res = $this->Tbl_icons->find('first', array('conditions' => array('id' => $id)));
            echo json_encode($res);
        } else {
            echo null;
        }
    }

    public function get_menu($id = null, $key = 0, $name = null) {
        $menus = $this->menu($id, false, $key, $name, 0);
        $module_n = $this->Tbl_modules->get_name($id);
        if (isset($menus) && !empty($menus)) {
            $first_arr = array();
            if (isset($menus['nodes']) && !empty($menus['nodes'])) {
                $second_arr = array();
                foreach ($menus['nodes'] AS $values) {
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
                                        'micon' => isset($v['menu_icon']) ? $v['menu_icon'] : '#',
                                        'href' => isset($v['menu_path']) ? $v['menu_path'] : '#',
                                        'level' => $v['menu_level'],
                                        'parent_id' => (int) $v['menu_parent_id'],
                                        'parent_name' => $this->Tbl_menus->get_name($v['menu_parent_id']),
                                        'module_id' => $id,
                                        'module_name' => $module_n,
                                        'is_active' => $v['is_active'],
                                        'is_logged_in' => $v['is_logged_in'],
                                        'id' => (int) $v['menu_id']
                                    );
                                }
                            }
                            $parent_id_ = $val['menu_parent_id'];
                            $parent_name_ = $this->Tbl_menus->get_name($val['menu_parent_id']);
                            $third_arr[] = array(
                                'text' => $val['menu_text'],
                                'micon' => isset($val['menu_icon']) ? $val['menu_icon'] : '#',
                                'href' => isset($val['menu_path']) ? $val['menu_path'] : '#',
                                'level' => $val['menu_level'],
                                'parent_id' => (int) $parent_id_,
                                'parent_name' => isset($parent_name_) ? $parent_name_ : '',
                                'id' => (int) $val['menu_id'],
                                'module_id' => $id,
                                'module_name' => $module_n,
                                'is_active' => $val['is_active'],
                                'is_logged_in' => $val['is_logged_in'],
                                'nodes' => $fourth_arr
                            );
                        }
                    }
                    if (isset($values['menu_parent_id']) && $values['menu_parent_id'] != 0) {
                        $parent_id = $values['menu_parent_id'];
                        $parent_name = $this->Tbl_menus->get_name($values['menu_parent_id']);
                    }
                    $second_arr[] = array(
                        'text' => $values['menu_text'],
                        'micon' => isset($values['menu_icon']) ? $values['menu_icon'] : '#',
                        'href' => isset($values['menu_path']) ? $values['menu_path'] : '#',
                        'level' => $values['menu_level'],
                        'id' => (int) $values['menu_id'],
                        'parent_id' => $parent_id,
                        'parent_name' => isset($parent_name) ? $parent_name : '-',
                        'module_id' => $id,
                        'module_name' => $module_n,
                        'is_active' => $values['is_active'],
                        'is_logged_in' => $values['is_logged_in'],
                        'nodes' => $third_arr
                    );
                }
                $first_arr = array(
                    'text' => $menus['text'],
                    'micon' => '-',
                    'href' => isset($menus['path']) ? $menus['path'] : '',
                    'level' => $menus['level'],
                    'id' => (int) $menus['id'],
                    'parent_id' => 0,
                    'parent_name' => '-',
                    'module_id' => $id,
                    'module_name' => $module_n,
                    'is_active' => $menus['is_active'],
                    'is_logged_in' => $menus['is_logged_in'],
                    'nodes' => $second_arr
                );
            }
            if ($first_arr != null) {
                echo '[' . json_encode($first_arr) . ']';
            }
        } else {
            echo '[{ 
                "text" : "' . $name . '" ,
                "icon": "",
                "href": "#",
                "level" : "0",
                "id": "0",
                "parent_id": "0",
                "parent_name": "-",
                "module_id": "' . $id . '",
                "module_name": "' . $module_n . '",
                "is_active": 1,
                "is_logged_in": 1
            }]';
        }
    }

    public function get_module() {
        $this->load->model('Tbl_modules');
        $modules = $this->Tbl_modules->find('all', array('conditions' => array('is_active' => 1)));
        echo json_encode($modules);
    }
}
