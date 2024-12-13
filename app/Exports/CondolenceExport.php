<?php

namespace App\Exports;

use App\Models\Condolence;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CondolenceExport implements FromCollection, WithHeadings
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
        return Condolence::with([
                'enquiry:id,enquirable_id,enquirable_type,full_name,force_no,check_number,account_number,bank_name,district_id,phone,region_id,branch_id,command_id,date_received',
                'enquiry.region:id,name',
                'enquiry.district:id,name',
                'enquiry.branch:id,name',
                'enquiry.command:id,name'
            ])
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($condolence) {
                $enquiry = $condolence->enquiry;

                return [
                    'dependent_member_type' => $condolence->dependent_member_type,
                    'gender' => $condolence->gender,
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
                    'command' => optional($enquiry->command)->name,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Dependent Member Type',
            'Gender',
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
            'Command Name',
        ];
    }
}
