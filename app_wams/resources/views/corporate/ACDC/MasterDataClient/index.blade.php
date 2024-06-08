@extends('layouts.main')

@section('title', 'Master Data Customer')

@section('css')
    <link rel="stylesheet" href="{{ asset('newassets/assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
    <style>
        .table-loader {
            visibility: hidden;
        }

        .table-loader:before {
            visibility: visible;
            display: table-caption;
            content: " ";
            width: 100%;
            height: 600px;
            background-image: linear-gradient(rgba(235, 235, 235, 1) 1px, transparent 0),
                linear-gradient(90deg, rgba(235, 235, 235, 1) 1px, transparent 0),
                linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5) 15%, rgba(255, 255, 255, 0) 30%),
                linear-gradient(rgba(240, 240, 242, 1) 35px, transparent 0);
            background-repeat: repeat;
            background-size: 1px 35px,
                calc(100% * 0.1666666666) 1px,
                30% 100%,
                2px 70px;
            background-position: 0 0,
                0 0,
                0 0,
                0 0;
            animation: shine 0.5s infinite;
        }

        @keyframes shine {
            to {
                background-position: 0 0,
                    0 0,
                    40% 0,
                    0 0;
            }
        }

        .picker__theme_dark {
            background-color: black;
            color: white;
        }

        .picker__theme_dark li:hover {
            color: black
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="card">
                <div class="alert">
                    <h2 class="text-capitalize text-center">List Master Data Customer</h2>
                </div>
            </div>
        </div>
        <div class="card" style="border-radius: 2em">
            <div class="card-header">
                <div class="card-header">
                    <div class="row">
                        <div class="col pull-left"></div>
                        <div class="col pull-right">
                            <div style="float: right;">
                                @if (auth()->user()->name !== 'Bona Napitupulu')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createModal">
                                        Create
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-6 pull-left">
                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        <div id="date-range" class="form-control">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span> <i class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3 pull-right">
                                <input type="text" class="form-control" placeholder="Search..." id="search"
                                    autocomplete="Off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered " id="project">
                        <thead>
                            <th>No</th>
                            <th>Nama Perusahaan</th>
                            <th>Nomor NPWP</th>
                            <th>Nama PIC</th>
                            <th>No Telp PIC</th>
                            <th>Email PIC</th>
                            <th>Alamat NPWP</th>
                            <th>CreatedAt</th>
                            <th>Action</th>
                        </thead>
                    </table>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('master-data-customer.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Perusahaan</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="Nama Perusahaan"
                                        name="company_name" value='{{ old('company_name', '') }}' autocomplete="Off"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor NPWP</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="Nomor NPWP" name="no_npwp"
                                        value='{{ old('no_npwp', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat
                                    Perusahaan</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="form-control" rows="10" name="address" placeholder="Alamat Perusahaan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama PIC</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="Nama PIC" name="pic_name"
                                        value='{{ old('pic_name', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telp PIC</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="No Telp PIC"
                                        name="phone_pic" value='{{ old('phone_pic', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email PIC</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control" placeholder="No Telp PIC"
                                        name="email_pic" value='{{ old('email_pic', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama
                                    Perusahaan</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="Nama Perusahaan"
                                        id="company_name" name="company_name" value='{{ old('company_name', '') }}'
                                        autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor NPWP</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="Nomor NPWP" id="no_npwp"
                                        name="no_npwp" value='{{ old('no_npwp', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat
                                    Perusahaan</label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea class="form-control" rows="10" name="address" id="address" placeholder="Alamat Perusahaan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama PIC</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="Nama PIC" id="pic_name"
                                        name="pic_name" value='{{ old('pic_name', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telp PIC</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" placeholder="No Telp PIC" id="phone_pic"
                                        name="phone_pic" value='{{ old('phone_pic', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email PIC</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control" placeholder="No Telp PIC" id="email_pic"
                                        name="email_pic" value='{{ old('email_pic', '') }}' autocomplete="Off" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('js/masterDataCustomer.js') }}"></script>

    <script>
        $(init)

        function init() {
            if ($('body').hasClass('theme-dark')) {
                $(".ranges").addClass('picker__theme_dark')
            } else {
                $('.ranges').removeClass('picker__theme_dark')
            }
        }
        $('input[type="checkbox"]').click(function() {
            if ($('body').hasClass('theme-dark')) {
                $(".ranges").addClass('picker__theme_dark')
            } else {
                $('.ranges').removeClass('picker__theme_dark')
            }
        })
    </script>
@endsection
