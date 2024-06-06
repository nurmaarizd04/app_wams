@extends('layouts.main')

@section('title', 'Create Project')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <section class="section">
        <div class="section-header" style="padding-bottom: 30px">
            <h5>
                <a href="{{ route('indexCPT') }}">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </h5>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <h6>Create New Data</h6>
                    </div>
                </div>
                <form action="{{ route('svcpt') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" placeholder="ID Project" id="code"
                                    name="id_project" value='{{ old('id_project', '') }}' autocomplete="Off" required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    name="project_name" placeholder="Project Name" autocomplete="Off"
                                    value='{{ old('project_name', '') }}' required>
                                <p class="text-danger">{{ $errors->first('project_name') }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">principal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectric-wrapper selectric-form-control selectric-selectric">
                                    <select class="form-control select2" name="principal_name" required>
                                        <option readOnly value="">----Pilih----</option>
                                        @foreach ($cp as $item)
                                            <option value="{{ $item->principal_name }}">{{ $item->principal_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Client</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectric-wrapper selectric-form-control selectric-selectric">
                                    <select class="form-control select2" name="client_name" required>
                                        <option readOnly value="">----Pilih----</option>
                                        @foreach ($cc as $item)
                                            <option value="{{ $item->client_name }}">{{ $item->client_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File</label>
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="file"
                                        accept = "application/pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">BMT - Awal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="bmt_awal" class="form-control uang calculate"
                                        value='{{ old('bmt', '') }}' name="bmt" min=1 required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">WAPU</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="wapu" class="form-control uang calculate" name="wapu"
                                        min=1 value='{{ old('wapu', '') }}' required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Service</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="service" class="form-control uang calculate" name="services"
                                        min=1 value='{{ old('services', '') }}' required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lain-lain</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="other" class="form-control uang calculate"
                                        aria-label="Amount" name="lain" value='{{ old('lain', '') }}' min=0 required
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">SubTotal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="hidden" name="subtotal" id="subtotal" value="">
                                    <div id="displaySubtotal" class="form-control"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bunga Admin</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control uang" id="admin_bunga" name="bunga_admin"
                                        min="1" max="100" placeholder="" required autocomplete="off">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Biaya Admin</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="hidden" name="biaya_admin" id="admin_cost">
                                    <div id="displayCost" class="form-control">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Biaya Lain</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="decrement_cost" class="form-control uang"
                                        aria-label="Amount" name="biaya_pengurangan" min=0 required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Final Subtotal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <div id="displayFinal" class="form-control">0</div>
                                    <input type="hidden" id="final_subtotal" class="form-control" name="final_subtotal"
                                        min=1>
                                </div>
                                <p class="text-sm text-muted">Final Subtotal <b>dari</b> Subtotal - Biaya admin - Biaya
                                    Lain</p>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Create</button>
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
            function parseNumber(value) {
                // Remove all dots and replace comma with dot for decimal conversion
                value = value.replace(/\./g, "").replace(/,/g, ".");
                return isNaN(value) ? 0 : parseFloat(value);
            }

            function numberWithCommas(x) {
                x = x.toString().split('.');
                x[0] = x[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return x[0]; // Only return the integer part without decimals
            }

            function calculateSubtotal() {
                let value_bmt = parseNumber($("#bmt_awal").val());
                let service = parseNumber($("#service").val());
                let wapu = parseNumber($("#wapu").val());
                let other = parseNumber($("#other").val());
                let admin_bunga = parseNumber($("#admin_bunga").val());

                let subtotal = value_bmt + wapu + service + other;
                let bunga_admin = (admin_bunga / 100) * subtotal;

                let roundedSubtotal = Math.round(subtotal);
                let roundedBungaAdmin = Math.round(bunga_admin);

                $("#subtotal").val(roundedSubtotal);
                $("#displaySubtotal").text(numberWithCommas(roundedSubtotal));
                $("#admin_cost").val(roundedBungaAdmin);
                $("#displayCost").text(numberWithCommas(roundedBungaAdmin));
            }

            function calculateFinalSubtotal() {
                let subtotal = parseNumber($("#subtotal").val());
                let admin_cost = parseNumber($("#admin_cost").val());
                let decrement_cost = parseNumber($("#decrement_cost").val());

                let final_subtotal = subtotal - admin_cost - decrement_cost;
                let roundedFinalSubtotal = Math.round(final_subtotal);

                $("#displayFinal").text(numberWithCommas(roundedFinalSubtotal));
                $("#final_subtotal").val(roundedFinalSubtotal);
            }

            $(".calculate").blur(function(e) {
                e.preventDefault();
                calculateSubtotal();
            });

            $("#admin_bunga, #decrement_cost").blur(function(e) {
                e.preventDefault();
                calculateSubtotal();
                calculateFinalSubtotal();
            });

            $("#decrement_cost").blur(function(e) {
                e.preventDefault();
                calculateFinalSubtotal();
            });

            $("#code_generate").on("click", function() {
                var generate = Math.floor(new Date().valueOf() * Math.random());
                $("#code").val(generate);
            });

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
