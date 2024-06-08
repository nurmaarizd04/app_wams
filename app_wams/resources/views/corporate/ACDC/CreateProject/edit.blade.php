@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('title', "Edit Project $data->project_name")

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
                        <h6>Edit Projek - ({{ $data->project_name }})</h6>
                    </div>
                </div>
                <form action="/updateAcdcP/{{ $data->id }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" placeholder="ID Project" id="code"
                                    name="id_project" value='{{ old('id_project', $data->id_project) }}' autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project Name</label>
                            <div class="col-sm-12 col-md-7">
                                <span class="form-control" readonly>{{ $data->project_name }}</span>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Principal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectric-wrapper selectric-form-control selectric-selectric">
                                    <select class="form-control select2" name="principal_name" required>
                                        <option readOnly value="">----Pilih----</option>
                                        @foreach ($cp as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $data->principal_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->principal_name }}
                                            </option>
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
                                            <option
                                                value="{{ $item->id }}"{{ $data->client_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->client_name }}
                                            </option>
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
                                        accept="application/pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    <p class="text-warning text-sm pt-2">Biarkan kosong jika tidak ingin mengganti file</p>
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
                                        value='{{ old('bmt', $data->bmt) }}' name="bmt" min=1 autocomplete="off"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="type_wapu" id="type_wapu" required>
                                    <option value="">------PILIH------</option>
                                    <option value="yes" {{ $data->type_wapu == 'yes' ? 'selected' : '' }}>Wapu</option>
                                    <option value="no" {{ $data->type_wapu == 'no' ? 'selected' : '' }}>Non Wapu
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4" id="showWapu" style="display: none">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">WAPU</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" id="wapu" class="form-control uang calculate" name="wapu"
                                        min=1 value='{{ old('wapu', $data->wapu) }}' required autocomplete="off">
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
                                    <input type="text" id="service" class="form-control uang calculate"
                                        name="services" min=1 value='{{ old('services', $data->services) }}'
                                        autocomplete="off" required>
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
                                        aria-label="Amount" name="lain" value='{{ old('lain', $data->lain) }}' min=0
                                        autocomplete="off" required>
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
                                    <input type="hidden" name="subtotal" id="subtotal" value="{{ $data->subtotal }}">
                                    <div id="displaySubtotal" class="form-control">Rp.
                                        {{ number_format($data->subtotal) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bunga Admin</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control uang calculate" id="admin_bunga"
                                        name="bunga_admin" min="1" max="100" placeholder=""
                                        autocomplete="off" value='{{ old('bunga_admin', $data->bunga_admin) }}' required>
                                    <div class="input-group-append">
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
                                    <input type="text" id="decrement_cost" class="form-control uang calculate"
                                        name="biaya_pengurangan" min=0 required autocomplete="off"
                                        value='{{ old('biaya_pengurangan', $data->biaya_pengurangan) }}'>
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
                                    <input type="hidden" name="final_subtotal" id="finalSubtotal"
                                        value="{{ $data->total_final }}">
                                    <div id="displayFinalSubtotal" class="form-control">
                                        Rp. {{ number_format($data->total_final) }}
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-muted">Final Subtotal <b>dari</b> Subtotal - Biaya admin - Biaya Lain
                            </p>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-secondary" type="reset">Reset</button>
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
        function calculateSubtotals() {
            let bmt_awal = parseInt($("#bmt_awal").val().replace(/[\D\s\._\-]+/g, "")) || 0;
            let service = parseInt($("#service").val().replace(/[\D\s\._\-]+/g, "")) || 0;
            let other = parseInt($("#other").val().replace(/[\D\s\._\-]+/g, "")) || 0;
            let wapu = parseInt($("#wapu").val().replace(/[\D\s\._\-]+/g, "")) || 0;
            let decrement_cost = parseInt($("#decrement_cost").val().replace(/[\D\s\._\-]+/g, "")) || 0;

            let subtotal = bmt_awal + service + other + wapu;
            let admin_bunga = parseFloat($("#admin_bunga").val()) || 0;
            let bunga_admin = Math.round((admin_bunga / 100) * subtotal);

            $("#admin_cost").val(bunga_admin);
            $("#displayCost").text(numberWithCommas(bunga_admin));

            $("#subtotal").val(subtotal);
            $("#displaySubtotal").text("Rp. " + subtotal.toLocaleString());

            let finalSubtotal = subtotal - bunga_admin - decrement_cost;
            $("#finalSubtotal").val(finalSubtotal);
            $("#displayFinalSubtotal").text("Rp. " + finalSubtotal.toLocaleString());
        }

        $(document).ready(function() {
            calculateSubtotals();

            $('.calculate').on('keyup change', function() {
                calculateSubtotals();
            });

            $('#type_wapu').change(function() {
                let typeWapu = $(this).val();
                if (typeWapu == 'yes') {
                    $('#showWapu').show();
                    $('#wapu').prop('required', true);
                } else {
                    $('#showWapu').hide();
                    $('#wapu').prop('required', false);
                    $('#wapu').val(0); // Reset WAPU field to 0 when not needed
                }
                calculateSubtotals();
            });
        });

        $(document).on('keyup', '.uang', function() {
            $(this).val(formatRupiah(this.value));
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function numberWithCommas(x) {
            x = x.toString().split('.');
            x[0] = x[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return x[0]; // Only return the integer part without decimals
        }
    </script>
@endsection
