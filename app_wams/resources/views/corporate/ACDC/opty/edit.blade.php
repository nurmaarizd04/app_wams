@extends('layouts.main')

@section('title', "Edit Project $data->project_name")

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <section class="section">
        <div class="section-header" style="padding-bottom: 30px">
            <h5>
                <a href="{{ route('project-opty-acdc.index') }}">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </h5>
        </div>
        <div class="container">
            <div class="card">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-header">
                    <div class="row">
                        <h6>Update Project {{ $data->project_name }}</h6>
                    </div>
                </div>
                <form action="{{ route('project-opty-acdc.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Project Opty</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text"
                                    class="form-control {{ $errors->has('code_opty') ? 'is-invalid' : '' }}"
                                    name="code_opty" placeholder="ID Project Opty" autocomplete="Off"
                                    value='{{ old('code_opty', $data->code_opty) }}' required>
                                <p class="text-danger">{{ $errors->first('code_opty') }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    name="project_name" placeholder="Project Name" autocomplete="Off"
                                    value='{{ old('project_name', $data->project_name) }}' required>
                                <p class="text-danger">{{ $errors->first('project_name') }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Account Manager</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control {{ $errors->has('account_manager') ? 'is-invalid' : '' }}"
                                    name="account_manager" placeholder="Nama Account Manager" autocomplete="Off"
                                    value='{{ old('account_manager', $data->account_manager) }}' required>
                                <p class="text-danger">{{ $errors->first('account_manager') }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Customer</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectric-wrapper selectric-form-control selectric-selectric">
                                    <select class="form-control select2" name="mdc_id" required>
                                        <option readOnly value="">----Pilih----</option>
                                        @foreach ($mdc as $item)
                                            <option value="{{ $item->id }}" {{ $data->mdc_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-danger">{{ $errors->first('mdc_id') }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nominal Penawaran</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="nominal" class="form-control uang calculate"
                                        value='{{ old('nominal', number_format($data->nominal)) }}' name="nominal" min=1
                                        required autocomplete="off">
                                    <p class="text-danger">{{ $errors->first('nominal') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Penawaran</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text"
                                    class="form-control {{ $errors->has('no_penawaran') ? 'is-invalid' : '' }}"
                                    name="no_penawaran" placeholder="No Penawaran" autocomplete="Off"
                                    value='{{ old('no_penawaran', $data->no_penawaran) }}' required>
                                <p class="text-danger">{{ $errors->first('no_penawaran') }}</p>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File</label>
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="file"
                                        accept = "application/pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    <p class="text-danger">{{ $errors->first('files') }}</p>
                                    <p class="text-muted">Biarkan kosong bila tidak ingin mengubah file</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js"
        integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.uang').mask('000.000.000.000.000', {
                reverse: true
            });
        });

        function numberWithCommas(x) {
            x = x.toString().split('.');
            x[0] = x[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return x[0]; // Only return the integer part without decimals
        }
    </script>
@endsection
