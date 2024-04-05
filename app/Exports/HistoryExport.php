<?php

namespace App\Exports;

use App\Models\Diagnosis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryExport implements FromCollection
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

   
}
