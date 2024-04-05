@extends('layouts.user.app')
@section('content')
    <div id="diagnosis" class="section mb-8">
        <div class="container">
            
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <div class="card shadow border border-0">
                        <div class="card-body">
                        <div class="col-xl-11 col-xxl-9 mx-auto">
                <h3 class="display-3 mb-8 px-lg-8 text-dark pt-5 text-center"> <span class="underline-3 style-2 white">Mari Skrining Sekarang</span></h3>
                <img src="{{ asset('assets/img/tbc.jpeg') }}" alt="Image description" class="img-fluid mx-auto d-block mb-3 pt-5">
                </div>
                            <!-- <div class="card-text">
                                Sistem ini menggunakan metode forward chaining untuk mendiagnosis penyakit. Proses dimulai
                                dengan mengevaluasi gejala yang diberikan oleh pengguna, kemudian sistem mencocokkannya
                                dengan aturan yang ada. Jika terdapat aturan yang terpenuhi, sistem akan memberikan detail
                                hasil diagnosis penyakit. Detail hasil diagnosis penyakit akan disimpan dalam sistem.
                                Pengguna dapat melihat kembali detail hasil diagnosis yang telah dilakukan pada histori
                                diagnosis di menu profil.
                            </div> -->
                            <div class="d-grid pt-5 mb-4">
                            <div class="d-flex justify-content-center">
                                <button id="btn-diagnosis" class="btn btn-custom1 py-2">
                                    Mulai Skrining penyakit
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="section section-default mt-none mb-none mb-5">
<div class="container">
<strong>
        <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="square-holder">
        <img alt="" src="{{ asset('assets/img/kementeriankesehatan.png') }}" />
        </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="square-holder">
        <img alt="" src="{{ asset('assets/img/prkomunitas.png') }}" />
        </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="square-holder">
        <img alt="" src="{{ asset('assets/img/tosstbc.jpg') }}" />
        </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="square-holder">
        <img alt="" src="{{ asset('assets/img/bcf.webp') }}" />
        </div>
        </div>
       
        </div>
        </strong>
        </div>
        </section>
 
        </div>
    </div>
    @if (Auth::check() && Auth::user()->email_verified_at != null && Gate::check('asUser'))
        @section('title', auth()->user()->name . html_entity_decode(' &mdash;'))
        @include('user.profile-modal')
        @include('user.detail-diagnosis-modal')
        @push('styleLibraries')
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        @endpush
        @push('scriptPerPage')
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="{{ asset('assets/chart.js/dist/Chart.min.js') }}"></script>
            <script src="{{ asset('spesified-assets/user/profile-modal.js') }}"></script>
            <script src="{{ asset('spesified-assets/user/detail-diagnosis-modal.js') }}"></script>
        @endpush
    @endif
@endsection

@push('scriptPerPage')
    <script type="text/javascript">
        const isUser = @json(Auth::check() && Auth::user()->email_verified_at != null && Gate::check('asUser'));
        // const hasUserProfile = @json(Auth::user()->profile->id ?? false);
        let login = @json(session('success') ?? false);
        const csrfToken = '{{ csrf_token() }}';
        const penyakitImage = @json($penyakit);
        const assetStoragePenyakit = '{{ asset('/storage/penyakit/') }}';
        const assetStorageGejala = '{{ asset('/storage/gejala/') }}';
    </script>
@endpush