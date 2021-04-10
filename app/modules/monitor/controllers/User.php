<?php

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect(base_url('login'));
    }

    public function dashboard() {
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/amcharts.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/serial.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/pie.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/radar.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/themes/light.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/themes/patterns.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amcharts/themes/chalk.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/ammap/ammap.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js'),
            static_url('templates/metronics/assets/global/plugins/amcharts/amstockcharts/amstock.js')
        );
        $this->load_js($js_files);
        $data['title_for_layout'] = 'welcome to dashbohard';
        $this->parser->parse('layouts/pages/metronic_horizontal.phtml', $data);
    }

    public function get_data() {
        $this->load->model('Tbl_users');
        $res = $this->Tbl_users->find('first', array(
            'fields' => array('a.id', 'a.username', 'a.first_name', 'a.last_name', 'a.email', 'a.is_active act_status', 'b.*', 'd.name group_name'),
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

    public function my_profile() {
        $data['title_for_layout'] = 'welcome';
        //load ajax var
        $var = array(
            array(
                'keyword' => 'wew',
                'value' => '1234'
            )
        );
        $this->load_ajax_var($var);
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
        //load ajax var
        $var = array(
            array(
                'keyword' => 'wew',
                'value' => '1234'
            )
        );
        $this->load_ajax_var($var);
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

    public function get_total_ticket_per_month() {
        $this->load->model('Tbl_helpdesk_tickets');
        $year = date('Y');
        $ticket_date = $this->Tbl_helpdesk_tickets->query("SELECT id, YEAR(create_date) AS year, MONTH(create_date) AS month, MONTHNAME(create_date) AS 'month_name' FROM tbl_helpdesk_tickets WHERE create_date LIKE '{$year}%' GROUP BY month_name ORDER BY month ASC");
        $arr_chart = array();
        foreach ($ticket_date AS $key => $val) {
            $dt = $val['year'] . '-' . str_pad($val['month'], 2, '0', STR_PAD_LEFT);
            $ticket_list = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(id) AS total FROM tbl_helpdesk_tickets WHERE is_active = 1 AND create_date LIKE '{$dt}%'");
            $arr_chart[] = array(
                'month' => $val['month_name'],
                'total' => (int) $ticket_list[0]['total']
            );
        }
        echo json_encode($arr_chart);
    }
    
    public function get_total_ticket_per_month_by_status(){
        $this->load->model('Tbl_helpdesk_tickets');
        $year = date('Y');
        $ticket_date = $this->Tbl_helpdesk_tickets->query("SELECT id, YEAR(create_date) AS year, MONTH(create_date) AS month, MONTHNAME(create_date) AS 'month_name' 
            FROM tbl_helpdesk_tickets 
            LEFT JOIN 
        ");
        $arr_chart = array();
        foreach ($ticket_date AS $key => $val) {
            $dt = $val['year'] . '-' . str_pad($val['month'], 2, '0', STR_PAD_LEFT);
            $ticket_list = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(id) AS total FROM tbl_helpdesk_tickets WHERE is_active = 1 AND create_date LIKE '{$dt}%'");
            $arr_chart[] = array(
                'month' => $val['month_name'],
                'total' => (int) $ticket_list[0]['total']
            );
        }
        echo json_encode($arr_chart);
    }

}
