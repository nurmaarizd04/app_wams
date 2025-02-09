@extends('layouts.main')
@section('content')
   
    <section class="section">
      <div class="card">
        <div class="card-header">
          <h1>Detail WO</h1>
        </div>

        <div class="card-body">
          <form action="{{route('updateStatusApproval', $detailId->id)}}" method="POST" enctype="multipart/form-data"> 
                  @method('put')
                  {{csrf_field()}}
                  {{-- no_so --}}
                <div class="form-group">
                  <label>No So</label>
                  <input type="text" name="no_so" class="form-control" value="{{$detailId->no_so}}" readonly>
                </div>
                  {{-- kode project --}}
                <div class="form-group">
                  <label>Kode Project</label>
                  <input type="text" name="kode_project" class="form-control" value="B{{$detailId->kode_project}}" readonly>
                </div>
                {{-- nama institusi --}}
                <div class="form-group">
                  <label>Nama Insitusi</label>
                  <input type="text" name="institusi" class="form-control" value="{{$detailId->institusi}}" readonly>
                </div>
                {{-- nama project--}}
                <div class="form-group">
                  <label>Nama project</label>
                  <input type="text" name="project" class="form-control" value="{{$detailId->project}}" readonly>
                </div>
                {{-- nama AM--}}
                <div class="form-group">
                  <label>Nama AM</label>
                  <input type="text" name="name_user" class="form-control" value="{{$detailId->name_user}}" readonly>
                </div>
                {{-- HPS--}}
                <div class="form-group">
                  <label>HPS</label>
                  <input type="text" name="hps" class="form-control" value="{{$detailId->hps}}" readonly>
                </div>
                {{-- status approve--}}
                {{-- <div class="form-group">
                  <label>Status Approve</label>
                  <input type="text" name="status_approve" class="form-control" value="{{$detailId->status}}">
                </div> --}}
                @if (Auth::user()->hasRole('Management'))
                <div class="form-group row" onchange="">
                  <div class="col-sm-9">
                    <p class="text-danger">Status : {{$detailId->status}}</p>
                    <select class="form-control select2" style="width: 100%;" name="status" id="status" autofocus onchange="myFunction()">
                      <option></option>
                      <option value="Approve">Approve</option>
                      <option value="Reject">Reject</option>
                    </select>
                  </div>
                </div>
                @endif
                    

                <div id="tes" class="tes form-group d-none" >                  
                  <label>Note</label>
                  <input type="text" name="note" class="form-control" value="">
                </div>
                    
                <div class="d-flex justify-content-between mt-5">
                  
                  <a href="/inputTwo" class="btn btn-danger ">Back</a>
                  @if (Auth::user()->hasRole('Management'))
                  <button class="btn btn-primary d-flex">Submit</button>
                  @endif

                </div>
            </form>
              </div>
      </div>
    </section>

    <script>
      function myFunction() {
        var x = document.getElementById("status").value;
        if (x == 'Reject') {
          // jika reject munculkam note
          console.log(x);
          var bukaNote = document.querySelector('.tes');
          bukaNote.classList.add('d-block')          
        }

        // jika approve -> note hilangkan
        if (x == 'Approve') {
          var bukaNote = document.querySelector('.tes');
            bukaNote.classList.remove('d-block')
          }
        // document.getElementById("demo").innerHTML = "You selected: " + x;
      }
      </script>

      

   
@endsection