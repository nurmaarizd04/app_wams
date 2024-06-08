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
                    <h2 class="text-capitalize text-center">List Project Opty</h2>
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
                                    <a href="{{ route('project-opty-acdc.create') }}" class="btn btn-primary">
                                        Create
                                    </a>
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
                                <input type="text" class="form-control" placeholder="Search Opty name" id="search"
                                    autocomplete="Off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered " id="project">
                        <thead>
                            <th>No</th>
                            <th>ID Opty</th>
                            <th>Nama Project</th>
                            <th>Nominal Penawaran</th>
                            <th>Nomor Penawaran</th>
                            <th>CreatedAt</th>
                            <th>Action</th>
                        </thead>
                    </table>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="moveModal" tabindex="-1" aria-labelledby="title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title">Pindah Ke Project</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="moveForm" method="POST">
                        @csrf
                        <div class="modal-body" id="modal-body-content">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Export Data
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="type" class="form-control" id="type" required>
                                        <option value="">------PILIH------</option>
                                        <option value="exist">Data sudah ada</option>
                                        <option value="new">Data baru</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-4" id="existProject" style="display: none">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Pilih Project
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="project_id" class="form-control select2" style="width: 100%">
                                        <option value="">------PILIH------</option>
                                        <option value="exist">Data sudah ada</option>
                                        <option value="new">Data baru</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-4" id="newProject" style="display: none">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    ID Project
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="id_project" placeholder="ID Project" autocomplete="off">
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
    <script src="{{ asset('js/optyAcdc.js') }}"></script>

    <script>
        $(init)

        $(document).on("change", "#type", function() {
            const val = $(this).val();
            if (val == 'exist') {
                $("#existProject").css("display", "")
                $("#newProject").css("display", "none")
            } else if (val == 'new') {
                $("#existProject").css("display", "none")
                $("#newProject").css("display", "")
            } else {
                $("#existProject").css("display", "none")
                $("#newProject").css("display", "none")
            }
        });


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
