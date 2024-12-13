<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;

// class MembersImport implements ToModel
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         return new Member([
//             //
//         ]);
//     }
// }
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class MembersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::transaction(function () use ($row) {
            $member = Member::create([
                'department'       => $row['department'],
                'checkNumber'      => $row['checknumber'],
                'fullName'         => $row['fullname'],
                'accountNumber'    => $row['accountnumber'],
                'bankName'         => $row['bankname'],
                'basicSalary'      => $this->parseCurrency($row['basicsalary']),
                'allowance'        => $this->parseCurrency($row['allowance']),
                'arrear'           => $this->parseCurrency($row['arrear']),
                'grossAmount'      => $this->parseCurrency($row['grossamount']),
                'netAmount'        => $this->parseCurrency($row['netamount'])
            ]);

            // Here you will call the loan calculation method to calculate loans for this member
            $this->calculateLoanableAmount($member);
        });
    }

    private function parseCurrency($value)
    {
        return str_replace(',', '', $value); // Remove commas in currency fields if present
    }

    // Loan calculation method based on your previously provided logic
    private function calculateLoanableAmount($member)
    {
        $basicSalary = $member->basicSalary;
        $allowances = [$member->allowance]; // Treat this as an array of allowances
        $takeHome = $member->netAmount;
        $numberOfMonths = 48; // You can set this dynamically if needed

        $oneThirdSalary = $basicSalary / 3;
        $totalAllowances = array_sum($allowances);
        $loanableTakeHome = $takeHome - ($oneThirdSalary + $totalAllowances);
        $annualInterestRate = 12;
        $monthlyInterestRate = $annualInterestRate / 100 / 12;

        $loanApplicable = ($loanableTakeHome * (pow(1 + $monthlyInterestRate, $numberOfMonths) - 1)) / ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfMonths));
        $monthlyDeduction = $loanableTakeHome;
        $totalLoanWithInterest = $monthlyDeduction * $numberOfMonths;
        $totalInterest = $totalLoanWithInterest - $loanApplicable;
        $processingFee = $loanApplicable * 0.0025;
        $insurance = $loanApplicable * 0.01;
        $disbursementAmount = $loanApplicable - ($processingFee + $insurance);

        // Update the member record with loan calculation results
        $member->update([
            'loanableAmount' => $loanApplicable,
            'totalLoanWithInterest' => $totalLoanWithInterest,
            'totalInterest' => $totalInterest,
            'monthlyDeduction' => $monthlyDeduction,
            'processingFee' => $processingFee,
            'insurance' => $insurance,
            'disbursementAmount' => $disbursementAmount,
            'status' => 'pending',
        ]);
    }
}
