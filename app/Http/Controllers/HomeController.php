<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

// class HomeController extends Controller
// {
//     public function index()
//     {
//          $monthlyLoanData = LoanApplication::getMonthlyDataForCurrentYear();
//         // Metrics for the dashboard
//         $enquiryFrequencyApproved = $this->getMonthlyFrequency('Enquiry', 'approved');
//         $loanApplicationFrequencyPending = $this->getLoanApplicationFrequency('pending');
//         $monthlyLoanApplications = $this->getMonthlyLoanApplicationFrequencies(); // New data
//         $enquiryTypeFrequency = $this->getEnquiryTypeFrequency();
//         $loanApplicationStatusFrequency = $this->getLoanApplicationStatusFrequency();

//         // Metrics Cards
//         $enquiryFrequencyAllTime = $this->getEnquiryFrequencyAllTime();
//         $loanApplicationFrequencyAllTime = $this->getLoanApplicationFrequencyAllTime();
//         $enquiryTypeMembership = $this->getEnquiryTypeFrequencyByType('join_membership');
//         $enquiryTypeShare = $this->getEnquiryTypeFrequencyByType('share_enquiry');
//         $enquiryTypeDeduction = $this->getEnquiryTypeFrequencyByType('deduction_add');

//         //last 10  enquires,
//         //  $enquiries = Enquiry::orderBy('date_received', 'desc')->limit(10)->get();
//         $enquiries = Enquiry::with(['region', 'district'])
//                     ->orderBy('date_received', 'desc')
//                     ->limit(10)
//                     ->get();


//         // Pass the data to the view
//         return view('dashboard', compact(
//             'enquiryFrequencyApproved',
//             'loanApplicationFrequencyPending',
//             'monthlyLoanApplications', // Include monthly data
//             'enquiryTypeFrequency',
//             'loanApplicationStatusFrequency',
//             'enquiryFrequencyAllTime',
//             'loanApplicationFrequencyAllTime',
//             'enquiryTypeMembership',
//             'enquiryTypeShare',
//             'enquiryTypeDeduction',
//             'enquiries'
//         ));
//     }

//     private function getMonthlyFrequency($model, $status)
//     {
//         return Enquiry::where('status', $status)
//             ->whereYear('date_received', Carbon::now()->year)
//             ->selectRaw('MONTH(date_received) as month, COUNT(*) as frequency')
//             ->groupBy('month')
//             ->get();
//     }

//     private function getLoanApplicationFrequency($status)
//     {
//         return LoanApplication::whereIn('status', [$status, 'paid'])
//             ->whereYear('created_at', Carbon::now()->year)
//             ->selectRaw('COUNT(*) as frequency')
//             ->first();
//     }

//     private function getMonthlyLoanApplicationFrequencies()
//     {
//         // Initialize arrays for the counts
//         $monthlyPaidFrequencies = array_fill(0, 12, 0);
//         $monthlyPendingFrequencies = array_fill(0, 12, 0);
//         $currentYear = Carbon::now()->year;

//         // Get paid loan applications by month
//         $paidApplications = LoanApplication::where('status', 'paid')
//             ->whereYear('created_at', $currentYear)
//             ->selectRaw('MONTH(created_at) as month, COUNT(*) as frequency')
//             ->groupBy('month')
//             ->get();

//         foreach ($paidApplications as $application) {
//             $monthlyPaidFrequencies[$application->month - 1] = $application->frequency; // month is 1-indexed
//         }

//         // Get pending loan applications by month
//         $pendingApplications = LoanApplication::where('status', 'pending')
//             ->whereYear('created_at', $currentYear)
//             ->selectRaw('MONTH(created_at) as month, COUNT(*) as frequency')
//             ->groupBy('month')
//             ->get();

//         foreach ($pendingApplications as $application) {
//             $monthlyPendingFrequencies[$application->month - 1] = $application->frequency; // month is 1-indexed
//         }

//         return [
//             'paid' => $monthlyPaidFrequencies,
//             'pending' => $monthlyPendingFrequencies,
//         ];
//     }

//     private function getEnquiryTypeFrequency()
//     {
//         return Enquiry::select('type')
//             ->selectRaw('COUNT(*) as frequency')
//             ->groupBy('type')
//             ->get();
//     }

//     private function getLoanApplicationStatusFrequency()
//     {
//         return LoanApplication::select('status')
//             ->selectRaw('COUNT(*) as frequency')
//             ->groupBy('status')
//             ->get();
//     }

//     private function getEnquiryFrequencyAllTime()
//     {
//         return Enquiry::selectRaw('COUNT(*) as frequency')->first();
//     }

//     private function getLoanApplicationFrequencyAllTime()
//     {
//         return LoanApplication::selectRaw('COUNT(*) as frequency')->first();
//     }

//     private function getEnquiryTypeFrequencyByType($type)
//     {
//         return Enquiry::where('type', $type)
//             ->selectRaw('COUNT(*) as frequency')
//             ->first();
//     }
// }

/*
class HomeController extends Controller
{
    public function index()
    {
        // Fetch monthly loan application data
        $monthlyLoanApplications = $this->getMonthlyLoanApplicationFrequencies();

        // Fetch monthly approved enquiries
        $enquiryFrequencyApproved = $this->getMonthlyFrequency('Enquiry', 'approved');

        // Fetch loan application frequency pending
        $loanApplicationFrequencyPending = $this->getLoanApplicationFrequency('pending');

        // Fetch enquiry type frequency
        $enquiryTypeFrequency = $this->getEnquiryTypeFrequency();

        // Fetch loan application status frequency
        $loanApplicationStatusFrequency = $this->getLoanApplicationStatusFrequency();

        // Metrics Cards
        $enquiryFrequencyAllTime = $this->getEnquiryFrequencyAllTime();
        $loanApplicationFrequencyAllTime = $this->getLoanApplicationFrequencyAllTime();
        $enquiryTypeMembership = $this->getEnquiryTypeFrequencyByType('join_membership');
        $enquiryTypeShare = $this->getEnquiryTypeFrequencyByType('share_enquiry');
        $enquiryTypeDeduction = $this->getEnquiryTypeFrequencyByType('deduction_add');

        // Last 10 enquiries
        $enquiries = Enquiry::with(['region', 'district'])
                    ->orderBy('date_received', 'desc')
                    ->limit(10)
                    ->get();

        // Define labels for the months
        $loanApplicationLabels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Extract data for 'paid' and 'pending' loan applications
        $loanApplicationPaidData = $monthlyLoanApplications['paid'];
        $loanApplicationPendingData = $monthlyLoanApplications['pending'];

        // Pass the data to the view
        return view('dashboard', compact(
            'enquiryFrequencyApproved',
            'loanApplicationFrequencyPending',
            'monthlyLoanApplications',
            'enquiryTypeFrequency',
            'loanApplicationStatusFrequency',
            'enquiryFrequencyAllTime',
            'loanApplicationFrequencyAllTime',
            'enquiryTypeMembership',
            'enquiryTypeShare',
            'enquiryTypeDeduction',
            'enquiries',
            'loanApplicationLabels',
            'loanApplicationPaidData',
            'loanApplicationPendingData'
        ));
    }

    private function getMonthlyFrequency($model, $status)
    {
        // Adjusted to work with Enquiry model
        return Enquiry::where('status', $status)
            ->whereYear('date_received', Carbon::now()->year)
            ->selectRaw('MONTH(date_received) as month, COUNT(*) as frequency')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    private function getLoanApplicationFrequency($status)
    {
        return LoanApplication::whereIn('status', [$status, 'paid'])
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('COUNT(*) as frequency')
            ->first();
    }

    private function getMonthlyLoanApplicationFrequencies()
    {
        // Initialize arrays for the counts
        $monthlyPaidFrequencies = array_fill(0, 12, 0);
        $monthlyPendingFrequencies = array_fill(0, 12, 0);
        $currentYear = Carbon::now()->year;

        // Get paid loan applications by month
        $paidApplications = LoanApplication::where('status', 'paid')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as frequency')
            ->groupBy('month')
            ->get();

        foreach ($paidApplications as $application) {
            $monthlyPaidFrequencies[$application->month - 1] = $application->frequency; // month is 1-indexed
        }

        // Get pending loan applications by month
        $pendingApplications = LoanApplication::where('status', 'pending')
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as frequency')
            ->groupBy('month')
            ->get();

        foreach ($pendingApplications as $application) {
            $monthlyPendingFrequencies[$application->month - 1] = $application->frequency; // month is 1-indexed
        }

        return [
            'paid' => $monthlyPaidFrequencies,
            'pending' => $monthlyPendingFrequencies,
        ];
    }

    private function getEnquiryTypeFrequency()
    {
        return Enquiry::select('type')
            ->selectRaw('COUNT(*) as frequency')
            ->groupBy('type')
            ->get();
    }

    private function getLoanApplicationStatusFrequency()
    {
        return LoanApplication::select('status')
            ->selectRaw('COUNT(*) as frequency')
            ->groupBy('status')
            ->get();
    }

    private function getEnquiryFrequencyAllTime()
    {
        return Enquiry::selectRaw('COUNT(*) as frequency')->first();
    }

    private function getLoanApplicationFrequencyAllTime()
    {
        return LoanApplication::selectRaw('COUNT(*) as frequency')->first();
    }

    private function getEnquiryTypeFrequencyByType($type)
    {
        return Enquiry::where('type', $type)
            ->selectRaw('COUNT(*) as frequency')
            ->first();
    }
            
}
*/




 

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index()
    {
        // Retrieve total payment amounts grouped by enquiry type
        $totalPaymentsByType = Enquiry::getTotalPaymentsByType();

        // Retrieve total payment amounts grouped by payment status
        $totalPaymentsByStatus = Enquiry::getTotalPaymentsByStatus();

         // Fetch enquiry count and total amount sum by type
         $enquiryPayments = Enquiry::getEnquiryPayments();






    // Fetch the total count and sum for each enquiry type  CARDS
        //-------------------------------------------------------------------
        
         // Fetch the total sum of all payments
         $totalAmount = \App\Models\Payment::sum('amount');
        $enquiryPayments = Enquiry::getEnquiryPayments();

        // Calculate the relative frequency (percentage) for each enquiry type
        $enquiryPayments = $enquiryPayments->map(function($enquiry) use ($totalAmount) {
            $enquiry->percentage = ($totalAmount > 0) ? ($enquiry->total_amount / $totalAmount) * 100 : 0;
            return $enquiry;
        });
        //----------------------------------------------------------------













        $currentYear = Carbon::now()->year;

        // Fetch enquiry types by frequency, grouped by month of the current year
        $enquiryTypes = Enquiry::selectRaw('MONTH(date_received) as month, type, COUNT(*) as frequency')
            ->whereYear('date_received', $currentYear)
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();
    
        // Prepare data for chart
        $months = range(1, 12); // For the months of the year
        $enquiryData = [];
    
        foreach ($months as $month) {
            foreach ($enquiryTypes as $enquiry) {
                if ($enquiry->month == $month) {
                    $enquiryData[$month][$enquiry->type] = $enquiry->frequency;
                }
            }
        }

        // Calculate subtotal per type and grand total for all types
        $typeSubtotals = [];
        $grandTotalAmount = 0;
        $grandTotalCount = 0;

        // Enquiry Type Count and Total
        $enquiryTypeTotals = [];

        foreach ($totalPaymentsByStatus as $entry) {
            // Sum amounts per type and status
            if (!isset($typeSubtotals[$entry->type])) {
                $typeSubtotals[$entry->type] = [
                    'total_amount' => 0,
                    'payment_count' => 0,
                ];
            }

            // Add to subtotal
            $typeSubtotals[$entry->type]['total_amount'] += $entry->total_amount;
            $typeSubtotals[$entry->type]['payment_count'] += $entry->payment_count;

            // Add to grand total
            $grandTotalAmount += $entry->total_amount;
            $grandTotalCount += $entry->payment_count;

            // Count Enquiry Types
            if (!isset($enquiryTypeTotals[$entry->type])) {
                $enquiryTypeTotals[$entry->type] = 0;
            }
            $enquiryTypeTotals[$entry->type]++;
        }

        // Get the type counts
        $enquiryTypes = Enquiry::getEnquiryTypeCount();

        // Pass all necessary data to the view
        return view('dashboard', compact('totalPaymentsByType', 'totalPaymentsByStatus', 'typeSubtotals', 'grandTotalAmount', 'grandTotalCount', 'enquiryTypeTotals','enquiryPayments','enquiryData','enquiryTypes'));
    }
}

