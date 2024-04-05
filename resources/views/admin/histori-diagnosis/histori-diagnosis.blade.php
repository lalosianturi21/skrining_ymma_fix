@extends('layouts.admin.app')

@push('cssLibraries')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush

@push('jsLibraries')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert/sweetalert.min.js') }}"></script>
@endpush

@push('jsCustom')
    <!-- Page Specific JS File -->
    <script>
        const table = document.getElementById('table-1');
        const dataTable = $(table).DataTable({});
        $(document).on("click", "#table-1 #btnHapus", function(e) {
            e.preventDefault();
            var form = $(this).closest("td").find("form");
            swal({
                    title: "Apakah Anda yakin?",
                    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) form.submit();
                });
        });
    </script>
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Histori Diagnosis</h1>
        </div>
        <div class="section-body">
            <div class="pb-4">
                <a href="{{ route('histori.diagnosis.pdf') }}" target="_blank" class="btn btn-warning text-dark"
                    type="button">
                    Cetak Data
                </a>
                <a href="{{ route('generate.history.excel') }}" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Generate Excel</a>
            </div>
            @if (session('error'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th>Nama Pasien</th>
                                    <th>Umur</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat KTP</th>
                                    <th>Alamat Domisili</th>
                                    <th>NIK</th>
                                    <th>Tanggal Melakukan investigasi kontak</th>
                                    <th>Status</th>
                                    <th>Gejala</th>
                                    
                                    <th>Tanggal Dibuat/Diubah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diagnosis as $diagnosisItem)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $diagnosisItem['nama_user'] }}</td>
                                        <td>{{ $diagnosisItem['umur'] }} tahun</td>
                                        <td>{{ $diagnosisItem['jenis_kelamin'] }}</td>
                                        <td>{{ $diagnosisItem['alamat_ktp'] }}</td>
                                        <td>{{ $diagnosisItem['alamat_domisili'] }}</td>
                                        <td>{{ $diagnosisItem['nik_serumah'] }}</td>
                                        <td>{{ $diagnosisItem['updated_at'] }}</td>
                                        @if ($diagnosisItem['penyakit']['id'] == null)
                                            <td><span class="">Tidak dirujuk</span>
                                            </td>
                                        @else
                                            <td>{{ $diagnosisItem['penyakit']['name'] }}</td>
                                        @endif
                                        <td> <!-- Gejala -->
                                            @foreach($diagnosisItem['detail'] as $detail)
                                                <div>
                                                    <strong>Nama Gejala:</strong> {{ $detail['name'] }} <br>
                                                    <strong>Jawaban:</strong> {{ $detail['answer'] }} <br>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{ $diagnosisItem['updated_at'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
