<?php

require_once DOCUMENT_ROOT . '/var/static/lib/packages/phpexcel/autoload.php';
require_once DOCUMENT_ROOT . '/var/static/lib/packages/TCPDF/tcpdf.php';

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
 * Description of V1_ticket
 *
 * @author SuperUser
 */
class V1_ticket extends MY_Controller {

//put your kode here

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Tbl_helpdesk_tickets', 'tbl_helpdesk_ticket_transactions', 'tbl_helpdesk_ticket_status', 'tbl_helpdesk_activities', 'tbl_helpdesk_ticket_priorities', 'tbl_helpdesk_ticket_categories'));
    }

    public function index() {
        redirect(base_backend_url('reports/v1_ticket/category/'));
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
        $data['status'] = $this->get_ticket_status();
        $data['priority'] = $this->get_ticket_priority();
        $data['category'] = ($this->get_category_v1());
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
            $tbl_name = 'view_pengaduan_isi a';
            $conditions = '';
            if (isset($post['param1']) && !empty($post['param1'])) {
                if (!empty($post['param1']['from_date']) && !empty($post['param1']['to_date'])) {
                    $conditions .= " AND a.waktu >= '" . date('Y-m-d H:i:s', strtotime($post['param1']['from_date'])) . "' AND a.waktu <= '" . date('Y-m-d H:i:s', strtotime('+1day', strtotime($post['param1']['to_date']))) . "'";
                }
                if (!empty($post['param1']['ticket_status'])) {
                    $conditions .= " AND a.status = '" . $post['param1']['ticket_status'] . "'";
                }
                if (!empty($post['param1']['ticket_category'])) {
                    $conditions .= " AND a.jenis = '" . $post['param1']['ticket_category'] . "'";
                }
                if (!empty($post['param1']['problem_subject'])) {
                    $conditions .= " AND a.jenis = '" . $post['param1']['problem_subject'] . "'";
                }
            } elseif (isset($post['param3']) && !empty($post['param3'])) {
                $conditions .= " AND a.nomor = '" . $post['param3']['code'] . "'";
            }
            $fields = '
                a.*, 
                b.entitas category_en, b.kode category_code, b.vendor category_vendor_id, b.induk category_parent_id, b.jenis category_name,
                c.entitas user_profile_en, c.kode user_profile_code, c.organisasi user_profile_office_code, c.akun user_profile_user_id, c.id user_profile_id, c.nama user_profile_name, c.email user_profile_email,
                d.entitas user_en, d.kode user_code, d.id user_id, d.status user_status, d.otoritas 
            ';
            $where = 'WHERE a.kode != "" ';
            $joins = '
                LEFT JOIN view_pengaduan_jenis b ON b.kode = a.jenis 
                LEFT JOIN view_profil c ON c.kode = a.pengadu
                LEFT JOIN view_pengguna d ON d.kode = c.akun
                ';
            $total_rows = ($this->Tbl_helpdesk_tickets->query("SELECT count(*) total FROM {$tbl_name} {$joins} {$where} {$conditions}", 'select', 'helpdesk_v1'));
            $total_rows = $total_rows[0]['total'];
            $res = $this->Tbl_helpdesk_tickets->query("SELECT {$fields} FROM {$tbl_name} {$joins} {$where} {$conditions} LIMIT {$start}, {$length}", 'select', 'helpdesk_v1');
            $arr = array();
            if (isset($res) && !empty($res)) {
                $i = $start + 1;
                foreach ($res as $d) {
                    $responder = '-';
                    if ($d['penerima'] != '-') {
                        $resp = $this->Tbl_helpdesk_tickets->query("
                            SELECT a.*, b.entitas user_en, b.id user_id, b.status, b.otoritas FROM view_profil a 
                            LEFT JOIN view_pengguna b ON b.kode = a.kode
                            WHERE a.kode = '" . $d['penerima'] . "';
                            ", 'select', 'helpdesk_v1'
                        );
                        if (isset($resp) && !empty($resp)) {
                            $responder = $resp[0]['nama'];
                        }
                    }
                    $respon_note = $this->Tbl_helpdesk_tickets->query("
                            SELECT a.*, b.entitas user_en, b.nama response_by FROM view_pengaduan_respon a 
                            LEFT JOIN view_profil b ON b.kode = a.penulis
                            WHERE a.aduan = '" . $d['kode'] . "';
                            ", 'select', 'helpdesk_v1'
                    );
                    $respon = '';
                    $arr_respon_note = '';
                    if (isset($respon_note) && !empty($respon_note)) {
                        foreach ($respon_note AS $key => $val) {
                            if (!isset($arr_respon_note)) {
                                $arr_respon_note .= '| </br>';
                            }
                            if ($val['response_by'] != '') {
                                $content = str_replace($val['penulis'], '', $val['isi']);
                                $arr_respon_note .= $val['response_by'] . ' ' . date('H:i:s', strtotime($val['waktu'])) . ' ' . $content . ' | ';
                            } else {
                                $arr_respon_note .= $val['isi'];
                            }
                        }
                    }
                    $reponse_detail = $this->Tbl_helpdesk_tickets->query("
                        SELECT * FROM view_pengaduan_respon a
                        WHERE a.jenis = 'respon' AND a.aduan = '" . $d['kode'] . "'
                        ", 'select', 'helpdesk_v1');
                    $data['respon_date'] = '';
                    $data['respon_time'] = '';
                    if (isset($reponse_detail) && !empty($reponse_detail)) {
                        $data['respon_date'] = date('d/m/Y', strtotime($reponse_detail[0]['waktu']));
                        $data['respon_time'] = date('H:i:s', strtotime($reponse_detail[0]['waktu']));
                    }
                    $closing_note = $this->Tbl_helpdesk_tickets->query("
                        SELECT * FROM `view_pengaduan_respon` `a` 
                        WHERE `a`.`jenis` = 'sisipan' 
                        ORDER BY `waktu` DESC;
                    ", 'select', 'helpdesk_v1');
                    $data['closing_date'] = '';
                    $data['closing_time'] = '';
                    if (isset($closing_note) && !empty($closing_note)) {
                        $data['closing_date'] = date('d/m/Y', strtotime($closing_note['waktu']));
                        $data['closing_time'] = date('H:i:s', strtotime($closing_note['waktu']));
                    }
                    $data['num'] = $i;
                    $data['code'] = $d['nomor']; //optional
                    $data['category_name'] = $d['category_name']; //optional
                    $data['tag'] = $d['perihal'];
                    $data['priority'] = $d['prioritas']; //optional
                    $data['status'] = $d['status']; //optional
                    $data['content'] = $d['deskripsi']; //optional
                    $data['respon_note'] = isset($arr_respon_note) ? $arr_respon_note : ''; //optional
                    $data['create_tgl'] = date('d/m/Y', strtotime($d['waktu'])); //optional
                    $data['create_time'] = date('H:i:s', strtotime($d['waktu'])); //optional
                    $data['create_by'] = $d['user_profile_name'];
                    $data['respon_by'] = $responder;
                    if (isset($post['param3']) && !empty($post['param3'])) {
                        $data['action'] = '<a href="' . base_backend_url('reports/v1_ticket/generate/excel/' . $d['kode']) . '" title="Download file to excel"><i class="fa fa-file-excel-o"></i></a>';
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
    }

    public function generate($type = null, $id = null) {
        switch ($type) {
            case 'excel':
                $this->gen_to_excel(trim($id));
                break;
        }
    }

    public function gen_to_pdf($data = array()) {
        if (isset($data) && !empty($data)) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // output the HTML content
            $html = '';
            $pdf->writeHTML($html, true, false, true, false, '');
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // reset pointer to the last page
            $pdf->lastPage();

            // ---------------------------------------------------------
            //Close and output PDF document
            echo $pdf->Output('example_006.pdf', 'D');
        }
    }

    protected function gen_to_excel($id = null) {
        $this->load->model(array('Tbl_helpdesk_tickets'));
        $spreadsheet = new Spreadsheet();
        $tbl_name = 'view_pengaduan_isi a';
        $fields = '
                a.*, 
                b.entitas category_en, b.kode category_code, b.vendor category_vendor_id, b.induk category_parent_id, b.jenis category_name,
                c.entitas user_profile_en, c.kode user_profile_code, c.organisasi user_profile_office_code, c.akun user_profile_user_id, c.id user_profile_id, c.nama user_profile_name, c.email user_profile_email,
                d.entitas user_en, d.kode user_code, d.id user_id, d.status user_status, d.otoritas 
            ';
        $where = 'WHERE a.kode = "' . $id . '" ';
        $joins = '
                LEFT JOIN view_pengaduan_jenis b ON b.kode = a.jenis 
                LEFT JOIN view_profil c ON c.kode = a.pengadu
                LEFT JOIN view_pengguna d ON d.kode = c.akun
                ';
        $result = $this->Tbl_helpdesk_tickets->query("SELECT {$fields} FROM {$tbl_name} {$joins} {$where}", 'select', 'helpdesk_v1');
        if (isset($result) && !empty($result)) {
            $create_by = $this->Tbl_helpdesk_tickets->query("
                SELECT * FROM view_profil a
                WHERE a.kode  = '{$result[0]['pengadu']}'
            ", 'select', 'helpdesk_v1');
            if ($create_by) {
                $result = array_merge($result, array('create_by' => $create_by[0]));
            }
            $response_by = $this->Tbl_helpdesk_tickets->query("
                SELECT * FROM view_profil a
                WHERE a.kode  = '{$result[0]['penerima']}'
            ", 'select', 'helpdesk_v1');
            if ($response_by) {
                $result = array_merge($result, array('response_by' => $response_by[0]));
            }
            $office = $this->Tbl_helpdesk_tickets->query("
                SELECT * FROM instansi a
                WHERE a.kode = '{$result[0]['user_profile_office_code']}'
            ", 'select', 'helpdesk_v1');
            if ($office) {
                $result = array_merge($result, array('office' => $office[0]));
            }
            $response = $this->Tbl_helpdesk_tickets->query("
                SELECT 
                a.entitas response_ticket_en, a.kode response_ticket_code, a.isi content, a.jenis ticket_type, a.waktu ticket_reponse_date,
                b.entitas user_profile_en, b.kode user_profile_code, b.nama user_profile_name, b.email user_profile_email
                FROM view_pengaduan_respon a
                LEFT JOIN view_profil b ON b.kode = a.penulis                
                WHERE aduan = '{$result[0]['kode']}' 
                ORDER BY waktu ASC
            ", 'select', 'helpdesk_v1');
            if ($response) {
                $result = array_merge($result, array('response' => $response));
            }
            $transfer = $this->Tbl_helpdesk_tickets->query("
                SELECT 
                a.entitas transfer_ticket_en, a.kode transfer_ticket_code, a.alasan transfer_reason, a.waktu transfer_date,
                b.entitas user_profile_en_sender, b.kode user_profile_code_sender, b.nama user_profile_name_sender, b.email user_profile_email_sender,
                c.entitas user_profile_en_receiver, c.kode user_profile_code_receiver, c.nama user_profile_name_receiver, c.email user_profile_email_receiver
                FROM tiket_transfer a
                LEFT JOIN view_profil b ON b.kode = a.pemohon
                LEFT JOIN view_profil c ON c.kode = a.penerima
                WHERE aduan = '{$result[0]['kode']}'
            ", 'select', 'helpdesk_v1');
            if ($transfer) {
                $result = array_merge($result, array('transfer' => $transfer));
            }
        }
        $data = $result[0];
        $ticket_code = strtoupper($data['kode']);
        $title_file = 'V1_ticket_report_' . $ticket_code;
        $spreadsheet->getProperties()->setCreator('PhpOffice')
                ->setLastModifiedBy('PhpOffice')
                ->setTitle('Office 2007 XLSX Test Document')
                ->setSubject('Office 2007 XLSX Test Document')
                ->setDescription('PhpOffice')
                ->setKeywords('PhpOffice')
                ->setCategory('PhpOffice');

        /*
         * sheet 1 detail ticket
         * start here
         */
        $sheet = $spreadsheet->getActiveSheet();
        // Rename worksheet'Detail V1_ticket'
        $sheet->setTitle($this->lang->line('global_detail_ticket'));

        $i = 1;
        /*
         * sheet style
         * start here
         */
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
        /*
         * sheet style
         * end here
         */
        $sheet->getStyle('B' . $i . ':D' . $i)->getFont()->setBold(true);
        $sheet->getStyle('B' . $i . ':D' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
        $sheet->getStyle('B' . $i . ':D' . $i)->applyFromArray($headerStyle);
        /*
         * Header
         * start here
         */
        $sheet->mergeCells('B' . $i . ':D' . $i);
        $sheet->setCellValue('B1', $this->lang->line('global_view_detail_ticket') . ' ' . $ticket_code);
        $sheet->getRowDimension('1')->setRowHeight(30);
        /*
         * Header
         * end here
         */
        /*
         * body table 
         * no | kode | pengirim | penerima  | deskripsi | prioritas | status | waktu | kategori | dibuat oleh(user_profile_name)
         * start here
         */
        $sheet->getStyle('B' . $i . ':D' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . $i . ':D' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        // Set Column Name
        $i++;
        $sheet->setCellValue('B' . $i, '#');
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_no_ticket'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_category'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_priority'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_issue'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_create_date'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_response_date'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_create_by'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_response_by'));
        $i++;
        $sheet->setCellValue('B' . $i, $this->lang->line('global_branch_name'));
        /*
         * body table 
         * no | kode | pengirim | penerima  | deskripsi | prioritas | status | waktu | kategori | dibuat oleh(user_profile_name)
         * end here
         */
        /*
         * body style options
         * end here
         */
        /*
         * body value
         * start here
         */
        //Set Value  
        $j = 2;
        $sheet->setCellValue('D' . $j, 'Keterangan');
        $j++;
        $sheet->setCellValue('D' . $j, $ticket_code);
        $j++;
        $sheet->setCellValue('D' . $j, $data['category_name']);
        $j++;
        $sheet->setCellValue('D' . $j, $data['prioritas']);
        $sheet->getRowDimension(4)->setRowHeight(-1);
        $j++;
        $sheet->setCellValue('D' . $j, $data['deskripsi']);
        $sheet->getStyle('D' . $j)->getAlignment()->setWrapText(true);
        $j++;
        $sheet->setCellValue('D' . $j, idn_date($data['waktu']));
        $j++;
        $sheet->setCellValue('D' . $j, idn_date($result['response'][0]['ticket_reponse_date']));
        $j++;
        $sheet->setCellValue('D' . $j, $result['create_by']['nama']);
        $j++;
        $sheet->setCellValue('D' . $j, $result['response_by']['nama']);
        $j++;
        $sheet->setCellValue('D' . $j, $result['office']['nama']);
        /*
         * body value
         * end here
         */
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(2);
        $sheet->getColumnDimension('D')->setWidth(80);
        $sheet->getStyle('B1:D' . $j)->applyFromArray($styleArray);
        $sheet->getStyle('B2:D' . $j)->getFont()->setBold(true);
        /*
         * body style options
         * end here
         */

        /*
         * sheet 1 detail ticket
         * end here
         */

        /*
         * sheet 2 chat ticket
         * start here
         */
        //create new sheet
        $k = 1;
        $row = 3;
        $spreadsheet->createSheet(1);
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle('Respon Tiket');
        $sheet2 = $spreadsheet->setActiveSheetIndex(1);
        $sheet2->mergeCells('B' . $k . ':F' . $k);
        $sheet2->setCellValue('B' . $k, 'Respon Tiket ' . $ticket_code);
        $sheet2->getRowDimension('1')->setRowHeight(40);
        $sheet2->getStyle('B1:F' . $k)->applyFromArray($styleArray);
        $sheet2->getStyle('B2:F' . $k)->getFont()->setBold(true);
        $sheet2->getStyle('B' . $k . ':F' . $k)->applyFromArray($headerStyle);
        $sheet2->getStyle('B' . $k . ':F' . $k)->getFont()->setBold(true);
        $sheet2->getStyle('B' . $k . ':F' . $k)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
        $sheet2->getStyle('B' . $k . ':F' . $k)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $k++;
        // Set Column Name
        $sheet2->setCellValue('B' . $k, 'No');
        $sheet2->getColumnDimension('B')->setWidth(6);
        $sheet2->setCellValue('C' . $k, 'Di respon Oleh');
        $sheet2->getColumnDimension('C')->setWidth(25);
        $sheet2->setCellValue('D' . $k, 'Tipe respon');
        $sheet2->getColumnDimension('D')->setWidth(15);
        $sheet2->setCellValue('E' . $k, 'Konten');
        $sheet2->getColumnDimension('E')->setWidth(80);
        $sheet2->setCellValue('F' . $k, 'Tanggal dibuat');
        $sheet2->getColumnDimension('F')->setWidth(35);
        $sheet2->getStyle('B1:F' . $k)->applyFromArray($styleArray);
        $sheet2->getStyle('B2:F' . $k)->getFont()->setBold(true);

        $no2 = 1;
        foreach ($result['response'] as $key => $value) {
            $sheet2->setCellValue('B' . $row, $no2);
            $sheet2->setCellValue('C' . $row, $value['user_profile_name']);
            $sheet2->setCellValue('D' . $row, $value['ticket_type']);
            $sheet2->setCellValue('E' . $row, $value['content']);
            $sheet2->getStyle('E' . $row)->getAlignment()->setWrapText(true);
            $sheet2->setCellValue('F' . $row, idn_date($value['ticket_reponse_date']));
            $row++;
            $no2++;
        }
        $row--;
        $sheet2->getStyle('B1:F' . $row)->applyFromArray($styleArray);
        $sheet2->getStyle('B2:F' . $row)->getFont()->setBold(true);
        /*
         * sheet 2 chat ticket
         * end here
         */
        /*
         * sheet 3 chat ticket
         * start here
         */
        //create new sheet
        $l = 1;
        $row2 = 3;
        $spreadsheet->createSheet(2);
        $spreadsheet->setActiveSheetIndex(2);
        $spreadsheet->getActiveSheet()->setTitle('Transfer Tiket');
        $sheet3 = $spreadsheet->setActiveSheetIndex(2);
        $sheet3->mergeCells('B' . $l . ':F' . $l);
        $sheet3->setCellValue('B' . $l, 'Respon Tiket ' . $ticket_code);
        $sheet3->getRowDimension('1')->setRowHeight(40);
        $sheet3->getStyle('B1:F' . $l)->applyFromArray($styleArray);
        $sheet3->getStyle('B2:F' . $l)->getFont()->setBold(true);
        $sheet3->getStyle('B' . $l . ':B' . $l)->applyFromArray($headerStyle);
        $sheet3->getStyle('B' . $l . ':B' . $l)->getFont()->setBold(true);
        $sheet3->getStyle('B' . $l . ':B' . $l)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
        $sheet3->getStyle('B' . $l . ':F' . $l)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $l++;
        // Set Column Name
        $sheet3->setCellValue('B' . $l, 'No');
        $sheet3->getColumnDimension('B')->setWidth(6);
        $sheet3->setCellValue('C' . $l, 'Di respon Oleh');
        $sheet3->getColumnDimension('C')->setWidth(25);
        $sheet3->setCellValue('D' . $l, 'Di ambil Oleh');
        $sheet3->getColumnDimension('D')->setWidth(25);
        $sheet3->setCellValue('E' . $l, 'Konten');
        $sheet3->getColumnDimension('E')->setWidth(80);
        $sheet3->setCellValue('F' . $l, 'Tanggal dibuat');
        $sheet3->getColumnDimension('F')->setWidth(35);
        $sheet3->getStyle('B1:F' . $l)->applyFromArray($styleArray);
        $sheet3->getStyle('B2:F' . $l)->getFont()->setBold(true);

        $no3 = 1;
        foreach ($result['transfer'] as $key => $value) {
            $row++;
            $sheet3->setCellValue('B' . $row2, $no3);
            $sheet3->setCellValue('C' . $row2, $value['user_profile_name_receiver']);
            $sheet3->setCellValue('D' . $row2, $value['user_profile_name_sender']);
            $sheet3->setCellValue('E' . $row2, $value['transfer_reason']);
            $sheet3->getStyle('E' . $row2)->getAlignment()->setWrapText(true);
            $sheet3->setCellValue('F' . $row2, idn_date($value['transfer_date']));
            $no2++;
        }
        $sheet3->getStyle('B1:F' . $row2)->applyFromArray($styleArray);
        $sheet3->getStyle('B2:F' . $row2)->getFont()->setBold(true);
        /*
         * sheet 3 chat ticket
         * end here
         */

        // Set active sheet index to the first sheet, so Excel opens
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

    public function get_category_v1($is_ajax = false) {
        $result = $this->Tbl_helpdesk_tickets->find('all', array(
            'table_name' => 'view_pengaduan_isi',
            'conditions' => array('status' => 'aktif')
                ), 'helpdesk_v1');
        if ($is_ajax == true) {
            echo json_encode($result);
        } else {
            return $result;
        }
    }

    public function get_category_v1_sub($category = null, $is_ajax = false) {
        $result = $this->Tbl_helpdesk_tickets->find('all', array(
            'table_name' => 'view_pengaduan_jenis',
            'conditions' => array('induk' => base64_decode($category), 'status' => 'aktif')
                ), 'helpdesk_v1');
        if ($is_ajax == true) {
            echo json_encode($result);
        } else {
            return $result;
        }
    }

    public function get_category_select() {
        $post = $this->input->post(NULL, TRUE);
        $id = $post['id'];
        if ($id == null) {
            $result = $this->get_category_v1();
            $arr = '';
            if ($result) {
                $arr .= '<option value="0">' . $this->lang->line('global_select_one') . '</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                }
            }
            echo $arr;
            exit();
        } else {
            $result = ($this->get_category_v1_sub($id));
            $arr = '';
            if ($result) {
                $arr .= '<option value="0">' . $this->lang->line('global_select_one') . '</option>';
                foreach ($result AS $key => $value) {
                    $arr .= '<option value="' . $value['kode'] . '">' . $value['jenis'] . '</option>';
                }
            }
            echo $arr;
            exit();
        }
    }

    public function get_ticket_priority($is_ajax = false) {
        $arr = array(
            array(
                'id' => 'rendah',
                'name' => 'rendah'
            ),
            array(
                'id' => 'normal',
                'name' => 'normal'
            ),
            array(
                'id' => 'tinggi',
                'name' => 'tinggi'
            )
        );
        if ($is_ajax == true) {
            echo json_encode($arr);
        } else {
            return $arr;
        }
    }

    public function get_ticket_status($is_ajax = false) {
        $arr = array(
            array(
                'id' => 'open',
                'name' => 'open'
            ),
            array(
                'id' => 'progress',
                'name' => 'progress'
            ),
            array(
                'id' => 'close',
                'name' => 'close'
            )
        );
        if ($is_ajax == true) {
            echo json_encode($arr);
        } else {
            return $arr;
        }
    }

}
