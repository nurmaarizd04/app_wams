<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\CreateProject;
use App\Models\TransactionMakerACDC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CorporateController extends Controller
{
    public function index() {

        // ambil nama principal
        $principal = DB::table('create_principals')->select('principal_name')->get();

        return view("corporate.dashboard", compact('principal'));
    }


    public function filterData(Request $request) {

        try {
            $validate = Validator::make($request->all(), [
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors());
            }
                // jika filter ALL
                if ($request->name_principal == 'all') {

                    $gatData =  CreateProject::get();

                    // DATA CHART PIE
                    // data princple Total BMT dan Service
                    $name_principle = 'ALL';
                    $totalBmt = $gatData->sum('bmt');
                    $totalService = $gatData->sum('services');

                    // data project
                    $getDataMakerAdc = TransactionMakerACDC::get();

                    $total_final = $gatData->sum('total_final'); // ini di ambil dari table createProject

                    if (!$getDataMakerAdc) {
                        $total_advance = 0;
                        $sisa_saldo = 0;
                    } else {
                        $total_advance = $getDataMakerAdc->sum('nominal');
                        $sisa_saldo = $total_final - $total_advance;
                    }

                    // DATA CHART BHART CHART , BAWWAH WKK
                    // Ambil semua prinsipal dari tabel CreateProject
                    $principals = CreateProject::select('principal_name')->distinct()->get();

                    $formattedData = [];

                    // Loop melalui setiap prinsipal
                    foreach ($principals as $principal) {
                        $totalProjects = CreateProject::where('principal_name', $principal->principal_name)->count();
                        

                        // Format data sesuai dengan struktur yang diinginkan
                        $formattedData[] = [
                            'name' => $principal->principal_name,
                            'y' => $totalProjects,
                            'drilldown' => $principal->principal_name, 
                        ];
                    }


                    return response()->json([$name_principle, $totalBmt, $totalService, $total_advance, $total_final, $sisa_saldo, $formattedData]);
                
                } else {

                    // DATA CHART PIE
                        $getDataPrincpal =  CreateProject::where('principal_name', $request->name_principal)->first();

                        // Periksa apakah data ditemukan
                        if (!$getDataPrincpal) {
                            return response()->json(['status'=> false,'message' => 'Data tidak ditemukan'], 404);
                        }

                        // data chart Principal 
                        $name_principle = $getDataPrincpal->principal_name;
                        $bmt = $getDataPrincpal->bmt;
                        $services = $getDataPrincpal->services;
                        $getByIdProject =  $getDataPrincpal->id;

                        // ambil data nominal, di table berbeda
                        $getDataProjects = TransactionMakerACDC::where('cpt_id', $getDataPrincpal->id)->first();

                        // data chart Project
                        $total_advance = $getDataProjects->nominal ?? 0;
                        $total_final = $getDataPrincpal->total_final; // ini di ambil dari table createProject
                        // cek apakah data total advance / nominal ada?
                        if (!$getDataProjects) {
                            $sisa_saldo = 0;
                        } else {
                            $sisa_saldo = $total_final - $total_advance;
                        }
                        
                    
                        // DATA CHART BHART CHART , BAWWAH WKK
                        $dataProjects = CreateProject::where('principal_name', $request->name_principal)->get();
                        $formattedData = [];
                
                        // Loop melalui setiap prinsipal
                        foreach ($dataProjects as $dataProject) {
                            // Ambil jumlah total proyek untuk prinsipal saat ini
                            $totalProjects = CreateProject::where('project_name', $dataProject->project_name)->count();
                
                            // Format data sesuai dengan struktur yang diinginkan
                            $formattedData[] = [
                                'name' => $dataProject->project_name,
                                'y' => $totalProjects,
                                'drilldown' => $dataProject->project_name, // Anda dapat menyesuaikan drilldown sesuai kebutuhan Anda
                            ];
                        }

                    return response()->json([$name_principle, $bmt, $services, $total_advance, $total_final, $sisa_saldo, $getByIdProject, $formattedData]);

                }

        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    
    }
}
