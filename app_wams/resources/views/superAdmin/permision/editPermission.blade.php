@extends('layouts.main')
@section('content')
    <section class="section">
      <div class="card">
        <div class="card-header">
          <h1>Welcome</h1>
        </div>
        <div class="card-body">
          <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4>Permission</h4>
              </div>
              <div class="card-body">
                <form action="{{route('/dashboard/updatePermission', $getid->id)}}" method="POST" enctype="multipart/form-data">
                  {{csrf_field()}}
                <div class="form-group">
                  <label>Add Permission</label>
                  <input type="text" name="name" class="form-control" placeholder="{{$getid->name}}">
                </div>
                <div class="d-flex  justify-content-between mt-5">
                  <a href="/dashboardPermision" class="btn btn-lg btn-primary text-white">Back</a>
                  <button class="btn btn-lg btn-success">Submit</button>
                </div>
                </form>
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </section>
@endsection

