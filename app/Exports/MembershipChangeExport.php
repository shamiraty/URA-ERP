<?php

namespace App\Exports;

use App\Models\MembershipChange;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class MembershipChangeExport implements FromCollection, WithHeadings
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
        return MembershipChange::with([
                'enquiry:enquirable_id,enquirable_type,id,full_name,check_number,account_number,region_id,district_id,bank_name,date_received,command_id',
                'enquiry.region:id,name',
                'enquiry.district:id,name',
                'enquiry.command:id,name',
            ])
            ->select('id', 'category', 'created_at')
            ->where('action', 'unjoin')
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($membershipChange) {
                $enquiry = $membershipChange->enquiry;

                return [
                    'firstname' => optional($enquiry)->full_name,
                    'check_number' => optional($enquiry)->check_number,
                    'account_number' => optional($enquiry)->account_number,
                    'region' => optional($enquiry->region)->name,
                    'district' => optional($enquiry->district)->name,
                    'bank_name' => optional($enquiry)->bank_name,
                    'date_received' => optional($enquiry)->date_received,
                    'category' => $membershipChange->category,
                    'command' => optional($enquiry->command)->name,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Check Number',
            'Account Number',
            'Region',
            'District',
            'Bank Name',
            'Date Received',
            'Category',
            'Command',
        ];
    }
}
