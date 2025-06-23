<?php

namespace App\Exports;

use App\Models\Beneficiary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class BeneficiariesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Beneficiary::select('code_num','name','id_num','created_at')->withCount('receipts_chech')->get();
    }
    public function headings(): array
    {
        return ["code_num", "name", "id_num", "created_at", "receipts_chech_count"];
    }
}
