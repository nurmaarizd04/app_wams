<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Corporate\Export\Excel;
use App\Models\TransactionMakerACDC;
use Illuminate\Support\Facades\DB;

class ExportACDC extends Controller
{
    use Excel;

    public function export($id)
    {
        $cpt = DB::table('create_projects')
            ->join('opty_acdcs', 'create_projects.opty_acdc_id', '=', 'opty_acdcs.id')
            ->select(
                'create_projects.*',
                'opty_acdcs.project_name'
            )
            ->where('create_projects.id', $id)
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();

        if (!empty($cpt)) {
            $cpt = (array) $cpt[0];
        }

        $ctm = TransactionMakerACDC::where('cpt_id', $cpt['id'])->get();

        @unlink("/export/file-project.xlsx");
        $headers = [
            'Content-Type' => 'application/xlsx',
        ];

        $export = self::doExport($cpt, $ctm);

        return response()->download(public_path($export), 'file-project.xlsx', $headers)->deleteFileAfterSend(false);
    }
}
