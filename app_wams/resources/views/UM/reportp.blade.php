@extends('layouts.main')
@section('content')
    <section class="section">
      <div class="section-header">
        <h1>Task Progress Report</h1>
      </div>
      <div class="card">
        <div class="card-body">
            <div class="text-right">
              <button type="button" class="btn btn-warning ml-2" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">Filter Data</button>
              <button class="btn btn-success ml-2" onclick="tableToExcel('task')">Export</button>
            </div>
            <div class="table-responsive">
              <table id="task" class="table table-hover mt-2 table-bordered table-striped">
                <thead>
                  <tr>
                    <th scope="col">Kode Project</th>
                    <th scope="col">Nama Client</th>
                    <th scope="col">Nama Project</th>
                    {{-- <th scope="col">Estimated Amount</th> --}}
                    <th scope="col">Nama AM</th>
                    <th scope="col">Nama PM</th>
                    <th scope="col">Nama Technical</th>
                    <th scope="col">Pekerjaan</th>
                    <th scope="col">Status Pekerjaan</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($dataM as $d) 
                  <tr>
                    <td>{{$d->timelines->lists->kode_project}}</td>
                    <td>{{$d->timelines->lists->nama_institusi}}</td>
                    <td>{{$d->timelines->lists->nama_project}}</td>
                    {{-- <td>{{$d->timelines->lists->hps}}</td> --}}
                    <td>{{$d->timelines->lists->nama_sales}}</td>
                    <td>{{$d->timelines->lists->nama_pm}}</td>
                    <td>{{$d->name_technikal}}</td>
                    <td>{{$d->job_essay}}</td>
                    <td>
                    @if ($d->status == 'OnProgress')
                    <div class="badge bg-warning">{{$d->status}}</div>
                    @elseif ($d->status == 'Issue')
                    <div class="badge bg-danger">{{$d->status}}</div>
                    @elseif ($d->status == 'Done')
                    <div class="badge bg-success">{{$d->status}}</div>
                    @endif 
                    </td>
                    <td>
                      <a target="" href="{{url('/umViewTechnikal', $d->id)}}" class="btn text-white" style="background-color: #0EC8F8">
                        Detail
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </section>
     <!-- Modal -->
  <div id="exampleModalScrollable" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter Data Table</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/reportp" method="GET">
        <div class="modal-body">
            <label for="dari">Dari</label>
            <input type="date" class="form-control" id="dari" name="dari_tgl">
            <label for="sampai" class="mt-2">Sampai</label>
            <input type="date" class="form-control" id="sampai" name="sampai_tgl">
            <label for="sampai" class="mt-2">Status</label>
            <select class="form-control" name="status">
              <option value="">All Status</option>
              <option value="Done">Done</option>
              <option value="OnProgress">On Progress</option>
              <option value="Issue">Issue</option>
            </select>
            <label for="sampai" class="mt-2">Nama Technikal</label>
            <select class="form-control" name="name_technikal">
              <option value="">All Technikal</option>
              @foreach ($Tech as $l)
                @foreach($l->users as $a)
                <option value="{{$a->name}}">{{$a->name}}</option>
                @endforeach
              @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Pilih</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  
    <script src="../assets/js/export_exel.js"></script>
@endsection