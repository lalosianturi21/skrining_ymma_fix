<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\HistoriDiagnosisController;
use App\Http\Controllers\Admin\PenyakitController;
use App\Http\Controllers\Admin\RuleController;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;

class ShowPdfController extends Controller
{

    public function penyakitPdf()
    {
        $data = new PenyakitController();
        $data = $data->index();
        $data = $data['penyakit'];
        $data = $data->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['penyakit' => $data];
        $pdf = Pdf::loadView('pdf.penyakit', $data);
        return $pdf->stream('penyakit_YMMA.pdf');
    }

    public function gejalaPdf()
    {
        $data = new GejalaController();
        $data = $data->index();
        $data = $data['gejala'];
        $data = $data->toArray();
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['gejala' => $data];
        $pdf = Pdf::loadView('pdf.gejala', $data);
        return $pdf->stream('gejala_YMMA.pdf');
    }

    public function rulePdf()
    {
        $data = new RuleController();
        $data = $data->index();
        $data = $data['rules'];
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['rules' => $data];
        $pdf = Pdf::loadView('pdf.rule', $data);
        return $pdf->stream('rule_YMMA.pdf');
    }

    public function historiDiagnosisPdf()
    {
        $data = new HistoriDiagnosisController();
        $data = $data->index();
        $data = $data['diagnosis'];
        foreach ($data as $key => $value) {
            $data[$key]['updated_at'] = Carbon::parse($value['updated_at'])->format('d-m-Y');
        }
        $data = ['historiDiagnosis' => $data];
        $pdf = Pdf::loadView('pdf.histori-diagnosis', $data);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('histori-diagnosis_YMMA.pdf');
    }
}
