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
 * Description of Oreno_generate_file
 *
 * @author user
 */
class Oreno_generate_file {

    //put your code here

    public function init($filename = null, $type = 'branch', $filetype = 'xlsx') {
        switch ($type) {
            case 'branch':
                $this->fn_get_branch_file($filename, $filetype);
                break;
            case 'vendor':
                $this->fn_get_vendor_file($filename, $filetype);
                break;
        }
    }

    public function fn_get_branch_file($filename, $type) {
        if ($filename != null) {
            $spreadsheet = new Spreadsheet();
            $title_file = $filename;
            $spreadsheet->getProperties()->setCreator('PhpOffice')
                    ->setLastModifiedBy('PhpOffice')
                    ->setTitle('Office 2007 XLSX Test Document')
                    ->setSubject('Office 2007 XLSX Test Document')
                    ->setDescription('PhpOffice')
                    ->setKeywords('PhpOffice')
                    ->setCategory('PhpOffice');
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Unggah data kelompok kantor cabang');
            $i = 5;
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
             * setup page information
             * start here
             */
            $sheet->mergeCells('B1:F1');
            $text_config_information1 = '
               Format Password  : base64_encode() atau buka tools online.
            ';
            $sheet->setCellValue('B1', $text_config_information1);
            $sheet->mergeCells('B2:F2');
            $text_config_information2 = '
               Kode kelompok pengguna kantor cabang : 2 (employee) | otomatis di generate
            ';
            $sheet->setCellValue('B2', $text_config_information2);
            $sheet->mergeCells('B3:F3');
            $text_config_information3 = '
               Kode
            ';
            $sheet->setCellValue('B3', $text_config_information3);
            $sheet->mergeCells('B4:F4');
            $text_config_information4 = '
               Status user : aktif/tidak aktif
            ';
            $sheet->setCellValue('B4', $text_config_information4);
            /*
             * sheet style
             * end here
             */
            $sheet->getStyle('B' . $i . ':L' . $i)->getFont()->setBold(true);
            $sheet->getStyle('B' . $i . ':L' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
            $sheet->getStyle('B' . $i . ':L' . $i)->applyFromArray($headerStyle);
            /*
             * Header
             * start here
             */
            $sheet->mergeCells('B' . $i . ':L' . $i);
            /*
             * Header
             * end here
             */
            /*
             * body table 
             * start here
             */

            $sheet->setCellValue('B5', 'UNGGAH DATA KELOMPOK PENGGUNA');
            $sheet->getStyle('B' . $i . ':L' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $i . ':L' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            // Set Column Name
            $i++;
            $sheet->getColumnDimension('B')->setWidth(6);
            $sheet->setCellValue('B' . $i, 'No');
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->setCellValue('C' . $i, 'NIK');
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->setCellValue('D' . $i, 'Nama Pengguna');
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->setCellValue('E' . $i, 'Nama Depan');
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->setCellValue('F' . $i, 'Nama Belakang');
            $sheet->getColumnDimension('G')->setWidth(25);
            $sheet->setCellValue('G' . $i, 'Surel');
            $sheet->getColumnDimension('H')->setWidth(25);
            $sheet->setCellValue('H' . $i, 'Password');
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->setCellValue('I' . $i, 'No Handphone');
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->setCellValue('J' . $i, 'Kode Kantor');
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->setCellValue('K' . $i, 'Kelompok Pengguna');
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->setCellValue('L' . $i, 'Status');
            $sheet->getStyle('B' . $i . ':L' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            //set sample value
            $i++;
            $sheet->setCellValue('B' . $i, '1.');
            $sheet->setCellValue('H' . $i, 'cGFzc3dvcmQ=');
            $sheet->setCellValue('J' . $i, 'JD');
            $sheet->setCellValue('K' . $i, 'EMPLOYEE');
            $sheet->setCellValue('L' . $i, 'AKTIF');
            $sheet->getStyle('B5:L' . ($i+2))->applyFromArray($styleArray);
            $sheet->getStyle('B6:L6')->applyFromArray($styleArray);
            $sheet->getStyle('B5:B' . ($i+2))->applyFromArray($styleArray);
            $sheet->getStyle('B5:L5')->getFont()->setBold(true);
            
            $sheet->getStyle('B' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            /*
             * body table 
             * end here
             */
            /*
             * body style options
             * end here
             */
            // Set active sheet index to the first sheet, so Excel opens
            $spreadsheet->setActiveSheetIndex(0);
            //Redirect output to a client’s web browser (Xlsx)
            $fnam = $title_file . '.' . $type;
            header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fnam . '"');
            header('Cache-Control: max-age = 0');
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

    protected function fn_get_vendor_file($filename, $type) {
        if ($filename != null) {
            $spreadsheet = new Spreadsheet();
            $title_file = $filename;
            $spreadsheet->getProperties()->setCreator('PhpOffice')
                    ->setLastModifiedBy('PhpOffice')
                    ->setTitle('Office 2007 XLSX Test Document')
                    ->setSubject('Office 2007 XLSX Test Document')
                    ->setDescription('PhpOffice')
                    ->setKeywords('PhpOffice')
                    ->setCategory('PhpOffice');
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Unggah data kelompok vendor');
            $i = 5;
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
             * setup page information
             * start here
             */
            $sheet->mergeCells('B1:F1');
            $text_config_information1 = '
               Format Password  : base64_encode() atau buka tools online.
            ';
            $sheet->setCellValue('B1', $text_config_information1);
            $sheet->mergeCells('B2:F2');
            $text_config_information2 = '
               Kode kelompok pengguna (vendor) : 3 (vendor) | otomatis di generate
            ';
            $sheet->setCellValue('B2', $text_config_information2);
            $sheet->mergeCells('B3:F3');
            $text_config_information3 = '
               Kode : 
            ';
            $sheet->setCellValue('B3', $text_config_information3);
            $sheet->mergeCells('B4:F4');
            $text_config_information4 = '
               Status user : aktif/tidak aktif
            ';
            $sheet->setCellValue('B4', $text_config_information4);
            /*
             * sheet style
             * end here
             */
            $sheet->getStyle('B' . $i . ':L' . $i)->getFont()->setBold(true);
            $sheet->getStyle('B' . $i . ':L' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ccccc');
            $sheet->getStyle('B' . $i . ':L' . $i)->applyFromArray($headerStyle);
            /*
             * Header
             * start here
             */
            $sheet->mergeCells('B' . $i . ':L' . $i);
            /*
             * Header
             * end here
             */
            /*
             * body table 
             * start here
             */

            $sheet->setCellValue('B5', 'UNGGAH DATA KELOMPOK PENGGUNA');
            $sheet->getStyle('B' . $i . ':L' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $i . ':L' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            // Set Column Name
            $i++;
            $sheet->getColumnDimension('B')->setWidth(6);
            $sheet->setCellValue('B' . $i, 'No');
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->setCellValue('C' . $i, 'NIK');
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->setCellValue('D' . $i, 'Nama Pengguna');
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->setCellValue('E' . $i, 'Nama Depan');
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->setCellValue('F' . $i, 'Nama Belakang');
            $sheet->getColumnDimension('G')->setWidth(25);
            $sheet->setCellValue('G' . $i, 'Surel');
            $sheet->getColumnDimension('H')->setWidth(25);
            $sheet->setCellValue('H' . $i, 'Password');
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->setCellValue('I' . $i, 'No Handphone');
            $sheet->getColumnDimension('J')->setWidth(20);
            $sheet->setCellValue('J' . $i, 'Kode Kantor');
            $sheet->getColumnDimension('K')->setWidth(20);
            $sheet->setCellValue('K' . $i, 'Kelompok Pengguna');
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->setCellValue('L' . $i, 'Status');
            $sheet->getStyle('B' . $i . ':L' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//            //set sample value
            $sheet->getStyle('B'. ($i) .':L' . ($i))->applyFromArray($styleArray);
            $i++;
            $sheet->setCellValue('B' . $i, '1.');
            $sheet->setCellValue('H' . $i, 'cGFzc3dvcmQ=');
            $sheet->setCellValue('J' . $i, 'SIG');
            $sheet->setCellValue('K' . $i, 'VENDOR');
            $sheet->setCellValue('L' . $i, 'AKTIF');
            $sheet->getStyle('B'. ($i) .':L' . ($i+2))->applyFromArray($styleArray);
            $sheet->getStyle('B'. ($i) .':L' . ($i+2))->getFont()->setBold(true);
            $sheet->getStyle('B' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
            /*
             * body table 
             * end here
             */
            /*
             * body style options
             * end here
             */
            // Set active sheet index to the first sheet, so Excel opens
            $spreadsheet->setActiveSheetIndex(0);
            //Redirect output to a client’s web browser (Xlsx)
            $fnam = $title_file . '.' . $type;
            header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fnam . '"');
            header('Cache-Control: max-age = 0');
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

}
