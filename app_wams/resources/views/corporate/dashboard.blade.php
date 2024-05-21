@extends('layouts.main')
@section('content')
    <form id="filterForm">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card-header">
                                <h4>Filter</h4>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="">Principal</label>
                                <select id="principal_filter" class="form-control select2" name="name_principal">
                                    <option value="" readonly>-----PILIH------</option>
                                    <option value="all">ALL</option>
                                    @forelse ($principal as $item)
                                        <option value="{{ $item->principal_name }}">{{ $item->principal_name }}</option>
                                    @empty
                                        <option value="">tidak ada data</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <div class="pt-3"></div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="dashboard-pie" class="card" style="display: none; justify-content: center;">
        <div class="row mb-5" style="justify-content: center;">
            <div class="col-lg-4 pt-5">
                <h4 class="text-center mb-3 principal-name" style="text-decoration: underline;">Principal</h4>
                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
            </div>
            <div class="col-lg-4 mb-3 pt-5">
                <h4 class="text-center mb-3" style="text-decoration: underline;">Project</h4>
                <canvas id="myChart2" style="width:100%;max-width:600px"></canvas>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>


    <script>
    $(document).ready(function() {
        var myChart = null;
        var myChart2 = null;

        $('#filterForm').submit(function(e) {
            e.preventDefault(); // Menghentikan pengiriman formulir secara normal

            // Validasi jika select option belum diisi
            if ($('#principal_filter').val() === '') {
                alert('Pilih Principal terlebih dahulu');
                return; // Berhenti jika validasi gagal
            }

            var formData = $(this).serialize(); // Mengambil data formulir
            $.ajax({
                type: "POST",
                url: "{{ route('filterprinciple') }}", // Rute yang ditentukan dalam file web.php
                data: formData, // Data yang dikirimkan ke server
                success: function(response) {
                  
                  // Tanggapan yang diterima dari server
                    var name = response[0];
                    var bmt = response[1];
                    var services = response[2];
                    var idProject = response[6]
                    var selectedPrincipal = name; // Dapatkan teks principal yang dipilih
                    $('.principal-name').text('Principal ' + selectedPrincipal);

                    // data project
                    var totalAdvance = response[3];
                    var totalFinal = response[4];
                    var sisaSaldo = response[5];

                    // Hancurkan chart lama jika ada
                    if (myChart) {
                        myChart.destroy();
                    }
                    if (myChart2) {
                        myChart2.destroy();
                    }

                    // Update data dalam chart atau lakukan tindakan lain sesuai kebutuhan Anda
                    myChart = updateChart(selectedPrincipal, bmt, services, idProject);
                    myChart2 = updateChart2(selectedPrincipal, totalAdvance, totalFinal, sisaSaldo, idProject);

                    // Tampilkan bagian dashboard-pie setelah mendapatkan respons
                    $('#dashboard-pie').show();
                },
                error: function(xhr, status, error) {
                    // Tanggapan jika terjadi kesalahan
                    alert('Data tidak ditemukan');
                    console.error(xhr.responseText.message);
                }
            });
        });

        // chart 1
        function updateChart(selectedPrincipal, bmt, services, idProject) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var xValues = ['BMT', 'SERVICE'];
            var yValues = [bmt, services];
            var barColors = ["#4285f4", "#ea4335", "#fbbc04", "#34a853", "#ff6d01", "#46bdc6"];

            return new Chart(ctx, {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: selectedPrincipal + "'s Contribution" // Perbarui teks judul dengan nama principal yang dipilih
                    },
                    onClick: function(e, element) {
                      if ($('#principal_filter').val() === 'all') {
                          return; // Berhenti jika all
                      } else {
                        if (element.length > 0) {
                            var url = `/showCPT/${idProject}`;
                            window.location.href = url;
                        }
                      }
                    },
                    onHover: function(e, element) {
                      if ($('#principal_filter').val() === 'all') {
                          return; // Berhenti jika all
                      } else {
                        e.native.target.style.cursor = element[0] ? 'pointer' : 'default';
                      }
                    }
                }
            });
        }

        // chart 2
        function updateChart2(selectedPrincipal, totalAdvance, totalFinal, sisaSaldo, idProject) {
            var ctx = document.getElementById('myChart2').getContext('2d');
            var xValues = ['TOTAL ADVANCE', 'TOTAL FINAL', 'SISA SALDO'];
            var yValues = [totalAdvance, totalFinal, sisaSaldo];
            var barColors = ["#ff6d01", "#00AB4E", "#FF0000"];

            return new Chart(ctx, {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: selectedPrincipal + "'s Contribution" // Perbarui teks judul dengan nama principal yang dipilih
                    },
                    onClick: function(e, element) {
                      if ($('#principal_filter').val() === 'all') {
                          return; // Berhenti jika all
                      } else {
                        if (element.length > 0) { 
                            var url = `/showCPT/${idProject}`;
                            window.location.href = url;
                        }
                      }
                    },
                    onHover: function(e, element) {
                      if ($('#principal_filter').val() === 'all') {
                          return; // Berhenti jika all
                      } else {
                        e.native.target.style.cursor = element[0] ? 'pointer' : 'default';
                      }
                    }
                }
            });
        }
    });


    
</script>

@endsection
