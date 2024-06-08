<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\MasterCustomer;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MasterDataController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        CarbonInterval::setlocale('id');
        if ($request->ajax()) {
            $data = DB::table('master_customers')
                ->select('master_customers.*')->latest('master_customers.id');

            return DataTables::of($data)
                ->addColumn('created_at', function ($val) {
                    return Carbon::parse($val->created_at)->translatedFormat("Y-m-d");
                })
                ->addColumn('action', function ($val) {
                    $btn_edit = "<a href='#' class='btn btn-warning btn-sm text-white edit' data-id=".$val->id."><i class='fa fa-edit'></i></a>";
                    $btn_delete = ' <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-id="' . $val->id . '" title="Hapus data"><i class="fas fa-trash "></i></a>';


                    if (auth()->user()->name !== 'Bona Napitupulu') {
                        return  $btn_edit . ' ' . $btn_delete;
                    }

                    return null;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('search')) {
                        $instance->where('master_customers.company_name', 'LIKE', '%' . request()->search . '%');
                    }

                    if ($request->get('start_date')) {

                        $instance->whereBetween('master_customersq.created_at', [
                            Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01',
                            Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59'
                        ]);
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('corporate.ACDC.MasterDataClient.index');
    }

    public function create()
    {
        return view('corporate.ACDC.MasterDataClient.create');
    }

    public function store(Request $request)
    {
        MasterCustomer::create($request->all());

        return redirect('/master-data-customer')->with([
            'success' => 'Customer - ' . $request->company_name . ' berhasil dibuat'
        ]);
    }

    public function edit($id)
    {
        $mdc = MasterCustomer::find($id);

        return response()->json($mdc);
    }

    public function update(Request $request, $id)
    {
        $mdc = MasterCustomer::find($id);

        $mdc->update($request->all());

        return redirect('/master-data-customer')->with([
            'success' => 'Customer - ' . $request->mdc . ' berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        $mdc = MasterCustomer::find($id);
        $mdc->delete();

        return response()->json("Data $mdc->company_name berhasil dihapus");
    }
}
