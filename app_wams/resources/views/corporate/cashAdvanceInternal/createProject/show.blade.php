
@extends('layouts.main')
@section("css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<section class="section">
    {{-- <div class="section-header">
        <h1>Detail Timeline</h1>
    </div> --}}
    <div class="card">
        <div class="card-header">
            {{-- <a href="" class="btn btn-secondary btn-sm mb-3">Back</a> --}}
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td>Id Project</td>
                    <td>:</td>
                    <td>{{ $cpt->id_project }}</td>
                </tr>
                <tr>
                    <td>Nama Project</td>
                    <td>:</td>
                    <td>{{$cpt->nama_project }}</td>
                </tr>
                <tr>
                    <td>Nama Client</td>
                    <td>:</td>
                    <td>{{ $cpt->nama_client }}</td>
                </tr>
                <tr>
                    <td>PIC</td>
                    <td>:</td>
                    <td>{{ $cpt->pic }}</td>
                </tr>
                <tr>
                    <td>Nominal</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($cpt->nominal) }}</td>
                </tr>
                <tr>
                    <td>Realisasi</td>
                    <td>:</td>
                    <td>{{ $cpt->realisasi }}</td>
                </tr>
                <tr>
                    <td>File</td>
                    <td>:</td>
                    <td><a href="/file_internal/{{ $cpt->file }}" download>Download</a></td>
                </tr>
            </table>

            <hr>

            <div class="pt-3 pb-3">
            @if(auth()->user()->name !== 'Bona Napitupulu')
                <a href="javascript:void(0)" class="btn btn-primary btn-sm maker" onclick="CreateTMInternal({{$cpt->id}})">
                    Transaction Maker <i class="fa fa-plus"></i>
                </a>
            @endif

            </div>
            <table class="table table-hover table-responsive table-bordered ">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Transaksi</th>
                        <th>Nominal</th>
                        <th>File</th>
                        @if(auth()->user()->name !== 'Bona Napitupulu')
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    $total=0;
                    $nominal2 = 0;
                    $sisa=0;
                    foreach($tmi as $tm){
                            ?>
                        {{-- <a href="{{route('penawaran.edit',$i->id)}}">     --}}
                            <tr  style="font-size: 13px;">
                                <td>{{$tm->tanggal}}</td>
                                <td>{{$tm->jenis_transaksi}} - {{$tm->nama_tujuan}} ({{$tm->keterangan}})</td>
                                <td>Rp. {{ number_format($tm->nominal) }}</td>
                                <td>
                                    <ul>
                                        <li>
                                            File Request : <br>
                                            <a href="/file_request/{{$tm->upload_request}}" download>Download</a>
                                        </li>
                                        <li>
                                            File Release : <br>
                                            <a href="/file_realese/{{$tm->upload_release}}" download>
                                                Download
                                            </a> 
                                        </li>
                                    </ul>
                                </td>
                                @if(auth()->user()->name !== 'Bona Napitupulu')
                                <td>
                                    <a class="btn btn-warning" onclick="moveTM({{$tm->id}})">Pindah Data</a>
                                    <a class="btn btn-primary" onclick="editTM({{$tm->id}})">Edit Data</a>
                                </td>
                                @endif
                            </tr>
                        {{-- </a>     --}}
                            <?php

                            // $nominal +=$tm->nominal;
                            $total += $tm->nominal;
                            $sisa = $cpt->nominal - $total;
                            // $diskon = $i->diskon;
                        }
                    ?>
                </tbody>
            </table>

            <p>Total Advance : Rp. {{number_format($total)}} </p>
            <p>Sisa : Rp. {{number_format($sisa)}}</p>
            
        



            <a href="{{ route('indexPJl') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2">
    
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('newassets/assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script src="{{ asset('newassets/assets/js/pages/datatables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function moveTM(id){
        $.get("{{url('editTMI')}}/"+ id,{},function(data,status){
            $("#exampleModalLabel").html('Pindah data')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }

    function editTM(id){
        $.get("{{url('editTransactionMakerInternal')}}/"+ id,{},function(data,status){
            $("#exampleModalLabel").html('Edit data')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }

    function CreateTMInternal(id){
        $.get("{{url('CreateTMInternal')}}/"+ id,{},function(data,status){
            $("#exampleModalLabel").html('Transaction Maker')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }
</script>
@endsection