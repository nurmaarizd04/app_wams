@extends('layouts.main')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

<section class="section">
<div class="section-header">
        <h1>List Project Technikal</h1>
    </div>
  <div class="card">
    <div class="card-body">
    <form action="{{route ('simpan-dok')}}" method="POST" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="row">
      <div class="col">
        <label for="id" class="form-label" style="font-weight: bold; color:black">ID</label>
        <select id="id" class="form-control" name="cobas_id" >
          @foreach($list as $v)
          <option value="{{$v->id}}">{{$v->id}}</option>
          @endforeach
        </select>
        @error('cobas_id')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>

      
      <div class="col-sm-3">
        <label for="code" class="form-label" style="font-weight: bold; color:black">Nama Client</label>
        <input type="text" id="code" class="form-control @error('nama_sales') is-invalid @enderror" readonly required>
        @error('nama_sales')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>

      <div class="col-sm-3">
        <label for="institusi" class="form-label" style="font-weight: bold; color:black">Nama Sales</label>
        <input type="text"  id="institusi" class="form-control @error('nama_sales') is-invalid @enderror" readonly required>
        @error('nama_sales')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>
    </div>
    <br>
  

    <div class="row g-3">
    

      <div class="col-sm-6">
        <label for="project" class="form-label" style="font-weight: bold; color:black">Nama Project</label>
        <input type="text" id="project" class="form-control @error('nama_project') is-invalid @enderror" readonly required>
        @error('nama_project')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>
    

      <div class="col-sm-3">
        <label for="jenis_dokumen" class="form-label" style="font-weight: bold; color:black">Jenis Dokumen</label>
        <select name="jenis_dokumen" id="jenis_dokumen" class="form-control @error('jenis_dokumen') is-invalid @enderror">
          <option selected>Pilih Dokumen</option>
          <option value="pdf">Pdf</option>
          <option value="doc">Doc</option>
          <option value="excel">Excel</option>
        </select>
        @error('jenis_dokumen')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>

      <div class="col-sm">
        <label for="upload_dokumen" class="form-label" style="font-weight: bold; color:black">Upload Dokumen</label>
        <input type="file" name="upload_dokumen[]" multiple="multiple" class="form-control @error('upload_dokumen') is-invalid @enderror">
        @error('upload_dokumen')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>
    </div>

    <br>
    

      <div class="col-sm-5">
        <label for="id_label_multiple" class="form-label">Sign Tecnikal</label>
        <select class="form-control select2" multiple="multiple" name="user_id[]">
          @foreach ($user as $l) 
          @foreach($l->users as $a)
          <option value="{{$a->id}}">{{$a->name}}</option>
          @endforeach
          @endforeach
        </select>
        @error('user_id')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
      </div>
      <br>
      <button type="submit" class="btn btn-primary btn-sm">Save</button>
    </div>
    
    
  </form>
    </div>
  </div>
  <!-- Nama CLient -->
  

  @endsection
  @section('js')

  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script>
    $('#id').change(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        method: "POST",
        type: "JSON",
        data: {
          id: this.value
        },
        url: "/work_order"
      }).done(function(res) {
        $("#code").val(res.code)
        $("#institusi").val(res.institusi)
        $("#project").val(res.project)
      })
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2();
    });
  </script>

  @endsection