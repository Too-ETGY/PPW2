<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromCollection, WithHeadings
{
    protected $jobId;

    public function __construct($jobId = null)
    {
        $this->jobId = $jobId;
    }

    public function collection()
    {
        $query = Application::with(['user', 'job']);

        if ($this->jobId) {
            $query->where('job_vacancy_id', $this->jobId);
        }

        return $query->get()->map(function ($app) {
            return [
                'Applicant' => $app->user->name,
                'Job' => $app->job->title,
                'Status' => $app->status,
                'Submitted At' => $app->created_at->format('Y-m-d H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Applicant', 'Job', 'Status', 'Submitted At'];
    }
}
