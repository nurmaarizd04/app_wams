<?php

namespace App\Http\Controllers\CashADVI\Export;

use App\Models\CreateClient;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

trait Excel
{
    public static function doExportInternal($project, $transMaker)
    {
        $spreadsheet = new Spreadsheet();
        $myWorksheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $project->nama_project);
        $spreadsheet->addSheet($myWorksheet, 0);
        $report_data = $spreadsheet->setActiveSheetIndex(0);
        $report_data->setTitle($project->nama_project);
        
        $report_data->setCellValue('A1', 'Project ' . $project->nama_project);
        $start_from = 16;

        // set Header
        $report_data->setCellValue('A3', 'ID Project');
        $report_data->setCellValue('A4', 'Project');
        $report_data->setCellValue('A5', 'Nama Client');
        $report_data->setCellValue('A6', 'PIC');
        $report_data->setCellValue('A7', 'Nominal');
        $report_data->setCellValue('A8', 'Realisasi');
        $report_data->setCellValue('A9', 'File');
        $report_data->setCellValue('A9', 'Tangggal');


        // Set data
        $report_data->setCellValue('B3', $project->id_project)->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B4', $project->nama_project)->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B5', $project->nama_client)->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B6', $project->pic)->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B7', 'Rp. ' . number_format($project->nominal, 0, ',', '.'))->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B8', $project->realisasi)->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B9', $project->file)->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('B9', $project->created_at)->getColumnDimension('B')->setWidth(20);


        $report_data->setCellValue('A14', 'Transaction Maker Project ' . $project->nama_project);

        $report_data->setCellValue('A' . $start_from, 'Tanggal')->getColumnDimension('A')->setWidth(20);
        $report_data->setCellValue('B' . $start_from, 'Jenis Transaksi')->getColumnDimension('B')->setWidth(20);
        $report_data->setCellValue('C' . $start_from, 'Tujuan')->getColumnDimension('C')->setWidth(20);
        $report_data->setCellValue('D' . $start_from, 'Nominal')->getColumnDimension('D')->setWidth(20);
        $report_data->setCellValue('E' . $start_from, 'Keterangan')->getColumnDimension('E')->setWidth(20);

        $sum = $start_from;

        // Loop untuk mengisi data transaksi
        foreach($transMaker as $val) {
            $sum += 1;
            $report_data->setCellValue("A$sum", $val->tanggal);
            $report_data->setCellValue("B$sum", $val->jenis_transaksi);
            $report_data->setCellValue("C$sum", $val->nama_tujuan);
            $report_data->setCellValue("D$sum", $val->nominal);
            $report_data->setCellValue("E$sum", $val->keterangan);
        }

        $report_header = 'A1:H1';
        $report_header2 = 'A14:H14';
        $repor_header_th = "A$start_from:H$start_from";

        $report_data->mergeCells($report_header);
        $report_data->mergeCells($report_header2);
        $report_data->getStyle($report_header)->getAlignment()->setHorizontal('center');
        $report_data->getStyle("A1")->getFont()->setSize(15);
        $report_data->getStyle("A14")->getFont()->setSize(15);
        $report_data->getStyle($repor_header_th)->getAlignment()->setHorizontal('center');

        $writer = new Xlsx($spreadsheet);
        $name = 'export/file-project-internal-' . time() . '.xlsx';
        $writer->save($name);

        return  "/" . $name;
    }

}