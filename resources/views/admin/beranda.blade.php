@extends('layouts.admin.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Beranda</h1>
        </div>
        @if (session()->exists('success-login-admin'))
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="hero bg-primary text-white">
                        <div class="hero-inner">
                            <h2>Selamat datang kembali, {{ auth()->user()->name }}!</h2>
                            <p class="lead">Disini adalah tempat untuk mengelola penyakit, gejala, rule, dan diagnosis</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Pengguna</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahPengguna }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-medkit"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Penyakit</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahPenyakit }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Gejala</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahGejala }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Diagnosis</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahDiagnosis }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Provinsi Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart1" ></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Kota Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart2" ></canvas>
                    </div>
                </div>
            </div> -->
            
        </div>
      
        
    </section>
@endsection

@push('jsLibraries')
    <script src="{{ asset('assets/chart.js/dist/Chart.min.js') }}"></script>
@endpush

@push('jsCustom')
    <script>
       
       
        
    </script>
@endpush
