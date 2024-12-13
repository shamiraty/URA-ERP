<?php

namespace App\Http\Controllers;


use Log;
use App\Models\User;
use App\Models\Region;
use GuzzleHttp\Client;
use App\Models\Enquiry;
use App\Models\File;
use App\Models\Payroll;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\Http;
use App\Models\LoanApplicationHistory;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Validator;
use App\Models\Folio;



class EnquiryController extends Controller
{





    public function index(Request $request)
    {
        $currentUser = auth()->user(); // Get the current authenticated user
        $type = $request->query('type');

        // List of roles that should see all data
        $allowedRoles = ['general_manager', 'assistant_general_manager', 'superadmin', 'system_admin'];

        // Check if the current user has one of the allowed roles
        if ($currentUser->hasAnyRole($allowedRoles)) {
            // User with one of the allowed roles should see all enquiries
            $enquiries = Enquiry::with(['response', 'region', 'district'])
                ->when($type, function ($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Other users should only see enquiries they registered
            $enquiries = Enquiry::with(['response', 'region', 'district'])
                ->where('registered_by', $currentUser->id) // Filter by the current user
                ->when($type, function ($query) use ($type) {
                    return $query->where('type', $type);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $users = User::all(); // Ensure this is still needed for your view, otherwise consider removing it if not used
        return view('enquiries.index', compact('enquiries', 'type', 'users'));
    }





public function fetchPayroll($check_number)
{
    $payroll = Payroll::where('check_number', $check_number)->first();

    if ($payroll) {
        // Assuming bank_name format is "BankName - Location"
        $bankNameParts = explode(' - ', $payroll->bank_name);
        $mainBankName = $bankNameParts[0]; // This will take "NMB" from "NMB - Zanzibar"

        // Modify the bank_name in the $payroll object before returning it
        $payroll->bank_name = $mainBankName;

        return response()->json($payroll);
    } else {
        return response()->json(null);
    }
}

public function create(Request $request, $check_number = null)
{
    $payrollData = null;
    if (!is_null($check_number)) {
        $payrollData = Payroll::where('check_number', $check_number)->first();
    }
    $regions = Region::with('districts')->get();
     $files=File::all();
    $activeStep = 1;

    return view('enquiries.create', compact('payrollData', 'regions','activeStep','files'));
}



    public function store(Request $request)
{


        $rules = [
            'date_received' => 'required|date',
            'full_name' => 'required|string|max:255',
            'force_no' => 'required|string|max:255',
            'check_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'district_id' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'region_id' => 'required|string|max:255',

            'type' => 'required|in:loan_application,refund,share_enquiry,retirement,deduction_add,withdraw_savings,withdraw_deposit,unjoin_membership,benefit_from_disasters',
            'basic_salary' => 'required|numeric',
        'allowances' => 'required|numeric',
        'take_home' => 'required|numeric'
        ];

        switch ($request->input('type')) {
            case 'loan_application':
                $rules = array_merge($rules, [
                    'loan_type' => 'required|string|max:255',
                    'loan_amount' => 'required|numeric',
                    'loan_duration' => 'required|integer',
                    'loan_category' => 'required|string',
                ]);
                break;

            case 'refund':
                $rules = array_merge($rules, [
                    'refund_amount' => 'required|numeric',
                    'refund_duration' => 'required|integer',
                ]);
                break;

            case 'share_enquiry':
                $rules = array_merge($rules, [
                    'share_amount' => 'required|numeric',
                ]);
                break;

            case 'retirement':
                $rules = array_merge($rules, [
                    'date_of_retirement' => 'required|date',

                ]);
                break;

            case 'deduction_add':
                $rules = array_merge($rules, [
                    'from_amount' => 'required|numeric',
                    'to_amount' => 'required|numeric',
                ]);
                break;

            case 'withdraw_savings':
                $rules = array_merge($rules, [
                    'withdraw_saving_amount' => 'required|numeric',

                ]);
                break;

            case 'withdraw_deposit':
                $rules = array_merge($rules, [
                    'withdraw_deposit_amount' => 'required|numeric',

                ]);
                break;

            case 'unjoin_membership':
                $rules = array_merge($rules, [

                    'category' => 'required|in:normal,job_termination',
                ]);
                break;

            case 'benefit_from_disasters':
                $rules = array_merge($rules, [
                    'benefit_amount' => 'required|numeric',
                    'benefit_description' => 'required|string|max:1000',
                    'benefit_remarks' => 'nullable|string|max:1000',
                ]);
                break;

            default:
                break;
        }



        $validated = $request->validate($rules);
        $enquiryData = array_merge($validated, [
            'command_id' => auth()->user()->command_id,
            'branch_id' => auth()->user()->branch_id,
            'registered_by' => auth()->id(),
        ]);
     
        // Create the Enquiry
        $enquiry = Enquiry::create($enquiryData);

        

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            if (!$file->isValid()) {
                \Log::error('File upload error', ['errors' => $file->getError()]);
                return back()->withErrors('File upload failed! Please try again.');
            }

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'attachments';  // This should be relative to the public directory
            $fullPath = public_path($destinationPath);

            // Check if directory exists, if not, create it
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0777, true);
            }


// Move the file from temporary to permanent location
$file->move($fullPath, $filename);
$filePath= $destinationPath . '/' . $filename;  // Save this path to store in the database
$folio = new Folio([
    'file_path' => $filePath,
    'folioable_id' => $enquiry->id,
    'folioable_type' => 'App\Models\Enquiry',
   'file_id' => $request->file_id
]);
$folio->save();

        }






        $fileRecord = File::find($request->file_id);
        if (!$fileRecord) {
            return back()->withErrors('File record not found.');
        }

     
        if (!$enquiry) {
            return back()->withErrors('Failed to create the enquiry.');
        }




        if ($enquiry) {
            // Construct a custom message based on the type of enquiry
            $message = "Hello " . $validated['full_name'] . ", ";

            switch ($validated['type']) {
                case 'loan_application':
                    $message .= "Your loan application for Tsh " . number_format($validated['loan_amount']) . " has been received and is under review. For further information, please contact 0677 026301";
                    break;
                case 'refund':
                    $message .= "Your refund request for Tsh " . number_format( $validated['refund_amount']) . " has been submitted. For further information, please contact 0677 026301";
                    break;
                case 'share_enquiry':
                    $message .= "Your share enquiry for Tsh " . number_format( $validated['share_amount']) . " has been recorded. For further information, please contact 0677 026301";
                    break;
                case 'retirement':
                    $message .= "Your retirement application set for " . $validated['date_of_retirement'] . " has been processed. For further information, please contact 0677 026301";
                    break;
                case 'deduction_add':
                    $message .= "Your deduction adjustment from Tsh " . number_format( $validated['from_amount']) . " to " . number_format($validated['to_amount']) . " has been updated. For further information, please contact 0677 026301";
                    break;
                case 'withdraw_savings':
                    $message .= "Your request to withdraw savings amount Tsh " . number_format( $validated['withdraw_saving_amount']) . " has been noted. For further information, please contact 0677 026301";
                    break;
                case 'withdraw_deposit':
                    $message .= "Your request to withdraw a deposit of Tsh " . number_format( $validated['withdraw_deposit_amount']) . " has been received. For further information, please contact 0677 026301";
                    break;
                case 'unjoin_membership':
                    $message .= "Your membership cancellation request under " . $validated['category'] . " category has been received. For further information, please contact 0677 026301";
                    break;
                case 'benefit_from_disasters':
                    $message .= "Your disaster benefit claim for Tsh " . number_format( $validated['benefit_amount']) . " due to " . $validated['benefit_description'] . " is under review. For further information, please contact 0677 026301." ;
                    break;
                default:
                    $message .= "Your enquiry has been received. We will contact you shortly. For further information, please contact 0677 026301.";
                    break;
            }

            $phone = $validated['phone']; // Ensure 'phone' is the correct field name
            $this->sendEnquirySMS($phone, $message);
        }


 // Create a notification
 Notification::create([
    'type' => 'enquiry_registered',
    'message' => "A new enquiry for {$validated['full_name']} has been registered. For further information, please contact 0677 026301",
]);
        return redirect()->route('enquiries.index', ['type' => $request->input('type')])
                         ->with([
                            'message' => 'Enquiry submitted successfully!',
                            'alert-type' => 'success'
                        ]);
    }

    private function sendEnquirySMS($phone, $message)
    {
        $url = 'https://41.59.228.68:8082/api/v1/sendSMS';
        $apiKey = 'xYz123#';  // Use the non-encoded key as it worked in your script

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('POST', $url, [
                'verify' => false,  // Keep SSL verification disabled as in your working script
                'form_params' => [
                    'msisdn' => $phone,
                    'message' => $message,
                    'key' => $apiKey,
                ]
            ]);

            $responseBody = $response->getBody()->getContents();
            \Log::info("SMS sent response: " . $responseBody);
            return $responseBody;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            \Log::error("Failed to send SMS: " . $e->getMessage());
            return null;
        }
    }





    public function show(Enquiry $enquiry)
    {
        // Eager load additional data like 'region' and 'district'
        // $enquiry = Enquiry::with(['region', 'district', 'users','folios']) // assuming 'users' is also a related model you might be interested in
        //                    ->where('id', $enquiry->id)
        //                    ->firstOrFail();
        $enquiry->load(['region', 'district', 'users', 'folios']);
                           $users = User::all();
        return view('enquiries.show', compact('enquiry','users'));
    }


    // Show the form for editing the specified resource
    public function edit(Enquiry $enquiry)
    {
        return view('enquiries.edit', compact('enquiry'));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $rules = [
            'date_received' => 'required|date',
            'full_name' => 'required|string|max:255',
            'force_no' => 'required|string|max:255',
            'check_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'type' => 'required|in:loan_application,refund,share_enquiry,retirement,deduction_add,withdraw_savings,withdraw_deposit,unjoin_membership,benefit_from_disasters',
        ];

        // Add conditional rules based on the type
        switch ($request->input('type')) {
            case 'loan_application':
                $rules = array_merge($rules, [
                    'loan_type' => 'required|string|max:255',
                    'loan_amount' => 'required|numeric',
                    'loan_duration' => 'required|integer',
                    'loan_category' => 'required|string',
                ]);
                break;

            case 'refund':
                $rules = array_merge($rules, [
                    'refund_amount' => 'required|numeric',
                    'refund_duration' => 'required|integer',
                ]);
                break;

            case 'share_enquiry':
                $rules = array_merge($rules, [
                    'share_amount' => 'required|numeric',
                ]);
                break;

            case 'retirement':
                $rules = array_merge($rules, [
                    'date_of_retirement' => 'required|date',
                    'retirement_amount' => 'required|numeric',
                ]);
                break;

            case 'deduction_add':
                $rules = array_merge($rules, [
                    'from_amount' => 'required|numeric',
                    'to_amount' => 'required|numeric',
                ]);
                break;

            case 'withdraw_savings':
                $rules = array_merge($rules, [
                    'withdraw_saving_amount' => 'required|numeric',
                    'withdraw_saving_reason' => 'required|string|max:255',
                ]);
                break;

            case 'withdraw_deposit':
                $rules = array_merge($rules, [
                    'withdraw_deposit_amount' => 'required|numeric',
                    'withdraw_deposit_reason' => 'required|string|max:255',
                ]);
                break;

            case 'unjoin_membership':
                $rules = array_merge($rules, [
                    'unjoin_reason' => 'required|string|max:255',
                    'unjoin_category' => 'required|in:normal,job_termination',
                ]);
                break;

            case 'benefit_from_disasters':
                $rules = array_merge($rules, [
                    'benefit_amount' => 'required|numeric',
                    'benefit_description' => 'required|string|max:1000',
                    'benefit_remarks' => 'nullable|string|max:1000',
                ]);
                break;

            default:
                break;
        }

        // Validate the request
        $validated = $request->validate($rules);

        // Update the enquiry with validated data
        $enquiry->update($validated);

        // Redirect with success message
        return Redirect::route('enquiries.index')->with('success', 'Enquiry updated successfully!');
    }


    // Remove the specified resource from storage
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        return Redirect::back()->with('success', 'Enquiry deleted successfully!');
    }

    // Send SMS to the given phone number
    private function sendSMS($to, $message)
    {
        try {
            $apiKey = 'YOUR_API_KEY';
            $apiUrl = 'https://api.smsprovider.com/send';

            $response = Http::post($apiUrl, [
                'apiKey' => $apiKey,
                'to' => $to,
                'message' => $message
            ]);

            // Log the response from SMS provider
            Log::info('SMS sent: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Failed to send SMS: ' . $e->getMessage());
        }
    }



public function changeStatus(Request $request, Enquiry $enquiry)
{
    $action = $request->action;

    if ($action == 'approve') {
        $enquiry->approve();
        Notification::create([
            'type' => 'enquiry_approved',
            'message' => "Enquiry #{$enquiry->id} has been approved.",
        ]);
    } elseif ($action == 'reject') {
        $enquiry->reject();
        Notification::create([
            'type' => 'enquiry_rejected',
            'message' => "Enquiry #{$enquiry->id} has been rejected.",
        ]);
    } elseif ($action == 'assign') {
        $enquiry->assign();
        Notification::create([
            'type' => 'enquiry_assigned',
            'message' => "Enquiry #{$enquiry->id} has been assigned.",
        ]);
    }

    return redirect()->back()->with('status', 'Enquiry status updated');
}






public function assignUsersToEnquiry(Request $request, $enquiryId)
{
    $request->validate([
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id',
    ]);

    $enquiry = Enquiry::with('users')->findOrFail($enquiryId);

    if (!$this->validateUserRoles($request->user_ids, $enquiry->type)) {
        return back()->with([
            'message' => 'One or more users are not authorized to handle this type of enquiry.',
            'alert-type' => 'error'
        ]);
    }

    $currentUser = auth()->id();
    $syncData = [];
    foreach ($request->user_ids as $userId) {
        $syncData[$userId] = ['assigned_by' => $currentUser];
    }

    $enquiry->users()->sync($syncData);

    if ($enquiry->type === 'loan_application' && $enquiry->loan_category === 'salary_loan') {
        // $this->processSalaryLoan($enquiry);
        // $this->logLoanApplicationHistory($loanApplication, 'Assigned');
        $loanApplication = $this->processSalaryLoan($enquiry);  // Ensure this method returns the LoanApplication instance
        $this->logLoanApplicationHistory($loanApplication, 'Assigned');
    }

    $enquiry->update(['status' => 'assigned']);
    return back()->with([
        'message' => 'Users have been successfully assigned to the enquiry and any special processing has been completed.',
        'alert-type' => 'success'
    ]);
}

    private function validateUserRoles($userIds, $enquiryType)
{
    $requiredRole = $this->getRoleForEnquiryType($enquiryType);
    $users = User::whereIn('id', $userIds)->get();

    return $users->every(function ($user) use ($requiredRole) {
        return $user->hasRole($requiredRole); // Assuming you're using Spatie's Permission package
    });
}
private function getRoleForEnquiryType($enquiryType)
{
    $roleMap = [
        'loan_application' => 'loanofficer', // Only loan officers can process loan enquiries
        'refund' => 'accountant', // Accountants handle refunds and other financial transactions
        // Add other roles and enquiry types as needed
    ];

    return $roleMap[$enquiryType] ?? null;
}
private function processSalaryLoan($enquiry)
{
    $loanDetails = $this->calculateLoanableAmount($enquiry);

    return LoanApplication::updateOrCreate(
        ['enquiry_id' => $enquiry->id, 'user_id' => auth()->id()],
        $loanDetails
    );
}


    private function calculateLoanableAmount($enquiry)
    {
        $basicSalary = $enquiry->basic_salary;
        $allowances = [$enquiry->allowances];
        $takeHome = $enquiry->take_home;



        $numberOfMonths = 48; // You can set this dynamically if needed

$oneThirdSalary = $basicSalary / 3;
$totalAllowances = array_sum($allowances);
$loanableTakeHome = $takeHome - ($oneThirdSalary + $totalAllowances);
$annualInterestRate = 12;
$monthlyInterestRate = $annualInterestRate / 100 / 12;

$loanApplicable = ($loanableTakeHome * (pow(1 + $monthlyInterestRate, $numberOfMonths) - 1)) / ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfMonths));

// Corrected formula for monthly deduction
$monthlyDeduction = $loanApplicable * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfMonths)) / (pow(1 + $monthlyInterestRate, $numberOfMonths) - 1);

$totalLoanWithInterest = $monthlyDeduction * $numberOfMonths;
$totalInterest = $totalLoanWithInterest - $loanApplicable;
$processingFee = $loanApplicable * 0.0025;
$insurance = $loanApplicable * 0.01;
$disbursementAmount = $loanApplicable - ($processingFee + $insurance);

        return [
            'loan_amount' => $loanApplicable,
            'loan_duration' => $numberOfMonths,
            'interest_rate' => 12, // Annual percentage rate
            'monthly_deduction' => $monthlyDeduction,
            'total_loan_with_interest' => $totalLoanWithInterest,
            'total_interest' => $totalInterest,
            'processing_fee' => $processingFee,
            'insurance' => $insurance,
            'disbursement_amount' => $disbursementAmount,
            'status' => 'pending' // Assuming default status
        ];
    }


    private function logLoanApplicationHistory(LoanApplication $loanApplication, $action)
    {
        LoanApplicationHistory::create([
            'user_id' => auth()->id(),
            'loan_application_id' => $loanApplication->id,
            'loan_amount' => $loanApplication->loan_amount,
            'loan_duration' => $loanApplication->loan_duration,
            'monthly_deduction' => $loanApplication->monthly_deduction,
            'total_loan_with_interest' => $loanApplication->total_loan_with_interest,
            'total_interest' => $loanApplication->total_interest,
            'processing_fee' => $loanApplication->processing_fee,
            'insurance' => $loanApplication->insurance,
            'disbursement_amount' => $loanApplication->disbursement_amount,
            'action_taken' => $action,
        ]);
    }

public function unassignUserFromEnquiry($enquiryId, $userId)
{
    $enquiry = Enquiry::findOrFail($enquiryId);
    $enquiry->users()->detach($userId); // Remove specific user assignment

    return back()->with('success', 'User unassigned from enquiry successfully.');
}




public function myAssignedEnquiries()
{
    $userId = auth()->id();
    $enquiries = Enquiry::whereHas('assignedUsers', function ($query) use ($userId) {
        $query->where('users.id', $userId);
    })
    ->with(['loanApplication', 'payment', 'assignedUsers', 'region', 'district'])
    ->get();

    // Add a log here to check if loan applications are being loaded
    \Log::info('Enquiries with loan applications:', $enquiries->toArray());

    return view('enquiries.my_enquiries', compact('enquiries'));
}



}
