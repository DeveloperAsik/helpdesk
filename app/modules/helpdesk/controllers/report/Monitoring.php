<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of monitoring
 *
 * @author SuperUser
 */
class Monitoring extends MY_Controller{

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_tickets'));
    }

    public function index() {
        redirect(base_url('helpdesk/report/monitoring/view/'));
    }

    public function view() {
        $data['title_for_layout'] = 'welcome';
        $data['view-header-title'] = 'View monitoring List';
        $data['content'] = 'ini kontent web';
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
        // $variable =  array(
        //     array('id' => 1,'name'=>'test'),
        //     array('id' => 2,'name'=>'test2'),
        //     array('id' => 3,'name'=>'test3')
        // );
        // // untuk lempar di php (view html)
        // $data['var_data'] = $variable;
        
        // // untuk lempat di ajax (view js)
        // $arr = array(
        //     array(
        //         'keyword' =>'var_data',
        //         'value' =>  str_replace('"',"'",json_encode($variable))
        //     )
        // );
        // $this->load_ajax_var($arr);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_list() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->library('pagination');
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $search = trim($post['search']['value']);

            $cond_count = array();
            $cond['table'] = $cond_count['table'] = 'Tbl_helpdesk_tickets';
            if (isset($search) && !empty($search)) {
                $cond['like'] = $cond_count['like'] = array('a.name', $search);
            }
            $cond['fields'] = array('a.*');
            $cond['limit'] = array('perpage' => $length, 'offset' => $start);
            $total_rows = $this->Tbl_helpdesk_tickets->find('count', $cond_count);
            $config = array(
                'base_url' => base_url('vendor/report/monitoring/get_list/'),
                'total_rows' => $total_rows,
                'per_page' => $length,
            );
            $this->pagination->initialize($config);
            $res = $this->Tbl_helpdesk_tickets->find('all', $cond);
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $status = '';
                    if ($d['is_active'] == 1) {
                        $status = 'checked';
                    }
                    $action_status = '<div class="form-group">
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
                    $data['name'] = $d['name']; //optional	
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

    public function get_data() {
		$post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $res = $this->Tbl_helpdesk_tickets->find('first', array(
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
            $status = 0;
            if ($post['active'] == 'true') {
                $status = 1;
            }
            $arr_insert = array(
                'name' => $post['name'],
                'description' => $post['description'],
                'is_active' => $status,
                'created_by' => (int) base64_decode($this->auth_config->user_id),
                'create_date' => date_now()
            );
            $result = $this->Tbl_helpdesk_tickets->insert($arr_insert);
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
            $res = $this->Tbl_helpdesk_tickets->update($arr, base64_decode($post['id']));
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
            $res = $this->Tbl_helpdesk_tickets->update($arr, $id);
            if ($res == true) {
                echo 'success';
            } else {
                echo 'failed';
            }
        }
    }

    public function remove() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
			if(is_array($post['id'])){
				$arr_res = 1;
				foreach($post['id'] AS $key => $val){
					$arr_res = $this->Tbl_helpdesk_tickets->remove($val);
				}
				if($arr_res == true){
					echo 'success';
				} else {
					echo 'failed';
				}
			}else{
				$id = base64_decode($post['id']);
				$res = $this->Tbl_helpdesk_tickets->remove($id);
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
			if(is_array($post['id'])){
				$arr_res = 1;
				foreach($post['id'] AS $key => $val){
					$arr_res = $this->Tbl_helpdesk_tickets->delete($val);
				}
				if($arr_res == true){
					echo 'success';
				} else {
					echo 'failed';
				}
			}else{
				$id = base64_decode($post['id']);
				$res = $this->Tbl_helpdesk_tickets->delete($id);
				if ($res == true) {
					echo 'success';
				} else {
					echo 'failed';
				}
			}
        }
    }

    public function get_total_ticket_per_month() {
        $this->load->model(array('Tbl_helpdesk_tickets','tbl_helpdesk_ticket_handlers'));
        $user = (int) base64_decode($this->auth_config->user_id);
        $year = date('Y');
        $ticket_date = $this->Tbl_helpdesk_tickets->query("SELECT id, YEAR(create_date) AS year, MONTH(create_date) AS month, MONTHNAME(create_date) AS 'month_name' FROM tbl_helpdesk_tickets WHERE create_date LIKE '{$year}%' GROUP BY month_name ORDER BY month ASC");
        $arr_chart = array();
        foreach ($ticket_date AS $key => $val) {
            $dt = $val['year'] . '-' . str_pad($val['month'], 2, '0', STR_PAD_LEFT);
            $ticket_list = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(id) AS total FROM tbl_helpdesk_tickets WHERE is_active = 1 AND create_date LIKE '{$dt}%' AND created_by = {$user}");
            // debug($this->db->last_query());
            $arr_chart[] = array(
                'month' => $val['month_name'],
                'total' => (int) $ticket_list[0]['total']
            );
        }
        echo json_encode($arr_chart);
    }
    

    public function get_total_ticket_per_month_by_status(){
        $this->load->model(array('Tbl_helpdesk_ticket_status','Tbl_helpdesk_ticket_transactions'));
        $user = (int) base64_decode($this->auth_config->user_id);
        $year = date('Y');
        $ticket_status = $this->Tbl_helpdesk_ticket_transactions->query("SELECT a.id, a.name, COUNT(b.status_id) total FROM tbl_helpdesk_ticket_status a LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.status_id = a.id WHERE b.created_by = {$user} GROUP BY a.id ");
        // debug($ticket_status);
        // debug($this->db->last_query());
        $arr_chart = array();
        foreach ($ticket_status AS $key => $val) {
            $status_id = $val['id'];
            $ticket_list = $this->Tbl_helpdesk_ticket_transactions->query("SELECT COUNT(id) total FROM tbl_helpdesk_ticket_transactions WHERE status_id = {$status_id} AND created_by = {$user}");
            // debug($this->db->last_query());
            $arr_chart[] = array(
                'status' => $val['name'],
                'total' => (int) $ticket_list[0]['total']
            );
        }
        echo json_encode($arr_chart);
    }

    public function get_total_ticket_progress_per_month() {
        $this->load->model(array('Tbl_helpdesk_ticket_status','Tbl_helpdesk_ticket_transactions','Tbl_helpdesk_tickets'));
        $user = (int) base64_decode($this->auth_config->user_id);
        $year = date('Y');
        $ticket_date = $this->Tbl_helpdesk_tickets->query("SELECT id, YEAR(create_date) AS year, MONTH(create_date) AS month, MONTHNAME(create_date) AS 'month_name' FROM tbl_helpdesk_tickets WHERE create_date LIKE '{$year}%' GROUP BY month_name ORDER BY month ASC");
        $arr_chart = array();
        foreach ($ticket_date AS $key => $val) {
            $dt = $val['year'] . '-' . str_pad($val['month'], 2, '0', STR_PAD_LEFT);
            $ticket_list = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(a.id) AS total FROM tbl_helpdesk_tickets a LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id WHERE a.created_by = {$user} AND a.create_date LIKE '{$dt}%' AND b.status_id = 2");
            // debug($this->db->last_query());
            $arr_chart[] = array(
                'month' => $val['month_name'],
                'total' => (int) $ticket_list[0]['total']
            );
        }
        // debug($arr_chart);
        echo json_encode($arr_chart);
    }


}
