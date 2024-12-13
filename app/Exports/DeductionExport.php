<?php

namespace App\Exports;

use App\Models\Deduction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeductionExport implements FromCollection, WithHeadings
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
        return Deduction::with([
                'enquiry:id,enquirable_id,enquirable_type,date_received,full_name,force_no,check_number,account_number,bank_name,district_id,phone,region_id,branch_id,command_id',
                'enquiry.region:id,name',
                'enquiry.district:id,name',
                'enquiry.branch:id,name',
                'enquiry.command:id,name',
            ])
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($deduction) {
                $enquiry = $deduction->enquiry;

                $status = $deduction->from_amount < $deduction->to_amount 
                          ? 'Deduction Increase' 
                          : 'Deduction Decrease';

                return [
                    'from_amount' => $deduction->from_amount,
                    'to_amount' => $deduction->to_amount,
                    'date_received' => optional($enquiry)->date_received,
                    'full_name' => optional($enquiry)->full_name,
                    'force_no' => optional($enquiry)->force_no,
                    'check_number' => optional($enquiry)->check_number,
                    'account_number' => optional($enquiry)->account_number,
                    'bank_name' => optional($enquiry)->bank_name,
                    'region' => optional($enquiry->region)->name,
                    'district' => optional($enquiry->district)->name,
                    'phone' => optional($enquiry)->phone,
                    'branch' => optional($enquiry->branch)->name,
                    'command' => optional($enquiry->command)->name, // Fetch command name
                    'status' => $status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'From Amount',
            'To Amount',
            'Date Received',
            'Full Name',
            'Force Number',
            'Check Number',
            'Account Number',
            'Bank Name',
            'Region',
            'District',
            'Phone',
            'Branch Name',
            'Command Name', // Add Command Name
            'Status',
        ];
    }
}
