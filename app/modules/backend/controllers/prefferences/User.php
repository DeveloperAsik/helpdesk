<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function dashboard() {
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
        );
        $this->load_js($js_files);
        $css_files = array(
            static_url('templates/metronics/assets/global/css/timeline.css'),
            static_url('templates/metronics/assets/global/css/todo.css'),

        );
        $this->load_css($css_files);
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_dashboard');
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function my_profile() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_my_profile');
        //load js
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function lock_screen() {
        $this->oreno_auth->lock_screen();
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_lock_screen');
        //load js
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic_lock_screen.phtml', $data);
    }

    public function un_lock_screen() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $res = $this->oreno_auth->unlock_screen($post);
            if ($res) {
                echo return_call_back('message', array('verify' => true), 'json');
            } else {
                echo return_call_back('message', array('verify' => false), 'json');
            }
        } else {
            echo return_call_back('message', array('verify' => false), 'json');
        }
        exit();
    }

    public function get_user($id = 1) {
        if ($id == 1) {
            $this->load->model('Tbl_helpdesk_users');
            $res = $this->Tbl_helpdesk_users->find('all', array(
                'fields' => array('a.*'),
                'conditions' => array('a.is_active' => 1)
                    )
            );
        } elseif ($id == 2) {
            $this->load->model('Tbl_helpdesk_support_users');
            $res = $this->Tbl_helpdesk_support_users->find('all', array(
                'fields' => array('a.id', 'a.nik', 'b.email'),
                'conditions' => array('a.is_active' => 1),
                'joins' => array(
                    array(
                        'table' => 'tbl_users b',
                        'conditions' => 'b.id = a.user_id',
                        'type' => 'left'
                    )
                )
                    )
            );
        }
        if (isset($res) && !empty($res)) {
            $arr = '<option value="">' . $this->lang->line('global_select_one') . '</option>';
            foreach ($res AS $k => $v) {
                $arr .= '<option value="' . $v['id'] . '">' . $v['nik'] . '-' . $v['email'] . '</option>';
            }
            echo $arr;
        } else {
            echo null;
        }
    }

    public function get_data() {
        $this->load->model('Tbl_users');
        $res = $this->Tbl_users->find('first', array(
            'fields' => array('a.id', 'a.username', 'a.first_name', 'a.last_name', 'a.email', 'a.is_active act_status', 'b.id user_profile_id', 'b.address', 'b.lat', 'b.lng', 'b.img', 'b.description', 'd.name group_name'),
            'conditions' => array('a.id' => (int) base64_decode($this->auth_config->user_id)),
            'joins' => array(
                array(
                    'table' => 'tbl_user_profiles b',
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

    public function get_history() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $total_rows = count($this->get_all_history());
            $res = $this->get_all_history();
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $activities = 'User accessing module <b>' . $d->module . '</b> and class <b>' . $d->class . '</b> at ' . $d->create_date;
                    $data['num'] = $i;
                    $data['activities'] = $activities; //optional	
                    $data['date'] = !empty($d->create_date) ? fn_date_diff($d->create_date, date_now()) . ' a go' : ''; //optional	
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
        }
    }

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_users', 'Tbl_user_profiles', 'Tbl_helpdesk_users'));
            $user_id = base64_decode($post['id']);
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password($post['password']));
            }
            $status = 0;
            if ($post['active'] == "true") {
                $status = 1;
            }
            $arr = array(
                'username' => $post['username'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'email' => $post['email'],
                'is_active' => $status,
            );
            $arr_res = array_merge($arr, $pass);
            $res = $this->Tbl_users->update($arr_res, $user_id);
            if ($res) {
                if (isset($post['files']['data']) && !empty($post['files']['data'])) {
                    $img_base64 = base64_decode($post['files']['data']);
                    $upload_img = $this->base64ToImage($post['id'], $img_base64);
                    $user_profile = $this->Tbl_user_profiles->find('first', array('conditions' => array('user_id' => $user_id)));
                    $arr_insert = array(
                        'img' => $upload_img
                    );
                    if ($user_profile == null) {
                        $rr = array(
                            'user_id' => $user_id,
                            'is_active' => 1,
                            'created_by' => (int) base64_decode($this->auth_config->user_id),
                            'create_date' => date_now()
                        );
                        $arr = array_merge($rr, $arr_insert);
                        $this->Tbl_user_profiles->insert($arr);
                    } else {
                        if (file_exists($this->config->item('dir.user_profile_img', 'path') . $user_profile['img'])) {
                            unlink($this->config->item('dir.user_profile_img', 'path') . $user_profile['img']);
                        }
                        $this->Tbl_user_profiles->update($arr_insert, $user_profile['id']);
                    }
                }
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

}
