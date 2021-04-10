<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oreno_auth
 *
 */
class Oreno_auth {

    //put your code here
    public function __construct() {
        $CI = & get_instance();
        $CI->load->library(array('session', 'oreno_mail'));
    }

    public function auth($data = array()) {
        $CI = & get_instance();
        $CI->load->helper('email');
        if (valid_email($data['userid'])) {
            $cond = array('field' => 'email', 'value' => $data['userid']);
        } elseif (is_numeric($data['userid'])) {
            $cond = array('field' => 'nik', 'value' => $data['userid']);
        } else {
            $cond = array('field' => 'username', 'value' => $data['userid']);
        }
        $pass = base64_decode($data['password']);
        $user = $this->get_user_by($cond, 'all');
        $result = json_decode($user);
        $return = array('result' => array('content' => $result->result->content, 'param' => $data['userid'], 'status' => 'failed'));
        if ($result->result->status == 'success') {
            $userid = $result->result->content->username;
            $pass_hashed = $result->result->content->password;
            //verfiy password
            $CI->load->model('Tbl_user_groups');
            $group = $CI->Tbl_user_groups->find('first', array('conditions' => array('user_id' => $result->result->content->id)));
            if (password_verify($pass, $pass_hashed)) {
                //generate session auth for user
                $this->generate_session($result->result->content->id);
                $return = array('result' => array('content' => 'Auth user success', 'status' => 'success', 'group' => $group['group_id']));
            } else {
                $return = array('result' => array('content' => 'Auth user failed, ' . $result->result->content->id, 'param' => $userid, 'group' => $group['group_id'], 'status' => 'failed'));
            }
        }
        return json_encode($return);
    }

    public function generate_session($id = null) {
        $CI = & get_instance();
        if ($id != null) {
            $prf = 'default';
            $sess_name = $CI->config->session_name;
            $cond = array('field' => 'a.id', 'value' => $id);
            $user = $this->get_user($cond, 'first');
            $result = json_decode($user);
            if ($result->result->status == 'success') {
                $cond2 = array('field' => 'a.id', 'value' => $result->result->content->group_id);
                $permission_arr = $this->get_permission($cond2, 'all');
                $permission = json_decode($permission_arr);
                $array = array(
                    'nik' => $result->result->content->nik,
                    'user_id' => base64_encode($id),
                    'username' => $result->result->content->username,
                    'email' => $result->result->content->email,
                    'group_id' => $result->result->content->group_id,
                    'group_name' => $result->result->content->group_name,
                    'img' => $result->result->content->img,
                    'is_active' => $result->result->content->is_active,
                    'is_logged_in' => true,
                    'login_start' => date_now(),
                    'login_expiry' => date('Y-m-d H:i:s', strtotime('+4 Hours'))
                );
                $arr_new = array();
                if ($result->result->content->group_name == 'employee') {
                    $CI->load->model('Tbl_helpdesk_employee_users');
                    $emp = $CI->Tbl_helpdesk_employee_users->find('first', array(
                        'fields' => array('a.*', 'b.id branch_id', 'b.code', 'b.name'),
                        'conditions' => array('a.user_id' => $id),
                        'joins' => array(
                            array(
                                'table' => 'tbl_helpdesk_office_branchs b',
                                'conditions' => 'b.id = a.branch_id',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $arr_new = array(
                        'office_id' => $emp['branch_id'],
                        'office_code' => $emp['code'],
                        'office_name' => $emp['name'],
                        'alias' => 'kanim',
                        'employee' => true
                    );
                } elseif ($result->result->content->group_name == 'vendor') {
                    $CI->load->model('Tbl_helpdesk_vendor_users');
                    $emp = $CI->Tbl_helpdesk_vendor_users->find('first', array(
                        'fields' => array('a.*', 'b.id branch_id', 'b.code', 'b.name'),
                        'conditions' => array('a.user_id' => $id),
                        'joins' => array(
                            array(
                                'table' => 'tbl_helpdesk_vendors b',
                                'conditions' => 'b.id = a.vendor_id',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $arr_new = array(
                        'office_id' => $emp['branch_id'],
                        'office_code' => $emp['code'],
                        'office_name' => $emp['name'],
                        'alias' => 'kso',
                        'employee' => false
                    );
                } else {
                    $arr_new = array(
                        'office_id' => '00',
                        'office_code' => 'IMI',
                        'office_name' => 'TIM TIK',
                        'alias' => 'TIM TIK',
                        'employee' => false
                    );
                }
                $array = array_merge($array, $arr_new);
                //update tbl_users is_logged_in true
                $CI->Tbl_users->update(array('is_logged_in' => 1), $id);
                //check if session is exist
                if (isset($_SESSION[$sess_name]) && !empty($_SESSION[$sess_name])) {
                    //if session with name exist, then remove and re-create
                    unset($_SESSION[$sess_name]);
                }
                $_SESSION[$sess_name] = $array;
            }
        }
    }

    public function generate_cookie($id = null) {
        $CI = & get_instance();
        $cookie = array(
            'name' => 'cookie_login',
            'value' => $CI->config->cookie_id,
            'expire' => '10800',
            'domain' => base_url(),
            'secure' => TRUE
        );
        $CI->input->set_cookie($cookie);
    }

    public function hash_password($password = null) {
        if ($password != null) {
            $options = array(
                'cost' => 12,
            );
            $pass_hashed = password_hash($password, PASSWORD_BCRYPT, $options);
            if (password_verify($password, $pass_hashed)) {
                return $pass_hashed;
            }else{
                debug('wew');
               return password_hash($password, PASSWORD_BCRYPT, $options);
            }
        }
    }

    public function get_user_by($conditions = null, $opt = 'all') {
        $this->c = & get_instance();
        $this->c->load->model(array('Tbl_users'));
        $result = $this->c->Tbl_users->find($opt, array(
            'conditions' => array($conditions['field'] => $conditions['value'], 'is_active' => 1)
                )
        );
        $return = array('result' => array('content' => 'data not found ', 'param' => $conditions, 'status' => 'failed'));
        if (isset($result) && !empty($result)) {
            $count = count($result);
            if ($count > 1) {
                $return = array('result' => array('content' => 'data found ' . $count, 'param' => $conditions, 'status' => 'failed'));
            }
            $return = array('result' => array('content' => $result[0], 'status' => 'success'));
        }
        return json_encode($return);
    }

    public function get_user($conditions = null, $opt = 'all') {
        $this->c = & get_instance();
        $this->c->load->model(array('Tbl_users'));
        $result = $this->c->Tbl_users->find($opt, array(
            'fields' => array('a.*', 'b.group_id', 'c.name group_name', 'd.facebook', 'd.twitter', 'd.instagram', 'd.linkedin', 'd.img'),
            'conditions' => array($conditions['field'] => $conditions['value']),
            'joins' => array(
                array(
                    'table' => 'tbl_user_groups b',
                    'conditions' => 'b.user_id = a.id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_groups c',
                    'conditions' => 'c.id = b.group_id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_user_profiles d',
                    'conditions' => 'd.user_id = a.id',
                    'type' => 'left'
                )
            )
                )
        );
        $return = array('result' => array('content' => 'data not found ', 'param' => $conditions, 'status' => 'failed'));
        if (isset($result) && !empty($result)) {
            $return = array('result' => array('content' => $result, 'status' => 'success'));
        } else {
            $return = array('result' => array('content' => 'data not found ', 'param' => $conditions, 'status' => 'failed'));
        }
        return json_encode($return);
    }

    public function get_permission($conditions = null, $opt = 'all') {
        $this->c = & get_instance();
        $this->c->load->model(array('Tbl_groups'));
        $result = $this->c->Tbl_groups->find($opt, array(
            'fields' => array('a.*', 'b.is_allowed permission_allowed', 'b.is_public permission_public', 'c.class', 'c.action'),
            'conditions' => array($conditions['field'] => $conditions['value'], 'b.is_allowed' => 1),
            'joins' => array(
                array(
                    'table' => 'tbl_group_permissions b',
                    'conditions' => 'b.group_id = a.id',
                    'type' => 'left'
                ),
                array(
                    'table' => 'tbl_permissions c',
                    'conditions' => 'c.id = b.permission_id',
                    'type' => 'left'
                )
            )
                )
        );
        $res = array();
        if ($result) {
            foreach ($result AS $keyword => $value) {
                $res[] = array(
                    'class' => $value['class'],
                    'action' => $value['action'],
                    'is_allowed' => $value['permission_allowed'],
                    'is_public' => $value['permission_public']
                );
            }
        }
        $return = array('result' => array('content' => 'data not found ', 'param' => $conditions, 'status' => 'failed'));
        if (isset($res) && !empty($res)) {
            $return = array('result' => array('content' => $res, 'status' => 'success'));
        } else {
            $return = array('result' => array('content' => 'data not found ', 'param' => $conditions, 'status' => 'failed'));
        }
        return json_encode($return);
    }

    public function destroy_session($session = array(), $sess_name = null) {
        $CI = & get_instance();
        $CI->load->model(array('Tbl_users'));
        //check if session is exist
        if ($session['is_logged_in'] == true) {
            //update tbl_users is_logged_in true
            $CI->Tbl_users->update(array('is_logged_in' => 0), $session['user_id']);
            $CI->session->unset_userdata($sess_name);
            $this->unlock_screen();
            $CI->session->sess_destroy();
        }
    }

    public function lock_screen() {
        $CI = & get_instance();
        $array = array(
            'user_id' => base64_encode($_SESSION[$CI->config->session_name]['user_id']),
            'username' => $_SESSION[$CI->config->session_name]['username'],
            'email' => $_SESSION[$CI->config->session_name]['email'],
            'create_date' => date_now(),
            'status' => true
        );
        if (isset($_SESSION[$CI->config->session_name . '_lock_screen']) && !empty($_SESSION[$CI->config->session_name . '_lock_screen'])) {
            //if session with name exist, then remove and re-create
            unset($_SESSION[$CI->config->session_name . '_lock_screen']);
        }
        $_SESSION[$CI->config->session_name . '_lock_screen'] = $array;
    }

    public function unlock_screen($data = array()) {
        $CI = & get_instance();
        $verify = $this->verify_user_unlock($data);
        $return = false;
        if ($verify == true) {
            if (isset($_SESSION[$CI->config->session_name . '_lock_screen']) && !empty($_SESSION[$CI->config->session_name . '_lock_screen'])) {
                //if session with name exist, then remove and re-create
                unset($_SESSION[$CI->config->session_name . '_lock_screen']);
                $return = true;
            }
        }
        return $return;
    }

    public function verify_user_unlock($data = array()) {
        $return = false;
        if ($data) {
            $cond = array('field' => 'id', 'value' => base64_decode($data['id']));
            $user = $this->get_user_by($cond, 'all');
            $res = json_decode($user);
            if ($res->result->status == 'success') {
                $userid = $res->result->content->username;
                $pass_hashed = $res->result->content->password;
                //verfiy password
                if (password_verify(base64_decode($data['password']), $pass_hashed)) {
                    $return = true;
                }
            }
        }
        return $return;
    }

    public function register($data = array(), $profile = 'default', $type = 'user') {
        if ($data) {
            $CI = & get_instance();
            $CI->load->model(array('Tbl_users', 'Tbl_user_groups', 'Tbl_email_layout'));
            $first_name = strtolower(trim($data['first_name']));
            $email = strtolower(trim($data['email']));
            $last_name = strtolower(trim($data['last_name']));
            $group_id = 2;
            if ($type == 'club') {
                $first_name = strtolower(trim($data['first_name']));
                $last_name = $type;
                $group_id = 3;
            }
            $activation_code = generate_code(32);
            $hash_password = $this->hash_password($data['password']);
            $arr_insert = array(
                'username' => $first_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $hash_password,
                'activation_code' => $activation_code,
                'status' => 3,
                'is_active' => 0,
                'is_logged_in' => 0,
                'created_by' => 1,
                'create_date' => date_now()
            );
            $user_id = $CI->Tbl_users->insert_return_id($arr_insert);
            $reply_to = 'noreply@netofcreatives.com';
            $return_url = base_pesky_url('login');
            if ($user_id) {
                $arr_user_group = array(
                    'user_id' => $user_id,
                    'group_id' => $group_id,
                    'is_active' => 0,
                    'created_by' => $user_id,
                    'create_date' => date_now()
                );
                $result = $CI->Tbl_user_groups->insert($arr_user_group);
                if ($result) {
                    $encrypt_data = '&activation_code=' . $activation_code . '&p=' . $hash_password . '&r=' . $return_url;
                    $email_layout = $CI->Tbl_email_layout->find('first', array('conditions' => array('keyword' => 'user_activation')));
                    $email_content = '';
                    $email_content .= str_replace('[date]', gmdate('d/m/Y H:i:s', time() + 60 * 60 * 7), $email_layout);
                    $email_content .= str_replace('[email]', $email, $email_layout);
                    $email_content .= str_replace('[username]', $first_name, $email_layout);
                    $email_content .= str_replace('[password]', $data['password'], $email_layout);
                    $email_content .= str_replace('[activation_link]', base_pesky_url('account-activate?id=' . $user_id . $encrypt_data), $email_layout);

                    $email_data = array(
                        'user_id' => $user_id,
                        'group_id' => $group_id,
                        'username' => $first_name,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'title_for_email' => 'Your account successfully create at Pesky IndoTimingSport',
                        'caption_for_email' => 'Please click this link to activate your account.',
                        'footer' => 'Please do not reply this email, this is auto send by system',
                        'content' => $email_content
                    );
                    $option = array(
                        'layout' => 'layouts/email/user_activation.phtml',
                        'subject' => 'User account activation',
                        'reply_to' => $reply_to
                    );
                    $from = array('admin@netofcreatives.com', 'Admin');

                    $CI->oreno_mail->send($email_data, $from, $email, $option, array());
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

}
