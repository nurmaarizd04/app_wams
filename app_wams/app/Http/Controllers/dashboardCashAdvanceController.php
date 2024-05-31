<?php

namespace App\Http\Controllers;

use App\Models\CreateProject;
use App\Models\TransactionMakerACDC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class dashboardCashAdvanceController extends Controller
{
    public function index() {

        // ambil nama project
        $namaProject = DB::table('project_internal')
        ->select('nama_project')
        ->distinct()
        ->get();

        // ambil nama pic
        $pic = DB::table('project_internal')
        ->select('pic')
        ->distinct()
        ->get();


        return view("corporate.cashAdvanceInternal.dashboard.index", compact('pic', 'namaProject'));

    }


    public function filterDataCashAdvance(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'namaProject' => 'required',
            'namaPIC'     => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['status'=> false,'message' => 'Silahkan isi data nama project dan nama PIC'], 404);
        }

        try {
                
                // ambil nama project dan nama pic, di table project intetnal
                $datProjectInternal = DB::table('project_internal')
                ->where('nama_project', $request->namaProject)
                ->where('pic', $request->namaPIC)
                ->first();


                // Periksa apakah data ditemukan
                if (!$datProjectInternal) {
                    return response()->json(['status'=> false,'message' => 'Data tidak ditemukan'], 404);
                }

                 // Data chart pie 1 kiri
                $pic = $datProjectInternal->pic;
                $nominal = DB::table('project_internal')
                            ->where('nama_project', $request->namaProject)
                            ->where('nama_client', $datProjectInternal->nama_client)
                            ->sum('nominal');

                $total_client = DB::table('project_internal')
                                ->where('nama_project', $request->namaProject)
                                ->where('nama_client', $datProjectInternal->nama_client)
                                ->count();

                $total_project = DB::table('project_internal')
                                ->where('nama_project', $request->namaProject)
                                ->where('pic', $request->namaPIC)
                                ->count();

                //  data chart pie 2 kanan
                $totalNominalTMKI = DB::table('transactions_maker_internal')
                                                ->where('id_project_internal', $datProjectInternal->id)
                                                ->sum('nominal');
                $sisa = $nominal - $totalNominalTMKI;
                $totalPemakaian =  $totalNominalTMKI;

                // DATA CHART BHART CHART , BAWWAH WKK
                $dataProjects = CreateProject::where('principal_name', $request->name_principal)->get();
                $formattedData = [];
        

                 // Mengambil data project internal berdasarkan nama project dan pic
                $projects = DB::table('project_internal')
                ->where('nama_project', $request->namaProject)
                ->where('pic', $request->namaPIC)
                ->select('nama_project', DB::raw('count(*) as total'))
                ->groupBy('nama_project')
                ->get();

                // Log data untuk debugging
                Log::info('Projects Data: ', $projects->toArray());

                // Format data
                $formattedData = [];
                foreach ($projects as $project) {
                    $formattedData[] = [
                        'name' => $project->nama_project,
                        'y' => $project->total,
                        'drilldown' => 'ok', // Sesuaikan drilldown sesuai kebutuhan Anda
                    ];
                }

                // }

                
                return response()->json([$pic, $nominal, $total_client, $total_project, $sisa, $totalPemakaian, $formattedData]);





        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    
    }
}
