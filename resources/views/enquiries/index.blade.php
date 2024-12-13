
@extends('layouts.app')
@section('content')
<!-- Add hover effects for buttons -->
<style>
    .btn:hover {
        background-color: #007bff; /* Change the background color on hover */
        color: #fff; /* Change text color on hover */
        transform: scale(1.05); /* Slightly increase the button size */
        transition: transform 0.3s ease, background-color 0.3s ease; /* Smooth hover effect */
    }

    .btn.disabled, .btn:disabled {
        background-color: #6c757d; /* Gray background when disabled */
        color: #fff; /* White text when disabled */
    }
</style>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0"> Enquiries</h6>
    <ul class="d-flex align-items-center gap-2">
      <li class="fw-medium">
        <a href="{{ route('enquiries.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
          <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
          all Enquiries
        </a>
      </li>
      <li>-</li>
      <li class="fw-medium">{{ $type ? ucfirst(str_replace('_', ' ', $type)) . ' Enquiries' : 'All Enquiries' }}</li>
    </ul>
  </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card basic-data-table">
    <div class="card-header d-flex justify-content-between align-items-center">
    <!-- Left add record button -->
    <h5 class="card-title mb-0">
        <a href="{{ route('enquiries.create', ['type' => $type ?? null]) }}" class="btn btn-primary radius-30 mt-2 mt-lg-0 d-flex align-items-center gap-2">
            <span>Add {{ $type ? ucfirst(str_replace('_', ' ', $type)) : 'Enquiry' }}</span>
            <iconify-icon icon="mingcute:add-circle-fill" class="text-xl"></iconify-icon>
        </a>
    </h5>

    {{-- EXPORT ALL OLD
    <!-- Right export record to CSV button -->
  <h5 class="card-title mb-0">
    <a href="{{ 
            match($type) {
                'loan_application' => route('exportLoanApplication'),
                'refund' => route('exportRefund'),
                'share_enquiry' => route('exportShare'),
                'retirement' => route('exportRetirement'),
                'deduction_add' => route('deductions.export'),
                'withdraw_savings' => route('withdrawalExport'),
                'withdraw_deposit' => route('withdrawalExport'),
                'unjoin_membership' => route('exportEnquiriesUnjoinMembership'),
                'benefit_from_disasters' => route('residential_disasters'),
                default => '#',  // Default to a fallback route or current page if no match
            }
        }}" 
        id="export-btn" 
        class="btn btn-primary radius-30 mt-2 mt-lg-0 d-flex align-items-center gap-2" 
        onclick="startExport()">
        <span id="export-text">Export {{ $type ? ucfirst(str_replace('_', ' ', $type)) : 'CSV' }}</span>
        <iconify-icon icon="mdi:file-excel" class="text-xl mr-4"></iconify-icon>
    </a>
</h5>
--}}

<h5 class="card-title mb-0">
    <form method="GET" 
          action="{{ 
              match($type) {
                  'loan_application' => route('exportLoanApplication'),
                  'refund' => route('exportRefund'),
                  'share_enquiry' => route('exportShare'),
                  'retirement' => route('exportRetirement'),
                  'deduction_add' => route('deductions.export'),
                  'withdraw_savings' => route('withdrawalExport'),
                  'withdraw_deposit' => route('withdrawalExport'),
                  'unjoin_membership' => route('exportEnquiriesUnjoinMembership'),
                  'benefit_from_disasters' => route('residential_disasters'),
                  'sick_for_30_days' => route('exportSickLeave'),
                  'condolences' => route('exportCondolences'),
                  'injured_at_work' => route('injuryExport'),
                  'join_membership' => route('membershipExport'),
                  default => '#',  // Default to a fallback route or current page if no match
              }
          }}" 
          id="export-form">
        <div class="row">
            <div class="col-md-3">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="frequency">Frequency</label>
                <select name="frequency" id="frequency" class="form-control">
                    <option value="">Select Frequency</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="half_year_1_6">Half Year (1-6 months)</option>
                    <option value="half_year_6_12">Half Year (6-12 months)</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary w-100">
                    Export 
                    {{ 
                        match($type) {
                            'loan_application' => 'Loan Application',
                            'refund' => 'Refund',
                            'share_enquiry' => 'Share Enquiry',
                            'retirement' => 'Retirement',
                            'deduction_add' => 'Deductions',
                            'withdraw_savings' => 'Withdraw Savings',
                            'withdraw_deposit' => 'Withdraw Deposit',
                            'unjoin_membership' => 'Unjoin Membership',
                            'benefit_from_disasters' => 'Benefit from Disasters',
                            'sick_for_30_days' => 'Sick Leave',
                            'condolences' => 'condolences',
                            'injured_at_work' => 'injury',
                            'join_membership' => 'New Membership',
                            

                            default => 'Data'
                        }
                    }}
                </button>
            </div>
        </div>
    </form>
</h5>


</div>
<div class="card-body">
<div class="table-responsive">
        <table class="table border-primary-table mb-0 mt-4 w-100" id="dataTable" data-page-length='10'>
          <thead>

                                <tr>
                                <th scope="col"> S/N</th>
                                <th scope="col">Date Received</th>
                                <th scope="col">Check Number</th>
                                <th scope="col">Full Name</th>
                                 <th scope="col">Account Number</th>
                                <th scope="col">Bank Name</th>
                                <th scope="col">Region</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Status</th>
                               {{-- <th scope="col">Assigned User</th>--}}
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enquiries as $enquiry)
                            <tr>
                                <!-- Serial Number -->
                                <td><div class=" d-flex align-items-center">

                                    {{ $loop->iteration }}
                                </div></td>

                                <!-- Existing Columns -->
                                <td><div class="d-flex align-items-center">{{ $enquiry->date_received }}</div></td>
                                <td><div class="d-flex align-items-center   text-primary-600">{{ $enquiry->check_number }}</div></td>
                                <td><div class="d-flex align-items-center text-lowercase">{{ucwords($enquiry->full_name) }}</div></td>
                                <td><div class="d-flex align-items-center">{{$enquiry->account_number }}</div></td>
                                <td><div class="d-flex align-items-center text-uppercase">{{ $enquiry->bank_name }}</div></td>
                                <td><div class="d-flex align-items-center">{{ ucwords($enquiry->region->name ?? 'No Region')}}</div></td>
                                 <td><div class="d-flex align-items-center">{{ $enquiry->phone }}</div></td>
                                <td>
                                    <span class="badge bg-{{ $enquiry->status == 'approved' ? 'success' : ($enquiry->status == 'rejected' ? 'danger' : ($enquiry->status == 'assigned' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($enquiry->status) }}
                                    </span>
                                </td>
                                {{--
                                <td>
                @if($enquiry->assignedUsers->isNotEmpty())
                 {{ $enquiry->assignedUsers->pluck('name')->join(', ') }}
                @else
                    Not Assigned
                @endif
            </td>
            --}}
           
                                <td>
                                    <div class="dropdown ms-auto">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                            <i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- View Action -->
                                            <li><a class="dropdown-item" href="{{ route('enquiries.show', $enquiry->id) }}"><i class="mdi mdi-eye me-2"></i>View Detail</a></li>
                                            <li><hr class="dropdown-divider"></li>

                                            <!-- Assign Action (triggers modal) -->
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignUserModal-{{ $enquiry->id }}"><i class="mdi mdi-account-arrow-right me-2"></i>Assign</a></li>
                                            <li><hr class="dropdown-divider"></li>

                                            <!-- Edit Action -->
                                            <li><a class="dropdown-item" href="{{ route('enquiries.edit', $enquiry->id) }}"><i class="mdi mdi-pencil me-2"></i>Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>

                                            <!-- Delete Action -->
                                            <li>
                                                <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="mdi mdi-delete me-2"></i>Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table></div>
                </div>
            </div> <!-- Fixed the stray '<' here -->


    <!-- Modals for each enquiry to assign users -->
    @foreach($enquiries as $enquiry)
        @include('modals.assign_enquries')
    @endforeach

    <script>
    function startExport() {
        const exportText = document.getElementById('export-text');
        const exportBtn = document.getElementById('export-btn');
        
        // Change button text to 'Exporting...' and disable the button
        exportText.textContent = 'Exporting...'; // Set text to 'Exporting'
        exportBtn.classList.add('disabled'); // Add 'disabled' class to button
        exportBtn.setAttribute('disabled', true); // Disable the button

        // Simulate export process with a timeout (Replace with actual export logic)
        setTimeout(function() {
            // After export is finished, revert the button text and enable the button
            exportText.textContent = 'Export {{ $type ? ucfirst(str_replace('_', ' ', $type)) : 'Enquiry' }}'; // Revert to original text
            exportBtn.classList.remove('disabled'); // Remove 'disabled' class from button
            exportBtn.removeAttribute('disabled'); // Enable the button
        }, 3000); // Assume the export takes 3 seconds, adjust accordingly
    }
</script>
@endsection
