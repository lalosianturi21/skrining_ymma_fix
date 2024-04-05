<?php

namespace App\Http\Controllers;

use Excel; 
use App\Http\Controllers\Admin\HistoriDiagnosisController;
use Carbon\Carbon;
use App\Exports\HistoryExport;
use Illuminate\Http\Request;


class ShowExcelController extends Controller
{
    public function generateExcel()
    {
        $historiDiagnosisController = new HistoriDiagnosisController();
        $data = $historiDiagnosisController->getHistoryDiagnosis();
        
        // Format tanggal
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
    
        // Persiapkan data untuk Excel
        $excelData = [];
    
        // Tambahkan baris untuk header
        $headerRow = [
            'Nama Pasien',
            'Umur',
            'Jenis Kelamin',
            'Alamat KTP',
            'Alamat Domisili',
            'NIK Serumah',
            'Tanggal Melakukan Investigasi Kontak'
        ];
    
        // Ambil nama-nama gejala dari histori diagnosis pertama
        if (count($data) > 0 && isset($data[0]['detail'])) {
            foreach ($data[0]['detail'] as $detail) {
                $headerRow[] = $detail['name'];
            }
        }
    
        $excelData[] = $headerRow;
    
        // Tambahkan data untuk setiap histori diagnosis
        foreach ($data as $histori) {
            $rowData = [
                $histori['nama_user'],
                $histori['umur'],
                $histori['jenis_kelamin'],
                $histori['alamat_ktp'],
                $histori['alamat_domisili'],
                // Mengatur NIK Serumah sebagai teks
                " " . $histori['nik_serumah'],
                $histori['updated_at'],
            ];
    
            // Tambahkan jawaban untuk setiap gejala
            foreach ($histori['detail'] as $detail) {
                $rowData[] = $detail['answer'];
            }
    
            $excelData[] = $rowData;
        }
    
        // Export data ke Excel
        return Excel::download(new HistoryExport($excelData), 'histori-diagnosis.xlsx');
    }
}
