<?php

require_once DOCUMENT_ROOT . '/var/static/lib/packages/phpexcel/autoload.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Description of Ticket
 *
 * @author SuperUser
 */
class Ticket extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_tickets'));
    }

    public function index() {
        redirect(base_url('helpdesk/report/ticket/category/'));
    }

    public function by_category() {
        $data['title_for_layout'] = 'Ticket reporting page by Category';
        $data['view-header-title'] = 'Ticket reporting page by Category';
        $data['content'] = 'ini kontent web';
        //load ajax var
        $var = array(
            array(
                'keyword' => 'export_file_name',
                'value' => 'LAPORAN TIKET HELPDESK'
            )
        );
        $this->load_ajax_var($var);
        $css_files = array(
            'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jquery.dataTables.min.css'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.dataTables.min.css'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/select.dataTables.min.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('templates/metronics/assets/global/scripts/datatable.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jquery.dataTables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/dataTables.buttons.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.flash.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.colVis.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.print.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jszip.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/pdfmake.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/vfs_fonts.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.html5.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/dataTables.select.min.js')
        );
        $this->load_js($js_files);
        $this->load->model(array('Tbl_helpdesk_ticket_status', 'Tbl_helpdesk_ticket_priorities', 'Tbl_helpdesk_ticket_categories'));
        $data['status'] = $this->Tbl_helpdesk_ticket_status->find('list', array('conditions' => array('is_active' => 1)));
        //$data['priority'] = $this->Tbl_helpdesk_ticket_priorities->find('list', array('conditions' => array('is_active' => 1)));
        $data['category'] = $this->Tbl_helpdesk_ticket_categories->find('list', array('conditions' => array('is_active' => 1, 'a.level' => 1)));
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function by_ticket() {
        $data['title_for_layout'] = 'Ticket reporting page by Category';
        $data['view-header-title'] = 'Ticket reporting page by Category';
        $data['content'] = 'ini kontent web';
        //load ajax var
        $var = array(
            array(
                'keyword' => 'export_file_name',
                'value' => 'export_ticket_report_' . date_now()
            )
        );
        $this->load_ajax_var($var);
        $css_files = array(
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jquery.dataTables.min.css'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.dataTables.min.css'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/select.dataTables.min.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jquery.dataTables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/dataTables.buttons.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.flash.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.colVis.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.print.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jszip.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/pdfmake.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/vfs_fonts.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.html5.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/dataTables.select.min.js')
        );
        $this->load_js($js_files);
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function by_date() {
        $data['title_for_layout'] = 'Ticket reporting page by Date';
        $data['view-header-title'] = 'Ticket reporting page by Date';
        $data['content'] = 'ini kontent web';
        //load ajax var
        $var = array(
            array(
                'keyword' => 'export_file_name',
                'value' => 'export_ticket_report_' . date_now()
            )
        );
        $this->load_ajax_var($var);
        $css_files = array(
            'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jquery.dataTables.min.css'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.dataTables.min.css'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/select.dataTables.min.css')
        );
        $this->load_css($css_files);
        $js_files = array(
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jquery.dataTables.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/dataTables.buttons.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.flash.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.colVis.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.print.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/jszip.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/pdfmake.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/vfs_fonts.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/buttons.html5.min.js'),
            static_url('templates/metronics/assets/global/plugins/datatables/plugins/dataTables.select.min.js')
        );
        $this->load_js($js_files);
        $this->load->model(array('Tbl_helpdesk_ticket_status', 'Tbl_helpdesk_ticket_priorities', 'Tbl_helpdesk_ticket_categories'));
        $data['status'] = $this->Tbl_helpdesk_ticket_status->find('list', array('conditions' => array('is_active' => 1)));
        $data['priority'] = $this->Tbl_helpdesk_ticket_priorities->find('list', array('conditions' => array('is_active' => 1)));
        $data['category'] = $this->Tbl_helpdesk_ticket_categories->find('list', array('conditions' => array('is_active' => 1)));

        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function get_list() {
        $post = $this->input->post(NULL, TRUE);
        $get = $this->input->post_get(NULL, TRUE);
        $output = array(
            'draw' => 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => array(),
        );
        if (isset($post) && !empty($post)) {
            $user = (int) base64_decode($this->auth_config->user_id);
            //init config for datatables
            $draw = $post['draw'];
            $start = $post['start'];
            $length = $post['length'];
            $tbl_name = 'tbl_helpdesk_tickets a';
            $conditions = '';
            $param3 = false;
            if (isset($post['param1']) && !empty($post['param1'])) {
                if (!empty($post['param1']['from_date']) && !empty($post['param1']['to_date'])) {
                    $conditions .= " AND a.create_date >= '" . date('Y-m-d H:i:s', strtotime($post['param1']['from_date'])) . "' AND a.create_date <= '" . date('Y-m-d H:i:s', strtotime('+1day', strtotime($post['param1']['to_date']))) . "'";
                }
                if (!empty($post['param1']['ticket_status'])) {
                    $conditions .= " AND c.id = " . $post['param1']['ticket_status'] . "";
                }
                if (!empty($post['param1']['ticket_category'])) {
                    $conditions .= " AND f.id = " . $post['param1']['ticket_category'] . "";
                }
                if (!empty($post['param1']['problem_subject'])) {
                    $conditions .= " AND g.id = " . $post['param1']['problem_subject'] . "";
                }
                $jnt = 'LEFT JOIN (SELECT messages As response_message, ticket_id, min(create_date) FROM tbl_helpdesk_ticket_chats l WHERE is_vendor != 0 GROUP BY ticket_id) AS l ON l.ticket_id = a.id';
                $f = ',l.response_message';
                $act = ' LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start,   solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d WHERE d.is_active = 1)) AS d ON d.ticket_id = a.id';
            } elseif (isset($post['param3']) && !empty($post['param3'])) {
                $param3 = true;
                $conditions = 'AND a.code LIKE "%' . $post['param3']['code'] . '%" AND b.status_id = 5';
                // $group = ' ';
                $jnt = '';
                $f = '';
                $act = 'LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start, solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d GROUP BY ticket_id)) AS d ON d.ticket_id = a.id';
            }
            $fields = 'a.*, b.status_id, c.name ticket_status,e.name priority_name, f.name category_name,p.first_name,i.fine_result,i.response_time,i.solving_time,o.close_message,o.response_time_start, o.response_time_stop,o.solving_time_start, o.solving_time_stop, j.job_list,j.message,k.name, m.first_name created_by,k.phone_number,n.ticket_id ticket,d.solving_stop,d.solving_start,d.response_stop,d.response_start,g.name job_category_name' . $f;
            $joins = '
            LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id 
            LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id 
           ' . $act . '
            LEFT JOIN tbl_helpdesk_ticket_priorities e ON e.id = b.priority_id
            LEFT JOIN tbl_helpdesk_ticket_categories f ON f.id = b.category_id
            LEFT JOIN tbl_helpdesk_ticket_categories g ON g.id = b.job_id
            LEFT JOIN tbl_helpdesk_ticket_rules i ON i.id = b.rule_id
            LEFT JOIN (SELECT ticket_id, job_list, message FROM tbl_helpdesk_ticket_requests j WHERE create_date IN (SELECT max(create_date) FROM tbl_helpdesk_ticket_requests j WHERE j.is_active = 1)) AS j ON j.ticket_id = a.id
            LEFT JOIN tbl_helpdesk_office_branchs k ON k.id = b.branch_id
            LEFT JOIN tbl_helpdesk_ticket_reopen_logs n ON n.ticket_id = a.id AND n.is_active = 1
            LEFT JOIN tbl_helpdesk_activities o ON o.ticket_id = a.id AND o.is_active = 1
            LEFT JOIN tbl_users p ON p.id = o.created_by
            ' . $jnt . '
            LEFT JOIN tbl_users m ON m.id = a.created_by ';
            $where = 'WHERE c.is_active = 1 AND a.created_by =' . $user . '';
            $query_total = "
                SELECT `a`.`id`
                FROM `tbl_helpdesk_tickets` `a`
                LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                LEFT JOIN `tbl_helpdesk_ticket_status` `c` ON `c`.`id` = `b`.`status_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `f` ON `f`.`id` = `b`.`job_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `g` ON `g`.`id` = `b`.`category_id`
                LEFT JOIN `tbl_helpdesk_ticket_priorities` `h` ON `h`.`id` = `b`.`priority_id`
                $where $conditions";
            debug($query_total);
            $total_rows = count($this->Tbl_helpdesk_tickets->query($query_total));
            $res = $this->Tbl_helpdesk_tickets->query("SELECT {$fields} FROM {$tbl_name} {$joins} {$where} {$conditions} LIMIT {$start}, {$length}"); // ORDER BY a.create_date DESC GROUP BY a.id  ORDER BY a.create_date DESC GROUP BY a.id
            if (isset($res) && !empty($res) && $res != null) {
                // $cond_count = $this->Tbl_helpdesk_tickets->query("SELECT COUNT(*) total FROM {$tbl_name} {$joins} {$conditions}");
                // $total_rows = $cond_count[0]['total'];
                $arr = array();
                if (isset($res) && !empty($res)) {
                    $this->load->library('oreno_sla');
                    $i = $start + 1;
                    foreach ($res as $d) {
                        $action_status = 'Tidak Aktif';
                        if ($d['is_active'] == 1) {
                            $action_status = 'Aktif';
                        }
                        $status = 'Tidak';
                        if ($d['ticket'] != null) {
                            $status = 'Ya';
                        }
                        if ($d['solving_time_stop'] == "0000-00-00 00:00:00") {
                            $solving_date =  "-";
                            $solving_time =  "-";
                        }else{
                            $solving_date = date('d/m/Y', strtotime($d['solving_time_stop']));
                            $solving_time = date('H:i:s', strtotime($d['solving_time_stop']));
                        }
                        if ($d['response_time_stop'] == "0000-00-00 00:00:00") {
                            $response_date =  "-";
                            $response_time =  "-";
                        }else{
                            $response_date = date('d/m/Y', strtotime($d['response_time_stop']));
                            $response_time = date('H:i:s', strtotime($d['response_time_stop']));
                        }
                        $response_time_start = $d['response_time_start'];
                        $response_time_stop = $d['response_time_stop'];
                        $solving_time_start = $d['solving_time_start'];
                        $solving_time_stop = $d['solving_time_stop'];
                        if($solving_time_stop == "0000-00-00 00:00:00"){
                             $solving_time_stop = $solving_time_start;
                        };
                        $total_response = fn_date_diff_ticket($response_time_start, $response_time_stop, 'all');
                        $total_solving = fn_date_diff_ticket($solving_time_start, $solving_time_stop, 'all');
                        $data['num'] = $i;
                        $data['code'] = $d['code']; //optional
                        $data['category'] = $d['category_name']; //optional
                        $data['sub_category'] = $d['job_category_name']; //optional
                        $data['priority'] = $d['priority_name']; //optional
                        $data['content'] = substr($d['content'], 0, 80); //optional
                        $data['status'] = $d['ticket_status']; //optional
                        $data['response'] = isset($d['response_message']) ? $d['response_message'] : ''; //optional
                        $data['vendor'] = $d['first_name']; //optional
                        $data['closing'] = isset($d['close_message']) ? $d['close_message'] : '-'; //optional
                        $data['kanim'] = $d['name']; //optional
                        $data['creator'] = $d['created_by']; //optional
                        $data['contact'] = $d['phone_number']; //optional
                        $data['open_date'] = date('d/m/Y', strtotime($d['create_date']));
                        $data['open_time'] = date('H:i:s', strtotime($d['create_date']));
                        $data['response_date'] =  $response_date;
                        $data['response_time'] =  $response_time;
                        $data['closing_date'] = $solving_date;
                        $data['closing_time'] = $solving_time;
                        $data['total_response'] = get_detail_date($total_response);
                        $data['total_solving'] = get_detail_date($total_solving);
                        $data['job'] = $d['job_list']; //optional
                        $data['create'] = idn_date($d['create_date']); //optional
                        $data['status_ticket'] = $status; //optional   
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
                echo json_encode($output);
            } else {
                echo json_encode($output);
            }
        } else {
            echo json_encode($output);
        }
    }

    public function get_category($id = null) {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $this->load->model(array('Tbl_helpdesk_ticket_categories'));
            $id = base64_decode($post['id']);
            $result = $this->Tbl_helpdesk_ticket_categories->find('all', array(
                'conditions' => array('is_active' => 1, 'parent_id' => $id)
                    )
            );
            if (isset($result) && !empty($result)) {
                $arr = '<option value="0">-- select one --</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
                echo $arr;
            } else {
                echo '';
            }
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

    public function delete() {
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            if (is_array($post['id'])) {
                $arr_res = 1;
                foreach ($post['id'] AS $key => $val) {
                    $arr_res = $this->Tbl_helpdesk_tickets->delete($val);
                }
                if ($arr_res == true) {
                    echo 'success';
                } else {
                    echo 'failed';
                }
            } else {
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

    public function gen_to_pdf() {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
            $user = (int) base64_decode($this->auth_config->user_id);
            $tbl_name = 'tbl_helpdesk_tickets a';
            $conditions = '';
            if (!empty($post['param1']['from_date']) && !empty($post['param1']['to_date'])) {
                    $conditions .= " AND a.create_date >= '" . date('Y-m-d H:i:s', strtotime($post['param1']['from_date'])) . "' AND a.create_date <= '" . date('Y-m-d H:i:s', strtotime('+1day', strtotime($post['param1']['to_date']))) . "'";
                }
                if (!empty($post['param1']['ticket_status'])) {
                    $conditions .= " AND c.id = " . $post['param1']['ticket_status'] . "";
                }
                if (!empty($post['param1']['ticket_category'])) {
                    $conditions .= " AND f.id = " . $post['param1']['ticket_category'] . "";
                }
                if (!empty($post['param1']['problem_subject'])) {
                    $conditions .= " AND g.id = " . $post['param1']['problem_subject'] . "";
                }
                $jnt = 'LEFT JOIN (SELECT messages As response_message, ticket_id, min(create_date) FROM tbl_helpdesk_ticket_chats l WHERE is_vendor != 0 GROUP BY ticket_id) AS l ON l.ticket_id = a.id';
                $f = ',l.response_message';
                $act = ' LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start,   solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d WHERE d.is_active = 1)) AS d ON d.ticket_id = a.id';
                $fields = 'a.*, b.status_id, c.name ticket_status,e.name priority_name, f.name category_name,p.first_name,i.fine_result,i.response_time,i.solving_time,o.close_message,o.response_time_start, o.response_time_stop,o.solving_time_start, o.solving_time_stop, j.job_list,j.message,k.name office_name,k.address, m.first_name created_by,k.phone_number,n.ticket_id ticket,d.solving_stop,d.solving_start,d.response_stop,d.response_start,g.name job_category_name' . $f;
                $joins = '
            LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id 
            LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id 
           ' . $act . '
            LEFT JOIN tbl_helpdesk_ticket_priorities e ON e.id = b.priority_id
            LEFT JOIN tbl_helpdesk_ticket_categories f ON f.id = b.category_id
            LEFT JOIN tbl_helpdesk_ticket_categories g ON g.id = b.job_id
            LEFT JOIN tbl_helpdesk_ticket_rules i ON i.id = b.rule_id
            LEFT JOIN (SELECT ticket_id, job_list, message FROM tbl_helpdesk_ticket_requests j WHERE create_date IN (SELECT max(create_date) FROM tbl_helpdesk_ticket_requests j WHERE j.is_active = 1)) AS j ON j.ticket_id = a.id
            LEFT JOIN tbl_helpdesk_office_branchs k ON k.id = b.branch_id
            LEFT JOIN tbl_helpdesk_ticket_reopen_logs n ON n.ticket_id = a.id AND n.is_active = 1
            LEFT JOIN tbl_helpdesk_activities o ON o.ticket_id = a.id AND o.is_active = 1
            LEFT JOIN tbl_users p ON p.id = o.created_by
            ' . $jnt . '
            LEFT JOIN tbl_users m ON m.id = a.created_by ';
            $where = 'WHERE c.is_active = 1 AND a.created_by =' . $user . '';
            $res = $this->Tbl_helpdesk_tickets->query("SELECT {$fields} FROM {$tbl_name} {$joins} {$where} {$conditions}"); 
            if (isset($res) && !empty($res)) {
                require_once DOCUMENT_ROOT . '/var/static/lib/packages/TCPDF/tcpdf.php';
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                // set document inform
                $pdf->SetTitle('LAPORAN HELPDESK ' . date_now());
                // set default header data
                $pdf->SetHeaderData(null, null, 'LAPORAN TIKET HELPDESK', null);
                

                // set header and footer fonts
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                // set default monospaced font
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set font
                $pdf->SetFont('helvetica', 'B', 20);

                // add a page
                $pdf->AddPage();

                // $pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

                $pdf->SetFont('helvetica', '', 8);
                                // set some text to print


                // -----------------------------------------------------------------------------
                $result = '
                    <style>
                    .a1{
                        border:1px solid #ccc; 
                        text-align:left; 
                        width: 22%;
                    }
                    .a2{
                        border:1px solid #ccc; 
                        text-align:left; 
                        width: 3%;
                    }
                    .a3{
                        border:1px solid #ccc; 
                        text-align:left; 
                        width: 25%;
                    }
                    .a4{
                        border:1px solid #ccc; 
                        text-align:left; 
                        width: 100%;
                    }
                    .a5{
                        border:1px solid #ccc; 
                        text-align:left; 
                        width: 50%;
                    }
                    .a6{
                        border:1px solid #ccc; 
                        text-align:left; 
                        width: 33.333%;
                    }
                    </style>
                ';
                // letterhead
                $Logo1 = static_url('images\logo\logo-imigrasi.png');
                $Logo2 = static_url('images\logo\logo_pengayoman.png');
                $txt = '<table class="table" style="width:100%;">                         
                            <tr>
                                <th rowspan="3" style="width:15%;"><img src="' . $Logo2 . '" height="80" width="80"/></th>
                                <td style="width:70%;text-align:center; font-size:12">KEMENTERIAN HUKUM DAN HAM REPUBLIK INDONESIA</td>
                                <th rowspan="3" style="width:15%;"><img src="' . $Logo1 . '" height="80" width="80"/></th>
                            </tr>
                            <tr>
                                <td style="text-align:center; font-size:12">'.$res[0]['office_name'].'</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; font-size:8">'.$res[0]['address'].'</td>
                            </tr>
                        </table>';

                // print letterhead
                $pdf->writeHTML($txt, true, false, true, false, '');
                //$result .= '';
                // NON-BREAKING TABLE (nobr="true")
                $arr = array();
                $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_handlers', 'Tbl_users', 'Tbl_helpdesk_ticket_problem_impacts', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_chats'));
                foreach ($res as $val) {
                    if(isset($result)){ $result .= '<div style="clear:both"><h3>Laporan Tiket (' . $val['code'] . ')</h3></div>'; }
                $status = 'Tidak';
                        if ($val['ticket'] != null) {
                            $status = 'Ya';
                        }
                    $history = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('a.ticket_id' => $val['id'], 'a.created_by' => 0),
                        'order' => array('key' => 'a.create_date', 'type' => 'ASC'),
                        'joins' => array(
                            array(
                                'table' => 'tbl_users b',
                                'conditions' => 'b.id = a.created_by',
                                'type' => 'left'
                            )
                        )
                            )
                    );
                    $chat = $this->Tbl_helpdesk_ticket_chats->find('all', array(
                        'fields' => array('a.*', 'b.username', 'b.email user_email'),
                        'conditions' => array('ticket_id' => $val['id'], 'a.created_by !=' => 0),
                        'order' => array('key' => 'a.create_date', 'type' => 'ASC'),
                        'joins' => array(
                            array(
                                'table' => 'tbl_users b',
                                'conditions' => 'b.id = a.created_by',
                                'type' => 'left'
                            )
                        )
                            )

                    );
                    $result .= '
                        <table class="table" style="width:100%; border:1px solid #ccc;padding:5px">
                            <tr>
                              <th style="border:1px solid #ccc; text-align:center" colspan="6">Detail Tiket</th>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Kode</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['code'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Petugas KSO</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['first_name'] . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Status</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['ticket_status'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Detail Pekerjaan</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['job_list'] . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Prioritas</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['priority_name'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Tanggal di buat</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . idn_date( $val['create_date']) . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Kategori</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['category_name'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Pelapor</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['created_by'] . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Sub Kategori</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['job_category_name'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Re-Open</span></td>
                              <td class="a2"></td>
                              <td class="a3">'.$status.'</td>
                            </tr>
                            <tr>
                              <td class="a4" colspan="6"><span style="font-weight:bold">Detail Permasalahan : </span></td>
                            </tr>
                            <tr>
                              <td class="a4" colspan="6">' . $val['content'] . '</td>
                            </tr>
                            <tr>
                              <td class="a4" colspan="6"><span style="font-weight:bold">Riwayat Tiket :</span><br></td>
                            </tr>
                            <tr>
                              <td class="a5" colspan="3"><span style="font-weight:bold">Tanggal</span></td>
                              <td class="a5" colspan="3"><span style="font-weight:bold">Aktivitas</span></td>
                            </tr>';
                            if(isset($history) && !empty($history)){
                                foreach ($history as $key => $val) {
                                    $result .= '
                                        <tr>
                                            <td class="a5" colspan="3">' . idn_date($val['create_date']) . '</td>
                                            <td class="a5" colspan="3">' . $val['messages'] . '</td>
                                          </tr>
                                        ';
                                }
                            }
                            $result .= '
                            <tr>
                              <td class="a4" colspan="6"><span style="font-weight:bold">Riwayat Percakapan :</span></td>
                            </tr>
                            <tr>
                              <td class="a6" colspan="2"><span style="font-weight:bold">User</span></td>
                              <td class="a6" colspan="2"><span style="font-weight:bold">Tanggal</span></td>
                              <td class="a6" colspan="2"><span style="font-weight:bold">Pesan</span></td>
                            </tr>';
                            if(isset($chat) && !empty($chat)){
                                foreach ($chat as $key => $val) {
                                    $result .= '
                                        <tr>
                                          <td class="a6" colspan="2">' . $val['username'] . '</td>
                                          <td class="a6" colspan="2">' . idn_date($val['create_date']) . '</td>
                                          <td class="a6" colspan="2">' . $val['messages'] . '</td>
                                        </tr>
                                    ';
                                }
                            }
                            $result .= '</table>';
                }
                $pdf->writeHTML($result, true, false, true, false, '');

                $filename = 'laporan_tiket_helpdesk_' . date('dmyhis') . '.pdf';
                $path = DOCUMENT_ROOT . '/var/static/documents/pdf/' . $filename;
                if (!is_dir(DOCUMENT_ROOT . '/var/static/documents/pdf/')) {
                    mkdir(DOCUMENT_ROOT . '/var/static/documents/pdf/', 0775);
                }
                $pdf->Output($path, 'F');
                echo static_url('documents/pdf/' . $filename);
            }
        }

    }

    public function generate() {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet(0);
        $sheet->setCellValue('A1', 'Hello World !');

        $spreadsheet->getActiveSheet()->setTitle('Report Excel ' . date('d-m-Y H'));
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Report Excel.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

}
