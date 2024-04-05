@extends('layouts.pdf-layout')
@section('title', 'Data Histori Diagnosis')
@section('content')
<style>
    #table1 {
        border-collapse: collapse;
        width: 100%;
        margin-top: 0; /* Mengurangi margin top */
        padding: 0; /* Menghapus padding */
    }

    #table1 td,
    #table1 th {
        border: 1px solid #ddd;
        padding: 4px; /* Mengurangi padding */
    }

    #table1 th {
        padding-top: 8px;
        padding-bottom: 8px;
        color: black;
        font-size: 10px; /* Mengurangi ukuran font */
        text-align: center;
    }

    #table1 td {
        font-size: 10px; /* Mengurangi ukuran font */
        text-align: center;
    }
</style>
<table border="1" id="table1">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Pasien</th>
            <th width="15%">Umur</th>
            <th width="15%">Jenis Kelamin</th>
            <th width="15%">Alamat KTP</th>
            <th width="15%">Alamat Domisili</th>
            <th width="15%">NIK</th>
            <th>Tanggal Melakukan investigasi kontak</th>
            @if (count($historiDiagnosis) > 0)
                @foreach ($historiDiagnosis[0]['detail'] as $detail)
                    <th width="15%">{{ $detail['name'] }}</th>
                @endforeach
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($historiDiagnosis as $key)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $key['nama_user'] }}</td>
                <td>{{ $key['umur'] }}</td>
                <td>{{ $key['jenis_kelamin'] }}</td>
                <td>{{ $key['alamat_ktp'] }}</td>
                <td>{{ $key['alamat_domisili'] }}</td>
                <td>{{ $key['nik_serumah'] }}</td>
                <td>{{ $key['updated_at'] }}</td>
                @foreach ($key['detail'] as $detail)
                    <td>{{ $detail['answer'] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
