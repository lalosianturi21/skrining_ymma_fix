<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Rule;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    private $allGejala;

    public function __construct()
    {
        $this->allGejala =  Gejala::get('id')->count();
    }

    private function newDiagnosis()
    {
        $modelDiagnosis = new Diagnosis();
        $modelDiagnosis->user_id = auth()->user()->id;
        return $modelDiagnosis;
    }

    private function lastDiagnosis()
    {
        return Diagnosis::where('user_id',  auth()->user()->id)->get()->last();
    }

    private function checkDiagnosis($idGejala)
    {
        $lastDiagnosis = $this->lastDiagnosis();

        if ($idGejala === 1) {
            return $this->newDiagnosis();
        }

        if ($lastDiagnosis->penyakit_id === null) {
            $answerLog = json_decode($lastDiagnosis->answer_log, true) ?? [];
            $maxAnswerLog = max(array_keys($answerLog));

            if ($maxAnswerLog === $this->allGejala) {
                return $this->newDiagnosis();
            }

            return $lastDiagnosis;
        }

        return $this->newDiagnosis();
    }

    public function diagnosis(Request $request)
    {
    $request->validate([
        'idgejala' => ['required', 'numeric', 'max:' . $this->allGejala, 'min:1'],
        'nama_user' => ['required', 'string', 'max:255'],
        'umur' => ['required', 'string'],
        'jenis_kelamin' => ['required', 'string', 'max:255'],
        'alamat_ktp' => ['required', 'string', 'max:255'],
        'alamat_domisili' => ['required', 'string', 'max:255'],
        'nik_serumah' => ['required', 'string', 'max:255'],
    ]);

    $requestFakta = [
        $request->idgejala => filter_var($request->value, FILTER_VALIDATE_BOOLEAN)
    ];

    $modelDiagnosis = $this->checkDiagnosis((int) $request->idgejala);
    $answerLog = json_decode($modelDiagnosis->answer_log, true) ?? [];
    $answerLog = $answerLog + $requestFakta;
    $modelDiagnosis->answer_log = json_encode($answerLog);
    $modelDiagnosis->nama_user = $request->nama_user;
    $modelDiagnosis->umur = $request->umur;
    $modelDiagnosis->jenis_kelamin = $request->jenis_kelamin;
    $modelDiagnosis->alamat_ktp = $request->alamat_ktp;
    $modelDiagnosis->alamat_domisili = $request->alamat_domisili;
    $modelDiagnosis->nik_serumah = $request->nik_serumah;

    // Check if all symptoms have been answered
    if (count($answerLog) >= $this->allGejala) {
        // Save the diagnosis with all answer log to database
        $modelDiagnosis->save();

        // Get rules
        $rule = Rule::get(['penyakit_id', 'gejala_id']);
        $aturan = [];
        foreach ($rule as $key => $value) {
            $aturan[$value->penyakit_id][] = $value->gejala_id;
        }

        // Get facts from answer log
        $fakta = $answerLog;

        // Inference
        $terdeteksi = false;
        foreach ($aturan as $penyakitId => $gejala) {
            $apakahPenyakit = true;
            foreach ($gejala as $gejalaPenyakit) {
                $fakta[$gejalaPenyakit] = $fakta[$gejalaPenyakit] ?? false;
                if (!$fakta[$gejalaPenyakit]) {
                    $apakahPenyakit = false;
                    break;
                }
            }
            if ($apakahPenyakit) {
                if ($modelDiagnosis->penyakit_id == null) {
                    $modelDiagnosis->penyakit_id = $penyakitId;
                    $modelDiagnosis->save();
                }
                $penyakit = Penyakit::where('id', $modelDiagnosis->penyakit_id)->first('id');
                $terdeteksi = true;
            }
        }

        if (!$terdeteksi) {
            return response()->json([
                'penyakitUnidentified' => true,
                'idPenyakit' => null,
                'idDiagnosis' => $modelDiagnosis->id,
            ]);
        }

        return response()->json([
            'idDiagnosis' => $modelDiagnosis->id,
            'idPenyakit' => $penyakit ?? null
        ]);
    }

    $modelDiagnosis->save();

    // If not all symptoms have been answered, return response indicating that the diagnosis is in progress
    return response()->json([
        'idDiagnosis' => $modelDiagnosis->id,
        'diagnosisInProgress' => true
    ]);
}

}
