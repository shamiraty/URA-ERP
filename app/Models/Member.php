<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'department', 'checkNumber', 'fullName', 'accountNumber', 'bankName',
        'basicSalary', 'allowance', 'arrear', 'grossAmount', 'netAmount',
        'loanableAmount', 'totalLoanWithInterest', 'totalInterest',
        'monthlyDeduction', 'processingFee', 'insurance', 'disbursementAmount','branch_id_employee'
    ];

    public function branchEmployee()
    {
        return $this->belongsTo(Branch::class, 'branch_id_employee');
    }
}
