<?php

namespace App\Exports;

use App\Models\Retirement;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Log;

class RetirementExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        // Parse the date inputs and set the start and end date
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function collection()
    {
        return Retirement::with([
                'enquiry', 
                'enquiry.region', 
                'enquiry.district', 
                'enquiry.branch',
                'enquiry.command'
            ])
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($retirement) {
                $enquiry = $retirement->enquiry;

                return [
                    'date_of_retirement' => $retirement->date_of_retirement,
                    'date_received' => optional($enquiry)->date_received,
                    'full_name' => optional($enquiry)->full_name,
                    'force_no' => optional($enquiry)->force_no,
                    'check_number' => optional($enquiry)->check_number,
                    'account_number' => optional($enquiry)->account_number,
                    'bank_name' => optional($enquiry)->bank_name,
                    'district' => optional(optional($enquiry)->district)->name,
                    'phone' => optional($enquiry)->phone,
                    'region' => optional(optional($enquiry)->region)->name,
                    'branch' => optional(optional($enquiry)->branch)->name,
                    'command' => optional(optional($enquiry)->command)->name,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Date of Retirement',
            'Date Received',
            'Full Name',
            'Force No',
            'Check Number',
            'Account Number',
            'Bank Name',
            'District',
            'Phone',
            'Region',
            'Branch',
            'Command',
        ];
    }
}
