<?php

namespace App\Exports;

use App\Models\Refund;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RefundExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function collection()
    {
        return Refund::with('enquiry.region', 'enquiry.district', 'enquiry.branch','enquiry.command')
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($refund) {
                $enquiry = $refund->enquiry;

                return [
                    'refund_amount' => $refund->refund_amount,
                    'refund_duration' => $refund->refund_duration,
                    'date_received' => optional($enquiry)->date_received,
                    'full_name' => optional($enquiry)->full_name,
                    'force_no' => optional($enquiry)->force_no,
                    'check_number' => optional($enquiry)->check_number,
                    'account_number' => optional($enquiry)->account_number,
                    'bank_name' => optional($enquiry)->bank_name,
                    'district' => optional(optional($enquiry)->district)->name, // Added optional()
                    'phone' => optional($enquiry)->phone,
                    'region' => optional(optional($enquiry)->region)->name,   // Added optional()
                    'branch' => optional(optional($enquiry)->branch)->name,  // Added optional()
                    'command' => optional(optional($enquiry)->command)->name, // Added optional()
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Refund Amount',
            'Refund Duration',
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
