<?php

namespace App\Http\Controllers;

use App\Models\CreateClient;
use App\Models\CreatePrincipal;
use App\Models\CreateProject;
use App\Models\TransactionMakerACDC;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class CashAdvanceInternalController extends Controller
{
    
    public function indexPJl()
    {
        $dataProjetsInernal = DB::table('project_internal')->get();
        $idProject = DB::table('project_internal')->select('nama_project')->get();
        $namaPIC = DB::table('project_internal')->select('pic')->get();

        // dd($namaPIC);

        // // $tm = CreateProject::with('detail')->find('2');
        // $tm = DB::table('project_internal')->where('id', '4')->first();


        // return response()->json($tm->id);

        return view('corporate.cashAdvanceInternal.createProject.index',compact('dataProjetsInernal', 'idProject', 'namaPIC'));
    }


    public function getDataList(Request $request)
    {
        Carbon::setLocale('id');
        CarbonInterval::setlocale('id');

        if ($request->ajax()) {
            $data = DB::table('project_internal')
                ->select(
                    'project_internal.id',
                    'project_internal.id_project as code',
                    'project_internal.nama_project as name', 
                    'project_internal.nama_client',
                    'project_internal.pic',
                    'project_internal.nominal',
                    'project_internal.realisasi',  
                    'project_internal.created_at'
                )->latest('project_internal.id');

            return DataTables::of($data)
                ->addColumn('nominal', function($val) {
                    return "Rp. " . number_format($val->nominal, 2, ",", ".");
                })
                ->addColumn('created_at', function ($val) {
                    return Carbon::parse($val->created_at)->translatedFormat("Y-m-d");
                })
                ->addColumn('action', function ($val) {
                    $edit_url = route('editProjectInternal',$val->id);
                    $detail_url = route('showProjectInternal', $val->id);

                    $btn_edit = "<a href='$edit_url' class='btn btn-warning btn-sm text-white'><i class='fa fa-edit'></i></a>";
                    $btn_detail = "<a href='$detail_url' class='btn btn-info btn-sm text-white'><i class='fa fa-eye'></i></a>";
                    $btn_delete = ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="'.$val->id.'" title="Hapus data"><i class="fas fa-trash "></i></a>';
                    $transMaker = '<a href="javascript:void(0)" class="btn btn-primary btn-sm maker" onclick="CreateTMInternal('. $val->id .')">Transaction Maker</a>';

                    if (auth()->user()->name !== 'Bona Napitupulu') {
                        return $btn_detail . ' ' . $btn_edit . ' ' . $btn_delete . ' ' . $transMaker;
                    }

                    return $btn_detail;


                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('search')) {
                        $instance->whereRaw('LOWER(project_internal.nama_project) LIKE ?', ['%' . strtolower(request()->search) . '%']);
                    }

                    if (!empty($request->client)) {
                        $instance->where('nama_project', $request->client);
                    }

                    if (!empty($request->principal)) {
                        $instance->where('pic', $request->principal);
                    }

                    if ($request->get('start_date')) {

                        $instance->whereBetween('create_projects.created_at', [
                            Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01',
                            Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59'
                        ]);
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }
    }


    public function createProjectInternal ()
    {
        $cp = CreatePrincipal::all();
        $cc = CreateClient::all();
        return view ('corporate.cashAdvanceInternal.createProject.create',compact('cp','cc'));
    }


    public function saveProjectInternal(Request $request)
    {
        // Handle file upload
        $file = $request->file('file');
        $file_ext = $file->getClientOriginalName();
        $file_name = time() . $file_ext;
        $file_path = public_path('file_internal/');
        $file->move($file_path, $file_name);

        // Konversi nilai nominal dan cek batas maksimum
        $nominal = str_replace(".", "", $request->nominal);

        // Batas maksimum untuk tipe integer
        $maxIntegerValue = 2147483647;

        // Periksa apakah nominal melebihi batas maksimum
        if ($nominal > $maxIntegerValue) {
            return redirect('/index-createproject-internal')
                ->withErrors(['nominal' => 'Nominal tidak boleh lebih dari ' . number_format($maxIntegerValue, 0, ',', '.')])
                ->withInput();
        }

        // Insert data ke tabel project_internal
        DB::table('project_internal')->insert([
            "id_project"        => $request->id_project,
            "nama_project"      => $request->project_name,
            "nama_client"       => $request->client_name,
            "pic"               => $request->pic,
            "file"              => $file_name,
            "realisasi"         => '-',
            "nominal"           => $nominal,
        ]);

        // Redirect dengan pesan sukses
        return redirect('/index-createproject-internal')->with([
            'success' => 'Project Internal - ' . $request->project_name . ' berhasil dibuat'
        ]);
    }


    public function editProjectInternal($id)
    {
        $cp = CreatePrincipal::all();
        $cc = CreateClient::all();

        $data = DB::table('project_internal')->where('id', $id)->first();   
        return view('corporate.cashAdvanceInternal.createProject.edit', compact('cp','cc', 'data'));
    }


    public function updateProjectInternal(Request $request, $id)
    {
        $data = DB::table('project_internal')->where('id', $id)->first();   

        if (!empty($request->file)) {
            unlink("/file_internal/$data->file");
            $extention = $request->file('file')->getClientOriginalExtension();
            $name = base64_encode(random_bytes(18)) . time();
            $request->file->move(public_path('file_hitungan'), $name . '.' . $extention);
            $fileName = $name . '.' . $extention;
        }

        DB::table('project_internal')->where('id', $id)->update([
            "id_project"        => $request->id_project,
            "nama_project"      => $request->project_name,
            "nama_client"       => $request->client_name,
            "pic"               => $request->pic,
            "file"              => empty($request->file) ? $data->file : $fileName,
            "realisasi"         => $request->realisasi,
            "nominal"           => str_replace(".", "", $request->nominal),
        ]);

        return redirect('/index-createproject-internal')->with([
            'success' => 'Project Internal - '. $request->project_name . ' berhasil dibuat'
        ]);
    }


    public function showProjectInternal($id)
    {
        $cpt = DB::table('project_internal')->where('id', $id)->first();   
        $tmi = DB::table('transactions_maker_internal')->where('id_project_internal', $cpt->id)->get();   


        return view('corporate.cashAdvanceInternal.createProject.show', compact('cpt', 'tmi'));
    }


    public function deleteProjectInternal($id)
    {
        // Ambil data proyek berdasarkan ID
        $idProjectInternal = DB::table('project_internal')->where('id', $id)->first();
        $idTransaksiInternal =  DB::table('transactions_maker_internal')->where('id_project_internal', $idProjectInternal->id)->first();

        if (!$idTransaksiInternal) {
            DB::table('project_internal')->where('id', $idProjectInternal->id)->delete();

            return response()->json("Data $idProjectInternal->nama_project berhasil dihapus");

        } else {

            DB::table('project_internal')->where('id', $idProjectInternal->id)->delete();
            DB::table('transactions_maker_internal')->where('id', $idTransaksiInternal->id)->delete();

            return response()->json("Data $idProjectInternal->nama_project berhasil dihapus");
        }
    }
    

    // transaction maker
    public function indexTMI()
    {
        $tmadc = TransactionMakerACDC::all();
        return view('corporate.ACDC.TransactionMakerACDC.indexTM-ACDC',compact('tmadc'));
    }


    public function CreateTMInternal($id)
    {
        $item = DB::table('project_internal')->where('id', $id)->first();
        // $item= CreateProject::find($id);
        // return response()->json($item);
        return view('corporate.cashAdvanceInternal.transactionMakerInternal.index',compact('item'));
    }


    public function saveTMI(Request $request)
    {   
        $file_request = $request -> file('upload_request');
        $file_ext_request = $file_request -> getClientOriginalName();
        $file_name_request = time(). $file_ext_request;
        $file_path_request = public_path ('file_request/');
        $file_request -> move ($file_path_request, $file_name_request);

        // $file_release = $request -> file('upload_release');
        // $file_ext_release = $file_release -> getClientOriginalName();
        // $file_name_release = time(). $file_ext_release;
        // $file_path_release = public_path ('file_release/');
        // $file_release -> move ($file_path_release, $file_name_release);

        TransactionMakerACDC::create([
            "tanggal" => $request->tanggal,
            "jenis_transaksi" => $request->jenis_transaksi,
            "nama_tujuan" => $request->nama_tujuan,
            "nominal" => $request->nominal,
            "keterangan" => $request->keterangan,
            "upload_request" => $request->upload_request = $file_name_request,
            "upload_release" => '-'
        ]);

        return redirect()->back();
    }


    public function saveTMACInternal(Request $request,$id)
    {
        // $tm = CreateProject::with('detail')->find($id);
        $tm = DB::table('project_internal')->where('id', $id)->first();


        $file_request = $request->file('upload_request');
        $file_ext_request = $file_request->getClientOriginalName();
        $file_name_request = time(). $file_ext_request;
        $file_path_request = public_path ('file_request_internal/');
        $file_request->move($file_path_request, $file_name_request);

        // $file_release = $request->file('upload_release');
        // $file_ext_release = $file_release -> getClientOriginalName();
        // $file_name_release = time(). $file_ext_release;
        // $file_path_release = public_path('file_request_internal/');
        // $file_release->move($file_path_release, $file_name_release);


        DB::table('transactions_maker_internal')->insert([
            "id_project_internal" => $tm->id,
            "tanggal"           => $request->tanggal,
            "jenis_transaksi"   => $request->jenis_transaksi,
            "nama_tujuan"       => $request->nama_tujuan,
            "nominal"           => $request->nominal,
            "keterangan"        => $request->keterangan,
            "upload_request"    => $file_name_request,
            "upload_release"    => '-',
        ]);

        return redirect(route('showProjectInternal', $id))->with([
            'success' => 'Transaction Maker Projek - '. $tm->nama_project . ' berhasil dibuat'
        ]);
    }

    public function editTMI($id)
    {

        // $getIdTransactionMakerInternal = DB::table('transactions_maker_internal')->where('id', $id)->first();
        $item = DB::table('transactions_maker_internal')->where('id',$id)->first();
        $data_project_internal = DB::table('project_internal')->where('id', $item->id_project_internal)->first();


        $data = DB::table('project_internal')->pluck('nama_client', 'id')->toArray();
        $in_client = array_unique($data);

        return view('corporate.cashAdvanceInternal.transactionMakerInternal.editTMI',compact('item', 'in_client', 'data_project_internal'));
    }

    public function getPojectByClientInternal(Request $request)
    {
        $data = DB::table('project_internal')
            ->select('id', 'nama_project', 'id_project', 'nama_client')
            ->where("nama_client", $request->client)
            ->get();
            
        return response($data);
    }


    public function updateTMACDCINTERNAL(Request $request, $id)
    {
        // $editProjectInternal = DB::table('project_internal')->where('id', $id)->first();
        $edittm = DB::table('transactions_maker_internal')->where('id', $request->id)->first();

        try {
            

            DB::table('transactions_maker_internal')->where('id', $id)->update([
                "nama_tujuan"                   => empty($request->nama_tujuan) ? $edittm->nama_tujuan : $request->nama_tujuan ?? '-',
                "jenis_transaksi"               => empty($request->jenis_transaksi) ? $edittm->jenis_transaksi : $request->jenis_transaksi,
                "nominal"                       => empty($request->nominal) ? $edittm->nominal : $request->nominal,
                "keterangan"                    => empty($request->keterangan) ? $edittm->keterangan : $request->keterangan,
                "id_project_internal"           => $request->cpt_id,
            ]);
            // DB::table('project_internal')->where('id', $id)->update([
            //     "nama_project"                  => $request->project_name,
            //     // "id_project"                    => $request->id_project,
            // ]);
    
            
            return redirect()->back()->with('success', 'Update Transaction Maker berhasil');
            
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function updateDataTMACDCINTERNAL(Request $request, $id)
    {

        $edittm = DB::table('transactions_maker_internal')->where('id', $id)->first();

        if (!$edittm) {
            return response()->json(['status'=> false,'message' => 'Data tidak ditemukan'], 404);
        }
        

        try {
            

            DB::table('transactions_maker_internal')->where('id', $id)->update([
                "nama_tujuan"                   => $request->nama_tujuan ?? $edittm->nama_tujuan ?? '-',
                "jenis_transaksi"               => $request->jenis_transaksi ?? $edittm->jenis_transaksi ?? '-' ,
                "nominal"                       => $request->nominal ?? $edittm->nominal ?? '-',
                "keterangan"                    => $request->keterangan ?? $edittm->keterangan ?? '-',
                "id_project_internal"           => $request->cpt_id ?? $edittm->id_project_internal,
            ]);
        
            
            return redirect()->back()->with('success', 'Update Transaction Maker berhasil');
            
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function editTransactionMakerInternal($id)
    {
        // $item = TransactionMakerACDC::with('cpt')->find($id);

        $item = DB::table('transactions_maker_internal')->where('id', $id)->first();

        return view('corporate.cashAdvanceInternal.transactionMakerInternal.editDataTMKI',compact('item'));
    }

}
