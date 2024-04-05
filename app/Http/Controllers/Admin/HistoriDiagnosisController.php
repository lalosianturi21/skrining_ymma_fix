<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\Gejala;
use Illuminate\Http\Request;

class HistoriDiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'loginDuration' => $this->LoginDuration(),
            'diagnosis' => $this->getHistoryDiagnosis(),
        ];

        return view('admin.histori-diagnosis.histori-diagnosis', $data);
    }

    public function getHistoryDiagnosis()
    {
        $diagnosis = Diagnosis::with(['user' => function ($query) {
            $query->select('id', 'name', 'email');
        }, 'penyakit' => function ($query) {
            $query->select('id', 'name');
        }])->get(['id', 'user_id', 'penyakit_id', 'nama_user','umur', 'jenis_kelamin', 'alamat_ktp', 'alamat_domisili', 'nik_serumah', 'updated_at'])->map(function ($diagnosis) {
            if ($diagnosis['penyakit'] == null) {
                $diagnosis['penyakit'] = [
                    'id' => null,
                    'name' => 'Penyakit tidak ditemukan',
                ];
            }
             // Retrieve detail diagnosis

            $diagnosis['updated_at'] = $diagnosis['updated_at'];
            $diagnosis['user'] = $diagnosis['user']->toArray();
            $diagnosis['penyakit'] = $diagnosis['penyakit'];
            $diagnosis['nama_user'] = $diagnosis['nama_user'];
            $diagnosis['umur'] = $diagnosis['umur'];
            $diagnosis['jenis_kelamin'] = $diagnosis['jenis_kelamin'];
            $diagnosis['alamat_ktp'] = $diagnosis['alamat_ktp'];
            $diagnosis['alamat_domisili'] = $diagnosis['alamat_domisili'];
            $diagnosis['nik_serumah'] = $diagnosis['nik_serumah'];
            

            $detailDiagnosis = $this->getDetailDiagnosis($diagnosis['id']);
            $diagnosis['detail'] = $detailDiagnosis;

            return [
                'id' => $diagnosis['id'],
                'updated_at' => $diagnosis['updated_at'],
                'nama_user' => $diagnosis['nama_user'],
                'umur' => $diagnosis['umur'],
                'jenis_kelamin' => $diagnosis['jenis_kelamin'],
                'alamat_ktp' => $diagnosis['alamat_ktp'],
                'alamat_domisili' => $diagnosis['alamat_domisili'],
                'nik_serumah' => $diagnosis['nik_serumah'],
                'user' => $diagnosis['user'],
                'penyakit' => $diagnosis['penyakit'],
                'detail' => $detailDiagnosis,
            ];
        })->values()->toArray();

        return $diagnosis;
    }

    public function getDetailDiagnosis($diagnosisId)
    {
        $diagnosis = Diagnosis::find($diagnosisId, ['answer_log']);
        $answerLog = json_decode($diagnosis->answer_log, true);
        foreach ($answerLog as $key => $value) {
            $answerLog[$key] = $value == 1 ? 'Ya' : 'Tidak';
        }
        $gejala = Gejala::whereIn('id', array_keys($answerLog))->get(['id', 'name']);
        foreach ($gejala as $item) {
            $item->answer = $answerLog[$item->id];
        }
        $answerLog = $gejala->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'answer' => $item->answer,
            ];
        });
    
        return $answerLog->toArray();
    }
}
