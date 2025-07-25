<?php

namespace App\Exports;

use App\Models\Daily_report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DailyReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Daily_report::with(['elderly', 'user'])
            ->get()
            ->map(function ($report) {
                return [
                    'المقيم' => $report->elderly->full_name,
                    'مقدم الرعاية' => $report->user->name,
                    'المزاج' => $report->mood,
                    'النوم' => $report->sleep_quality,
                    'الشهية' => $report->appetite,
                    'العلامات الحيوية' => $report->vital_signs,
                    'الملاحظات' => $report->notes,
                    'التاريخ' => $report->report_date,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'المقيم',
            'مقدم الرعاية',
            'المزاج',
            'النوم',
            'الشهية',
            'العلامات الحيوية',
            'الملاحظات',
            'تاريخ التقرير',
        ];
    }
}
