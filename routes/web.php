<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
//added
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
//end added
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\LoanTrendController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileSeriesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\DashboardTrendsController;
use App\Http\Controllers\MortgageCalculatorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

 

// Protected Routes
Route::middleware(['auth'])->group(function () {

    //----------------EXPORT TO EXCEL  STARTS  HERE-----------------------------
    Route::get('/loan-applications/export', [EnquiryController::class, 'exportLoanApplication'])->name('exportLoanApplication');
    Route::get('export-enquiries', [EnquiryController::class, 'exportMembershipChanges'])->name('exportEnquiriesUnjoinMembership');
    Route::get('export-condolences', [EnquiryController::class, 'exportCondolences'])->name('exportCondolences');
    Route::get('/deductions/export', [EnquiryController::class, 'export'])->name('deductions.export');
    Route::get('/refunds/export', [EnquiryController::class, 'exportRefund'])->name('exportRefund');
    Route::get('/residential-disasters/export', [EnquiryController::class, 'ResidentialDisasterExport'])->name('residential_disasters');
    Route::get('/retirements/export', [EnquiryController::class, 'exportRetirement'])->name('exportRetirement');
    Route::get('/shares/export', [EnquiryController::class, 'exportShare'])->name('exportShare');
    Route::get('/sickleave/export', [EnquiryController::class, 'exportSickLeave'])->name('exportSickLeave');
    Route::get('/withdrawal/export', [EnquiryController::class, 'WithdrawalExport'])->name('withdrawalExport');
    Route::get('/injury/export', [EnquiryController::class, 'InjuryExport'])->name('injuryExport');
    Route::get('/membership/export', [EnquiryController::class, 'JoinMembershipExport'])->name('membershipExport');
    //----------------EXPORT TO EXCEL  ENDS  HERE-----------------------------
    

    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    // Route::get('/enquiries/create', [EnquiryController::class, 'create'])->name('enquiries.create');
    Route::get('/enquiries/create/{check_number?}', [EnquiryController::class, 'create'])
    ->name('enquiries.create');

    Route::get('/enquiries/fetch-payroll/{check_number}', [EnquiryController::class, 'fetchPayroll']);

    Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
    Route::get('/enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::get('/enquiries/{enquiry}/edit', [EnquiryController::class, 'edit'])->name('enquiries.edit');
    Route::put('/enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');
    Route::delete('/enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');


    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //Route::resource('users', UserController::class);




Route::get('enquiries/{enquiry}/responses/create', [ResponseController::class, 'create'])->name('responses.create');
Route::post('enquiries/{enquiry}/responses', [ResponseController::class, 'store'])->name('responses.store');
Route::post('/enquiries/{enquiry}/change-status', [EnquiryController::class, 'changeStatus'])->name('enquiries.changeStatus');

Route::post('/notifications/{notification}/read', [NotificationController::class, 'markNotificationAsRead'])->name('notifications.read');



Route::get('members/{member}/details', [MemberController::class, 'showDetails'] )->name('members.details');
Route::post('/members/{member}/status/{status}', [MemberController::class, 'updateStatus'] )->name('members.updateStatus');




Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('users', UserController::class);







Route::post('/calculate-loan/{loanApplicationId}', [LoanController::class, 'calculateLoan'])->name('calculate.loan');;

    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/create', [EnquiryController::class, 'create'])->name('enquiries.create');
    Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
    Route::get('/enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::get('/enquiries/{enquiry}/edit', [EnquiryController::class, 'edit'])->name('enquiries.edit');
    Route::put('/enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');
    Route::delete('/enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
    Route::post('enquiries/{enquiry}/change-status', [EnquiryController::class, 'changeStatus'])->name('enquiries.changeStatus');
    Route::get('members/{member}/details', [MemberController::class, 'showDetails'])->name('members.details');
    Route::post('/enquiries/{enquiry}/assign', [EnquiryController::class, 'assignUsersToEnquiry'])->name('enquiries.assign');







    Route::get('/my-enquiries', [EnquiryController::class,'myAssignedEnquiries'])->name('enquiries.my');
Route::get('/enquiries/{enquiry}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/enquiries/{enquiry}/payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::post('/payment/pay/{paymentId}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payments/{paymentId}/timeline', [PaymentController::class, 'showTimeline'])->name('payments.timeline');
    Route::post('/payment/reject/{paymentId}',[PaymentController::class, 'reject'] )->name('payment.reject');



Route::post('/send-otp-approve/{paymentId}', [PaymentController::class, 'sendOtpApprove'])->name('send.otp.approve');
Route::post('/verify-otp-approve/{paymentId}', [PaymentController::class, 'verifyOtpApprove'])->name('verify.otp.approve');

Route::post('/send-otp-pay/{paymentId}', [PaymentController::class, 'sendOtpPay'])->name('send.otp.pay');
Route::post('/verify-otp-pay/{paymentId}', [PaymentController::class, 'verifyOtpPay'])->name('verify.otp.pay');
Route::get('/payments/type/{type}', [PaymentController::class, 'showByType'])->name('payments.type');

Route::post('/payment/initiate/{enquiryId}', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('/payment/approve/{paymentId}', [PaymentController::class, 'approve'])->name('payment.approve');
Route::post('/payment/pay/{paymentId}',[PaymentController::class, 'pay'] )->name('payment.pay');



Route::post('/payment/reject/{paymentId}',[PaymentController::class, 'reject'] )->name('payment.reject');



Route::post('/send-otp-approve/{paymentId}', [PaymentController::class, 'sendOtpApprove'])->name('send.otp.approve');
Route::post('/verify-otp-approve/{paymentId}', [PaymentController::class, 'verifyOtpApprove'])->name('verify.otp.approve');

Route::post('/send-otp-pay/{paymentId}', [PaymentController::class, 'sendOtpPay'])->name('send.otp.pay');
Route::post('/verify-otp-pay/{paymentId}', [PaymentController::class, 'verifyOtpPay'])->name('verify.otp.pay');





    Route::get('loans/{member}/amortization-form', [LoanController::class, 'showAmortizationForm'])->name('loans.amortizationForm');
    Route::post('loans/{member}/amortization', [LoanController::class, 'calculateAmortization'])->name('loans.calculate');
    Route::post('/payment/pay/{paymentId}', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::post('/loans/{loanApplication}/process', [LoanController::class, 'process'])->name('loans.process');
Route::post('/loans/{loanApplication}/approve', [LoanController::class, 'approve'])->name('loans.approve');
Route::post('/loans/{loanApplication}/reject', [LoanController::class, 'reject'])->name('loans.reject');
Route::post('/loans/{loanApplication}/send-otp-approve-loan', [LoanController::class, 'sendOtpApproveLoan'])->name('loans.send-otp-approve');
Route::post('/loans/{loanApplication}/verify-otp-approve-loan', [LoanController::class, 'verifyOtpApproveLoan'])->name('loans.verify-otp-approve');
Route::get('/mortgage-form', [MortgageCalculatorController::class, 'showForm'])->name('mortgage.form');


Route::post('/calculate-loanable-amount', [MortgageCalculatorController::class, 'calculateLoanableAmount'])->name('calculate.loanable.amount');

Route::post('upload-data', [MemberController::class, 'store'])->name('members.store');

Route::get('processed-loans', [MemberController::class, 'showProcessedLoans'])->name('members.processedLoans');
Route::get('upload-form', [MemberController::class, 'showUploadForm'])->name('members.uploadForm');

Route::get('loans/{member}/amortization-form', [LoanController::class, 'showAmortizationForm'])->name('loans.amortizationForm');
Route::post('loans/{member}/amortization', [LoanController::class, 'calculateAmortization'])->name('loans.calculate');



 


    Route::get('/trends', [DashboardTrendsController::class, 'index'])->name('trends');
    Route::get('/loan_trends', [LoanTrendController::class, 'index'])->name('loan_trends');
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
Route::get('/branches/create', [BranchController::class, 'create'])->name('branches.create');
Route::post('/branches', [BranchController::class, 'store'])->name('branches.store'); // Ensure this line is correct
Route::get('/branches/{branch}', [BranchController::class, 'show'])->name('branches.show');
Route::get('/branches/{branch}/edit', [BranchController::class, 'edit'])->name('branches.edit');
Route::put('/branches/{branch}', [BranchController::class, 'update'])->name('branches.update');
Route::delete('/branches/{branch}', [BranchController::class, 'destroy'])->name('branches.destroy');
Route::resource('departments', DepartmentController::class);
Route::resource('representatives', RepresentativeController::class);
Route::get('/trends', [DashboardTrendsController::class, 'index'])->name('trends');
    Route::get('/loan_trends', [LoanTrendController::class, 'index'])->name('loan_trends');

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');

Route::get('/payroll/upload', [PayrollController::class, 'showUploadForm'])->name('payroll.showUpload');
Route::post('/payroll/upload', [PayrollController::class, 'uploadExcel'])->name('payroll.upload');
Route::resource('files', FileController::class);
Route::resource('file_series', FileSeriesController::class);
Route::resource('keywords', KeywordController::class);
Route::post('keywords/import', [KeywordController::class, 'import'])->name('keywords.import');
Route::get('keywords/import/show', [KeywordController::class, 'showImportForm'])->name('keywords.showImportForm');

});


Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::post('/otp-confirm', [AuthenticatedSessionController::class, 'confirmOTP'])->name('otp.confirm');

Route::get('/otp-verify', function () {
    return view('auth.otp-verify');
})->name('otp.verify');



use App\Http\Controllers\RankController;

Route::get('/ranks/create', [RankController::class, 'create'])->name('ranks.create');
Route::post('/ranks', [RankController::class, 'store'])->name('ranks.store');
Route::get('/ranks/{id}/edit', [RankController::class, 'edit']);
Route::put('/ranks/{id}', [RankController::class, 'update']);
Route::delete('/ranks/{id}', [RankController::class, 'destroy']);



 

 

// Route for viewing and editing profile
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth')->name('profile');

// Route for updating profile (e.g., password change)
Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->middleware('auth')->name('profile.update-password');

// routes/web.php

use App\Http\Controllers\CommandController;

Route::resource('commands', CommandController::class);



require __DIR__.'/auth.php';
