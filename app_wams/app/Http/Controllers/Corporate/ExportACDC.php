<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Corporate\Export\Excel;
use App\Models\CreateProject;
use App\Models\TransactionMakerACDC;

class ExportACDC extends Controller
{
    use Excel;

    public function export($id)
    {
        $cpt = CreateProject::find($id)->toArray();
        $ctm = TransactionMakerACDC::where('cpt_id', $cpt['id'])->get();

        @unlink("/export/file-project.xlsx");
        $headers = [
            'Content-Type' => 'application/xlsx',
        ];

        $export = self::doExport($cpt, $ctm);

        return response()->download(public_path($export), 'file-project.xlsx', $headers)->deleteFileAfterSend(false);
    }
}