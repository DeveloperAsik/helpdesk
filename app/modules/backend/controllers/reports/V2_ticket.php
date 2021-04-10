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
 * Description of V2_ticket
 *
 * @author SuperUser
 */
class V2_ticket extends MY_Controller {

//put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_tickets', 'tbl_helpdesk_ticket_transactions', 'tbl_helpdesk_ticket_status', 'tbl_helpdesk_activities', 'tbl_helpdesk_ticket_priorities', 'tbl_helpdesk_ticket_categories'));
    }

    public function index() {
        redirect(base_backend_url('reports/v2_ticket/category/'));
    }

    public function by_category() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_report_by_category');
        $data['view-header-title'] = $this->lang->line('global_header_title_report_by_category');
        //load ajax var
        $var = array(
            array(
                'keyword' => 'export_file_name',
                'value' => strtoupper('export_ticket_report_' . gmdate('Y_m_d_h_i_s'))
            )
        );
        $this->load_ajax_var($var);
        $css_files = array(
            static_url('lib/packages/jquery-ui/jquery-ui.min.css'),
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
        $data['category'] = $this->Tbl_helpdesk_ticket_categories->find('list', array('conditions' => array('is_active' => 1, 'a.level' => 1)));
        $this->parser->parse('layouts/pages/metronic.phtml', $data);
    }

    public function by_ticket() {
        $data['title_for_layout'] = $this->lang->line('global_title_for_layout_report_by_ticket');
        $data['view-header-title'] = $this->lang->line('global_header_title_report_by_ticket');
        //load ajax var
        $var = array(
            array(
                'keyword' => 'export_file_name',
                'value' => strtoupper('export_ticket_report_' . gmdate('Y_m_d_h_i_s'))
            )
        );
        $this->load_ajax_var($var);
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
        $output = array(
            'draw' => 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => array(),
        );
        if (isset($post) && !empty($post)) {
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
                $jnt = 'LEFT JOIN tbl_helpdesk_ticket_chats l ON l.ticket_id = a.id';
                $f = ',l.messages AS response_message';
                $act = ' LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start, solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d WHERE d.is_active = 1 GROUP BY id)) AS d ON d.ticket_id = a.id';
            } elseif (isset($post['param3']) && !empty($post['param3'])) {
                $param3 = true;
                $conditions .= ' AND a.code LIKE "%' . $post['param3']['code'] . '%" AND b.status_id = 4';
                $jnt = '';
                $f = '';
                $act = 'LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start, solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d WHERE is_active = 1 GROUP BY id)) AS d ON d.ticket_id = a.id';
            }
            $fields = 'a.*, b.status_id, c.name ticket_status,e.name priority_name, f.name category_name,p.first_name,i.fine_result,i.response_time,i.solving_time,o.close_message,o.response_time_start, o.response_time_stop,o.solving_time_start, o.solving_time_stop, j.job_list, j.message,k.name, m.first_name created_by,k.phone_number,n.ticket_id ticket,d.solving_stop,d.solving_start,d.response_stop,d.response_start,g.name job_category_name' . $f;
            $joins = '
            LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id 
            LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id 
           ' . $act . '
            LEFT JOIN tbl_helpdesk_ticket_priorities e ON e.id = b.priority_id
            LEFT JOIN tbl_helpdesk_ticket_categories f ON f.id = b.category_id
            LEFT JOIN tbl_helpdesk_ticket_categories g ON g.id = b.job_id
            LEFT JOIN tbl_helpdesk_ticket_rules i ON i.id = b.rule_id
            LEFT JOIN tbl_helpdesk_ticket_requests j ON j.ticket_id = a.id 
            LEFT JOIN tbl_helpdesk_office_branchs k ON k.id = b.branch_id
            LEFT JOIN tbl_helpdesk_ticket_reopen_logs n ON n.ticket_id = a.id AND n.is_active = 1
            LEFT JOIN tbl_helpdesk_activities o ON o.ticket_id = a.id AND o.is_active = 1
            LEFT JOIN tbl_users p ON p.id = o.created_by
            ' . $jnt . '
            LEFT JOIN tbl_users m ON m.id = a.created_by ';
            $where = 'WHERE c.is_active = 1';
            $query_total = "
                SELECT `a`.`id`
                FROM `tbl_helpdesk_tickets` `a`
                LEFT JOIN `tbl_helpdesk_ticket_transactions` `b` ON `b`.`ticket_id` = `a`.`id`
                LEFT JOIN `tbl_helpdesk_ticket_status` `c` ON `c`.`id` = `b`.`status_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `f` ON `f`.`id` = `b`.`job_id`
                LEFT JOIN `tbl_helpdesk_ticket_categories` `g` ON `g`.`id` = `b`.`category_id`
                LEFT JOIN `tbl_helpdesk_ticket_priorities` `h` ON `h`.`id` = `b`.`priority_id`
                $where $conditions";
            $total_rows = count($this->Tbl_helpdesk_tickets->query($query_total));

            $res = $this->Tbl_helpdesk_tickets->query("SELECT {$fields} FROM {$tbl_name} {$joins} {$where} {$conditions} LIMIT {$start}, {$length}"); // ORDER BY a.create_date DESC GROUP BY a.id  ORDER BY a.create_date DESC GROUP BY a.id
            // debug($this->db->last_query());
            if (isset($res) && !empty($res) && $res != null) {
                $arr = array();
                if (isset($res) && !empty($res)) {
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
                            $solving_date = "-";
                            $solving_time = "-";
                        } else {
                            $solving_date = date('d/m/Y', strtotime($d['solving_time_stop']));
                            $solving_time = date('H:i:s', strtotime($d['solving_time_stop']));
                        }
                        if ($d['response_time_stop'] == "0000-00-00 00:00:00") {
                            $response_date = "-";
                            $response_time = "-";
                        } else {
                            $response_date = date('d/m/Y', strtotime($d['response_time_stop']));
                            $response_time = date('H:i:s', strtotime($d['response_time_stop']));
                        }
                        $response_time_start = $d['response_time_start'];
                        $response_time_stop = $d['response_time_stop'];
                        $solving_time_start = $d['solving_time_start'];
                        $solving_time_stop = $d['solving_time_stop'];
                        if ($response_time_stop == "0000-00-00 00:00:00") {
                            $response_time_stop = $response_time_start;
                        }
                        if ($solving_time_stop == "0000-00-00 00:00:00") {
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
                        $data['response_date'] = $response_date;
                        $data['response_time'] = $response_time;
                        $data['closing_date'] = $solving_date;
                        $data['closing_time'] = $solving_time;
                        $data['total_response'] = get_detail_date($total_response);
                        $data['total_solving'] = get_detail_date($total_solving);
                        $data['job'] = $d['job_list']; //optional
                        $data['create'] = idn_date($d['create_date']); //optional
                        $data['status_ticket'] = $status; //optional   
                        $data['active'] = $action_status; //optional
                        $data['action'] = '';
                        if ($param3 == true) {
                            $data['action'] = '<a href="' . base_backend_url('reports/v2_ticket/generate/excel/' . $d['id']) . '" title="Download file to excel"><i class="fa fa-file-excel-o"></i></a>';
                        }
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
            print_r('forbidden access!');
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
                $arr = '<option value="0">' . $this->lang->line('global_select_one') . '</option>';
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

    public function generate($type = null, $id = null) {
        switch ($type) {
            case 'excel':
                $this->gen_to_excel(trim($id));
                break;
        }
    }

    public function gen_to_pdf() {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $post = $this->input->post(NULL, TRUE);
        if (isset($post) && !empty($post)) {
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
            $jnt = 'LEFT JOIN tbl_helpdesk_ticket_chats l ON l.ticket_id = a.id';
            $f = ',l.messages AS response_message';
            $act = ' LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start, solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d WHERE d.is_active = 1)) AS d ON d.ticket_id = a.id';
            $fields = 'a.*, b.status_id, c.name ticket_status,e.name priority_name, f.name category_name,p.first_name,i.fine_result,i.response_time,i.solving_time, o.close_message,o.response_time_start, o.response_time_stop,o.solving_time_start, o.solving_time_stop, k.name, m.first_name created_by,j.job_list, j.message,k.phone_number,n.ticket_id ticket,d.solving_stop,d.solving_start,d.response_stop,d.response_start,g.name job_category_name' . $f;
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
            $where = 'WHERE c.is_active = 1';
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
                $txt = '';

                // print letterhead
                $pdf->writeHTML($txt, true, false, true, false, '');
                //$result .= '';
                // NON-BREAKING TABLE (nobr="true")
                $arr = array();
                $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_handlers', 'Tbl_users', 'Tbl_helpdesk_ticket_problem_impacts', 'Tbl_helpdesk_ticket_files', 'Tbl_helpdesk_ticket_chats'));
                foreach ($res as $val) {
                    if (isset($result)) {
                        $result .= '<div style="clear:both"><h3>Laporan Tiket (' . $val['code'] . ')</h3></div>';
                    }
                    if ($val['solving_time_stop'] == "0000-00-00 00:00:00") {
                        $solving_date = "-";
                    } else {
                        $solving_date = date('d:m:Y H:i:s', strtotime($val['solving_time_stop']));
                    }
                    if ($val['response_time_stop'] == "0000-00-00 00:00:00") {
                        $response_date = "-";
                    } else {
                        $response_date = date('d:m:Y H:i:s', strtotime($val['response_time_stop']));
                    }
                    $status = 'Tidak';
                    if ($val['ticket'] != null) {
                        $status = 'Ya';
                    }
                    $response_time_start = $val['response_time_start'];
                    $response_time_stop = $val['response_time_stop'];
                    $solving_time_start = $val['solving_time_start'];
                    $solving_time_stop = $val['solving_time_stop'];
                    if ($response_time_stop == "0000-00-00 00:00:00") {
                        $response_time_stop = $response_time_start;
                    }
                    if ($solving_time_stop == "0000-00-00 00:00:00") {
                        $solving_time_stop = $solving_time_start;
                    };
                    // total response and solving
                    $total_response = fn_date_diff_ticket($response_time_start, $response_time_stop, 'all');
                    $total_solving = fn_date_diff_ticket($solving_time_start, $solving_time_stop, 'all');
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
                              <td class="a1"><span style="font-weight:bold">Petugas</span></td>
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
                              <td class="a3">' . idn_date($val['create_date']) . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Kategori</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['category_name'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Tanggal respon</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $response_date . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Sub Kategori</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['job_category_name'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Tanggal penyelesaian</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $solving_date . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Pelapor</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['created_by'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Total Respon</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . get_detail_date($total_response) . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Kantor</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['name'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Total Penyelesaian</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . get_detail_date($total_solving) . '</td>
                            </tr>
                            <tr>
                              <td class="a1"><span style="font-weight:bold">Kontak Pelapor</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $val['phone_number'] . '</td>
                              <td class="a1"><span style="font-weight:bold">Re-Open</span></td>
                              <td class="a2"></td>
                              <td class="a3">' . $status . '</td>
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
                    if (isset($history) && !empty($history)) {
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
                    if (isset($chat) && !empty($chat)) {
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
                echo base_url('/var/static/documents/pdf/' . $filename);
            }
        }
    }

    protected function gen_to_excel($id = null) {
        $this->load->model(array('Tbl_helpdesk_tickets', 'Tbl_helpdesk_ticket_chats'));
        $this->load->library('oreno_sla');
        $ticket_activities = $this->oreno_sla->get($id);
        $spreadsheet = new Spreadsheet();
        $tbl_name = 'tbl_helpdesk_tickets a';
        $fields = 'a.*, c.name ticket_status, d.response_start, d.response_stop,d.solving_start , d.solving_stop, e.name priority_name, f.name category_name,h.username response_by,i.response_time,i.solving_time,i.fine_result, CONCAT(j.first_name,j.last_name) create_ticket_by,k.job_list, l.name,n.name job_category_name, o.ticket_id ticket';
        $joins = 'LEFT JOIN tbl_helpdesk_ticket_transactions b ON b.ticket_id = a.id 
                    LEFT JOIN tbl_helpdesk_ticket_status c ON c.id = b.status_id
                    LEFT JOIN (SELECT ticket_id,solving_time_start AS solving_start, solving_time_stop AS solving_stop,response_time_start AS response_start, response_time_stop AS response_stop FROM tbl_helpdesk_activities d WHERE solving_time_stop IN (SELECT max(solving_time_stop) FROM tbl_helpdesk_activities d GROUP BY ticket_id)) AS d ON d.ticket_id = a.id 
                    LEFT JOIN tbl_helpdesk_activities p ON p.ticket_id = a.id  AND p.is_active = 1
                    LEFT JOIN tbl_helpdesk_ticket_priorities e ON e.id = b.priority_id 
                    LEFT JOIN tbl_helpdesk_ticket_categories f ON f.id = b.category_id
                    LEFT JOIN tbl_helpdesk_ticket_categories n ON n.id = b.job_id
                    LEFT JOIN tbl_users h ON h.id = p.created_by
                    LEFT JOIN tbl_helpdesk_ticket_rules i ON i.id = b.rule_id                    
                    LEFT JOIN tbl_users j ON j.id = a.created_by
                    LEFT JOIN tbl_helpdesk_ticket_requests k ON k.ticket_id = a.id
                    LEFT JOIN tbl_helpdesk_office_branchs l ON l.id = b.branch_id
                    LEFT JOIN tbl_helpdesk_ticket_reopen_logs o ON o.ticket_id = a.id';
        $conditions = 'WHERE a.id LIKE "%' . $id . '%" ';
        $ticket1 = $this->Tbl_helpdesk_tickets->query("SELECT {$fields} FROM {$tbl_name} {$joins} {$conditions}");
        $title_file = 'V2_ticket_report_' . $ticket1[0]['code'];
        $spreadsheet->getProperties()->setCreator('PhpOffice')
                ->setLastModifiedBy('PhpOffice')
                ->setTitle('Office 2007 XLSX Test Document')
                ->setSubject('Office 2007 XLSX Test Document')
                ->setDescription('PhpOffice')
                ->setKeywords('PhpOffice')
                ->setCategory('PhpOffice');

        /*
         *
         * Sheet 1 start here
         */
        $sheet = $spreadsheet->getActiveSheet();
        // Rename worksheet'Detail V2_ticket'
        $sheet->setTitle($this->lang->line('global_detail_ticket'));
        // Header
        $sheet->mergeCells('B1:D1');
        $sheet->setCellValue('B1', $this->lang->line('global_view_detail_ticket') . $ticket1[0]['code']);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getStyle('B1:D15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // Set Column Name
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('B2', $this->lang->line('global_no'));
        $sheet->setCellValue('B3', $this->lang->line('global_no_ticket'));
        $sheet->setCellValue('B4', $this->lang->line('global_category'));
        $sheet->setCellValue('B5', $this->lang->line('global_problem_subject'));
        $sheet->setCellValue('B6', $this->lang->line('global_priority'));
        $sheet->setCellValue('B7', $this->lang->line('global_issue'));
        $sheet->setCellValue('B8', $this->lang->line('global_create_date'));
        $sheet->setCellValue('B9', $this->lang->line('global_response_date'));
        $sheet->setCellValue('B10', $this->lang->line('global_solving_date'));
        $sheet->setCellValue('B11', $this->lang->line('global_ticket_create_by'));
        $sheet->setCellValue('B12', $this->lang->line('global_response'));
        $sheet->setCellValue('B13', $this->lang->line('global_detail_job_list'));
        $sheet->setCellValue('B14', $this->lang->line('global_branch_name'));
        $sheet->setCellValue('B15', $this->lang->line('global_reopen'));
        $sheet->getStyle('B2:B15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $status = 'Tidak';
        if ($ticket1[0]['ticket'] != null) {
            $status = 'Ya';
        }

        //Set Value  
        $no = 1;
        $sheet->getColumnDimension('D')->setWidth(90);
        $sheet->setCellValue('D2', $no);
        $sheet->setCellValue('D3', $ticket1[0]['code']);
        $sheet->setCellValue('D4', $ticket1[0]['category_name']);
        $sheet->setCellValue('D5', $ticket1[0]['job_category_name']);
        //$sheet->getRowDimension(4)->setRowHeight(-1);
        $sheet->setCellValue('D6', $ticket1[0]['priority_name']);
        $sheet->setCellValue('D7', $ticket1[0]['content']);
        $sheet->setCellValue('D8', idn_date($ticket1[0]['create_date']));
        $sheet->setCellValue('D9', idn_date($ticket1[0]['response_stop']));
        $sheet->setCellValue('D10', idn_date($ticket1[0]['solving_stop']));
        $sheet->setCellValue('D11', $ticket1[0]['create_ticket_by']);
        $sheet->setCellValue('D12', $ticket1[0]['response_by']);
        $sheet->setCellValue('D13', $ticket1[0]['job_list']);
        $sheet->setCellValue('D14', $ticket1[0]['name']);
        $sheet->setCellValue('D15', $status);

        $sheet->getStyle('B3:D15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $no++;
        $sheet->getStyle('B1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => '000000'],
                'size' => '22'
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('B1:D1')->getFont()->setBold(true);
        $sheet->getStyle('B2:D2')->getFont()->setBold(true);
        $sheet->getStyle('B1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
        $sheet->getStyle('B1:D1')->applyFromArray($headerStyle);
        $sheet->getStyle('B1:D15')->applyFromArray($styleArray);

        //set actual content here at sheet 1
        /*
         *
         * Sheet 1 end here
         */
        //create new sheet
        $spreadsheet->createSheet();
        /*
         *
         * Sheet 2 start here
         */
        // Add some data
        $spreadsheet->setActiveSheetIndex(1);
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->mergeCells('B1:E1');
        $sheet->setCellValue('B1', 'Report : Close V2_ticket ' . $ticket1[0]['code']);
        $sheet->getRowDimension('1')->setRowHeight(40);
        $sheet->getStyle('B1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $no = 1;
        $row = 3;
        $chats = $this->Tbl_helpdesk_ticket_chats->find('all', array(
            'fields' => array('a.*', 'b.username', 'b.email'),
            'conditions' => array('ticket_id' => $id),
            'joins' => array(
                array(
                    'table' => 'tbl_users b',
                    'conditions' => 'b.id = a.created_by',
                    'type' => 'left'
                )
            )
                )
        );
        foreach ($chats as $key => $value) {
            $sheet->setCellValue('B' . $row, $no);
            $sheet->setCellValue('C' . $row, $value['username']);
            $sheet->setCellValue('D' . $row, $value['messages']);
            $sheet->setCellValue('E' . $row, idn_date($value['create_date']));
            $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B:E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
            $no++;
        }

        // Set Column Name
        $sheet->setCellValue('B2', 'No');
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->setCellValue('C2', 'Responder');
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->setCellValue('D2', 'Chat History');
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->setCellValue('E2', 'Response Time');
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getStyle('B2:E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setTitle('Chat & History');
        $sheet->getStyle('B3:E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ],
        ];
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'ffffff'],
                'size' => '22'
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ],
        ];
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'ffffff'],
                'size' => '22'
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ],
        ];
        $border_style = [
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ]
        ];
        $sheet->getStyle('B2:E2')->applyFromArray($border_style);
        $sheet->getStyle('B1:E1')->getFont()->setBold(true);
        $sheet->getStyle('B2:E2')->getFont()->setBold(true);
        $sheet->getStyle('B1:E1')->applyFromArray($headerStyle);
        $sheet->getStyle('B1:E' . ($row - 1))->applyFromArray($styleArray);
        $sheet->getStyle('B1:E' . ($row - 1))->applyFromArray($border_style);
        $sheet->getStyle('B1:E' . ($row - 1))->applyFromArray($border_style);
        /*
         *
         * Sheet 2 end here
         */
        //create new sheet
        $spreadsheet->createSheet();

        /*
         *
         * Sheet 3 start here
         */
        // Add some data
        $spreadsheet->setActiveSheetIndex(2);
        $sheet = $spreadsheet->setActiveSheetIndex(2);
        $sheet->mergeCells('B1:E1');
        $sheet->setCellValue('B1', 'Report : Close V2_ticket ' . $ticket1[0]['code']);
        $sheet->getRowDimension('1')->setRowHeight(40);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);
        $sheet->getRowDimension('4')->setRowHeight(20);
        $sheet->getRowDimension('5')->setRowHeight(20);
        $sheet->getRowDimension('6')->setRowHeight(20);
        $sheet->getStyle('B1:E1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set Column Name
        $sheet->setCellValue('B2', '#');
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('C2', 'SLA Response');
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('D2', 'SLA Transfer');
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->setCellValue('E2', 'SLA Solving');
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getStyle('B2:E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('B3', 'Mulai');
        $sheet->setCellValue('B4', 'Selesai');
        $sheet->setCellValue('B5', 'Total Waktu');
        $sheet->getRowDimension(4)->setRowHeight(-1);
        $sheet->getStyle('B2:B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $response_time_start = $ticket1[0]['response_start'];
        $response_time_stop = $ticket1[0]['response_stop'];
        $solving_time_start = $ticket1[0]['solving_start'];
        $solving_time_stop = $ticket1[0]['solving_stop'];
        $total_response = fn_date_diff_ticket($response_time_start, $response_time_stop, 'all');
        $total_solving = fn_date_diff_ticket($solving_time_start, $solving_time_stop, 'all');
        //set value
        $sheet->setCellValue('C3', idn_date($response_time_start));
        $sheet->setCellValue('C4', idn_date($response_time_stop));
        $sheet->setCellValue('C5', get_detail_date($total_response));
        $sheet->getRowDimension(4)->setRowHeight(-1);
        $sheet->getStyle('C2:C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('D3', isset($ticket_activities[0]['transfer']['transfer_time_start']) ? $ticket_activities[0]['transfer']['transfer_time_start'] : '-');
        $sheet->setCellValue('D4', isset($ticket_activities[0]['transfer']['transfer_time_stop']) ? $ticket_activities[0]['transfer']['transfer_time_stop'] : '-');
        $sheet->setCellValue('D5', '');
        $sheet->getRowDimension(4)->setRowHeight(-1);
        $sheet->getStyle('D2:D5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('E3', idn_date($solving_time_start));
        $sheet->setCellValue('E4', idn_date($solving_time_stop));
        $sheet->setCellValue('E5', get_detail_date($total_solving));
        $sheet->getRowDimension(4)->setRowHeight(-1);
        $sheet->getStyle('E3:E5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->setTitle('SLA Response V2_ticket');
        $sheet->getStyle('B1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ],
        ];
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'ffffff'],
                'size' => '22'
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ],
        ];
        $border_style = [
            'borders' => [
                'outline' => [
                    'borderStyle' =>
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'cccccc'],
                ],
            ]
        ];
        $sheet->getStyle('B2:E2')->getFont()->setBold(true);
        $sheet->getStyle('B3:B5')->getFont()->setBold(true);
        $sheet->getStyle('B1:B5')->applyFromArray($border_style);
        $sheet->getStyle('B2:E2')->applyFromArray($border_style);
        $sheet->getStyle('B1:E1')->applyFromArray($headerStyle);
        $sheet->getStyle('B1:E5')->applyFromArray($styleArray);
        /*
         *
         * Sheet 3 end here
         */
        // Set active sheet index to the first sheet, so Excel opens
        //this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
        //Redirect output to a client’s web browser (Xlsx)
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $title_file . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_clean();
        $writer->save('php://output');
        exit;
    }

}
