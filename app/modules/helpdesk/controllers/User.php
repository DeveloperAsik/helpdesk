<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect(base_url('login'));
    }

    public function dashboard() {
        $css_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.css'),
            static_url('templates/metronics/assets/global/css/timeline.css'),
            static_url('templates/metronics/assets/global/css/todo.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            "http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js",
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/datatables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
            static_url('lib/single/modernizr.custom.js'),
            static_url('lib/packages/dropzone/dist/dropzone.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'),
            static_url('templates/metronics/assets/global/plugins/jquery-validation/js/additional-methods.min.js'),
            static_url('templates/metronics/assets/global/plugins/select2/js/select2.full.min.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/lib/markdown.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'),
            static_url('templates/metronics/assets/global/plugins/bootstrap-summernote/summernote.min.js')
        );
        $this->load_js($js_files);
        $data['title_for_layout'] = 'welcome to dashbohard';
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_data() {
        $this->load->model(array('Tbl_users', 'Tbl_user_profiles'));
        $res = $this->Tbl_users->find('first', array(
            'fields' => array('a.id', 'a.username', 'a.first_name', 'a.last_name', 'a.email', 'a.is_active act_status', 'd.name group_name'),
            'conditions' => array('a.id' => (int) base64_decode($this->auth_config->user_id)),
            'joins' => array(
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
            $img = $this->Tbl_user_profiles->find('first', array('conditions' => array('user_id' => $res['id'])));
            $res = array_merge($res, array('img' => $img['img']));
            echo json_encode($res);
        } else {
            echo null;
        }
    }

    public function my_profile() {
        $data['title_for_layout'] = 'welcome';
        //load js
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')
        );		
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function lock_screen() {
        $this->oreno_auth->lock_screen();
        $data['title_for_layout'] = 'welcome';
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
                exit();
            } else {
                echo return_call_back('message', array('verify' => false), 'json');
                exit();
            }
        } else {
            echo return_call_back('message', array('verify' => false), 'json');
            exit();
        }
    }

    public function switch_lang() {
        $request_language = $this->input->get(NULL, TRUE);
        if (isset($request_language['bahasa']) && !empty($request_language['bahasa'])) {
            $session_language = $this->session->userdata('_lang');
            if ($request_language['bahasa'] != $session_language) {
                unset($_SESSION['_lang']);
                $_SESSION['_lang'] = $request_language['bahasa'];
                redirect($this->agent->referrer());
            }
        } else {
            $this->session->set_flashdata('error', $this->lang->line('failed_change_lang'));
            redirect($this->agent->referrer());
        }
    }

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_users', 'Tbl_user_profiles'));
            $user_id = base64_decode($post['id']);
            $pass = array();
            if (isset($post['password']) && !empty($post['password'])) {
                $pass = array('password' => $this->oreno_auth->hash_password(($post['password'])));
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
                exit();
            } else {
                echo 'failed';
                exit();
            }
        } else {
            echo 'failed';
            exit();
        }
    }

	public function get_history() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->library('pagination');
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
                    $activities = 'User access Module : ' . $d->module . ' and Class : ' . $d->class;
                    $data['num'] = $i;
                    $data['activities'] = $activities; //optional	
                    $data['date'] = fn_date_diff($d->create_date, date_now()) . ' a go'; //optional	
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
            exit();
        }
    }
}
