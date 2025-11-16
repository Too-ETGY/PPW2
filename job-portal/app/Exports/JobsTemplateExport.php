<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'title',
            'description',
            'location',
            'company',
            'salary',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Software Engineer',
                'Responsible for developing software...',
                'Jakarta',
                'Tech Corp',
                '15000000',
            ],
        ];
    }
}
